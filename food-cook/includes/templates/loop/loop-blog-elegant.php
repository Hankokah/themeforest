<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Loop - Blog Elegant
 *
 * This is the loop file used on the "Blog" page template.
 *
 * @package WooFramework
 * @subpackage Template
 */
global $more; $more = 0; 

woo_loop_before();
 if (isset($_POST['auth_name'])) { 
$author = $_POST['auth_name'];
}
// Fix for the WordPress 3.0 "paged" bug.
$paged = 1;
if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
if ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
$paged = intval( $paged );

$query_args = array(
					'post_type' => 'post',
					'paged' => $paged,
					'author_name' => $author
					
				);
 
 if (isset($_GET['auth_name'])) { 

$query_args = array(
					'post_type' => 'post',
					'paged' => $paged,
					'posts_per_page' => -1, 
					'author_name' => $author
					
				);

 }
 else {
$query_args = array(
					'post_type' => 'post',
					'paged' => $paged,
					'author_name' => $author
					
				);
 }


$query_args = apply_filters( 'woo_blog_template_query_args', $query_args ); // Do not remove. Used to exclude categories from displaying here.

remove_filter( 'pre_get_posts', 'woo_exclude_categories_homepage', 10 );

query_posts( $query_args );

		
if ( have_posts() ) { $count = 0;
?>

<div class="fix"></div>

<?php
	while ( have_posts() ) { the_post(); $count++;

  	dahz_get_template( 'content', 'content-elegant-post' );	

	} // End WHILE Loop
	woo_pagenav();

} else {
	dahz_get_template( 'content', 'content-noposts' );
} // End IF Statement

wp_reset_query();

woo_loop_after();

?>
