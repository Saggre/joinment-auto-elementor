<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Joinment_Auto_Elementor_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Adds the menu
	 */
	public function add_menu() {
		add_management_page( 'Auto Elementor', 'Auto Elementor', 'manage_options', 'joinment-auto-elementor', array(
			$this,
			'admin_page'
		) );
	}

	/**
	 * Saves
	 */
	public function save() {

		// First, validate the nonce.
		// Secondly, verify the user has permission to save.
		// If the above are valid, save the option.

		// First, validate the nonce and verify the user as permission to save.
		if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
			// TODO: Display an error message.
		}

		// If the above are valid, sanitize and save the option.
		if ( null !== wp_unslash( $_POST['acme-message'] ) ) {

			$value = $_POST['acme-message'];
			update_option( 'tutsplus-custom-data', $value );

		}

		$this->redirect();
	}

	/**
	 * Determines if the nonce variable associated with the options page is set
	 * and is valid.
	 *
	 * @access private
	 *
	 * @return boolean False if the field isn't set or the nonce value is invalid;
	 *                 otherwise, true.
	 */
	private function has_valid_nonce() {

		// If the field isn't even in the $_POST, then it's invalid.
		if ( ! isset( $_POST['acme-custom-message'] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST['acme-custom-message'] );
		$action = 'acme-settings-save';

		return wp_verify_nonce( $field, $action );

	}

	/**
	 * Redirect to the page from which we came (which should always be the
	 * admin page. If the referred isn't set, then we redirect the user to
	 * the login page.
	 *
	 * @access private
	 */
	private function redirect() {

		// To make the Coding Standards happy, we have to initialize this.
		if ( ! isset( $_POST['_wp_http_referer'] ) ) { // Input var okay.
			$_POST['_wp_http_referer'] = wp_login_url();
		}

		// Sanitize the value of the $_POST collection for the Coding Standards.
		$url = sanitize_text_field(
			wp_unslash( $_POST['_wp_http_referer'] ) // Input var okay.
		);

		// Finally, redirect back to the admin page.
		wp_safe_redirect( urldecode( $url ) );
		exit;

	}

	/**
	 * Creates the admin page
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function admin_page() {
		include( plugin_dir_path( __FILE__ ) . 'partials/joinment-auto-elementor-admin-page.php' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/joinment-auto-elementor-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/joinment-auto-elementor-admin.js', array( 'jquery' ), $this->version, false );

	}

}
