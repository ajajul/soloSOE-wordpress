<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class Publish extends Feature {
    public $feature_name = 'publish';
    public $settings = array(
        'bbp_is_site_public' => 'auto'
    );

    public function __construct() {
        parent::__construct();

        if ($this->settings['bbp_is_site_public'] == 'public') {
            add_filter('bbp_is_site_public', '__return_true');
        } else if ($this->settings['bbp_is_site_public'] == 'private') {
            add_filter('bbp_is_site_public', '__return_false');
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\Publish */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Publish();
        }

        return $instance;
    }
}
