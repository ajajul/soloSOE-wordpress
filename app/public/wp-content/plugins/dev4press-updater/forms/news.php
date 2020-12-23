<?php

if (!defined('ABSPATH')) exit;

include(D4PUPD_PATH.'forms/shared/top.php');

$rss = array(
    'promotions' => fetch_feed(d4pupd_updater()->feeds['promotions']),
    'releases' => fetch_feed(d4pupd_updater()->feeds['releases']),
    'blog' => fetch_feed(d4pupd_updater()->feeds['blog'])
);

$promotions = $rss['promotions']->get_item_quantity() > 0 ? 'block' : 'none';
$releases = $promotions == 'block' ? 'none' : 'block';

$_select = $promotions == 'block' ? 'promotions' : 'releases';

?>

<div class="d4p-content-left">
    <div class="d4p-panel-title">
        <i aria-hidden="true" class="fa fa-rss-square"></i>
        <h3><?php _e("News", "dev4press-updater"); ?></h3>
    </div>
    <div class="d4p-panel-info">
        <?php _e("This page shows latest Dev4Press news, promotions and plugins releases.", "dev4press-updater"); ?>
    </div>
    
    <div class="dev4press-switcher">
        <?php _e("You can switch to different News feed from Dev4Press using this selection control:", "dev4press-updater"); ?>
        <select title="<?php _e("Switch the News Feed", "dev4press-updater"); ?>">
            <option<?php echo $_select == 'promotions' ? ' selected="selected"' : ''; ?> value="promotions"><?php _e("Promotions", "dev4press-updater"); ?></option>
            <option<?php echo $_select == 'releases' ? ' selected="selected"' : ''; ?>  value="releases"><?php _e("Releases", "dev4press-updater"); ?></option>
            <option<?php echo $_select == 'blog' ? ' selected="selected"' : ''; ?> value="blog"><?php _e("Blog", "dev4press-updater"); ?></option>
        </select>
    </div>
</div>
<div class="d4p-content-right">
    <div class="dev4press-listed-promotions" style="display: <?php echo $promotions; ?>">
        <h4><?php _e("Active Promotions", "dev4press-updater"); ?></h4>
        <div>
            <?php

            if ($rss['promotions']->get_item_quantity() > 0) {
                $max_items = $rss['promotions']->get_item_quantity();
                $rss_items = $rss['promotions']->get_items(0, $max_items);

                foreach ($rss_items as $item) {
                    $_url = d4pupd_plugin()->feed_url($item->get_permalink());

                    include(D4PUPD_PATH.'forms/parts/feed.promotion.php');
                }
            } else {
                _e("There are no promotions active right now.", "dev4press-updater");
            }

            ?>
        </div>
    </div>
    <div class="dev4press-listed-releases" style="display: <?php echo $releases; ?>">
        <h4><?php _e("Latest Releases", "dev4press-updater"); ?></h4>
        <div>
            <?php

            if ($rss['releases']->get_item_quantity() > 0) {
                $max_items = $rss['releases']->get_item_quantity();
                $rss_items = $rss['releases']->get_items(0, $max_items);

                foreach ($rss_items as $item) {
                    $_url = d4pupd_plugin()->feed_url($item->get_permalink());

                    include(D4PUPD_PATH.'forms/parts/feed.release.php');
                }
            } else {
                _e("There are no new releases in the past 3 months.", "dev4press-updater");
            }

            ?>
        </div>
    </div>
    <div class="dev4press-listed-blog" style="display: none">
        <h4><?php _e("Latest News", "dev4press-updater"); ?></h4>
        <div>
            <?php

            if ($rss['blog']->get_item_quantity() > 0) {
                $max_items = $rss['blog']->get_item_quantity();
                $rss_items = $rss['blog']->get_items(0, $max_items);

                foreach ($rss_items as $item) {
                    $_url = d4pupd_plugin()->feed_url($item->get_permalink());

                    include(D4PUPD_PATH.'forms/parts/feed.news.php');
                }
            } else {
                _e("There are no news in the feed.", "dev4press-updater");
            }

            ?>
        </div>
    </div>
</div>

<?php 

include(D4PUPD_PATH.'forms/shared/bottom.php');
