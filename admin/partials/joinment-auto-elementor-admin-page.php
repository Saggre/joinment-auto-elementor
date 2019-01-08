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
        <div>
            <h2>Page options</h2>

            <div class="options">
                <p>
                    <label>Which page would you want to create automatically?</label>
                    <br/>

					<?php
					$pages            = get_pages();
					$front_page_id    = get_option( 'page_on_front' );
					$selected_page_id = get_option( $this->plugin_name . '-field-page-id', $front_page_id );
					?>

                    <select name="<?php echo $this->plugin_name ?>-field-page-id">
						<?php
						foreach ( $pages as $page ) {
							?>
                            <option value="<?php echo $page->ID ?>" <?php echo( $page->ID == $selected_page_id ? "selected" : "" ) ?>>
								<?php echo $page->post_title ?>
                            </option>
							<?php
						}
						?>
                    </select>
                </p>
                <p>
                    <label>What would you like as the main title?</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-title"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-title', 'Title' ) ); ?>"/>
                </p>
                <p>
                    <label>What is the primary color?</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-main-color" class="colorpicker"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-main-color', '#FFFFFF' ) ); ?>"/>
                </p>

            </div><!-- #universal-message-container -->
		<?php
		wp_nonce_field( $this->plugin_name . '-settings-save', $this->plugin_name . '-custom-message' );
		submit_button( 'Save Settings' );
		?></form>
</div>