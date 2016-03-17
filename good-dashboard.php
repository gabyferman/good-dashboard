<?php
/**
 * @wordpress-plugin
 *
 * @link http://github.com/gabyferman/
 * @since 2.0.0
 * @package Good_Dashboard
 *
 * Plugin Name: Good Dashboard
 * Plugin URI: http://github.com/gabyferman/good-dashboard/
 * Description: A WordPress plugin, made to customize the admin / dashboard & login areas of a website.
 * Version: 2.0.0
 * Author: Good Bad Taste
 * Author URI: http://github.com/gabyferman/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: good-dashboard
 * Domain Path: /languages
 *
 * A WordPress plugin, made to customize the admin / dashboard & login areas of a website.
 * Helps with:
 *
 * -- Adding custom dashboard classes
 * -- Adding custom CSS style to dashboard
 * -- Adding your own logo to the admin bar
 * -- Modifying the footer text for the dashboard
 * -- Removing dashboard widgets
 * -- Adding admin color scheme and use as default
 * -- Hiding other color schemes
 * -- Creating a custom login form
 * -- Hiding adminbar on frontpage
 *
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) )
	die;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-good-dashboard-activator.php
 */
function activate_good_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-good-dashboard-activator.php';
	Good_Dashboard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-good-dashboard-deactivator.php
 */
function deactivate_good_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-good-dashboard-deactivator.php';
	Good_Dashboard_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_good_dashboard' );
register_deactivation_hook( __FILE__, 'deactivate_good_dashboard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-good-dashboard.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off the plugin from this
 * point in the file does not affect the page life cycle.
 */
function run_good_dashboard() {

	$plugin = new Good_Dashboard();
	$plugin->run();

}
run_good_dashboard();
