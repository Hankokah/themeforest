<?php 
$classes = 'eltd-blog-list-expandable-item eltd-blei-h-1 eltd-blei-post '.$featured_class;
$params = array(
	'external_link' => $external_link,
	'link_target' => 'blank'
);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
	<div class="eltd-post-content" style="background-image: url(' <?php echo flow_elated_kses_img($image[0]); ?> ')">
		<?php if($featured_class != ''){ ?>
			<div class="eltd-featured-triangle-holder">
				<div class="eltd-featured-triangle"></div>
				<span class="icon_star_alt"></span>
			</div>
		<?php } ?>
		<div class="eltd-post-text">
			<div class="eltd-post-text-inner">
				<div class="eltd-link-icon">
					<i class="icon_link"></i>
				</div>
				<?php flow_elated_get_module_template_part('templates/lists/parts/title','blog', '', $params); ?>
				<div class="eltd-post-info-author-holder">
					<?php flow_elated_post_info(array(
						'author' => 'yes',
					));
					?>
				</div>
			</div>
		</div>
		<div class ="eltd-post-info-wrapper">
			<div class="eltd-post-info eltd-left-section">
				<?php flow_elated_post_info(array(
					'date' => 'yes',
					'like' => 'yes'
				))
				?>
			</div>
		</div>
	</div>
</article>