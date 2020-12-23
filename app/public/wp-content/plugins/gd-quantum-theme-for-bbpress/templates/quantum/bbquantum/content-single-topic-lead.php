<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-the-list bbp-list-content bbp-lead-topic">
    <div class="bbp-item bbp-header">
        <div class="bbp-item-info bbp-topic-info"><?php _e( "Author", "gd-quantum-theme-for-bbpress" ); ?></div>
        <div class="bbp-item-meta bbp-topic-meta">
            <div class="bbp-item-topic bbp-topic-content">
				<?php _e( "Topic", "gd-quantum-theme-for-bbpress" ); ?>

				<?php if ( ! gdqnt_customizer()->get( 'topic-actions-block' ) ) { ?>
                    <div class="bbp-post-user-controls">
						<?php gdqnt_theme()->topic_user_links(); ?>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
    <div class="bbp-item-wrapper">
        <div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class( 0, array( 'bbp-item', 'bbp-body' ) ); ?>>
            <div class="bbp-post-author">
				<?php

				do_action( 'bbp_theme_before_topic_author_details' );

				bbp_topic_author_link( array( 'show_role' => true, 'size' => 100, 'sep' => '' ) );

				if ( current_user_can( 'moderate', bbp_get_reply_id() ) ) :

					do_action( 'bbp_theme_before_topic_author_admin_details' );
					bbp_get_template_part( 'extra', 'topic-author-details' );
					do_action( 'bbp_theme_before_topic_author_admin_details' );

				endif;

				do_action( 'bbp_theme_after_topic_author_details' );

				?>
            </div>
            <div class="bbp-post-wrapper">
                <div class="bbp-post-controls">
                    <div class="bbp-meta">
                        <span class="bbp-post-date"><?php bbp_topic_post_date(); ?></span>
                        <a href="<?php bbp_topic_permalink(); ?>"
                                class="bbp-post-permalink">#<?php bbp_topic_id(); ?></a>

						<?php

						do_action( 'bbp_theme_before_topic_admin_links' );
						gdqnt_theme()->topic_admin_links();
						do_action( 'bbp_theme_after_topic_admin_links' );

						?>

                    </div>
                </div>
                <div class="bbp-post-content bbp-topic-content">
					<?php

					do_action( 'bbp_theme_before_topic_content' );
					bbp_topic_content();
					do_action( 'bbp_theme_after_topic_content' );

					?>
                </div>
            </div>
        </div>
    </div>
</div>
