<?php defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

    <div id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-the-list bbp-topics">
        <div class="bbp-item bbp-header">
            <div class="bbp-item-info bbp-topic-info"><?php _e( "Topic", "gd-quantum-theme-for-bbpress" ); ?></div>
            <div class="bbp-item-meta bbp-topic-meta">
                <div class="bbp-item-count bbp-topic-voice-count"><i aria-hidden="true"
                            class="gdqnt-icon gdqnt-icon-users"
                            title="<?php _e( "Voices", "gd-quantum-theme-for-bbpress" ); ?>"></i><span
                            class="screen-reader-text hidden"><?php _e( "Voices", "gd-quantum-theme-for-bbpress" ); ?></span>
                </div>
                <div class="bbp-item-count bbp-topic-reply-count"><i aria-hidden="true"
                            class="gdqnt-icon gdqnt-icon-reply"
                            title="<?php _e( "Replies", "gd-quantum-theme-for-bbpress" ); ?>"></i><span
                            class="screen-reader-text hidden"><?php _e( "Replies", "gd-quantum-theme-for-bbpress" ); ?></span>
                </div>
                <div class="bbp-item-activity bbp-forum-activity"><?php _e( "Last Post", "gd-quantum-theme-for-bbpress" ); ?></div>
            </div>
        </div>

        <div class="bbp-body">
            <ul class="bbp-items-list">
				<?php

				while ( bbp_topics() ) : bbp_the_topic();
					bbp_get_template_part( 'loop', 'single-topic' );
				endwhile;

				?>
            </ul>
        </div>
    </div>

<?php do_action( 'bbp_template_after_topics_loop' );
