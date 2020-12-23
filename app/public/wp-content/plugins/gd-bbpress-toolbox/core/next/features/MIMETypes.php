<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class MIMETypes extends Feature {
    public $feature_name = 'mime-types';
    public $settings = array(
        'list' => array()
    );

    public function __construct() {
        parent::__construct();

        if (!empty($this->settings['list'])) {
            $this->settings['list'] = (array)$this->settings['list'];
            add_filter('upload_mimes', array($this, 'upload_mimes'));
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\MIMETypes */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new MIMETypes();
        }

        return $instance;
    }

    public function upload_mimes($mimes) {
        return array_merge($mimes, $this->settings['list']);
    }
}
