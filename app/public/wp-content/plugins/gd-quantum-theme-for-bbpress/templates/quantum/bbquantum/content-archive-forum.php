<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums" class="bbpress-content-forum-archive">
	<?php do_action( 'bbp_quantum_template_forums_index_start' ); ?>

	<?php if ( bbp_allow_search() ) : ?>
        <div class="bbp-search-form">
			<?php bbp_get_template_part( 'form', 'search' ); ?>
        </div>
	<?php endif; ?>

	<?php

	gdqnt_theme()->breadcrumbs();

	do_action( 'bbp_template_before_forums_index' );

	if ( bbp_has_forums() ) :
		bbp_get_template_part( 'loop', 'forums' );
	else :
		bbp_get_template_part( 'feedback', 'no-forums' );
	endif;

	do_action( 'bbp_template_after_forums_index' );

	?>
</div>
