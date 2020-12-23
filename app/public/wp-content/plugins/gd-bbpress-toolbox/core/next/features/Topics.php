<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class Topics extends Feature {
    public $feature_name = 'topics';
    public $settings = array(
        'new_topic_minmax_active' => false,
        'new_topic_min_title_length' => 0,
        'new_topic_min_content_length' => 0,
        'new_topic_max_title_length' => 0,
        'new_topic_max_content_length' => 0,
        'enable_lead_topic' => false,
        'enable_topic_reversed_replies' => false,
        'forum_list_topic_thumbnail' => false
    );

    public function __construct() {
        parent::__construct();

        if ($this->settings['new_topic_minmax_active']) {
            add_filter('bbp_new_topic_pre_title', array($this, 'new_topic_title'));
            add_filter('bbp_new_topic_pre_content', array($this, 'new_topic_content'));
        }

        if (!is_admin()) {
            if ($this->settings['forum_list_topic_thumbnail']) {
                add_action('bbp_theme_before_topic_title', array($this, 'show_thumbnail'));
            }

            if ($this->settings['enable_lead_topic']) {
                add_action('init', array($this, 'show_lead_topic'));
            }

            if ($this->settings['enable_topic_reversed_replies']) {
                add_filter('bbp_before_has_replies_parse_args', array($this, 'change_replies_order'));
            }
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\Topics */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Topics();
        }

        return $instance;
    }

    public function new_topic_title($title) {
        $length = strlen($title);

        if ($this->settings['new_topic_min_title_length'] > 0) {
            if ($length < $this->settings['new_topic_min_title_length']) {
                bbp_add_error('bbp_topic_title', __("<strong>ERROR</strong>: Your topic title is too short.", "gd-bbpress-toolbox"));
            }
        }

        if ($this->settings['new_topic_max_title_length'] > 0) {
            if ($length > $this->settings['new_topic_max_title_length']) {
                bbp_add_error('bbp_topic_title', __("<strong>ERROR</strong>: Your topic title is too long.", "gd-bbpress-toolbox"));
            }
        }

        return $title;
    }

    public function new_topic_content($content) {
        $length = strlen($content);

        if ($this->settings['new_topic_min_content_length'] > 0) {
            if ($length < $this->settings['new_topic_min_content_length']) {
                bbp_add_error('bbp_topic_content', __("<strong>ERROR</strong>: Your topic is too short.", "gd-bbpress-toolbox"));
            }
        }

        if ($this->settings['new_topic_max_content_length'] > 0) {
            if ($length > $this->settings['new_topic_max_content_length']) {
                bbp_add_error('bbp_topic_content', __("<strong>ERROR</strong>: Your topic is too long.", "gd-bbpress-toolbox"));
            }
        }

        return $content;
    }

    public function show_thumbnail() {
        $img = gdbbx_get_topic_thumbnail();

        if ($img != '') {
            echo '<div class="gdbbx-topic-thumbnail"><a href="'.bbp_get_topic_permalink().'"><img src="'.$img.'" alt="'.bbp_get_topic_title().'" /></a></div>';
        }
    }

    public function show_lead_topic() {
        if (!gdbbx_is_feed()) {
            add_filter('bbp_show_lead_topic', '__return_true', 10000);
        }
    }

    public function change_replies_order($r) {
        $r['order'] = 'DESC';

        return $r;
    }
}
