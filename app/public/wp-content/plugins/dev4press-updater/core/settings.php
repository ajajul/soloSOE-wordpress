<?php

if (!defined('ABSPATH')) {
    exit;
}

class d4pupd_core_settings {
    public $info;
    public $current = array();
    public $settings = array(
        'core' => array(
            'activated' => 0
        ),
        'settings' => array(
            'dev4press_api_key' => '',
            'debug_level' => 'none',
            'check_interval' => 'twicedaily',
            'update_status' => 'stable'
        )
    );

    public function __construct() {
        $this->info = new d4pupd_core_info();

        add_action('d4pupd_plugin_core_ready', array($this, 'init'));
        add_filter('d4pupd_settings_get', array($this, 'override_get'), 10, 3);
    }

    public function __get($name) {
        $get = explode('_', $name, 2);

        return $this->get($get[1], $get[0]);
    }

    private function _name($name) {
        return 'dev4press_'.$this->info->code.'_'.$name;
    }

    private function _install() {
        $this->current = $this->_merge();

        $this->current['info'] = $this->info->to_array();
        $this->current['info']['install'] = true;
        $this->current['info']['update'] = false;

        $this->current['core']['activated'] = time();

        foreach ($this->current as $key => $data) {
            update_site_option($this->_name($key), $data);
        }
    }

    private function _update() {
        $old_build = $this->current['info']['build'];

        $this->current['info'] = $this->info->to_array();
        $this->current['info']['install'] = false;
        $this->current['info']['update'] = true;
        $this->current['info']['previous'] = $old_build;

        update_site_option($this->_name('info'), $this->current['info']);

        $settings = $this->_merge();

        if ($this->current['core']['activated'] == 0) {
            $this->current['core']['activated'] = time();

            update_site_option($this->_name('core'), $this->current['core']);
        }

        foreach ($settings as $key => $data) {
            $now = get_site_option($this->_name($key));

            if (!is_array($now)) {
                $now = $data;
            } else {
                $now = $this->_upgrade($now, $data);
            }

            $this->current[$key] = $now;

            update_site_option($this->_name($key), $now);
        }

        delete_site_transient('dev4press_updater_response');
        delete_site_transient('dev4press_updater_throttle');
    }

    private function _upgrade($old, $new) {
        foreach ($new as $key => $value) {
            if (!isset($old[$key])) {
                $old[$key] = $value;
            }
        }

        $unset = array();
        foreach ($old as $key => $value) {
            if (!isset($new[$key])) {
                $unset[] = $key;
            }
        }

        if (!empty($unset)) {
            foreach ($unset as $key) {
                unset($old[$key]);
            }
        }

        return $old;
    }

    private function _groups() {
        return array_keys($this->settings);
    }

    private function _merge() {
        $merged = array();

        foreach ($this->settings as $key => $data) {
            $merged[$key] = array();

            foreach ($data as $name => $value) {
                $merged[$key][$name] = $value;
            }
        }

        return $merged;
    }

    public function init() {
        $this->current['info'] = get_site_option($this->_name('info'));
        $this->current['core'] = get_site_option($this->_name('core'));

        $installed = is_array($this->current['info']) && isset($this->current['info']['build']);

        if (!$installed) {
            $this->_install();
        } else {
            $update = $this->current['info']['build'] != $this->info->build;

            if ($update) {
                $this->_update();
            } else {
                $groups = $this->_groups();

                foreach ($groups as $key) {
                    $this->current[$key] = get_site_option($this->_name($key));

                    if (!is_array($this->current[$key])) {
                        $data = $this->group($key);

                        if (!is_null($data)) {
                            $this->current[$key] = $data;

                            update_site_option($this->_name($key), $data);
                        }
                    }
                }
            }
        }

        do_action('d4pupd_plugin_settings_loaded');
    }

    public function group($group) {
        if (isset($this->settings[$group])) {
            return $this->settings[$group];
        } else {
            return null;
        }
    }

    public function exists($name, $group = 'settings') {
        if (isset($this->current[$group][$name])) {
            return true;
        } else if (isset($this->settings[$group][$name])) {
            return true;
        } else {
            return false;
        }
    }

    public function prefix_get($prefix, $group = 'settings') {
        $settings = array_keys($this->group($group));

        $results = array();

        foreach ($settings as $key) {
            if (substr($key, 0, strlen($prefix)) == $prefix) {
                $results[substr($key, strlen($prefix))] = $this->get($key, $group);
            }
        }

        return $results;
    }

    public function group_get($group) {
        return $this->current[$group];
    }

    public function get($name, $group = 'settings') {
        $exit = null;

        if (isset($this->current[$group][$name])) {
            $exit = $this->current[$group][$name];
        } else if (isset($this->settings[$group][$name])) {
            $exit = $this->settings[$group][$name];
        }

        return apply_filters('d4pupd_settings_get', $exit, $name, $group);
    }

    public function set($name, $value, $group = 'settings', $save = false) {
        $this->current[$group][$name] = $value;

        if ($save) {
            $this->save($group);
        }
    }

    public function save($group = 'settings') {
        update_site_option($this->_name($group), $this->current[$group]);
    }

    public function is_install() {
        return $this->get('install', 'info');
    }

    public function is_update() {
        return $this->get('update', 'info');
    }

    public function override_get($value, $name, $group) {
        return $value;
    }

    public function remove_plugin_settings() {
        foreach ($this->_groups() as $group) {
            delete_site_option($this->_name($group));
        }
    }

    public function remove_plugin_settings_by_name($name) {
        delete_site_option($this->_name($name));
    }

    public function import_from_object($import, $list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        foreach ($import as $key => $data) {
            if (in_array($key, $list)) {
                $this->current[$key] = (array)$data;

                $this->save($key);
            }
        }
    }

    public function serialized_export($list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        $data = new stdClass();
        $data->info = $this->current['info'];

        foreach ($list as $name) {
            $data->$name = $this->current[$name];
        }

        return serialize($data);
    }

    public function file_version() {
        return $this->info_version.'.'.$this->info_build;
    }

    public function update_six_months_expired() {
        $version_key = $this->info->key;

        return time() > $version_key + 6 * MONTH_IN_SECONDS;
    }

    public function update_one_year_expired() {
        $version_key = $this->info->key;

        return time() > $version_key + YEAR_IN_SECONDS;
    }
}
