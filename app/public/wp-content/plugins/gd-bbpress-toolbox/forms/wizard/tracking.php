<div>
    <p>
        <?php _e("One of the most important aspects in providing best experience to forum users, is to know what new content is available for each user when they visit back, including new topics, new replies, unread topics and more. To provide each user with such information, plugin can track each user activity.", "gd-bbpress-toolbox"); ?>
    </p>
</div>

<div class="d4p-wizard-option-block d4p-wizard-block-yesno">
    <p><?php _e("Do you want to track users online status?", "gd-bbpress-toolbox"); ?></p>
    <div>
        <em><?php _e("Plugin will track online status for each user and overall of all currently online users and visitors.", "gd-bbpress-toolbox"); ?></em>
        <span>
            <input type="radio" name="gdbbx[wizard][tracking][online]" value="yes" id="gdbbx-wizard-tracking-online-yes" checked />
            <label for="gdbbx-wizard-tracking-online-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
        </span>
        <span>
            <input type="radio" name="gdbbx[wizard][tracking][online]" value="no" id="gdbbx-wizard-tracking-online-no" />
            <label for="gdbbx-wizard-tracking-online-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
        </span>
    </div>
</div>

<div class="d4p-wizard-option-block d4p-wizard-block-yesno">
    <p><?php _e("Do you want to track user activity and read status for content?", "gd-bbpress-toolbox"); ?></p>
    <div>
        <em><?php _e("Plugin will track topic read status for each topic and each user. Based on that, it will be able to display information about new and unread content on repeat visits.", "gd-bbpress-toolbox"); ?></em>
        <span>
            <input class="gdbbx-wizard-connect-switch" data-connect="gdbbx-wizard-connect-tracking-activity" type="radio" name="gdbbx[wizard][tracking][activity]" value="yes" id="gdbbx-wizard-tracking-activity-yes" checked />
            <label for="gdbbx-wizard-tracking-activity-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
        </span>
        <span>
            <input class="gdbbx-wizard-connect-switch" data-connect="gdbbx-wizard-connect-tracking-activity" type="radio" name="gdbbx[wizard][tracking][activity]" value="no" id="gdbbx-wizard-tracking-activity-no" />
            <label for="gdbbx-wizard-tracking-activity-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
        </span>
    </div>
</div>

<div class="d4p-wizard-connect-wrapper" id="gdbbx-wizard-connect-tracking-activity" style="display: block;">
    <div class="d4p-wizard-option-block d4p-wizard-block-yesno">
        <p><?php _e("Do you want to show activity badges for topics?", "gd-bbpress-toolbox"); ?></p>
        <div>
            <em><?php _e("Based on the tracking data, plugin can show badges for new topics, unread topics, topics with new replies.", "gd-bbpress-toolbox"); ?></em>
            <span>
                <input type="radio" name="gdbbx[wizard][tracking][topics]" value="yes" id="gdbbx-wizard-tracking-topics-yes" checked />
                <label for="gdbbx-wizard-tracking-topics-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
            </span>
            <span>
                <input type="radio" name="gdbbx[wizard][tracking][topics]" value="no" id="gdbbx-wizard-tracking-topics-no" />
                <label for="gdbbx-wizard-tracking-topics-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
            </span>
        </div>
    </div>

    <div class="d4p-wizard-option-block d4p-wizard-block-yesno">
        <p><?php _e("Do you want to show activity badges for forums?", "gd-bbpress-toolbox"); ?></p>
        <div>
            <em><?php _e("Based on the tracking data, plugin can show badges for new topic, unread topics, topics with new replies.", "gd-bbpress-toolbox"); ?></em>
            <span>
                <input type="radio" name="gdbbx[wizard][tracking][forums]" value="yes" id="gdbbx-wizard-tracking-forums-yes" checked />
                <label for="gdbbx-wizard-tracking-forums-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
            </span>
            <span>
                <input type="radio" name="gdbbx[wizard][tracking][forums]" value="no" id="gdbbx-wizard-tracking-forums-no" />
                <label for="gdbbx-wizard-tracking-forums-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
            </span>
        </div>
    </div>
</div>
