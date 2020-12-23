<div class="d4p-group d4p-group-information">
    <h3><?php _e("Important", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool can remove plugin settings saved in the WordPress options table, individual settings for forums related to this plugin and individual settings for users related to this plugin (tracking and signature).", "gd-bbpress-toolbox"); ?><br/><br/>
        <?php _e("Deletion operations are not reversible, and it is highly recommended to create database backup before proceeding with this tool.", "gd-bbpress-toolbox"); ?> 
        <?php _e("If you choose to remove plugin settings, that will also reinitialize all plugin settings to default values.", "gd-bbpress-toolbox"); ?>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Remove plugin settings", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][all]" value="on" /> <?php _e("All The Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <div class="d4p-setting-hr" style="margin: 15px 0">
            <span><?php _e("Or, choose individual settings groups", "gd-bbpress-toolbox"); ?></span>
            <hr>
        </div>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][settings]" value="on" /> <?php _e("Basic Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][attachments]" value="on" /> <?php _e("Attachments Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][features]" value="on" /> <?php _e("Features Settings and features Load status", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][online]" value="on" /> <?php _e("Online Tracking Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][seo]" value="on" /> <?php _e("SEO Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][widgets]" value="on" /> <?php _e("Widgets Activation Settings", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][settings][buddypress]" value="on" /> <?php _e("BuddyPress Related Settings", "gd-bbpress-toolbox"); ?>
        </label>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Remove various meta data", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][forums]" value="on" /> <?php _e("All Forums Settings meta fields", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][tracking]" value="on" /> <?php _e("All Users Latest activity meta field", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][signature]" value="on" /> <?php _e("All Users Signatures meta fields", "gd-bbpress-toolbox"); ?>
        </label>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Remove plugin CRON jobs", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][cron]" value="on" /> <?php _e("All Plugin CRON Jobs", "gd-bbpress-toolbox"); ?>
        </label>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Remove database data and tables", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][drop]" value="on" /> <?php _e("Remove plugins database tables and all data in them", "gd-bbpress-toolbox"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][truncate]" value="on" /> <?php _e("Remove all data from database tables", "gd-bbpress-toolbox"); ?>
        </label>
        <div class="d4p-setting-hr" style="margin: 15px 0">
            <span><?php _e("Database tables that will be affected", "gd-bbpress-toolbox"); ?></span>
            <hr>
        </div>
        <ul style="list-style: inside disc;">
            <li><?php echo gdbbx_db()->actions; ?></li>
            <li><?php echo gdbbx_db()->actionmeta; ?></li>
            <li><?php echo gdbbx_db()->attachments; ?></li>
            <li><?php echo gdbbx_db()->online; ?></li>
            <li><?php echo gdbbx_db()->tracker; ?></li>
        </ul>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Disable Plugin", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdbbxtools[remove][disable]" value="on" /> <?php _e("Disable plugin", "gd-bbpress-toolbox"); ?>
        </label>
    </div>
</div>
