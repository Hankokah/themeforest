<?php
/**
 * The template for displaying Archive pages
 *
 * @package Evential
 * @subpackage Evential
 * @since Evential 1.0
 */

get_header(); ?>
<?php 
	global $tlazya_evential; 
	if (isset($tlazya_evential['inner_url']['url']) && $tlazya_evential['inner_url']['url'] != '' ) { 
?>
<section id="top" class="innder-page" style="background: url(<?php echo esc_url($tlazya_evential['inner_url']['url']); ?>) no-repeat 0% 0%;">
<?php 
	}
	else 
	{
?>
<section id="top" class="innder-page" style="background: url(<?php echo get_template_directory_uri(); ?>/img/register-bg.png) no-repeat 0% 0%;">
<?php
	}
?>
	<div class="container">
		<div class="countdown">
			<div class="row">
                        <?php if ( have_posts() ) : ?>
                            <div class="col-xs-12">
				<div class="counter-title align-center blog-banner">
					<h2 class="uppercase"><?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'evential' ), get_the_date() );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'evential' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'evential' ) ) );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'evential' ), get_the_date( _x( 'Y', 'yearly archives date format', 'evential' ) ) );

						else :
							_e( 'Archives', 'evential' );

						endif;
					?></h2>
				</div>	
			</div>
                    </div><!--/ .row-->
		</div><!--/ .countdown-->
	</div><!--/ .container-->
</section>        
<section id="about">
    <div class="container">
        <div class="col-md-12 blog-all">
			<?php
					// Start the Loop.
					while ( have_posts() ) : the_post(); ?>
			<?php
				if ( has_post_format( 'audio' ))
				{
			?>
            <article class="audio">
				<div class="blog-post-date">
					<?php echo get_post_meta($post->ID, "audio", true); ?>
					<div class="post-date">
						<p><?php echo get_the_date('j'); ?><span><?php echo get_the_time('M'); ?></span></p>
					</div>
				</div>
				<h2><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h2>
				<div class="entry-meta">
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-user"></i> Posted By: <?php echo get_the_author();?></a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-comments"></i> <?php comments_number( '0', '1', '%' ); ?> Comments</a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-list"></i> <?php the_category(' '); ?></a></span>
				</div>
				<p>
					<?php echo substr(get_the_content(), 0, 2000);?>
				</p>
				<div class="button-holder">
					<a class="readmore le-btn" href="<?php echo get_permalink();?>">readmore</a>
				</div>
            </article>
			<div style="clear:both"></div>
			
			<?php
				}
				elseif ( has_post_format( 'video' ))
				{
			?>
			<article>
				<div class="blog-post-date">
					<div class="video-holder">
						<a data-rel="prettyPhoto" href="<?php echo get_post_meta($post->ID, "video", true); ?>">
							<?php echo get_the_post_thumbnail(get_the_ID()); ?>
						</a>
					</div>
					<div class="post-date">
						<p><?php echo get_the_date('j'); ?><span><?php echo get_the_time('M'); ?></span></p>
					</div>
				</div>
				<h2><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h2>
				<div class="entry-meta">
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-user"></i> Posted By: <?php echo get_the_author();?></a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-comments"></i> <?php comments_number( '0', '1', '%' ); ?> Comments</a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-list"></i> <?php the_category(' '); ?></a></span>
				</div>
				<p>
					<?php echo substr(get_the_content(), 0, 2000);?>
				</p>
				<div class="button-holder">
					<a class="readmore le-btn" href="<?php echo get_permalink();?>">readmore</a>
				</div>
                        </article>
			<div style="clear:both"></div>
			<?php
				}
				elseif ( has_post_format( 'image' ))
				{
			?>
			<article>
				<div class="blog-post-date">
					<a href="<?php echo get_permalink();?>">
						<?php
							if(has_post_thumbnail()) {
								echo get_the_post_thumbnail(get_the_ID());
							} else { 
								echo '<img src="http://placehold.it/1090x817" alt="Uncle"/>';
							} 
						?>
					</a>
					<div class="post-date">
						<p><?php echo get_the_date('j'); ?><span><?php echo get_the_time('M'); ?></span></p>
					</div>
				</div>
				<h2><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h2>
				<div class="entry-meta">
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-user"></i> Posted By: <?php echo get_the_author();?></a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-comments"></i> <?php comments_number( '0', '1', '%' ); ?> Comments</a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-list"></i> <?php the_category(' '); ?></a></span>
				</div>
				<p>
					<?php echo substr(get_the_content(), 0, 2000);?>
				</p>
				<div class="button-holder">
					<a class="readmore le-btn" href="<?php echo get_permalink();?>">readmore</a>
				</div>
            </article>
			<div style="clear:both"></div>
			<?php
				}
				else
				{
			?>
			<article class="stand">
				<div class="blog-post-date">
					<?php
					if(has_post_thumbnail()) {
					?>
						<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail(get_the_ID()); ?></a>
					<?php
					}
					else 
					{ 
					?>
						<div class="empty-image"></div>
					<?php 
					} 
					?>
					<div class="post-date">
						<p><?php echo get_the_date('j'); ?><span><?php echo get_the_time('M'); ?></span></p>
					</div>
				</div>
				<h2><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h2>
				<div class="entry-meta">
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-user"></i> Posted By: <?php echo get_the_author();?></a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-comments"></i> <?php comments_number( '0', '1', '%' ); ?> Comments</a></span>
					<span><a href="<?php echo get_permalink();?>"><i class="fa fa-list"></i> <?php the_category(' '); ?></a></span>
				</div>
				<p>
					<?php echo substr(get_the_content(), 0, 2000);?>
				</p>
				<div class="button-holder">
					<a class="readmore le-btn" href="<?php echo get_permalink();?>">readmore</a>
				</div>
            </article>
			<div style="clear:both"></div>
			<?php
				}
			?>
				<?php endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_footer();
