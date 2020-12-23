<div>
    <p>
        <?php _e("You can easily replace default, basic editor used for topics and replies with one of the additional editors supported by bbPress and GD bbPress Toolbox Pro.", "gd-bbpress-toolbox"); ?>
    </p>
</div>

<div class="d4p-wizard-option-block d4p-wizard-block-yesno">
    <p><?php _e("Do you want to replace basic content editor?", "gd-bbpress-toolbox"); ?></p>
    <div>
        <em><?php _e("Select editor that you think will provide best experience for your users. Each editor has good and bad sides, and it is not simple to give recommendation.", "gd-bbpress-toolbox"); ?></em>
        <span>
            <input class="gdbbx-wizard-connect-switch" data-connect="gdbbx-wizard-connect-editor-replace" type="radio" name="gdbbx[wizard][editors][replace]" value="yes" id="gdbbx-wizard-editors-replace-yes" />
            <label for="gdbbx-wizard-editors-replace-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
        </span>
        <span>
            <input class="gdbbx-wizard-connect-switch" data-connect="gdbbx-wizard-connect-editor-replace" type="radio" name="gdbbx[wizard][editors][replace]" value="no" id="gdbbx-wizard-editors-replace-no" checked />
            <label for="gdbbx-wizard-editors-replace-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
        </span>
    </div>
</div>

<div class="d4p-wizard-connect-wrapper" id="gdbbx-wizard-connect-editor-replace" style="display: none;">
    <div class="d4p-wizard-option-block d4p-wizard-block-select">
        <p><?php _e("Which editor type you want to use?", "gd-bbpress-toolbox"); ?></p>
        <div>
            <em><?php _e("Pick one of the available editors.", "gd-bbpress-toolbox"); ?></em>
            <span>
                <label for="gdbbx-wizard-editors-mime"><?php _e("Topic Content Editor", "gd-bbpress-toolbox"); ?></label>
                <select name="gdbbx[wizard][editors][editor]" id="gdbbx-wizard-attachments-mime">
                    <option value="basic"><?php _e("Basic textarea editor", "gd-bbpress-toolbox"); ?></option>
                    <option value="quicktags"><?php _e("Quicktags only Editor", "gd-bbpress-toolbox"); ?></option>
                    <option value="tinymce"><?php _e("TinyMCE Full Editor", "gd-bbpress-toolbox"); ?></option>
                    <option value="teeny"><?php _e("TinyMCE Teeny Editor", "gd-bbpress-toolbox"); ?></option>
                    <?php if (gdbbx()->get('bbcodes_active', 'tools')) { ?>
                        <option value="bbcodes"><?php _e("BBCodes Simple Toolbar", "gd-bbpress-toolbox"); ?></option>
                    <?php } ?>
                </select>
            </span>
        </div>
    </div>
</div>

<div class="d4p-wizard-option-block d4p-wizard-block-yesno">
    <p><?php _e("Do you want to allow use of Media Library to regular users?", "gd-bbpress-toolbox"); ?></p>
    <div>
        <em><?php _e("If you have set editor to TinyMCE, depending on the user role, some users will be able to use Media Library, but regular users and moderators will not be able to use it due to the roles restrictions. This option will change that, and participants and moderators will see Media button in the TinyMCE editor.", "gd-bbpress-toolbox"); ?></em>
        <span>
            <input type="radio" name="gdbbx[wizard][editors][library]" value="yes" id="gdbbx-wizard-editors-library-yes" />
            <label for="gdbbx-wizard-editors-library-yes"><?php _e("Yes", "gd-bbpress-toolbox"); ?></label>
        </span>
        <span>
            <input type="radio" name="gdbbx[wizard][editors][library]" value="no" id="gdbbx-wizard-editors-library-no" checked />
            <label for="gdbbx-wizard-editors-library-no"><?php _e("No", "gd-bbpress-toolbox"); ?></label>
        </span>
    </div>
</div>
