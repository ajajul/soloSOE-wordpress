<div class="d4p-group d4p-group-information">
    <h3><?php _e("Important", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool changes status of topics to 'close' based on the selected criteria. Closed topics don't allow new replies.", "gd-bbpress-toolbox"); ?>
    </div>
</div>
<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Close inactive topics", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <input type="checkbox" class="widefat" name="gdbbxtools[close][inactive]" value="on" /> <?php _e("Close all topics that were last active", "gd-bbpress-toolbox"); ?>
        <input type="number" class="widefat" name="gdbbxtools[close][inactivity]" value="365" min="1" style="width: 80px; margin: 0 10px;" /> <?php _e("or more days ago", "gd-bbpress-toolbox"); ?>
    </div>
</div>
<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Close old topics", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <input type="checkbox" class="widefat" name="gdbbxtools[close][old]" value="on" /> <?php _e("Close all topics that were created", "gd-bbpress-toolbox"); ?>
        <input type="number" class="widefat" name="gdbbxtools[close][age]" value="365" min="1" style="width: 80px; margin: 0 10px;" /> <?php _e("or more days ago", "gd-bbpress-toolbox"); ?>
    </div>
</div>
