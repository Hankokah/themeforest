<?php

	// Load the widget on widgets_init
	function bdt_logo_widget_register() {
		register_widget('bdtLogoWidget');
	}
	add_action('widgets_init', 'bdt_logo_widget_register');


class bdtLogoWidget extends WP_Widget {

	const CUSTOM_IMAGE_SIZE_SLUG = 'bdt_logo_custom_size';

	/**
	 * Tribe Image Widget constructor
	 *
	 * @author Modern Tribe, Inc.
	 */
	function bdtLogoWidget() {
		$widget_ops = array( 'classname' => 'bdt_logo_widget', 'description' => __( 'Set your site logo by this widget.', 'warp' ) );
		$control_ops = array( 'id_base' => 'bdt_logo_widget' );
		$this->WP_Widget('bdt_logo_widget', __('Logo Widget', 'warp'), $widget_ops, $control_ops);
		
		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );
		add_action( 'admin_head-widgets.php', array( $this, 'admin_head' ) );
	}

	/**
	 * Enqueue all the javascript.
	 */
	function admin_setup() {
		wp_enqueue_media();
		wp_enqueue_script( 'bdt-logo-widget', get_stylesheet_directory_uri().'/js/image-widget.js', array( 'jquery', 'media-upload', 'media-views' ),'' );

		wp_localize_script( 'bdt-logo-widget', 'TribeImageWidget', array(
			'frame_title' => __( 'Select an Image', 'warp' ),
			'button_title' => __( 'Insert Into Widget', 'warp' ),
		) );
	}

	/**
	 * Widget frontend output
	 *
	 * @param array $args
	 * @param array $instance
	 * @author Modern Tribe, Inc.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, self::get_defaults() );
		if ( !empty( $instance['imageurl'] ) || !empty( $instance['attachment_id'] ) ) {
			$instance['link'] = apply_filters( 'image_widget_image_link', esc_url( $instance['link'] ), $args, $instance );
			$instance['width'] = apply_filters( 'image_widget_image_width', abs( $instance['width'] ), $args, $instance );
			$instance['height'] = apply_filters( 'image_widget_image_height', abs( $instance['height'] ), $args, $instance );
			$instance['maxwidth'] = apply_filters( 'image_widget_image_maxwidth', esc_attr( $instance['maxwidth'] ), $args, $instance );
			$instance['maxheight'] = apply_filters( 'image_widget_image_maxheight', esc_attr( $instance['maxheight'] ), $args, $instance );
			$instance['alt'] = apply_filters( 'image_widget_image_alt', esc_attr( $instance['alt'] ), $args, $instance );

			if ( !defined( 'IMAGE_WIDGET_COMPATIBILITY_TEST' ) ) {
				$instance['attachment_id'] = ( $instance['attachment_id'] > 0 ) ? $instance['attachment_id'] : $instance['image'];
				$instance['attachment_id'] = apply_filters( 'image_widget_image_attachment_id', abs( $instance['attachment_id'] ), $args, $instance );
				$instance['size'] = apply_filters( 'image_widget_image_size', esc_attr( $instance['size'] ), $args, $instance );
			}
			$instance['imageurl'] = apply_filters( 'image_widget_image_url', esc_url( $instance['imageurl'] ), $args, $instance );

			echo $before_widget;
			echo $this->get_image_html( $instance, true );
			echo $after_widget;
		}
	}

	/**
	 * Update widget options
	 *
	 * @param object $new_instance Widget Instance
	 * @param object $old_instance Widget Instance
	 * @return object
	 * @author Modern Tribe, Inc.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, self::get_defaults() );
		$instance['link'] = $new_instance['link'];
		$instance['width'] = abs( $new_instance['width'] );
		$instance['height'] =abs( $new_instance['height'] );
		if ( !defined( 'IMAGE_WIDGET_COMPATIBILITY_TEST' ) ) {
			$instance['size'] = $new_instance['size'];
		}
		$instance['alt'] = $new_instance['alt'];

		// Reverse compatibility with $image, now called $attachement_id
		if ( !defined( 'IMAGE_WIDGET_COMPATIBILITY_TEST' ) && $new_instance['attachment_id'] > 0 ) {
			$instance['attachment_id'] = abs( $new_instance['attachment_id'] );
		} elseif ( $new_instance['image'] > 0 ) {
			$instance['attachment_id'] = $instance['image'] = abs( $new_instance['image'] );
			if ( class_exists('ImageWidgetDeprecated') ) {
				$instance['imageurl'] = ImageWidgetDeprecated::get_image_url( $instance['image'], $instance['width'], $instance['height'] );  // image resizing not working right now
			}
		}
		$instance['imageurl'] = $new_instance['imageurl']; // deprecated

		$instance['aspect_ratio'] = $this->get_image_aspect_ratio( $instance );

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance, self::get_defaults());
		$id_prefix = $this->get_field_id(''); 
		?>
		<div class="uploader">

			<input type="submit" class="button bdt-logo-upload-btn" name="<?php echo $this->get_field_name('uploader_button'); ?>" id="<?php echo $this->get_field_id('uploader_button'); ?>" value="<?php _e('Select an Image', 'warp'); ?>" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' ); return false;" />
			<div class="bdt-logo-preview" id="<?php echo $this->get_field_id('preview'); ?>">
				<?php echo $this->get_image_html($instance, false); ?>
			</div>
			<input type="hidden" id="<?php echo $this->get_field_id('attachment_id'); ?>" name="<?php echo $this->get_field_name('attachment_id'); ?>" value="<?php echo abs($instance['attachment_id']); ?>" />
			<input type="hidden" id="<?php echo $this->get_field_id('imageurl'); ?>" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $instance['imageurl']; ?>" />
		</div>
		<br clear="all" />

		<div id="<?php echo $this->get_field_id('fields'); ?>" <?php if ( empty($instance['attachment_id']) && empty($instance['imageurl']) ) { ?>style="display:none;"<?php } ?>>
			<p><label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alternate Text', 'warp'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['alt'])); ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Alternative Link', 'warp'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['link'])); ?>" /><br />

			<div id="<?php echo $this->get_field_id('custom_size_selector'); ?>" 
			<?php if ( empty($instance['attachment_id']) && !empty($instance['imageurl']) ) { $instance['size'] = 'bdt_custom_size'; ?>style="display:none;"<?php } ?>>
				<p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Custom Size', 'warp'); ?>:</label>
					<select class="widefat" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" onChange="imageWidget.toggleSizes( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' );">
						<?php
						// Note: this is dumb. We shouldn't need to have to do this. There should really be a centralized function in core code for this.
						$possible_sizes = array(
							'full'      => __('Full Size', 'warp'),
							'bdt_custom_size' => __('Custom Size', 'warp')
						);

						foreach( $possible_sizes as $size_key => $size_label ) { ?>
							<option value="<?php echo $size_key; ?>"<?php selected( $instance['size'], $size_key ); ?>><?php echo $size_label; ?></option>
						<?php } ?>
					</select>
				</p>
			</div>
			<div id="<?php echo $this->get_field_id('custom_size_fields'); ?>" <?php if ( empty($instance['size']) || $instance['size']!='bdt_custom_size' ) { ?>style="display:none;"<?php } ?>>

				<input type="hidden" id="<?php echo $this->get_field_id('aspect_ratio'); ?>" name="<?php echo $this->get_field_name('aspect_ratio'); ?>" value="<?php echo $this->get_image_aspect_ratio( $instance ); ?>" />

				<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width', 'warp'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['width'])); ?>" onchange="imageWidget.changeImgWidth( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' )" /></p>

				<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height', 'warp'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['height'])); ?>" onchange="imageWidget.changeImgHeight( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' )" /></p>

			</div>
		</div>
		<?php
	}

	/**
	 * Admin header css
	 *
	 * @author Modern Tribe, Inc.
	 */
	function admin_head() {
		?>
	<style type="text/css">
		input.bdt-logo-upload-btn {
			width: 100%;
			height: 34px !important;
			line-height: 33px !important;
			margin: 15px 0 !important;
		}
		.bdt-logo-preview {
			background-color: #ddd;
			padding: 15px;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
			border-radius: 3px;
			box-shadow: inset 0 0 5px 0 rgba(0,0,0,0.05);
			border: 1px solid rgba(0,0,0,0.1);
		}
		.bdt-logo-preview img {
			max-width: 100%;
			height: auto;
		}
	</style>
	<?php
	}

	/**
	 * Render an array of default values.
	 *
	 * @return array default values
	 */
	private static function get_defaults() {

		$defaults = array(
			'link' => '',
			'width' => 0,
			'height' => 0,
			'maxwidth' => '100%',
			'maxheight' => '',
			'image' => 0, // reverse compatible - now attachement_id
			'imageurl' => '', // reverse compatible.
			'alt' => '',
			'size' =>''
		);

		return $defaults;
	}

	/**
	 * Render the image html output.
	 *
	 * @param array $instance
	 * @param bool $include_link will only render the link if this is set to true. Otherwise link is ignored.
	 * @return string image html
	 */
	private function get_image_html( $instance, $include_link = true ) {

		$output = '';

		if ( $include_link ) {
			$attr = array(
				'href' => (!empty($instance['link'])) ? $instance['link'] : home_url(),
				'class' => 	$this->widget_options['classname'].'-image-link',
				'title' => (!empty($instance['alt'])) ? $instance['alt'] : get_bloginfo('name'),
			);
			$attr = apply_filters('image_widget_link_attributes', $attr, $instance );
			$attr = array_map( 'esc_attr', $attr );
			$output = '<a';
			foreach ( $attr as $name => $value ) {
				$output .= sprintf( ' %s="%s"', $name, $value );
			}
			$output .= '>';
		}

		$size = $this->get_image_size( $instance );
		if ( is_array( $size ) ) {
			$instance['width'] = $size[0];
			$instance['height'] = $size[1];
		} elseif ( !empty( $instance['attachment_id'] ) ) {
			//$instance['width'] = $instance['height'] = 0;
			$image_details = wp_get_attachment_image_src( $instance['attachment_id'], $size );
			if ($image_details) {
				$instance['imageurl'] = $image_details[0];
				$instance['width'] = $image_details[1];
				$instance['height'] = $image_details[2];
			}
		}
		$instance['width'] = abs( $instance['width'] );
		$instance['height'] = abs( $instance['height'] );

		$attr = array();
		$attr['alt'] = ( !empty( $instance['alt'] ) ) ? $instance['alt'] : get_bloginfo('name');
		if (is_array($size)) {
			$attr['class'] = 'attachment-'.join('x',$size);
		} else {
			$attr['class'] = 'attachment-'.$size;
		}
		$attr['style'] = '';
		if (!empty($instance['maxwidth'])) {
			$attr['style'] .= "max-width: {$instance['maxwidth']};";
		}
		if (!empty($instance['maxheight'])) {
			$attr['style'] .= "max-height: {$instance['maxheight']};";
		}
		$attr = apply_filters( 'image_widget_image_attributes', $attr, $instance );

		// If there is an imageurl, use it to render the image. Eventually we should kill this and simply rely on attachment_ids.
		if ( !empty( $instance['imageurl'] ) ) {
			// If all we have is an image src url we can still render an image.
			$attr['src'] = $instance['imageurl'];
			$attr = array_map( 'esc_attr', $attr );
			$hwstring = image_hwstring( $instance['width'], $instance['height'] );
			$output .= rtrim("<img $hwstring");
			foreach ( $attr as $name => $value ) {
				$output .= sprintf( ' %s="%s"', $name, $value );
			}
			$output .= ' />';
		}

		if ( $include_link ) {
			$output .= '</a>';
		}

		return $output;
	}

	/**
	 * Assesses the image size in case it has not been set or in case there is a mismatch.
	 *
	 * @param $instance
	 * @return array|string
	 */
	private function get_image_size( $instance ) {
		if ( !empty( $instance['size'] ) && $instance['size'] != 'bdt_custom_size' ) {
			$size = $instance['size'];
		} elseif ( isset( $instance['width'] ) && is_numeric($instance['width']) && isset( $instance['height'] ) && is_numeric($instance['height']) ) {
			//$size = array(abs($instance['width']),abs($instance['height']));
			$size = array($instance['width'],$instance['height']);
		} else {
			$size = 'full';
		}
		return $size;
	}

	/**
	 * Establish the aspect ratio of the image.
	 *
	 * @param $instance
	 * @return float|number
	 */
	private function get_image_aspect_ratio( $instance ) {
		if ( !empty( $instance['aspect_ratio'] ) ) {
			return abs( $instance['aspect_ratio'] );
		} else {
			$attachment_id = ( !empty($instance['attachment_id']) ) ? $instance['attachment_id'] : $instance['image'];
			if ( !empty($attachment_id) ) {
				$image_details = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ($image_details) {
					return ( $image_details[1]/$image_details[2] );
				}
			}
		}
	}
}