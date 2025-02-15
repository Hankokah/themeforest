<?php get_header(); 
	$default_sidebar = $theme_prefix['blog_sidebar']; // Default Sidebar ?>
<div class="fitvids container clearfix">
	<div class="row">
		<div class="col-lg-12">
			<?php if($theme_prefix['slider-count'] != "sidebar" ){ get_template_part('slider'); } ?>
		</div>
	</div>
	<div class="row clearfix">
        <?php if($theme_prefix['sidebar-type'] == "left" ){ ?> <!-- Sidebar Left (If selected) -->
            <aside class="col-lg-3 col-sm-4 sidebar">
            	<?php if ( is_active_sidebar( $default_sidebar ) ) { ?>
	                <?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($default_sidebar)) :  ?>
	                    <a href="wp-admin/widgets.php"><?php echo __("Please Add Widget <a href='wp-admin/widgets.php'>here</a>","2035Themes-fm") ?></a>
	                <?php endif; ?>
                <?php } ?>
            </aside>
        <?php } ?>

		<?php if($theme_prefix['sidebar-type'] == "none" ){ ?> <div class="col-lg-12 col-sm-12" ><?php } else { ?> <div class="col-lg-9 col-sm-8" > <?php } ?> <!-- Entry Loop -->

			<?php if($theme_prefix['slider-count'] == "sidebar" ){ get_template_part('slider'); } ?>
			<?php if (have_posts()) : while(have_posts()) :  the_post(); ?>
			<?php get_template_part('inc/content'); ?>
			<?php endwhile; else : ?>
			<div class="margint30"><h4><?php echo __('Not Post Found!','2035Themes-fm') ?></h4></div>
			<?php endif; ?>
			<?php Theme2035_pagination(); ?>
		</div>
        
        <?php if($theme_prefix['sidebar-type'] == "right" ){ ?> <!-- Sidebar Right (If selected) -->
            <aside class="col-lg-3 col-sm-4 sidebar">
                <?php if ( is_active_sidebar( $default_sidebar ) ) { ?>
	                <?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($default_sidebar)) :  ?>
	                    <a href="wp-admin/widgets.php"><?php echo __("Please Add Widget <a href='wp-admin/widgets.php'>here</a>","2035Themes-fm") ?></a>
	                <?php endif; ?>
                <?php } ?>
            </aside>
        <?php } ?>
	</div>
</div>
<?php get_footer(); ?>