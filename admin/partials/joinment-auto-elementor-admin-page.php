<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Now Hiring
 * @subpackage Now Hiring/admin/partials
 */
?>
<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>"><?php
		//settings_fields( $this->plugin_name . '-options' );
		//do_settings_sections( $this->plugin_name );

		?>
        <div id="universal-message-container">
            <h2>Universal Message</h2>

            <div class="options">
                <p>
                    <label>What message would you like to display above each post?</label>
                    <br/>
                    <input type="text" name="acme-message"
                           value="<?php echo esc_attr( get_option( 'tutsplus-custom-data' ) ); ?>"
                    />
                </p>
            </div><!-- #universal-message-container -->
		<?php
		wp_nonce_field( 'acme-settings-save', 'acme-custom-message' );
		submit_button( 'Save Settings' );
		?></form>
</div>