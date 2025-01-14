<?php
function pix_add_general() {
	global $options, $posts_per_page;
admin_general();
foreach ($options as $value) :
if(!get_pix_option($value['id'])){
    add_option($value['id'], $value['std']);
}
endforeach;
}

if (is_admin() && isset($_GET['activated'] ) && $pagenow ==	"themes.php" ){

pix_add_general();
wp_redirect(admin_url("admin.php?page=admin_general&activate=true"));
}


function admin_general()
{
    global $options;

	$options = array (
array( "id" => "pix_show_tweets",
	"std" => "show"),
/*########################## GENERAL ##########################*/
array( "id" => "pix_layout_animated",
	"std" => "show"),
array( "id" => "pix_sliding_page",
	"std" => "open_on_load"),
array( "id" => "pix_general_sidebar",
	"std" => "rightsidebar"),
array( "id" => "pix_general_template",
	"std" => "left"),
array( "id" => "pix_header_position",
	"std" => 'fixed'),
array( "id" => "pix_site_title",
	"std" => get_bloginfo( 'name' )),
array( "id" => "pix_site_description",
	"std" => get_bloginfo( 'description' )),
array( "id" => "pix_social_bar",
	"std" => "closed"),
array( "id" => "pix_social_bar",
	"std" => "closed"),
array( "id" => "pix_seach_show",
	"std" => "show"),
array( "id" => "pix_twitter_icon",
	"std" => "show"),
array( "id" => "pix_twitter_url",
	"std" => ''),
array( "id" => "pix_twitter_text",
	"std" => 'Twit us'),
array( "id" => "pix_google_icon",
	"std" => "show"),
array( "id" => "pix_google_url",
	"std" => ''),
array( "id" => "pix_google_text",
	"std" => 'Google+'),
array( "id" => "pix_facebook_icon",
	"std" => "show"),
array( "id" => "pix_facebook_url",
	"std" => ''),
array( "id" => "pix_facebook_text",
	"std" => 'Facebook'),
array( "id" => "pix_tumblr_icon",
	"std" => "0"),
array( "id" => "pix_tumblr_url",
	"std" => ''),
array( "id" => "pix_tumblr_text",
	"std" => 'Tumblr'),
array( "id" => "pix_linkedin_icon",
	"std" => "0"),
array( "id" => "pix_linkedin_url",
	"std" => ''),
array( "id" => "pix_linkedin_text",
	"std" => 'LinkedIn'),
array( "id" => "pix_myspace_icon",
	"std" => "show"),
array( "id" => "pix_myspace_url",
	"std" => ''),
array( "id" => "pix_myspace_text",
	"std" => 'My Space'),
array( "id" => "pix_flickr_icon",
	"std" => "show"),
array( "id" => "pix_flickr_url",
	"std" => ''),
array( "id" => "pix_flickr_text",
	"std" => 'Flickr'),
array( "id" => "pix_youtube_icon",
	"std" => "show"),
array( "id" => "pix_youtube_url",
	"std" => ''),
array( "id" => "pix_youtube_text",
	"std" => 'YouTube'),
array( "id" => "pix_vimeo_icon",
	"std" => "show"),
array( "id" => "pix_vimeo_url",
	"std" => ''),
array( "id" => "pix_vimeo_text",
	"std" => 'Vimeo'),
array( "id" => "pix_behance_icon",
	"std" => "hide"),
array( "id" => "pix_behance_url",
	"std" => ''),
array( "id" => "pix_behance_text",
	"std" => 'Behance'),
array( "id" => "pix_500px_icon",
	"std" => "hide"),
array( "id" => "pix_500px_url",
	"std" => ''),
array( "id" => "pix_500px_text",
	"std" => '500px'),
array( "id" => "pix_soundcloud_icon",
	"std" => "hide"),
array( "id" => "pix_soundcloud_url",
	"std" => ''),
array( "id" => "pix_soundcloud_text",
	"std" => 'SoundCloud'),
array( "id" => "pix_pinterest_icon",
	"std" => "hide"),
array( "id" => "pix_pinterest_url",
	"std" => ''),
array( "id" => "pix_pinterest_text",
	"std" => 'Pinterest'),
array( "id" => "pix_dribbble_icon",
	"std" => "hide"),
array( "id" => "pix_dribbble_url",
	"std" => ''),
array( "id" => "pix_dribbble_text",
	"std" => 'Dribbble'),
array( "id" => "pix_forrst_icon",
	"std" => "hide"),
array( "id" => "pix_forrst_url",
	"std" => ''),
array( "id" => "pix_forrst_text",
	"std" => 'Forrst'),
array( "id" => "pix_skype_icon",
	"std" => "show"),
array( "id" => "pix_skype_id",
	"std" => ''),
array( "id" => "pix_skype_text",
	"std" => 'Skype contact'),
array( "id" => "pix_skype_action",
	"std" => 'call'),
array( "id" => "pix_rss_icon",
	"std" => "show"),
array( "id" => "pix_rss_text",
	"std" => 'RSS'),
array( "id" => "pix_rss_url",
	"std" => get_bloginfo('rss_url')),
array( "id" => "pix_seach_show",
	"std" => "show"),
/*NAVIGATION*/
array( "id" => "pix_nav_position",
	"std" => 'fixed'),
array( "id" => "pix_breadcrumbs_show",
	"std" => 'show'),
/*FOOTER*/
array( "id" => "pix_footer_show",
	"std" => 'show'),
array( "id" => "pix_photocredits_show",
	"std" => 'show'),
array( "id" => "pix_photocommands_show",
	"std" => 'show'),
array( "id" => "pix_footerthumbnail_show",
	"std" => 'show'),
/*SEO*/
array( "id" => "pix_seo_enable",
	"std" => 'true'),
/*MEDIA*/
array( "id" => "pix_audio_external",
	"std" => 'false'),
array( "id" => "pix_video_external",
	"std" => 'false'),
/*SCRIPTS*/
array( "id" => "pix_google_analytics",
	"std" => ''),
array( "id" => "pix_css_inline",
	"std" => 'true'),
array( "id" => "pix_google_prevent",
	"std" => 'show'),
array( "id" => "pix_timthumb_cache",
	"std" => '0'),
array( "id" => "pix_use_timthumb",
	"std" => 'show'),
/*SLIDESHOWS*/
array( "id" => "pix_slideshow_speed",
	"std" => '7000'),
array( "id" => "pix_slideshow_fade",
	"std" => '700'),
array( "id" => "pix_slideshow_adapt",
	"std" => 'false'),
/*########################## TYPOGRAPHY ##########################*/
/*GENERAL*/
array( "id" => "pix_typo_general",
	"std" => 'Cabin'),
array( "id" => "pix_typo_general_own",
	"std" => ''),
array( "id" => "pix_typo_general_fontsize",
	"std" => '12'),
array( "id" => "pix_typo_buttons",
	"std" => 'Cabin'),
array( "id" => "pix_typo_buttons_own",
	"std" => ''),
array( "id" => "pix_typo_h1",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_h1_own",
	"std" => ''),
array( "id" => "pix_typo_h2",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_h2_own",
	"std" => ''),
array( "id" => "pix_typo_h3",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_h3_own",
	"std" => ''),
array( "id" => "pix_typo_h4",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_h4_own",
	"std" => ''),
array( "id" => "pix_typo_h5",
	"std" => 'Cabin'),
array( "id" => "pix_typo_h5_own",
	"std" => ''),
array( "id" => "pix_typo_h6",
	"std" => 'Cabin'),
array( "id" => "pix_typo_h6_own",
	"std" => ''),
/*HEADER*/
array( "id" => "pix_typo_sitetitle",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_sitetitle_own",
	"std" => ''),
array( "id" => "pix_typo_sitedescription_own",
	"std" => ''),
array( "id" => "pix_typo_sitetitle_fontsize",
	"std" => '35'),
array( "id" => "pix_typo_sitedescription",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_sitedescription_fontsize",
	"std" => '18'),
/*NAVIGATION*/
array( "id" => "pix_typo_firstlevellink",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_firstlevellink_own",
	"std" => ''),
array( "id" => "pix_typo_firstlevellink_fontsize",
	"std" => '14'),
array( "id" => "pix_typo_secondlevellink",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_secondlevellink_own",
	"std" => ''),
array( "id" => "pix_typo_secondlevellink_fontsize",
	"std" => '14'),
array( "id" => "pix_typo_thirdlevellink",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_thirdlevellink_own",
	"std" => ''),
array( "id" => "pix_typo_thirdlevellink_fontsize",
	"std" => '12'),
/*FOOTER*/
array( "id" => "pix_typo_logobottom",
	"std" => 'Raleway:100'),
array( "id" => "pix_typo_logobottom_own",
	"std" => ''),
array( "id" => "pix_typo_logobottom_fontsize",
	"std" => '20'),
/*########################## COLORS AND IMAGES ##########################*/
/*SITE BACKGROUND*/
array( "id" => "pix_body_background_color",
	"std" => '#222222'),
array( "id" => "pix_body_background",
	"std" => 'texture'),
array( "id" => "pix_body_background_pattern",
	"std" => 'arabesque'),
array( "id" => "pix_body_background_single_image",
	"std" => ''),
array( "id" => "pix_body_background_single_image_position",
	"std" => 'center top'),
array( "id" => "pix_body_background_single_image_repeat",
	"std" => 'repeat'),
array( "id" => "pix_body_background_single_image_attachment",
	"std" => 'fixed'),
/*OVERLAY PATTERN*/
array( "id" => "pix_overlay_pattern",
	"std" => '2'),
array( "id" => "pix_overlay_pattern_opacity",
	"std" => '0.5'),
/*WIDE BG*/
array( "id" => "pix_general_background",
	"std" => 'none'),
array( "id" => "pix_wide_image_general",
	"std" => ''),
array( "id" => "pix_wide_video_general",
	"std" => ''),
array( "id" => "pix_wide_video_general_start",
	"std" => 'true'),
array( "id" => "pix_wide_video_general_loop",
	"std" => 'true'),
array( "id" => "pix_wide_googlemap_general",
	"std" => ''),
array( "id" => "pix_wide_googlemap_general_zoom",
	"std" => '17'),
array( "id" => "pix_wide_googlemap_indications",
	"std" => ''),
array( "id" => "pix_wide_googlemap_type",
	"std" => 'HYBRID'),
/*GENERAL*/
array( "id" => "pix_favicon_ico",
	"std" => ''),
array( "id" => "pix_content_background",
	"std" => '#ffffff'),
array( "id" => "pix_content_bg_opacity",
	"std" => '1'),
array( "id" => "pix_content_text_color",
	"std" => '#000000'),
array( "id" => "pix_link_color",
	"std" => '#4990af'),
/*HEADER*/
array( "id" => "pix_header_background",
	"std" => '#000000'),
array( "id" => "pix_header_bg_opacity",
	"std" => '1'),
array( "id" => "pix_header_text_color",
	"std" => '#ffffff'),
array( "id" => "pix_header_image_bg",
	"std" => ''),
array( "id" => "pix_header_image_position",
	"std" => '0px 0px'),
array( "id" => "pix_header_image_repeat",
	"std" => 'no-repeat'),
array( "id" => "pix_header_margin",
	"std" => '0px 0px 0px 0px'),
array( "id" => "pix_header_padding",
	"std" => '0px 0px 0px 0px'),
/*1ST MENU*/
array( "id" => "pix_first_level_background",
	"std" => '#ffffff'),
array( "id" => "pix_first_level_opacity",
	"std" => '1'),
array( "id" => "pix_first_level_color",
	"std" => '#000000'),
array( "id" => "pix_first_level_hover",
	"std" => '#888888'),
array( "id" => "pix_first_level_border",
	"std" => '#000000'),
array( "id" => "pix_second_level_background",
	"std" => '#000000'),
array( "id" => "pix_second_level_color",
	"std" => '#ffffff'),
array( "id" => "pix_second_level_hover",
	"std" => '#888888'),
array( "id" => "pix_third_level_background",
	"std" => '#000000'),
array( "id" => "pix_third_level_color",
	"std" => '#ffffff'),
array( "id" => "pix_third_level_hover",
	"std" => '#888888'),
/*2ND MENU*/
array( "id" => "pix_first_level_background_2nd",
	"std" => '#000000'),
array( "id" => "pix_first_level_opacity_2nd",
	"std" => '1'),
array( "id" => "pix_first_level_color_2nd",
	"std" => '#ffffff'),
array( "id" => "pix_first_level_hover_2nd",
	"std" => '#888888'),
array( "id" => "pix_first_level_border_2nd",
	"std" => '#ffffff'),
array( "id" => "pix_second_level_background_2nd",
	"std" => '#ffffff'),
array( "id" => "pix_second_level_color_2nd",
	"std" => '#000000'),
array( "id" => "pix_second_level_hover_2nd",
	"std" => '#888888'),
array( "id" => "pix_third_level_background_2nd",
	"std" => '#ffffff'),
array( "id" => "pix_third_level_color_2nd",
	"std" => '#000000'),
array( "id" => "pix_third_level_hover_2nd",
	"std" => '#888888'),
/*FOOTER*/
array( "id" => "pix_footer_background",
	"std" => '#000000'),
array( "id" => "pix_footer_text_color",
	"std" => '#ffffff'),
array( "id" => "pix_footer_image_bg",
	"std" => ''),
array( "id" => "pix_footer_sitetitle",
	"std" => get_bloginfo( 'name' )),
array( "id" => "pix_footer_credits",
	"std" => '&copy;2011 <a href="http://www.pixedelic.com/" title="Pixedelic" target="_blank">Pixedelic</a> by <a href="http://consorziocreativo.com/" title="Consorzio Creativo" target="_blank">Consorzio Creativo</a>'),
array( "id" => "pix_footer_image_position",
	"std" => '0px 0px'),
array( "id" => "pix_footer_image_repeat",
	"std" => 'no-repeat'),
array( "id" => "pix_footer_padding",
	"std" => '0px 0px 0px 0px'),
array( "id" => "pix_footer_margin",
	"std" => '0px 0px 0px 0px'),
array( "id" => "pix_checkcolorbox",
	"std" => 'show'),
array( "id" => "pix_colorbox_theme",
	"std" => 'black'),
array( "id" => "pix_tooltip_theme",
	"std" => 'youtube'),
/*TYPOGRAPHY*/
array( "id" => "pix_h1_color",
	"std" => '#000000'),
array( "id" => "pix_h2_color",
	"std" => '#000000'),
array( "id" => "pix_h3_color",
	"std" => '#000000'),
array( "id" => "pix_h4_color",
	"std" => '#000000'),
array( "id" => "pix_h5_color",
	"std" => '#000000'),
array( "id" => "pix_h6_color",
	"std" => '#000000'),
/*DIVS, BUTTONS ETC*/
array( "id" => "pix_buttons_bg",
	"std" => '#333333'),
array( "id" => "pix_buttons_color",
	"std" => '#ffffff'),
array( "id" => "pix_buttons_bghover",
	"std" => '#000000'),
array( "id" => "pix_buttons_colorhover",
	"std" => '#ffffff'),
array( "id" => "pix_general_box_bg",
	"std" => '#eeeeee'),
array( "id" => "pix_general_box_bg_hover",
	"std" => '#cccccc'),
array( "id" => "pix_general_light_text_color",
	"std" => '#666666'),
array( "id" => "pix_general_light_text_color_hover",
	"std" => '#888888'),
/*########################## FRONTPAGE ##########################*/
array( "id" => "pix_home_background",
	"std" => "slideshow"),
array( "id" => "pix_wide_image_home",
	"std" => ''),
array( "id" => "pix_wide_video_home",
	"std" => ''),
array( "id" => "pix_wide_video_home_start",
	"std" => 'true'),
array( "id" => "pix_wide_video_home_loop",
	"std" => 'true'),
array( "id" => "pix_wide_googlemap_home",
	"std" => ''),
array( "id" => "pix_wide_googlemap_home_zoom",
	"std" => '17'),
array( "id" => "pix_wide_googlemap_indications_home",
	"std" => ''),
array( "id" => "pix_wide_googlemap_type_home",
	"std" => 'HYBRID'),
array( "id" => "pix_sliding_frontpage",
	"std" => "closed"),
array( "id" => "pix_frontpage_posttype",
	"std" => "posts"),
array( "id" => "pix_frontpage_posttype_categories",
	"std" => "all"),
array( "id" => "pix_frontpage_posttype_galleries",
	"std" => "all"),
array( "id" => "pix_frontpage_galleries_template",
	"std" => "onecolumn"),
array( "id" => "pix_frontpage_galleries_filterable",
	"std" => "show"),
array( "id" => "pix_frontpage_galleries_scrolling",
	"std" => "show"),
array( "id" => "pix_frontpage_galleries_colorbox",
	"std" => "show"),
array( "id" => "pix_frontpage_galleries_slideshow",
	"std" => "show"),
array( "id" => "pix_frontpage_galleries_gotopage",
	"std" => "show"),
array( "id" => "pix_frontpage_length_excerpt",
	"std" => '50'),
array( "id" => "pix_frontpage_content_excerpt",
	"std" => 'excerpt'),
array( "id" => "pix_frontpage_featured_image",
	"std" => '0'),
array( "id" => "pix_frontpage_galleries_ppp",
	"std" => get_pix_option('posts_per_page')),
array( "id" => "pix_frontpage_posts_image_link",
	"std" => "goto"),
array( "id" => "pix_frontpage_galleries_tooltip",
	"std" => "titleexcerptaction"),
array( "id" => "pix_sidebar_frontpage_layout",
	"std" => get_pix_option('pix_general_sidebar')),
array( "id" => "pix_front_page_layout",
	"std" => "right"),
array( "id" => "pix_front_page_title",
	"std" => "Deligh theme... welcome!"),
array( "id" => "pix_front_page_content",
	"std" => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lectus augue, venenatis a tincidunt nec, tincidunt vel ligula. Vivamus quis ante luctus purus condimentum volutpat. Fusce interdum convallis sem vitae facilisis. Morbi adipiscing nibh id arcu pulvinar mollis. Suspendisse varius, sapien in rhoncus luctus, lectus libero pulvinar tortor, et elementum enim tellus eu odio. In egestas metus quis nisi vehicula fermentum. Nullam tristique condimentum lobortis. Phasellus aliquam sem sapien, sit amet scelerisque lectus. Pellentesque sollicitudin imperdiet fermentum. Nullam blandit, mauris ullamcorper lobortis sodales, elit nulla pharetra odio, ac iaculis erat tortor vel libero. Curabitur ut pulvinar dui. Mauris at libero in nisi ullamcorper sollicitudin ut in erat. Mauris vel justo non nibh bibendum blandit. Quisque nibh arcu, egestas eget tempor ut, pulvinar nec nunc.</p>"),
array( "id" => "pix_front_page_seo_title",
	"std" => ""),
array( "id" => "pix_front_page_seo_description",
	"std" => ""),
array( "id" => "pix_front_page_seo_keywords",
	"std" => ""),
array( "id" => "pix_sidebar_frontpage",
	"std" => ""),
/*########################## SIDEBARS ##########################*/
array( "id" => "sidebar_generator_0",
	"std" => ""),
array( "id" => "pix_sidebar_posts",
	"std" => "none"),
array( "id" => "pix_sidebar_pages",
	"std" => "none"),
array( "id" => "pix_sidebar_categories",
	"std" => "none"),
array( "id" => "pix_sidebar_taxonomies",
	"std" => "none"),
array( "id" => "pix_sidebar_archives",
	"std" => "none"),
array( "id" => "pix_sidebar_404",
	"std" => "none"),
array( "id" => "pix_sidebar_search",
	"std" => "none"),
/*########################## BLOG ##########################*/
array( "id" => "pix_show_postmetadata",
	"std" => "show"),
array( "id" => "pix_archive_show_postmetadata",
	"std" => "show"),
array( "id" => "pix_postmetadata_comments",
	"std" => "show"),
array( "id" => "pix_prev_next_posts",
	"std" => "hide"),
array( "id" => "pix_show_related_items",
	"std" => "show"),
array( "id" => "pix_what_related_items",
	"std" => "excerpt"),
array( "id" => "pix_length_related_items",
	"std" => "20"),
array( "id" => "pix_post_show_share_section",
	"std" => "show"),
array( "id" => "pix_post_share_type",
	"std" => "counter"),
array( "id" => "pix_page_show_share_section",
	"std" => "show"),
array( "id" => "pix_page_share_type",
	"std" => "counter"),
array( "id" => "pix_archive_sliding_page",
	"std" => "default"),
array( "id" => "pix_archive_sidebar",
	"std" => "default"),
array( "id" => "pix_archive_maincolumn",
	"std" => "left"),
array( "id" => "pix_archive_slide",
	"std" => "default"),
array( "id" => "pix_archive_single",
	"std" => ""),
array( "id" => "pix_archive_video",
	"std" => ''),
array( "id" => "pix_archive_video_start",
	"std" => 'true'),
array( "id" => "pix_archive_video_loop",
	"std" => 'true'),
array( "id" => "pix_archive_googlemap",
	"std" => ''),
array( "id" => "pix_archive_googlemap_zoom",
	"std" => '17'),
array( "id" => "pix_archive_googlemap_indications",
	"std" => ''),
array( "id" => "pix_archive_googlemap_type",
	"std" => 'HYBRID'),
array( "id" => "pix_searchpage_sliding_page",
	"std" => "default"),
array( "id" => "pix_searchpage_sidebar",
	"std" => "default"),
array( "id" => "pix_searchpage_maincolumn",
	"std" => "left"),
array( "id" => "pix_searchpage_slide",
	"std" => "default"),
array( "id" => "pix_searchpage_single",
	"std" => ""),
array( "id" => "pix_searchpage_video",
	"std" => ""),
array( "id" => "pix_searchpage_video_start",
	"std" => 'true'),
array( "id" => "pix_searchpage_video_loop",
	"std" => 'true'),
array( "id" => "pix_searchpage_googlemap",
	"std" => ""),
array( "id" => "pix_searchpage_googlemap_zoom",
	"std" => ""),
array( "id" => "pix_searchpage_googlemap_indications",
	"std" => ""),
array( "id" => "pix_searchpage_googlemap_type",
	"std" => "HYBRID"),
array( "id" => "pix_404_sliding_page",
	"std" => "default"),
array( "id" => "pix_404_sidebar",
	"std" => "default"),
array( "id" => "pix_404_maincolumn",
	"std" => "left"),
array( "id" => "pix_404_slide",
	"std" => "default"),
array( "id" => "pix_404_single",
	"std" => ""),
array( "id" => "pix_404_video",
	"std" => ""),
array( "id" => "pix_404_video_start",
	"std" => 'true'),
array( "id" => "pix_404_video_loop",
	"std" => 'true'),
array( "id" => "pix_404_googlemap",
	"std" => ""),
array( "id" => "pix_404_googlemap_zoom",
	"std" => ""),
array( "id" => "pix_404_googlemap_indications",
	"std" => ""),
array( "id" => "pix_404_googlemap_type",
	"std" => "HYBRID"),
/*########################## PORTFOLIO ##########################*/
array( "id" => "pix_show_custom_related_items",
	"std" => "show"),
array( "id" => "pix_portfolio_show_share_section",
	"std" => "show"),
array( "id" => "pix_portfolio_share_type",
	"std" => "counter"),
array( "id" => "pix_portfolio_credits_section",
	"std" => "show"),
/*########################## STYLES ##########################*/
array( "id" => "pix_custom_style",
	"std" => ""),
/*########################## HACKS & TIPS ##########################*/
array( "id" => "pix_category_hack",
	"std" => "all"),
array( "id" => "pix_gallery_hack",
	"std" => "all"),
		  );
if (!isset($_GET['activated'])){
	pix_add_admin('admin_general');
}
	return $options;
}

?>