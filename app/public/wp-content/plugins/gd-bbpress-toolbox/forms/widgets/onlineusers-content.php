<?php

$_templates = apply_filters('gdbbx-widget-onlineusers-templates', array(
    'gdbbx-widget-onlineusers.php' => __("Default layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-onlineusers.php'.']'
));

$_sel_userinfo = array(
    'profile_link' => __("Profile Link", "gd-bbpress-toolbox"),
    'display_name' => __("Display Name", "gd-bbpress-toolbox"),
);

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

<h4><?php _e("Online users information", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_users_list'); ?>">
                        <input class="widefat" <?php echo $instance['show_users_list'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_users_list'); ?>" name="<?php echo $this->get_field_name('show_users_list'); ?>" />
                        <?php _e("Show current online users", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_max_users'); ?>">
                        <input class="widefat" <?php echo $instance['show_max_users'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_max_users'); ?>" name="<?php echo $this->get_field_name('show_max_users'); ?>" />
                        <?php _e("Show maximum number of users online with date and time", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('show_users_limit'); ?>"><?php _e("Limit users per role", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('show_users_limit'); ?>" name="<?php echo $this->get_field_name('show_users_limit'); ?>" type="number" min="0" step="1" value="<?php echo $instance['show_users_limit']; ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("User information to show", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('show_users'); ?>"><?php _e("User information", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_userinfo, array('id' => $this->get_field_id('show_users'), 'class' => 'widefat', 'name' => $this->get_field_name('show_users'), 'selected' => $instance['show_users'])); ?>
            </td>
            <td class="cell-right">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_users_avatar'); ?>">
                        <input class="widefat" <?php echo $instance['show_users_avatar'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_users_avatar'); ?>" name="<?php echo $this->get_field_name('show_users_avatar'); ?>" />
                        <?php _e("Show avatar", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_user_roles'); ?>">
                        <input class="widefat" <?php echo $instance['show_user_roles'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_user_roles'); ?>" name="<?php echo $this->get_field_name('show_user_roles'); ?>" />
                        <?php _e("Show user roles", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>
