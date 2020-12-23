<?php defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

    <div id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-the-list bbp-forums">

        <div class="bbp-item bbp-header">
            <div class="bbp-item-info bbp-forum-info"><?php _e( "Forum", "gd-quantum-theme-for-bbpress" ); ?></div>
            <div class="bbp-item-meta bbp-forum-meta">
                <div class="bbp-item-count bbp-forum-topic-count"><i aria-hidden="true"
                            class="gdqnt-icon gdqnt-icon-topic"
                            title="<?php _e( "Topics", "gd-quantum-theme-for-bbpress" ); ?>"></i><span
                            class="screen-reader-text hidden"><?php _e( "Topics", "gd-quantum-theme-for-bbpress" ); ?></span>
                </div>
                <div class="bbp-item-count bbp-forum-reply-count"><i aria-hidden="true"
                            class="gdqnt-icon gdqnt-icon-reply"
                            title="<?php _e( "Replies", "gd-quantum-theme-for-bbpress" ); ?>"></i><span
                            class="screen-reader-text hidden"><?php _e( "Replies", "gd-quantum-theme-for-bbpress" ); ?></span>
                </div>
				<?php if ( gdqnt_customizer()->get( 'forum-colum-four' ) == 'freshness' ) { ?>
                    <div class="bbp-item-freshness bbp-forum-freshness"><?php _e( "Freshness", "gd-quantum-theme-for-bbpress" ); ?></div>
				<?php } else { ?>
                    <div class="bbp-item-activity bbp-forum-activity"><?php _e( "Last Activity", "gd-quantum-theme-for-bbpress" ); ?></div>
				<?php } ?>
            </div>
        </div>

        <div class="bbp-body">
            <ul class="bbp-items-list">
				<?php

				while ( bbp_forums() ) : bbp_the_forum();
					bbp_get_template_part( 'loop', 'single-forum' );
				endwhile;

				?>
            </ul>
        </div>

    </div>

<?php do_action( 'bbp_template_after_forums_loop' );
