<?php
/**
 * Grouped Product Add to Cart
 * @version 2.1.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

// Put grouped products into an array
$grouped_products = array();
$quantites_required = false;

do_action( 'woocommerce_before_add_to_cart_form' );

foreach ( $product->get_children() as $child_id ) {
	$child_product = $product->get_child( $child_id );

	if ( ! $child_product->is_sold_individually() && ! $child_product->is_type('external') )
		$quantites_required = true;

	$grouped_products[] = array(
		'product' => $child_product,
		'availability' => $child_product->get_availability()
	);
}
?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="cart" method="post" enctype='multipart/form-data'>
	<table cellspacing="0" class="group_table">
		<tbody>
			<?php foreach ( $grouped_products as $child_product ) : ?>
				<tr>
					<td>
						<?php if ( $child_product['product']->is_type('external') ) :

							$product_url = get_post_meta( $child_product['product']->id, '_product_url', true );
							$button_text = get_post_meta( $child_product['product']->id, '_button_text', true );
							?>

							<a href="<?php echo $product_url; ?>" rel="nofollow" class="button alt"><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></a>

						<?php elseif ( ! $quantites_required ) : ?>

							<button type="submit" name="quantity[<?php echo $child_product['product']->id; ?>]" value="1" class="button alt"><?php echo  yiw_get_option( 'shop_button_addtocart_label', __('Add to cart', 'yiw')) ?></button>

						<?php else : ?>

							<?php woocommerce_quantity_input( array( 'input_name' => 'quantity['.$child_product['product']->id.']', 'input_value' => '0' ) ); ?>

						<?php endif; ?>
					</td>

					<td class="label"><label for="product-<?php echo $child_product['product']->id; ?>"><?php

						if ($child_product['product']->is_visible())
							echo '<a href="'.get_permalink($child_product['product']->id).'">' . $child_product['product']->get_title() . '</a>';
						else
							echo $child_product['product']->get_title();

					?></label></td>

					<td class="price"><?php echo $child_product['product']->get_price_html(); ?>
					<?php echo apply_filters( 'woocommerce_stock_html', '<small class="stock '.$child_product['availability']['class'].'">'.$child_product['availability']['availability'].'</small>', $child_product['availability']['availability'] , $product ); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

    <?php if ( $quantites_required ) : ?>

		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<button type="submit" class="button alt"><?php echo apply_filters('single_add_to_cart_text',  yiw_get_option( 'shop_button_addtocart_label', __('Add to cart', 'yiw')) , $product->product_type); ?></button>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<?php endif; ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>