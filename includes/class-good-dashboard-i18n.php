<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin so that it is ready for
 * translation.
 *
 * @link http://github.com/gabyferman/
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it is ready for
 * translation.
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/includes
 * @author Good Bad Taste <hello@goodbadtaste.com>
 */
class Good_Dashboard_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @access private
	 * @var string $domain The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @param string $domain The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
