<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $smof_data;

get_header(); ?>
<section id="midsection" class="container">
	<div class="row">
    
		<?php 
        $class = ($smof_data['sellya_product_page_design'] == 1) ? 'span12' : 'span9 single-with-sidebar';
        
        if($smof_data['sellya_product_page_design'] != 1 and $smof_data['sellya_product_page_design'] != 3 ):
    
            get_leftbar('left'); 
        
        endif;
        
        ?>
        
        <div id="content" class="<?php echo $class?>">
            <div class="row-fluid">
                <div class="breadcrumb">
                <?php
                    /**
                     * woocommerce_before_main_content hook
                     *
                     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                     * @hooked woocommerce_breadcrumb - 20
                     */
                    do_action('woocommerce_before_main_content');
                ?>
                </div><!--.breadcrumb -->
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

                <?php endwhile; // end of the loop. ?>

                <?php
                    /**
                     * woocommerce_after_main_content hook
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action('woocommerce_after_main_content');
                ?>

                <?php
                    /**
                     * woocommerce_sidebar hook
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */
                    //do_action('woocommerce_sidebar');
                ?>
            </div>
        </div>
        
        <?php 
		if($smof_data['sellya_product_page_design'] != 1 and $smof_data['sellya_product_page_design'] != 2 ):

            get_leftbar('left'); 
        
        endif;
		?>
        
	</div>
</section>

<?php get_footer(); ?>