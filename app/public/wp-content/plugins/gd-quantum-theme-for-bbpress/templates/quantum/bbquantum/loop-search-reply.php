<?php defined( 'ABSPATH' ) || exit; ?>

<li id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>
    <div class="bbp-search-result-header">
        <div class="bbp-reply-title">
            <h3><?php esc_html_e( "In reply to: ", "gd-quantum-theme-for-bbpress" ); ?>
                <a class="bbp-topic-permalink"
                        href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
            </h3>
        </div>
    </div>
    <div class="bbp-item bbp-body">
        <div class="bbp-post-author">
			<?php

			do_action( 'bbp_theme_before_reply_author_details' );

			bbp_reply_author_link( array( 'show_role' => true, 'size' => 100, 'sep' => '' ) );

			if ( current_user_can( 'moderate', bbp_get_reply_id() ) ) :

				do_action( 'bbp_theme_before_reply_author_admin_details' );
				bbp_get_template_part( 'extra', 'reply-author-details' );
				do_action( 'bbp_theme_before_reply_author_admin_details' );

			endif;

			do_action( 'bbp_theme_after_reply_author_details' );

			?>
        </div>
        <div class="bbp-post-wrapper">
            <div class="bbp-post-controls">
                <div class="bbp-meta">
                    <span class="bbp-post-date"><?php bbp_reply_post_date(); ?></span>
                    <a href="<?php bbp_reply_url(); ?>" class="bbp-post-permalink">#<?php bbp_reply_id(); ?></a>
                </div>
            </div>
            <div class="bbp-post-content bbp-reply-content">
				<?php

				do_action( 'bbp_theme_before_reply_content' );
				bbp_reply_content();
				do_action( 'bbp_theme_after_reply_content' );

				?>
            </div>
        </div>
    </div>
</li>