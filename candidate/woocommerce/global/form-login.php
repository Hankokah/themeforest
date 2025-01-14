<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() ) 
	return;
?>
<form method="post" class="login checkout-login-form animate-onscroll" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>

	<div class="row inline-inputs">
		<div class="col-lg-6 col-md-6 col-sm-6">
			<label for="username"><?php _e( 'Username or email', 'candidate' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="username" id="username" />
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6">
			<label for="password"><?php _e( 'Password', 'candidate' ); ?> <span class="required">*</span></label>
			<input class="input-text" type="password" name="password" id="password" />
		</div>
	
	</div>
	
	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<p class="form-row">
		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'candidate' ); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
		<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> 
		<label for="rememberme" class="inline" style="margin-bottom: 0;">
			<?php _e( 'Remember me', 'candidate' ); ?>
		</label>
	</p>
	<p class="lost_password">
		<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'candidate' ); ?></a>
	</p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>