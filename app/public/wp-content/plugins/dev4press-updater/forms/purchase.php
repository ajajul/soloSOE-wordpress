<?php

if (!defined('ABSPATH')) exit;

include(D4PUPD_PATH.'forms/shared/top.php');

?>

<div class="d4p-content-left">
    <div class="d4p-panel-title">
        <i aria-hidden="true" class="fa fa-shopping-cart"></i>
        <h3><?php _e("Buy", "dev4press-updater"); ?></h3>
    </div>
    <div class="d4p-panel-info">
        <?php _e("From this page you can purchase Dev4Press plugins or Dev4Press Plugins Club Membership.", "dev4press-updater"); ?>
    </div>
</div>
<div class="d4p-content-right">
    <div class="dev4press-listed-plugins" style="display: block;">
        <div>
            <?php

            if (isset(d4pupd_updater()->update['purchase']['plugins']) && 
                      is_array(d4pupd_updater()->update['purchase']['clubs']) && 
                      !empty(d4pupd_updater()->update['purchase']['clubs'])) {
                $ribbon = 'club';
                foreach (d4pupd_updater()->update['purchase']['clubs'] as $data) {
                    if (!empty($data->price)) {
                        include(D4PUPD_PATH.'forms/parts/plugin.purchase.php');
                    }
                }
            }

            if (isset(d4pupd_updater()->update['purchase']['plugins']) && 
                      is_array(d4pupd_updater()->update['purchase']['plugins']) && 
                      !empty(d4pupd_updater()->update['purchase']['plugins'])) {
                $ribbon = 'plugin';
                foreach (d4pupd_updater()->update['purchase']['plugins'] as $data) {
                    if (!empty($data->price)) {
                        include(D4PUPD_PATH.'forms/parts/plugin.purchase.php');
                    }
                }
            }

            if (isset(d4pupd_updater()->update['purchase']['addons']) && 
                      is_array(d4pupd_updater()->update['purchase']['addons']) && 
                      !empty(d4pupd_updater()->update['purchase']['addons'])) {
                $ribbon = 'addon';
                foreach (d4pupd_updater()->update['purchase']['addons'] as $data) {
                    if (!empty($data->price)) {
                        include(D4PUPD_PATH.'forms/parts/plugin.purchase.php');
                    }
                }
            }

            ?>
        </div>
    </div>
</div>

<?php 

include(D4PUPD_PATH.'forms/shared/bottom.php');
