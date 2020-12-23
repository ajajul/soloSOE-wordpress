<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums">
	<?php

	do_action( 'bbp_quantum_template_single_topic_start' );

	gdqnt_theme()->breadcrumbs();

	do_action( 'bbp_template_before_single_view' );

	bbp_set_query_name( bbp_get_view_rewrite_id() );

	if ( bbp_view_query() ) :
		bbp_get_template_part( 'pagination', 'topics' );
		bbp_get_template_part( 'loop', 'topics' );
		bbp_get_template_part( 'pagination', 'topics' );
	else :
		bbp_get_template_part( 'feedback', 'no-topics' );
	endif;

	bbp_reset_query_name();

	do_action( 'bbp_template_after_single_view' );

	?>
</div>
