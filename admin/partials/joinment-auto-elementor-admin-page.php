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
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-title', 'Tervetuloa' ) ); ?>"/>
                </p>
                <p>
                    <label>Main text area.</label>
                    <br/>
                    <textarea rows="5" cols="60" type="text"
                              name="<?php echo $this->plugin_name ?>-field-primary-text"><?php echo esc_attr( get_option( $this->plugin_name . '-field-primary-text', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' ) ); ?></textarea>

                </p>
                <p>
                    <label>First call-to-action?</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-cta1-text"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-cta1-text', 'Tuotteemme' ) ); ?>"/>
                </p>
                <p>

                    <label>Second call-to-action?</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-cta2-text"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-cta2-text', 'Lue lisää' ) ); ?>"/>

                </p>
                <p>
                    <label>What is the primary color?</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-primary-color" class="colorpicker"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-primary-color', '#FFFFFF' ) ); ?>"/>
                </p>
                <p>
                    <label>What is the secondary color?</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-secondary-color" class="colorpicker"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-secondary-color', '#F2F2F2' ) ); ?>"/>
                </p>
                <p>
                    <label>What is the dark accent color? (hover buttons)</label>
                    <br/>
                    <input type="text" name="<?php echo $this->plugin_name ?>-field-dark-color" class="colorpicker"
                           value="<?php echo esc_attr( get_option( $this->plugin_name . '-field-dark-color', '#CCCCCC' ) ); ?>"/>
                </p>
                <p>
                    <label>Which template to use?</label>
                    <br/>
                    <select name="<?php echo $this->plugin_name ?>-field-template">

						<?php
						$templates        = $this->get_elementor_templates();
						$default_template = $templates[0];
						foreach ( $templates as $template ) {
							$file = wp_basename( $template );
							?>
                            <option value="<?php echo $file ?>" <?php echo( $template == $default_template ? "selected" : "" ) ?>>
								<?php echo $file ?>
                            </option>
							<?php
						}
						?>

                    </select>

                </p>

            </div><!-- #universal-message-container -->
		<?php
		wp_nonce_field( $this->plugin_name . '-settings-save', $this->plugin_name . '-custom-message' );
		submit_button( 'Apply' );
		?></form>
</div>