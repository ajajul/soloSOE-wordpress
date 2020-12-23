<?php global $_meta; ?>

<input type="hidden" name="gdbbx_privacy_forum_meta" value="edit" />

<h4><?php _e("Private Content Checkbox", "gd-bbpress-toolbox"); ?>:</h4>
<p>
    <label for="gdbbx_settings_privacy_enable_topic_private"><?php _e("Enable for topic form", "gd-bbpress-toolbox"); ?></label>
    <?php d4p_render_select(gdbbx_select_forum_settings(), array('id' => 'gdbbx_settings_privacy_enable_topic_private', 'name' => 'gdbbx_settings[privacy_enable_topic_private]', 'class' => 'widefat', 'selected' => $_meta['privacy_enable_topic_private'])); ?>
</p>
<p>
    <label for="gdbbx_settings_privacy_enable_reply_private"><?php _e("Enable for reply form", "gd-bbpress-toolbox"); ?></label>
    <?php d4p_render_select(gdbbx_select_forum_settings(), array('id' => 'gdbbx_settings_privacy_enable_reply_private', 'name' => 'gdbbx_settings[privacy_enable_reply_private]', 'class' => 'widefat', 'selected' => $_meta['privacy_enable_reply_private'])); ?>
</p>
