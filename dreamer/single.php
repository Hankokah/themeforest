<?php get_header(); ?>

<!-- Main Content Starts HERE -->
<div class="page-container pattern-2" id="news">
	<div class="row">      
		<div class="twelve columns news">
			<!-- News Item -->
			<div style="padding-top: 100px;" class="news-section">
			<?php while (have_posts()) : the_post(); ?>
            
            <?php // The following determines what the post format is and shows the correct file accordingly
                $format = get_post_format();
                get_template_part( 'includes/blog-posts/'.$format );
                if($format == '')
                get_template_part( 'includes/blog-posts/image' );
            ?>
            <?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>