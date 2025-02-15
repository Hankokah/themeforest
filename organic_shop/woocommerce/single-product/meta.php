<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<div class="product_meta">

	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option('woocommerce_enable_sku') == 'yes' && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku"><?php _e('SKU:','qns' ); ?> <?php echo $product->get_sku(); ?>.</span>
	<?php endif; ?>
	
	<?php echo $product->get_categories( ', ', ' <span class="posted_in">'.__('Category:','qns' ).' ', '.</span>'); ?>
	
	<?php echo $product->get_tags( ', ', ' <span class="tagged_as">'.__('Tags:','qns' ).' ', '.</span>'); ?>

</div>