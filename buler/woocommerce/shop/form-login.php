<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     99.99
 */

global $woocommerce;

if (is_user_logged_in()) return;
?>
<form method="post" class="login">
	<?php if ($message) echo wpautop(wptexturize($message)); ?>

	<p class="form-row form-row-first">
		<label for="username"><?php _e('Username or email', 'buler'); ?> <span class="required">*</span></label>
		<input type="text" class="input-text" name="username" id="username" />
	</p>
	<p class="form-row form-row-last">
		<label for="password"><?php _e('Password', 'buler'); ?> <span class="required">*</span></label>
		<input class="input-text" type="password" name="password" id="password" />
	</p>
	<div class="clear"></div>

	<p class="form-row">
		<?php $woocommerce->nonce_field('login', 'login') ?>
		<input type="submit" class="button" name="login" value="<?php _e('Login', 'buler'); ?>" />
		<input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
		<a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url( home_url() ) ); ?>"><?php _e('Lost Password?', 'buler'); ?></a>
	</p>

	<div class="clear"></div>
</form>