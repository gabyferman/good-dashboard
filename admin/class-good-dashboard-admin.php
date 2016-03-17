<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link http://github.com/gabyferman/
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/admin
 * @author Good Bad Taste <hello@goodbadtaste.com>
 */
class Good_Dashboard_Admin {

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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Good_Dashboard_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Good_Dashboard_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/good-dashboard-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Good_Dashboard_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Good_Dashboard_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_media();

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/good-dashboard-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Remove the default Admin bar content.
	 *
	 * @param $wp_admin_bar
	 */
	public function remove_default_admin_bar( $wp_admin_bar ) {

		$ids = array(
			'updates',
			'comments',
			'new-content',
		);

		foreach( $ids as $id) {
			$wp_admin_bar->remove_node( $id );
		}

	}

	/**
	 * Get rid of all default dashboard panels.
	 */
	public function remove_dashboard_defaults() {

		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );

		/**
		 * Remove the default Welcome Panel
		 */
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

	}

	/**
	 * Add custom classes to the dashboard <body> tag.
	 *
	 * @param string $classes
	 * @return string
	 */
	public function custom_dashboard_classes( $classes ) {

		$class = array(
			'good-dashboard-admin'
		);

		if ( is_multisite() )
			$class[] = 'multisite';

		if ( is_network_admin() )
			$class[] = 'network-admin';

		$classes = ' ' . implode( ' ', $class );

		return $classes;

	}

	/**
	 * Use your logo in the admin bar.
	 *
	 * @return string
	 */
	public function admin_bar_logo_icon() {

		// echo '
		// 	<style type="text/css">
		// 		#wpadminbar ul#wp-admin-bar-root-default > li#wp-admin-bar-wp-logo { display: none; }
		// 		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon, #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-item:before, #wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo > .ab-item .ab-icon { font: normal 0/0 a; }
		// 	</style>
		// ';

	}

	/**
	 * Use a custom favicon.
	 *
	 * @return string
	 */
	public function admin_favicon() {

		$output = sprintf(
				'<link href="%s" rel="icon" type="image/x-icon">',
				esc_url( plugin_dir_url( __FILE__ ) . 'images/favicon.ico' )
			);

		echo $output;

	}

	/**
	 * Use a custom footer for the dashboard.
	 *
	 * @return string
	 */
	public function admin_footer () {

		$output = sprintf(
				'Made by <a href="%s" target="_blank">Good Bad Taste</a> | Fueled by <a href="%s" target="_blank">WordPress</a>',
				esc_url( 'http://github.com/gabyferman/' ),
				esc_url( 'http://www.wordpress.org/' )
		);

		echo wp_kses( $output, array( 'a' => array( 'href' => array(), 'target' => array() ) ) );

	}

	/**
	 * Add a settings page link.
	 */
	function add_menu() {

		add_options_page(
			apply_filters( $this->plugin_name . '-settings-page-title', __( 'Dashboard Settings', 'good-dashboard' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', __( 'Dashboard', 'good-dashboard' ) ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'options_page' )
		);

	}

	/**
	 * Add options page.
	 */
	function options_page() {

		include( plugin_dir_path( __FILE__ ) . 'partials/good-dashboard-admin-display.php' );

	}

	/**
	 * Registers plugin settings, sections, and fields
	 */
	public function register_settings() {

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

		add_settings_section(
			$this->plugin_name . '-display-options',
			apply_filters( $this->plugin_name . '-display-section-title', __( 'Login Page', 'good-dashboard' ) ),
			array( $this, 'display_options_section' ),
			$this->plugin_name
		);

		add_settings_field(
			'admin_logo_src',
			apply_filters( $this->plugin_name . '-date-expiration-label', __( 'Admin Logo', 'good-dashboard' ) ),
			array( $this, 'admin_logo_src' ),
			$this->plugin_name,
			$this->plugin_name . '-display-options'
		);

	}

	/**
	 * Validates saved options
	 *
	 * @param array $input array of submitted plugin options
	 * @return array array of validated plugin options
	 */
	public function validate_options( $input ) {

		$options = get_option( $this->plugin_name . '-options' );

		$options['admin_logo_src'] = esc_url( $input['admin_logo_src'] );

		return $options;

	}

	/**
	 * Creates a settings section
	 *
	 * @param array $params Array of parameters for the section
	 * @return mixed The settings section
	 */
	public function display_options_section( $params ) {

		echo '<p>' . __( 'Add an image to use in the login page.', 'good-dashboard' ) . '</p>';

	}

	/**
	 * Creates a settings field
	 *
	 * @return mixed The settings field
	 */
	public function admin_logo_src() {

		$options = get_option( $this->plugin_name . '-options' );

		$name = $this->plugin_name . '-options[admin_logo_src]';
		$value = $options['admin_logo_src'];

		?>

		<p class="hide-if-no-js">
			<a title="Upload Image" href="javascript:;" id="set-admin-logo" class="button media-button button-large pressware-image-upload"><?php _e( 'Upload Image', 'good-dashboard' ); ?></a>
		</p>

		<div id="admin-logo-image-container" class="good-dashboard-image-container">

			<?php if ( get_post_meta( $post->ID, 'admin-logo-src', true ) == '' ) : ?>
				<img src="<?php echo $value; ?>" />
			<?php else : ?>
				<img src="<?php echo get_post_meta( $post->ID, 'admin-logo-src', true ); ?>" />
			<?php endif; ?>


		</div>

		<p class="hide-if-no-js hidden">
			<a title="Remove Image" href="javascript:;" id="remove-admin-logo" class="button media-button button-large pressware-image-upload"><?php _e( 'Remove Image', 'good-dashboard' ); ?></a>
		</p>

		<p id="admin-logo-image-info">
			<input type="hidden" id="admin-logo-src" name="admin-logo-src" value="<?php echo get_post_meta( $post->ID, 'admin-logo-src', true ); ?>" />
			<input type="hidden" id="admin-logo-alt" name="admin-logo-alt" value="<?php echo get_post_meta( $post->ID, 'admin-logo-alt', true ); ?>" />
			<input type="hidden" id="admin-logo-title" name="admin-logo-title" value="<?php echo get_post_meta( $post->ID, 'admin-logo-title', true ); ?>" />
			<input type="hidden" id="admin_logo_src" name="<?php echo $name; ?>" value="<?php echo ( get_post_meta( $post->ID, 'admin-logo-src', true ) == '' ) ? $value : get_post_meta( $post->ID, 'admin-logo-src', true ); ?>">
		</p>

		<?php
	}

}
