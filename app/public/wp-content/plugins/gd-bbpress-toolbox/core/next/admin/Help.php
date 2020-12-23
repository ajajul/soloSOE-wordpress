<?php

namespace Dev4Press\Plugin\GDBBX\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class Help {
    public function __construct() {
    }

    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Help();
        }

        return $instance;
    }

    public function plugin() {
        $this->help_tab_sidebar();
        $this->help_tab_getting_help();
    }

    public function help_tab_sidebar($plugin = 'gd-bbpress-toolbox', $title = 'GD bbPress Toolbox Pro') {
        $screen = get_current_screen();

        $screen->set_help_sidebar(
            '<p><strong>'.$title.'</strong></p>'.
            '<p><a target="_blank" href="https://plugins.dev4press.com/'.$plugin.'/">'.__("Home Page", "gd-bbpress-toolbox").'</a><br/>'.
            '<a target="_blank" href="https://support.dev4press.com/kb/product/'.$plugin.'/">'.__("Knowledge Base", "gd-bbpress-toolbox").'</a><br/>'.
            '<a target="_blank" href="https://support.dev4press.com/forums/forum/plugins/'.$plugin.'/">'.__("Support Forum", "gd-bbpress-toolbox").'</a></p>'
        );
    }

    public function help_tab_getting_help() {
        $screen = get_current_screen();

        if (gdbbx_admin()->page == 'features') {
            $this->help_for_features($screen);
        }

        $screen->add_help_tab(
            array(
                'id' => 'gdbbx-help-info',
                'title' => __("Help & Support", "gd-bbpress-toolbox"),
                'content' => '<h2>'.__("Help & Support", "gd-bbpress-toolbox").'</h2><p>'.__("To get help with this plugin, you can start with Knowledge Base list of frequently asked questions, user guides, articles (tutorials) and reference guide (for developers).", "gd-bbpress-toolbox").
                    '</p><p><a href="https://support.dev4press.com/kb/product/gd-bbpress-toolbox/" class="button-primary" target="_blank">'.__("Knowledge Base", "gd-bbpress-toolbox").'</a> <a href="https://support.dev4press.com/forums/forum/plugins/gd-bbpress-toolbox/" class="button-secondary" target="_blank">'.__("Support Forum", "gd-bbpress-toolbox").'</a></p>'
            )
        );

        $screen->add_help_tab(
            array(
                'id' => 'gdbbx-help-bugs',
                'title' => __("Found a bug?", "gd-bbpress-toolbox"),
                'content' => '<h2>'.__("Found a bug?", "gd-bbpress-toolbox").'</h2><p>'.__("If you find a bug in GD bbPress Toolbox Pro, you can report it in the support forum.", "gd-bbpress-toolbox").
                    '</p><p>'.__("Before reporting a bug, make sure you use latest plugin version, your website and server meet system requirements. And, please be as descriptive as possible, include server-side logged errors, or errors from browser debugger.", "gd-bbpress-toolbox").
                    '</p><p><a href="https://support.dev4press.com/forums/forum/plugins/gd-bbpress-toolbox/" class="button-primary" target="_blank">'.__("Open new topic", "gd-bbpress-toolbox").'</a></p>'
            )
        );

        $screen->add_help_tab(
            array(
                'id' => 'gdbbx-help-wizard',
                'title' => __("Setup Wizard", "gd-bbpress-toolbox"),
                'content' => '<h2>'.__("Setup Wizard", "gd-bbpress-toolbox").'</h2><p>'.__("If you need to quickly reconfigure the plugin, you can access the Setup Wizard again.", "gd-bbpress-toolbox").
                    '</p><p><a href="'.admin_url('admin.php?page=gd-bbpress-toolbox-wizard').'" class="button-primary" target="_blank">'.__("Open Setup Wizard", "gd-bbpress-toolbox").'</a></p>'
            )
        );
    }

    public function help_for_features($screen) {
        if (gdbbx_admin()->panel == 'custom-views') {
            $screen->add_help_tab(
                array(
                    'id' => 'gdbbx-help-features-custom-views',
                    'title' => __("Custom Topic Views", "gd-bbpress-toolbox"),
                    'content' => '<h2>'.__("Custom Topic Views", "gd-bbpress-toolbox").'</h2>
                         <p>'.__("If you plan to translate the plugin, and translate the titles for the views, it is important to leave original title in the custom topic views settings intact. If you change the default titles, WordPress translation system will not be able to match the translations to these titles.", "gd-bbpress-toolbox").'</p>'
                )
            );
        } else if (gdbbx_admin()->panel == 'schedule-topic') {
            $screen->add_help_tab(
                array(
                    'id' => 'gdbbx-help-features-schedule-topic',
                    'title' => __("Schedule Topic", "gd-bbpress-toolbox"),
                    'content' => '<h2>'.__("Schedule Topic", "gd-bbpress-toolbox").'</h2>
                         <p>'.__("Once scheduled, topics will not appear on the topics lists. Each user can see own scheduled topics through the 'My Scheduled Topics' view, and you can enable this view from the 'Custom Topic Views' feature panel.", "gd-bbpress-toolbox").'</p>
                         <p>'.__("It is recommended to enable this feature only for keymasters and moderators, and avoid giving it to participants to avoid issues with abuse of the publishing.", "gd-bbpress-toolbox").'</p>'
                )
            );
        }
    }
}
