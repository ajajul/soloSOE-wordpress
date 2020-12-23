<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbp-user-profile">
	<?php do_action( 'bbp_template_before_user_profile' ); ?>

    <div class="bbp-user-profile-about">
        <h4><?php _e( "Activity", "gd-quantum-theme-for-bbpress" ); ?></h4>
        <p class="bbp-user-last-activity"><?php printf( esc_html__( "Last Activity: %s", "gd-quantum-theme-for-bbpress" ), '<strong>' . bbp_get_time_since( bbp_get_user_last_posted(), false, true ) . '</strong>' ); ?></p>
    </div>

    <div class="bbp-user-profile-about">
        <h4><?php _e( "Basic Activity", "gd-quantum-theme-for-bbpress" ); ?></h4>
        <p class="bbp-user-topic-count"><?php printf( esc_html__( "Topics Started: %s", "gd-quantum-theme-for-bbpress" ), '<strong>' . bbp_get_user_topic_count() . '</strong>' ); ?></p>
        <p class="bbp-user-reply-count"><?php printf( esc_html__( "Replies Created: %s", "gd-quantum-theme-for-bbpress" ), '<strong>' . bbp_get_user_reply_count() . '</strong>' ); ?></p>
    </div>

	<?php if ( bbp_get_displayed_user_field( 'description' ) ) : ?>
        <div class="bbp-user-profile-about">
            <h4><?php _e( "About", "gd-quantum-theme-for-bbpress" ); ?></h4>
            <p class="bbp-user-description"><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'description' ) ); ?></p>
        </div>
	<?php endif; ?>

	<?php do_action( 'bbp_template_after_user_profile' ); ?>
</div>