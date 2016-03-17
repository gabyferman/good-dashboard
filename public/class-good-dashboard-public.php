<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link http://github.com/gabyferman/
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to enqueue the
 * admin-specific stylesheet and JavaScript.
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/public
 * @author Good Bad Taste <hello@goodbadtaste.com>
 */
class Good_Dashboard_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @access private
	 * @var string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @access private
	 * @var string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function defined in
		 * Good_Dashboard_Loader as all of the hooks are defined in that particular
		 * class.
		 *
		 * The Good_Dashboard_Loader will then create the relationship between the
		 * defined hooks and the functions defined in this class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/good-dashboard-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function defined in
		 * Good_Dashboard_Loader as all of the hooks are defined in that particular
		 * class.
		 *
		 * The Good_Dashboard_Loader will then create the relationship between the
		 * defined hooks and the functions defined in this class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/good-dashboard-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add custom classes to the login <body> tag.
	 *
	 * @param string $classes
	 * @return string
	 */
	public function custom_login_classes( $classes ) {

		$classes[] = 'good-dashboard-login';

		return $classes;

	}

	/**
	 * Add custom logo to the login form.
	 *
	 * @return string
	 */
	public function custom_login_logo() {

		$options = get_option( $this->plugin_name . '-options' );
		$admin_logo_url = $options['admin_logo_src'];

		if ( $options ) {
			echo '
				<style type="text/css">
					.good-dashboard-login.login h1 a {
						 background-image: url("' . $admin_logo_url . '");
					}
				</style>
			';
		}

	}

}
