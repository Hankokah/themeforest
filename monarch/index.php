<?php

   /**
    * The main template file
    *
    * This is the most generic template file in a WordPress theme
    * and one of the two required files for a theme (the other being style.css).
    * It is used to display a page when nothing more specific matches a query.
    * e.g., it puts together the home page when no home.php file exists.
    *
    * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
    *
    * @package WordPress
    * @subpackage Monarch
    * @since Monarch 1.0
    */
   
?>

<?php
    get_header();
    get_template_part( 'index-' . get_theme_mod( 'monarch_main_style', 'default' ) );
    get_footer();
?>