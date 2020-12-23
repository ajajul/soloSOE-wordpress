<fieldset class="bbp-form gdbbx-fieldset-attachments-edit">
    <legend><?php _e("Current Attachments", "gd-bbpress-toolbox"); ?>:</legend>
    <div>
        <div class="gdbbx-attachments-form-current">
            <?php echo $this->embed_attachments_edit($attachments, $id); ?>
        </div>
    </div>
</fieldset>