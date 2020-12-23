<div class="bbp-user-profile-about">
    <h4><?php _e("Subscriptions and Favorites", "gd-bbpress-toolbox"); ?></h4>
    <p class="bbp-user-forum-subscriptions">
        <?php printf(esc_html__("Forums Subscriptions: %s", "gd-bbpress-toolbox"), '<strong>'.gdbbx_user_profiles()->get_count_value('forum_subscriptions').'</strong>'); ?>
        <?php echo gdbbx_user_profiles()->get_action_link('forum_subscriptions'); ?>
    </p>
    <p class="bbp-user-topic-subscriptions">
        <?php printf(esc_html__("Topics Subscriptions: %s", "gd-bbpress-toolbox"), '<strong>'.gdbbx_user_profiles()->get_count_value('topic_subscriptions').'</strong>'); ?>
        <?php echo gdbbx_user_profiles()->get_action_link('topic_subscriptions'); ?>
    </p>
    <p class="bbp-user-topic-favorite">
        <?php printf(esc_html__("Favorite Topics: %s", "gd-bbpress-toolbox"), '<strong>'.gdbbx_user_profiles()->get_count_value('topic_favorites').'</strong>'); ?>
        <?php echo gdbbx_user_profiles()->get_action_link('topic_favorites'); ?>
    </p>
</div>
