<?php
/**
 * Order tracking
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
    $status = get_term_by('slug', $order->status, 'shop_order_status');

    $order_status_text = sprintf( __('Order %s which was made %s has the status &ldquo;%s&rdquo;', 'yit'), $order->get_order_number(), human_time_diff(strtotime($order->order_date), current_time('timestamp')) . ' ' . __('ago', 'yit'), __($status->name, 'yit') );

    if ($order->status == 'completed') $order_status_text .= ' ' . __('and was completed', 'yit') . ' ' . human_time_diff(strtotime($order->completed_date), current_time('timestamp')).__(' ago', 'yit');

    $order_status_text .= '.';

    echo wpautop( esc_attr( apply_filters('woocommerce_order_tracking_status', $order_status_text, $order ) ) );
?>

<?php
    $notes = $order->get_customer_order_notes();
    if ($notes) :
        ?>
        <h2><?php _e('Order Updates', 'yit'); ?></h2>
        <ol class="commentlist notes">
            <?php foreach ($notes as $note) : ?>
            <li class="comment note">
                <div class="comment_container">
                    <div class="comment-text">
                        <p class="meta"><?php echo date_i18n('l jS \of F Y, h:ia', strtotime($note->comment_date)); ?></p>
                        <div class="description">
                            <?php echo wpautop(wptexturize($note->comment_content)); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php
    endif;
?>

<?php do_action( 'woocommerce_view_order', $order->id ); ?>