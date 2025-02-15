<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     19.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' || YSettings::g('woocommerce_show_rating_on_related', 1) != 1)
	return;
?>

<?php
$count   = $product->get_rating_count();
$average = $product->get_average_rating();

if ( $count > 0 ) : ?>
	
<div class="rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	<span title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>"><span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%"></span></span>
</div>

<?php endif; ?>