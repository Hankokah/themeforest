<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 )
	return;
?>
<div class="woocommerce-pagination pagination">
	<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base' 			=> esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format' 		=> '',
			'add_args'     => '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '<div class="previous"><i class="icons icon-left-dir"></i></div>',
			'next_text' 	=> '<div class="next"><i class="icons icon-right-dir"></i></div>',
			'type'			=> 'plain',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) ) );
	?>
</div>