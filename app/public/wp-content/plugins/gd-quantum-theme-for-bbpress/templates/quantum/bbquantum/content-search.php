<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums" class="bbpress-content-search-results">

	<?php

	gdqnt_theme()->breadcrumbs();

	bbp_set_query_name( bbp_get_search_rewrite_id() );

	do_action( 'bbp_template_before_search' );

	?>

	<?php if ( gdqnt_customizer()->get( 'search-show-form' ) ) : ?>
        <div class="bbp-search-form">
			<?php bbp_get_template_part( 'form', 'search' ); ?>
        </div>
	<?php endif; ?>

	<?php

	if ( bbp_has_search_results() ) :
		bbp_get_template_part( 'pagination', 'search' );
		bbp_get_template_part( 'loop', 'search' );
		bbp_get_template_part( 'pagination', 'search' );
    elseif ( bbp_get_search_terms() ) :
		bbp_get_template_part( 'feedback', 'no-search' );
	endif;

	do_action( 'bbp_template_after_search_results' );

	?>

</div>
