<div id="cf-post-format-tabs" class="cf-nav" style="display: none;">
	<!-- <ul class="clearfix"> -->
	<h2 class="nav-tab-wrapper">
<?php

foreach ($post_formats as $format) {
	$class = ($format == $current_post_format || (empty($current_post_format) && $format == 'standard') ? 'current nav-tab-active' : '');
	
	if ($format == 'standard') {
		$format_string = __('Standard', 'mediacenter');
		$format_hash = 'post-format-0';
	}
	else {
		$format_string = get_post_format_string($format);
		$format_hash = 'post-format-'.$format;
	}
	
	// echo '<li><a '.(!empty($class) ? 'class="'.esc_attr($class).'"' : '').' href="#'.esc_attr($format_hash).'">'.esc_html($format_string).'</a></li>';
	echo '<a class="'.esc_attr($class).' nav-tab" href="#'.esc_attr($format_hash).'">'.esc_html($format_string).'</a>';
}

?>
	</h2>
	<!-- </ul> -->
</div>