<?php

if (!defined('ABSPATH')) exit;

include(D4PUPD_PATH.'forms/shared/top.php');

$plugins = d4pupd_updater()->update['install']['plugins'];

foreach ($plugins as $id => $plugin) {
    $_key = isset(d4pupd_updater()->transcode[$plugin->group]) ? d4pupd_updater()->transcode[$plugin->group] : $plugin->group;

    if (file_exists(WP_PLUGIN_DIR.'/'.$_key.'/'.$_key.'.php')) {
        unset($plugins[$id]);
    }
}

?>

<div class="d4p-content-left">
    <div class="d4p-panel-title">
        <i aria-hidden="true" class="fa fa-cloud-download"></i>
        <h3><?php _e("Install", "dev4press-updater"); ?></h3>
    </div>
    <div class="d4p-panel-info">
        <?php _e("This page shows all Dev4Press plugins you can install.", "dev4press-updater"); ?>
    </div>
</div>
<div class="d4p-content-right">
    <?php if (empty($plugins)) { ?>
    <div class="dev4press-listed-nothing">
        <?php _e("You don't have any additional plugins you can install. Check out more Dev4Press plugins:", "dev4press-updater"); ?><br/><br/>
        <a href="admin.php?page=dev4press-updater-purchase" class="button-primary"><?php _e("Dev4Press Plugins", "dev4press-updater"); ?></a>
    </div>
    <?php } else { ?>
    <div class="dev4press-listed-plugins" style="display: <?php echo !empty($plugins) ? 'block' : 'none'; ?>">
        <div>
            <?php

            foreach ($plugins as $install) {
                $code = $install->group.'/'.$install->group.'.php';
                $ribbon = $install->category;

                if (!file_exists(ABSPATH.PLUGINDIR.'/'.$code)) {
                    $data = d4pupd_updater()->update['purchase'][$ribbon.'s'][$install->group];

                    $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&amp;plugin='.urlencode($install->group)), 'install-plugin_'.$install->group);

                    include(D4PUPD_PATH.'forms/parts/plugin.install.php');
                }
            }

            ?>
        </div>
    </div>
    <?php } ?>
</div>

<?php 

include(D4PUPD_PATH.'forms/shared/bottom.php');
