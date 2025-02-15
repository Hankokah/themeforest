<?php if ( ! defined( 'ABSPATH' ) ) die( 'Direct access forbidden.' );

class Widget_Fw_Testimonials extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Testimonials Widget.', 'fw' ) );

		parent::__construct( false, __( 'Apital Testimonials', 'fw' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$params = array();

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$filepath = dirname( __FILE__ ) . '/views/widget.php';

		$data = array(
			'instance' => $params,
			'before_widget' => '',
			'after_widget'  => '',
		);

        if(defined('FW'))
        echo fw_render_view( $filepath, $data );
    }

	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( (array) $new_instance, $old_instance );
        $instance['title'] = $new_instance['title'];
        $instance['number'] = $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number' => '') );
        $title = ($instance['title']);
        $number = (int)$instance['number'];
        ?>

        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','fw'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of testimonials:','fw'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></p>

<?php
	}
}


