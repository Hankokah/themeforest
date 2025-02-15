<?php
/**
 * The template for displaying search forms in StagFramework
 *
 * @package StagFramework
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'stag' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'stag' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'stag' ); ?>">
	</label>
	<input type="hidden" name="post_type" value="product">
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'stag' ); ?>">
</form>
