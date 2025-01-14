<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ($price_html = $product->get_price_html()) : ?>
	<p class="product-price"><?php echo $price_html; ?></p>
<?php endif; ?>