<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums">
	<?php

	do_action( 'bbp_quantum_template_single_topic_start' );

	gdqnt_theme()->breadcrumbs();

	do_action( 'bbp_template_before_single_topic' );

	if ( post_password_required() ) :
		bbp_get_template_part( 'form', 'protected' );
	else :

		bbp_single_topic_description( array( 'size' => 16 ) );

		if ( gdqnt_customizer()->get( 'topic-actions-block' ) ) {
			bbp_get_template_part( 'extra', 'topic-actions' );
		}

		bbp_topic_tag_list( 0, array( 'sep'    => ' ',
		                              'before' => '<div class="bbp-topic-tags"><p>' . esc_html__( "Tags:", "gd-quantum-theme-for-bbpress" ) . ' '
		) );

		if ( bbp_show_lead_topic() ) :
			bbp_get_template_part( 'content', 'single-topic-lead' );
		endif;

		if ( bbp_has_replies() ) :
			bbp_get_template_part( 'pagination', 'replies' );
			bbp_get_template_part( 'loop', 'replies' );
			bbp_get_template_part( 'pagination', 'replies' );
		endif;

		bbp_get_template_part( 'form', 'reply' );

	endif;

	bbp_get_template_part( 'alert', 'topic-lock' );

	do_action( 'bbp_template_after_single_topic' );

	?>
</div>