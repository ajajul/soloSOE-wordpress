<?php

$topic_id = bbp_get_topic_id();

$_topic_future = '';
$_topic_publish = 'now';

if ($topic_id > 0) {
    $_topic_future = get_post_time('Y-m-d H:i:s', false, $topic_id);
    $_topic_publish = 'future';
}

$_when_values = array(
    'now' => __("Publish the topic now", "gd-bbpress-toolbox"),
    'future' => __("Schedule the topic for future publish", "gd-bbpress-toolbox")
);

?>
<fieldset class="bbp-form gdbbx-fieldset-scheduler">
    <legend><?php _e("Schedule the topic publishing", "gd-bbpress-toolbox"); ?>:</legend>
    <div>
        <label for="gdbbx_schedule_when"><?php _e("When to publish the topic", "gd-bbpress-toolbox"); ?>
            <?php gdbbx_render_select_dropdown($_when_values, $_topic_publish, array('name' => 'gdbbx_schedule_when', 'id' => 'gdbbx_schedule_when')); ?>
        </label>
    </div>
    <div style="display: <?php echo $_topic_publish == 'future' ? 'block' : 'none'; ?>">
        <label for="gdbbx_schedule_datetime"><?php _e("Publish on date", "gd-bbpress-toolbox"); ?>
            <input name="gdbbx_schedule_datetime" id="gdbbx_schedule_datetime" type="text" value="<?php echo $_topic_future; ?>" />
        </label>
    </div>
</fieldset>
