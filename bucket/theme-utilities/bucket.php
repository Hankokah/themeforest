<?php

class bucket {
	/**
	 * This is a modified version of wp_get_archives() function
	 * also it includes the query for month post count from wp_count_posts()
	 *
	 * @param string $type Optional. Post type to retrieve count
	 * @param string $perm Optional. 'readable' or empty.
	 * @return object Number of posts for each month
	 */
	static function wpgrade_count_posts( $type = 'post', $perm = '' ) {
		global $wpdb, $wp_locale;
		$args = '';
		$defaults = array(
			'type' => 'monthly', 'limit' => '',
			'format' => 'html', 'before' => '',
			'after' => '', 'show_post_count' => false,
			'echo' => 1, 'order' => 'DESC',
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
		$join = apply_filters( 'getarchives_join', '', $r );

		$user = wp_get_current_user();

		$cache_key = 'posts-' . $type;

		$query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";
		if ( 'readable' == $perm && is_user_logged_in() ) {
			$post_type_object = get_post_type_object($type);
			if ( !current_user_can( $post_type_object->cap->read_private_posts ) ) {
				$cache_key .= '_' . $perm . '_' . $user->ID;
				$query .= " AND (post_status != 'private' OR ( post_author = '$user->ID' AND post_status = 'private' ))";
			}
		}
		$query .= ' GROUP BY post_status';

		$counts = wp_cache_get( $cache_key, 'counts' );
		if ( false === $counts ) {
			$results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type ), ARRAY_A );
			$counts = array_fill_keys( get_post_stati(), 0 );

			foreach ( $results as $row )
				$counts[ $row['post_status'] ] = $row['num_posts'];

			$counts = (object) $counts;
			wp_cache_set( $cache_key, $counts, 'counts' );
		}

		$query = "
			SELECT YEAR(post_date) AS `year`,
				MONTH(post_date) AS `month`,
				count(ID) as posts
			FROM $wpdb->posts
			     $join
			 WHERE post_type = 'post'
			   AND post_status = 'publish'
			   AND UNIX_TIMESTAMP(post_date) >= UNIX_TIMESTAMP('".\date('Y-m-01', strtotime('-11 months'))."')

			 GROUP BY YEAR(post_date), MONTH(post_date)
			 ORDER BY post_date $order";

		$results = $wpdb->get_results( $query );

		$months_posts = array();
		// create a ref array with the month number as key
		$result_refs = array();
		foreach ($results as &$val) {
			$result_refs[$val->month] = $val;
		}

		$default_months = util::get_latest_twelve_monts();

		$max_posts_nr = 0;

		// loop into all months, check for values and assign names
		foreach ( $default_months as $key ) {
			if (isset($result_refs[$key])) {
				$result = $result_refs[$key];
				$months_posts[$result->month]['url'] = get_month_link( $result->year, $result->month );
				$months_posts[$result->month]['count'] = $result->posts;
				$months_posts[$result->month]['month'] = $wp_locale->get_month_abbrev($wp_locale->get_month($key));

				if ( $result->posts > $max_posts_nr ) $max_posts_nr = $result->posts;
			}
			else { // not in result
				$months_posts[$key] = array(
					'count' => 0,
					'month' => $wp_locale->get_month_abbrev( $wp_locale->get_month($key) )
				);
			}
		}
		return array('max_posts_nr' => $max_posts_nr, 'months' => $months_posts );
	}

	static function has_average_score(){
		if (get_field('enable_review_score') && get_field('score_breakdown')) {
			return true;
		}
		return false;
	}

	/**
	 * Get the score of the current post
	 * @return bool|float
	 */
	static function get_average_score() {

		if (get_field('enable_review_score') && get_field('score_breakdown')):
			$score_sum = 0;
			$score_sum_weighted = 0;
			$scores = 0;
			$weights = 0;
			while (has_sub_fields('score_breakdown')):
				$weight_temp = get_sub_field('weight');
				$score_sum_weighted = $score_sum_weighted + get_sub_field('score')*$weight_temp;
				$weights += $weight_temp;

				$score_sum = $score_sum + get_sub_field('score');
				$scores++;
			endwhile;

			if ($weights > 0) {
				$average = round($score_sum_weighted / $weights, 1);
			} else {
				$average = round($score_sum / $scores, 1);
			}

			return $average;
		endif;

		return false;
	}

	//function borrowed from WP SEO by Yoast so we can make sure that the theme plays nice with this plugin
	//the plugin will now output rel=next links for the first page of the Custom Page Builder
	static function adjacent_rel_link( $rel, $url, $page, $incl_pagination_base ) {
		global $wp_rewrite;
		if ( ! $wp_rewrite->using_permalinks() ) {
			if ( $page > 1 )
				$url = add_query_arg( 'paged', $page, $url );
		} else {
			if ( $page > 1 ) {
				$base = '';
				if ( $incl_pagination_base ) {
					$base = trailingslashit( $wp_rewrite->pagination_base );
				}
				$url = user_trailingslashit( trailingslashit( $url ) . $base . $page );
			}
		}
		/**
		 * Filter: 'wpseo_' . $rel . '_rel_link' - Allow changing link rel output by WP SEO
		 *
		 * @api string $unsigned The full `<link` element.
		 */
		$link = apply_filters( 'wpseo_' . $rel . '_rel_link', '<link rel="' . $rel . '" href="' . esc_url( $url ) . "\" />\n" );

		if ( is_string( $link ) && $link !== '' ) {
			echo $link;
		}
	}

	/**
	 * Echo author page link
	 * @return bool|string
	 */
	static function the_author_posts_link() {
		global $authordata;
		if ( !is_object( $authordata ) )
			return false;
		$link = sprintf(
			'<a href="%1$s" title="%2$s">%3$s</a>',
			esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
			esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
			get_the_author()
		);

		/**
		 * Filter the link to the author page of the author of the current post.
		 *
		 * @since 2.9.0
		 *
		 * @param string $link HTML link.
		 */
		echo apply_filters( 'the_author_posts_link', $link );
	}

	/**
	 * Checks if a post type object needs password aproval
	 *
	 * @return if the form was submited it returns an array with the success status and a message
	 */

	static function is_password_protected(){
		global $post;
		$private_post = array('allowed' => false, 'error' => '');

		if ( isset( $_POST['submit_password']) ) { // when we have a submision check the password and its submision
			if ( isset( $_POST['submit_password_nonce'] ) && wp_verify_nonce( $_POST['submit_password_nonce'], 'password_protection') ) {
				if ( isset ( $_POST['post_password'] ) && !empty($_POST['post_password']) ) { // some simple checks on password
					// finally test if the password submitted is correct
					if ( $post->post_password ===  $_POST['post_password'] ) {
						$private_post['allowed'] = true;

						// ok if we have a correct password we should inform wordpress too
						// otherwise the mad dog will put the password form again in the_content() and other filters
						global $wp_hasher;
						if ( empty( $wp_hasher ) ) {
							require_once(ABSPATH . 'wp-includes/class-phpass.php');
							$wp_hasher = new PasswordHash(8, true);
						}

						setcookie( 'wp-postpass_' . COOKIEHASH, $wp_hasher->HashPassword( stripslashes( $_POST['post_password'] ) ), 0, COOKIEPATH );

					} else {
						$private_post['error'] = '<h4 class="text--error">Wrong Password</h4>';
					}
				}
			}
		}

		return $private_post;
	}

	static function get_post_format_first_image_src(){
		global $post;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];

		if(empty($first_img)){ //Defines a default image
			$first_img = wpgrade::uri("/theme-content/img/default.jpg");
		}
		return $first_img;
	}

	/**
	 * Returns the URL from the post.
	 *
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 * @return string The Link format URL.
	 */
	static function get_content_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}

	static function the_img_tag ($image_src, $image_alt = '', $image_width = false, $image_height = false, $class = '') {
		echo self::get_img_tag($image_src, $image_alt, $image_width, $image_height, $class);
	}

	static function get_img_tag ($image_src, $image_alt = '', $image_width = false, $image_height = false, $class = '') {
		$output = '';

		if (!empty($image_src)) {
			$output .= '<img ';

			if (wpgrade::option('enable_lazy_loading_images')) {
				$class .= ' lazy ';
				$output .= 'data-src="' . $image_src . '" ';
			} else {
				$output .= 'src="' . $image_src . '" ';
			}
			$output .= 'alt="' . $image_alt . '" ';

			if ($image_width !== false) {
				$output .= 'width="' . $image_width . '" ';
			}

			if ($image_height !== false) {
				$output .= 'height="' . $image_height . '" ';
			}

			if (!empty($class)) {
				$output .= ' class="' . $class . '" ';
			}
			$output .= '/>' . PHP_EOL;
		}

		return $output;
	}

	/**
	 * @param array $image
	 * @param int $default
	 *
	 * @return array
	 */
	static function get_image_aspect_ratio( $image, $default = 70 ) {
		$aspect_ratio = $default; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
		if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
			$aspect_ratio = $image[2] * 100/$image[1];
		} else {
			//lets try another way in case Jetpack's Photon is activated
			//when requesting full image size, it will return the dimensions
			$image_for_aspect_ratio = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if (isset($image_for_aspect_ratio[1]) && isset($image_for_aspect_ratio[2]) && $image_for_aspect_ratio[1] > 0) {
				$aspect_ratio = $image_for_aspect_ratio[2] * 100/$image_for_aspect_ratio[1];
			}
		}

		return $aspect_ratio;
	}
}

/**
 * Get the Image - An advanced post image script for WordPress.
 *
 * Get the Image was created to be a highly-intuitive image script that displays post-specific images (an
 * image-based representation of a post).  The script handles old-style post images via custom fields for
 * backwards compatibility.  It also supports WordPress' built-in featured image functionality.  On top of
 * those things, it can automatically set attachment images as the post image or scan the post content for
 * the first image element used.  It can also fall back to a given default image.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package GetTheImage
 * @version 0.7.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2011, Justin Tadlock
 * @link http://justintadlock.com/archives/2008/05/27/get-the-image-wordpress-plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Delete the cache when a post or post metadata is updated. */
add_action( 'save_post', array('wpGrade_Get_The_Image', 'get_the_image_delete_cache_by_post') );
add_action( 'deleted_post_meta', array('wpGrade_Get_The_Image', 'get_the_image_delete_cache_by_meta'), 10, 2 );
add_action( 'updated_post_meta', array('wpGrade_Get_The_Image', 'get_the_image_delete_cache_by_meta'), 10, 2 );
add_action( 'added_post_meta', array('wpGrade_Get_The_Image', 'get_the_image_delete_cache_by_meta'), 10, 2 );

/**
 * The main image function for displaying an image.  It supports several arguments that allow developers to
 * customize how the script outputs the image.
 *
 * The image check order is important to note here.  If an image is found by any specific check, the script
 * will no longer look for images.  The check order is 'meta_key', 'the_post_thumbnail', 'attachment',
 * 'image_scan', 'callback', and 'default_image'.
 *
 * @since 0.1.0
 * @global $post The current post's database object.
 * @param array $args Arguments for how to load and display the image.
 * @return string|array The HTML for the image. | Image attributes in an array.
 */
function wpgrade_get_the_image( $args = array(), $post_id = null ) {
	global $post;

	/* Set the default arguments. */
	$defaults = array(
		'meta_key' => array( 'Thumbnail', 'thumbnail' ),
		'post_id' => is_null( $post_id ) ? $post->ID : $post_id,
		'attachment' => true,
		'the_post_thumbnail' => true, // WP 2.9+ image function
		'size' => 'thumbnail',
		'default_image' => false,
		'order_of_image' => 1,
		'link_to_post' => true,
		'image_class' => false,
		'image_scan' => false,
		'width' => false,
		'height' => false,
		'format' => 'img',
		'meta_key_save' => false,
		'callback' => null,
		'cache' => true,
		'echo' => true,
		'custom_key' => null, // @deprecated 0.6. Use 'meta_key'.
		'default_size' => null, // @deprecated 0.5.  Use 'size'.
	);

	/* Allow plugins/themes to filter the arguments. */
	$args = apply_filters( 'wpgrade_get_the_image_args', $args );

	/* Merge the input arguments and the defaults. */
	$args = wp_parse_args( $args, $defaults );

	/* If $default_size is given, overwrite $size. */
	if ( !is_null( $args['default_size'] ) )
		$args['size'] = $args['default_size']; // Deprecated 0.5 in favor of $size

	/* If $custom_key is set, overwrite $meta_key. */
	if ( !is_null( $args['custom_key'] ) )
		$args['meta_key'] = $args['custom_key']; // Deprecated 0.6 in favor of $meta_key

	/* If $format is set to 'array', don't link to the post. */
	if ( 'array' == $args['format'] )
		$args['link_to_post'] = false;

	/* Extract the array to allow easy use of variables. */
	extract( $args );

	/* Get cache key based on $args. */
	$key = md5( serialize( compact( array_keys( $args ) ) ) );

	/* Check for a cached image. */
	$image_cache = wp_cache_get( $post_id, 'wpgrade_get_the_image' );

	if ( !is_array( $image_cache ) )
		$image_cache = array();

	/* If there is no cached image, let's see if one exists. */
	if ( !isset( $image_cache[$key] ) || empty( $cache ) ) {

		/* If a custom field key (array) is defined, check for images by custom field. */
		if ( !empty( $meta_key ) )
			$image = wpGrade_Get_The_Image::get_the_image_by_meta_key( $args );

		/* If no image found and $the_post_thumbnail is set to true, check for a post image (WP feature). */
		if ( empty( $image ) && !empty( $the_post_thumbnail ) )
			$image = wpGrade_Get_The_Image::get_the_image_by_post_thumbnail( $args );

		/* If no image found and $attachment is set to true, check for an image by attachment. */
		if ( empty( $image ) && !empty( $attachment ) )
			$image = wpGrade_Get_The_Image::get_the_image_by_attachment( $args );

		/* If no image found and $image_scan is set to true, scan the post for images. */
		if ( empty( $image ) && !empty( $image_scan ) )
			$image = wpGrade_Get_The_Image::get_the_image_by_scan( $args );

		/* If no image found and a callback function was given. Callback function must pass back array of <img> attributes. */
		if ( empty( $image ) && !is_null( $callback ) && function_exists( $callback ) )
			$image = call_user_func( $callback, $args );

		/* If no image found and a $default_image is set, get the default image. */
		if ( empty( $image ) && !empty( $default_image ) )
			$image = wpGrade_Get_The_Image::get_the_image_by_default( $args );

		/* If an image was found. */
		if ( !empty( $image ) ) {

			/* If $meta_key_save was set, save the image to a custom field. */
			if ( !empty( $meta_key_save ) )
				wpGrade_Get_The_Image::get_the_image_meta_key_save( $args, $image['src'] );

			/* Format the image HTML. */
			$image = wpGrade_Get_The_Image::get_the_image_format( $args, $image );

			/* Set the image cache for the specific post. */
			$image_cache[$key] = $image;
			wp_cache_set( $post_id, $image_cache, 'wpgrade_get_the_image' );
		}
	}

	/* If an image was already cached for the post and arguments, use it. */
	else {
		$image = $image_cache[$key];
	}

	/* Allow plugins/theme to override the final output. */
	$image = apply_filters( 'wpgrade_get_the_image', $image );

	/* If $format is set to 'array', return an array of image attributes. */
	if ( 'array' == $format ) {

		/* Set up a default empty array. */
		$out = array();

		/* Get the image attributes. */
		$atts = wp_kses_hair( $image, array( 'http' ) );

		/* Loop through the image attributes and add them in key/value pairs for the return array. */
		foreach ( $atts as $att )
			$out[$att['name']] = $att['value'];

		//$out['url'] = $out['src']; // @deprecated 0.5 Use 'src' instead of 'url'.

		/* Return the array of attributes. */
		return $out;
	}

	/* Or, if $echo is set to false, return the formatted image. */
	elseif ( false === $echo ) {
		return $image;
	}

	/* Display the image if we get to this point. */
	echo $image;
}

class wpGrade_Get_The_Image{

	/* Internal Functions */

	/**
	 * Calls images by custom field key.  Script loops through multiple custom field keys.  If that particular key
	 * is found, $image is set and the loop breaks.  If an image is found, it is returned.
	 *
	 * @since 0.7.0
	 * @param array $args Arguments for how to load and display the image.
	 * @return array|bool Array of image attributes. | False if no image is found.
	 */
	static function get_the_image_by_meta_key( $args = array() ) {

		/* If $meta_key is not an array. */
		if ( !is_array( $args['meta_key'] ) ) {

			/* Get the image URL by the single meta key. */
			$image = get_post_meta( $args['post_id'], $args['meta_key'], true );
		}

		/* If $meta_key is an array. */
		elseif ( is_array( $args['meta_key'] ) ) {

			/* Loop through each of the given meta keys. */
			foreach ( $args['meta_key'] as $meta_key ) {

				/* Get the image URL by the current meta key in the loop. */
				$image = get_post_meta( $args['post_id'], $meta_key, true );

				/* If an image was found, break out of the loop. */
				if ( !empty( $image ) )
					break;
			}
		}

		/* If a custom key value has been given for one of the keys, return the image URL. */
		if ( !empty( $image ) )
			return array( 'src' => $image );

		return false;
	}

	/**
	 * Checks for images using a custom version of the WordPress 2.9+ get_the_post_thumbnail() function.
	 * If an image is found, return it and the $post_thumbnail_id.  The WordPress function's other filters are
	 * later added in the self::display_the_image() function.
	 *
	 * @since 0.7.0
	 * @param array $args Arguments for how to load and display the image.
	 * @return array|bool Array of image attributes. | False if no image is found.
	 */
	static function get_the_image_by_post_thumbnail( $args = array() ) {

		/* Check for a post image ID (set by WP as a custom field). */
		$post_thumbnail_id = get_post_thumbnail_id( $args['post_id'] );

		/* If no post image ID is found, return false. */
		if ( empty( $post_thumbnail_id ) )
			return false;

		/* Apply filters on post_thumbnail_size because this is a default WP filter used with its image feature. */
		$size = apply_filters( 'post_thumbnail_size', $args['size'] );

		/* Get the attachment image source.  This should return an array. */
		$image = wp_get_attachment_image_src( $post_thumbnail_id, $size );

		/* Get the attachment excerpt to use as alt text. */
		$alt = trim( strip_tags( get_post_field( 'post_excerpt', $post_thumbnail_id ) ) );

		/* Return both the image URL and the post thumbnail ID. */
		return array( 'src' => $image[0], 'post_thumbnail_id' => $post_thumbnail_id, 'alt' => $alt );
	}

	/**
	 * Check for attachment images.  Uses get_children() to check if the post has images attached.  If image
	 * attachments are found, loop through each.  The loop only breaks once $order_of_image is reached.
	 *
	 * @since 0.7.0
	 * @param array $args Arguments for how to load and display the image.
	 * @return array|bool Array of image attributes. | False if no image is found.
	 */
	static function get_the_image_by_attachment( $args = array() ) {

		/* Get attachments for the inputted $post_id. */
		$attachments = get_children( array( 'post_parent' => $args['post_id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );

		/* If no attachments are found, check if the post itself is an attachment and grab its image. */
		if ( empty( $attachments ) && $args['size'] ) {
			if ( 'attachment' == get_post_type( $args['post_id'] ) ) {
				$image = wp_get_attachment_image_src( $args['post_id'], $args['size'] );
				$alt = trim( strip_tags( get_post_field( 'post_excerpt', $args['post_id'] ) ) );
			}
		}

		/* If no attachments or image is found, return false. */
		if ( empty( $attachments ) && empty( $image ) )
			return false;

		/* Set the default iterator to 0. */
		$i = 0;

		/* Loop through each attachment. Once the $order_of_image (default is '1') is reached, break the loop. */
		foreach ( $attachments as $id => $attachment ) {
			if ( ++$i == $args['order_of_image'] ) {
				$image = wp_get_attachment_image_src( $id, $args['size'] );
				$alt = trim( strip_tags( get_post_field( 'post_excerpt', $id ) ) );
				break;
			}
		}

		/* Return the image URL. */
		return array( 'src' => $image[0], 'alt' => $alt );
	}

	/**
	 * Scans the post for images within the content.  Not called by default with self::get_the_image().  Shouldn't use
	 * if using large images within posts, better to use the other options.
	 *
	 * @since 0.7.0
	 * @param array $args Arguments for how to load and display the image.
	 * @return array|bool Array of image attributes. | False if no image is found.
	 */
	static function get_the_image_by_scan( $args = array() ) {

		/* Search the post's content for the <img /> tag and get its URL. */
		preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

		/* If there is a match for the image, return its URL. */
		if ( isset( $matches ) && !empty( $matches[1][0] ) )
			return array( 'src' => $matches[1][0] );

		return false;
	}

	/**
	 * Used for setting a default image.  The function simply returns the image URL it was given in an array.
	 * Not used with self::get_the_image() by default.
	 *
	 * @since 0.7.0
	 * @param array $args Arguments for how to load and display the image.
	 * @return array|bool Array of image attributes. | False if no image is found.
	 */
	static function get_the_image_by_default( $args = array() ) {
		return array( 'src' => $args['default_image'] );
	}

	/**
	 * Formats an image with appropriate alt text and class.  Adds a link to the post if argument is set.  Should
	 * only be called if there is an image to display, but will handle it if not.
	 *
	 * @since 0.7.0
	 * @param array $args Arguments for how to load and display the image.
	 * @param array $image Array of image attributes ($image, $classes, $alt, $caption).
	 * @return string $image Formatted image (w/link to post if the option is set).
	 */
	static function get_the_image_format( $args = array(), $image = false ) {

		/* If there is no image URL, return false. */
		if ( empty( $image['src'] ) )
			return false;

		/* Extract the arguments for easy-to-use variables. */
		extract( $args );

		/* If there is alt text, set it.  Otherwise, default to the post title. */
		$image_alt = ( ( !empty( $image['alt'] ) ) ? $image['alt'] : apply_filters( 'the_title', get_post_field( 'post_title', $post_id ) ) );

		/* If there is a width or height, set them as HMTL-ready attributes. */
		$width = ( ( $width ) ? ' width="' . esc_attr( $width ) . '"' : '' );
		$height = ( ( $height ) ? ' height="' . esc_attr( $height ) . '"' : '' );

		/* Loop through the custom field keys and add them as classes. */
		if ( is_array( $meta_key ) ) {
			foreach ( $meta_key as $key )
				$classes[] = str_replace( ' ', '-', strtolower( $key ) );
		}

		/* Add the $size and any user-added $image_class to the class. */
		$classes[] = $size;
		$classes[] = $image_class;

		/* Join all the classes into a single string and make sure there are no duplicates. */
		$class = join( ' ', array_unique( $classes ) );

		/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
		if ( !empty( $image['post_thumbnail_id'] ) )
			do_action( 'begin_fetch_post_thumbnail_html', $post_id, $image['post_thumbnail_id'], $size );

		/* Add the image attributes to the <img /> element. */
		$html = '<img src="' . $image['src'] . '" alt="' . esc_attr( strip_tags( $image_alt ) ) . '" class="' . esc_attr( $class ) . '"' . $width . $height . ' />';

		/* If $link_to_post is set to true, link the image to its post. */
		if ( $link_to_post )
			$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( apply_filters( 'the_title', get_post_field( 'post_title', $post_id ) ) ) . '">' . $html . '</a>';

		/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
		if ( !empty( $image['post_thumbnail_id'] ) )
			do_action( 'end_fetch_post_thumbnail_html', $post_id, $image['post_thumbnail_id'], $size );

		/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
		if ( !empty( $image['post_thumbnail_id'] ) )
			$html = apply_filters( 'post_thumbnail_html', $html, $post_id, $image['post_thumbnail_id'], $size, '' );

		return $html;
	}

	/**
	 * Saves the image URL as the value of the meta key provided.  This allows users to set a custom meta key
	 * for their image.  By doing this, users can trim off database queries when grabbing attachments or get rid
	 * of expensive scans of the content when using the image scan feature.
	 *
	 * @since 0.6.0
	 * @param array $args Arguments for how to load and display the image.
	 * @param array $image Array of image attributes ($image, $classes, $alt, $caption).
	 */
	static function get_the_image_meta_key_save( $args = array(), $image = array() ) {

		/* If the $meta_key_save argument is empty or there is no image $url given, return. */
		if ( empty( $args['meta_key_save'] ) || empty( $image['src'] ) )
			return;

		/* Get the current value of the meta key. */
		$meta = get_post_meta( $args['post_id'], $args['meta_key_save'], true );

		/* If there is no value for the meta key, set a new value with the image $url. */
		if ( empty( $meta ) )
			add_post_meta( $args['post_id'], $args['meta_key_save'], $image['src'] );

		/* If the current value doesn't match the image $url, update it. */
		elseif ( $meta !== $image['src'] )
			update_post_meta( $args['post_id'], $args['meta_key_save'], $image['src'], $meta );
	}

	/**
	 * Deletes the image cache for the specific post when the 'save_post' hook is fired.
	 *
	 * @since 0.7.0
	 */
	static function get_the_image_delete_cache_by_post( $post_id ) {
		wp_cache_delete( $post_id, 'wpgrade_get_the_image' );
	}

	/**
	 * Deletes the image cache for a specific post when the 'added_post_meta', 'deleted_post_meta',
	 * or 'updated_post_meta' hooks are called.
	 *
	 * @since 0.7.0
	 */
	static function get_the_image_delete_cache_by_meta( $meta_id, $post_id ) {
		wp_cache_delete( $post_id, 'wpgrade_get_the_image' );
	}

	/**
	 * @since 0.1.0
	 * @deprecated 0.3.0
	 */
	static function get_the_image_link( $deprecated = '', $deprecated_2 = '', $deprecated_3 = '' ) {
		self::get_the_image();
	}

	/**
	 * @since 0.3.0
	 * @deprecated 0.7.0
	 */
	static function image_by_custom_field( $args = array() ) {
		return self::get_the_image_by_meta_key( $args );
	}

	/**
	 * @since 0.4.0
	 * @deprecated 0.7.0
	 */
	static function image_by_the_post_thumbnail( $args = array() ) {
		return self::get_the_image_by_post_thumbnail( $args );
	}

	/**
	 * @since 0.3.0
	 * @deprecated 0.7.0
	 */
	static function image_by_attachment( $args = array() ) {
		return self::get_the_image_by_attachment( $args );
	}

	/**
	 * @since 0.3.0
	 * @deprecated 0.7.0
	 */
	static function image_by_scan( $args = array() ) {
		return self::get_the_image_by_scan( $args );
	}

	/**
	 * @since 0.3.0
	 * @deprecated 0.7.0
	 */
	static function image_by_default( $args = array() ) {
		return self::get_the_image_by_default( $args );
	}

	/**
	 * @since 0.1.0
	 * @deprecated 0.7.0
	 */
	static function display_the_image( $args = array(), $image = false ) {
		return self::get_the_image_format( $args, $image );
	}

	/**
	 * @since 0.5.0
	 * @deprecated 0.7.0 Replaced by cache delete functions specifically for the post ID.
	 */
	static function get_the_image_delete_cache() {
		return;
	}


	/**
	 * We check if there is a gallery shortcode in the content, extract it and
	 * display it in the form of a slideshow.
	 */
	static function gallery_slideshow($current_post, $template = null) {
		if ($template === null) {

			$image_scale_mode = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_image_scale_mode', true);
			$slider_transition = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_transition', true);
			$slider_autoplay = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_autoplay', true);
			if($slider_autoplay)
				$slider_delay = get_post_meta($current_post->ID, wpgrade::prefix() . 'post_slider_delay', true);

			$template = '<div class="wp-gallery" data-royalslider data-customarrows data-sliderpauseonhover data-slidertransition="' . $slider_transition . '" ';
			$template .= ' data-imagescale="' . $image_scale_mode . '" ';
			if($slider_autoplay){
				$template .= ' data-sliderautoplay="" ';
				$template .= ' data-sliderdelay="' . $slider_delay . '" ';
			}
			if($image_scale_mode != 'fill'){
				$template .= ' data-imagealigncenter ';
			}
			$template .= '>:gallery</div>';
		}

		// first check if we have a meta with a gallery
		$gallery_ids = array();
		$gallery_ids = get_post_meta( $current_post->ID, wpgrade::prefix() . 'main_gallery', true );

		if ( ! empty($gallery_ids)) {
			//recreate the gallery shortcode
			$gallery = '[gallery ids="'.$gallery_ids.'"]';

			if (strpos($gallery, 'style') === false) {
				$gallery = str_replace("]", " style='big_thumb' size='blog-big' link='file']", $gallery);
			}

			$shrtcode = do_shortcode($gallery);

			if (!empty($shrtcode)) {
				return strtr($template, array(':gallery' => $shrtcode));
			} else {
				return null;
			}
		}
		else { // empty gallery_ids
			// search for the first gallery shortcode
			$gallery_matches = null;
			preg_match("!\[gallery.+?\]!", $current_post->post_content, $gallery_matches);

			if ( ! empty($gallery_matches)) {
				$gallery = $gallery_matches[0];

				if (strpos($gallery, 'style') === false) {
					$gallery = str_replace("]", " style='big_thumb' size='blog-big' link='file']", $gallery);
				}
				$shrtcode = do_shortcode($gallery);

				if (!empty($shrtcode)) {
					return strtr($template, array(':gallery' => $shrtcode));
				} else {
					return null;
				}
			}
			else { // gallery_matches is empty
				return null;
			}
		}
	}

}//wpGrade_Get_The_Image class

function custom_warning_handler($errno, $errstr) {
// do something - nothing right now
}