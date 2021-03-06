<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;
use Dev4Press\Plugin\GDBBX\Basic\Feature;
use WP_User;
use WP_User_Query;

if (!defined('ABSPATH')) {
    exit;
}

class ForumIndex extends Feature {
    public $feature_name = 'forum-index';
    public $settings = array(
        'welcome_front' => false,
        'welcome_filter' => 'before',
        'welcome_front_roles' => null,
        'welcome_show_links' => true,
        'statistics_front' => false,
        'statistics_filter' => 'after',
        'statistics_front_roles' => null,
        'statistics_front_visitor' => false,
        'statistics_show_online' => true,
        'statistics_show_online_overview' => true,
        'statistics_show_online_top' => true,
        'statistics_show_users' => 0,
        'statistics_show_users_colors' => false,
        'statistics_show_users_avatars' => false,
        'statistics_show_users_links' => false,
        'statistics_show_users_limit' => 32,
        'statistics_show_legend' => false,
        'statistics_show_statistics' => true,
        'statistics_show_statistics_totals' => true,
        'statistics_show_statistics_newest_user' => false
    );

    public function __construct() {
        parent::__construct();

        if ($this->settings['welcome_front'] && $this->allowed('welcome_front', 'forum-index-welcome')) {
            if ($this->settings['welcome_filter'] == 'before') {
                add_action('bbp_template_before_forums_index', array($this, 'welcome_index'));
            } else {
                add_action('bbp_template_after_forums_index', array($this, 'welcome_index'));
            }
        }

        if ($this->settings['statistics_front'] && $this->allowed('statistics_front', 'forum-index-statistics')) {
            if ($this->settings['statistics_filter'] == 'before') {
                add_action('bbp_template_before_forums_index', array($this, 'forum_index'));
            } else {
                add_action('bbp_template_after_forums_index', array($this, 'forum_index'));
            }
        }
    }

    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new ForumIndex();
        }

        return $instance;
    }

    public function get_welcome($name) {
        return $this->settings['welcome_show_'.$name];
    }

    public function get_statistics($name) {
        return $this->settings['statistics_show_'.$name];
    }

    public function welcome_index() {
        Enqueue::instance()->core();

        include(gdbbx_get_template_part('gdbbx-forums-welcome.php'));
    }

    public function forum_index() {
        Enqueue::instance()->core();

        include(gdbbx_get_template_part('gdbbx-forums-statistics.php'));
    }

    public function user_visit() {
        $timestamp = GDBBX_LAST_ACTIVTY + 3600 * d4p_gmt_offset();

        $out = array(
            'timestamp' => GDBBX_LAST_ACTIVTY,
            'topics' => gdbbx_db()->get_topics_count_since(GDBBX_LAST_ACTIVTY),
            'replies' => gdbbx_db()->get_replies_count_since(GDBBX_LAST_ACTIVTY),
            'time' => date(get_option('time_format'), $timestamp),
            'date' => date(get_option('date_format'), $timestamp),
        );

        $out['posts'] = $out['topics'] + $out['replies'];

        if ($out['posts'] == 0) {
            add_filter('gdbbx_welcome_back_user_links_last_visit', '__return_false');
        }

        return $out;
    }

    public function user_links() {
        $links = array();

        $_view_new_posts = CustomViews::instance()->settings['newposts_slug'];
        if (bbp_get_view_id($_view_new_posts) !== false && apply_filters('gdbbx_welcome_back_user_links_last_visit', true)) {
            $links[] = '<a href="'.bbp_get_view_url($_view_new_posts).'">'.__("New posts since last visit", "gd-bbpress-toolbox").'</a>';
        }

        $_view_latest_topics = CustomViews::instance()->settings['latesttopics_slug'];
        if (bbp_get_view_id($_view_latest_topics) !== false) {
            $links[] = '<a href="'.bbp_get_view_url($_view_latest_topics).'">'.__("All latest topics", "gd-bbpress-toolbox").'</a>';
        }

        $links[] = '<a href="'.bbp_get_user_profile_url(bbp_get_current_user_id()).'">'.__("My user profile page", "gd-bbpress-toolbox").'</a>';

        return $links;
    }

    public function user_roles_legend() {
        $_roles = gdbbx_get_user_roles();

        $items = array();

        foreach ($_roles as $role => $name) {
            $items[] = '<span class="gdbbx-front-user gdbbx-user-color-'.$role.'">'.$name.'</span>';
        }

        return join(', ', $items);
    }

    public function users_list($_show = null, $_limit = null, $user_args = array()) {
        $_show = is_null($_show) ? $this->get_statistics('users') : absint($_show);
        $_limit = is_null($_limit) ? $this->get_statistics('users_limit') : absint($_limit);

        $items = array();

        if ($_show == 0) {
            $online = gdbbx_module_online()->online();

            $_users = array();
            foreach ($online['roles'] as $ids) {
                $_users = array_merge($_users, $ids);
            }

            foreach ($_users as $id) {
                if (count($items) == $_limit) {
                    break;
                }

                $_user = get_user_by('id', absint($id));

                if ($_user !== false) {
                    $items[] = $_user;
                }
            }

            $label = __("Users currently online", "gd-bbpress-toolbox");
        } else {
            $_users = array_keys(gdbbx_db()->get_users_active_in_past($_show * MINUTE_IN_SECONDS, $_limit));

            foreach ($_users as $id) {
                $_user = get_user_by('id', absint($id));

                if ($_user !== false) {
                    $items[] = $_user;
                }
            }

            $standard = array(
                30 => __("30 minutes", "gd-bbpress-toolbox"),
                60 => __("60 minutes", "gd-bbpress-toolbox"),
                120 => __("2 hours", "gd-bbpress-toolbox"),
                720 => __("12 hours", "gd-bbpress-toolbox"),
                1440 => __("24 hours", "gd-bbpress-toolbox"),
                4320 => __("3 days", "gd-bbpress-toolbox"),
                10080 => __("7 days", "gd-bbpress-toolbox")
            );

            if (isset($standard[$_show])) {
                $period = $standard[$_show];
            } else {
                $period = sprintf(_n("%s minute", "%s minutes", $_show, "gd-bbpress-toolbox"), $_show);
            }

            $label = sprintf(__("Users active in the past %s", "gd-bbpress-toolbox"), $period);
        }

        $render = array();

        foreach ($items as $user) {
            if ($user instanceof WP_User) {
                $render[] = $this->_user_format_for_display($user, $user_args);
            }
        }

        if (empty($render)) {
            $render[] = '&minus;';
        }

        return '<label>'.$label.':</label> '.join(', ', $render);
    }

    public function newest_user() {
        $users = new WP_User_Query(array(
            'orderby' => 'registered',
            'order' => 'DESC', 'number' => 1
        ));

        $user = $users->get_results();

        return $this->_user_format_for_display($user[0]);
    }

    private function _user_format_for_display(WP_User $user, $args = array()) {
        $defaults = array(
            'color' => $this->get_statistics('users_colors'),
            'avatar' => $this->get_statistics('users_avatars'),
            'link' => $this->get_statistics('users_links'),
            'wrapped' => true
        );

        $args = wp_parse_args($args, $defaults);

        $_roles = $args['color'] ? $this->_user_roles($user) : array();

        $_class = 'gdbbx-front-user';

        if (!empty($_roles)) {
            $_class .= ' gdbbx-user-color-'.$_roles[0];
        }

        $item = '<span class="'.$_class.'">';

        if ($args['wrapped'] && $args['avatar']) {
            if ($args['link']) {
                $item .= '<a class="bbp-author-avatar" href="'.esc_url(bbp_get_user_profile_url($user->ID)).'">';
            }

            $item .= get_avatar($user, '14');
            $item .= $user->display_name;

            if ($args['link']) {
                $item .= '</a>';
            }
        } else {
            if ($args['avatar']) {
                if ($args['link']) {
                    $item .= '<a class="bbp-author-avatar" href="'.esc_url(bbp_get_user_profile_url($user->ID)).'">';
                }

                $item .= get_avatar($user, '14');

                if ($args['link']) {
                    $item .= '</a>';
                }
            }

            if ($args['link']) {
                $item .= bbp_get_user_profile_link($user->ID);
            } else {
                $item .= $user->display_name;
            }
        }

        $item .= '</span>';

        return $item;
    }

    private function _user_roles(WP_User $user) {
        $_roles = array_keys(gdbbx_get_user_roles());
        $_inter = array_intersect($user->roles, $_roles);

        return array_values($_inter);
    }
}
