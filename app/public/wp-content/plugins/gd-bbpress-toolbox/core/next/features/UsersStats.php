<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;
use Dev4Press\Plugin\GDBBX\Basic\Feature;
use Dev4Press\Plugin\GDBBX\Basic\Features;
use WP_User;

if (!defined('ABSPATH')) {
    exit;
}

class UsersStats extends Feature {
    public $feature_name = 'users-stats';
    public $settings = array(
        'super_admin' => true,
        'visitor' => false,
        'roles' => null,
        'show_online_status' => true,
        'show_registration_date' => false,
        'show_topics' => true,
        'show_replies' => true,
        'show_thanks_given' => false,
        'show_thanks_received' => false
    );

    public function __construct() {
        parent::__construct();

        if ($this->allowed()) {
            add_action('bbp_theme_after_topic_author_details', array($this, 'user_stats'));
            add_action('bbp_theme_after_reply_author_details', array($this, 'user_stats'));

            add_action('gdbbx_template_before_replies_loop', array($this, 'before_replies_loop'), 10, 2);
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\UsersStats */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new UsersStats();
        }

        return $instance;
    }

    public function before_replies_loop($posts, $users) {
        gdbbx_cache()->userstats_run_bulk_counts($users);
        gdbbx_cache()->userstats_run_bulk_online($users);
    }

    public function user_stats() {
        if (bbp_is_reply_anonymous()) {
            return;
        }

        Enqueue::instance()->core();

        $list = array();
        $author = bbp_get_reply_author_id();

        if ($author > 0) {
            if ($this->settings['show_online_status'] && function_exists('gdbbx_module_online')) {
                $online = gdbbx_module_online()->is_online($author);

                $item = apply_filters('gdbbx_user_stats_online_status',
                    '<div class="gdbbx-user-stats-block gdbbx-user-stats-online-status">
                 <span class="gdbbx-label gdbbx-status-'.($online ? 'online' : 'offline').'">'.($online ? __("Online", "gd-bbpress-toolbox") : __("Offline", "gd-bbpress-toolbox")).'</span>
                 </div>', $online);

                $list['online_status'] = $item;
            }

            if ($this->settings['show_registration_date']) {
                $user = get_user_by('id', $author);

                if ($user instanceof WP_User) {
                    $date = $user->user_registered;
                    $format = apply_filters('gdbbx_user_stats_registered_date_format', get_option('date_format'));

                    $item = apply_filters('gdbbx_user_stats_registered_on',
                        '<div class="gdbbx-user-stats-block gdbbx-user-stats-registered">
                 <span class="gdbbx-label">'.__("Registered On", "gd-bbpress-toolbox").':</span> <span class="gdbbx-value">'.mysql2date($format, $date).'</span>
                 </div>', $date, $format);

                    $list['registered'] = $item;
                }
            }

            if ($this->settings['show_topics']) {
                $topics = gdbbx_cache()->userstats_count_posts($author, bbp_get_topic_post_type());

                $item = apply_filters('gdbbx_user_stats_topics_count',
                    '<div class="gdbbx-user-stats-block gdbbx-user-stats-topics">
                 <span class="gdbbx-label">'.__("Topics", "gd-bbpress-toolbox").':</span> <span class="gdbbx-value">'.$topics.'</span>
                 </div>', $topics);

                $list['topics'] = $item;
            }

            if ($this->settings['show_replies']) {
                $replies = gdbbx_cache()->userstats_count_posts($author, bbp_get_reply_post_type());

                $item = apply_filters('gdbbx_user_stats_replies_count',
                    '<div class="gdbbx-user-stats-block gdbbx-user-stats-replies">
                 <span class="gdbbx-label">'.__("Replies", "gd-bbpress-toolbox").':</span> <span class="gdbbx-value">'.$replies.'</span>
                 </div>', $replies);

                $list['replies'] = $item;
            }

            if (Features::instance()->is_enabled('thanks')) {
                if ($this->settings['show_thanks_given']) {
                    $thanks_given = gdbbx_cache()->thanks_get_count_given($author);

                    $item = apply_filters('gdbbx_user_stats_thanks_given_count',
                        '<div class="gdbbx-user-stats-block gdbbx-user-stats-thanks-given">
                     <span class="gdbbx-label">'.__("Has thanked", "gd-bbpress-toolbox").':</span> <span class="gdbbx-value">'.sprintf(_n("%s time", "%s times", $thanks_given, "gd-bbpress-toolbox"), $thanks_given).'</span>
                     </div>', $thanks_given);

                    $list['thanks_given'] = $item;
                }

                if ($this->settings['show_thanks_received']) {
                    $thanks_received = gdbbx_cache()->thanks_get_count_received($author);

                    $item = apply_filters('gdbbx_user_stats_thanks_received_count',
                        '<div class="gdbbx-user-stats-block gdbbx-user-stats-thanks-received">
                     <span class="gdbbx-label">'.__("Been thanked", "gd-bbpress-toolbox").':</span> <span class="gdbbx-value">'.sprintf(_n("%s time", "%s times", $thanks_received, "gd-bbpress-toolbox"), $thanks_received).'</span>
                     </div>', $thanks_received);

                    $list['thanks_received'] = $item;
                }
            }
        }

        $list = apply_filters('gdbbx_user_stats_items', $list, $author);

        echo '<div class="gdbbx-user-stats">'.join('', $list).'</div>';
    }
}
