<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;
use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class Quote extends Feature {
    public $feature_name = 'quote';
    public $settings = array(
        'method' => 'bbcode',
        'full_content' => 'postquote',
        'super_admin' => true,
        'visitor' => false,
        'roles' => null
    );

    private $allowed = null;

    function __construct() {
        parent::__construct();

        if ($this->allowed() && !gdbbx_loader()->is_search) {
            add_filter('gdbbx_script_values', array($this, 'script_values'));

            add_filter('bbp_get_reply_content', array($this, 'quote_reply_content'), 90, 2);
            add_filter('bbp_get_topic_content', array($this, 'quote_topic_content'), 90, 2);
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\Quote */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Quote();
        }

        return $instance;
    }

    public function script_values($values) {
        $values['load'][] = 'quote';
        $values['quote'] = apply_filters('gdbbx_quote_script_values', array(
            'method' => $this->settings['method'],
            'bbcode' => $this->settings['full_content'],
            'wrote' => _x("%s wrote", "Quote Author Line", "gd-bbpress-toolbox")
        ));

        return $values;
    }

    public function check_if_allowed() {
        if (is_null($this->allowed)) {
            $this->allowed = bbp_current_user_can_access_create_reply_form();
        }

        if (bbp_is_search_results() || bbp_is_user_home()) {
            $this->allowed = false;
        }

        return $this->allowed;
    }

    private function _quote($id) {
        $is_reply = bbp_is_reply($id);

        $allowed = $is_reply ? gdbbx_is_user_allowed_to_reply($id) : gdbbx_is_user_allowed_to_topic($id);

        if ($allowed) {
            if ($this->settings['method'] == 'html') {
                if ($is_reply) {
                    $url = bbp_get_reply_url($id);
                    $ath = bbp_get_reply_author_display_name($id);
                } else {
                    $url = bbp_get_topic_permalink($id);
                    $ath = bbp_get_topic_author_display_name($id);
                }

                return '<a role="button" href="#" data-id="'.$id.'" data-url="'.$url.'" data-author="'.$ath.'" class="gdbbx-link-quote">'.$this->_string('quote').'</a>';
            } else {
                return '<a role="button" href="#" data-id="'.$id.'" class="gdbbx-link-quote">'.$this->_string('quote').'</a>';
            }
        } else {
            return false;
        }
    }

    public function get_quote_link($id) {
        $allowed = $this->check_if_allowed();

        if (apply_filters('gdbbx_quote_show_link', $allowed, $id)) {
            return $this->_quote($id);
        }

        return false;
    }

    public function quote_reply_content($content, $reply_id) {
        if (gdbbx()->is_inside_content_shortcode($reply_id)) {
            return $content;
        }

        if (gdbbx_is_feed()) {
            return $content;
        }

        Enqueue::instance()->core();

        if ($this->check_if_allowed()) {
            return '<div id="gdbbx-quote-wrapper-'.bbp_get_reply_id().'">'.$content.'</div>';
        } else {
            return $content;
        }
    }

    public function quote_topic_content($content, $topic_id) {
        if (gdbbx()->is_inside_content_shortcode($topic_id)) {
            return $content;
        }

        if (gdbbx_is_feed()) {
            return $content;
        }

        Enqueue::instance()->core();

        if ($this->check_if_allowed()) {
            return '<div id="gdbbx-quote-wrapper-'.bbp_get_topic_id().'">'.$content.'</div>';
        } else {
            return $content;
        }
    }

    private function _string($name) {
        switch ($name) {
            default:
            case 'quote':
                return apply_filters('gdbbx_quote_string_quote', __("Quote", "gd-bbpress-toolbox"));
        }
    }
}
