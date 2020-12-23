<?php defined( 'ABSPATH' ) || exit; ?>

<div class="bbp-single-forum-description"><?php do_action( 'bbp_template_before_topic_tag_description' );

	bbp_topic_tag_description();

	do_action( 'bbp_template_after_topic_tag_description' ); ?></div>
