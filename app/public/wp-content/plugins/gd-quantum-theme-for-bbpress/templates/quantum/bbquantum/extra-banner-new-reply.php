<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( gdqnt_customizer()->get( 'topic-action-new-reply' ) && gdqnt_customizer()->get( 'popup-reply-show-cta' ) && bbp_current_user_can_access_create_reply_form() ) { ?>

    <div class="bbp-banner-actions"><?php

		bbp_topic_new_reply_link();

		?></div>

<?php } ?>