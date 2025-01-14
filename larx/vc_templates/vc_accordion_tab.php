<?php
$output = $title = '';

extract(shortcode_atts(array(
	'title' => __("Section", "js_composer")
), $atts));

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base'], $atts );
//$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';
//    $output .= "\n\t\t\t\t" . '<h3 class="wpb_accordion_header ui-accordion-header"><a href="#'.sanitize_title($title).'">'.$title.'</a></h3>';
//    $output .= "\n\t\t\t\t" . '<div class="wpb_accordion_content ui-accordion-content vc_clearfix">';
//        $output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
//        $output .= "\n\t\t\t\t" . '</div>';
//    $output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_accordion_section') . "\n";
   
$rand_id = rand(1,99999); 

$output .= '<div class="panel panel-default"><div class="panel-heading" role="tab" id="heading'.$rand_id.'"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$rand_id.'" aria-expanded="true" aria-controls="#collapse'.$rand_id.'">'.$title.'</a></h4></div><div id="collapse'.$rand_id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$rand_id.'"><div class="panel-body">'.wpb_js_remove_wpautop($content).'</div></div></div>';

echo $output;
