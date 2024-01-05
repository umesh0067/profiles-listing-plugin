<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://umeshwp.com
 * @since             1.0.0
 * @package           Um_Profile_Listing
 *
 * @wordpress-plugin
 * Plugin Name:       UM Profile Listing
 * Plugin URI:        https://umeshwp.com
 * Description:       The ProfileListing plugin is a versatile and user-friendly tool designed to enhance your website's user experience by creating visually appealing and informative profile listings. Whether you're running a community platform, a professional network, or any website that features user profile listing, ProfileListing adds a layer of customization and interactivity.
 * Version:           1.0.0
 * Author:            Umesh Ladumor
 * Author URI:        https://umeshwp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       um-profile-listing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UM_PROFILE_LISTING_VERSION', '1.0.0' );
define( 'UM_PROFILE_LIST_URL', plugin_dir_url(__FILE__) );
define( 'UM_PROFILE_LIST_PATH', plugin_dir_path(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-um-profile-listing-activator.php
 */

function activate_um_profile_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-um-profile-listing-activator.php';
    Um_Profile_Listing_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-um-profile-listing-deactivator.php
 */
function deactivate_um_profile_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-um-profile-listing-deactivator.php';
	Um_Profile_Listing_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_um_profile_listing' );
register_deactivation_hook( __FILE__, 'deactivate_um_profile_listing' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-um-profile-listing.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_um_profile_listing() {

	$plugin = new Um_Profile_Listing();
	$plugin->run();

}
run_um_profile_listing();

