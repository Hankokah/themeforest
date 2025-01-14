<?php
global $wp_query, $jaw_data, $post;
jaw_template_inc_counter('pagination');
$backup_query = $wp_query;
$wp_query = null;
$wp_query = jaw_template_get_data();

if (!have_posts()) {
    ?>
    <div class="notice">
        <p class="bottom"><?php _e('We are sorry, no results were found. You can try to find some related posts using the search function.', 'jawtemplates'); ?></p>
    </div>
    <?php get_search_form();
    ?>	
<?php } ?>

<div class="jaw_blog">
    <div class="row elements_iso jaw_paginated_<?php echo jaw_template_get_counter('pagination'); ?>">


        <?php
        
        $col = jaw_template_get_var('box_size', jwLayout::parseColWidth());
        if ($col == 'max') {
            $col = jwLayout::parseColWidth();
        }

        while (have_posts()) {
            the_post();
            ?>

            <?php
            $type = get_post_meta(get_the_ID(), 'portfolio_type', true);
            echo jaw_get_template_part('content-portfolio-' . $type, 'custom-posts');

            ?>

        <?php }
        ?>

    </div>                       
</div>
<div class="clear"></div>

<?php echo jwRender::pagination(jaw_template_get_var('pagination', jwOpt::get_option('blog_pagination', 'number'))); ?>

<?php
$wp_query = null;
$wp_query = $backup_query;
wp_reset_postdata();
?>





