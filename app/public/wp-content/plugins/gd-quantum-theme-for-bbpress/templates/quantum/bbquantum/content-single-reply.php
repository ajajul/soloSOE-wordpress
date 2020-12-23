<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums">
	<?php

	do_action( 'bbp_quantum_template_single_reply_start' );

	gdqnt_theme()->breadcrumbs();

	do_action( 'bbp_template_before_single_reply' );

	if ( post_password_required() ) :
		bbp_get_template_part( 'form', 'protected' );
	else :

		?>

        <div id="bbp-reply-<?php bbp_reply_id(); ?>" class="bbp-the-list bbp-list-content bbp-list-replies">
            <div class="bbp-item bbp-header">
                <div class="bbp-item-info bbp-topic-info"><?php _e( "Author", "gd-quantum-theme-for-bbpress" ); ?></div>
                <div class="bbp-item-meta bbp-topic-meta">
                    <div class="bbp-item-topic bbp-topic-content">
						<?php _e( "Reply", "gd-quantum-theme-for-bbpress" ); ?>
                    </div>
                </div>
            </div>
            <div class="bbp-items">
                <ul class="bbp-items-list">

					<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

                </ul>
            </div>
        </div>

	<?php

	endif;

	do_action( 'bbp_template_after_single_reply' );

	?>
</div>