<h4><?php _e("Results Caching", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('_cached'); ?>"><?php _e("Cache Period", "gd-bbpress-toolbox"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_cached'); ?>" name="<?php echo $this->get_field_name('_cached'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['_cached']); ?>" />

                <em>
                    <?php _e("To use cache and speed up the widget, enter number of hours for cached results to be kept. Leave 0 to disable cache.", "gd-bbpress-toolbox"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>
