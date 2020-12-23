<?php

if (!defined('ABSPATH')) exit;

$_classes = array('d4p-wrap', 'wpv-'.D4PUPD_WPV, 'd4p-page-install');

?>
<div class="<?php echo join(' ', $_classes); ?>">
    <div class="d4p-header">
        <div class="d4p-plugin">
            Dev4Press Updater
        </div>
    </div>
    <div class="d4p-content">
        <div class="d4p-content-left">
            <div class="d4p-panel-title">
                <i aria-hidden="true" class="fa fa-magic"></i>
                <h3><?php _e("Installation", "dev4press-updater"); ?></h3>
            </div>
            <div class="d4p-panel-info">
                <?php _e("Before you continue, make sure plugin installation was successful.", "dev4press-updater"); ?>
            </div>
        </div>
        <div class="d4p-content-right">
            <div class="d4p-update-info">
                <h3 style="margin-top: 0;"><?php _e("Previous Plugin Version", "dev4press-updater"); ?></h3>
                <?php

                d4pupd_remove_cron('dev4press_update_check');
                d4pupd_remove_cron('dev4press_updater_v4_check');

                $old = get_site_option('dev4press-updater');

                $found = is_array($old) && isset($old['dev4press_api_key']);

                if (!$found) {
                    _e("Older version settings not found.", "dev4press-updater");
                } else {
                    $key = $old['dev4press_api_key'];

                    d4pupd_settings()->set('dev4press_api_key', $key, 'settings', true);

                    _e("API Key imported from previous plugin version. Check all plugin settings to make sure everything is OK.", "dev4press-updater");

                    delete_site_option('dev4press-updater');
                }

                ?>

                <h3><?php _e("All Done", "dev4press-updater"); ?></h3>
                <?php

                    d4pupd_settings()->set('install', false, 'info');
                    d4pupd_settings()->set('update', false, 'info', true);

                    _e("Installation completed.", "dev4press-updater");

                ?>
                <br/><br/><a class="button-primary" href="<?php echo network_admin_url('admin.php?page=dev4press-updater-about'); ?>"><?php _e("Click here to continue.", "dev4press-updater"); ?></a>
            </div>
            <?php echo d4pupd_plugin()->recommend('install'); ?>
        </div>
    </div>
</div>