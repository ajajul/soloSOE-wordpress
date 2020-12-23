<?php if (!defined('ABSPATH')) exit; ?>

<div class="plugin-card d4pupd-plugin-status-<?php echo $update_status; ?> d4pupd-single-plugin<?php if ($upgrade_url != '') { echo ' d4pupd-update-available'; } ?>">
    <div class="corner-ribbon ribbon-<?php echo $ribbon; ?>"><?php echo $ribbon; ?></div>
    <div class="plugin-card-top">
        <a class="plugin-icon"><img alt="<?php echo $data->name; ?>" src="<?php echo d4pupd_updater()->cdn; ?>icons/<?php echo $ribbon; ?>s/<?php echo $data->code; ?>.png" /></a>
        <div class="name column-name">
            <h4><?php echo $data->name; ?></h4>
        </div>
        <div class="desc column-description">
            <p><?php echo $data->description; ?></p>
            <p class="authors">
                <cite>
                    <?php if ($data->category == 'addon') { ?>
                    <a href="https://addons.dev4press.com/<?php echo $data->code; ?>/"><?php _e("Home", "dev4press-updater"); ?></a> &middot; 
                    <a href="https://support.dev4press.com/forums/forum/plugins/<?php echo $data->parent; ?>/addons/<?php echo $data->code; ?>"><?php _e("Support Forum", "dev4press-updater"); ?></a> &middot; 
                    <?php } else { ?>
                    <a href="https://plugins.dev4press.com/<?php echo $data->code; ?>/"><?php _e("Home", "dev4press-updater"); ?></a> &middot; 
                    <a href="https://support.dev4press.com/forums/forum/plugins/<?php echo $data->code; ?>/"><?php _e("Support Forum", "dev4press-updater"); ?></a> &middot; 
                    <?php } ?>
                    <a href="https://support.dev4press.com/kb/product/<?php echo $data->code; ?>/"><?php _e("Documentation", "dev4press-updater"); ?></a>
                </cite>
            </p>
        </div>
    </div>
    <div class="plugin-card-bottom">
        <div class="column-current-version">
            <?php

            echo __("Currently installed Version", "dev4press-updater").': <strong>'.$plugin['version'];
            echo '</strong> ('.__("build", "dev4press-updater").': '.$plugin['build'].')';

            ?>
        </div>
        <div class="column-downloaded">
            <?php if ($upgrade_url != '') { ?>
            <a class="button-primary" href="<?php echo $upgrade_url; ?>"><?php _e("Update Now", "dev4press-updater"); ?></a>
            <?php } else if ($purchase_url != '') { ?>
            <a class="button-primary button-red" href="<?php echo $purchase_url; ?>"><?php _e("Buy Now", "dev4press-updater"); ?></a>
            <?php } else { ?>
            <a target="_blank" class="button-secondary" href="https://plugins.dev4press.com/<?php echo $data->code; ?>/changelog/"><?php _e("Changelog", "dev4press-updater"); ?></a>
            <?php } ?>
        </div>
        <div class="column-compatibility">
            <i aria-hidden="true" class="<?php echo $update_icon; ?>"></i> <?php echo $update_message; ?>
        </div>
        <?php if ($upgrade_url != '') { ?>
        <div class="clear"></div>
        <div class="column-full-width">
            <?php

            $release_date = mysql2date('U', $update_content->release_date);

            echo '<strong>'.__("New Version", "dev4press-updater").'</strong>: '.$update_content->version;

            if ($update_content->status != 'stable') {
                echo ' '.ucfirst($update_content->status);
            }

            echo ' ('.$update_content->build.') &middot; ';
            echo sprintf(__("<strong>Released</strong>: %s ago", "dev4press-updater"), human_time_diff($release_date));
            echo '<br/><strong>'.__("Notice", "dev4press-updater").'</strong>: ';
            echo $update_content->info.' &middot; <a target="_blank" href="https://'.$ribbon.'s.dev4press.com/'.$data->code.'/changelog/">';
            echo __("You can see full changelog here", "dev4press-updater").'</a>';

            if ($update_content->status != 'stable') {
                echo '<div class="not-stable-version">';
                echo sprintf(__("This is a %s version, for testing purposes only. Do not use it on live websites!", "dev4press-updater"), '<strong>'.$update_content->status.'</strong>');
                echo '</div>';
            }
            
            ?>
        </div>
        <?php } ?>
    </div>
</div>