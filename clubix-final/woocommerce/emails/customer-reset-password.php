<?php
/**
 * Customer Reset Password email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<p><?php _e( 'Someone requested that the password be reset for the following account:', LANGUAGE_ZONE ); ?></p>
<p><?php printf( __( 'Username: %s', LANGUAGE_ZONE ), $user_login ); ?></p>
<p><?php _e( 'If this was a mistake, just ignore this email and nothing will happen.', LANGUAGE_ZONE ); ?></p>
<p><?php _e( 'To reset your password, visit the following address:', LANGUAGE_ZONE ); ?></p>
<p>
    <a href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'login' => rawurlencode( $user_login ) ), wc_get_endpoint_url( 'lost-password', '', get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) ); ?>">
			<?php _e( 'Click here to reset your password', LANGUAGE_ZONE ); ?></a>
</p>
<p></p>

<?php do_action( 'woocommerce_email_footer' ); ?>