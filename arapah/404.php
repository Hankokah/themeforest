<?php
/**
 * @package WordPress
 * @subpackage Arapah-WP
 */

get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title ?>

	<div class="container">

		<div class="two-thirds column">
			<div class="gutter alpha">
				<section id="content">

					<article id="post-0" class="error404">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'Arapah-WP' ); ?></h1>
						</header>

						<div class="entry-content">
						  <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'Arapah-WP' ); ?></p>

							 <?php get_search_form(); ?>

							 <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

							<div class="widget">
								 <h2 class="widgettitle"><?php _e( 'Most Used Categories', 'themename' ); ?></h2>
													 <ul>
													 <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 'TRUE', 'title_li' => '', 'number' => '10' ) ); ?>
													 </ul>
							</div>

							<?php
							$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'Arapah-WP' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
							?>

						</div><!-- .entry-content -->
						
					</article><!-- #post-0 -->

				</section><!-- #content -->
			</div><!-- .gutter .alpha -->
		</div><!-- .two-thirds .column -->
		
		<?php get_template_part( 'sidebar', 'index' ); //the Sidebar ?>
        
	</div>

<?php get_footer(); ?>