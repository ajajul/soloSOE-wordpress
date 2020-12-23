<?php

if (!defined('ABSPATH')) {
    exit;
}

class d4pupd_admin_settings {
    private $settings;

    function __construct() {
        $this->init();
    }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    private function init() {
        $this->settings = array(
            'api' => array(
                'api_info' => array('name' => __("Important", "dev4press-updater"), 'settings' => array(
                    new d4pSettingElement('settings', '_', __("How to get API Key", "dev4press-updater"), $this->get_info_api_key(), d4pSettingType::INFO),
                )),
                'api_key' => array('name' => __("API Key", "dev4press-updater"), 'settings' => array(
                    new d4pSettingElement('settings', 'dev4press_api_key', __("Enter API Key", "dev4press-updater"), __("Without valid API Key, plugin will not work.", "dev4press-updater"), d4pSettingType::PASSWORD, d4pupd_settings()->get('dev4press_api_key')),
                ))
            ),
            'control' => array(
                'control_auto_check' => array('name' => __("Auto check for updates", "dev4press-updater"), 'settings' => array(
                    new d4pSettingElement('settings', 'check_interval', __("Interval", "dev4press-updater"), '', d4pSettingType::SELECT, d4pupd_settings()->get('check_interval'), 'array', $this->get_auto_check_period())
                )),
                'control_version' => array('name' => __("Update status", "dev4press-updater"), 'settings' => array(
                    new d4pSettingElement('settings', 'update_status', __("Check for", "dev4press-updater"), __("Alpha, Beta and Nightly updates can be unstable, they are for testing purposes only, and they should be used on staging, localhost or development websites only, not on live websites!", "dev4press-updater"), d4pSettingType::SELECT, d4pupd_settings()->get('update_status'), 'array', $this->get_auto_check_versions())
                ))
            ),
            'debug' => array(
                'debug_info' => array('name' => __("Important", "dev4press-updater"), 'settings' => array(
                    new d4pSettingElement('settings', '_', __("About debugging", "dev4press-updater"), $this->get_info_debug(), d4pSettingType::INFO),
                )),
                'debug_level' => array('name' => __("Save data into file for debugging purposes", "dev4press-updater"), 'settings' => array(
                    new d4pSettingElement('settings', 'debug_level', __("What to save", "dev4press-updater"), '', d4pSettingType::SELECT, d4pupd_settings()->get('debug_level'), 'array', $this->get_debug_levels())
                ))
            )
        );
    }

    private function get_info_api_key() {
        $render = __("To get your API Key, log in to Dev4Press website, and visit your dashboard", "dev4press-updater");
        $render .= ': <a href="https://my.dev4press.com/api-key/" target="_blank">'.__("User Dashboard API Key", "dev4press-updater").'</a>. ';
        $render .= __("Make sure you keep your API Key safe, and don't share it with anyone else!", "dev4press-updater");

        return $render;
    }

    private function get_info_debug() {
        $render = __("If you have problems with the updater, it is useful to enable debug mode and plugin will save information about requests sent to Dev4Press and responses received.", "dev4press-updater");
        $render .= ' '.__("All data will be stored into text file 'dev4press.log' in your WordPress uploads folder.", "dev4press-updater");

        return $render;
    }

    public function get_auto_check_period() {
        return array(
            '__none__' => __("Disable", "dev4press-updater"),
            'twicedaily' => __("Twice Daily", "dev4press-updater"),
            'daily' => __("Daily", "dev4press-updater"),
            'd4p_twodays' => __("Every Two Days", "dev4press-updater"),
            'd4p_twiceweekly' => __("Twice Weekly", "dev4press-updater"),
            'd4p_weekly' => __("Weekly", "dev4press-updater")
        );
    }

    public function get_auto_check_versions() {
        return array(
            'stable' => __("Only stable releases", "dev4press-updater"),
            'normal' => __("Stable and beta releases", "dev4press-updater"),
            'alpha' => __("Stable, beta and alpha releases", "dev4press-updater"),
            'nightly' => __("Stable, beta, alpha and nightly releases", "dev4press-updater")
        );
    }

    public function get_debug_levels() {
        return array(
            'none' => __("No debug", "dev4press-updater"),
            'full' => __("All requests and responses", "dev4press-updater"),
            'requests' => __("Requests only", "dev4press-updater"),
            'responses' => __("Responses only", "dev4press-updater")
        );
    }
}
