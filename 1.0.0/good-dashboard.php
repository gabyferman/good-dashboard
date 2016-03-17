<?php
/**
 * Plugin Name: Good Dashboard
 * Plugin URI: http://github.com/gabyferman/good-dashboard
 * Description: A WordPress plugin, made to customize the admin / dashboard & login areas of a website.
 * Author: Good Bad Taste by Gaby Ferman
 * Version: 1.0.0
 * Author URI: https://github.com/gabyferman
 *
 * A WordPress plugin, made to customize the admin / dashboard & login areas of a
 * website.
 *
 * - Add custom dashboard classes
 * - Add custom CSS style to dashboard
 * - Add your own logo to the admin bar
 * - Modify the footer text for the dashboard
 * - Remove dashboard widgets
 * - Add admin color scheme and use as default
 * - Hide other color schemes
 * - Custom login form
 * - Hide adminbar on frontpage
 *
 */


/* Hello, let's call all the hooks to modify your admin dashboard! */
add_filter( 'admin_body_class', 'gbt_body_class' ); // Adds custom dashboard body classes
add_action('admin_head', 'gbt_admin_favicon'); // Add a favicon to the dashboard
add_action( 'admin_head', 'gbt_custom_logo' ); // Add your site's logo to the admin-bar
add_filter( 'admin_footer_text', 'gbt_admin_footer' ); // Add a custom dashboard footer
add_action( 'admin_enqueue_scripts', 'gbt_dashboard_css', 1 ); // Add custom styles to the dashboard
add_action( 'admin_menu', 'gbt_disable_dashboard_widgets' ); //  Disable dashboard widgets

add_filter( 'get_user_option_admin_color', 'gbt_change_admin_color' ); // Set default dashboard color
add_action( 'user_register', 'gbt_default_admin_color' ); // Change dashboard color
add_filter( 'admin_init', 'gbt_rename_fresh_color_scheme' ); // Rename 'default' color scheme to 'fresh'
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' ); // Hide the color scheme picker

add_filter( 'show_admin_bar', '__return_false' ); // Hide the admin bar in the front end



// Calling the color schemes files
include( plugin_dir_path( __FILE__ ) . 'color-schemes/color-schemes.php' );



/*=========================================
=            #CUSTOM DASHBOARD            =
=========================================*/
/**
 * Custom dashboard body classes
 * @wp-hook admin_body_class
 * @param string $classes Custom classes for dashboard and multisite customization
 * @return string New classes
 */
function gbt_body_class( $classes ) {
	$classes .= ' candy-dashboard';
	if ( is_multisite() )
		$classes .= ' multisite';
	if ( is_network_admin() )
		$classes .= ' network-admin';
	return $classes;
}

/**
 * Add your site's logo to the admin bar
 * @wp-hook admin_head
 * @return string
 */
function gbt_custom_logo() {
	echo '
		<style type="text/css">
			#wpadminbar ul#wp-admin-bar-root-default > li#wp-admin-bar-wp-logo {
				display: none;
			}
			#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon, #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-item:before, #wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo > .ab-item .ab-icon {
				font: normal 0/0 a;
			}
		</style>
	';
}

/**
 * Add a favicon to the admin
 */
function gbt_admin_favicon() {
	echo '<link href="' . plugin_dir_url( __FILE__ ) . 'images/favicon.ico" rel="icon" type="image/x-icon">';
}

/**
 * Custom dashboard footer
 * @wp-hool admin_footer_text
 * @return string Admin footer and site info
 */
function gbt_admin_footer () {
	echo 'Made by <a href="http://github.com/gabyferman" target="_blank">Good Bad Taste</a> | Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';
}

/**
 * Add custom styles to the dashboard
 * @wp-hook admin_enqueue_scripts
 */
function gbt_dashboard_css() {
	wp_enqueue_style( 'dashboard', plugins_url( 'css/dashboard.css', __FILE__ ), array(), '', 'screen' );
	// wp_enqueue_style( 'logo', plugins_url( 'fonts/style.css', __FILE__ ), array(), '', 'screen' );
}

/**
 * Disable dashboard widgets
 * @wp-hook admin_menu
 */
function gbt_disable_dashboard_widgets() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
}



/*===================================================
=            #COLOR SCHEME            =
===================================================*/
/**
 * Set default admin color
 * @wp-hook user_register
 * @param string $user_id
 */
function gbt_default_admin_color( $user_id ) {
	$args = array(
		'ID' => $user_id,
		'admin_color' => 'candy'
	 );
	wp_update_user( $args );
}

/**
 * Change admin color
 * @wp-hook get_user_option_admin_color
 * @param string $result
 */
function gbt_change_admin_color( $result ) {
	return 'candy';
}

/**
 * Rename 'default' color scheme to 'fresh'
 * @wp-hook admin_init
 */
function gbt_rename_fresh_color_scheme() {
	global $_wp_admin_css_colors;
	$color_name = $_wp_admin_css_colors['fresh']->name;

	if ( $color_name == 'Default' )
		$_wp_admin_css_colors['fresh']->name = 'Fresh';

	return $_wp_admin_css_colors;
}



/*=====================================
=            #CUSTOM LOGIN            =
=====================================*/
/**
 * Remove WP login stylesheet
 * @wp-hook login_init
 */
function gbt_login_remove_style() {
	wp_deregister_style( 'login' );
}

// add_action( 'login_init', 'gbt_login_remove_style' );

/**
 * Add custom style to login page
 * @wp-hook login_enqueue_scripts
 */
function gbt_login_css() {
	wp_enqueue_style( 'candy-login', plugins_url( 'css/login.css', __FILE__ ), true );
}

add_action( 'login_enqueue_scripts', 'gbt_login_css', 1 );

/**
 * Change the logo link from wordpress.org to your site domain
 * @wp-hook login_headurl
 */
function gbt_login_url() { return home_url(); }

add_filter( 'login_headerurl', 'gbt_login_url' );

/**
 * Change the alt text on the logo to show our site's name
 * @wp-hook login_headertitle
 */
function gbt_login_title() { return get_option( 'blogname' ); }

add_filter( 'login_headertitle', 'gbt_login_title' );
