<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_error {
    public $errors = array();

    function __construct() { }

    function add($code, $message, $data) {
        $this->errors[$code][] = array($message, $data);
    }
}

class gdbbx_core_plugin {
    private $_date_time;

    function __construct() {
        gdbbx_roles();

        add_action('plugins_loaded', array($this, 'core'));
        add_action('after_setup_theme', array($this, 'init'));

        add_action('gdbbx_cron_daily_maintenance_job', array($this, 'daily_maintenance_job'));
        add_action('gdbbx_clear_bulk_directory', array($this, 'clear_bulk_directory'));

        $this->_date_time = new d4p_datetime_core();
    }

    /** @return d4p_datetime_core */
    public function datetime() {
        return $this->_date_time;
    }

    public function clear_bulk_directory() {
        $dir = wp_upload_dir();

        if ($dir['error'] === false) {
            $file_path = trailingslashit($dir['basedir']).'gdbbx/';

            $proceed = true;
            if (!file_exists($file_path)) {
                $proceed = wp_mkdir_p($file_path);
            }

            if ($proceed) {
                $age = apply_filters('gdbbx_bulk_download_clanup_age', 1800);

                $files = d4p_scan_dir($file_path, 'files', array('bbx'));

                foreach ($files as $file) {
                    $parts = explode('-', $file);

                    if (count($parts) > 2) {
                        $time = absint($parts[1]);

                        if ($time + $age < time()) {
                            unlink($file_path.$file);
                        }
                    }
                }
            }
        }
    }

    public function user_meta_key_last_activity() {
        return gdbbx_db()->prefix().'bbp_last_activity';
    }

    public function get_user_last_activity($user_id) {
        $timestamp = get_user_meta($user_id, $this->user_meta_key_last_activity(), true);

        if ($timestamp == '') {
            $timestamp = get_user_meta($user_id, 'bbp_last_activity', true);
        }

        return intval($timestamp);
    }

    public function update_user_last_activity($user_id, $timestamp = 0) {
        update_user_meta($user_id, $this->user_meta_key_last_activity(), $timestamp);
    }

    public function core() {
        global $wp_version;

        $version = substr(str_replace('.', '', $wp_version), 0, 2);
        define('GDBBX_WPV', intval($version));

        if (gdbbx_has_bbpress()) {
            $this->init_lang();
            $this->init_cron();

            do_action('gdbbx_plugin_core_ready');
        }
    }

    public function init() {
        require_once(GDBBX_PATH.'core/functions/theme.php');
    }

    public function init_cron() {
        if (!wp_next_scheduled('gdbbx_cron_daily_maintenance_job')) {
            $cron_hour = apply_filters('gdbbx_cron_daily_maintenance_job_hour', 3);
            $cron_time = mktime($cron_hour, 0, 0, date('m'), date('d') + 1, date('Y'));

            wp_schedule_event($cron_time, 'daily', 'gdbbx_cron_daily_maintenance_job');
        }
    }

    public function init_lang() {
        load_plugin_textdomain('gd-bbpress-toolbox', false, 'gd-bbpress-toolbox/languages');
        load_plugin_textdomain('d4plib', false, 'gd-bbpress-toolbox/d4plib/languages');
    }

    public function daily_maintenance_job() {
        do_action('gdbbx_daily_maintenance_job');
    }

    public function get_transient_key($name) {
        $version = absint(str_replace('.', '', gdbbx()->info_version));

        return 'gdbbx_'.$version.'_'.$name;
    }

    public function recommend($panel = 'update') {
        d4p_includes(array(
            array('name' => 'ip', 'directory' => 'classes'), 
            array('name' => 'four', 'directory' => 'classes')
        ), GDBBX_D4PLIB);

        $four = new d4p_core_four('plugin', 'gd-bbpress-toolbox', gdbbx()->info_version, gdbbx()->info_build);
        $four->ad();

        return $four->ad_render($panel);
    }
}
