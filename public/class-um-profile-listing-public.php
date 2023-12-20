<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://umeshwp.com
 * @since      1.0.0
 *
 * @package    Um_Profile_Listing
 * @subpackage Um_Profile_Listing/public
 */

class Um_Profile_Listing_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		//for shortcode hook
		add_shortcode( 'um_profile_listing_shortcode', array($this, 'um_profile_listing_shortcode') );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//select2 css
		wp_enqueue_style( 'select2_style', UM_PROFILE_LIST_URL . 'public/css/select2.min.css', array(), $this->version, 'all' );

		//bootsraps css
		wp_enqueue_style( 'bootsrap_style', UM_PROFILE_LIST_URL . 'public/css/bootstrap.min.css', array(), $this->version, 'all' );

		//datatable css
		wp_enqueue_style( 'style_dataTable', UM_PROFILE_LIST_URL . 'public/css/jquery.dataTables.min.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name, UM_PROFILE_LIST_URL . 'public/css/um-profile-listing-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// Enqueue jQuery
		wp_enqueue_script('jquery');
		// bootsrap js
		wp_enqueue_script( 'bootsrap_jquery', UM_PROFILE_LIST_URL . 'public/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		// datatable js
		wp_enqueue_script( 'jquery_dataTable', UM_PROFILE_LIST_URL . 'public/js/jquery.dataTables.min.js', array( 'jquery' ), '1.13.7', false );
		// select2 js
		wp_enqueue_script( 'select2_jquery', UM_PROFILE_LIST_URL . 'public/js/select2.min.js', array( 'jquery' ), '4.0.13', true );
		wp_enqueue_script( $this->plugin_name, UM_PROFILE_LIST_URL . 'public/js/um-profile-listing-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'um_Ajax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce('profile_listing_nonce')
		));
	}

	public function um_profile_listing_shortcode() {
		ob_start();  // start buffer
		include_once( UM_PROFILE_LIST_PATH . "public/partials/um-profile-listing-public-display.php" );  // include template
		$template = ob_get_contents();  // reading contents
		ob_end_clean();  //closing buffer
		return $template;
	}

	public function handle_ajax_request() {
		// Verify nonce
		if (!isset($_POST['wp_nonce'])) {
			die('Permission denied');
		} else {
			include_once( UM_PROFILE_LIST_PATH . "public/partials/um-profile-listing-public-ajax.php" );

		}
		
	}
	

}
