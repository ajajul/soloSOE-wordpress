<?php

if (!defined('ABSPATH')) exit;

$licenses = d4pupd_updater()->has_licenses($data->code);

?>

<div class="plugin-card d4pupd-single-plugin">
    <div class="corner-ribbon ribbon-<?php echo $ribbon; ?>"><?php echo $ribbon; ?></div>
    <div class="plugin-card-top">
        <a class="plugin-icon"><img alt="<?php echo $data->name; ?>" src="<?php echo d4pupd_updater()->cdn; ?>icons/<?php echo $data->category; ?>s/<?php echo $data->code; ?>.png" /></a>
        <div class="name column-name">
            <h4><?php echo $data->name; ?></h4>
        </div>
        <div class="desc column-description">
            <p><?php echo $data->description; ?></p>
            <p class="authors">
                <cite>
                    <a href="<?php echo $data->url; ?>"><?php _e("Home", "dev4press-updater"); ?></a>
                    <?php if ($ribbon != 'club') { ?>
                     &middot; 
                    <a href="https://support.dev4press.com/forums/forum/plugins/<?php echo $data->code; ?>/"><?php _e("Support Forum", "dev4press-updater"); ?></a> &middot; 
                    <a href="https://support.dev4press.com/kb/product/<?php echo $data->code; ?>/"><?php _e("Documentation", "dev4press-updater"); ?></a>
                    <?php } ?>
                </cite>
            </p>
        </div>
    </div>
    <div class="plugin-card-bottom">
        <div class="column-rating">
            <a target="_blank" class="button-primary button-red" href="<?php echo $data->url_buy; ?>"><?php _e("Buy Now", "dev4press-updater"); ?></a>

            <?php if ($licenses !== false) { $lics = count($licenses); ?>
            <div class="dev4press-licenses"><i aria-hidden="true" class="fa fa-check-square"></i> 
                <?php echo sprintf(_n("You have %s active license for this plugin.", "You have %s active licenses for this plugin.", $lics, "dev4press-updater"), $lics) ?>
            </div>
            <?php } ?>
        </div>
        <div class="column-updated">
            <div class="dev4press-price">
                <strong><?php _e("The license price starting from", "dev4press-updater"); ?></strong> <span>$<?php echo $data->price; ?></span>
            </div>
        </div>
    </div>
</div>
