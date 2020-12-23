<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums">
    <fieldset class="bbp-form" id="bbp-protected">
        <Legend><?php esc_html_e( "Protected", "gd-quantum-theme-for-bbpress" ); ?></legend>

		<?php echo get_the_password_form(); ?>

    </fieldset>
</div>