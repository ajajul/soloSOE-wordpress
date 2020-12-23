<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( gdqnt_customizer()->get( 'forum-action-new-topic' ) && gdqnt_customizer()->get( 'popup-topic-show-cta' ) && bbp_current_user_can_access_create_topic_form() && ! bbp_is_forum_category() ) { ?>

    <div class="bbp-banner-actions"><?php

		bbp_forum_new_topic_link();

		?></div>

<?php } ?>