<?php if (!defined('ABSPATH')) exit; ?>

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
            <a target="_blank" class="button-primary" href="<?php echo esc_url($_url); ?>"><?php _e("Read More", "dev4press-updater"); ?></a>
        </div>
        <div class="column-updated">
            <?php

            echo '<span style="font-size: 85%">'.__("Published On", "dev4press-updater").'</span>:<br/><strong>'.$item->get_date('j F Y, g:i a').'</strong>';

            ?>
        </div>
    </div>
</div>