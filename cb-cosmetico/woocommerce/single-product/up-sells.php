<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = array();
$meta_query[] = $woocommerce->query->visibility_meta_query();
$meta_query[] = $woocommerce->query->stock_status_meta_query();

$woo_relatedup_n=esc_attr(get_option('cb5_woo_relatedup_n'));
$woo_relatedup_c=esc_attr(get_option('cb5_woo_relatedup_c'));

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page' 		=> $woo_relatedup_n,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $woo_relatedup_c;

if ( $products->have_posts() ) : ?>

<div class="upsells related products">

	<h2>
	<?php _e( 'You may also like', 'cb-cosmetico' ) ?>
	</h2>

	<?php woocommerce_product_loop_start(); ?>

	<?php while ( $products->have_posts() ) : $products->the_post(); ?>

	<?php woocommerce_get_template_part( 'content', 'product' ); ?>

	<?php endwhile; // end of the loop. ?>

	<?php woocommerce_product_loop_end(); ?>

</div>

	<?php endif;

	wp_reset_postdata();
