<?php defined( 'ABSPATH' ) || exit; ?>

<li id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
    <div class="bbp-item bbp-row">
        <div class="bbp-item-info bbp-topic-info bbp-topic-title">
			<?php bbp_get_template_part( 'extra', 'topic-user-controls' ); ?>

			<?php do_action( 'bbp_theme_before_topic_title' ); ?>

            <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>

			<?php do_action( 'bbp_theme_after_topic_title' ); ?>

			<?php bbp_topic_pagination(); ?>

			<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

            <p class="bbp-topic-meta">

				<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

                <span class="bbp-topic-started-by"><?php printf( __( 'Started by: %1$s', "gd-quantum-theme-for-bbpress" ), bbp_get_topic_author_link( array( 'size' => '16' ) ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

				<?php if ( ! bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

					<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

                    <span class="bbp-topic-started-in"><?php printf( __( "in: <a href='%s'>%s</a>", "gd-quantum-theme-for-bbpress" ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></span>

					<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

				<?php endif; ?>

            </p>

			<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

			<?php bbp_topic_row_actions(); ?>

            <div class="bbp-topic-counts gdqnt-visible-md gdqnt-visible-sm">
				<?php bbp_topic_voices_and_replies_counts(); ?>
            </div>
        </div>
        <div class="bbp-item-meta bbp-topic-meta">
            <div class="bbp-item-count bbp-topic-voice-count">
				<?php bbp_topic_voice_count(); ?>
            </div>
            <div class="bbp-item-count bbp-topic-reply-count">
				<?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?>
            </div>
            <div class="bbp-item-activity bbp-forum-activity">
                <span class="gdqnt-visible-sm gdqnt-inline"><?php _e( "Last Post", "gd-quantum-theme-for-bbpress" ); ?>: </span>
				<?php

				do_action( 'bbp_theme_before_topic_freshness_link' );
				bbp_topic_freshness_link();
				do_action( 'bbp_theme_after_topic_freshness_link' );

				?>

                <p class="bbp-topic-meta">
					<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

                    <span class="bbp-topic-freshness-author"><?php bbp_author_link( array(
							'post_id' => bbp_get_topic_last_active_id(),
							'size'    => 16
						) ); ?></span>

					<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>
                </p>
            </div>
        </div>
    </div>
</li>
