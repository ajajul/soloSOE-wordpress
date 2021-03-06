<div class="gdbbx-report-template" style="display: none;">
    <div>
        <fieldset class="bbp-form">
            <legend><?php _e("Report This Post", "gd-bbpress-toolbox"); ?></legend>

            <div class="gdbbx-report-form">
                <p>
                    <label for="gdbbx-report-message"><?php _e("Report Message", "gd-bbpress-toolbox"); ?></label>
                    <input id="gdbbx-report-message" type="text" value="" />
                </p>
                <p class="description"><?php _e("Use this only to report spam, harassment, fighting, or rude content.", "gd-bbpress-toolbox"); ?></p>
                <button class="gdqnt-button gdbbx-report-send"><?php _e("Send Report", "gd-bbpress-toolbox"); ?></button>
                <button class="gdqnt-button gdqnt-button-secondary gdbbx-report-cancel"><?php _e("Cancel", "gd-bbpress-toolbox"); ?></button>
            </div>
            <div class="gdbbx-report-sending" style="display: none;">
                <?php _e("Please wait, sending report.", "gd-bbpress-toolbox"); ?>
            </div>
            <div class="gdbbx-report-sent" style="display: none;">
                <?php _e("Thank you, your report has been sent.", "gd-bbpress-toolbox"); ?>
            </div>
        </fieldset>
    </div>
</div>
