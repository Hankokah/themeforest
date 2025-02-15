<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) {
	return;
}
?>
<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>
<section class="shipping-calculator-form">
<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
		<p class="form-row form-row-wide" id="calc_shipping_country_field">
            <label class="input-desc"><?php _e("Country","mango") ?></label>
            <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state " rel="calc_shipping_state">
				<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
				<?php
					foreach( WC()->countries->get_shipping_countries() as $key => $value )
						echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				?>
			</select>
		</p>

		<p class="form-row form-group form-row-wide" id="calc_shipping_state_field">
			<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states( $current_cc );

				// Hidden Input
				if ( is_array( $states ) && empty( $states ) ) {

					?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / county', 'woocommerce' ); ?>" /><?php

				// Dropdown Input
				} elseif ( is_array( $states ) ) {

					?><label class="input-desc"><?php _e("State","mango"); ?></label>

						<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / county', 'woocommerce' ); ?>">
							<option value=""><?php _e( 'Select a state&hellip;', 'woocommerce' ); ?></option>
							<?php
								foreach ( $states as $ckey => $cvalue )
									echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' .esc_html( $cvalue ) .'</option>';
							?>
						</select>
					<?php
				// Standard Input
				} else { ?>
                    <label class="input-desc"><?php _e("State","mango"); ?></label>
                    <input type="text" class="form-control input-sm input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / county', 'woocommerce' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php
				}
			?>
		</p>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

			<p class="form-group form-row form-row-wide" id="calc_shipping_city_field">
                <label class="input-desc"><?php _e("City","mango"); ?></label>
				<input type="text" class="form-control input-sm input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'woocommerce' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

			<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                <label class="input-desc"><?php _e( 'Postcode / Zip', 'woocommerce' ); ?></label>
				<input type="text" class="input-text form-control input-sm" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / Zip', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</p>
		<?php endif; ?>

		<button type="submit" name="calc_shipping" value="1" class="button btn btn-custom4 btn-md min-width text-uppercase"><?php _e( 'Calculate Shipping', 'mango' ); ?></button>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
</form>
</section>
<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
