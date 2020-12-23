<?php defined( 'ABSPATH' ) || exit; ?>

<div id="bbpress-forums" class="bbpress-content-topic-archive">

	<?php if ( bbp_allow_search() && ! bbp_is_topic_tag() ) : ?>
        <div class="bbp-search-form">
			<?php bbp_get_template_part( 'form', 'search' ); ?>
        </div>
	<?php endif; ?>

	<?php

	gdqnt_theme()->breadcrumbs();

	bbp_topics_archive_description();

	if ( bbp_is_topic_tag() ) {
		bbp_get_template_part( 'extra', 'topic-tag-description' );
	}

	do_action( 'bbp_template_before_topics_index' );

	if ( bbp_has_topics() ) :
		bbp_get_template_part( 'pagination', 'topics' );
		bbp_get_template_part( 'loop', 'topics' );
		bbp_get_template_part( 'pagination', 'topics' );
	else :
		bbp_get_template_part( 'feedback', 'no-topics' );
	endif;

	do_action( 'bbp_template_after_topics_index' );

	?>

</div>
