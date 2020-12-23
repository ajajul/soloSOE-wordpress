<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( bbp_is_user_home() && bbp_is_subscriptions() ) : ?>

    <span class="bbp-row-actions">
        <?php

        do_action( 'bbp_theme_before_forum_subscription_action' );
        bbp_forum_subscription_link( array( 'profile'     => true,
                                            'before'      => '',
                                            'subscribe'   => '+',
                                            'unsubscribe' => '<i title="' . esc_attr__( "Unsubscribe", "gd-quantum-theme-for-bbpress" ) . '" class="gdqnt-icon gdqnt-icon-clear"></i>'
        ) );
        do_action( 'bbp_theme_after_forum_subscription_action' );

        ?>
    </span>

<?php endif; ?>