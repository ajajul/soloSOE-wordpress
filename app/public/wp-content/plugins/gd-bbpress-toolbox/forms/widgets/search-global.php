<h4><?php _e("Alternative Title", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('title_current'); ?>"><?php _e("Title for 'Current' search mode", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title_current'); ?>" name="<?php echo $this->get_field_name('title_current'); ?>" type="text" value="<?php echo esc_attr($instance['title_current']); ?>" />
            </td>
        </tr>
    </tbody>
</table>
