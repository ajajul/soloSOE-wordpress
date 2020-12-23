<?php defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>-replies"
        class="bbp-the-list bbp-list-content bbp-list-replies <?php if ( bbp_show_lead_topic() ) {
			echo 'bbp-with-lead-topic';
		} ?>">
    <div class="bbp-item bbp-header">
        <div class="bbp-item-info bbp-topic-info"><?php _e( "Author", "gd-quantum-theme-for-bbpress" ); ?></div>
        <div class="bbp-item-meta bbp-topic-meta">
            <div class="bbp-item-topic bbp-topic-content">
				<?php bbp_show_lead_topic() ? esc_html_e( "Replies", "gd-quantum-theme-for-bbpress" ) : esc_html_e( "Posts", "gd-quantum-theme-for-bbpress" ); ?>

				<?php if ( ! bbp_show_lead_topic() && ! gdqnt_customizer()->get( 'topic-actions-block' ) ) { ?>
                    <div class="bbp-post-user-controls">
						<?php gdqnt_theme()->topic_user_links(); ?>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>

    <div class="bbp-items">
        <ul class="bbp-items-list">
			<?php

			if ( bbp_thread_replies() ) :
				gdqnt_list_threaded_replies();
			else :
				while ( bbp_replies() ) : bbp_the_reply();
					bbp_get_template_part( 'loop', 'single-reply' );
				endwhile;
			endif;

			?>
        </ul>
    </div>
</div>