<fieldset class="bbp-form gdbbx-fieldset-attachments">
    <legend><?php _e("Attachments", "gd-bbpress-toolbox"); ?>:</label></legend>
    <div>
        <?php do_action('gdbbx_attachments_form_notices'); ?>

        <div class="gdbbx-attachments-form">
            <div class="gdbbx-attachments-input">
                <div role="button" class="gdbbx-attachment-preview"><span aria-hidden="true"><?php _e("Select File", "gd-bbpress-toolbox"); ?></span></div>
                <label>
                    <input type="file" size="40" name="gdbbx-attachment[]" />
                    <span class="gdbbx-accessibility-show-for-sr"><?php _e("Select File", "gd-bbpress-toolbox"); ?></span>
                </label>
                <div class="gdbbx-attachment-control"></div>
            </div>
            <a role="button" class="gdbbx-attachment-add-file" href="#"><?php _e("Add another file", "gd-bbpress-toolbox"); ?></a>
        </div>
    </div>
</fieldset>