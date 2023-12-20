<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://umeshwp.com
 * @since      1.0.0
 *
 * @package    Um_Profile_Listing
 * @subpackage Um_Profile_Listing/admin
 */
class Um_Profile_Listing_Admin {
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'jquery_ui_css', UM_PROFILE_LIST_URL . 'admin/css/jquery-ui-css.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, UM_PROFILE_LIST_URL . 'admin/css/um-profile-listing-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'jquery_ui', UM_PROFILE_LIST_URL . 'admin/js/jquery-ui.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, UM_PROFILE_LIST_URL . 'admin/js/um-profile-listing-admin.js', array( 'jquery' ), $this->version, true );

	}

	// Create admin menu method
	public function um_profile_listing_menu(){
		add_menu_page('UM Profile Listing', 'UM Profile Listing', 'manage_options', 'um-profile-listing', array($this, 'um_profile_dashboard'), 'dashicons-image-filter' );

		add_submenu_page('um-profile-listing', 'UM Profile Listing Setting', 'UM Profile Listing Setting', 'manage_options', 'um-profile-listing', array($this, 'um_profile_dashboard') );
	}

	// Admin menu callback fuction.
	public function um_profile_dashboard(){
		echo "<h1>Welcome to admin menu page</h1>";
		echo "<p>Below shortcode to copy and paste when you want display profile listing and profile data filter.</p>";
		echo "<br/>";
		echo "<br/>";
		echo "<strong>[um_profile_listing_shortcode]</strong>";

		
	}

}
