<?php
/*
Plugin Name: Advanced Custom Fields Pro
Plugin URI: http://www.advancedcustomfields.com/
Description: Customise WordPress with powerful, professional and intuitive fields
Version: 5.3.2.2
Author: elliot condon
Author URI: http://www.elliotcondon.com/
Copyright: Elliot Condon
Text Domain: acf
Domain Path: /lang
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('acf') ) :

class acf {
	
	// vars
	var $settings;
		
	
	/*
	*  __construct
	*
	*  A dummy constructor to ensure ACF is only initialized once
	*
	*  @type	function
	*  @date	23/06/12
	*  @since	5.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	function __construct() {
		
		/* Do nothing here */
		
	}
	
	
	/*
	*  initialize
	*
	*  The real constructor to initialize ACF
	*
	*  @type	function
	*  @date	28/09/13
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
		
	function initialize() {
		
		// vars
		$this->settings = array(
			
			// basic
			'name'				=> __('Advanced Custom Fields', 'acf'),
			'version'			=> '5.3.2.2',
						
			// urls
			'basename'			=> plugin_basename( __FILE__ ),
			'path'				=> plugin_dir_path( __FILE__ ),
			'dir'				=> plugin_dir_url( __FILE__ ),
			
			// options
			'show_admin'		=> true,
			'show_updates'		=> true,
			'stripslashes'		=> false,
			'local'				=> true,
			'json'				=> true,
			'save_json'			=> '',
			'load_json'			=> array(),
			'default_language'	=> '',
			'current_language'	=> '',
			'capability'		=> 'manage_options',
			'uploader'			=> 'wp',
			'autoload'			=> false,
			'export_textdomain'	=> '',
			'export_translate'	=> array('title', 'label', 'instructions')
		);
		
		
		// include helpers
		include_once('api/api-helpers.php');
		
		
		// api
		acf_include('api/api-value.php');
		acf_include('api/api-field.php');
		acf_include('api/api-field-group.php');
		acf_include('api/api-template.php');
		
		
		// core
		acf_include('core/ajax.php');
		acf_include('core/field.php');
		acf_include('core/input.php');
		acf_include('core/json.php');
		acf_include('core/local.php');
		acf_include('core/location.php');
		acf_include('core/media.php');
		acf_include('core/revisions.php');
		acf_include('core/compatibility.php');
		acf_include('core/third_party.php');
		
		
		// forms
		acf_include('forms/attachment.php');
		acf_include('forms/comment.php');
		acf_include('forms/post.php');
		acf_include('forms/taxonomy.php');
		acf_include('forms/user.php');
		acf_include('forms/widget.php');
		
		
		// admin
		if( is_admin() ) {
			
			acf_include('admin/admin.php');
			acf_include('admin/field-group.php');
			acf_include('admin/field-groups.php');
			acf_include('admin/update.php');
			acf_include('admin/settings-tools.php');
			//acf_include('admin/settings-addons.php');
			acf_include('admin/settings-info.php');
		}
		
		
		// pro
		acf_include('pro/acf-pro.php');
		
		
		// actions
		add_action('init',	array($this, 'init'), 5);
		add_action('init',	array($this, 'register_post_types'), 5);
		add_action('init',	array($this, 'register_post_status'), 5);
		add_action('init',	array($this, 'register_assets'), 5);
		
		
		// filters
		add_filter('posts_where',		array($this, 'posts_where'), 10, 2 );
		//add_filter('posts_request',	array($this, 'posts_request'), 10, 1 );
		
	}
	
	
	/*
	*  init
	*
	*  This function will run after all plugins and theme functions have been included
	*
	*  @type	action (init)
	*  @date	28/09/13
	*  @since	5.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	function init() {
		
		// bail early if a plugin called get_field early
		if( !did_action('plugins_loaded') ) return;
		
		
		// bail early if already init
		if( acf_get_setting('init') ) return;
		
		
		// only run once
		acf_update_setting('init', true);
		
		
		// vars
		$major = intval( acf_get_setting('version') );
		
		
		// redeclare dir
		// - allow another plugin to modify dir (maybe force SSL)
		acf_update_setting('dir', plugin_dir_url( __FILE__ ));
		
		
		// set text domain
		load_textdomain( 'acf', acf_get_path( 'lang/acf-' . get_locale() . '.mo' ) );
		
		
		// include wpml support
		if( defined('ICL_SITEPRESS_VERSION') ) {
		
			acf_include('core/wpml.php');
			
		}
		
		
		// field types
		acf_include('fields/text.php');
		acf_include('fields/textarea.php');
		acf_include('fields/number.php');
		acf_include('fields/email.php');
		acf_include('fields/url.php');
		acf_include('fields/password.php');
		acf_include('fields/wysiwyg.php');
		acf_include('fields/oembed.php');
		acf_include('fields/image.php');
		acf_include('fields/file.php');
		acf_include('fields/select.php');
		acf_include('fields/checkbox.php');
		acf_include('fields/radio.php');
		acf_include('fields/true_false.php');
		acf_include('fields/post_object.php');
		acf_include('fields/page_link.php');
		acf_include('fields/relationship.php');
		acf_include('fields/taxonomy.php');
		acf_include('fields/user.php');
		acf_include('fields/google-map.php');
		acf_include('fields/date_picker.php');
		acf_include('fields/color_picker.php');
		acf_include('fields/message.php');
		acf_include('fields/tab.php');
		
		
		// 3rd party field types
		do_action('acf/include_field_types', $major);
		
		
		// local fields
		do_action('acf/include_fields', $major);
		
		
		// action for 3rd party
		do_action('acf/init');
			
	}
	
	
	/*
	*  register_post_types
	*
	*  This function will register post types and statuses
	*
	*  @type	function
	*  @date	22/10/2015
	*  @since	5.3.2
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function register_post_types() {
		
		// vars
		$cap = acf_get_setting('capability');
		
		
		// register post type 'acf-field-group'
		register_post_type('acf-field-group', array(
			'labels'			=> array(
			    'name'					=> __( 'Field Groups', 'acf' ),
				'singular_name'			=> __( 'Field Group', 'acf' ),
			    'add_new'				=> __( 'Add New' , 'acf' ),
			    'add_new_item'			=> __( 'Add New Field Group' , 'acf' ),
			    'edit_item'				=> __( 'Edit Field Group' , 'acf' ),
			    'new_item'				=> __( 'New Field Group' , 'acf' ),
			    'view_item'				=> __( 'View Field Group', 'acf' ),
			    'search_items'			=> __( 'Search Field Groups', 'acf' ),
			    'not_found'				=> __( 'No Field Groups found', 'acf' ),
			    'not_found_in_trash'	=> __( 'No Field Groups found in Trash', 'acf' ), 
			),
			'public'			=> false,
			'show_ui'			=> true,
			'_builtin'			=> false,
			'capability_type'	=> 'post',
			'capabilities'		=> array(
				'edit_post'			=> $cap,
				'delete_post'		=> $cap,
				'edit_posts'		=> $cap,
				'delete_posts'		=> $cap,
			),
			'hierarchical'		=> true,
			'rewrite'			=> false,
			'query_var'			=> false,
			'supports' 			=> array('title'),
			'show_in_menu'		=> false,
		));
		
		
		// register post type 'acf-field'
		register_post_type('acf-field', array(
			'labels'			=> array(
			    'name'					=> __( 'Fields', 'acf' ),
				'singular_name'			=> __( 'Field', 'acf' ),
			    'add_new'				=> __( 'Add New' , 'acf' ),
			    'add_new_item'			=> __( 'Add New Field' , 'acf' ),
			    'edit_item'				=> __( 'Edit Field' , 'acf' ),
			    'new_item'				=> __( 'New Field' , 'acf' ),
			    'view_item'				=> __( 'View Field', 'acf' ),
			    'search_items'			=> __( 'Search Fields', 'acf' ),
			    'not_found'				=> __( 'No Fields found', 'acf' ),
			    'not_found_in_trash'	=> __( 'No Fields found in Trash', 'acf' ), 
			),
			'public'			=> false,
			'show_ui'			=> false,
			'_builtin'			=> false,
			'capability_type'	=> 'post',
			'capabilities'		=> array(
				'edit_post'			=> $cap,
				'delete_post'		=> $cap,
				'edit_posts'		=> $cap,
				'delete_posts'		=> $cap,
			),
			'hierarchical'		=> true,
			'rewrite'			=> false,
			'query_var'			=> false,
			'supports' 			=> array('title'),
			'show_in_menu'		=> false,
		));
		
	}
	
	
	/*
	*  register_post_status
	*
	*  This function will register custom post statuses
	*
	*  @type	function
	*  @date	22/10/2015
	*  @since	5.3.2
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function register_post_status() {
		
		// acf-disabled
		register_post_status('acf-disabled', array(
			'label'                     => __( 'Disabled', 'acf' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Disabled <span class="count">(%s)</span>', 'Disabled <span class="count">(%s)</span>', 'acf' ),
		));
		
	}
	
	
	/*
	*  register_assets
	*
	*  This function will register scripts and styles
	*
	*  @type	function
	*  @date	22/10/2015
	*  @since	5.3.2
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function register_assets() {
		
		// vars
		$version = acf_get_setting('version');
		$lang = get_locale();
		$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$scripts = array();
		$styles = array();
		
		
		// append scripts
		$scripts['select2'] = array(
			'src'	=> acf_get_dir("assets/inc/select2/select2{$min}.js"),
			'deps'	=> array('jquery')
		);
		
		$scripts['acf-input'] = array(
			'src'	=> acf_get_dir("assets/js/acf-input{$min}.js"),
			'deps'	=> array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
				'jquery-ui-resizable',
				'jquery-ui-datepicker',
				'wp-color-picker',
				'select2'
			)
		);
		
		$scripts['acf-field-group'] = array(
			'src'	=> acf_get_dir("assets/js/acf-field-group{$min}.js"),
			'deps'	=> array('acf-input')
		);
		
		
		// select2-l10n
		if( $lang ) {
			
			// vars
			$lang = str_replace('_', '-', $lang);
			$lang_code = substr($lang, 0, 2);
			$src = '';
			
			
			// attempt 1
			if( file_exists(acf_get_path("assets/inc/select2/select2_locale_{$lang_code}.js")) ) {
				
				$src = acf_get_dir("assets/inc/select2/select2_locale_{$lang_code}.js");
				
			} elseif( file_exists(acf_get_path("assets/inc/select2/select2_locale_{$lang}.js")) ) {
				
				$src = acf_get_dir("assets/inc/select2/select2_locale_{$lang}.js");
				
			}
			
			
			// only append if file exists
			if( $src ) {
				
				// append script
				$scripts['select2-l10n'] = array(
					'src'	=> $src,
					'deps'	=> array('select2')
				);
				
				
				// append dep
				$scripts['acf-input']['deps'][] = 'select2-l10n';
				
			}
			
		}
		
		
		// register scripts
		foreach( $scripts as $handle => $script ) {
			
			wp_register_script( $handle, $script['src'], $script['deps'], $version );
			
		}
		
		
		// append styles
		$styles['select2'] = array(
			'src'		=> acf_get_dir('assets/inc/select2/select2.css'),
			'deps'		=> false
		);
		
		$styles['acf-datepicker'] = array(
			'src'		=> acf_get_dir('assets/inc/datepicker/jquery-ui-1.10.4.custom.min.css'),
			'deps'		=> false
		);
		
		$styles['acf-global'] = array(
			'src'		=> acf_get_dir('assets/css/acf-global.css'),
			'deps'		=> false
		);
		
		$styles['acf-input'] = array(
			'src'		=> acf_get_dir('assets/css/acf-input.css'),
			'deps'		=> array('acf-global', 'wp-color-picker', 'select2', 'acf-datepicker')
		);
		
		$styles['acf-field-group'] = array(
			'src'		=> acf_get_dir('assets/css/acf-field-group.css'),
			'deps'		=> array('acf-input')
		);
		
		
		// register styles
		foreach( $styles as $handle => $style ) {
		
			wp_register_style( $handle, $style['src'], $style['deps'], $version ); 
			
		}
		
	}
	
	
	/*
	*  posts_where
	*
	*  This function will add in some new parameters to the WP_Query args allowing fields to be found via key / name
	*
	*  @type	filter
	*  @date	5/12/2013
	*  @since	5.0.0
	*
	*  @param	$where (string)
	*  @param	$wp_query (object)
	*  @return	$where (string)
	*/
	
	function posts_where( $where, $wp_query ) {
		
		// global
		global $wpdb;
		
		
		// acf_field_key
		if( $field_key = $wp_query->get('acf_field_key') ) {
		
			$where .= $wpdb->prepare(" AND {$wpdb->posts}.post_name = %s", $field_key );
			
	    }
	    
	    
	    // acf_field_name
	    if( $field_name = $wp_query->get('acf_field_name') ) {
	    
			$where .= $wpdb->prepare(" AND {$wpdb->posts}.post_excerpt = %s", $field_name );
			
	    }
	    
	    
	    // acf_group_key
		if( $group_key = $wp_query->get('acf_group_key') ) {
		
			$where .= $wpdb->prepare(" AND {$wpdb->posts}.post_name = %s", $group_key );
			
	    }
	    
	    
	    // return
	    return $where;
	    
	}
	
	
	/*
function posts_request( $thing ) {
		
		return $thing;
	}
*/
	
}


/*
*  acf
*
*  The main function responsible for returning the one true acf Instance to functions everywhere.
*  Use this function like you would a global variable, except without needing to declare the global.
*
*  Example: <?php $acf = acf(); ?>
*
*  @type	function
*  @date	4/09/13
*  @since	4.3.0
*
*  @param	N/A
*  @return	(object)
*/

function acf() {

	global $acf;
	
	if( !isset($acf) ) {
	
		$acf = new acf();
		
		$acf->initialize();
		
	}
	
	return $acf;
	
}


// initialize
acf();


endif; // class_exists check

?>
