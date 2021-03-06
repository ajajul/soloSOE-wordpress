<fieldset class="bbp-form gdbbx-fieldset-notify-on-topic-edit">
    <legend><?php _e("On edit notifications", "gd-bbpress-toolbox"); ?>:</legend>
    <?php if (bbp_get_topic_author_id() != bbp_get_current_user_id()) { ?>
    <div>
        <input name="gdbbx_notify_on_edit_author" id="gdbbx_notify_on_edit_author" type="checkbox" value="1" />
        <label for="gdbbx_notify_on_edit_author"><?php _e("Notify topic author", "gd-bbpress-toolbox"); ?></label>
    </div>
    <?php } ?>
    <div>
        <input name="gdbbx_notify_on_edit_subscribers" id="gdbbx_notify_on_edit_subscribers" type="checkbox" value="1" />
        <label for="gdbbx_notify_on_edit_subscribers"><?php _e("Notify topic subscribers", "gd-bbpress-toolbox"); ?></label>
    </div>
</fieldset>