<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class VisitorsRedirect extends Feature {
    public $feature_name = 'visitors-redirect';
    public $settings = array(
        'for_visitors' => false,
        'for_visitors_url' => '',
        'hidden_forums' => false,
        'hidden_forums_url' => '',
        'private_forums' => false,
        'private_forums_url' => '',
        'blocked_users' => false,
        'blocked_users_url' => ''
    );

    public function __construct() {
        parent::__construct();

        if (!is_admin()) {
            if (!is_user_logged_in() && $this->settings['for_visitors']) {
                add_action('bbp_template_redirect', array($this, 'redirect_all'));
            }

            if ($this->settings['hidden_forums']) {
                remove_action('bbp_template_redirect', 'bbp_forum_enforce_hidden', 1);
                add_action('bbp_template_redirect', array($this, 'hidden_forums'), 1);
            }

            if ($this->settings['private_forums']) {
                remove_action('bbp_template_redirect', 'bbp_forum_enforce_private', 1);
                add_action('bbp_template_redirect', array($this, 'private_forums'), 1);
            }

            if ($this->settings['blocked_users']) {
                remove_action('bbp_template_redirect', 'bbp_forum_enforce_blocked', 1);
                add_action('bbp_template_redirect', array($this, 'blocked_users'), 1);
            }
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\VisitorsRedirect */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new VisitorsRedirect();
        }

        return $instance;
    }

    public function redirect_to_key($key) {
        $url = $this->settings[$key];

        if (empty($url)) {
            $url = get_site_url();
        }

        $url = apply_filters('gdbbx_visitors_redirect_'.$key, $url);

        wp_redirect($url);
        exit;
    }

    public function redirect_all() {
        if (apply_filters('gdbbx_visitors_redirect_bbpress', gdbbx_is_bbpress())) {
            $this->redirect_to_key('for_visitors_url');
        }
    }

    public function hidden_forums() {
        if (bbp_is_user_keymaster() || current_user_can('read_hidden_forums')) {
            return;
        }

        $forum_id = gdbbx_get_forum_from_wp_query();
        $redirect = !empty($forum_id) && bbp_is_forum_hidden($forum_id) && !current_user_can('read_hidden_forums');

        if (apply_filters('gdbbx_visitors_redirect_hidden_forums', $redirect, $forum_id)) {
            $this->redirect_to_key('hidden_forums_url');
        }
    }

    public function private_forums() {
        if (bbp_is_user_keymaster() || current_user_can('read_private_forums')) {
            return;
        }

        $forum_id = gdbbx_get_forum_from_wp_query();
        $redirect = !empty($forum_id) && bbp_is_forum_private($forum_id) && !current_user_can('read_private_forums');

        if (apply_filters('gdbbx_visitors_redirect_private_forums', $redirect, $forum_id)) {
            $this->redirect_to_key('private_forums_url');
        }
    }

    public function blocked_users() {
        if (!is_user_logged_in() || bbp_is_user_keymaster()) {
            return;
        }

        $redirect = is_bbpress() && !current_user_can('spectate');

        if (apply_filters('gdbbx_visitors_redirect_blocked_users', $redirect, bbp_get_current_user_id())) {
            $this->redirect_to_key('blocked_users_url');
        }
    }
}
