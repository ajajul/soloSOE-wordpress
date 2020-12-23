<?php

if (!defined('ABSPATH')) {
    exit;
}

class d4pupd_admin_core {
    public $is_debug;

    public $page = false;
    public $panel = false;
    public $action = false;

    public $menu_items;
    public $page_ids = array();

    public function __construct() {
        add_action('d4pupd_plugin_core_ready', array($this, 'core'));
        add_action('admin_page_access_denied', array($this, 'denied'));
    }

    private function file($type, $name, $d4p = false) {
        $get = D4PUPD_URL;

        if ($d4p) {
            $get .= 'd4plib/resources/';
        }

        if ($name == 'font') {
            $get .= 'font/styles.css';
        } else {
            $get .= $type.'/'.$name;

            if (!$this->is_debug && $type != 'font') {
                $get .= '.min';
            }

            $get .= '.'.$type;
        }

        return $get;
    }

    public function core() {
        $this->is_debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;

        if (is_multisite()) {
            add_action('network_admin_menu', array($this, 'admin_menu'));
        } else {
            add_action('admin_menu', array($this, 'admin_menu'));
        }

        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

        if (d4pupd_settings()->is_install()) {
            add_action('network_admin_notices', array($this, 'install_notice'));
            add_action('admin_notices', array($this, 'install_notice'));
        }

        if (d4pupd_settings()->is_update()) {
            add_action('network_admin_notices', array($this, 'update_notice'));
            add_action('admin_notices', array($this, 'update_notice'));
        }
    }

    public function install_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            $url = network_admin_url('admin.php?page=dev4press-updater-about');

            echo '<div class="updated"><p>';
            echo __("Dev4Press Updater is activated and it needs to finish installation.", "dev4press-updater");
            echo ' <a href="'.$url.'">'.__("Click Here", "dev4press-updater").'</a>.';
            echo '</p></div>';
        }
    }

    public function update_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            $url = network_admin_url('admin.php?page=dev4press-updater-about');

            echo '<div class="updated"><p>';
            echo __("Dev4Press Updater is updated, and you need to review the update process.", "dev4press-updater");
            echo ' <a href="'.$url.'">'.__("Click Here", "dev4press-updater").'</a>.';
            echo '</p></div>';
        }
    }

    public function denied() {
        if (isset($_GET['page']) && $_GET['page'] == 'dev4press_installed') {
            wp_redirect(network_admin_url('admin.php?page=dev4press-updater-front'));
            exit;
        }
    }

    public function admin_init() {
        if (isset($_GET['panel']) && $_GET['panel'] != '') {
            $this->panel = d4p_sanitize_slug($_GET['panel']);
        }

        if (isset($_POST['option_page']) && $_POST['option_page'] == 'dev4press-updater-settings') {
            check_admin_referer('dev4press-updater-settings-options');

            require_once(D4PUPD_D4PLIB.'admin/d4p.functions.php');
            require_once(D4PUPD_D4PLIB.'admin/d4p.settings.php');
            include(D4PUPD_PATH.'core/internal.php');

            $options = new d4pupd_admin_settings();
            $settings = $options->settings($this->panel);

            $processor = new d4pSettingsProcess($settings);
            $processor->base = 'd4pupdvalue';

            $data = $processor->process();

            $old_api_key = d4pupd_settings()->get('dev4press_api_key');

            foreach ($data as $group => $values) {
                foreach ($values as $name => $value) {
                    d4pupd_settings()->set($name, $value, $group);
                }

                d4pupd_settings()->save($group);
            }

            $new_api_key = d4pupd_settings()->get('dev4press_api_key');

            if ($new_api_key != $old_api_key) {
                delete_site_transient('dev4press_updater_response');
                delete_site_transient('dev4press_updater_throttle');
            }

            wp_redirect('admin.php?page=dev4press-updater-settings&panel='.$this->panel.'&message=saved');
            exit;
        }
    }

    public function admin_menu() {
        $this->menu_items = array(
            'front' => array('title' => __("Dashboard", "dev4press-updater"), 'icon' => 'home'),
            'about' => array('title' => __("About", "dev4press-updater"), 'icon' => 'info-circle'),
            'products' => array('title' => __("Plugins", "dev4press-updater"), 'icon' => 'cloud-upload'),
            'install' => array('title' => __("Install", "dev4press-updater"), 'icon' => 'cloud-download'),
            'purchase' => array('title' => __("Purchase", "dev4press-updater"), 'icon' => 'shopping-cart'),
            'news' => array('title' => __("News", "dev4press-updater"), 'icon' => 'rss-square'),
            'settings' => array('title' => __("Settings", "dev4press-updater"), 'icon' => 'cogs')
        );

        $parent = 'dev4press-updater-front';

        $this->page_ids[] = add_menu_page(
            'Dev4Press Updater',
            'Dev4Press',
            'd4pupd_standard',
            $parent,
            array($this, 'panel_front'),
            d4pupd_plugin()->svg_icon);

        foreach ($this->menu_items as $item => $data) {
            $this->page_ids[] = add_submenu_page($parent,
                'Dev4Press Updater: '.$data['title'],
                $data['title'],
                'd4pupd_standard',
                'dev4press-updater-'.$item,
                array($this, 'panel_'.$item));
        }

        if (!d4pupd_settings()->update_one_year_expired()) {
            add_submenu_page($parent,
                'Dev4Press Updater: '.__("Check for updates", "dev4press-updater"),
                __("Check for updates", "dev4press-updater"),
                'd4pupd_standard',
                'dev4press-updater-front&check=run&_wpnonce='.wp_create_nonce('dev4press-updater'),
                array($this, 'panel_front'));
        }

        $this->admin_load_hooks();
    }

    public function admin_load_hooks() {
        foreach ($this->page_ids as $id) {
            add_action('load-'.$id, array($this, 'load_admin_page'));
        }
    }

    public function enqueue_scripts($hook) {
        if ($this->page !== false) {
            d4p_admin_enqueue_defaults();

            wp_enqueue_style('fontawesome', d4pupd_plugin()->fontawesome);

            wp_enqueue_style('d4plib-font', $this->file('css', 'font', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-admin', $this->file('css', 'admin', true), array('d4plib-shared'), D4P_VERSION);

            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION, true);
            wp_enqueue_script('d4plib-admin', $this->file('js', 'admin', true), array('d4plib-shared'), D4P_VERSION, true);

            wp_enqueue_style('d4pupd-plugin', $this->file('css', 'plugin'), array('d4plib-admin'), d4pupd_settings()->file_version());
            wp_enqueue_script('d4pupd-plugin', $this->file('js', 'plugin'), array('d4plib-admin'), d4pupd_settings()->file_version(), true);

            if ($this->page == 'about') {
                wp_enqueue_style('d4plib-grid', $this->file('css', 'grid', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            }

            $_data = array(
                'wp_version' => D4PUPD_WPV,
                'page' => $this->page,
                'panel' => $this->panel
            );

            wp_localize_script('d4pupd-plugin', 'd4pupd_data', $_data);

            wp_localize_script('d4plib-shared', 'd4plib_admin_data', array(
                'string_media_image_title' => __("Select Image", "dev4press-updater"),
                'string_media_image_button' => __("Use Selected Image", "dev4press-updater"),
                'string_are_you_sure' => __("Are you sure you want to do this?", "dev4press-updater"),
                'string_image_not_selected' => __("Image not selected.", "dev4press-updater")
            ));
        }
    }

    public function load_admin_page() {
        $screen = get_current_screen();
        $id = $screen->id;

        if (is_multisite()) {
            if ($id == 'toplevel_page_dev4press-updater-front-network') {
                $this->page = 'front';
            } else if (substr($id, 0, 33) == 'dev4press_page_dev4press-updater-') {
                $this->page = substr(substr($id, 0, strlen($id) - 8), 33);
            }
        } else {
            if ($id == 'toplevel_page_dev4press-updater-front') {
                $this->page = 'front';
            } else if (substr($id, 0, 33) == 'dev4press_page_dev4press-updater-') {
                $this->page = substr($id, 33);
            }
        }

        if ($this->page == 'front') {
            if (isset($_GET['check']) && $_GET['check'] == 'run') {
                if (wp_verify_nonce($_GET['_wpnonce'], 'dev4press-updater')) {
                    $url = self_admin_url('admin.php?page=dev4press-updater-front&message=');

                    if (d4pupd_updater()->is_throttled()) {
                        $url.= 'wait';
                    } else {
                        $url.= 'update';
                        d4pupd_plugin()->update_check();
                    }

                    wp_redirect($url);
                    exit;
                }
            }
        }
    }

    public function install_or_update() {
        $install = d4pupd_settings()->is_install();
        $update = d4pupd_settings()->is_update();

        if ($install) {
            include(D4PUPD_PATH.'forms/setup/install.php');
        } else if ($update) {
            include(D4PUPD_PATH.'forms/setup/update.php');
        }

        if (d4pupd_updater()->update === false) {
            d4pupd_updater()->run();
        }

        return $install || $update;
    }

    public function panel_front() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/front.php');
        }
    }

    public function panel_about() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/about.php');
        }
    }

    public function panel_products() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/products.php');
        }
    }

    public function panel_install() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/install.php');
        }
    }

    public function panel_purchase() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/purchase.php');
        }
    }

    public function panel_settings() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/settings.php');
        }
    }

    public function panel_news() {
        if (!$this->install_or_update()) {
            include(D4PUPD_PATH.'forms/news.php');
        }
    }
}

$_d4pupd_core_admin = new d4pupd_admin_core();

function d4pupd_admin() {
    global $_d4pupd_core_admin;
    return $_d4pupd_core_admin;
}
