<?php

namespace Dev4Press\Plugin\GDBBX\Basic;

use Dev4Press\Plugin\GDBBX\Features\Icons;

if (!defined('ABSPATH')) {
    exit;
}

class Enqueue {
    private $rtl;
    private $settings_loaded = false;
    private $flatpickr = array(
        'load' => 'd4plib3-flatpickr',
        'code' => ''
    );

    public function __construct() {
        $this->register_styles();
        $this->register_scripts();

        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_files'), 1);
    }

    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Enqueue();
        }

        return $instance;
    }

    public function init() {
        $this->rtl = is_rtl();
    }

    public function locale() {
        return apply_filters('plugin_locale', get_user_locale());
    }

    public function enqueue_files() {
        if (is_admin()) {
            return;
        }

        if (apply_filters('gdbbx_enqueue_files', gdbbx()->get('load_always') || gdbbx_is_bbpress())) {
            $this->core();
        }

        $this->widgets();
    }

    public function widgets() {
        wp_enqueue_style($this->rtl_handle('gdbbx-front-widgets'));
    }

    public function tinymce() {
        wp_enqueue_style($this->rtl_handle('gdbbx-front-tinymce'));
    }

    public function fitvids() {
        if (gdbbx()->get('load_fitvids')) {
            wp_enqueue_script('d4plib-fitvids');
        }
    }

    public function toolbar() {
        $this->font();

        wp_enqueue_style($this->rtl_handle('gdbbx-front-toolbar'));
        wp_enqueue_script('gdbbx-front-toolbar');
    }

    public function icons() {
        if (Icons::instance()->settings['mode'] == 'images') {
            wp_enqueue_style('gdbbx-image-icons');
        }
    }

    public function font() {
        wp_enqueue_style('gdbbx-font-icons');
    }

    public function schedule() {
        $this->core();

        wp_enqueue_style('d4plib3-flatpickr');
        wp_enqueue_script($this->flatpickr['load']);
    }

    public function attachments() {
        $this->core();

        wp_enqueue_style($this->rtl_handle('gdbbx-front-attachments'));
        wp_enqueue_script('gdbbx-front-attachments');
    }

    public function core() {
        $this->font();
        $this->icons();
        $this->fitvids();

        wp_enqueue_style($this->rtl_handle('gdbbx-front-features'));
        wp_enqueue_script('gdbbx-front-features');

        $this->register_settings();
    }

    public function is_rtl() {
        return $this->rtl;
    }

    public function rtl_handle($name) {
        if ($this->is_rtl()) {
            $name .= '-rtl';
        }

        return $name;
    }

    public function file($type, $name, $path) {
        $get = GDBBX_URL.'templates/default/'.$path.'/'.$name;

        if (!gdbbx_loader()->debug) {
            $get .= '.min';
        }

        $get .= '.'.$type;

        return $get;
    }

    public function register_styles() {
        wp_register_style('gdbbx-font-icons', $this->file('css', 'font', 'css'), array(), gdbbx()->file_version());
        wp_register_style('gdbbx-image-icons', $this->file('css', 'icons', 'css'), array(), gdbbx()->file_version());

        wp_register_style('gdbbx-front-widgets', $this->file('css', 'widgets', 'css'), array(), gdbbx()->file_version());
        wp_register_style('gdbbx-front-widgets-rtl', $this->file('css', 'widgets-rtl', 'css'), array('gdbbx-front-widgets'), gdbbx()->file_version());
        wp_register_style('gdbbx-front-toolbar', $this->file('css', 'toolbar', 'css'), array('gdbbx-font-icons'), gdbbx()->file_version());
        wp_register_style('gdbbx-front-toolbar-rtl', $this->file('css', 'toolbar-rtl', 'css'), array('gdbbx-front-toolbar'), gdbbx()->file_version());
        wp_register_style('gdbbx-front-tinymce', $this->file('css', 'tinymce', 'css'), array(), gdbbx()->file_version());
        wp_register_style('gdbbx-front-tinymce-rtl', $this->file('css', 'tinymce-rtl', 'css'), array('gdbbx-front-tinymce'), gdbbx()->file_version());
        wp_register_style('gdbbx-front-features', $this->file('css', 'features', 'css'), array('gdbbx-font-icons'), gdbbx()->file_version());
        wp_register_style('gdbbx-front-features-rtl', $this->file('css', 'features-rtl', 'css'), array('gdbbx-front-features'), gdbbx()->file_version());
        wp_register_style('gdbbx-front-attachments', $this->file('css', 'attachments', 'css'), array(), gdbbx()->file_version());
        wp_register_style('gdbbx-front-attachments-rtl', $this->file('css', 'attachments-rtl', 'css'), array('gdbbx-front-attachments'), gdbbx()->file_version());

        wp_register_style('d4plib3-flatpickr', GDBBX_URL.'d4pjs/flatpickr/flatpickr.min.css', array(), '4.6.3');
    }

    public function register_scripts() {
        wp_register_script('d4plib-textrange', GDBBX_URL.'d4plib/resources/libraries/jquery.textrange.min.js', array('jquery'), gdbbx()->file_version(), true);
        wp_register_script('d4plib-jqeasycharcounter', GDBBX_URL.'d4plib/resources/libraries/jquery.jqeasycharcounter.min.js', array('jquery'), gdbbx()->file_version(), true);
        wp_register_script('d4plib-fitvids', GDBBX_URL.'d4pjs/fitvids/jquery.fitvids'.(gdbbx_loader()->debug ? '' : '.min').'.js', array('jquery'), gdbbx()->file_version(), true);

        wp_register_script('gdbbx-front-features', $this->file('js', 'features', 'js'), array('jquery'), gdbbx()->file_version(), true);
        wp_register_script('gdbbx-front-toolbar', $this->file('js', 'toolbar', 'js'), array('jquery', 'd4plib-textrange', 'd4plib-jqeasycharcounter', 'gdbbx-front-features'), gdbbx()->file_version(), true);
        wp_register_script('gdbbx-front-attachments', $this->file('js', 'attachments', 'js'), array('jquery', 'gdbbx-front-features'), gdbbx()->file_version(), true);

        wp_register_script('d4plib3-flatpickr', GDBBX_URL.'d4pjs/flatpickr/flatpickr.min.js', array('jquery'), '4.6.3', true);

        $locale = $this->locale();

        if (!empty($locale)) {
            $code = strtolower(substr($locale, 0, 2));

            if (in_array($code, array('de', 'es', 'fr', 'it', 'nl', 'pl', 'pt', 'ru', 'sr'))) {
                wp_register_script('d4plib3-flatpickr-'.$code, GDBBX_URL.'d4pjs/flatpickr/l10n/'.$code.'.js', array('d4plib3-flatpickr'), '4.6.3', true);

                $this->flatpickr['code'] = $code;
                $this->flatpickr['load'] = 'd4plib3-flatpickr-'.$code;
            }
        }
    }

    private function register_settings() {
        if ($this->settings_loaded) {
            return;
        }

        $values = apply_filters('gdbbx_script_values', array(
            'url' => admin_url('admin-ajax.php'),
            'now' => time(),
            'wp_editor' => bbp_use_wp_editor(),
            'last_cookie' => gdbbx()->session_cookie_expiration(),
            'flatpickr_locale' => $this->flatpickr['code'],
            'load' => array(),
            'text' => array(
                'are_you_sure' => __("Are you sure? Operation is not reversible.", "gd-bbpress-toolbox")
            )
        ));

        wp_localize_script('gdbbx-front-features', 'gdbbx_data', $values);

        $this->settings_loaded = true;
    }
}
