<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( gdqnt_theme()->is() && bbp_show_topic_lock_alert() ) : ?>

	<?php do_action( 'bbp_theme_before_alert_topic_lock' ); ?>

    <div class="bbp-alert-outer">
        <div class="bbp-alert-inner">
            <p class="bbp-alert-description"><?php bbp_topic_lock_description(); ?></p>
            <p class="bbp-alert-actions">
                <a class="bbp-alert-back"
                        href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php esc_html_e( "Leave", "gd-quantum-theme-for-bbpress" ); ?></a>
                <a class="bbp-alert-close" href="#"><?php esc_html_e( "Stay", "gd-quantum-theme-for-bbpress" ); ?></a>
            </p>
        </div>
    </div>

	<?php do_action( 'bbp_theme_after_alert_topic_lock' ); ?>

<?php endif;
