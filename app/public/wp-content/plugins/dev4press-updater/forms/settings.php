<?php

if (!defined('ABSPATH')) exit;

$panels = array(
    'index' => array(
        'title' => __("Settings", "dev4press-updater"), 'icon' => 'cogs', 
        'info' => __("All plugin settings are split into several panels, and you access each starting from the right.", "dev4press-updater")),
    'api' => array(
        'title' => __("API Key", "dev4press-updater"), 'icon' => 'lock', 
        'info' => __("On this panel you can add your Dev4Press API Key.", "dev4press-updater")),
    'control' => array(
        'title' => __("Control", "dev4press-updater"), 'icon' => 'tasks', 
        'info' => __("These are basic settings controlling automatic check for updates.", "dev4press-updater")),
    'debug' => array(
        'title' => __("Debug", "dev4press-updater"), 'icon' => 'bug', 
        'info' => __("These are settings for controlling the debug process used to find problems with the plugin.", "dev4press-updater"))
);

include(D4PUPD_PATH.'forms/shared/top.php');

?>

<form method="post" action="">
    <?php settings_fields('dev4press-updater-settings'); ?>

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i aria-hidden="true" class="fa fa-cogs"></i>
                <h3><?php _e("Settings", "dev4press-updater"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i aria-hidden="true" class="<?php echo d4p_get_icon_class($panels[$_panel]['icon']); ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index') { ?>
                <div class="d4p-panel-buttons">
                    <input type="submit" value="<?php _e("Save Settings", "dev4press-updater"); ?>" class="button-primary" />
                </div>
                <div class="d4p-return-to-top">
                    <a href="#wpwrap"><?php _e("Return to top", "dev4press-updater"); ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'admin.php?page=dev4press-updater-'.$_page.'&panel='.$panel;

                ?>

                <div class="d4p-options-panel">
                    <i aria-hidden="true" class="<?php echo d4p_get_icon_class($obj['icon']); ?>"></i>
                    <h5><?php echo $obj['title']; ?></h5>
                    <div>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Settings Panel", "dev4press-updater"); ?></a>
                    </div>
                </div>
        
                <?php
            }
        } else {
            require_once(D4PUPD_D4PLIB.'admin/d4p.functions.php');
            require_once(D4PUPD_D4PLIB.'admin/d4p.settings.php');

            include(D4PUPD_PATH.'core/internal.php');

            $options = new d4pupd_admin_settings();

            $panel = d4pupd_admin()->panel;
            $groups = $options->get($panel);

            $render = new d4pSettingsRender($panel, $groups);
            $render->base = 'd4pupdvalue';
            $render->render();

            ?>

            <div class="clear"></div>
            <div style="padding-top: 15px; border-top: 1px solid #777; max-width: 800px;">
                <input type="submit" value="<?php _e("Save Settings", "dev4press-updater"); ?>" class="button-primary">
            </div>

            <?php

        }

        ?>
    </div>
</form>

<?php 

include(D4PUPD_PATH.'forms/shared/bottom.php');
