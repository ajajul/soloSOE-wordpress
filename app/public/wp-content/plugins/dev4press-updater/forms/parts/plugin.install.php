<?php if (!defined('ABSPATH')) exit; ?>

<div class="plugin-card d4pupd-single-plugin">
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
        <div class="column-rating">
            <?php

            echo '<strong>'.__("Version", "dev4press-updater").'</strong>: '.$install->version;
            echo ' ('.$install->build.')';

            ?>
        </div>
        <div class="column-updated">
            <?php

            $last_update = mysql2date('U', $install->release_date);

            echo sprintf(__("<strong>Last Updated</strong>: %s ago", "dev4press-updater"), human_time_diff($last_update));

            ?>
        </div>
        <div class="column-downloaded">
            <a class="button-primary button-red" href="<?php echo $install_url; ?>"><?php _e("Install Now", "dev4press-updater"); ?></a>
        </div>
        <div class="column-compatibility">
            <?php

            echo '<a target="_blank" href="https://'.$ribbon.'s.dev4press.com/'.$data->code.'/changelog/">';
            echo __("You can see full changelog here", "dev4press-updater").'</a>';

            ?>
        </div>
    </div>
</div>