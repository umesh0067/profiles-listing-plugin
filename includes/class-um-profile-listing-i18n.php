<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://umeshwp.com
 * @since      1.0.0
 *
 * @package    Um_Profile_Listing
 * @subpackage Um_Profile_Listing/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Um_Profile_Listing
 * @subpackage Um_Profile_Listing/includes
 * @author     Umesh Ladumor <umeshladumor2011@gmail.com>
 */
class Um_Profile_Listing_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'um-profile-listing',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
