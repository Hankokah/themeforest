<?php
// debug
function out( $what ) {
	$bt = debug_backtrace();
	echo '<br><br>' . $bt[0]['file'] . '[' . $bt[0]['line'] . ']: <br><pre>' . print_r( $what, true ) . '</pre><br>';
}

// Test the PHP version before we continue
if (PHP_VERSION_ID >= 50301) { 
	
	// We're good! This at least v5.3.1

	//-----------------------------------------------------------------
	// Functions needing to run before config.php is loaded
	//-----------------------------------------------------------------
	include_once 'includes/load-functions.php';


	//-----------------------------------------------------------------
	// Framework configuration variables
	//-----------------------------------------------------------------
	include_once 'defaults.php';


	//-----------------------------------------------------------------
	// Load framework components
	//-----------------------------------------------------------------
	include_once 'core/common-object.php';


	//-----------------------------------------------------------------
	// Initialize the admin components
	//-----------------------------------------------------------------
	if ( is_admin() || isset($GLOBALS['wp_customize']) ) {
		include_once 'core/admin-object.php';
	}

	load_data_types();
	load_framework_libraries();

	//-----------------------------------------------------------------
	// Extensions
	//-----------------------------------------------------------------

	// Get available extensions
	//................................................................
	$extensions = get_extensions();

	// Set filters on get option and update option for extensions
	//................................................................
	foreach ( $extensions as $extension_name => $extension_path ) {
		$key = $shortname.str_replace( '-', '_', $extension_name );
		add_action( 'pre_option_'.$key, 'theme_option_filter' );
		add_action( 'pre_update_option_'.$key, 'theme_option_dual_save_filter' );
	}


	//................................................................
	// Load extensions PHP file
	//................................................................
	include_once 'includes/load-extensions.php';


	//-----------------------------------------------------------------
	// ** Temporary ** Theme Menu
	//-----------------------------------------------------------------

	// We're adding a menu for the currently active theme just to nest
	// the theme option pages inside. This will probably need to be
	// integrated into the framework better in the future.

	function add_framework_menu() {

		global $extm;
		// Runway menu
		add_menu_page( 'Runway', 'Runway', 'administrator', 'framework-options', 'do_nothing', FRAMEWORK_URL.'framework/images/menu-runway.png' );
		// Downloads menu
		add_menu_page( 'Downloads', 'Downloads', 'administrator', 'downloads', 'do_nothing', FRAMEWORK_URL.'framework/images/menu-downloads.png' );
		// Child theme menu
		$currentThemeName = ( trim( THEME_NAME ) == trim( 'Runway' ) ) ? 'Child Theme' : THEME_NAME;
		add_menu_page( '', $currentThemeName, 'administrator', 'current-theme', 'do_nothing' );

	}
	// add_action( 'admin_menu', 'add_framework_menu', 5);

	if ( !function_exists( 'do_nothing' ) ) {
		function do_nothing() { }
	}

	function add_framework_submenu() {
		// Runway sub-menu
		add_submenu_page( 'framework-options', 'Runway Development Sandbox', 'Dashboard', 'administrator', 'dashboard' );
		add_submenu_page( 'framework-options', 'Runway Development Sandbox', 'Themes', 'administrator', 'themes' );
		add_submenu_page( 'framework-options', 'Runway Development Sandbox', 'Extensions', 'administrator', 'extensions' );
		add_submenu_page( 'framework-options', 'Runway Development Sandbox', 'Options Builder', 'administrator', 'options-builder' );
	}
	// add_action( 'admin_menu', 'add_framework_submenu', 9); // higher priority, 9, forces default items to top of sub-menu

	function add_child_theme_submenu() {
		// Child theme sub-menu
		add_submenu_page( 'current-theme', 'Add Options Page', '+ Add Options Page', 'administrator', 'admin.php?page=options-builder&navigation=new-page' );
	}
	add_action( 'admin_menu', 'add_child_theme_submenu', 11); // lower priority, 11, forces item to end of sub-menu

	function clear_submenu() {
		global $submenu;
		unset($submenu['framework-options'][0]);
		unset($submenu['downloads'][0]);
		unset($submenu['current-theme'][0]);
	}
	add_action( 'admin_menu', 'clear_submenu', 100); 


	//-----------------------------------------------------------------
	// WP-Pointers (temporary location)
	//-----------------------------------------------------------------

	// Dashboard "Getting Started"
	if ( is_admin() && isset($_GET['page']) && $_GET['page'] !== 'dashboard' && !isset($_GET['activate-default']) ) {
		WP_Pointers::add_pointer( 'all', 'a.wp-first-item[href=\'admin.php?page=dashboard\']', array( 'title' => 'Start Here', 'body' => '<p>Visit the dashboard and learn how Runway works to start making awesome themes today.</p>' ), 'edge: "left", align: "center"' );
	}


} else { 

	// This is no good. The PHP version needs to be higher. :(
	// ----------------------------------------------------------------

	add_action( 'admin_notices', 'php_version_warning_message' );
	function php_version_warning_message(){
	     global $current_screen;
		echo '<div id="message" class="error">',
		     '<h3><strong>You must have PHP v5.3.1 or later to use this theme.</strong></h3>',
		     '<p>You can try adding the following to the top of your .htaccess file in the WordPress root directory:</p>',
		     '<p><code style="font-size: 14px; font-weight: 800;">AddType application/x-httpd-php53 .php</code></p>',
		     '<p>If that does not work, contact your host and ask them to update your PHP version. The theme will not be functional until this issue is corrected.</p>',
		     '</div>';
	}

}

?>