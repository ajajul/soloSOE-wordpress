<?php defined( 'ABSPATH' ) || exit; ?>

<li id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class( 0, array( 'bbp-item', 'bbp-body' ) ); ?>>
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

				<?php

				do_action( 'bbp_theme_before_reply_admin_links' );
				gdqnt_theme()->reply_admin_links();
				do_action( 'bbp_theme_after_reply_admin_links' );

				?>
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
</li>