<?php defined( 'ABSPATH' ) || exit; ?>

<div class="bbp-banner-actions bbp-banner-for-topic"><?php

	if ( gdqnt_customizer()->get( 'topic-action-new-reply' ) && bbp_current_user_can_access_create_reply_form() ) {
		bbp_topic_new_reply_link();
	}

	bbp_topic_subscription_link();
	bbp_topic_favorite_link();

	?></div>
