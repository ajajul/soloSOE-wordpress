<?php

if (!defined('ABSPATH')) {
    exit;
}

class d4pupd_core_plugin {
    public $is_debug;
    public $wp_version;

    public $domain = '';

    public $svg_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxOS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9Ii0xNTYgMjQ3LjEgMjk4LjkgMjk4LjkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgLTE1NiAyNDcuMSAyOTguOSAyOTguOTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2Rpc3BsYXk6bm9uZTtjbGlwLXBhdGg6dXJsKCNTVkdJRF8yXyk7fQ0KCS5zdDF7ZGlzcGxheTppbmxpbmU7fQ0KCS5zdDJ7ZGlzcGxheTpub25lO2NsaXAtcGF0aDp1cmwoI1NWR0lEXzZfKTt9DQo8L3N0eWxlPg0KPGc+DQoJPGRlZnM+DQoJCTxwYXRoIGlkPSJTVkdJRF8xXyIgZD0iTTEwNC4xLDM5OC4zYzYuOC0yLjEsMTMuNy00LjYsMjAuNC03LjZjLTAuMi0zLjktMC42LTcuNy0xLjEtMTEuNWMtNy4zLTItMTQuNC0zLjUtMjEuNy00LjYNCgkJCWMtMS01LjUtMi43LTExLjItNC44LTE2LjRjNS43LTQuNSwxMS4xLTkuMywxNi4zLTE0LjRjLTEuNi0zLjUtMy4zLTctNS4yLTEwLjNjLTcuNCwwLjctMTQuOCwxLjktMjEuOSwzLjUNCgkJCWMtMC44LTEuMi0xLjYtMi40LTIuNS0zLjVsLTEwLjEsNDAuM2MxLjUsNS4yLDIuNiwxMC43LDMsMTYuNGgxNS41bC0xNS43LDYzLjZINTQuOGMtMC41LDAuNS0wLjksMS0xLjQsMS41bC02LjMsMjYuMkw0NCw0OTQuMw0KCQkJaC03Ny4ybDQuMS0xNi45Yy0xNC44LTQuMi0yOC0xMi41LTM4LjItMjMuNWgtMzQuNWMwLjMsMC41LDAuNSwwLjksMC44LDEuNGMtNC43LDUuNC05LjMsMTEuMi0xMy40LDE3LjJjMi4yLDMuMiw0LjUsNi4yLDcsOS4yDQoJCQljNy4yLTIuMSwxNC4yLTQuNiwyMC45LTcuNWMzLjgsNC4yLDguMiw4LDEyLjcsMTEuNGMtMi41LDYuOC00LjUsMTMuNy02LjMsMjAuOWMzLjIsMi4xLDYuNSw0LjIsOS44LDZjNi00LjYsMTEuNS05LjQsMTYuOC0xNC42DQoJCQljNS4xLDIuNCwxMC41LDQuNSwxNiw2YzAuMSw3LjIsMC43LDE0LjQsMS42LDIxLjdjMy44LDAuOSw3LjUsMS42LDExLjQsMi4xYzMuOS02LjMsNy40LTEzLDEwLjQtMTkuNmM1LjgsMC4zLDExLjMsMC4yLDE3LjEtMC4yDQoJCQljMi43LDYuNiw1LjksMTMuMiw5LjQsMTkuNmMzLjgtMC41LDcuNi0xLjMsMTEuMy0yLjJjMS4zLTcuNSwyLjItMTQuNywyLjYtMjIuMWM1LjQtMS42LDEwLjgtMy43LDE1LjktNi4zDQoJCQljNSw1LjIsMTAuMywxMC4yLDE1LjgsMTQuOWMzLjQtMS45LDYuNi0zLjksOS44LTYuMWMtMS40LTcuNC0zLjMtMTQuNS01LjYtMjEuNWM0LjUtMy41LDguNi03LjUsMTIuNS0xMS42DQoJCQljNi41LDMuMSwxMy4yLDUuOCwyMC4yLDguMmMyLjQtMyw0LjctNi4xLDYuOS05LjJjLTQtNi40LTguMy0xMi4zLTEzLTE4YzIuOS00LjgsNS41LTEwLjEsNy41LTE1LjNjNy4yLDAuNSwxNC40LDAuNiwyMS44LDAuNA0KCQkJYzEuMi0zLjcsMi4zLTcuNCwzLjEtMTEuMWMtNS45LTQuNS0xMi4zLTguNi0xOC42LTEyLjFDMTAzLjUsNDA5LjcsMTA0LDQwNC4xLDEwNC4xLDM5OC4zTDEwNC4xLDM5OC4zeiBNNzkuMywzMTcuMg0KCQkJYzIuMy00LjIsNC40LTguNSw2LjQtMTIuOWMtMi43LTIuNy01LjYtNS4zLTguNi03LjhjLTYuNywzLjQtMTMuMSw3LjEtMTkuMiwxMS4zYy00LjUtMy40LTkuNS02LjQtMTQuNi04LjkNCgkJCWMxLjItNy4yLDEuOS0xNC4zLDIuNC0yMS43Yy0zLjUtMS41LTcuMS0yLjktMTAuOC00LjFjLTUsNS41LTkuNiwxMS40LTEzLjgsMTcuNGMtNS41LTEuNC0xMS4xLTIuNS0xNi44LTMNCgkJCWMtMS41LTctMy4zLTE0LjEtNS42LTIxYy0zLjktMC4yLTcuNy0wLjEtMTEuNiwwYy0yLjcsNy00LjksMTQuMS02LjYsMjEuMmMtNS42LDAuNi0xMS4zLDEuNy0xNi43LDMuMw0KCQkJYy0zLjktNi4xLTguMi0xMS45LTEyLjgtMTcuNmMtMy42LDEuMy03LjIsMi42LTEwLjcsNC4yYzAsNy40LDAuNiwxNC45LDEuNSwyMi4xYy01LDIuOC05LjgsNS44LTE0LjQsOS4xDQoJCQljLTUuOC00LjItMTItOC4yLTE4LjMtMTEuN2MtMywyLjUtNS44LDUuMS04LjUsNy44YzIuOCw3LDUuOSwxMy43LDkuNCwyMC4xYy0zLjgsNC4yLTcuMiw4LjktMTAuMiwxMy43Yy03LTEuOS0xNC0zLjItMjEuNC00LjMNCgkJCWMtMS44LDMuNC0zLjYsNi44LTUuMSwxMC40YzUuMSw1LjUsMTAuNCwxMC42LDE2LDE1LjRjLTEuOSw1LjMtMy42LDEwLjktNC41LDE2LjVjLTcuMiwwLjgtMTQuMywyLTIxLjUsMy42DQoJCQljLTAuNSwzLjgtMC45LDcuNy0xLDExLjVjNS4yLDIuNiwxMC42LDQuOSwxNS45LDYuOWwwLjMtMS4xbDM0LjMtMTkuOWM4LjUtMzQuOSwzOS4xLTYxLjYsNzYuOC02My41YzkuNC0wLjUsMTguNiwwLjcsMjcuMSwzLjENCgkJCWwwLjItMC4xSDc5LjNMNzkuMywzMTcuMnoiLz4NCgk8L2RlZnM+DQoJPHVzZSB4bGluazpocmVmPSIjU1ZHSURfMV8iICBzdHlsZT0ib3ZlcmZsb3c6dmlzaWJsZTtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiNBMkEyQTI7Ii8+DQoJPGNsaXBQYXRoIGlkPSJTVkdJRF8yXyI+DQoJCTx1c2UgeGxpbms6aHJlZj0iI1NWR0lEXzFfIiAgc3R5bGU9Im92ZXJmbG93OnZpc2libGU7Ii8+DQoJPC9jbGlwUGF0aD4NCgk8ZyBjbGFzcz0ic3QwIj4NCgkJPGRlZnM+DQoJCQk8cmVjdCBpZD0iU1ZHSURfM18iIHg9Ii0xMzcuNyIgeT0iMjY2LjMiIHdpZHRoPSIyNjIuMiIgaGVpZ2h0PSIyNjEuNCIvPg0KCQk8L2RlZnM+DQoJCTx1c2UgeGxpbms6aHJlZj0iI1NWR0lEXzNfIiAgc3R5bGU9ImRpc3BsYXk6aW5saW5lO292ZXJmbG93OnZpc2libGU7ZmlsbDojQTJBMkEyOyIvPg0KCQk8Y2xpcFBhdGggaWQ9IlNWR0lEXzRfIiBjbGFzcz0ic3QxIj4NCgkJCTx1c2UgeGxpbms6aHJlZj0iI1NWR0lEXzNfIiAgc3R5bGU9Im92ZXJmbG93OnZpc2libGU7Ii8+DQoJCTwvY2xpcFBhdGg+DQoJCTxnIHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgMCAwKSIgc3R5bGU9ImRpc3BsYXk6aW5saW5lO2NsaXAtcGF0aDp1cmwoI1NWR0lEXzRfKTsiPg0KCQkJDQoJCQkJPGltYWdlIHN0eWxlPSJvdmVyZmxvdzp2aXNpYmxlOyIgd2lkdGg9IjIyOTIiIGhlaWdodD0iMjI4MiIgeGxpbms6aHJlZj0iNThGNDVGNjIuanBnIiAgdHJhbnNmb3JtPSJtYXRyaXgoMC4xMTQ3IDAgMCAtMC4xMTQ3IC0xMzcuODgxNiA1MjcuNzY4NCkiPg0KCQkJPC9pbWFnZT4NCgkJPC9nPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxkZWZzPg0KCQk8cGF0aCBpZD0iU1ZHSURfNV8iIGQ9Ik02My41LDQzNy4ySDQwLjhsLTAuOSwzLjVoLTAuMWMtMywxMi4zLTYsMjQuNi04LjksMzYuOUgtMTJsOS45LTQwLjRoLTExMmw3LjEtMjguOGwxMjguNS03NC42aDQ1DQoJCQlsLTE4LjIsNzMuMUg3MUw2My41LDQzNy4yTDYzLjUsNDM3LjJ6IE01LjQsNDA2LjlsMTIuNC00OS43bC04NC45LDQ5LjNMNS40LDQwNi45TDUuNCw0MDYuOXoiLz4NCgk8L2RlZnM+DQoJPHVzZSB4bGluazpocmVmPSIjU1ZHSURfNV8iICBzdHlsZT0ib3ZlcmZsb3c6dmlzaWJsZTtmaWxsOiNBMkEyQTI7Ii8+DQoJPGNsaXBQYXRoIGlkPSJTVkdJRF82XyI+DQoJCTx1c2UgeGxpbms6aHJlZj0iI1NWR0lEXzVfIiAgc3R5bGU9Im92ZXJmbG93OnZpc2libGU7Ii8+DQoJPC9jbGlwUGF0aD4NCgk8ZyBjbGFzcz0ic3QyIj4NCgkJPGRlZnM+DQoJCQk8cmVjdCBpZD0iU1ZHSURfN18iIHg9Ii0xMTQuMSIgeT0iMzMzLjgiIHdpZHRoPSIxODUuMSIgaGVpZ2h0PSIxNDMuOCIvPg0KCQk8L2RlZnM+DQoJCTx1c2UgeGxpbms6aHJlZj0iI1NWR0lEXzdfIiAgc3R5bGU9ImRpc3BsYXk6aW5saW5lO292ZXJmbG93OnZpc2libGU7ZmlsbDojQTJBMkEyOyIvPg0KCQk8Y2xpcFBhdGggaWQ9IlNWR0lEXzhfIiBjbGFzcz0ic3QxIj4NCgkJCTx1c2UgeGxpbms6aHJlZj0iI1NWR0lEXzdfIiAgc3R5bGU9Im92ZXJmbG93OnZpc2libGU7Ii8+DQoJCTwvY2xpcFBhdGg+DQoJCTxnIHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgMCAwKSIgc3R5bGU9ImRpc3BsYXk6aW5saW5lO2NsaXAtcGF0aDp1cmwoI1NWR0lEXzhfKTsiPg0KCQkJDQoJCQkJPGltYWdlIHN0eWxlPSJvdmVyZmxvdzp2aXNpYmxlOyIgd2lkdGg9IjE2MjAiIGhlaWdodD0iMTI1OCIgeGxpbms6aHJlZj0iNThGNDVGNjYucG5nIiAgdHJhbnNmb3JtPSJtYXRyaXgoMC4xMTQ3IDAgMCAtMC4xMTQ3IC0xMTQuMzgzOSA0NzcuODMzNCkiPg0KCQkJPC9pbWFnZT4NCgkJPC9nPg0KCQk8dXNlIHhsaW5rOmhyZWY9IiNTVkdJRF83XyIgIHN0eWxlPSJkaXNwbGF5OmlubGluZTtvdmVyZmxvdzp2aXNpYmxlO2ZpbGw6bm9uZTtzdHJva2U6IzIzMUYyMDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==';
    public $fontawesome = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

    public function __construct() {
        add_action('plugins_loaded', array($this, 'core'));
        add_action('after_setup_theme', array($this, 'init'));
    }

    public function core() {
        global $wp_version;

        $this->wp_version = substr(str_replace('.', '', $wp_version), 0, 2);

        define('D4PUPD_WPV', intval($this->wp_version));

        add_action('init', array($this, 'init_language'));
        add_action('init', array($this, 'init_capabilities'));

        add_action('dev4press_updater_v4_check', array($this, 'update_check'));

        if (is_main_site()) {
            add_filter('cron_schedules', array($this, 'cron_schedules'));
        }

        $this->domain = parse_url(get_bloginfo('url'), PHP_URL_HOST);

        do_action('d4pupd_plugin_core_ready');
    }

    public function update_check() {
        if (!d4pupd_settings()->update_one_year_expired()) {
            d4pupd_updater()->run();
        }
    }

    public function cron_schedules($schedules) {
        $schedules['d4p_weekly'] = array('interval' => 604800, 'display' => __("Once Weekly", "dev4press-updater"));
        $schedules['d4p_twiceweekly'] = array('interval' => 302400, 'display' => __("Twice Weekly", "dev4press-updater"));
        $schedules['d4p_twodays'] = array('interval' => 172800, 'display' => __("Every Two Days", "dev4press-updater"));

        return $schedules;
    }

    public function init() {
        $this->is_debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
    }

    public function init_capabilities() {
        $role = get_role('administrator');

        if ($role) {
            $role->add_cap('d4pupd_standard');
        }
    }

    public function init_language() {
        $language = get_locale();

        if (!empty($language)) {
            load_plugin_textdomain('dev4press-updater', false, 'dev4press-updater/languages');
            load_plugin_textdomain('d4plib', false, 'dev4press-updater/d4plib/languages');
        }
    }

    public function feed_url($url, $campaign = 'dev4press-updater') {
        $url = add_query_arg('utm_source', $this->domain, $url);
        $url = add_query_arg('utm_medium', 'web', $url);
        $url = add_query_arg('utm_campaign', $campaign, $url);

        return $url;
    }

    public function recommend($panel = 'update') {
        d4p_include('four', 'classes', D4PUPD_D4PLIB);

        $four = new d4p_core_four('plugin', 'dev4press-updater', d4pupd_settings()->info_version, d4pupd_settings()->info_build, 'free');
        $four->ad();

        return $four->ad_render($panel);
    }
}
