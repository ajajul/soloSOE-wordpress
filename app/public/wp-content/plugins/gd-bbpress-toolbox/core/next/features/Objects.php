<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class Objects extends Feature {
    public $feature_name = 'objects';
    public $settings = array(
        'add_forum_features' => array(),
        'add_topic_features' => array(),
        'add_reply_features' => array()
    );

    public function __construct() {
        parent::__construct();

        $_forums = $this->settings['add_forum_features'];
        if (!empty($_forums)) {
            add_filter('bbp_get_forum_post_type_supports', array($this, 'bbp_supports_forum'));
        }

        $_topics = $this->settings['add_topic_features'];
        if (!empty($_topics)) {
            add_filter('bbp_get_topic_post_type_supports', array($this, 'bbp_supports_topic'));
        }

        $_replies = $this->settings['add_reply_features'];
        if (!empty($_replies)) {
            add_filter('bbp_get_reply_post_type_supports', array($this, 'bbp_supports_reply'));
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\Objects */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Objects();
        }

        return $instance;
    }

    public function bbp_supports_forum($supports) {
        $supports = array_merge($supports, $this->settings['add_forum_features']);

        return $supports;
    }

    public function bbp_supports_topic($supports) {
        $supports = array_merge($supports, $this->settings['add_topic_features']);

        return $supports;
    }

    public function bbp_supports_reply($supports) {
        $supports = array_merge($supports, $this->settings['add_reply_features']);

        return $supports;
    }
}
