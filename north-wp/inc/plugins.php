<?php
add_action('tgmpa_register', 'thb_register_required_plugins');
function thb_register_required_plugins() {
	$plugins = array(
		array(
			'name'     				=> 'WooCommerce', // The plugin name
			'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
			'required'			=> true,
			'force_activation'		=> false,
			'force_deactivation'	=> false
		),
		array(
			'name'			=> 'WPBakery Visual Composer', // The plugin name
			'slug'			=> 'js_composer', // The plugin slug (typically the folder name)
			'source'			=> get_template_directory_uri() . '/inc/plugins/codecanyon-242431-visual-composer-page-builder-for-wordpress-wordpress-plugin.zip', // The plugin source
			'required'			=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'		=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Slider Revolution', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/inc/plugins/codecanyon-2751380-slider-revolution-responsive-wordpress-plugin-wordpress-plugin.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name'     				=> 'YITH WooCommerce Wishlist', // The plugin name
			'slug'     				=> 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
			'required'			=> false,
			'force_activation'		=> false,
			'force_deactivation'	=> false
		),
		array(
			'name'     				=> 'YITH WooCommerce Ajax Search', // The plugin name
			'slug'     				=> 'yith-woocommerce-ajax-search', // The plugin slug (typically the folder name)
			'required'			=> false,
			'force_activation'		=> false,
			'force_deactivation'	=> false
		),
		array(
			'name'     				=> 'Contact Form 7',
			'slug'     				=> 'contact-form-7'
		)
	);
	$config = array(
		'domain'       		=> 'north',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'north' ),
			'menu_title'                       			=> __( 'Install Plugins', 'north' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'north' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'north' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'north' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'north' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'north' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'north' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'north' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'north' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'north' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'north' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'north' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'north' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'north' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'north' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'north' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);
	tgmpa($plugins, $config);
}