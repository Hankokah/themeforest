<?php
/**
 * Bootstrap Wordpress Breadcrumbs
 *
 * @package Wordpress
 * @subpackage Spritz
 * @since 3.4.0
 */

function bootstrapwp_breadcrumbs() {

	$delimiter 	= '<span class="divider"><i class="icon-double-angle-right"></i></span>';
	$home 		= 'Home'; // text for the 'Home' link
	$before 	= '<li class="active">'; // tag before the current crumb
	$after 		= '</li>'; // tag after the current crumb

	if ( ! is_home() && ! is_front_page() || is_paged() ) {
		echo '<nav><ul class="breadcrumb">';

		global $post;
		$homeLink = home_url();
		echo '<li><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' </li>';

		if ( is_category() ) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category( $thisCat );
			$parentCat = get_category( $thisCat->parent );
			if ( $thisCat->parent != 0 )
				echo get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ' );
			echo $before . 'Archive by category "' . single_cat_title( '', false ) . '"' . $after;

		} elseif ( is_day() ) {

			echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . '</li>';
			echo '<li><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li> ' . $delimiter . ' ';
			echo $before . get_the_time( 'd' ) . $after;

		} elseif ( is_month() ) {

			echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . '</li>';
			echo $before . get_the_time( 'F' ) . $after;

		} elseif ( is_year() ) {

			echo $before . get_the_time( 'Y' ) . $after;

		} elseif ( is_single() && ! is_attachment() ) {

			if ( get_post_type() == 'event') {
				$post_type 	= get_post_type_object( get_post_type() );
				$slug 		= $post_type->rewrite;
				echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . '</li>';
				$cats = get_the_term_list( get_the_ID(), 'event-category', '<li>', $delimiter , $delimiter . ' </li>');
				echo $cats;
				echo $before . get_the_title() . $after;
			} elseif ( get_post_type() != 'post' ) {
				$post_type 	= get_post_type_object( get_post_type() );
				$slug 		= $post_type->rewrite;
				echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . '</li>';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				echo '<li>'.get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' ).'</li>';
				echo $before . get_the_title() . $after;
			}

		} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {

			$post_type = get_post_type_object( get_post_type() );
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( false && is_attachment() ) {

			$parent = get_post( $post->post_parent );
			$cat = get_the_category( $parent->ID );
			$cat = $cat[0];
			echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
			echo '<li><a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a> ' . $delimiter . '</li>';
			echo $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {

			echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {

			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>' . $delimiter . '</li>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			foreach ( $breadcrumbs as $crumb )
				echo $crumb . ' ' .  ' ';
			echo $before . get_the_title() . $after;

		} elseif ( is_search() ) {

			echo $before . 'Search results for "' . get_search_query() . '"' . $after;

		} elseif ( is_tag() ) {

			echo $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;

		} elseif ( is_author() ) {

			global $author;
			$userdata = get_userdata( $author );
			echo $before . 'Articles posted by ' . $userdata->display_name . $after;

		} elseif ( is_404() ) {
			echo $before . 'Error 404' . $after;
		}

		if ( get_query_var( 'paged' ) ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo ' (';
			echo __( 'Page', 'spritz' ) . ' ' . get_query_var( 'paged' );
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo ')';
		}

		echo '</ul></nav>';

	}
} // end bootstrapwp_breadcrumbs()
?>