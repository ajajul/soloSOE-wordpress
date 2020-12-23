<?php global $_meta; ?>

<h4><?php _e("Lock topic form", "gd-bbpress-toolbox"); ?>:</h4>
<p>
    <label for="gdbbx_settings_privacy_lock_topic_form"><?php _e("Status", "gd-bbpress-toolbox"); ?></label>
    <?php d4p_render_select(gdbbx_select_forum_settings(), array('id' => 'gdbbx_settings_privacy_lock_topic_form', 'name' => 'gdbbx_settings[privacy_lock_topic_form]', 'class' => 'widefat', 'selected' => $_meta['privacy_lock_topic_form'])); ?>
</p>
<p>
    <label for="gdbbx_settings_privacy_lock_topic_form_message"><?php _e("Lock Message", "gd-bbpress-toolbox"); ?></label>
    <input name="gdbbx_settings[privacy_lock_topic_form_message]" id="gdbbx_settings_privacy_lock_topic_form_message" value="<?php echo esc_attr($_meta['privacy_lock_topic_form_message']) ?>" class="widefat" type="text" />
    <em><?php _e("Leave empty to use global lock message.", "gd-bbpress-toolbox"); ?></em>
</p>
<hr/>
<h4><?php _e("Lock reply form", "gd-bbpress-toolbox"); ?>:</h4>
<p>
    <label for="gdbbx_settings_privacy_lock_reply_form"><?php _e("Status", "gd-bbpress-toolbox"); ?></label>
    <?php d4p_render_select(gdbbx_select_forum_settings(), array('id' => 'gdbbx_settings_privacy_lock_reply_form', 'name' => 'gdbbx_settings[privacy_lock_reply_form]', 'class' => 'widefat', 'selected' => $_meta['privacy_lock_reply_form'])); ?>
</p>
<p>
    <label for="gdbbx_settings_privacy_lock_reply_form_message"><?php _e("Lock Message", "gd-bbpress-toolbox"); ?></label>
    <input name="gdbbx_settings[privacy_lock_reply_form_message]" id="gdbbx_settings_privacy_lock_reply_form_message" value="<?php echo esc_attr($_meta['privacy_lock_reply_form_message']) ?>" class="widefat" type="text" />
    <em><?php _e("Leave empty to use global lock message.", "gd-bbpress-toolbox"); ?></em>
</p>
