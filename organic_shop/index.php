<?php get_header(); ?>

	<?php //Display Page Header
		global $wp_query;
		$postid = $wp_query->post->ID;
		echo page_header( get_post_meta($postid, 'qns_page_header_image', true) );
		wp_reset_query();
	?>
	
	<!-- BEGIN .section -->
	<div class="section">
		
		<ul class="columns-content page-content clearfix">
			
			<!-- BEGIN .col-main -->
			<li class="<?php echo sidebar_position('primary-content'); ?>">
		
			<?php load_template( get_template_directory() . '/includes/loop.php' ); ?>
		
			<!-- END .col-main -->
			</li>
				
		<?php get_sidebar(); ?>
		
		</ul>
		
	<!-- END .section -->
	</div>

<?php get_footer(); ?>