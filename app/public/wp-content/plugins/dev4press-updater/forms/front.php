<?php

if (!defined('ABSPATH')) exit;

include(D4PUPD_PATH.'forms/shared/top.php');

$scopes = array(
    'normal' => array('beta'),
    'alpha' => array('alpha', 'beta'),
    'nightly' => array('nightly', 'alpha', 'beta')
);

$promotions = fetch_feed(d4pupd_updater()->feeds['promotions']);

?>

<div class="d4p-content-left">
    <img src="<?php echo D4PUPD_URL ?>gfx/sign.png" alt="Dev4Press Updater"  />
    <div class="d4p-panel-title">
        <h3><?php _e("Dev4Press Updater", "dev4press-updater"); ?></h3>
    </div>
    <div style="text-align: right; font-size: 20px; line-height: 26px;">
        <?php _e("Version", "dev4press-updater"); ?>: 
        <strong><?php echo d4pupd_settings()->info_version; ?></strong><br/>
        <?php echo d4pupd_settings()->info_updated; ?>
    </div>
</div>
<div class="d4p-content-right">
    <?php

    if (d4pupd_settings()->update_one_year_expired()) {
        
    ?>

    <div class="d4pupd-notice-info">
        <?php _e("Dev4Press Updater installed on this website is over a year old, and it is no longer allowed to access Dev4Press plugins update system.", "dev4press-updater"); ?>
    </div>
    
    <?php

    } else if (d4pupd_settings()->update_six_months_expired()) {
        
    ?>

    <div class="d4pupd-notice-info">
        <?php _e("Dev4Press Updater installed on this website is older then six months. You need to update it as soon as possible, or you will not be able to update and install plugins using old versions of Dev4Press Updater.", "dev4press-updater"); ?>
    </div>
    
    <?php

    }

    ?>
    <?php if (d4pupd_updater()->apikey == '') { ?>
    <div class="d4p-group d4p-group-update-status">
        <h3><?php _e("API Key missing!", "dev4press-updater"); ?></h3>
        <div class="d4p-group-inner" style="text-align: left;">
            <p style="margin-bottom: 10px;"><?php _e("You need to enter Dev4Press API Key before you can check for the updates.", "dev4press-updater"); ?></p>
            <a class="button-primary" href="admin.php?page=dev4press-updater-settings&panel=api"><?php _e("Enter API Key", "dev4press-updater"); ?></a>
        </div>
    </div>
    <?php } else {

        if ($promotions->get_item_quantity() > 0) {
            $item = $promotions->get_item(0);
            $_url = d4pupd_plugin()->feed_url($item->get_permalink());

            ?>

            <div class="d4p-group d4p-group-update-status d4p-group-promotion">
                <h3><?php _e("Promotion", "dev4press-updater"); ?>: <?php echo esc_html($item->get_title()); ?></h3>
                <div class="d4p-group-inner">
                    <p><?php echo $item->get_description(); ?></p>
                    <a target="_blank" class="button-primary" href="<?php echo esc_url($_url); ?>"><?php _e("Read More", "dev4press-updater"); ?></a>
                </div>
            </div>

            <?php
        }

        $update_last = _x("Never", "When the last check was performed", "dev4press-updater");

        if (isset(d4pupd_updater()->update['core']['time'])) {
            $update_last = sprintf(_x("%s ago", "When the last check was performed", "dev4press-updater"), human_time_diff(d4pupd_updater()->update['core']['time']));
        }

        $core = d4pupd_updater()->core();
        $updates = d4pupd_updater()->has_updates();
        $no_updates = empty($updates['plugins']) || $core === false || $core['status'] != 'ok';

        $_api_key_error = isset($core['code']) && in_array($core['code'], array('api_key_missing', 'api_key_invalid'));

    ?>
    <div class="d4p-group d4p-group-update-status">
        <h3><?php _e("Update Status", "dev4press-updater"); ?></h3>
        <div class="d4p-group-inner">
            <?php if (d4pupd_settings()->get('update_status') != 'stable') { ?>
            <div class="d4p-block-notice-nonstable">
                <?php echo sprintf(__("The updater is currently set to allow %s updates. These updates can be unstable, they are for testing purposes only, and they should be used on staging, localhost or development websites only, not on live websites!", "dev4press-updater"), '<strong>'.join('</strong>, <strong>', $scopes[d4pupd_settings()->get('update_status')]).'</strong>'); ?> 
                <?php echo sprintf(__("To change the updates received, visit the <a href='%s'>Settings</a> page.", "dev4press-updater"), network_admin_url('admin.php?page=dev4press-updater-settings&panel=control')); ?>
            </div>
            <?php } ?>

            <div class="d4p-block-update-status">
                <strong><?php _e("Last check performed", "dev4press-updater"); ?>: </strong><?php echo $update_last; ?>
            </div>

            <div class="d4p-block-update-updates">
                <?php

                if ($core === false || $core['status'] != 'ok') {
                    echo '<div class="d4p-block-notice-error">';
                    if ($core === false) {
                        echo '<p>'.__("Unspecified error occured during the update check, no response received.", "dev4press-updater").'</p>';
                    } else {
                        echo '<p>'.__($core['message'], "dev4press-updater").'</p>';

                        if ($_api_key_error) {
                            echo '<p><a class="button-primary" href="'.network_admin_url("admin.php?page=dev4press-updater-settings&panel=api").'">'.__("Enter Valid API Key", "dev4press-updater").'</a></p>';
                        }
                    }
                    echo '</div>';
                } else {
                    if ($no_updates) {
                        _e("There are no updates currently available", "dev4press-updater");
                    } else {
                        if (!empty($updates['plugins'])) {
                            $num = count($updates['plugins']);

                            echo sprintf(_n("<strong>%s plugin</strong> availbale for update", "<strong>%s plugins</strong> availbale for update", $num, "dev4press-updater"), $num).':';

                            echo '<ul>';
                            foreach ($updates['plugins'] as $plugin) {
                                echo '<li>'.$plugin['name'].' <strong>'.$plugin['version'].'</strong>';

                                if ($plugin['status'] != 'stable') {
                                    echo ' <strong style="color: #900">'.ucfirst($plugin['status']).'</strong>';
                                }

                                echo ' ('.$plugin['released'].')</li>';
                            }

                            echo '</ul>';
                        }
                    }
                }

                ?>
            </div>
            <div class="d4p-block-update-check">
                <a href="<?php echo self_admin_url('admin.php?page=dev4press-updater-products'); ?>" class="button-primary"><i aria-hidden="true" class="fa fa-cloud-upload fa-fw"></i> <?php _e("Installed plugins", "dev4press-updater"); ?></a>
                <?php if (!$no_updates) { ?>
                    <a href="<?php echo self_admin_url('update-core.php'); ?>" class="button-primary"><i aria-hidden="true" class="fa fa-tasks fa-fw"></i> <?php _e("WordPress Updates", "dev4press-updater"); ?></a>
                <?php } ?>
                <?php if (!d4pupd_settings()->update_one_year_expired()) { ?>
                    <a href="<?php echo d4pupd_check_update_url(); ?>" class="button-secondary" style="float: right"><i aria-hidden="true" class="fa fa-refresh fa-fw"></i> <?php _e("Recheck", "dev4press-updater"); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="d4p-group d4p-group-update-status">
        <h3><?php _e("Additional Options", "dev4press-updater"); ?></h3>
        <div class="d4p-group-inner">
            <div class="d4p-block-update-updates" style="margin-top: 0px;">
                <?php

                _e("Check out latest news, new releases and available promotions. Install more plugins if you have active licenses, or purchase licenses for Dev4Press plugins or addons.", "dev4press-updater");

                ?>
            </div>
            <div class="d4p-block-update-check">
                <a href="<?php echo self_admin_url('admin.php?page=dev4press-updater-news'); ?>" class="button-primary"><i aria-hidden="true" class="fa fa-rss-square fa-fw"></i> <?php _e("News and Deals", "dev4press-updater"); ?></a>
                <a href="<?php echo self_admin_url('admin.php?page=dev4press-updater-install'); ?>" class="button-secondary"><i aria-hidden="true" class="fa fa-cloud-download fa-fw"></i> <?php _e("Install more", "dev4press-updater"); ?></a>
                <a href="<?php echo self_admin_url('admin.php?page=dev4press-updater-purchase'); ?>" class="button-secondary"><i aria-hidden="true" class="fa fa-shopping-cart fa-fw"></i> <?php _e("Buy licenses", "dev4press-updater"); ?></a>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="d4p-group d4p-group-update-system">
        <h3><?php _e("System Status", "dev4press-updater"); ?></h3>
        <div class="d4p-group-inner">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e("Updater", "dev4press-updater"); ?></th>
                        <td>
                            <strong><?php _e("Plugin Version", "dev4press-updater"); ?>: </strong><?php echo d4pupd_settings()->info_version; ?> &middot; 
                            <strong><?php _e("Build", "dev4press-updater"); ?>: </strong><?php echo d4pupd_settings()->info_build; ?><br/>
                            <strong><?php _e("Update Server Version", "dev4press-updater"); ?>: </strong><?php echo isset(d4pupd_updater()->update['core']['api_version']) ? d4pupd_updater()->update['core']['api_version'] : __("Invalid", "dev4press-updater"); ?><br/>
                            <strong><?php _e("Last Update Check", "dev4press-updater"); ?>: </strong><?php echo isset(d4pupd_updater()->update['core']['time']) ? date('r', d4pupd_updater()->update['core']['time'] + 3600 * d4p_gmt_offset()) : __("No Information", "dev4press-updater"); ?><br/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e("Website", "dev4press-updater"); ?></th>
                        <td>
                            <strong><?php _e("URL", "dev4press-updater"); ?>: </strong><?php echo d4pupd_plugin()->domain; ?><br/>
                            <strong><?php _e("WordPress", "dev4press-updater"); ?>: </strong><?php global $wp_version; echo $wp_version; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e("Server", "dev4press-updater"); ?></th>
                        <td>
                            <strong><?php _e("Server", "dev4press-updater"); ?>: </strong><?php echo $_SERVER["SERVER_SOFTWARE"]; ?><br/>
                            <strong><?php _e("Operating System", "dev4press-updater"); ?>: </strong><?php echo PHP_OS; ?><br/>
                            <strong><?php _e("Hostname", "dev4press-updater"); ?>: </strong><?php echo $_SERVER['SERVER_NAME']; ?><br/>
                            <strong><?php _e("IP and Port", "dev4press-updater"); ?>: </strong><?php echo $_SERVER['SERVER_ADDR']." (".$_SERVER['SERVER_PORT']; ?>)
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e("Software", "dev4press-updater"); ?></th>
                        <td>
                            <strong><?php _e("PHP Version", "dev4press-updater"); ?>: </strong><?php echo phpversion(); ?><br/>
                            <strong><?php _e("mySQL Version", "dev4press-updater"); ?>: </strong><?php echo d4pupd_mysql_version(); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 

include(D4PUPD_PATH.'forms/shared/bottom.php');
