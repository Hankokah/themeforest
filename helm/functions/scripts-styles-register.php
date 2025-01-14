<?php
//Common Scripts
function LoadCommonScripts() {
		global $is_IE;
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'superfish', MTHEME_JS . '/menu/superfish.js?v=1.0', array( 'jquery' ),null, true );
		wp_enqueue_script( 'hoverintent', MTHEME_JS . '/menu/hoverIntent.js?v=1.0', array( 'jquery' ),null, true );
		wp_enqueue_script( 'qtips', MTHEME_JS . '/jquery.tipsy.js?v=1.0', array( 'jquery' ),null, true );
		wp_enqueue_script( 'prettyPhoto', MTHEME_JS . '/jquery.prettyPhoto.js?v=1.0', array( 'jquery' ),null, true );
		wp_enqueue_script( 'twitter', MTHEME_JS . '/jquery.tweet.js?v=1', array( 'jquery' ),null, true );
		wp_enqueue_script( 'EasingScript', MTHEME_JS . '/jquery.easing.min.js', array( 'jquery' ),null, true );
		wp_enqueue_script( 'portfolioloader', MTHEME_JS . '/page-elements.js', array( 'jquery' ), null,false );
		if($is_IE) {
			wp_enqueue_script( 'ResponsiveJQIE', MTHEME_JS . '/css3-mediaqueries.js', array('jquery'),null, true );
		}
		wp_enqueue_script( 'custom', MTHEME_JS . '/common.js?v=1.0', array( 'jquery' ),null, true );
}
//Common Styles
function LoadCommonStyles() {
		wp_enqueue_style( 'MainStyle', MTHEME_STYLESHEET . '/style.css',false, 'screen' );
		if ( ! MTHEME_BUILDMODE ) {
			wp_enqueue_style( 'Open_Sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' );
		}
		wp_enqueue_style( 'PrettyPhoto', MTHEME_CSS . '/prettyPhoto.css', array( 'MainStyle' ), false, 'screen' );
		wp_enqueue_style( 'navMenuCSS', MTHEME_CSS . '/menu/superfish.css', array( 'MainStyle' ), false, 'screen' );	
}
//HTML5 Video player
function JPlayerScripts() {
		wp_enqueue_script( 'jPlayerJS', MTHEME_JS . '/html5player/jquery.jplayer.min.js', array( 'jquery' ),null, true );
		wp_enqueue_style( 'css_jplayer', MTHEME_ROOT . '/css/html5player/jplayer.dark.css', array( 'MainStyle' ), false, 'screen' );
}
//Dark Theme
function DarkTheme() {
	wp_enqueue_style( 'DarkStyle', MTHEME_STYLESHEET . '/style_dark.css', array( 'MainStyle' ), false, 'screen' );
}
//JwScripts
function JWPlayerScripts() {
wp_enqueue_script( 'jwplayer', MTHEME_JS . '/jwplayer/jwplayer.js', array( 'jquery' ),null, true );
}
//FeaturedFlexisliderscripts
function FeaturedFlexiSlideScripts () {
wp_enqueue_script( 'flexislider', MTHEME_JS . '/flexislider/jquery.flexslider.js', array('jquery') , '',true );
wp_enqueue_style( 'featuredflexislider_css', MTHEME_ROOT . '/css/flexislider/flexslider_featured.css', false, 'screen' );
}
//Flexisliderscripts
function FlexiSlideScripts () {
wp_enqueue_script( 'flexislider', MTHEME_JS . '/flexislider/jquery.flexslider.js', array('jquery') , '',true );
wp_enqueue_style( 'flexislider_css', MTHEME_ROOT . '/css/flexislider/flexslider-page.css', false, 'screen' );
}
// jQuery UI
function JqueryUIScript() {
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-ui-accordion');
}
//Contact Form
function contactFormScript() {
wp_enqueue_script( 'contactform', MTHEME_JS . '/contact.js', array( 'jquery' ),null, false );
}
//Responsive
function ResponsiveStyle() {
wp_enqueue_style( 'Responsive', MTHEME_CSS . '/responsive.css',array( 'MainStyle' ),false, 'screen' );
}
//Custom CSS
function CustomStyle() {
wp_enqueue_style( 'CustomStyle', MTHEME_STYLESHEET . '/custom.css',array( 'MainStyle' ),false, 'screen' );
}