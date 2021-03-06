<?php

$_templates = apply_filters('gdbbx-widget-foruminfo-templates', array(
    'gdbbx-widget-foruminfo.php' => __("Default table layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-foruminfo.php'.']',
    'gdbbx-widget-foruminfo-icons.php' => __("Default table layout, with icons", "gd-bbpress-toolbox").' ['.'gdbbx-widget-foruminfo-icons.php'.']',
    'gdbbx-widget-foruminfo-list.php' => __("Enhanced list layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-foruminfo-list.php'.']',
    'gdbbx-widget-foruminfo-list-icons.php' => __("Enhanced list layout, with icons", "gd-bbpress-toolbox").' ['.'gdbbx-widget-foruminfo-list-icons.php'.']'
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

<h4><?php _e("Information to show", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_parent_forum'); ?>">
                        <input class="widefat" <?php echo $instance['show_parent_forum'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_parent_forum'); ?>" name="<?php echo $this->get_field_name('show_parent_forum'); ?>" />
                        <?php _e("Show parent forum", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_count_replies'); ?>">
                        <input class="widefat" <?php echo $instance['show_count_replies'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_count_replies'); ?>" name="<?php echo $this->get_field_name('show_count_replies'); ?>" />
                        <?php _e("Show replies count", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_count_topics'); ?>">
                        <input class="widefat" <?php echo $instance['show_count_topics'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_count_voices'); ?>" name="<?php echo $this->get_field_name('show_count_topics'); ?>" />
                        <?php _e("Show voices count", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_last_post_user'); ?>">
                        <input class="widefat" <?php echo $instance['show_last_post_user'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_last_post_user'); ?>" name="<?php echo $this->get_field_name('show_last_post_user'); ?>" />
                        <?php _e("Show last post user", "gd-bbpress-toolbox"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_last_activity'); ?>">
                        <input class="widefat" <?php echo $instance['show_last_activity'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_last_activity'); ?>" name="<?php echo $this->get_field_name('show_last_activity'); ?>" />
                        <?php _e("Show last activity", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Actions to show", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-single">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_subscribe'); ?>">
                        <input class="widefat" <?php echo $instance['show_subscribe'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_subscribe'); ?>" name="<?php echo $this->get_field_name('show_subscribe'); ?>" />
                        <?php _e("Show subscribe button", "gd-bbpress-toolbox"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>
