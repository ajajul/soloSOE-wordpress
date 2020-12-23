<?php

$_sel_period = array('last_year' => __("Last year", "gd-bbpress-toolbox"), 'last_6months' => __("Last 6 months", "gd-bbpress-toolbox"), 'last_3months' => __("Last 3 months", "gd-bbpress-toolbox"), 'last_month' => __("Last month", "gd-bbpress-toolbox"), 'last_fortnight' => __("Last two weeks", "gd-bbpress-toolbox"), 'last_week' => __("Last week", "gd-bbpress-toolbox"), 'last_day' => __("Last day", "gd-bbpress-toolbox"), 'last_hour' => __("Last Hour", "gd-bbpress-toolbox"));
$_sel_scope = array('topic,reply' => __("Topics and Replies", "gd-bbpress-toolbox"), 'topic' => __("Topics only", "gd-bbpress-toolbox"), 'reply' => __("Replies only", "gd-bbpress-toolbox"));
$_sel_date = array('yes' => __("Yes", "gd-bbpress-toolbox"), 'no' => __("No", "gd-bbpress-toolbox"));

?>

<h4><?php _e("Topics and Reply Filtering", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('period'); ?>"><?php _e("Period to get posts", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_period, array('id' => $this->get_field_id('period'), 'class' => 'widefat', 'name' => $this->get_field_name('period'), 'selected' => $instance['period'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('scope'); ?>"><?php _e("Get new posts from", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_scope, array('id' => $this->get_field_id('scope'), 'class' => 'widefat', 'name' => $this->get_field_name('scope'), 'selected' => $instance['scope'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Forums", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('include_forums_ids'); ?>"><?php _e("Include forums by forum ID", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('include_forums_ids'); ?>" name="<?php echo $this->get_field_name('include_forums_ids'); ?>" type="text" value="<?php echo join(',', $instance['include_forums_ids']); ?>" />
                <em>
                    <?php _e("Comma separated list of forum ID's.", "gd-bbpress-toolbox"); ?>
                </em>
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('exclude_forums_ids'); ?>"><?php _e("Exclude forums by forum ID", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('exclude_forums_ids'); ?>" name="<?php echo $this->get_field_name('exclude_forums_ids'); ?>" type="text" value="<?php echo join(',', $instance['exclude_forums_ids']); ?>" />
                <em>
                    <?php _e("Comma separated list of forum ID's. This list will be used only if Include forums list is empty.", "gd-bbpress-toolbox"); ?>
                </em>
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('exclude_private'); ?>"><?php _e("Check user access rights", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_date, array('id' => $this->get_field_id('exclude_private'), 'class' => 'widefat', 'name' => $this->get_field_name('exclude_private'), 'selected' => $instance['exclude_private'])); ?>
                <em>
                    <?php _e("If you use this option, it will work only with widget cache disabled, so make sure to set Cache Period on the Global tab to '0'.", "gd-bbpress-toolbox"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>
