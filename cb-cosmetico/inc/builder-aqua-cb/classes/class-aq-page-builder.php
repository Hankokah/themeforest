<?php
/**
 * AQ_Page_Builder class
 *
 * The core class that generates the functionalities for the
 * Aqua Page Builder. Almost nothing inside in the class should
 * be overridden by theme authors
 *
 * @since forever
 **/
 /*
function array_str_replace( $sSearch, $sReplace, &$aSubject ) {

	foreach( $aSubject as $sKey => $uknValue ) {
		if( is_array($uknValue) ) {
			array_str_replace( $sSearch, $sReplace, $aSubject[$sKey] );
		} else {
			$aSubject[$sKey] = str_replace( $sSearch, $sReplace, $uknValue );
		}
	}

}
*/
if(!class_exists('AQ_Page_Builder')) {
	class AQ_Page_Builder {

		public $url = AQPB_DIR;
		public $config = array();
		private $admin_notices;

		/**
		 * Stores public queryable vars
		 */
		function __construct( $config = array()) {
				
			$defaults['menu_title'] = __('Page Builder', 'framework');
			$defaults['page_title'] = __('Page Builder', 'framework');
			$defaults['page_slug'] = __('aq-page-builder', 'framework');
			$defaults['debug'] = false;
				
			$this->args = wp_parse_args($config, $defaults);
				
			$this->args['page_url'] = esc_url(add_query_arg(
			array('page' => $this->args['page_slug']),
			admin_url( 'themes.php' )
			));
				
		}

		/**
		 * Initialise Page Builder page and its settings
		 *
		 * @since 1.0.0
		 */
		function init() {

			//add_action('admin_menu', array(&$this, 'admin_pages'));
			add_action('init', array(&$this, 'register_template_post_type'));
			add_action('init', array(&$this, 'add_shortcode'));
			add_action('template_redirect', array(&$this, 'preview_template'));
			add_filter('contextual_help', array(&$this, 'contextual_help'));
			if(!is_admin()) add_action('init', array(&$this, 'view_enqueue'));
			add_action('admin_bar_menu', array(&$this, 'add_admin_bar'), 1000);

			/** TinyMCE button */
			//add_filter('media_buttons_context', array(&$this, 'add_media_button') );
			add_filter('media_buttons_context', array(&$this, 'add_icon_button') );
			//add_action('admin_footer', array(&$this, 'add_media_display') );
			add_action('admin_footer', array(&$this, 'add_icon_display') );
				
		}

		/**
		 * Create Admin Pages
		 *
		 * @since 1.0.0
		 */
		function admin_pages() {

			$this->page = add_theme_page( $this->args['page_title'], $this->args['menu_title'], 'manage_options', $this->args['page_slug'], array(&$this, 'builder_page_show'));
			add_action('admin_print_styles-'.$this->page, array(&$this, 'admin_enqueue'));

		}
			
		/**
		 * Add shortcut to Admin Bar menu
		 *
		 * @since 1.0.4
		 */
		function add_admin_bar(){
			//global $wp_admin_bar;
			//$wp_admin_bar->add_menu( array( 'id' => 'aq-page-builder', 'parent' => 'appearance', 'title' => 'Page Builder', 'href' => admin_url('themes.php?page='.$this->args['page_slug']) ) );
				
		}

		/**
		 * Register and enqueueu styles/scripts
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function admin_enqueue() {
			// Register 'em
			wp_register_style( 'aqpb-css', $this->url.'assets/css/aqpb.css', array(), time(), 'all');
			wp_register_style( 'aqpb-blocks-css', $this->url.'assets/css/aqpb_blocks.css', array(), time(), 'all');
			wp_register_script('aqpb-js', $this->url . 'assets/js/aqpb.js', array('jquery'), time(), true);
			wp_register_script('aqpb-fields-js', $this->url . 'assets/js/aqpb-fields.js', array('jquery'), time(), true);
				
			// Enqueue 'em
			wp_enqueue_style('aqpb-css');
			wp_enqueue_style('aqpb-blocks-css');
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-resizable');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('iris');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('aqpb-js');
			wp_enqueue_script('aqpb-fields-js');
			wp_enqueue_script('jquery-ui-spinner');
			// Media library uploader
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_style('jui', get_template_directory_uri('template_directory').'/inc/css/jquery-ui.css', false, '1.0', 'screen');
			wp_enqueue_script('media-upload');
			wp_enqueue_media();
				
			// Hook to register custom style/scripts
			do_action('aq-page-builder-admin-enqueue');
				
		}

		/**
		 * Register and enqueueu styles/scripts on front-end
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function view_enqueue() {
				
			// front-end css
			wp_register_style( 'aqpb-view-css', $this->url.'assets/css/aqpb-view.css', array(), time(), 'all');
			wp_enqueue_style('aqpb-view-css');

			// front-end js
			wp_register_script('aqpb-view-js', $this->url . 'assets/js/aqpb-view.js', array('jquery'), time(), true);
			wp_enqueue_script('aqpb-view-js');
				
			//hook to register custom styles/scripts
			do_action('aq-page-builder-view-enqueue');
				
		}

		/**
		 * Register template post type
		 *
		 * @uses register_post_type
		 * @since 1.0.0
		 */
		function register_template_post_type() {

			if(!post_type_exists('template')) {
					
				$template_args = array(
					'labels' => array(
						'name' => 'Templates',
				),
					'public' => false,
					'show_ui' => false,
					'capability_type' => 'page',
					'hierarchical' => false,
					'rewrite' => false,
					'supports' => array( 'title', 'editor' ), 
					'query_var' => false,
					'can_export' => true,
					'show_in_nav_menus' => false
				);

				if($this->args['debug'] == true && WP_DEBUG == true) {
					$template_args['public'] = true;
					$template_args['show_ui'] = true;
				}

				register_post_type( 'template', $template_args);

			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Aqua Page Builder notice: </strong>'. __('The \"template\" post type already exists, possibly added by the theme or other plugins. Please consult with theme author to consult with this issue', 'framework') .'</p></div>';"));
			}
				
		}

		/**
		 * Checks if template with given id exists
		 *
		 * @since 1.0.0
		 */
		function is_template($template_id) {

			$template = get_post($template_id);
				
			if($template) {
				if($template->post_type != 'template' || $template->post_status != 'publish') return false;
			} else {
				return false;
			}
				
			return true;
				
		}

		/**
		 * Retrieve all blocks from template id
		 *
		 * @return	array - $blocks
		 * @since	1.0.0
		 */
		function get_blocks($template_id) {

			//verify template
			if(!$template_id) return;
			if(!$this->is_template($template_id)) return;
				
			//filter post meta to get only blocks data
			$blocks = array();
			$all = get_post_custom($template_id);
			foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_') {
					$block_instance = get_post_meta($template_id, $key, true);
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}
				
			//sort by order
			$sort = array();
			foreach($blocks as $block) {
				$sort[] = $block['order'];
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
				
			return $blocks;
				
		}

		/**
		 * Display blocks archive
		 *
		 * @since	1.0.0
		 */
		function blocks_archive() {

			global $aq_registered_blocks;
			foreach($aq_registered_blocks as $block) {
				$block->form_callback();
			}
				
		}

		/**
		 * Display template blocks
		 *
		 * @since	1.0.0
		 */

		function display_blocks( $template_id , $cb5_blocks = 'true') {

			if ($cb5_blocks == 'true'){

				//verify template
				if(!$template_id) return;
				if(!$this->is_template($template_id)) return;
					
				$blocks = $this->get_blocks($template_id);
			}else{

				if(isset($cb5_blocks[0])) $blocks = $cb5_blocks[0]; else $blocks=array();
			}
			$blocks = is_array($blocks) ? $blocks : array();
			
			array_str_replace(";cbsp#21;","\r\n",$blocks);
			array_str_replace(";cbsp#21&;","\r\n",$blocks);
			//print_r($blocks);
			//return early if no blocks
			if(empty($blocks)) {
				echo '<p class="empty-template">';
				echo __('Drag block items from the left into this area to begin building your template.', 'framework');
				echo '</p>';
				return;

			} else {
				
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					extract($instance);

					//echo $id_base;
					if(isset($aq_registered_blocks[$id_base])) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];

						//insert template_id into $instance
						$instance['template_id'] = $template_id;

						//display the block
						if($parent == 0) {
							$block->form_callback($instance);
						}
						}
				}

			}
				
		}

		/**
		 * Get all saved templates
		 *
		 * @since	1.0.0
		 */
		function get_templates() {

			$args = array (
				'nopaging' => true,
				'post_type' => 'template',
				'status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC',
			);
				
			$templates = get_posts($args);
				
			return $templates;
				
		}

		/**
		 * Creates a new template
		 *
		 * @since	1.0.0
		 */
		function create_template($title,$blocks,$post_id) {
		 global $cb5_builder;
			//wp security layer
			//check_admin_referer( 'create-template', 'create-template-nonce' );

			//create new template only if title don't yet exist
			// Autosave, do nothing
		 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		 return;
		 // AJAX? Not used here
		 if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		 return;
		 // Check user permissions
		 if ( ! current_user_can( 'edit_post', $post_id ) )
		 return;
		 // Return if it's a post revision
		 if ( false !== wp_is_post_revision( $post_id ) )
		 return;
		 $template_id='';
			if(!get_page_by_title( $title, 'OBJECT', 'template' )) {
				//set up template name
				$template = array(
					'post_title' => wp_strip_all_tags($title),
					'post_type' => 'template',
					'post_status' => 'publish'
					);
					//create the template
					$template_id = wp_insert_post($template);
					$cb5_builder->update_template($template_id, $blocks, $title);
					update_post_meta($post_id,'cb5_builder',$template_id);

			} else {
			}
			//return the new id of the template
			return $template_id;
				
		}

		/**
		 * Function to update templates
		 *
		 * @since	1.0.0
		 **/
		function update_template($template_id, $blocks, $title) {
				
			//update the title
			$template = array('ID' => $template_id, 'post_title'=> $title);
				
			if ( ! wp_is_post_revision( $template_id ) ){
				remove_action('save_post', 'cbb_save_postdata');
				wp_update_post( $template );
				add_action('save_post', 'cbb_save_postdata');
			}
			//now let's save our blocks & prepare haystack
			$blocks = is_array($blocks) ? $blocks : array();
			$haystack = array();
			$template_transient_data = array();
			$i = 1;
				
			foreach ($blocks as $new_instance) {
				global $aq_registered_blocks;

				$old_key = isset($new_instance['number']) ? 'aq_block_' . $new_instance['number'] : 'aq_block_0';
				$new_key = isset($new_instance['number']) ? 'aq_block_' . $i : 'aq_block_0';

				$old_instance = get_post_meta($template_id, $old_key, true);

				extract($new_instance);

				if(class_exists($id_base)) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];
						
					//insert template_id into $instance
					$new_instance['template_id'] = $template_id;
						
					//sanitize instance with AQ_Block::update()
					$new_instance = $block->update($new_instance, $old_instance);
				}

				//update block
				update_post_meta($template_id, $new_key, $new_instance);

				//store instance into $template_transient_data
				$template_transient_data[$new_key] = $new_instance;

				//prepare haystack
				$haystack[] = $new_key;

				$i++;
			}
				
			//update transient
			$template_transient = 'aq_template_' . $template_id;
			set_transient( $template_transient, $template_transient_data );
				
			//use haystack to check for deleted blocks
			$curr_blocks = $this->get_blocks($template_id);
			$curr_blocks = is_array($curr_blocks) ? $curr_blocks : array();
			foreach($curr_blocks as $key => $block){
				if(!in_array($key, $haystack))
				delete_post_meta($template_id, $key);
			}
				
		}

		function delete_template($template_id) {
				
			//first let's check if template id is valid
			if(!$this->is_template($template_id)) return false;
				
			//wp security layer
			//check_admin_referer( 'delete-template', '_wpnonce' );
				
			//delete template, hard!
			wp_delete_post( $template_id, true );
				
			//delete template transient
			$template_transient = 'aq_template_' . $template_id;
			delete_transient( $template_transient );
				
		}

		/**
		 * Preview template
		 *
		 * Theme authors should attempt to make the preview
		 * layout to be consistent with their themes by using
		 * the filter provided in the function
		 *
		 * @since	1.0.0
		 */
		function preview_template() {

			global $wp_query, $aq_page_builder;
			$post_type = $wp_query->query_vars['post_type'];
				
			if($post_type == 'template') {
				get_header();
				?>
<div id="main" class="cf">
	<div id="content" class="cf">
	<?php $this->display_template(get_the_ID()); ?>
	<?php if($this->args['debug'] == true) print_r(aq_get_blocks(get_the_ID())) //for debugging ?>
	</div>
</div>
	<?php
	get_footer();
	exit;
			}
				
		}

		/**
		 * Display the template on the front end
		 *
		 * @since	1.0.0
		 **/
		function display_template($template_id) {

			//verify template
			if(!$template_id) return;
			if(!$this->is_template($template_id)) return;
				
			//get transient if available
			$template_transient = 'aq_template_' . $template_id;
			$template_transient_data = get_transient($template_transient);
				
			if($template_transient_data == false) {
				$blocks = $this->get_blocks($template_id);
			} else {
				$blocks = $template_transient_data;
			}
				
			$blocks = is_array($blocks) ? $blocks : array();
				
			//return early if no blocks
			if(empty($blocks)) {
					
				echo '<p class="empty-template">';
				echo __('This template is empty', 'framework');
				echo '</p>';

			} else {
				//template wrapper
				echo '<div id="aq-template-wrapper-'.$template_id.'" class="aq-template-wrapper aq_row">';

				$overgrid = 0; $span = 0; $first = false;

				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					extract($instance);
						
					if(class_exists($id_base)) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];

						//insert template_id into $instance
						$instance['template_id'] = $template_id;

						//display the block
						if($parent == 0) {
								
							$col_size = absint(preg_replace("/[^0-9]/", '', $size));
								
							$overgrid = $span + $col_size;
								
							if($overgrid > 12 || $span == 12 || $span == 0) {
								$span = 0;
								$first = true;
							}
								
							if($first == true) {
								$instance['first'] = true;
							}
								
							$block->block_callback($instance);
								
							$span = $span + $col_size;
								
							$overgrid = 0; //reset $overgrid
							$first = false; //reset $first
						}
					}
				}

				//close template wrapper
				echo '</div>';
			}
				
		}

		/**
		 * Add the [template] shortcode
		 *
		 * @since 1.0.0
		 */
		function add_shortcode() {

			global $shortcode_tags;
			if ( !array_key_exists( 'template', $shortcode_tags ) ) {
				add_shortcode( 'template', array(&$this, 'do_shortcode') );
			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Aqua Page Builder notice: </strong>'. __('The \"[template]\" shortcode already exists, possibly added by the theme or other plugins. Please consult with the theme author to consult with this issue', 'framework') .'</p></div>';"));
			}
				
		}

		/**
		 * Shortcode function
		 *
		 * @since 1.0.0
		 */
		function do_shortcode($atts, $content = null) {

			$defaults = array('id' => 0);
			extract( shortcode_atts( $defaults, $atts ) );
				
			//capture template output into string
			ob_start();
			$this->display_template($id);
			$template = ob_get_contents();
			ob_end_clean();
				
			return $template;
				
		}


		/**
		 * Media button shortcode
		 *
		 * @since 1.0.6
		 */
		function add_media_button( $button ) {

			global $pagenow, $wp_version;

			$output = '';

			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {

				if ( version_compare( $wp_version, '3.5', '<' ) ) {
					$img 	= '<img src="' . AQPB_DIR . '/assets/images/aqua-media-button.png" width="16px" height="16px" alt="' . esc_attr__( 'Add Page Template', 'framework' )  . '" />';
					$output = '<a href="#TB_inline?width=640&inlineId=aqpb-iframe-container" class="thickbox" title="' . esc_attr__( 'Add Page Template', 'framework' )  . '">' . $img . '</a>';
				} else {
					$img 	= '<span class="wp-media-buttons-icon" style="background-image: url(' . AQPB_DIR . '/assets/images/aqua-media-button.png ); margin-top: -1px;"></span>';
					$output = '<a href="#TB_inline?width=640&inlineId=aqpb-iframe-container" class="thickbox button" title="' . esc_attr__( 'Add Page Template', 'framework' ) . '" style="padding-left: .4em;">' . $img . ' ' . esc_attr__( 'Add Template', 'framework' ) . '</a>';
				}

			}

			return $button . $output;

		}		function add_icon_button( $button ) {

			global $pagenow, $wp_version;

			$output = '';

			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {

				if ( version_compare( $wp_version, '3.5', '<' ) ) {
					$img 	= '<img src="' . AQPB_DIR . '/assets/images/aqua-media-button.png" width="16px" height="16px" alt="' . esc_attr__( 'Add Icon', 'framework' )  . '" />';
					$output = '<a href="#TB_inline?width=640&inlineId=cb-icon-box-iframe-container" onclick="load_icon();" class="thickbox" title="' . esc_attr__( 'Add Icon', 'framework' )  . '" >' . $img . '</a>';
				} else {
					$img 	= '<span class="wp-media-buttons-icon" style="background-image: url(' . AQPB_DIR . '/assets/images/aqua-media-button.png ); margin-top: -1px;"></span>';
					$output = '<a href="#TB_inline?width=640&inlineId=cb-icon-box-iframe-container" onclick="load_icon();" class="thickbox button" title="' . esc_attr__( 'Add Icon', 'framework' ) . '" style="padding-left: .4em;" ">' . $img . ' ' . esc_attr__( 'Add Icon', 'framework' ) . '</a>';
				}

			}

			return $button . $output;

		}
		function add_icon_display() {
			global $pagenow;

			/** Only run in post/page new and edit */
			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
				?>
<script type="text/javascript">
function rgb2hex(rgb) {
     if (  rgb.search("rgb") == -1 ) {
          return rgb;
     } else {
          rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
          function hex(x) {
               return ("0" + parseInt(x).toString(16)).slice(-2);
          }
          return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]); 
     }
}
function load_icon(id) {
"use strict";
		if(typeof id !== 'undefined') {
		jQuery('#selected-id-builder').val(id);
		jQuery('#cur_icon').html(jQuery('#'+id+'-val').val());
		var color = rgb2hex(jQuery('#cur_icon i').css('color'));
		var size = parseInt(jQuery('#cur_icon i').css('font-size'), 10);
		jQuery("#font-size").val(size);
		jQuery("#color").wpColorPicker('color', color);
		}else{
		jQuery('#selected-id-builder').val('');
		}
		
		
}
jQuery(document).ready(function($) {
"use strict";

jQuery('.sicon').each(function() {
	var sico=jQuery(this).html();
	if(sico.indexOf("res-icon") >= 0) jQuery(this).find('.remo').hide();
});

jQuery('.remo').click(function() { 
jQuery(this).parent().find('.res-icon').parent().html('');
jQuery(this).parent().find('.hide-icon').html('');
return false;
});

	jQuery('.the-icons li').click(function() { 
	var size = jQuery('#font-size').val();
	var color = jQuery('#color').val();
	
	var style='';
	var data ='';
	var icon_class = jQuery(this).find('i').attr('class');
	if(size) {style +='font-size:'+size+'px;';}
	if(color) {style +='color:'+color+';';}
	data = '<i class="'+icon_class+' builder-icon" style="'+style+'"></i>';
	jQuery('#cur_icon').html(data);

jQuery("#TB_ajaxContent").animate({
      scrollTop: "0px"
}, {
    duration: 800
});
	});
	
	jQuery('.newcolor').wpColorPicker({
	change:function(event, ui) {
            var selectedColor = ui.color.toString();
			jQuery('#cur_icon i').css("color",selectedColor);
        }
	}); 
	function set_icon_size(){
	var size = jQuery('#font-size').val();
	jQuery('#cur_icon i').css("font-size",size+"px");
	
	}
	jQuery("#font-size" ).spinner({
	min: 1,
	numberFormat: "C",
	change: set_icon_size,
    stop: set_icon_size
    });
	

});
function change(id){

wpActiveEditor=id;
			
}
function save_icon(){
	var sel_id = jQuery('#selected-id-builder').val();
	var data = jQuery('#cur_icon').html();
	if (sel_id===''){
	window.send_to_editor(data);
	}
	else{
	jQuery('#'+sel_id+'-val').html(data);
	jQuery('#'+sel_id).html('<span class="res-icon">'+data+'</span>&nbsp;&nbsp;&nbsp;');
	jQuery('.res-icon i').removeAttr( 'style' );
	tb_remove();
	}
			
}
function hide_skill_ops(sel,id){
if(sel.value=='horizontal')jQuery('#'+id+'_style_h').show();
else
jQuery('#'+id+'_style_h').hide();
}
</script>

<input
	type="hidden" class="my-color-picker" name="background_color" value="" />
<input
	type="text" class="my-color-picker" name="background_color" value="" />
</script>
<div id="cb-icon-box-iframe-container" style="display: none;">

	<div class="wrap" style="padding: 1em">

		<div id="icon_customise">
			<p class="description">
				<label for="font-size">Font size<br /> <input type="text"
					id="font-size" value="12"> </label>
			</p>
			<p class="description">
				<label for="color">Color<br /> <input id="color" type="text"
					value="#000" class="newcolor" autocomplete="off" style=""> </label>

			</p>
		</div>
		<div id="icon_prev">
			<div id="cur_icon"></div>
			<button onclick="save_icon();">save</button>
		</div>
		<div class="cl"></div>
		<input type="hidden" id="selected-id-builder">
		<?php
		require_once('icons.php');
		?>


	</div>
</div>
		<?php
			}}
			/**
			 * Media button display
			 *
			 * @since 1.0.6
			 */
			function add_media_display() {

				global $pagenow;

				/** Only run in post/page new and edit */
				if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
					/** Get all published templates */
					$templates = get_posts( array(
					'post_type' 		=> 'template', 
					'posts_per_page'	=> -1,
					'post_status' 		=> 'publish',
					'order'				=> 'ASC',
					'orderby'			=> 'title'
					)
					);

					?>
<script type="text/javascript">
					function insertTemplate() {
						var id = jQuery( '#select-aqpb-template' ).val();

						/** Alert user if there is no template selected */
						if ( '' == id ) {
							alert("<?php echo esc_js( __( 'Please select your template first!', 'framework' ) ); ?>");
							return;
						}

						/** Send shortcode to editor */
						window.send_to_editor('[template id="' + id + '"]');
					}
<?php /*					
					function savetobox(){
					var id = jQuery( '#edited-text-box' ).val();
					jQuery('#'+id).val(jQuery( '#cb-aq-text-block' ).val());
					tb_remove();
					}
					function gettextbox(id){
					jQuery('#edited-text-box').val(id);
					jQuery( '#cb-aq-text-block' ).val(jQuery('#'+id).val());
					}

					function add_new_accordion(block_id){
					
		var n = (jQuery(".accordion_item_"+block_id).length)+1;
					
        jQuery('<div class="accordion_item_'+block_id+'"> <p class="description"><label for="">Title #'+n+'<br/><input type="text"  class="input-full" value="" name="aq_blocks['+block_id+'][title_acor][]"></label></p><p class="description"><label for="">Content #'+n+'<br/><textarea class="textarea-full" name="aq_blocks['+block_id+'][content_acor][]" rows="5"></textarea></label></p></div>').appendTo('.accordions_'+block_id);
    }
	function del_last_accordion(block_id){
		var n = jQuery(".accordion_item_"+block_id).length;
		if(n>1){
        jQuery('.accordion_item_'+block_id+':last').remove();
		}
    }

		*/?>		</script>

<div id="aqpb-iframe-container" style="display: none;">
	<div class="wrap" style="padding: 1em">

	<?php do_action( 'aqpb_before_iframe_display', $templates ); ?>

	<?php
	/** If there is no template created yet */
	if ( empty( $templates ) ) {
		//echo sprintf( __( 'You don\'t have any template yet. Let\'s %s create %s one!', 'framework' ), '', '</a>' );
		return;
	}
	?>

		<h3>
		<?php _e( 'Choose Your Page Template', 'framework' ); ?>
		</h3>
		<br /> <select id="select-aqpb-template"
			style="clear: both; min-width: 200px; display: inline-block; margin-right: 3em;">
			<?php
			foreach ( $templates as $template )
			echo '<option value="' . absint( $template->ID ) . '">' . esc_attr( $template->post_title ) . '</option>';
			?>
		</select> <input type="button" id="aqpb-insert-template"
			class="button-primary"
			value="<?php echo esc_attr__( 'Insert Template', 'framework' ); ?>"
			onclick="insertTemplate();" /> <a id="aqpb-cancel-template"
			class="button-secondary" onclick="tb_remove();"
			title="<?php echo esc_attr__( 'Cancel', 'framework' ); ?>"><?php echo esc_attr__( 'Cancel', 'framework' ); ?>
		</a>

		<?php do_action( 'aqpb_after_iframe_display', $templates ); ?>

	</div>
</div>





		<?php /*
		<div id="cb-text-box-iframe-container" style="display: none;">
		<div class="wrap" style="padding: 1em">
		<textarea id="cb-aq-text-block" style="width: 100%;height: 200px;"></textarea>
		<input type="hidden" id="edited-text-box">
		<span class="button" onClick="savetobox();">Save</span>
		</div>
		</div>
		*/?>
		<?php
				} /** End Coditional Statement for post, page, new and edit post */

			}

			/**
			 * Contextual help tabs
			 *
			 * @since 1.0.0
			 */
			function contextual_help() {

					
			}

			/**
			 * Main page builder page display
			 *
			 * @since	1.0.0
			 */
			function builder_page_show(){
				global $post;
				$post_id = $post->ID;
				$cb5_builder_id=get_post_meta($post_id,'cb5_builder',true);
				$new_template=get_post_meta($post_id,'new_template',true);
				$cb5_post_blocks = get_post_meta($post_id,'blocks');

				if(!isset($cb5_post_blocks[0])) $cb5_post_blocks[0]='';
				$new_blocks = $cb5_post_blocks[0];
				if (is_array($new_blocks)){

						
					foreach ($new_blocks as $key=>$value){
						if($value['id_base']=='aq_clear_block')unset($new_blocks[$key]);
						if($value['id_base']=='aq_tabs_block'){
							for($i=1;$i<=sizeof($new_blocks[$key]['tabs']);$i++){
								//if(isset($new_blocks[$key]['tabs'][$i]['content']))$new_blocks[$key]['tabs'][$i]['content']=str_replace(";cbsp#21&;","\r\n",$new_blocks[$key]['tabs'][$i]['content']);
							}

						}
						//if(isset($new_blocks[$key]['content']))$new_blocks[$key]['content']=str_replace(";cbsp#21&;","\r\n",$new_blocks[$key]['content']);
					}
					array_str_replace(";cbsp#21&;","\r\n",$new_blocks);
					array_str_replace(";cbsp#21;","\r\n",$new_blocks);
					$cb5_post_blocks[0] = $new_blocks;

				}
			    
				require_once(AQPB_PATH . 'view/view-builder-page.php');
					
			}


	}
}
// not much to say when you're high above the mucky-muck


add_action( 'add_meta_boxes', 'cbb_add_custom_box' );

add_action( 'save_post', 'cbb_save_postdata' );
$cb5_builder=new AQ_Page_Builder();

function cbb_add_custom_box() {
	$screens = array( 'post', 'page','product' );
	foreach ($screens as $screen) {
		add_meta_box(
            'cbb-page-builder',
		__( 'Cosmetico Page Builder', 'cb-cosmetico' ),
            'cbb_inner_custom_box',
		$screen
		);
	}
}

/* Prints the box content */
function cbb_inner_custom_box( $post ) {
	global $cb5_builder;
	$cb5_builder->builder_page_show();
	$cb5_builder->admin_enqueue();
}


/* When the post is saved, saves our custom data */
function cbb_save_postdata( $post_id ) {
	global $cb5_builder;
	$selected_template_id = isset($_REQUEST['template']) ? (int) $_REQUEST['template'] : 0;
	if(isset($_REQUEST['cb5_action'])) $cb5_action = $_REQUEST['cb5_action']; else $cb5_action='';

	$template_name = isset($_REQUEST['template-name']) && !empty($_REQUEST['template-name']) ? htmlspecialchars($_REQUEST['template-name']) : 'No Title';

	$blocks = isset($_REQUEST['aq_blocks']) ? $_REQUEST['aq_blocks'] : '';

	$new_blocks = $blocks;

	if (is_array($new_blocks)){
		foreach ($new_blocks as $key=>$value){
			if($value['id_base']=='aq_clear_block')unset($new_blocks[$key]);
			if($value['id_base']=='aq_tabs_block'){
				for($i=1;$i<=sizeof($new_blocks[$key]['tabs']);$i++){
					//if(isset($new_blocks[$key]['tabs'][$i]['content']))$new_blocks[$key]['tabs'][$i]['content']=str_replace("\r\n",";cbsp#21&;",$new_blocks[$key]['tabs'][$i]['content']);
				}

			}
			//if(isset($new_blocks[$key]['content']))$new_blocks[$key]['content']=str_replace("\r\n",";cbsp#21&;",$new_blocks[$key]['content']);
		}

		$blocks = $new_blocks;
		//$test = $blocks;
		array_str_replace("\r\n",";cbsp#21;",$blocks);

		/*
		 echo '<pre>';
		 print_r($test);
		 echo '</pre>';
		 /*
		 $ser_blocks = serialize($blocks);
		 $ser_blocks=str_replace("\r\n",";cbsp#2222221&;",$ser_blocks);

		 $blocks = unserialize($ser_blocks);
		 /*	echo $ser_blocks;
		 echo '<pre>';
		 print_r($blocks);
		 echo '</pre>';
		 */
	}
	switch ($cb5_action) {
		case "update":

			$cb5_builder->update_template($selected_template_id, $blocks, $template_name);
			update_post_meta($post_id,'cb5_builder',$selected_template_id);

			break;

		case "create":
			$new_id = $cb5_builder->create_template($template_name,$blocks,$post_id);


			break;

		case "delete":
			$cb5_builder->delete_template($selected_template_id);
			update_post_meta($post_id,'cb5_builder','0');

			break;
		case "change":
			update_post_meta($post_id,'cb5_builder',(int) $_REQUEST['template_change']);

			break;
		case "to_post":
			//$blocks = isset($_REQUEST['aq_blocks']) ? $_REQUEST['aq_blocks'] : '';
			update_post_meta($post_id,'blocks',$blocks);
			update_post_meta($post_id,'cb5_builder','0');

			break;

	}

}
