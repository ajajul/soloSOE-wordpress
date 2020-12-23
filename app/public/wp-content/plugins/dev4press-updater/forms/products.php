<?php

if (!defined('ABSPATH')) exit;

$icons = array(
    'not_found' => 'fa fa-check',
    'error' => 'fa fa-bug',
    'illegal' => 'fa fa-ban'
);

include(D4PUPD_PATH.'forms/shared/top.php');

$plugins = d4pupd_updater()->get_plugins();

?>

<div class="d4p-content-left">
    <div class="d4p-panel-title">
        <i aria-hidden="true" class="fa fa-cloud-upload"></i>
        <h3><?php _e("Plugins", "dev4press-updater"); ?></h3>
    </div>
    <div class="d4p-panel-info">
        <?php _e("This page shows all Dev4Press plugins  have installed with available updates listed.", "dev4press-updater"); ?>
    </div>
</div>
<div class="d4p-content-right">
    <div class="dev4press-listed-plugins" style="display: block">
        <div>
            <?php

            foreach ($plugins as $plugin) {
                $update_status = 'error';
                $update_message = d4pupd_updater()->generic_error();
                $update_icon = $icons[$update_status];
                $upgrade_url = '';
                $purchase_url = '';
                $data = false;
                $update = false;

                $product_id = isset(d4pupd_updater()->transcode[$plugin['product_id']]) ? d4pupd_updater()->transcode[$plugin['product_id']] : $plugin['product_id'];

                if (isset(d4pupd_updater()->update['purchase']['plugins'][$product_id])) {
                    $data = d4pupd_updater()->update['purchase']['plugins'][$product_id];
                } else if (isset(d4pupd_updater()->update['purchase']['addons'][$product_id])) {
                    $data = d4pupd_updater()->update['purchase']['addons'][$product_id];
                }

                if (isset(d4pupd_updater()->update['plugins'][$plugin['plugin']])) {
                    $update = d4pupd_updater()->update['plugins'][$plugin['plugin']];
                }

                if ($data !== false) {
                    if ($update !== false) {
                        $update_status = key($update);
                        $update_content = $update[$update_status];
                        $update_icon = isset($icons[$update_status]) ? $icons[$update_status] : 'fa fa-download';
                        $update_message = isset($icons[$update_status]) ? __($update_content, "dev4press-updater") : __("New update is available.", "dev4press-updater");

                        $upgrade_url = !isset($icons[$update_status]) ? wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&amp;plugin='.urlencode($plugin['plugin'])), 'upgrade-plugin_'.$plugin['plugin']) : '';
                        $purchase_url = $update_status == 'illegal' ? 'https://plugins.dev4press.com/'.$data->code.'/buy/' : '';
                    }

                    $ribbon = $data->category;

                    include(D4PUPD_PATH.'forms/parts/plugin.installed.php');
                }
            }

            ?>
        </div>
    </div>
</div>

<?php

include(D4PUPD_PATH.'forms/shared/bottom.php');
