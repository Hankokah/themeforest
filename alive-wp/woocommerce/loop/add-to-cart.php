<?php
/**
 * Loop Add to Cart
 */
 
global $product; 

if( $product->get_price() === '' && $product->product_type != 'external' ) return;
?>

<?php if ( ! $product->is_in_stock() ) : ?>
		
	<a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ); ?>" class="button theme small"><?php echo apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', 'woocommerce' ) ); ?></a>

<?php else : ?>
	
	<?php 
	
		switch ( $product->product_type ) {
			case "variable" :
				$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', 'woocommerce') );
			break;
			case "grouped" :
				$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
				$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', 'woocommerce') );
			break;
			case "external" :
				$link 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
				$label 	= apply_filters( 'external_add_to_cart_text', __('Read More', 'woocommerce') );
			break;
			default :
				$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
				$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', 'woocommerce') );
			break;
		}
	
		printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button %s small add_to_cart_button product_type_%s">%s</a>', $link, $product->id, of_get_option('blog_button_color'), $product->product_type, $label);

	?>

<?php endif; ?>