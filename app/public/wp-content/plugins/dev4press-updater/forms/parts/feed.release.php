<?php

if (!defined('ABSPATH')) exit;

$link_download = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'linkDownload');
$link_download = $link_download[0]['data'];

$link_changelog = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'linkChangelog');
$link_changelog = $link_changelog[0]['data'];

?>
<div class="plugin-card d4pupd-single-feeditem">
    <div class="plugin-card-top">
        <div class="name column-name">
            <h5><a target="_blank" href="<?php echo esc_url($_url); ?>"><?php echo esc_html($item->get_title()); ?></a></h5>
        </div>
        <div class="desc column-description">
            <p><?php echo $item->get_description(); ?></p>
        </div>
    </div>
    <div class="plugin-card-bottom">
        <div class="column-rating">
            <a target="_blank" class="button-primary" href="<?php echo esc_url(d4pupd_plugin()->feed_url($link_changelog)); ?>"><?php _e("Changelog", "dev4press-updater"); ?></a><a style="margin-left: 5px;" target="_blank" class="button-secondary" href="<?php echo esc_url(d4pupd_plugin()->feed_url($link_download)); ?>"><?php _e("Download", "dev4press-updater"); ?></a>
        </div>
        <div class="column-updated">
            <?php

            echo '<span style="font-size: 85%">'.__("Released On", "dev4press-updater").'</span>:<br/><strong>'.$item->get_date('j F Y, g:i a').'</strong>';

            ?>
        </div>
    </div>
</div>