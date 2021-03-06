<?php

namespace Dev4Press\Plugin\GDBBX\Basic;

if (!defined('ABSPATH')) {
    exit;
}

abstract class Feature {
    public $feature_name = '';
    public $has_settings = true;
    public $settings = array();

    public function __construct() {
        if ($this->has_settings) {
            $this->settings = gdbbx()->prefix_get($this->feature_name.'__', 'features');
        }
    }

    public function __get($name) {
        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        }

        return '';
    }

    public function get($name, $missing = null) {
        return isset($this->settings[$name]) ? $this->settings[$name] : $missing;
    }

    protected function allowed($prefix = '', $name = '') {
        $allowed = false;

        $prefix = empty($prefix) ? '' : $prefix.'_';
        $name = empty($name) ? $this->feature_name : $name;

        if (current_user_can('gdbbx_feature_'.$name)) {
            $allowed = true;
        }

        if (!$allowed && isset($this->settings[$prefix.'super_admin']) && is_super_admin()) {
            $allowed = $this->settings[$prefix.'super_admin'];
        }

        if (!$allowed && is_user_logged_in()) {
            $roles = $this->settings[$prefix.'roles'];

            if (is_null($roles)) {
                $allowed = true;
            } else if (is_array($roles) && empty($roles)) {
                $allowed = false;
            } else if (is_array($roles) && !empty($roles)) {
                global $current_user;

                if (is_array($current_user->roles)) {
                    $matched = array_intersect($current_user->roles, $roles);
                    $allowed = !empty($matched);
                }
            }
        }

        if (!$allowed && isset($this->settings[$prefix.'visitor']) && !is_user_logged_in()) {
            $allowed = $this->settings[$prefix.'visitor'];
        }

        return apply_filters('gdbbx_feature_allowed_'.$name, $allowed, $this->settings);
    }
}
