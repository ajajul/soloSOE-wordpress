<?php

if (!defined('ABSPATH')) { exit; }

$panels = array(
    'index' => array(
        'title' => __("Settings Index", "gd-bbpress-toolbox"), 'icon' => 'cogs', 
        'info' => __("All plugin settings are split into several panels, and you access each starting from the right.", "gd-bbpress-toolbox")),
    'widgets' => array(
        'title' => __("Widgets", "gd-bbpress-toolbox"), 'icon' => 'puzzle-piece',
        'break' => __("Basic Settings", "gd-bbpress-toolbox"),
        'info' => __("Enable or disable widgets included in the plugin, and disable some default bbPress widgets.", "gd-bbpress-toolbox")),
    'seo' => array(
        'title' => __("SEO", "gd-bbpress-toolbox"), 'icon' => 'search-plus',
        'info' => __("Search engine optimization enhanacements for forums, topic and replies.", "gd-bbpress-toolbox")),
    'files' => array(
        'title' => __("JS/CSS Files", "gd-bbpress-toolbox"), 'icon' => 'file-code-o',
        'info' => __("Some additional controls for JS and CSS files loaded by the plugin.", "gd-bbpress-toolbox")),
    'attachments' => array(
        'title' => __("General", "gd-bbpress-toolbox"), 'icon' => 'archive',
        'break' => __("Attachments", "gd-bbpress-toolbox"),
        'info' => __("Basic settings for control over attachments upload for topics and replies.", "gd-bbpress-toolbox")),
    'attachments_integration' => array(
        'title' => __("Integration", "gd-bbpress-toolbox"), 'icon' => 'sliders',
        'info' => __("Settings to control attachments integration into bbPress.", "gd-bbpress-toolbox")),
    'attachments_images' => array(
        'title' => __("Images", "gd-bbpress-toolbox"), 'icon' => 'image',
        'info' => __("Settings to control display of the image based attachments.", "gd-bbpress-toolbox")),
    'attachments_mime' => array(
        'title' => __("Allowed Types", "gd-bbpress-toolbox"), 'icon' => 'file-o',
        'info' => __("Select which MIME types (or extensions) are allowed for upload.", "gd-bbpress-toolbox")),
    'attachments_advanced' => array(
        'title' => __("Advanced", "gd-bbpress-toolbox"), 'icon' => 'flag',
        'info' => __("Settings for bulk download, upload directory and more advanced attachments options.", "gd-bbpress-toolbox")),
    'attachments_deletion' => array(
        'title' => __("Deletion", "gd-bbpress-toolbox"), 'icon' => 'trash',
        'info' => __("Settings to control options for the attachments deletion.", "gd-bbpress-toolbox")),
    'bbcodes_basic' => array(
        'title' => __("General", "gd-bbpress-toolbox"), 'icon' => 'pencil-square', 'type' => 'settings',
        'break' => __("BBCodes", "gd-bbpress-toolbox"),
        'info' => __("Basic settings for the control over the BBCodes implementation.", "gd-bbpress-toolbox")),
    'bbcodes_toolbar' => array(
        'title' => __("Toolbar", "gd-bbpress-toolbox"), 'icon' => 'bars', 'type' => 'settings',
        'info' => __("Setup and configure a simple BBCodes Toolbar.", "gd-bbpress-toolbox")),
    'bbcodes_single' => array(
        'title' => __("Defaults", "gd-bbpress-toolbox"), 'icon' => 'code', 'type' => 'settings',
        'info' => __("Control some of the individual BBCodes default settings.", "gd-bbpress-toolbox")),
    'tracking' => array(
        'title' => __("Users Tracking", "gd-bbpress-toolbox"), 'icon' => 'location-arrow',
        'break' => __("New and Unread Topics Tracking", "gd-bbpress-toolbox"),
        'info' => __("Control the user activity tracking in the forums for purpose of determining new and unread topics.", "gd-bbpress-toolbox")),
    'topic_read' => array(
        'title' => __("For Topics", "gd-bbpress-toolbox"), 'icon' => 'd4p-icon-bbpress-topic',
        'info' => __("Control the way topics activity is displayed inside the topics list.", "gd-bbpress-toolbox")),
    'forum_read' => array(
        'title' => __("For Forums", "gd-bbpress-toolbox"), 'icon' => 'd4p-icon-bbpress-forum',
        'info' => __("Control the way topics activity is displayed inside the forums list.", "gd-bbpress-toolbox")),
    'notifications' => array(
        'title' => __("Notifications", "gd-bbpress-toolbox"), 'icon' => 'envelope', 
        'break' => __("Notifications", "gd-bbpress-toolbox"), 
        'info' => __("Basic settings and overrides for the bbPress notification system.", "gd-bbpress-toolbox")),
    'notify_templates_bbp' => array(
        'title' => __("bbPress Templates", "gd-bbpress-toolbox"), 'icon' => 'envelope-o',
        'info' => __("Control the notifications content sent to users for default bbPress notifications.", "gd-bbpress-toolbox")),
    'notify_templates_bbx' => array(
        'title' => __("Toolbox Templates", "gd-bbpress-toolbox"), 'icon' => 'envelope-o',
        'info' => __("Control the notifications content sent to users for Toolbox plugin notifications.", "gd-bbpress-toolbox")),
    'buddypress' => array(
        'title' => __("BuddyPress", "gd-bbpress-toolbox"), 'icon' => 'd4p-logo-buddypress',
        'break' => __("Integrations", "gd-bbpress-toolbox"),
        'info' => __("Settings for the BuddyPress related features and tweaks.", "gd-bbpress-toolbox"))
);

if (!gdbbx_has_buddypress()) {
    unset($panels['buddypress']);
}

include(GDBBX_PATH.'forms/shared/top.php');

?>

<form method="post" action="" id="gdbbx-form-settings" autocomplete="off">
    <?php settings_fields('gd-bbpress-toolbox-settings'); ?>
    <input type="hidden" name="gdbbx_handler" value="postback" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i aria-hidden="true" class="fa fa-cogs"></i>
                <h3><?php _e("Settings", "gd-bbpress-toolbox"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i aria-hidden="true" class="<?php echo d4p_get_icon_class($panels[$_panel]['icon']); ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index') { ?>
                <div class="d4p-panel-buttons">
                    <input type="submit" value="<?php _e("Save Settings", "gd-bbpress-toolbox"); ?>" class="button-primary">
                </div>
            <?php } ?>
            <div class="d4p-return-to-top">
                <a href="#wpwrap"><?php _e("Return to top", "gd-bbpress-toolbox"); ?></a>
            </div>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'admin.php?page=gd-bbpress-toolbox-'.$_page.'&panel='.$panel;

                if (isset($obj['break'])) { ?>

                    <div style="clear: both"></div>
                    <div class="d4p-panel-break d4p-clearfix">
                        <h4><?php echo $obj['break']; ?></h4>
                    </div>
                    <div style="clear: both"></div>

                <?php } ?>

                <div class="d4p-options-panel">
                    <i aria-hidden="true" class="<?php echo d4p_get_icon_class($obj['icon']); ?>"></i>
                    <h5 aria-label="<?php echo $obj['info']; ?>" data-balloon-pos="up-left" data-balloon-length="large"><?php echo $obj['title']; ?></h5>
                    <div>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Settings", "gd-bbpress-toolbox"); ?></a>
                    </div>
                </div>
        
                <?php
            }
        } else {
            require_once(GDBBX_PATH.'d4plib/admin/d4p.functions.php');
            require_once(GDBBX_PATH.'d4plib/admin/d4p.settings.php');

            include(GDBBX_PATH.'core/admin/internal.php');

            $options = new gdbbx_admin_settings();

            $panel = gdbbx_admin()->panel;
            $groups = $options->get($panel);

            $render = new d4pSettingsRender($panel, $groups);
            $render->base = 'gdbbxvalue';
            $render->render();

            ?>

            <div class="clear"></div>
            <div style="padding-top: 15px; border-top: 1px solid #777; max-width: 800px;">
                <input type="submit" value="<?php _e("Save Settings", "gd-bbpress-toolbox"); ?>" class="button-primary">
            </div>

            <?php

        }

        ?>
    </div>
</form>

<?php 

include(GDBBX_PATH.'forms/shared/bottom.php');
