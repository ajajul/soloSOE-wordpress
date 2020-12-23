<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;
use WP_Error;

if (!defined('ABSPATH')) {
    exit;
}

class LockTopics extends Feature {
    public $feature_name = 'lock-topics';
    public $settings = array(
        'lock' => true
    );

    private $_defaults = array(
        'topic' => array(
            'edit' => array('gdbbx-lock'),
            'bulk' => array('gdbbx-lock')
        )
    );

    public function __construct() {
        parent::__construct();

        add_action('gdbbx_template', array($this, 'loader'));

        add_action('gdfar_register_actions', array($this, 'register'));

        foreach ($this->_defaults as $scope => $actions) {
            foreach ($actions as $action => $names) {
                foreach ($names as $name) {
                    $key = $scope.'-'.$action.'-'.$name;
                    $method = $scope.'_'.$action.'_'.str_replace('-', '_', $name);

                    add_filter('gdbbx-action-visible-'.$key, '__return_true');
                    add_filter('gdbbx-action-display-'.$key, array($this, 'display_'.$method), 10, 2);
                    add_filter('gdbbx-action-process-'.$key, array($this, 'process_'.$method), 10, 2);
                }
            }
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\LockTopics */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new LockTopics();
        }

        return $instance;
    }

    public function loader() {
        if (!gdbbx_current_user_can_moderate() && $this->is_topic_temp_locked()) {
            $this->topic_lock_reply_form();
        }

        add_filter('bbp_get_reply_class', array($this, 'topic_post_class'), 10, 2);
        add_filter('bbp_get_topic_class', array($this, 'topic_post_class'), 10, 2);
    }

    public function topic_post_class($classes, $topic_id) {
        if ($this->is_topic_temp_locked($topic_id)) {
            $classes[] = 'locked-topic';
        }

        return $classes;
    }

    public function get_lock_link($id) {
        $locked = $this->is_topic_temp_locked($id) ? 'locked' : 'unlocked';

        $url = add_query_arg('id', $id, bbp_get_topic_permalink($id));
        $url = add_query_arg('_wpnonce', wp_create_nonce('gdbbx_lock_'.$id), $url);

        if ($locked == 'locked') {
            $url = add_query_arg('action', 'unlock', $url);

            return '<a href="'.esc_url($url).'" class="d4p-bbt-lock-link">'.esc_html__("Unlock", "gd-bbpress-toolbox").'</a>';
        } else {
            $url = add_query_arg('action', 'lock', $url);

            return '<a href="'.esc_url($url).'" class="d4p-bbt-lock-link">'.esc_html__("Lock", "gd-bbpress-toolbox").'</a>';
        }
    }

    public function is_topic_temp_locked($topic_id = 0) {
        $topic_id = bbp_get_topic_id($topic_id);

        return get_post_meta($topic_id, '_gdbbx_temp_lock', true) === 'locked';
    }

    public function topic_lock_reply_form() {
        add_filter('bbp_get_template_part', array($this, 'replace_topic_reply_form'), 99999, 3);
    }

    public function message_topic_reply_lock() {
        return apply_filters('gdbbx_privacy_topic_reply_form_message', __("This topic is temporarily locked.", "gd-bbpress-toolbox"));
    }

    public function replace_topic_reply_form($templates, $slug, $name) {
        if ($slug == 'form' && $name == 'reply' && !bbp_is_reply_edit()) {
            $templates = array('gdbbx-form-lock.php');
        }

        return $templates;
    }

    public function lock_topic($topic_id = 0, $status = 'lock') {
        $topic_id = bbp_get_topic_id($topic_id);

        delete_post_meta($topic_id, '_gdbbx_temp_lock');

        if ($status == 'lock') {
            add_post_meta($topic_id, '_gdbbx_temp_lock', 'locked', true);
        }
    }

    public function register() {
        gdfar_register_action('gdbbx-lock', array(
            'scope' => 'topic',
            'action' => 'edit',
            'prefix' => 'gdbbx',
            'label' => __("Lock", "gd-bbpress-toolbox"),
            'description' => __("Change topic lock status.", "gd-bbpress-toolbox"),
            'source' => 'GD bbPress Toolbox Pro'
        ));

        gdfar_register_action('gdbbx-lock', array(
            'scope' => 'topic',
            'action' => 'bulk',
            'prefix' => 'gdbbx',
            'label' => __("Lock", "gd-bbpress-toolbox"),
            'description' => __("Change topic lock status.", "gd-bbpress-toolbox"),
            'source' => 'GD bbPress Toolbox Pro'
        ));
    }

    public function display_topic_edit_gdbbx_lock($render, $args = array()) {
        $list = array('lock' => __("Locked", "gd-bbpress-toolbox"),
            'unlock' => __("Unlocked", "gd-bbpress-toolbox")
        );

        $locked = $this->is_topic_temp_locked($args['id']) ? 'lock' : 'unlock';

        return gdfar_render()->select($list, array('selected' => $locked, 'name' => $args['base'].'[lock]', 'id' => $args['element']));
    }

    public function process_topic_edit_gdbbx_lock($result, $args = array()) {
        $topic_id = $args['id'];

        $new_status = isset($args['value']['lock']) ? $args['value']['lock'] : '';
        $old_status = $this->is_topic_temp_locked($topic_id) ? 'lock' : 'unlock';

        if (empty($new_status) || !in_array($new_status, array('lock', 'unlock'))) {
            return new WP_Error("invalid_lock", __("Invalid lock value.", "gd-bbpress-toolbox"));
        }

        if ($new_status != $old_status) {
            $this->lock_topic($topic_id, $new_status);
        }

        return $result;
    }

    public function display_topic_bulk_gdbbx_lock($render, $args = array()) {
        $list = array('' => __("Don't Change", "gd-bbpress-toolbox"),
            'lock' => __("Locked", "gd-bbpress-toolbox"),
            'unlock' => __("Unlocked", "gd-bbpress-toolbox")
        );

        return gdfar_render()->select($list, array('selected' => '', 'name' => $args['base'].'[lock]', 'id' => $args['element']));
    }

    public function process_topic_bulk_gdbbx_lock($result, $args = array()) {
        $new_status = isset($args['value']['lock']) ? $args['value']['lock'] : '';

        if (!empty($new_status)) {
            if (!in_array($new_status, array('lock', 'unlock'))) {
                return new WP_Error("invalid_lock", __("Invalid lock value.", "gd-bbpress-toolbox"));
            }

            foreach ($args['id'] as $topic_id) {
                $old_status = $this->is_topic_temp_locked($topic_id) ? 'lock' : 'unlock';

                if ($new_status != $old_status) {
                    $this->lock_topic($topic_id, $new_status);
                }
            }
        }

        return $result;
    }
}
