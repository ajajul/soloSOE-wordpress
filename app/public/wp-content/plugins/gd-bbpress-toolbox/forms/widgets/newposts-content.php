<?php

$_templates = apply_filters('gdbbx-widget-newposts-templates', array(
    'gdbbx-widget-newposts.php' => __("Default post layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-newposts.php'.']'
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
                <label for="<?php echo $this->get_field_id('display_date'); ?>"><?php _e("Show date", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_date, array('id' => $this->get_field_id('display_date'), 'class' => 'widefat', 'name' => $this->get_field_name('display_date'), 'selected' => $instance['display_date'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e("Limit list of topics", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="0" step="1" value="<?php echo $instance['limit']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('display_author'); ?>"><?php _e("Show author", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_date, array('id' => $this->get_field_id('display_author'), 'class' => 'widefat', 'name' => $this->get_field_name('display_author'), 'selected' => $instance['display_author'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('display_author_avatar'); ?>"><?php _e("With avatar image", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_date, array('id' => $this->get_field_id('display_author_avatar'), 'class' => 'widefat', 'name' => $this->get_field_name('display_author_avatar'), 'selected' => $instance['display_author_avatar'])); ?>
            </td>
        </tr>
    </tbody>
</table>
