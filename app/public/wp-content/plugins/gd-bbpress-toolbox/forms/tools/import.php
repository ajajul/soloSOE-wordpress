<div class="d4p-group d4p-group-information">
    <h3><?php _e("Important", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("With this tool you import all plugin settings from the JSON formatted file made using the Export tool. If you made changes to this file, the import will not be possible.", "gd-bbpress-toolbox"); ?><br/><br/>
        <strong><?php _e("Export file created with the plugin version before 4.2 can't be imported!", "gd-bbpress-toolbox"); ?></strong>
    </div>
</div>

<div class="d4p-group d4p-group-information">
    <h3><?php _e("Import File", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("Select file you want to import", "gd-bbpress-toolbox"); ?>:
        <br/><br/>
        <input type="file" name="import_file" accept=".json" />
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Settings to Import", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][settings]" value="on" /> <?php _e("Basic Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][attachments]" value="on" /> <?php _e("Attachments Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][features]" value="on" /> <?php _e("Features Settings and features Load status", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][online]" value="on" /> <?php _e("Online Tracking Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][seo]" value="on" /> <?php _e("SEO Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][widgets]" value="on" /> <?php _e("Widgets Activation Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input checked="checked" type="checkbox" class="widefat" name="gdbbxtools[import][buddypress]" value="on" /> <?php _e("BuddyPress Related Settings", "gd-bbpress-toolbox"); ?>
        </label>
    </div>
</div>
