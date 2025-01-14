<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) :
    die ( 'You do not have sufficient permissions to access this page!' );
endif;

/**
 * Page Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `page.php` template file, contextually, as well as in archive lists or search results.
 *
 * @package WooFramework
 * @subpackage Template
 */

/**
 * Settings for this template file.
 *
 * This is where the specify the HTML tags for the title.
 * These options can be filtered via a child theme.
 *
 * @link http://codex.wordpress.org/Plugin_API#Filters
 */
global $woo_options;
 
$page_link_args = apply_filters( 'woothemes_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages : ', 'woothemes' ), 'after' => '</div>' ) );
 
woo_post_before(); ?>

<div <?php post_class(); ?>>

	<?php woo_post_inside_before();	?>

	<div class="entry">
	    <?php
	    	if ( !is_singular() ) :
	    		the_excerpt();
	    	else :
	    		the_content(__('Read More &rarr;', 'woothemes') );
	    	endif;
	    	
	    	wp_link_pages( $page_link_args );
	    ?>
	</div><!-- /.entry -->

	<div class="fix"></div>

	<?php woo_post_inside_after(); ?>

</div><!-- /.post -->

<?php
woo_post_after();
$comm = get_option( 'woo_comments' );

if ( ( $comm == 'page' || $comm == 'both' ) && is_page() ) : 
	comments_template(); 
endif;