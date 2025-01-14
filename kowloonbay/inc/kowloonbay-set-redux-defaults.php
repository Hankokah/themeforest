<?php 

/* Redux Framework: default values */
function kowloonbay_set_redux_defaults()
{
	global $kowloonbay_redux_opts;

	$kowloonbay_redux_defaults = array(
		"general_disable_visual_editor" => "1",
		"general_use_as_logo" => "html",
		"general_logo_html" => "<strong>Kowloon</strong>Bay",
		"general_logo_img" => '',
		"general_auto_adjust_header_height" => "0",
		"general_enable_preloader" => "1",
		"general_preloader_spinner" => "8",
		"general_transition_duration" => "0.3s",
		"general_meta_keywords" => "Keyword1, Keyword2, Keyword3",
		"general_meta_description" => "A short and accurate summary of the content of this webpage in a single line.",
		"general_footer_content" => '<!-- The HTML codes of other social icons are available at the code snippets page. --><ul class="social list-inline"><li><a href="#" class="facebook" data-hover="&#xf09a;"><i class="fa fa-facebook"></i></a></li><li><a href="#" class="twitter" data-hover="&#xf099;"><i class="fa fa-twitter"></i></a></li><li><a href="#" class="linkedin" data-hover="&#xf0e1;"><i class="fa fa-linkedin"></i></a></li><li><a href="#" class="google-plus" data-hover="&#xf0d5;"><i class="fa fa-google-plus"></i></a></li></ul><p class="copyright">Copyright &copy; 2014. All rights reserved.</p>',
		"general_custom_css" => "",
		"general_google_analytics_tracking_id" => "",
		"typography_body_text" => array(
									"font-size" => "14px",
									"font-family" => "Raleway",
									"font-weight" => "400",
									"line-height" => "23px"
									),
		"typography_body_light_font_weight" => "200",
		"typography_body_medium_font_weight" => "400",
		"typography_body_heavy_font_weight" => "800",
		"typography_body_text_letter_spacing" => "1px",
		"typography_title_text" => array(
									"font-family" => "Montserrat"
									),
		"typography_title_medium_font_weight" => "400",
		"typography_title_heavy_font_weight" => "700",
		"typography_enable_webkit_subpixel_antialiasing" => "0",
		"dim_base_line_height" => "23px",
		"dim_base_height" => "@baseLineHeight*12",
		"dim_page_padding_h" => "@baseLineHeight*3",
		"dim_page_padding_v" => "@baseLineHeight*4",
		"dim_multi_level_menu_border_radius" => "4px",
		"dim_gutter_width" => "6px",
		"color_scheme_primary_color" => "#cabaa7",
		"color_scheme_bg_color" => "#ffffff",
		"color_scheme_home_bg_color" => "@titleTextColor",
		"color_scheme_body_text_color" => "#444444",
		"color_scheme_title_text_color" => "#222222",
		"color_scheme_preloader_bg_color" => "@titleTextColor",
		"color_scheme_icon_color" => "fadeout(desaturate(@primaryColor, 100%), 50%)",
		"color_scheme_link_color" => "@primaryColor",
		"color_scheme_link_hover_color" => "spin(@primaryColor, 180)",
		"color_scheme_image_hover_overlay_color" => "@titleTextColor",
		"color_scheme_image_hover_overlay_opacity" => "0.5",
		"color_scheme_footer_text_color" => "fadeout(@bodyTextColor, 50%)",
		"homepage_youtube_or_html5" => "youtube",
		"homepage_bg_video_poster" => "",
		"homepage_youtube_url" => "",
		"homepage_youtube_quality" => "default",
		"homepage_youtube_mute" => "1",
		"homepage_youtube_loop" => "0",
		"homepage_youtube_opacity" => "1",
		"homepage_youtube_start_at" => "",
		"homepage_youtube_stop_at" => "",
		"homepage_bg_video_mp4" => "",
		"homepage_bg_video_webm" => "",
		"homepage_bg_video_ogv" => "",
		"portfolio_layout" => "h",
		"portfolio_boxed" => "0",
		"portfolio_infinite_scroll" => "1",
		"portfolio_posts_per_page" => "6",
		"portfolio_masonry_base_col_grid" => "3",
		"portfolio_ordering" => "ASC",
		"portfolio_hide_cat_icon" => "0",
		"portfolio_cat_all_label" => "All",
		"portfolio_cat_all_icon" => "fa-th",
		"portfolio_show_related_projects" => "1",
		"portfolio_related_projects_label" => "Related Projects",
		"portfolio_video_posters_always_cover" => "1",
		"portfolio_use_high_res_video_posters" => "1",
		"team_max_col" => "4",
		"team_show_others" => "1",
		"team_label_others" => "Other Team Members",
		"blog_layout" => "masonry",
		"blog_post_full_width" => "1",
		"blog_clickable_block" => "1",
		"blog_infinite_scroll" => "1",
		"blog_pagination_align" => "center",
		"blog_label_continue_reading" => "Continue Reading",
		"blog_show_prev_next" => "1",
		"blog_toolbar_items" => array(
								"a" => "1",
								"c" => "1",
								"t" => "1",
								"s" => "1"
								),
		"blog_toolbar_fa_icon_archive" => "fa-calendar",
		"blog_toolbar_fa_icon_cats" => "fa-bookmark-o",
		"blog_toolbar_fa_icon_tags" => "fa-tags",
		"blog_toolbar_fa_icon_search" => "fa-search",
		"blog_toolbar_label_archive" => "Archive",
		"blog_toolbar_label_cats" => "Categories",
		"blog_toolbar_label_tags" => "Tags",
		"blog_toolbar_label_search" => "Search",
		"blog_infobar_items" => array(
								"d" => "1",
								"a" => "0",
								"c" => "1",
								"co" => "1"
								),
		"blog_infobar_fa_icon_date" => "fa-calendar",
		"blog_infobar_fa_icon_author" => "fa-user",
		"blog_infobar_fa_icon_cat" => "fa-bookmark-o",
		"blog_infobar_fa_icon_comments" => "fa-comments-o",
		"blog_link_fa_icon" => "fa-link",
		"blog_quote_fa_icon" => "fa-quote-left",
		"blog_status_fa_icon" => "fa-comment-o",
		"google_maps_lat" => "22.323663",
		"google_maps_long" => "114.214035",
		"google_maps_zoom" => "15",
		"google_maps_styled" => "1",
		"google_maps_marker_icon" => '',
		"google_maps_marker_animation" => "none",
		"google_maps_gamma" => "1.75",
		"google_maps_saturation" => "-100",
		"google_maps_lightness" => "-10",
		"google_maps_invert_lightness" => "1",
		"google_maps_disable_default_ui" => "0",
		"google_maps_scrollwheel" => "0",
		"google_maps_info_window_content_string" => "'<h4>Info Window</h4>' + '<p>You can add content here</p>'",
		"breadcrumb_icon" => "fa-caret-right",
		"breadcrumb_home_label" => "Home",
		"breadcrumb_portfolio_display" => "1",
		"breadcrumb_portfolio_display_cat" => "1",
		"breadcrumb_portfolio_page" => "",
		"breadcrumb_portfolio_label" => "Portfolio",
		"breadcrumb_team_display" => "1",
		"breadcrumb_team_page" => "",
		"breadcrumb_team_label" => "Team",
		"breadcrumb_services_display" => "1",
		"breadcrumb_services_page" => "",
		"breadcrumb_services_label" => "Services",
		"animation_section_heading" => "flipInX",
		"animation_section_desc" => "fadeIn",
		"animation_section_desc_apply_to_letter" => "0",
		"animation_item_array" => "fadeInRight",
		"animation_portfolio_slider" => "rotateOutUpRight",
		"animation_team_member_photo_left" => "rotateInUpRight",
		"animation_team_member_photo_right" => "rotateInUpLeft",
		"animation_blog_post_title" => "fadeInUp",
		"animation_parallax_initial" => "background-position:50% 30%;",
		"animation_parallax_final" => "background-position:50% 70%;",
		"duration_carousel_single_item_autoplay_timeout" => "3000",
		"duration_carousel_multiple_items_autoplay_timeout" => "3000",
		"duration_carousel_related_items_autoplay_timeout" => "3000",
		"duration_carousel_blog_gallery_autoplay_timeout" => "3000",
		"misc_services_listing_mode" => 'horizontal',
		"misc_loading_fa_icon" => "fa-circle-o-notch",
		"misc_faq_label_expand_all" => "Expand All",
		"misc_faq_label_collapse_all" => "Collapse All",
		"misc_testimonials_profile_pic_img_style" => "img-circle",
		"misc_404_content" => "<h2>404 - Page Not Found</h2><p>The page you requested could not be found on our server.</p>",
		"misc_rs_custom_hide_whitespaces" => "0",
		"misc_rs_custom_less" => "0",
		"misc_disable_query_vars" => "1",
	);

	foreach ($kowloonbay_redux_defaults as $k => $v) {
		if ( isset( $kowloonbay_redux_opts[$k] ) === false ){
			$kowloonbay_redux_opts[$k] = $v;
		}
	}
}