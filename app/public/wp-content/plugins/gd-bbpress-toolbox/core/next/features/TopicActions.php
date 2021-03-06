<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;
use Dev4Press\Plugin\GDBBX\Basic\Features;

if (!defined('ABSPATH')) {
    exit;
}

class TopicActions extends Feature {
    public $feature_name = 'topic-actions';
    public $settings = array(
        'edit' => 'header',
        'merge' => 'header',
        'close' => 'header',
        'stick' => 'header',
        'trash' => 'header',
        'spam' => 'header',
        'approve' => 'header',
        'reply' => 'header',
        'lock' => 'footer',
        'duplicate' => 'footer',
        'thanks' => 'footer',
        'quote' => 'footer',
        'report' => 'footer'
    );

    public $links = array();
    public $defaults = array();
    public $has_footer = false;

    public function __construct() {
        parent::__construct();

        $this->defaults = array_keys($this->settings);
        $this->has_footer = Features::instance()->is_enabled('footer-actions');

        add_filter('bbp_topic_admin_links', array($this, 'topic_admin_links'), 10, 2);
        add_filter('gdbbx_topic_footer_links', array($this, 'topic_footer_links'), 10, 2);
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\TopicActions */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new TopicActions();
        }

        return $instance;
    }

    private function _generate_links($topic_id) {
        if (gdbbx_current_user_can_moderate()) {
            if ($this->settings['duplicate'] != 'hide') {
                $url = bbp_get_topic_permalink($topic_id);

                $url = add_query_arg('id', $topic_id, $url);
                $url = add_query_arg('_wpnonce', wp_create_nonce('gdbbx_dupe_topic_'.$topic_id), $url);
                $url = add_query_arg('action', 'dupe_topic', $url);

                $this->links['duplicate'] = '<a href="'.$url.'" class="d4p-bbt-dupe-topic-link">'.__("Duplicate Topic", "gd-bbpress-toolbox").'</a>';
            }

            if (Features::instance()->is_enabled('lock-topics')) {
                if ($this->settings['lock'] != 'hide') {
                    $link = LockTopics::instance()->get_lock_link($topic_id);

                    if ($link !== false) {
                        $this->links['lock'] = $link;
                    }
                }
            }
        }

        if ($this->settings['thanks'] != 'hide' && gdbbx_say_thanks() !== false) {
            $link = gdbbx_say_thanks()->get_thanks_link($topic_id);

            if ($link !== false) {
                $this->links['thanks'] = $link;
            }
        }

        if ($this->settings['report'] != 'hide' && gdbbx_report() !== false) {
            $link = gdbbx_report()->get_report_link($topic_id);

            if ($link !== false) {
                $this->links['report'] = $link;
            }
        }

        if ($this->settings['quote'] != 'hide' && gdbbx_quote() !== false) {
            $link = gdbbx_quote()->get_quote_link($topic_id);

            if ($link !== false) {
                $this->links['quote'] = $link;
            }
        }
    }

    public function topic_admin_links($links, $topic_id) {
        $this->links = $links;
        $this->_generate_links($topic_id);

        foreach ($this->defaults as $key) {
            if ($this->settings[$key] != 'header' && isset($links[$key])) {
                unset($links[$key]);
            }

            if (isset($this->links[$key])) {
                if ($this->settings[$key] == 'header') {
                    if (!isset($links[$key])) {
                        $links[$key] = $this->links[$key];
                    }
                } else if ($this->settings[$key] == 'footer') {
                    if (!$this->has_footer) {
                        $links[$key] = $this->links[$key];
                    }
                }
            }
        }

        return $links;
    }

    public function topic_footer_links($links, $topic_id) {
        foreach ($this->defaults as $key) {
            if ($this->settings[$key] == 'footer' && isset($this->links[$key])) {
                $links[$key] = $this->links[$key];
            }
        }

        return $links;
    }
}
