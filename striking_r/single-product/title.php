<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woothemes.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$post_id = theme_get_queried_object_id();
$type = get_post_meta($post_id, '_introduce_text_type', true);
if ($type=='default' || empty($type)) {
	$type=theme_get_option('general','introduce');
}
if (empty($type)|| $type==="disable") $tag='h1'; else $tag='h2';
?>
<<?php echo $tag?> itemprop="name" class="product_title entry-title"><?php the_title(); ?></<?php echo $tag?>>
