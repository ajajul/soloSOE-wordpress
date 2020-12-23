<div>
    <p>
        <?php _e("Attachments are one of the most complex features in GD bbPress Toolbox Pro, and there are many ways they can be configured and used.", "gd-bbpress-toolbox"); ?>
    </p>
</div>

<div class="d4p-wizard-option-block d4p-wizard-block-yesno">
    <p><?php _e("Do you want to enable use of Attachments?", "gd-bbpress-toolbox"); ?></p>
    <div>
        <em><?php _e("With attachments support, your forum users can upload files to topics and replies. You can limit file size and file types, and control how the attachments are displayed.", "gd-bbpress-toolbox"); ?></em>
        <span>
            <input class="gdbbx-wizard-connect-switch" data-connect="gdbbx-wizard-connect-attachments" type="radio" name="gdbbx[wizard][attachments][attach]" value="yes" id="gdbbx-wizard-attachments-attach-yes" checked />
            <label for="gdbbx-wizard-attachments-attach-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
        </span>
        <span>
            <input class="gdbbx-wizard-connect-switch" data-connect="gdbbx-wizard-connect-attachments" type="radio" name="gdbbx[wizard][attachments][attach]" value="no" id="gdbbx-wizard-attachments-attach-no" />
            <label for="gdbbx-wizard-attachments-attach-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
        </span>
    </div>
</div>

<div class="d4p-wizard-connect-wrapper" id="gdbbx-wizard-connect-attachments" style="display: block;">
    <div class="d4p-wizard-option-block d4p-wizard-block-yesno">
        <p><?php _e("Do you want to use enhanced attachments interface?", "gd-bbpress-toolbox"); ?></p>
        <div>
            <em><?php _e("Enhanced interface shows preview of the file before upload, it validates the file size and type, and allows you to set the caption for each file.", "gd-bbpress-toolbox"); ?></em>
            <span>
                <input type="radio" name="gdbbx[wizard][attachments][enhance]" value="yes" id="gdbbx-wizard-attachments-enhance-yes" checked />
                <label for="gdbbx-wizard-attachments-enhance-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
            </span>
            <span>
                <input type="radio" name="gdbbx[wizard][attachments][enhance]" value="no" id="gdbbx-wizard-attachments-enhance-no" />
                <label for="gdbbx-wizard-attachments-enhance-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
            </span>
        </div>
    </div>

    <div class="d4p-wizard-option-block d4p-wizard-block-yesno">
        <p><?php _e("Do you want to show images as thumbnails?", "gd-bbpress-toolbox"); ?></p>
        <div>
            <em><?php _e("Attachments are displayed as a list of files. But, with images, you can choose to show thumbnails instead.", "gd-bbpress-toolbox"); ?></em>
            <span>
                <input type="radio" name="gdbbx[wizard][attachments][images]" value="yes" id="gdbbx-wizard-attachments-images-yes" checked />
                <label for="gdbbx-wizard-attachments-images-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
            </span>
            <span>
                <input type="radio" name="gdbbx[wizard][attachments][images]" value="no" id="gdbbx-wizard-attachments-images-no" />
                <label for="gdbbx-wizard-attachments-images-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
            </span>
        </div>
    </div>

    <div class="d4p-wizard-option-block d4p-wizard-block-select">
        <p><?php _e("Select the file types you want to allow for upload?", "gd-bbpress-toolbox"); ?></p>
        <div>
            <em><?php _e("You can use attachments settings to select individual MIME types. For now, select mime types groups you want to allow.", "gd-bbpress-toolbox"); ?></em>
            <span>
                <label for="gdbbx-wizard-attachments-mime"><?php _e("MIME Types Groups", "gd-bbpress-toolbox"); ?></label>
                <select name="gdbbx[wizard][attachments][mime]" id="gdbbx-wizard-attachments-mime">
                    <option value="all"><?php _e("Do not limit file types", "gd-bbpress-toolbox"); ?></option>
                    <option value="images" selected="selected"><?php _e("Only image types", "gd-bbpress-toolbox"); ?></option>
                    <option value="media"><?php _e("Images, video and audio files", "gd-bbpress-toolbox"); ?></option>
                </select>
            </span>
        </div>
    </div>
</div>
