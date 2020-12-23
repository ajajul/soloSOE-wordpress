<?php

$_templates = apply_filters('gdbbx-widget-userprofile-templates', array(
    'gdbbx-widget-userprofile.php' => __("Default two columns layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-userprofile.php'.']',
    'gdbbx-widget-userprofile-enhanced.php' => __("Enhanced single column layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-topicinfo-enhanced.php'.']'
));

?>

<h4><?php _e("Display Template", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e("Select template", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_templates, array('id' => $this->get_field_id('template'), 'class' => 'widefat', 'name' => $this->get_field_name('template'), 'selected' => $instance['template'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Avatar", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e("Avatar Size", "gd-bbpress-toolbox"); ?> (px):</label>
                <input class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="text" value="<?php echo $instance['avatar_size']; ?>" />
            </td>
            <td class="cell-right">
                
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Login and Logout", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_logout'); ?>">
                        <input class="widefat" <?php echo $instance['show_logout'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_logout'); ?>" name="<?php echo $this->get_field_name('show_logout'); ?>" />
                        <?php _e("Show logout link", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_login'); ?>">
                        <input class="widefat" <?php echo $instance['show_login'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_login'); ?>" name="<?php echo $this->get_field_name('show_login'); ?>" />
                        <?php _e("Show login and registration", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Other Settings", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_edit'); ?>">
                        <input class="widefat" <?php echo $instance['show_edit'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_edit'); ?>" name="<?php echo $this->get_field_name('show_edit'); ?>" />
                        <?php _e("Show edit profile link", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_profile'); ?>">
                        <input class="widefat" <?php echo $instance['show_profile'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_profile'); ?>" name="<?php echo $this->get_field_name('show_profile'); ?>" />
                        <?php _e("Show profile title", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_stats'); ?>">
                        <input class="widefat" <?php echo $instance['show_stats'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_stats'); ?>" name="<?php echo $this->get_field_name('show_stats'); ?>" />
                        <?php _e("Show user statistics", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_role'); ?>">
                        <input class="widefat" <?php echo $instance['show_role'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_role'); ?>" name="<?php echo $this->get_field_name('show_role'); ?>" />
                        <?php _e("Show user forum role", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_topics'); ?>">
                        <input class="widefat" <?php echo $instance['show_topics'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_topics'); ?>" name="<?php echo $this->get_field_name('show_topics'); ?>" />
                        <?php _e("Show started topics link", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_replies'); ?>">
                        <input class="widefat" <?php echo $instance['show_replies'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_replies'); ?>" name="<?php echo $this->get_field_name('show_replies'); ?>" />
                        <?php _e("Show posted replies link", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_favorites'); ?>">
                        <input class="widefat" <?php echo $instance['show_favorites'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_favorites'); ?>" name="<?php echo $this->get_field_name('show_favorites'); ?>" />
                        <?php _e("Show favorite topics link", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_subsciptions'); ?>">
                        <input class="widefat" <?php echo $instance['show_subsciptions'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_subsciptions'); ?>" name="<?php echo $this->get_field_name('show_subsciptions'); ?>" />
                        <?php _e("Show subscribed topics link", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_engagements'); ?>">
                        <input class="widefat" <?php echo $instance['show_engagements'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_engagements'); ?>" name="<?php echo $this->get_field_name('show_engagements'); ?>" />
                        <?php _e("Show engagements link", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>
