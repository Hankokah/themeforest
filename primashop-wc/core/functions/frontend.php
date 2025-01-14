<?php 
/**
 * Functions to handle frontends
 *
 * WARNING: This file is part of the core PrimaThemes framework.
 * DO NOT edit this file under any circumstances. 
 *
 * Credits (and Inspirations):
 * - Breadcrumb functions of WooCommerce by WooThemes http://woothemes.com
 *
 * @category   PrimaThemes
 * @package    Framework
 * @subpackage Functions
 * @author     PrimaThemes
 * @link       http://www.primathemes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Remove wordpress generator meta tag for security purpose.
 *
 * @since PrimaThemes 2.0
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Return title for every wordpress conditional tags.
 *
 * @since PrimaThemes 2.0
 */
add_filter( 'wp_title', 'prima_default_title', 10, 3);
function prima_default_title( $title, $sep = '', $seplocation = '' ) {
	if ( is_home() ) $title = get_bloginfo('name');
	global $wp_query;
	$doctitle = '';
	if ( is_404() )
		$doctitle = __('404 - Not Found', 'primathemes');
	elseif ( is_search() )
		$doctitle = sprintf( __( 'Search Results for "%1$s"', 'primathemes' ), esc_attr( get_search_query() ) );
	elseif ( ( is_home() || is_front_page() ) )
		$doctitle = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
	elseif ( is_author() )
		$doctitle = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
	elseif ( is_date() ) {
		if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
			$doctitle = sprintf( __( 'Archive for %1$s', 'primathemes' ), get_the_time( __( 'g:i a', 'primathemes' ) ) );

		elseif ( get_query_var( 'minute' ) )
			$doctitle = sprintf( __( 'Archive for minute %1$s', 'primathemes' ), get_the_time( __( 'i', 'primathemes' ) ) );

		elseif ( get_query_var( 'hour' ) )
			$doctitle = sprintf( __( 'Archive for %1$s', 'primathemes' ), get_the_time( __( 'g a', 'primathemes' ) ) );

		elseif ( is_day() )
			$doctitle = sprintf( __( 'Archive for %1$s', 'primathemes' ), get_the_time( __( 'F jS, Y', 'primathemes' ) ) );

		elseif ( get_query_var( 'w' ) )
			$doctitle = sprintf( __( 'Archive for week %1$s of %2$s', 'primathemes' ), get_the_time( __( 'W', 'primathemes' ) ), get_the_time( __( 'Y', 'primathemes' ) ) );

		elseif ( is_month() )
			$doctitle = sprintf( __( 'Archive for %1$s', 'primathemes' ), single_month_title( ' ', false) );

		elseif ( is_year() )
			$doctitle = sprintf( __( 'Archive for %1$s', 'primathemes' ), get_the_time( __( 'Y', 'primathemes' ) ) );
	}
	elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {
		$post_type = get_post_type_object( get_query_var( 'post_type' ) );
		$doctitle = $post_type->labels->name;
	}
	elseif ( is_category() || is_tag() || is_tax() ) {
		$term = $wp_query->get_queried_object();
		$doctitle = $term->name;
	}
	elseif ( is_singular() ) {
		$post_id = $wp_query->get_queried_object_id();
		$doctitle = get_post_field( 'post_title', $post_id );
	}
	if (get_query_var('paged')) {
		$doctitle .= ' ' . sprintf( __( '- Page %s' , 'primathemes'), get_query_var('paged') );
	}
	$doctitle = esc_attr($doctitle);
	if ($doctitle) return $doctitle;
	else return $title;
}

/**
 * Output content type meta tag.
 *
 * @since PrimaThemes 2.0
 */
add_action( 'wp_head', 'prima_meta_content_type', 0);
function prima_meta_content_type() {
	echo '<meta http-equiv="Content-Type" content="' . get_bloginfo( 'html_type' ) . '; charset=' . get_bloginfo( 'charset' ) . '" />' . "\n";
}

/**
 * Output title tag.
 *
 * @since PrimaThemes 2.0
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	add_action( 'wp_head', 'prima_head_title', 1);
	function prima_head_title() {
		?>
		<title><?php wp_title(); ?></title>
		<?php 
	}
endif;

/**
 * Enqueue theme javascripts file.
 *
 * @since PrimaThemes 2.0
 */
add_action( 'get_header', 'prima_scripts', 100);
function prima_scripts() {
	if (is_singular() && get_option('thread_comments') && comments_open())
		wp_enqueue_script('comment-reply');
	if(file_exists(PRIMA_DIR.'/js/jquery.placeholder.min.js'))
		wp_enqueue_script('jquery-placeholder', PRIMA_URI.'/js/jquery.placeholder.min.js', array('jquery'), '2.0.7', true);
	if(file_exists(PRIMA_DIR.'/js/primathemes.js'))
		wp_enqueue_script('primathemes', PRIMA_URI.'/js/primathemes.js', array('jquery'), PRIMA_THEME_VERSION, true);
}

/**
 * Output dynamic css style.
 *
 * @since PrimaThemes 2.0
 */
add_action( 'wp_head', 'prima_load_custom_styles', 101);
function prima_load_custom_styles() {
	echo '<style type="text/css" media="screen">'."\n";
	echo '/* Custom Styles */ ';
	do_action('prima_custom_styles');
	echo "\n".'</style>'."\n";
}

/**
 * Return current "real" page id.
 *
 * @since PrimaThemes 2.1
 */
function prima_get_real_page_id() {
	global $wp_query;
	$page_id = null;
	if ( class_exists( 'woocommerce' ) && ( is_shop() || is_product_category() || is_product_tag() || is_product_attribute() || is_product() ) ) {
		$page_id = woocommerce_get_page_id( 'shop' );
	}
	elseif ( is_front_page() && get_option('show_on_front') == 'page' && get_option('page_on_front') > 0 )
		$page_id = get_option('page_on_front');
	elseif ( is_home() && get_option('show_on_front') == 'page' && get_option('page_for_posts') > 0 )
		$page_id = get_option('page_for_posts');
	elseif ( is_page() )
		$page_id = $wp_query->post->ID;
	return $page_id;
}

/**
 * Echo breadcrumb.
 *
 * @since PrimaThemes 2.0
 */
function prima_breadcrumb() {
	do_action( 'prima_breadcrumb' );
}

/**
 * Output breadcrumb.
 *
 * @since PrimaThemes 2.0
 */
add_action( 'prima_breadcrumb', 'prima_breadcrumb_output' );
function prima_breadcrumb_output( $args = array() ) {
	$defaults = apply_filters( 'prima_breadcrumb_defaults', array(
		'delimiter'   => ' &#47; ',
		'wrap_before' => '<nav class="breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => __( 'Home', 'primathemes' ),
	) );

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	global $post, $wp_query;

	if ( ( ! is_home() && ! is_front_page() ) || is_paged() ) {

		echo $wrap_before;

		if ( ! empty( $home ) ) {
			echo $before . '<a class="home" href="' . apply_filters( 'prima_breadcrumb_home_url', home_url() ) . '">' . $home . '</a>' . $after . $delimiter;
		}

		do_action( 'prima_breadcrumb_home_after', $args );
		
		if ( is_category() ) {

			$cat_obj = $wp_query->get_queried_object();
			$this_category = get_category( $cat_obj->term_id );

			if ( $this_category->parent != 0 ) {
				$parent_category = get_category( $this_category->parent );
				echo get_category_parents($parent_category, TRUE, $delimiter );
			}

			echo $before . single_cat_title( '', false ) . $after;

		} 
		elseif ( is_tax() ) {

			$queried_object = $wp_query->get_queried_object();
			echo $before . $queried_object->name . $after;
		
		}
		elseif ( is_day() ) {

			echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after . $delimiter;
			echo $before . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $after . $delimiter;
			echo $before . get_the_time('d') . $after;

		} 
		elseif ( is_month() ) {

			echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after . $delimiter;
			echo $before . get_the_time('F') . $after;

		} 
		elseif ( is_year() ) {

			echo $before . get_the_time('Y') . $after;

		} 
		elseif ( is_single() && !is_attachment() ) {

			if ( get_post_type() != 'post' ) {

				if ( get_post_type_archive_link( get_post_type() ) ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug = $post_type->rewrite;
						echo $before . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . $post_type->labels->singular_name . '</a>' . $after . $delimiter;
				}

			} 
			else {

				$cat = current( get_the_category() );
				if ( !empty($cat) ) {
					echo get_category_parents( $cat, true, $delimiter );
				}

			}
			
			echo $before . get_the_title() . $after;

		} 
		elseif ( is_404() ) {

			echo $before . __( 'Error 404', 'primathemes' ) . $after;

		} 
		elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

			$post_type = get_post_type_object( get_post_type() );

			if ( $post_type )
				echo $before . $post_type->labels->singular_name . $after;

		} 
		elseif ( is_attachment() ) {

			if ( $post->post_parent ) {
				$parent = get_post( $post->post_parent );
				echo $before . '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $after . $delimiter;
			}
			echo $before . get_the_title() . $after;

		} 
		elseif ( is_page() && !$post->post_parent ) {

			echo $before . get_the_title() . $after;

		} 
		elseif ( is_page() && $post->post_parent ) {

			$parent_id  = $post->post_parent;
			$breadcrumbs = array();

			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id  = $page->post_parent;
			}

			$breadcrumbs = array_reverse( $breadcrumbs );

			foreach ( $breadcrumbs as $crumb )
				echo $crumb . '' . $delimiter;

			echo $before . get_the_title() . $after;

		} 
		elseif ( is_search() ) {

			echo $before . __( 'Search results for &ldquo;', 'primathemes' ) . get_search_query() . '&rdquo;' . $after;

		} 
		elseif ( is_tag() ) {

				echo $before . __( 'Posts tagged &ldquo;', 'primathemes' ) . single_tag_title('', false) . '&rdquo;' . $after;

		} 
		elseif ( is_author() ) {

			$userdata = get_userdata($author);
			echo $before . __( 'Author:', 'primathemes' ) . ' ' . $userdata->display_name . $after;

		}

		if ( get_query_var( 'paged' ) )
			echo ' (' . __( 'Page', 'primathemes' ) . ' ' . get_query_var( 'paged' ) . ')';

		echo $wrap_after;

	}	
}

/**
 * Return characters-limited post content.
 *
 * @since PrimaThemes 2.0
 */
function prima_get_content_limit($max_char, $more_link_text = '[more...]', $stripteaser = 0) {
	$content = get_the_content( '', $stripteaser );
	$content = preg_replace( "~(?:\[/?)[^/\]]+/?\]~s", '', $content );
	$content = wp_kses( $content, array() );
	if ( strlen($content) > $max_char ) {
		$content = substr($content, 0, $max_char + 1);
		$content = trim(substr($content, 0, strrpos($content, ' ')));
		$content .= __( ' &hellip;', 'primathemes' );
	}
	if ( $more_link_text ) {
		$link = apply_filters( 'get_the_content_more_link', sprintf( '<a href="%s" class="more-link">%s</a>', get_permalink(), $more_link_text ) );
		$output = sprintf('<p>%s %s</p>', $content, $link);
	}
	else {
		$link = '';
		$output = sprintf('<p>%s</p>', $content);
	}
	return apply_filters('prima_get_content_limit', $output, $content, $link, $max_char);
}

/**
 * Echo characters-limited post content.
 *
 * @since PrimaThemes 2.0
 */
function prima_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0) {
	$content = prima_get_content_limit($max_char, $more_link_text, $stripteaser);
	echo apply_filters('prima_content_limit', $content);
}

/**
 * Return characters-limited post excerpt.
 *
 * @since PrimaThemes 2.0
 */
function prima_get_excerpt_limit($max_char, $more_link_text = '[more...]') {
	$content = get_the_excerpt();
	$content = preg_replace( "~(?:\[/?)[^/\]]+/?\]~s", '', $content );
	$content = wp_kses( $content, array() );
	if ( strlen($content) > $max_char ) {
		$content = substr($content, 0, $max_char + 1);
		$content = trim(substr($content, 0, strrpos($content, ' ')));
		$content .= __( ' &hellip;', 'primathemes' );
	}
	if ( $more_link_text ) {
		$link = apply_filters( 'get_the_excerpt_more_link', sprintf( '<a href="%s" class="more-link">%s</a>', get_permalink(), $more_link_text ) );
		$output = sprintf('<p>%s %s</p>', $content, $link);
	}
	else {
		$link = '';
		$output = sprintf('<p>%s</p>', $content);
	}
	return apply_filters('prima_get_excerpt_limit', $output, $content, $link, $max_char);
}

/**
 * Echo characters-limited post excerpt.
 *
 * @since PrimaThemes 2.0
 */
function prima_excerpt_limit($max_char, $more_link_text = '(more...)') {
	$content = prima_get_excerpt_limit($max_char, $more_link_text);
	echo apply_filters('prima_excerpt_limit', $content);
}

/**
 * Output dynamic javascript to the bottom.
 *
 * @since PrimaThemes 2.0
 */
add_action('wp_footer', 'prima_load_custom_scripts', 100);
function prima_load_custom_scripts() {
	echo '<script type="text/javascript">';
	echo "\n/* <![CDATA[ */ \n";
	echo "/* ".__('Custom Scripts', 'primathemes')." */ \n";
	do_action('prima_custom_scripts');
	echo "/* ]]> */ \n";
	echo "</script> \n";
}

/**
 * Output dynamic javascript for specific shortcodes.
 *
 * @since PrimaThemes 2.0
 */
add_action('prima_custom_scripts', 'prima_print_shortcodes_scripts', 100);
function prima_print_shortcodes_scripts() {
	global $prima_shortcodes_scripts;
	echo $prima_shortcodes_scripts;
}
