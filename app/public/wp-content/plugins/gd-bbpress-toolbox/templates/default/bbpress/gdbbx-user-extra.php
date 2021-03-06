<div id="bbp-user-profile-extras" class="bbp-user-profile-extras">
    <h3><?php _e("Subscriptions and Favorites", "gd-bbpress-toolbox"); ?></h3>
    <p class="bbp-user-forum-subscriptions">
        <?php printf(esc_html__("Forums Subscriptions: %s", "gd-bbpress-toolbox"), gdbbx_user_profiles()->get_count_value('forum_subscriptions')); ?>
        <?php echo gdbbx_user_profiles()->get_action_link('forum_subscriptions'); ?>
    </p>
    <p class="bbp-user-topic-subscriptions">
        <?php printf(esc_html__("Topics Subscriptions: %s", "gd-bbpress-toolbox"), gdbbx_user_profiles()->get_count_value('topic_subscriptions')); ?>
        <?php echo gdbbx_user_profiles()->get_action_link('topic_subscriptions'); ?>
    </p>
    <p class="bbp-user-topic-favorite">
        <?php printf(esc_html__("Favorite Topics: %s", "gd-bbpress-toolbox"), gdbbx_user_profiles()->get_count_value('topic_favorites')); ?>
        <?php echo gdbbx_user_profiles()->get_action_link('topic_favorites'); ?>
    </p>
</div>