<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package berg-wp
 */

if ( ! function_exists( 'berg_wp_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function berg_wp_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'BERG'); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><span class="meta-nav">&larr;</span><?php next_posts_link( __(' Older posts', 'BERG') ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'BERG') ); ?> <span class="meta-nav">&rarr;</span></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'berg_wp_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function berg_wp_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'BERG'); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'BERG') );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'BERG') );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'berg_wp_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function berg_wp_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	// if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
	// 	$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	// }

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		// _x( 'Posted on %s', 'post date', 'BERG'),
		'<span>' . $time_string . '</span>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'BERG'),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	// echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
	echo '<span class="posted-on">' . $posted_on . '</span>';
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function berg_wp_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'berg_wp_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'berg_wp_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so berg_wp_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so berg_wp_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in berg_wp_categorized_blog.
 */
function berg_wp_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'berg_wp_categories' );
}
add_action( 'edit_category', 'berg_wp_category_transient_flusher' );
add_action( 'save_post',     'berg_wp_category_transient_flusher' );
