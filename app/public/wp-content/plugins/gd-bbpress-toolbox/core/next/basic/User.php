<?php

namespace Dev4Press\Plugin\GDBBX\Basic;

use Dev4Press\Plugin\GDBBX\Features\UserSettings;

if (!defined('ABSPATH')) {
    exit;
}

class User {
    public $id;

    public function __construct($id = 0) {
        $this->id = $id;
    }

    public static function instance($id = 0) {
        static $instance = array();

        $id = $id == 0 ? bbp_get_current_user_id() : $id;

        if (!isset($instance[$id])) {
            $instance[$id] = new User($id);
        }

        return $instance[$id];
    }

    public function get_default($name, $fallback = null) {
        $obj = UserSettings::instance()->find($name);

        if ($obj === false) {
            return $fallback;
        }

        return $obj->default;
    }

    public function get($name) {
        $value = get_user_option($name, $this->id);

        if ($value === false) {
            return $this->get_default($name, false);
        }

        return $value;
    }
}
