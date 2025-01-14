<?php
/**
 * The post archive page template file
 *
 * @package		WordPress
 * @subpackage	Experience
 * @since		Experience 1.0
 **/ 

// Save theme options array to variable for use in this file
$experience_theme_array = experience_get_options();

get_header(); ?>

<!-- BEGIN .section-wrapper -->
<section class="section-wrapper">
	
	<?php $parallax = $parallax_speed = $parallax_image = $video_bg_url = $flexbox_class = '';
	$wrapper_attributes = array();
	$css_classes = array();
	
	if ( $experience_theme_array['search-header-parallax'] == "1" ) {
		
		$parallax = 'content-moving';
		$parallax_speed = '1.5';
		
		if ( 
			isset( $experience_theme_array['search-header-parallax-speed'] ) 
			&& $experience_theme_array['search-header-parallax-speed'] != ''
		) {
			$parallax_speed = $experience_theme_array['search-header-parallax-speed'];
		}
		
		if ( 
			isset( $experience_theme_array['search-header-background-image'] ) 
			&& $experience_theme_array['search-header-background-image']['url'] != ''
		) {
			$parallax_image = $experience_theme_array['search-header-background-image']['url'];
		}
		
		if ( 
			isset( $experience_theme_array['search-header-background-video'] ) 
			&& $experience_theme_array['search-header-background-video'] != ''
		) {
			$video_bg_url = $experience_theme_array['search-header-background-video'];
		}
		
		$has_video_bg = ( ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

		if ( $has_video_bg ) {
			$parallax_image = $video_bg_url;
			$css_classes[] = ' vc_video-bg-container';	
		}

		if ( ! empty( $parallax ) ) {
			$wrapper_attributes[] = 'data-vc-parallax="'. esc_attr( $parallax_speed ) .'"';
			$css_classes[] = 'vc_general vc_parallax vc_parallax-'. esc_attr( $parallax );
			$css_classes[] = 'js-vc_parallax-o-fixed';
		}

		if ( ! empty( $parallax_image ) ) {
			$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image ) . '"';
		}
		if ( ! $parallax && $has_video_bg ) {
			$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
		}
		
	}

	// Set colour scheme
	if ( isset( $experience_theme_array['search-header-color-scheme'] )
		&& $experience_theme_array['search-header-color-scheme'] != "" 
	) {		
		$css_classes[] = 'color-scheme-'. $experience_theme_array['search-header-color-scheme'];
	} else {
		$css_classes[] = 'color-scheme-3';	
	}

	// Set section header size
	if ( $experience_theme_array['search-header-type'] == 'fill' ) {
		$flexbox_before = '<div class="exp_ie-flexbox-fixer"><div class="exp-full-height exp-flexbox exp-content-middle"><div class="exp-flexbox-inner">';
		$flexbox_after = '</div></div></div>';
	} ?>
	
	<!-- BEGIN .section-header -->
	<div class="section-header <?php echo esc_attr( implode( ' ', $css_classes ) ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
		
		<?php if (
			isset( $experience_theme_array['search-header-background-image']['url'] )
			&& ( !function_exists( 'vc_asset_url' ) || $experience_theme_array['search-header-parallax'] != "1" )
		) {
			experience_get_background( $experience_theme_array['search-header-background-image']['url'] );
		} ?>
		
		<?php echo $flexbox_before; ?>
		
			<!-- BEGIN .section-header-content -->
			<div class="section-header-content padding-h narrow-width">
				
				<h1 class="heading-title"><?php esc_html_e( "Search Results", 'experience' ); ?></h1>
				
				<p class="heading-subtitle"><?php printf( esc_html__( 'Showing search results for "%s"', 'experience' ), get_search_query() ); ?></p>
			
			</div>
			<!-- END .section-header-content -->
			
			<?php if (
				isset( $experience_theme_array['search-header-scroll-link'] )
				&& $experience_theme_array['search-header-scroll-link'] == "1"
			) {	?>		
				<span class="section-scroll-link">
					<span class="funky-icon-arrow-down"></span>
				</span>		
			<?php } ?>
		
		<?php echo $flexbox_after; ?>
		
	</div>
	<!-- END .section-header -->
	
	<?php if (
		isset( $experience_theme_array['search-posts-color-scheme'] )
		&& $experience_theme_array['search-posts-color-scheme'] != ""
	) {		
		$color_scheme = 'color-scheme-'. $experience_theme_array['search-posts-color-scheme'];
	} else {
		$color_scheme = '';
	} ?>
	
	<!-- BEGIN .section-content-wrapper -->
	<div class="section-content-wrapper <?php echo esc_attr( $color_scheme ); ?>">
		
		<?php get_template_part( 'templates/loop' ); ?>
		
		<?php experience_pagination_links(); ?>
	
	</div>
	<!-- END .section-content-wrapper -->
	
</section>
<!-- END .section-wrapper -->

<?php get_footer(); ?>