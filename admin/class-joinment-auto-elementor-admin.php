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

	public function api_request() {
		// TODO api_url
		$api_url = '/malli/automaatti/joinment-auto-elementor-api';
		if ( $_SERVER["REQUEST_URI"] == $api_url ) {

			$this->save_template();

		} else {
			echo "Invalid request";
			exit();
		}
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

	/** Returns a list of templates
	 * @return mixed
	 */
	public function get_elementor_templates() {
		$dir = plugin_dir_path( __FILE__ ) . 'partials/elementor_templates/';

		return list_files( $dir );
	}

	/** Replaces raw JSON values
	 *
	 * @param $file
	 * @param $options
	 */
	public function get_elementor_template_json( $file, $options ) {
		$dir = plugin_dir_path( __FILE__ ) . 'partials/elementor_templates/';

		$raw_json = file_get_contents( $dir . $file );

		if ( ! $raw_json ) {
			//TODO fail
		}

		// Apply options
		$cooked_json = strtr( $raw_json, array(
			'%%title%%'           => $options['title'],
			'%%primary_text%%'    => $options['primary_text'],
			'%%primary_color%%'   => $options['primary_color'],
			'%%secondary_color%%' => $options['secondary_color'],
			'%%dark_color%%'      => $options['dark_color'],
			'%%cta1_text%%'       => $options['cta1_text'],
			'%%cta2_text%%'       => $options['cta2_text'],
			'%%image_cover%%'     => $options['image_cover'],
		) );

		return $cooked_json;
	}

	private function get_default_template_options() {
		return array(
			'title'              => 'Tervetuloa',
			'primary_text'       => 'Lorem ipsum',
			'primary_color'      => '#ff0000',
			'secondary_color'    => '#ff00ff',
			'dark_color'         => '#2f2f2f',
			'cta1_text'          => 'Tuotteemme',
			'cta2_text'          => 'Lue lisää',
			'image_cover'        => 'https://picsum.photos/1920/1080',
			'image_square'       => 'https://picsum.photos/960',
			'image_second_cover' => 'https://picsum.photos/1920/1080'
		);
	}

	/** Update the elementor post meta value
	 *
	 * @param $page_id
	 * @param $template_json
	 */
	public function update_elementor_page_json( $page_id, $template_json ) {
		update_post_meta( $page_id, '_elementor_data', $template_json );
		update_post_meta( $page_id, '_elementor_version', '0.4' );
		update_post_meta( $page_id, '_elementor_template_type', 'post' );
		update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	}

	/**
	 * Saves
	 */
	public function save_template() {

		// First, validate the nonce.
		// Secondly, verify the user has permission to save.
		// If the above are valid, save the option.

		// First, validate the nonce and verify the user as permission to save.
		//TODO security checks
		//if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
		// TODO: Display an error message.
		//}

		/**
		 * Defaults
		 */
		$template_options = $this->get_default_template_options();

		//print_r( $_POST );

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-title' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-title' ];

			$template_options['title'] = $value;

			update_option( $this->plugin_name . '-field-title', $value );
		}

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-primary-text' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-primary-text' ];

			$template_options['primary_text'] = $value;

			update_option( $this->plugin_name . '-field-primary-text', $value );
		}

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-primary-color' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-primary-color' ];

			$template_options['primary_color'] = $value;

			update_option( $this->plugin_name . '-field-primary-color', $value );
		}

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-secondary-color' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-secondary-color' ];

			$template_options['secondary_color'] = $value;

			update_option( $this->plugin_name . '-field-secondary-color', $value );
		}

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-dark-color' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-dark-color' ];

			$template_options['dark_color'] = $value;

			update_option( $this->plugin_name . '-field-dark-color', $value );
		}

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-cta1-text' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-cta1-text' ];

			$template_options['cta1_text'] = $value;

			update_option( $this->plugin_name . '-field-cta1_text', $value );
		}

		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-cta2-text' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-cta2-text' ];

			$template_options['cta2_text'] = $value;

			update_option( $this->plugin_name . '-field-cta2-text', $value );
		}


		$selected_page_id = null;

		/**
		 * Cover image
		 */
		if ( getimagesize( $_FILES[ $this->plugin_name . '-image-cover' ]["tmp_name"] ) !== false ) {
			$image_data = file_get_contents( $_FILES[ $this->plugin_name . '-image-cover' ]["tmp_name"] );
			$image_name = $_FILES[ $this->plugin_name . '-image-cover' ]["name"];

			// TODO do I have to check mime

			$image_url = $this->upload_to_media_library( $image_data, $image_name );

			$template_options['image_cover'] = $image_url;
		} else {
			//TODO fail
		}

		/**
		 * The page to modify. Deletes elementor css
		 */
		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-page-id' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-page-id' ];

			update_option( $this->plugin_name . '-field-page-id', $value );

			$selected_page_id = $value;
			$this->elementor_delete_css( $selected_page_id );
		}

		/**
		 * The template to use. Last check
		 */
		if ( null !== wp_unslash( $_POST[ $this->plugin_name . '-field-template' ] ) ) {
			$value = $_POST[ $this->plugin_name . '-field-template' ];

			if ( isset( $selected_page_id ) ) {

				$template_json = $this->get_elementor_template_json( $value, $template_options );

				//print_r( $template_json );

				// Start template creation process
				$this->update_elementor_page_json( $selected_page_id, $template_json );
			}
		}

		$this->redirect();
	}

	/** Uploads a file straight to wordpress media library and returns the url to it
	 *
	 * @param $image_data
	 * @param $image_name
	 */
	protected function upload_to_media_library( $image_data, $image_name ) {
		$upload_dir = wp_upload_dir();

		$filename = $image_name;

		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		file_put_contents( $file, $image_data );

		$wp_filetype = wp_check_filetype( $filename, null );

		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		//TODO check
		$attach_id = wp_insert_attachment( $attachment, $file );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		$image_path = $upload_dir['baseurl'] . '/' . $attach_data["file"];

		return $image_path;
	}

	/**
	 * Deletes the old elementor CSS file
	 */
	protected function elementor_delete_css( $post_id ) {
		if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
			$post_css = new Elementor\Core\Files\CSS\Post( $post_id );
			$post_css->delete();
		} else {
			//TODO unable to save elementor
		}
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
		if ( ! isset( $_POST[ $this->plugin_name . '-custom-message' ] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST[ $this->plugin_name . '-custom-message' ] );
		$action = $this->plugin_name . '-settings-save';

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

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jqcolorpicker', plugin_dir_url( __FILE__ ) . 'js/jqColorPicker.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/joinment-auto-elementor-admin.js', array(
			'jquery',
			'jqcolorpicker'
		), $this->version, true );

	}

}
