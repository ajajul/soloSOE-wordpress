<?php

if (!defined('ABSPATH')) {
    exit;
}

class d4pupd_core_updater {
    public $update = false;

    public $debug;
    public $apikey;
    public $status;

    public $statuses = array(
        'stable',
        'beta',
        'alpha',
        'nightly'
    );

    public $transcode = array(
        'gd-rating-system-builder' => 'code-builder-addon',
        'gd-rating-system-analytics' => 'analytics-addon',
        'gd-rating-system-mycred' => 'mycred-integration-addon',
        'gd-rating-system-mycred-simple' => 'mycred-simple-integration-addon',
        'gd-rating-system-rich-snippet-recipe' => 'recipe-rich-snippet-addon',
        'gd-rating-system-rich-snippet-book' => 'book-rich-snippet-addon',
        'gd-rating-system-multi' => 'multi-ratings-addon',
        'gd-rating-system-user-reviews' => 'user-reviews-addon',
        'gd-rating-system-comment-form' => 'comment-form-addon',
        'gd-rating-system-data-export' => 'data-export-addon',
        'gd-rating-system-emojione' => 'emojione-pack-addon',
        'gd-rating-system-halloween' => 'halloween-pack-addon',
        'gd-rating-system-christmas' => 'christmas-pack-addon',
        'gd-press-tools-storage-dropbox' => 'dropbox-storage-addon',
        'gd-press-tools-storage-s3' => 'amazon-s3-storage-addon',
        'gd-knowledge-base-integration-wc' => 'integration-addon-wc',
        'gd-knowledge-base-integration-edd' => 'integration-addon-edd',
        'gd-mail-queue-aws-ses' => 'aws-ses-addon',
        'gd-mail-queue-mailgun' => 'mailgun-addon',
        'gd-mail-queue-gmail' => 'gmail-addon',
        'gd-mail-queue-mailjet' => 'mailjet-addon',

        'code-builder-addon' => 'gd-rating-system-builder',
        'analytics-addon' => 'gd-rating-system-analytics',
        'mycred-integration-addon' => 'gd-rating-system-mycred',
        'mycred-simple-integration-addon' => 'gd-rating-system-mycred-simple',
        'recipe-rich-snippet-addon' => 'gd-rating-system-rich-snippet-recipe',
        'book-rich-snippet-addon' => 'gd-rating-system-rich-snippet-book',
        'multi-ratings-addon' => 'gd-rating-system-multi',
        'user-reviews-addon' => 'gd-rating-system-user-reviews',
        'comment-form-addon' => 'gd-rating-system-comment-form',
        'emojione-pack-addon' => 'gd-rating-system-emojione',
        'halloween-pack-addon' => 'gd-rating-system-halloween',
        'christmas-pack-addon' => 'gd-rating-system-christmas',
        'dropbox-storage-addon' => 'gd-press-tools-storage-dropbox',
        'amazon-s3-storage-addon' => 'gd-press-tools-storage-s3',
        'integration-addon-wc' => 'gd-knowledge-base-integration-wc',
        'integration-addon-edd' => 'gd-knowledge-base-integration-edd',
        'aws-ses-addon' => 'gd-mail-queue-aws-ses',
        'mailgun-addon' => 'gd-mail-queue-mailgun',
        'gmail-addon' => 'gd-mail-queue-gmail',
        'mailjet-addon' => 'gd-mail-queue-mailjet'
    );

    public $plugins = array(
        'dev4press-updater/dev4press-updater.php',

        'gd-security-toolbox/gd-security-toolbox.php',
        'gd-power-search-for-bbpress/gd-power-search-for-bbpress.php',
        'gd-quantum-theme-for-bbpress/gd-quantum-theme-for-bbpress.php',
        'gd-members-directory-for-bbpress/gd-members-directory-for-bbpress.php',
        'gd-forum-notices-for-bbpress/gd-forum-notices-for-bbpress.php',
        'gd-rating-system/gd-rating-system.php',
        'gd-seo-toolbox/gd-seo-toolbox.php',
        'gd-bbpress-toolbox/gd-bbpress-toolbox.php',
        'gd-swift-navigator/gd-swift-navigator.php',
        'gd-crumbs-navigator/gd-crumbs-navigator.php',
        'gd-knowledge-base/gd-knowledge-base.php',
        'gd-clever-widgets/gd-clever-widgets.php',
        'gd-webfonts-toolbox/gd-webfonts-toolbox.php',
        'gd-press-tools/gd-press-tools.php',
        'gd-content-tools/gd-content-tools.php',
        'gd-topic-prefix/gd-topic-prefix.php',
        'gd-topic-polls/gd-topic-polls.php',
        'gd-mail-queue/gd-mail-queue.php',

        'gd-rating-system-emojione/gd-rating-system-emojione.php',
        'gd-rating-system-halloween/gd-rating-system-halloween.php',
        'gd-rating-system-christmas/gd-rating-system-christmas.php',
        'gd-rating-system-valentine/gd-rating-system-valentine.php',
        'gd-rating-system-builder/gd-rating-system-builder.php',
        'gd-rating-system-mycred/gd-rating-system-mycred.php',
        'gd-rating-system-mycred-simple/gd-rating-system-mycred-simple.php',
        'gd-rating-system-rich-snippet-recipe/gd-rating-system-rich-snippet-recipe.php',
        'gd-rating-system-rich-snippet-book/gd-rating-system-rich-snippet-book.php',
        'gd-rating-system-multi/gd-rating-system-multi.php',
        'gd-rating-system-user-reviews/gd-rating-system-user-reviews.php',
        'gd-rating-system-comment-form/gd-rating-system-comment-form.php',
        'gd-rating-system-analytics/gd-rating-system-analytics.php',

        'gd-press-tools-storage-dropbox/gd-press-tools-storage-dropbox.php',
        'gd-press-tools-storage-s3/gd-press-tools-storage-s3.php',

        'gd-mail-queue-aws-ses/gd-mail-queue-aws-ses.php',
        'gd-mail-queue-mailgun/gd-mail-queue-mailgun.php',
        'gd-mail-queue-gmail/gd-mail-queue-gmail.php',
        'gd-mail-queue-mailjet/gd-mail-queue-mailjet.php',

        'gd-knowledge-base-integration-wc/gd-knowledge-base-integration-wc.php',
        'gd-knowledge-base-integration-edd/gd-knowledge-base-integration-edd.php'
    );

    public $check = 'https://www.dev4press.com/service/updater/query/';

    public $download = 'https://www.dev4press.com/download/%category%/%apikey%/%id%/%build%/';
    public $cdn = 'https://dev4press.s3.amazonaws.com/';

    public $feeds = array(
        'promotions' => 'https://www.dev4press.com/service/feeds/promotions/',
        'releases' => 'https://www.dev4press.com/service/feeds/releases/',
        'blog' => 'https://www.dev4press.com/service/feeds/blog/',
    );

    public function __construct() {
        add_action('d4pupd_plugin_core_ready', array($this, 'ready'));
    }

    public function ready() {
        $this->apikey = d4pupd_settings()->get('dev4press_api_key');
        $this->status = d4pupd_settings()->get('update_status');
        $this->debug = d4pupd_settings()->get('debug_level');

        $this->update = get_site_transient('dev4press_updater_response');

        if ($this->apikey != '') {
            if (is_main_site()) {
                if (!wp_next_scheduled('dev4press_updater_v4_check') && d4pupd_settings()->get('check_interval') != '__none__') {
                    wp_schedule_event($this->cron_time_day(), $this->cron_check_interval(), 'dev4press_updater_v4_check');
                }
            } else {
                if (wp_next_scheduled('dev4press_updater_v4_check') !== false) {
                    d4pupd_remove_cron('dev4press_updater_v4_check');
                }
            }

            if ($this->update !== false) {
                add_filter('site_transient_update_plugins', array($this, 'add_updates_plugins'));

                add_filter('plugins_api', array($this, 'add_plugin_info'), 20, 3);
            }

            add_filter('upgrader_post_install', array($this, 'clear_update_information'), 10, 3);
            add_filter('http_request_args', array($this, 'request_headers'), 1000, 2);

            add_filter('install_plugin_complete_actions', array($this, 'install_plugin_complete_actions'), 10, 3);

            foreach ($this->plugins as $file) {
                add_action('in_plugin_update_message-'.$file, array($this, 'update_message'), 10, 2);
            }
        }
    }

    public function update_message($plugin_data, $response) {
        if (isset($response->dev4press) && $response->dev4press && $response->dev4press_status != 'stable') {
            echo '</p></div><div class="notice inline notice-error notice-alt"><p>';
            echo sprintf(__("The new update is a %s version, for testing purposes only. Do not use it on live websites!", "dev4press-updater"), '<strong>'.$response->dev4press_status.'</strong>');
        }
    }

    public function install_plugin_complete_actions($actions, $api, $plugin_file) {
        if (in_array($plugin_file, $this->plugins)) {
            $actions['plugins_page'] = '<a href="'.self_admin_url('admin.php?page=dev4press-updater-install').'" target="_parent">'.__("Return to Dev4Press Installer", "dev4press-updater").'</a>';
        }

        return $actions;
    }

    public function request_headers($r, $url) {
        if (strpos($url, 'www.dev4press.com/download') !== false) {
            $r['headers']['X-Dev4press-Updater-Domain'] = d4pupd_plugin()->domain;
        }

        return $r;
    }

    public function clear_update_information($res, $hook_extra, $result) {
        if (isset($hook_extra['plugin'])) {
            $plugin = $hook_extra['plugin'];

            if (is_string($plugin) && in_array($plugin, $this->plugins)) {
                $this->_update('plugins', $plugin);
            }
        }

        return $res;
    }

    public function get_plugin_update_data($file) {
        $release = false;

        if (isset($this->update['plugins'][$file])) {
            $updates = $this->update['plugins'][$file];

            foreach ($this->statuses as $status) {
                if (isset($updates[$status])) {
                    $release = $updates[$status];
                    break;
                }
            }
        }

        return $release;
    }

    public function add_updates_plugins($updates) {
        if (isset($this->update['core']['status']) && $this->update['core']['status'] == 'ok') {
            foreach ($this->update['plugins'] as $plugin => $data) {
                $release = false;

                foreach ($this->statuses as $status) {
                    if (isset($data[$status])) {
                        $release = $data[$status];
                        break;
                    }
                }

                if ($release !== false) {
                    $update = new StdClass();

                    $icon = $this->cdn.'icons/'.$release->category.'s/'.$release->group.'.png';
                    $banner = $this->cdn.'banners/'.$release->category.'s/'.$release->group.'.jpg';

                    $update->id = $release->id;
                    $update->slug = $release->group;
                    $update->plugin = $plugin;
                    $update->new_version = $release->version;
                    $update->url = 'https://'.$release->category.'s.dev4press.com/'.$release->group.'/';
                    $update->package = $this->download_product_url($release);
                    $update->icons = array(
                        '1x' => $icon,
                        '2x' => $icon,
                        'default' => $icon
                    );
                    $update->banners = array(
                        '1x' => $banner,
                        '2x' => $banner,
                        'low' => $banner,
                        'high' => $banner,
                        'default' => $banner
                    );
                    $update->upgrade_notice = $release->info;
                    $update->dev4press = true;
                    $update->dev4press_status = $release->status;
                    $update->requires_php = '5.6';

                    if (isset($release->php)) {
                        $update->requires_php = $release->php;
                    }

                    if (isset($release->wordpress_tested)) {
                        $update->tested = $release->wordpress_tested;
                    }

                    if ($release->status != 'stable') {
                        $update->new_version .= ' '.strtoupper($release->status);
                    }

                    if ($this->debug == 'full') {
                        dev4upd_debug_log('PLUGIN_UPDATE_PACKAGE', $update);
                    }

                    $updates->response[$plugin] = $update;
                }
            }
        }

        return $updates;
    }

    public function add_plugin_info($result, $action = null, $args = null) {
        if ($action == 'plugin_information' && isset($args->slug) && $args->slug != '') {
            if (
                isset($this->update['purchase']) &&
                isset($this->update['purchase']['plugins']) &&
                isset($this->update['purchase']['addons']) &&
                is_array($this->update['purchase']['plugins']) &&
                is_array($this->update['purchase']['addons'])) {

                $the_list = array_merge(
                    $this->update['purchase']['plugins'],
                    $this->update['purchase']['addons']);

                foreach ($the_list as $code => $data) {
                    if ($args->slug == $code) {
                        $result = new stdClass();

                        $update = $this->get_plugin_update_data($code.'/'.$code.'.php');

                        if ($update === false) {
                            $update = $data->latest;
                        }

                        $banner = $this->cdn.'banners/'.$data->category.'s/'.$data->code.'.jpg';

                        $result->name = $data->name;
                        $result->slug = $code;
                        $result->version = $update->version;
                        $result->homepage = $data->url;
                        $result->last_updated = $update->release_date;
                        $result->download_link = $this->download_product_url($update);
                        $result->requires = $update->wordpress;
                        $result->requires_php = '5.6';
                        $result->author = 'Milan Petrovic, Dev4Press';
                        $result->author_homepage = 'https://www.dev4press.com/';
                        $result->sections = array(
                            'description' => $data->description,
                            'changelog' => '<strong>'.__("Version", "dev4press-updater").': '.$update->version.($update->status != 'stable' ? ' '.strtoupper($update->status) : '').'</strong><p>'.$update->info.'</p>',
                        );

                        if ($update->status != 'stable') {
                            $result->version .= ' '.strtoupper($update->status);
                            $result->sections['changelog'] .= '<strong>'.__("Important", "dev4press-updater").':</strong><p>'.sprintf(__("The new update is a %s version, for testing purposes only. Do not use it on live websites!", "dev4press-updater"), '<strong>'.$update->status.'</strong>').'</p>';
                        }

                        $result->sections['changelog'] .= '<strong>'.__("Full Changelog", "dev4press-updater").':</strong><p><a target="_blank" href="'.$data->url.'changelog/">'.__("Changelog page", "dev4press-updater").'</a></p>';

                        $result->banners = array(
                            'low' => $banner,
                            'high' => $banner
                        );

                        if (isset($update->php)) {
                            $result->requires_php = $update->php;
                        }

                        if (isset($update->wordpress_tested)) {
                            $result->tested = $update->wordpress_tested;
                        }

                        if ($this->debug == 'full') {
                            dev4upd_debug_log('PLUGIN_INSTALL_PACKAGE', $result);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function cron_time_day() {
        return mktime(0, 5, 2, date('m'), date('d') + 1, date('Y'));
    }

    public function cron_check_interval() {
        return d4pupd_settings()->get('check_interval') != '' ? d4pupd_settings()->get('check_interval') : 'twicedaily';
    }

    public function download_product_url($release, $type = 'plugin') {
        $url = $this->download;

        $url = str_replace('%category%', $type, $url);
        $url = str_replace('%apikey%', $this->apikey, $url);
        $url = str_replace('%id%', $release->id, $url);
        $url = str_replace('%build%', d4pupd_settings()->info_build, $url);

        return $url;
    }

    public function is_throttled() {
        $throttle = get_site_transient('dev4press_updater_throttle');

        return $throttle === 'wait';
    }

    public function run() {
        if ($this->apikey != '') {
            $throttle = get_site_transient('dev4press_updater_throttle');

            if ($throttle == false) {
                $plugins = $this->get_plugins();

                $this->update = $this->_request($plugins);

                set_site_transient('dev4press_updater_response', $this->update, 604800);
                set_site_transient('dev4press_updater_throttle', 'wait', 300);
            }
        }

        return $this->update;
    }

    public function get_plugins() {
        require_once(ABSPATH.'wp-admin/includes/plugin.php');
        $all_plugins = get_plugins();

        $_plugins = array();

        foreach ($this->plugins as $plugin) {
            if (isset($all_plugins[$plugin])) {
                $pp = explode('/', $plugin);

                $_plugins[$plugin] = array(
                    'plugin' => $plugin,
                    'product_id' => $pp[0],
                    'edition' => $pp[0] == 'dev4press-updater' ? 'free' : 'pro',
                    'name' => $all_plugins[$plugin]['Name'],
                    'version' => $all_plugins[$plugin]['Version'],
                    'build' => 0
                );

                $_plugins[$plugin]['build'] = 0;

                $build_path = WP_PLUGIN_DIR.'/'.$pp[0].'/code/build.php';

                if (!file_exists($build_path)) {
                    $build_path = WP_PLUGIN_DIR.'/'.$pp[0].'/core/build.php';
                }

                if (file_exists($build_path)) {
                    include($build_path);

                    $_plugins[$plugin]['build'] = $build;
                }
            }
        }

        return $_plugins;
    }

    public function has_updates() {
        $list = array(
            'plugins' => array(),
            'themes' => array()
        );

        if (isset($this->update['plugins']) && is_array($this->update['plugins'])) {
            foreach ($this->update['plugins'] as $plugin => $data) {
                reset($data);
                $status = key($data);

                if (in_array($status, $this->statuses)) {
                    $list['plugins'][] = array(
                        'name' => $data[$status]->name,
                        'version' => $data[$status]->version,
                        'status' => $status,
                        'released' => $data[$status]->release_date
                    );
                }
            }
        }

        return $list;
    }

    public function has_licenses($code) {
        $list = array();

        if (isset($this->update['licenses']['active']) && is_array($this->update['licenses']['active'])) {
            foreach ($this->update['licenses']['active'] as $lic) {
                if ($lic['code'] == $code) {
                    $list[] = $lic;
                }
            }
        }

        return empty($list) ? false : $list;
    }

    public function core() {
        return isset($this->update['core']) ? $this->update['core'] : false;
    }

    public function generic_error() {
        if (isset($this->update['core']['message'])) {
            return $this->update['core']['message'];
        } else {
            return __("There was an error with update check.", "dev4press-updater");
        }
    }

    private function _update($type, $name) {
        $this->update[$type][$name] = array(
            'not_found' => __("You are using latest version.", "dev4press-updater")
        );

        set_site_transient('dev4press_updater_response', $this->update, 604800);

        $timestamp = d4p_next_scheduled('dev4press_updater_v4_check');
        if ($timestamp === false || $timestamp > time() + 300) {
            wp_schedule_single_event(time() + 300, 'dev4press_updater_v4_check');
        }
    }

    private function _meta() {
        return array(
            d4pupd_settings()->info_build,
            $this->apikey,
            D4PUPD_WPV,
            is_multisite() ? 'Y' : 'N',
            d4pupd_prepare_host(),
            $_SERVER['SERVER_NAME']
        );
    }

    private function _post($url, $data) {
        global $wp_version;

        $options = array(
            'timeout' => 30,
            'body' => serialize($data),
            'method' => 'POST',
            'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url')
        );

        return wp_remote_post($url, $options);
    }

    private function _request($plugins) {
        $request = array(
            'updater' => d4pupd_settings()->info_build,
            'api_key' => $this->apikey,
            'home_url' => get_bloginfo('url'),
            'domain' => d4pupd_plugin()->domain,
            'wordpress' => D4PUPD_WPV,
            'php' => function_exists('phpversion') ? phpversion() : 'NA',
            'mysql' => d4pupd_mysql_version(),
            'multisite' => is_multisite() ? 'yes' : 'no',
            'status' => $this->status,
            'meta' => d4pupd_prepare_meta(serialize($this->_meta()), d4pupd_settings()->info_build),
            'plugins' => $plugins,
            'themes' => array()
        );

        if ($this->debug == 'full' || $this->debug == 'requests') {
            dev4upd_debug_log('REMOTE_POST_REQUEST_DATA', $request);
        }

        $raw = $this->_post($this->check, $request);

        if ($this->debug == 'full' || $this->debug == 'responses') {
            dev4upd_debug_log('REMOTE_POST_RESPONSE_RAW', $raw);
        }

        if (is_wp_error($raw)) {
            $response = array(
                'core' => array(
                    'status' => 'error',
                    'code' => 'request_failed',
                    'message' => $raw->get_error_message()
                )
            );
        } else {
            $body = $raw['body'];
            $isok = false;

            if (is_serialized($body)) {
                $response = unserialize($body);

                if (is_array($response)) {
                    if (isset($response['core']['status'])) {
                        $isok = true;

                        if ($this->debug == 'full' || $this->debug == 'responses') {
                            dev4upd_debug_log('REMOTE_POST_RESPONSE_DATA', $response);
                        }
                    }
                }
            }

            if (!$isok) {
                $response = array(
                    'core' => array(
                        'status' => 'error',
                        'code' => 'invalid_response',
                        'message' => __("Invalid response received.", "dev4press-updater")
                    )
                );
            }
        }

        $response['core']['time'] = time();

        return $response;
    }
}
