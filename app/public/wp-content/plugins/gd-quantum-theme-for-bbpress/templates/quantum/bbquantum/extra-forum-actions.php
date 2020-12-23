<?php defined( 'ABSPATH' ) || exit; ?>

<div class="bbp-banner-actions bbp-banner-for-forum"><?php

	if ( gdqnt_customizer()->get( 'forum-action-new-topic' ) && bbp_current_user_can_access_create_topic_form() && ! bbp_is_forum_category() ) {
		bbp_forum_new_topic_link();
	}

	bbp_forum_subscription_link();

	?></div>
