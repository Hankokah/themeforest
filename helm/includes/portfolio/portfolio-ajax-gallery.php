<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="ajax-portfolio-block-wrap">
<?php
$idCount=1;
$columns=4;
?>
<div class="fullpage-contents-wrap">
	<div class="page-container">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<div class="ajax-gallery-navigation clearfix">
					<a class="ajax-navigation-arrow ajax-next" href="#">Next</a>
					<a class="ajax-navigation-arrow ajax-prev" href="#">Prev</a>

				</div>
				<div class="ajax-portfolio-window">
					<div id="ajax-portfolio-wrap"></div>
				</div>
			
			
			<div class="portfolio-works-wrap ajax-top-margin">
					<ul class="portfolio-filter clearfix">
					<li class="current all"><a href="#"><?php _e('All','mthemelocal'); ?></a></li>
					<?php					
					$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
					foreach ($categories as $category){ ?>
					<li class="<?php echo "filter-" . $category->slug;?>"><a href="#"><?php echo $category->name;?></a></li>
					<?php }?>
					</ul>
			</div>

			<div class="portfolio-filter-wrap clearfix">
				<ul class="portfolio-list">
					<?php
					$newquery = array(
						'post_type' => 'mtheme_portfolio',
						'types' => $portfolio_cat_slug,
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'posts_per_page' => -1,
						);
					query_posts($newquery);
					if (have_posts()) : while (have_posts()) : the_post();
					$custom = get_post_custom(get_the_ID());
					$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
					$video_url="";
					$thumbnail="";
					$link_url="";
					if ( isset($custom["video"][0]) ) { $video_url=$custom["video"][0]; }
					if ( isset($custom["thumbnail"][0]) ) { $thumbnail=$custom["thumbnail"][0]; }
					if ( isset($custom["custom_link"][0]) ) { $link_url=$custom["custom_link"][0]; }
					$portfolio_thumb_header=$custom["portfolio_page_header"][0];
					
					if ($portfolio_column_count>$columns) $portfolio_column_count=1;
					
					?>
					<li class="portfolio-col-<?php echo $portfolio_column_count++; ?>" data-portfolio="portfolio-<?php echo $post->ID; ?>" data-id="id-<?php echo $idCount++; ?>" data-type="<?php foreach ($portfolio_cats as $taxonomy) { echo 'filter-' . $taxonomy->slug . ' '; } ?>">
						<span class="ajax-image-selector"></span>
						
						<?php
						if ( $custom["video"][0]<>"" ) {
							$p_class="fadethumbnail-play";
						} elseif ( $custom["custom_link"][0]<>"" ) {
							$p_class="fadethumbnail-link";
						} else {
							$p_class="fadethumbnail-view";
						}
						?>
							<?php
								if ($portfolio_thumb_header=="Slideshow") {
									echo '<a class="portfolio-image-link portfolio-ajax" rel="'.$post->ID.'" ref="'.$video_url.'" >';
									echo '<span class="column-portfolio-icon portfolio-slideshow-icon"></span>';
									} else {							
										if ( $custom["video"][0]<>"" ) { 
											echo '<a class="portfolio-image-link portfolio-ajax" rel="'.$post->ID.'" ref="'.$video_url.'" >';
											echo '<span class="column-portfolio-icon portfolio-video-icon"></span>';
											} elseif ( $custom["custom_link"][0]<>"" ) {
								
												echo '<a class="portfolio-image-link portfolio-ajax" rel="'.$post->ID.'" ref="'.$custom["custom_link"][0].'" >';
												echo '<span class="column-portfolio-icon portfolio-image-icon"></span>';
								
											} else {
											echo '<a class="portfolio-image-link portfolio-ajax" rel="'.$post->ID.'" ref="'.featured_image_link($post->ID).'" >';
											echo '<span class="column-portfolio-icon portfolio-image-icon"></span>';
										}
								}
							?>
							<?php
							// Show Image
							if ($thumbnail<>"") {
								echo '<img src="'.$thumbnail.'" class="preload-image displayed-image" alt="thumbnail" />';
							} else {
								echo display_post_image (
									$post->ID,
									$have_image_url=$thumbnail_image_url,
									$link=false,
									$type="portfolio-medium",
									$post->post_title,
									$class="preload-image displayed-image"
								);
							}
							?>
							<span class="ajax-image-title"><?php the_title(); ?></span>			
							</a>
					</li>
					<?php endwhile; ?>
					<?php endif;?>
			 
				</ul>
			</div>
			<?php
			require ( MTHEME_INCLUDES . 'clients.php' );
			?>
		</div>
	</div>
</div>
</div>