<?php
/**
 * Shop Breadcrumb
 * @version 2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

$delimiter   = ' &rsaquo; ';
$wrap_before = '<div id="breadcrumb">';
$wrap_after  = '</div>';

?>
<?php if ( $breadcrumb ) : ?>

    <?php echo $wrap_before; ?>

    <?php foreach ( $breadcrumb as $key => $crumb ) : ?>

        <?php echo $before; ?>

        <?php if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) : ?>
            <?php echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>'; ?>
        <?php else : ?>
            <?php echo esc_html( $crumb[0] ); ?>
        <?php endif; ?>

        <?php echo $after; ?>

        <?php if ( sizeof( $breadcrumb ) !== $key + 1 ) : ?>
            <?php echo $delimiter; ?>
        <?php endif; ?>

    <?php endforeach; ?>

    <?php echo $wrap_after; ?>

<?php endif; ?>