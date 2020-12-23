<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( bbp_is_user_home() ) : ?>

	<?php if ( bbp_is_favorites() ) : ?>

        <span class="bbp-row-actions">
            <?php

            do_action( 'bbp_theme_before_topic_favorites_action' );
            bbp_topic_favorite_link( array( 'profile'   => true,
                                            'before'    => '',
                                            'favorite'  => '+',
                                            'favorited' => '<i title="' . esc_attr__( "Remove from Favorites", "gd-quantum-theme-for-bbpress" ) . '" class="gdqnt-icon gdqnt-icon-clear"></i>'
            ) );
            do_action( 'bbp_theme_after_topic_favorites_action' );

            ?>
        </span>

	<?php elseif ( bbp_is_subscriptions() ) : ?>

        <span class="bbp-row-actions">
            <?php

            do_action( 'bbp_theme_before_topic_subscription_action' );
            bbp_topic_subscription_link( array( 'profile'     => true,
                                                'before'      => '',
                                                'subscribe'   => '+',
                                                'unsubscribe' => '<i title="' . esc_attr__( "Unsubscribe", "gd-quantum-theme-for-bbpress" ) . '" class="gdqnt-icon gdqnt-icon-clear"></i>'
            ) );
            do_action( 'bbp_theme_after_topic_subscription_action' );

            ?>

        </span>

	<?php endif; ?>

<?php endif; ?>