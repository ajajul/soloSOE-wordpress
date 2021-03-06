<?php

$_templates = apply_filters('gdbbx-widget-statistics-templates', array(
    'gdbbx-widget-statistics-list.php' => __("Basic list layout", "gd-bbpress-toolbox").' ['.'gdbbx-widget-statistics-list.php'.']',
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

<h4><?php _e("Select Statistics", "gd-bbpress-toolbox"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list gdbbx-stats-list">
                    <ul class="gdbbx-stats-ul">
                    <?php

                    $_act = (array)$instance['stats'];
                    $_all = gdbbx_list_of_statistics_elements();

                    foreach ($_act as $stat) {
                        $title = $_all[$stat];

                        echo sprintf('<li class="bbx-stat-item-%s" data-stat="%s"><label><input type="checkbox" name="%s[]" value="%s"%s />%s</label></li>',
                                $stat, $stat, $this->get_field_name('stats'), $stat, 'checked="checked"', $title);
                    }

                    foreach ($_all as $stat => $title) {
                        if (!in_array($stat, $_act) || empty($_act)) {
                            echo sprintf('<li class="bbx-stat-item-%s" data-stat="%s"><label><input type="checkbox" name="%s[]" value="%s"%s />%s</label></li>',
                                    $stat, $stat, $this->get_field_name('stats'), $stat, empty($_act) ? 'checked="checked"' : '', $title);
                        }
                    }

                    ?>
                    </ul>
                </div>
            </td>
            <td class="cell-right">
                <em>
                    <?php _e("You can rearange the list of items using drag and drop. Only items that are checked will be displayed.", "gd-bbpress-toolbox"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("a.gdbbx-tab-topics-stats.d4plib-tab-active").click();
});
</script>