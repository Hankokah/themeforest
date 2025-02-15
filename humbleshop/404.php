<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package humbleshop
 */

get_header(); ?>

	<section id="primary" class="content-area container">
		<main id="main" class="site-main row" role="main">

			<section class="error-404 not-found col-xs-12">
				<header class="page-header">
					<h1 class="page-title text-center"><?php _e( 'Oops! That page can&rsquo;t be found.', 'humbleshop' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p class="text-center"><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'humbleshop' ); ?></p>

					<div id="topsearch"><?php get_search_form(); ?></div>
					<hr>
					<div class="row">
					<div class="col-sm-3"><?php the_widget( 'WP_Widget_Recent_Posts' ); ?></div>

					<div class="col-sm-3">
					<?php if ( humbleshop_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'humbleshop' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>	
					</div>

					<div class="col-sm-3">
					<?php
					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'humbleshop' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>	
					</div>

					<div class="col-sm-3"><?php the_widget( 'WP_Widget_Tag_Cloud' ); ?></div>	
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>