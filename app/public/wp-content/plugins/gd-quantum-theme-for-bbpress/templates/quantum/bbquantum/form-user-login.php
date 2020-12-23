<?php defined( 'ABSPATH' ) || exit; ?>

<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form">
    <fieldset class="bbp-form">
        <legend><?php esc_html_e( "Log In", "gd-quantum-theme-for-bbpress" ); ?></legend>

        <div class="bbp-username">
            <label for="user_login"><?php esc_html_e( "Username", "gd-quantum-theme-for-bbpress" ); ?>: </label>
            <input type="text" name="log" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" size="20"
                    maxlength="100" id="user_login" autocomplete="off"/>
        </div>

        <div class="bbp-password">
            <label for="user_pass"><?php esc_html_e( "Password", "gd-quantum-theme-for-bbpress" ); ?>: </label>
            <input type="password" name="pwd" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" size="20"
                    id="user_pass" autocomplete="off"/>
        </div>

        <div class="bbp-remember-me">
            <input type="checkbox" name="rememberme"
                    value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ) ); ?> id="rememberme"/>
            <label for="rememberme"><?php esc_html_e( "Keep me signed in", "gd-quantum-theme-for-bbpress" ); ?></label>
        </div>

		<?php do_action( 'login_form' ); ?>

        <div class="bbp-submit-wrapper">

            <button type="submit" name="user-submit" id="user-submit"
                    class="button submit user-submit"><?php esc_html_e( "Log In", "gd-quantum-theme-for-bbpress" ); ?></button>

			<?php bbp_user_login_fields(); ?>

        </div>
    </fieldset>
</form>
