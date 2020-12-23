<?php

$_sel_mode = array(
    'global' => __("Global search through all forums", "gd-bbpress-toolbox"),
    'current' => __("Search the current forum only", "gd-bbpress-toolbox")
);

?>

<h4><?php _e("Search Mode", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('search_mode'); ?>"><?php _e("Select mode", "gd-bbpress-toolbox"); ?>:</label>
                <?php d4p_render_select($_sel_mode, array('id' => $this->get_field_id('search_mode'), 'class' => 'widefat', 'name' => $this->get_field_name('search_mode'), 'selected' => $instance['search_mode'])); ?>
                <em>
                    <?php _e("If the 'Current forum' search mode is active, and the forum can't be identified, search will revert to global mode.", "gd-bbpress-toolbox"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>
