<?php
$output = $title = $interval = $el_class = '';
extract(shortcode_atts(array(
    'title' => '',
    'interval' => 0,
    'style' => 'style1',
    'el_class' => ''
), $atts));

wp_enqueue_script('jquery-ui-tabs');

$el_class = $this->getExtraClass($el_class);

$element = 'wpb_tabs';
if ( 'vc_tour' == $this->shortcode) $element = 'wpb_tour';

// Extract tab titles
preg_match_all( '/vc_tab title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();

/**
 * vc_tabs
 *
 */
switch ($style) {
	case 'style2':
		if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
		$tabs_nav = '';
		$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix '.$style.'">';
		foreach ( $tab_titles as $tab ) {
		    preg_match('/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
		    if(isset($tab_matches[1][0])) {
		        $tabs_nav .= '<li><a href="#tab-'. (isset($tab_matches[3][0]) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) .'">' . $tab_matches[1][0] . '</a></li>';

		    }
		}
		$tabs_nav .= '</ul>'."\n";

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );

		$output .= "\n\t".'<div class="'.$css_class.' '.$style.'" data-interval="'.$interval.'">';
		$output .= "\n\t\t".'<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
		$output .= wpb_widget_title(array('title' => $title, 'extraclass' => $element.'_heading'));
		$output .= "\n\t\t\t".$tabs_nav;
		$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
		if ( 'vc_tour' == $this->shortcode) {
		    $output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav vc_clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="'.esc_html__('Previous slide', 'wp_nuvo').'">'.esc_html__('Previous slide', 'wp_nuvo').'</a></span> <span class="wpb_next_slide"><a href="#next" title="'.esc_html__('Next slide', 'wp_nuvo').'">'.esc_html__('Next slide', 'wp_nuvo').'</a></span></div>';
		}
		$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.$this->endBlockComment($element);

		echo $output;
		break;
	case 'style3':
		if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
		$tabs_nav = '';
		$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix '.$style.'">';
		foreach ( $tab_titles as $tab ) {
		    preg_match('/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
		    if(isset($tab_matches[1][0])) {
		        $tabs_nav .= '<li><a href="#tab-'. (isset($tab_matches[3][0]) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) .'">' . $tab_matches[1][0] . '</a></li>';

		    }
		}
		$tabs_nav .= '</ul>'."\n";

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );

		$output .= "\n\t".'<div class="'.$css_class.' '.$style.'" data-interval="'.$interval.'">';
		$output .= "\n\t\t".'<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
		$output .= wpb_widget_title(array('title' => $title, 'extraclass' => $element.'_heading'));
		$output .= "\n\t\t\t".$tabs_nav;
		$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
		if ( 'vc_tour' == $this->shortcode) {
		    $output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav vc_clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="'.esc_html__('Previous slide', 'wp_nuvo').'">'.esc_html__('Previous slide', 'wp_nuvo').'</a></span> <span class="wpb_next_slide"><a href="#next" title="'.esc_html__('Next slide', 'wp_nuvo').'">'.esc_html__('Next slide', 'wp_nuvo').'</a></span></div>';
		}
		$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.$this->endBlockComment($element);

		echo $output;
		break;
	default:
		if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
		$tabs_nav = '';
		$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix '.$style.'">';
		foreach ( $tab_titles as $tab ) {
		    preg_match('/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
		    if(isset($tab_matches[1][0])) {
		        $tabs_nav .= '<li><a href="#tab-'. (isset($tab_matches[3][0]) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) .'">' . $tab_matches[1][0] . '</a></li>';

		    }
		}
		$tabs_nav .= '</ul>'."\n";

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );

		$output .= "\n\t".'<div class="'.$css_class.' '.$style.'" data-interval="'.$interval.'">';
		$output .= "\n\t\t".'<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
		$output .= wpb_widget_title(array('title' => $title, 'extraclass' => $element.'_heading'));
		$output .= "\n\t\t\t".$tabs_nav;
		$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
		if ( 'vc_tour' == $this->shortcode) {
		    $output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav vc_clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="'.esc_html__('Previous slide', 'wp_nuvo').'">'.esc_html__('Previous slide', 'wp_nuvo').'</a></span> <span class="wpb_next_slide"><a href="#next" title="'.esc_html__('Next slide', 'wp_nuvo').'">'.esc_html__('Next slide', 'wp_nuvo').'</a></span></div>';
		}
		$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.$this->endBlockComment($element);

		echo $output;
		break;
}
		