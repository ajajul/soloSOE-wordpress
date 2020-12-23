<li id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
    <div class="bbp-item bbp-row">
        <div class="bbp-item-info bbp-forum-info">
            <div class="bbp-forum-basic">
				<?php bbp_get_template_part( 'extra', 'forum-user-controls' ); ?>

				<?php do_action( 'bbp_theme_before_forum_title' ); ?>

                <a class="bbp-item-info-title bbp-forum-title" href="<?php bbp_forum_permalink(); ?>">
					<?php bbp_forum_title(); ?>
                </a>

				<?php do_action( 'bbp_theme_after_forum_title' ); ?>

				<?php do_action( 'bbp_theme_before_forum_description' ); ?>

                <div class="bbp-forum-content">
					<?php bbp_forum_content(); ?>
                </div>

				<?php do_action( 'bbp_theme_after_forum_description' ); ?>
            </div>

			<?php

			if ( gdqnt_customizer()->get( 'forum-list-subforums' ) ) {
				do_action( 'bbp_theme_before_forum_sub_forums' );
				bbp_list_forums( array(
					'separator' => '',
					'sep'       => '',
					'forum_id'  => bbp_get_forum_id(),
					'before'    => '<ul class="bbp-item-info-list bbp-forums-list">'
				) );
				do_action( 'bbp_theme_after_forum_sub_forums' );
			}

			bbp_forum_row_actions();

			?>

            <div class="bbp-forum-counts gdqnt-visible-md gdqnt-visible-sm">
				<?php bbp_forum_topics_and_replies_counts(); ?>
            </div>
        </div>
        <div class="bbp-item-meta bbp-forum-meta">
            <div class="bbp-item-count bbp-forum-topic-count">
				<?php bbp_forum_topic_count(); ?>
            </div>

            <div class="bbp-item-count bbp-forum-reply-count">
				<?php bbp_forum_reply_count(); ?>
            </div>
			<?php if ( gdqnt_customizer()->get( 'forum-colum-four' ) == 'freshness' ) { ?>
                <div class="bbp-item-freshness bbp-forum-freshness">
                    <span class="gdqnt-visible-sm gdqnt-inline"><?php _e( "Freshness", "gd-quantum-theme-for-bbpress" ); ?>: </span>
					<?php

					do_action( 'bbp_theme_before_forum_freshness_link' );
					bbp_forum_freshness_link();
					do_action( 'bbp_theme_after_forum_freshness_link' );

					?>
					<?php if ( ! empty( bbp_get_forum_last_active_time() ) ) { ?>
                        <p class="bbp-freshness-meta">
							<?php do_action( 'bbp_theme_before_topic_author' ); ?>

                            <span class="bbp-topic-freshness-author"><?php bbp_author_link( array(
									'post_id' => bbp_get_forum_last_active_id(),
									'size'    => 16
								) ); ?></span>

							<?php do_action( 'bbp_theme_after_topic_author' ); ?>
                        </p>
					<?php } ?>
                </div>
			<?php } else { ?>
                <div class="bbp-item-activity bbp-forum-activity">
                    <span class="gdqnt-visible-sm gdqnt-inline"><?php _e( "Last Activity", "gd-quantum-theme-for-bbpress" ); ?>: </span>
					<?php

					do_action( 'bbp_theme_before_forum_last_activity_link' );
					bbp_forum_last_activity_link();
					do_action( 'bbp_theme_after_forum_last_activity_link' );

					?>
					<?php if ( ! empty( bbp_get_forum_last_active_time() ) ) { ?>
                        <p class="bbp-activity-meta">
							<?php do_action( 'bbp_theme_before_last_activity_meta' ); ?>

                            <span class="bbp-last-activity-date"><?php bbp_forum_last_activity_date(); ?></span>
                            &middot;
                            <span class="bbp-last-activity-author"><?php bbp_author_link( array(
									'post_id' => bbp_get_forum_last_active_id(),
									'size'    => 16
								) ); ?></span>

							<?php do_action( 'bbp_theme_after_last_activity_meta' ); ?>
                        </p>
					<?php } ?>
                </div>
			<?php } ?>
        </div>
    </div>
</li>
