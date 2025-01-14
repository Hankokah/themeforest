<?php
if(!class_exists('MET_Tabs_Block')) {
	class MET_Tabs_Block extends AQ_Block {

		function __construct() {
			$block_options = array(
				'name' => 'Tabs &amp; Accordion',
				'size' => 'span6',
			);

			parent::__construct('MET_Tabs_Block', $block_options);

			add_action('wp_ajax_aq_block_tab_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => 'My New Tab',
						'content' => 'My tab contents',
					)
				),
				'type'	=> 'tab',
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$tab_types = array(
				'tab' 		=> 'Tabs',
				//'vtab' 		=> 'Vertical Tabs',
				//'toggle' 	=> 'Toggles',
				'accordion' => 'Accordion'
			);

			?>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="tab" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<p class="description">
				<label for="<?php echo $this->get_field_id('type') ?>">
					Tabs style<br/>
					<?php echo aq_field_select('type', $block_id, $tab_types, $type) ?>
				</label>
			</p>
		<?php
		}

		function tab($tab = array(), $count = 0) {

			?>
			<li id="<?php echo $this->get_field_id('tabs') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $tab['title'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>

				<div class="sortable-body">
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title">
							Tab Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
						</label>
					</p>
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content">
							Tab Content<br/>
							<textarea id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $tab['content'] ?></textarea>
						</label>
					</p>
					<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>

			</li>
		<?php
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script('jquery-ui-tabs');

			$output = '';

			if($type == 'tab') {

				$widgetID = uniqid('met_tabs_');
                $uniqueTabID = uniqid('_');
?>
				<ul id="myTab" class="nav nav-tabs met_tab_nav met_bgcolor">
					<?php $i = 1; foreach( $tabs as $tab ): ?> <li <?php echo (($i == 1) ? 'class="active"' : '') ?>><a href="#<?php echo sanitize_title( $tab['title'] ) . $i . $uniqueTabID ?>" data-toggle="tab"><?php echo $tab['title'] ?></a></li> <?php $i++; endforeach; ?>
				</ul>
				<div id="<?php echo $widgetID ?>" class="tab-content met_tab_content">
				<?php $i = 1; foreach( $tabs as $tab ): ?>
					<div class="tab-pane fade <?php echo (($i == 1) ? 'active in' : '') ?>" id="<?php echo sanitize_title( $tab['title'] ) . $i . $uniqueTabID ?>">
						<?php echo do_shortcode(htmlspecialchars_decode($tab['content'])) ?>
					</div>
				<?php $i++; endforeach; ?>
				</div>


<?php

			} elseif ($type == 'toggle') {

				$output .= '<div id="aq_block_toggles_wrapper_'.rand(1,100).'" class="aq_block_toggles_wrapper">';

				foreach( $tabs as $tab ){
					$output  .= '<div class="aq_block_toggle">';
					$output .= '<h2 class="tab-head">'. $tab['title'] .'</h2>';
					$output .= '<div class="arrow"></div>';
					$output .= '<div class="tab-body close cf">';
					$output .= wpautop(do_shortcode(htmlspecialchars_decode($tab['content'])));
					$output .= '</div>';
					$output .= '</div>';
				}

				$output .= '</div>';

			} elseif ($type == 'accordion') {

				$count = count($tabs);
				$i = 1;

				$widgetID = uniqid('met_');
				$output = '<div id="'.$widgetID.'" class="accordion met_accordion scrolled">';

				foreach( $tabs as $tab ){

					$open = $i == 1 ? 'in' : 'collapsed';
					$minusPlus = $open == 'in' ? 'minus' : 'plus';

					$child = '';
					if($i == 1) $child = 'first-child';
					if($i == $count) $child = 'last-child';
					$i++;

                    $uniqueTabID = uniqid('_');

					$output .= '
					<div class="accordion-group scrolled__item">
						<div class="accordion-heading">
							<a class="accordion-toggle '.$open.'" data-toggle="collapse" data-parent="#'.$widgetID.'" href="#collapse_'.$i.$uniqueTabID.'">
								<span class="met_toggle_text">'. $tab['title'] .'</span>
								<span class="met_icon_'.$minusPlus.'"></span>
							</a>
						</div>
						<div id="collapse_'.$i.$uniqueTabID.'" class="accordion-body collapse '.$open.'">
							<div class="accordion-inner">'.wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))).'</div>
						</div>
					</div><!-- Accordion Group Ends -->
					';
				}

				$output .= '</div>';

			}elseif($type == 'vtab') {

				$output .= '<div id="met_vtabs_'. rand(1, 100) .'" class="sideway-tabs">';
				$output .= '<ul class="sideway-controls"><div class="sideway-controls-shadow"></div>';

				$i = 1;
				foreach( $tabs as $tab ){
					$tab_selected = $i == 1 ? 'active-sideway-item' : '';
					$output .= '<li data-sideway-index="'.$i.'" class="'.$tab_selected.'">' . $tab['title'] . '</li>';
					$i++;
				}

				$output .= '</ul><div class="sideway-description">';

				$i = 1;
				foreach($tabs as $tab) {
					$tab_content_selected = $i == 1 ? 'active-sideway-content' : '';
					$output .= '<div class="sideway-description-content '.$tab_content_selected.'" id="met-vtab-'. sanitize_title( $tab['title'] ) . $i .'">'. wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))) .'</div>';

					$i++;
				}

				$output .= '</div></div>';

			}

			echo $output;

		}

		/* AJAX add tab */
		function add_tab() {
			$nonce = $_POST['security'];
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => 'New Tab',
				'content' => ''
			);

			if($count) {
				$this->tab($tab, $count);
			} else {
				die(-1);
			}

			die();
		}

		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return $new_instance;
		}
	}
}
