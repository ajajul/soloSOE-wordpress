<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( apply_filters( 'show_password_fields', true, bbpress()->displayed_user ) ) : ?>

    <div id="password" class="user-pass1-wrap">
        <label for="user_login"><?php esc_html_e( "Password", "gd-quantum-theme-for-bbpress" ); ?></label>
        <div>
            <button type="button"
                    class="gdqnt-button button wp-generate-pw hide-if-no-js"><?php esc_html_e( "Generate Password", "gd-quantum-theme-for-bbpress" ); ?></button>
        </div>

        <fieldset class="password wp-pwd hide-if-js">
		<span class="password-input-wrapper">
			<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off"
                    data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result"/>
		</span>

            <span class="password-button-wrapper">
			<button type="button" class="gdqnt-button button wp-hide-pw hide-if-no-js" data-toggle="0"
                    aria-label="<?php esc_attr_e( "Hide password", "gd-quantum-theme-for-bbpress" ); ?>">
				<span class="text"><?php esc_html_e( "Hide", "gd-quantum-theme-for-bbpress" ); ?></span>
			</button><button type="button" class="gdqnt-button button wp-cancel-pw hide-if-no-js" data-toggle="0"
                        aria-label="<?php esc_attr_e( "Cancel password change", "gd-quantum-theme-for-bbpress" ); ?>">
				<span class="text"><?php esc_html_e( "Cancel", "gd-quantum-theme-for-bbpress" ); ?></span>
			</button>
		</span>

            <div style="display:none" id="pass-strength-result" aria-live="polite"></div>
        </fieldset>

        <div class="pw-weak">
            <input type="checkbox" name="pw_weak" class="pw-checkbox checkbox"/>
            <label for="pw_weak"><?php esc_html_e( "Confirm", "gd-quantum-theme-for-bbpress" ); ?></label>
            <p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
        </div>

        <div class="user-pass2-wrap hide-if-js">
            <label for="pass2"><?php esc_html_e( "Repeat New Password", "gd-quantum-theme-for-bbpress" ); ?></label>
            <input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off"/>
            <p class="description"><?php esc_html_e( "Type your new password again.", "gd-quantum-theme-for-bbpress" ); ?></p>
        </div>
    </div>

<?php endif;
