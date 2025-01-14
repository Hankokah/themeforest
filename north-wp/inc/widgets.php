<?php
// Do Shortcodes inside widgets
add_filter('widget_text', 'do_shortcode');

// thb Tag Cloud Size
function tag_cloud_filter($args = array()) {
   $args['smallest'] = 11;
   $args['largest'] = 11;
   $args['unit'] = 'px';
   $args['format']= 'list';
   return $args;
}

add_filter('widget_tag_cloud_args', 'tag_cloud_filter', 90);
add_filter('widget_product_tag_cloud_args', 'tag_cloud_filter', 90);

require get_template_directory() .'/inc/widgets/dribbble.php';
require get_template_directory() .'/inc/widgets/flickr.php';
require get_template_directory() .'/inc/widgets/subscribe.php';
require get_template_directory() .'/inc/widgets/latest-posts-images.php';