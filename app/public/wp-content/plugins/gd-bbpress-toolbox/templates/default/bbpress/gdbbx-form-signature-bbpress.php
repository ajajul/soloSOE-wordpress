<h2 class="entry-title"><?php bbp_is_user_home() ? _e("Your Forum Signature", "gd-bbpress-toolbox") : _e("User Forum Signature", "gd-bbpress-toolbox"); ?></h2>
<fieldset class="bbp-form gdbbx-fieldset-signature">
    <legend><?php bbp_is_user_home() ? _e("Your Forum Signature", "gd-bbpress-toolbox") : _e("User Forum Signature", "gd-bbpress-toolbox"); ?></legend>
    <?php do_action('gdbbx_user_edit_before_signature'); ?>

    <div class="<?php echo gdbbx_signature_editor_class(); ?>">
        <label for="signature"><?php _e("Signature", "gd-bbpress-toolbox"); ?></label>
        <fieldset class="bbp-form gdbbx-signature">

            <?php

            $signature = gdbbx_signature()->get_signature_for_bbpress_displayed_user();
            gdbbx_render_signature_editor($signature);

            ?>

            <span class="description">
                <?php echo sprintf(__("Signature length is limited to %s characters.", "gd-bbpress-toolbox"), gdbbx_signature()->settings['length']); ?><br/>
                <?php do_action('gdbbx_user_edit_signature_info'); ?>
            </span>
        </fieldset>
    </div>

    <?php do_action('gdbbx_user_edit_after_signature'); ?>
</fieldset>
