<?php

$_templates = apply_filters('gdbbx-widget-usersthanks-templates', array(
    'gdbbx-widget-usersthanks.php' => __("Default widget layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-usersthanks.php'.']',
    'gdbbx-widget-usersthanks-lite.php' => __("Lite widget layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-usersthanks-lite.php'.']'
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

<h4><?php _e("Additional settings", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e("Limit number of users", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="0" step="1" value="<?php echo $instance['limit']; ?>" />
            </td>
        </tr>
    </tbody>
</table>
