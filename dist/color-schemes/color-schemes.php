<?php
/**
 * Add a default color scheme
 */

class candy_color_schemes {

	/**
	 * Register the color schemes. Needed for registering colors-fresh dependency.
	 *
	 * @var array $colors List of colors registered in this plugin.
	 */
	private $colors = array( 'candy' );
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_default_css' ) );
		add_action( 'admin_init' , array( $this, 'add_colors' ) );
	}

	/**
	 * Register color schemes.
	 */
	function add_colors() {
		// $suffix = is_rtl() ? '-rtl' : '';

		wp_admin_css_color(
			'candy', __( 'Candy', 'admin_schemes' ),
			plugins_url( "/candy/colors.css", __FILE__ ),
				array( '#26292c', '#363b3f', '#e14d43', '#107d82' ),
				array( 'base' => '#fafafa', 'focus' => '#fff', 'current' => '#fff' )
		);

	}

	/**
	 * Make sure core's default `colors.css` gets enqueued, since we can't
	 * @import it from a plugin stylesheet. Also force-load the default colors
	 * on the profile screens, so the JS preview isn't broken-looking.
	 */
	function load_default_css() {
		global $wp_styles, $_wp_admin_css_colors;
		$color_scheme = get_user_option( 'admin_color' );
		$scheme_screens = apply_filters( 'acs_picker_allowed_pages', array( 'profile', 'profile-network' ) );
		if ( in_array( $color_scheme, $this->colors ) || in_array( get_current_screen()->base, $scheme_screens ) ){
			$wp_styles->registered[ 'colors' ]->deps[] = 'colors-fresh';
		}

	}

}
global $candy_colors;
$candy_colors = new candy_color_schemes;

