<?php
/**
 * Order Customer Details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="krown-column-container span6 clearfix" style="padding-left:40px">

	<h3><?php _e( 'Customer details', 'krown' ); ?></h3>

	<table class="shop_table shop_table_responsive customer_details">
		<?php if ( $order->customer_note ) : ?>
			<tr>
				<th><?php _e( 'Note:', 'krown' ); ?></th>
				<td><?php echo wptexturize( $order->customer_note ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->billing_email ) : ?>
			<tr>
				<th><?php _e( 'Email:', 'krown' ); ?></th>
				<td><?php echo esc_html( $order->billing_email ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->billing_phone ) : ?>
			<tr>
				<th><?php _e( 'Telephone:', 'krown' ); ?></th>
				<td><?php echo esc_html( $order->billing_phone ); ?></td>
			</tr>
		<?php endif; ?>

		<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
	</table>

	<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

	<div class="col2-set addresses">
		<div class="col-1">

	<?php endif; ?>

	<header class="title">
		<h5><?php _e( 'Billing Address', 'krown' ); ?></h5>
	</header>
	<address><p>
		<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'krown' ); ?>
	</p></address>

	<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

		</div><!-- /.col-1 -->
		<div class="col-2">
			<header class="title">
				<h5><?php _e( 'Shipping Address', 'krown' ); ?></h5>
			</header>
			<address>
				<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'krown' ); ?>
			</address>
		</div><!-- /.col-2 -->
	</div><!-- /.col2-set -->

	<?php endif; ?>

</div>