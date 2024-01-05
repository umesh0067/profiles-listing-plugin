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



	// custom post type and texonomies
	// Register Custom Post Type
	function create_profile_listing_post_type() {
		$labels = array(
			'name'                  => _x( 'Profile Listings', 'Post Type General Name', 'um-profile-listing' ),
			'singular_name'         => _x( 'Profile Listing', 'Post Type Singular Name', 'um-profile-listing' ),
			'menu_name'             => __( 'Profile Listings', 'um-profile-listing' ),
			'all_items'             => __( 'All Listings', 'um-profile-listing' ),
			'add_new_item'          => __( 'Add New Listing', 'um-profile-listing' ),
			'add_new'               => __( 'Add New', 'um-profile-listing' ),
			'edit_item'             => __( 'Edit Listing', 'um-profile-listing' ),
			'update_item'           => __( 'Update Listing', 'um-profile-listing' ),
			'view_item'             => __( 'View Listing', 'um-profile-listing' ),
			'search_items'          => __( 'Search Listing', 'um-profile-listing' ),
			'not_found'             => __( 'Not Found', 'um-profile-listing' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'um-profile-listing' ),
		);

		$args = array(
			'label'                 => __( 'Profile Listing', 'um-profile-listing' ),
			'description'           => __( 'User profile listings', 'um-profile-listing' ),
			'labels'                => $labels,
			'supports'              => array( 'title'),
			'taxonomies'            => array( 'skills', 'education' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'show_in_admin_bar'     => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-groups',
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);

		register_post_type( 'profile_listing', $args );
	}

	// Register Taxonomies
	function create_profile_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Skills', 'taxonomy general name', 'um-profile-listing' ),
			'singular_name'     => _x( 'Skill', 'taxonomy singular name', 'um-profile-listing' ),
			'search_items'      => __( 'Search Skills', 'um-profile-listing' ),
			'all_items'         => __( 'All Skills', 'um-profile-listing' ),
			'parent_item'       => __( 'Parent Skill', 'um-profile-listing' ),
			'parent_item_colon' => __( 'Parent Skill:', 'um-profile-listing' ),
			'edit_item'         => __( 'Edit Skill', 'um-profile-listing' ),
			'update_item'       => __( 'Update Skill', 'um-profile-listing' ),
			'add_new_item'      => __( 'Add New Skill', 'um-profile-listing' ),
			'new_item_name'     => __( 'New Skill Name', 'um-profile-listing' ),
			'menu_name'         => __( 'Skills', 'um-profile-listing' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'skill' ),
		);

		register_taxonomy( 'skills', array( 'profile_listing' ), $args );

		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Education', 'taxonomy general name', 'um-profile-listing' ),
			'singular_name'              => _x( 'Education', 'taxonomy singular name', 'um-profile-listing' ),
			'search_items'               => __( 'Search Education', 'um-profile-listing' ),
			'popular_items'              => __( 'Popular Education', 'um-profile-listing' ),
			'all_items'                  => __( 'All Education', 'um-profile-listing' ),
			'edit_item'                  => __( 'Edit Education', 'um-profile-listing' ),
			'update_item'                => __( 'Update Education', 'um-profile-listing' ),
			'add_new_item'               => __( 'Add New Education', 'um-profile-listing' ),
			'new_item_name'              => __( 'New Education Name', 'um-profile-listing' ),
			'separate_items_with_commas' => __( 'Separate education with commas', 'um-profile-listing' ),
			'add_or_remove_items'        => __( 'Add or remove education', 'um-profile-listing' ),
			'choose_from_most_used'      => __( 'Choose from the most used education', 'um-profile-listing' ),
			'menu_name'                  => __( 'Education', 'um-profile-listing' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'education' ),
		);

		register_taxonomy( 'education', 'profile_listing', $args );
	}

	// Add Metadata Fields
	function add_profile_listing_metadata() {
		add_meta_box(
			'profile_metadata',
			'Profile Data',
			'render_profile_metadata_fields',
			'profile_listing',
			'normal',
			'high'
		);
	}

	function render_profile_metadata_fields( $post ) {
		// Add your custom metadata fields here
		$dob = get_post_meta( $post->ID, '_dob', true );
		$age = get_post_meta( $post->ID, '_age', true );
		$hobbies = get_post_meta( $post->ID, '_hobbies', true );
		$interests = get_post_meta( $post->ID, '_interests', true );
		$years_of_experience = get_post_meta( $post->ID, '_years_of_experience', true );
		$ratings = get_post_meta( $post->ID, '_ratings', true );
		$jobs_completed = get_post_meta( $post->ID, '_jobs_completed', true );

		?>
		<div class="um_meta_item um_dob">
		<label for="dob">Date of Birth:</label>
		<input type="text" class="meta-field" id="datepicker" name="dob" value="<?php echo esc_attr( $dob ); ?>" />
		</div>

		<div class="um_meta_item um_age">
		<label for="age">Age</label>
		<input type="number" class="meta-field" name="um_age" value="<?php echo esc_attr( $age ); ?>" />
		</div>

		<div class="um_meta_item um_dob">
		<label for="hobbies">Hobbies:</label>
		<input type="text" class="meta-field" name="hobbies" value="<?php echo esc_attr( $hobbies ); ?>" />
		</div>

		<div class="um_meta_item um_dob">
		<label for="interests">Interests:</label>
		<input type="text" class="meta-field" name="interests" value="<?php echo esc_attr( $interests ); ?>" />
		</div>

		<div class="um_meta_item um_dob">
		<label for="years_of_experience">Years of Experience:</label>
		<input type="number" class="meta-field" name="years_of_experience" value="<?php echo esc_attr( $years_of_experience ); ?>" />
		</div>

		<div class="um_meta_item um_dob">
		<label for="ratings">Ratings:</label>
		<select class="meta-field" name="ratings">
			<option value="" <?php selected($ratings, ''); ?>>Select Rating</option>
			<?php
			for ($i = 1; $i <= 5; $i++) {
				echo '<option value="' . esc_attr($i) . '" ' . selected($ratings, $i, false) . '>' . esc_html($i) . '</option>';
			}
			?>
		</select>
		</div>

		<div class="um_meta_item um_dob">
		<label for="jobs_completed">No Jobs Completed:</label>
		<input type="number" class="meta-field" name="jobs_completed" value="<?php echo esc_attr( $jobs_completed ); ?>" />
		</div>
		<?php
	}

	// Save Metadata
	function save_profile_listing_metadata( $post_id ) {
		// Save your custom metadata fields here
		if ( isset( $_POST['dob'] ) ) {
			update_post_meta( $post_id, '_dob', sanitize_text_field( $_POST['dob'] ) );
		}

		if ( isset( $_POST['um_age'] ) ) {
			update_post_meta( $post_id, '_age', sanitize_text_field( $_POST['um_age'] ) );
		}

		if ( isset( $_POST['hobbies'] ) ) {
			update_post_meta( $post_id, '_hobbies', sanitize_text_field( $_POST['hobbies'] ) );
		}

		if ( isset( $_POST['interests'] ) ) {
			update_post_meta( $post_id, '_interests', sanitize_text_field( $_POST['interests'] ) );
		}

		if ( isset( $_POST['years_of_experience'] ) ) {
			update_post_meta( $post_id, '_years_of_experience', sanitize_text_field( $_POST['years_of_experience'] ) );
		}

		if ( isset( $_POST['ratings'] ) ) {
			update_post_meta( $post_id, '_ratings', sanitize_text_field( $_POST['ratings'] ) );
		}

		if ( isset( $_POST['jobs_completed'] ) ) {
			update_post_meta( $post_id, '_jobs_completed', sanitize_text_field( $_POST['jobs_completed'] ) );
		}
	}

}
