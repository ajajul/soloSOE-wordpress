<?php defined( 'ABSPATH' ) || exit; ?>

<li id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>
    <div class="bbp-search-result-header">
        <div class="bbp-topic-title">
            <h3><?php esc_html_e( "Topic: ", "gd-quantum-theme-for-bbpress" ); ?>
                <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
            </h3>
        </div>
    </div>
    <div class="bbp-item bbp-body">
        <div class="bbp-post-author">
			<?php

			do_action( 'bbp_theme_before_topic_author_details' );

			bbp_topic_author_link( array( 'show_role' => true, 'size' => 100, 'sep' => '' ) );

			if ( current_user_can( 'moderate', bbp_get_topic_id() ) ) :

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
                    <a href="<?php bbp_topic_permalink(); ?>" class="bbp-post-permalink">#<?php bbp_topic_id(); ?></a>
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
</li>