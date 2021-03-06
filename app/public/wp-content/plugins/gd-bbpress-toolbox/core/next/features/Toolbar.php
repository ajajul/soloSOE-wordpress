<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;
use Dev4Press\Plugin\GDBBX\Basic\Features;

if (!defined('ABSPATH')) {
    exit;
}

class Toolbar extends Feature {
    public $feature_name = 'toolbar';
    public $settings = array(
        'super_admin' => true,
        'visitor' => true,
        'roles' => null,
        'title' => 'Forums',
        'information' => true
    );

    public $title = '';

    public function __construct() {
        parent::__construct();

        if ($this->allowed()) {
            $this->title = $this->settings['title'] ? _x("Forums", "Toolbar menu default title", "gd-bbpress-toolbox") : __($this->settings['title'], "gd-bbpress-toolbox");

            add_action('gdbbx_init', array($this, 'init'));
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\Toolbar */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Toolbar();
        }

        return $instance;
    }

    public function init() {
        add_action('admin_bar_menu', array($this, 'admin_bar_menu'), 100);

        add_action('admin_head', array($this, 'admin_bar_icon'));
        add_action('wp_head', array($this, 'admin_bar_icon'));
    }

    public function admin_bar_icon() { ?>
        <style type="text/css">
            #wpadminbar #wp-admin-bar-gdbb-toolbar .ab-icon:before {
                content: "\f477";
                top: 2px;
            }

            @media screen and ( max-width: 782px ) {
                #wpadminbar li#wp-admin-bar-gdbb-toolbar {
                    display: block;
                }
            }
        </style>
    <?php }

    public function admin_bar_menu() {
        global $wp_admin_bar;

        $title = $this->title;

        $icon = '<span class="ab-icon"></span>';
        $title = $icon.'<span class="ab-label">'.$this->title.'</span>';

        $wp_admin_bar->add_menu(array(
            'id' => 'gdbb-toolbar',
            'title' => $title,
            'href' => get_post_type_archive_link(bbp_get_forum_post_type()),
            'meta' => array('class' => 'icon-gdbb-toolbar')
        ));

        $wp_admin_bar->add_group(array(
            'parent' => 'gdbb-toolbar',
            'id' => 'gdbb-toolbar-public'
        ));

        $query = array(
            'post_parent' => 0,
            'post_status' => 'publish',
            'posts_per_page' => 20,
            'orderby' => 'menu_order',
            'order' => 'ASC');

        $forums = bbp_get_forums_for_current_user($query);

        if (is_array($forums) && count($forums) > 0) {
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-public',
                'id' => 'gdbb-toolbar-forums',
                'title' => __("Forums", "gd-bbpress-toolbox"),
                'href' => bbp_get_forums_url()
            ));

            foreach ($forums as $forum) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-forums',
                    'id' => 'gdbb-toolbar-forums-'.$forum->ID,
                    'title' => apply_filters('the_title', $forum->post_title, $forum->ID),
                    'href' => get_permalink($forum->ID)
                ));
            }
        }

        $views = bbp_get_views();
        if (is_array($views) && count($views) > 0) {
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-public',
                'id' => 'gdbb-toolbar-views',
                'title' => __("Views", "gd-bbpress-toolbox")
            ));

            foreach ($views as $view => $args) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-views',
                    'id' => 'gdbb-toolbar-views-'.$view,
                    'title' => bbp_get_view_title($view),
                    'href' => bbp_get_view_url($view)
                ));
            }
        }

        if (current_user_can(GDBBX_CAP)) {
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar',
                'id' => 'gdbb-toolbar-admin'
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id' => 'gdbb-toolbar-new',
                'title' => __("New", "gd-bbpress-toolbox"),
                'href' => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-new',
                'id' => 'gdbb-toolbar-new-forum',
                'title' => __("Forum", "gd-bbpress-toolbox"),
                'href' => admin_url('post-new.php?post_type='.bbp_get_forum_post_type())
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-new',
                'id' => 'gdbb-toolbar-new-topic',
                'title' => __("Topic", "gd-bbpress-toolbox"),
                'href' => admin_url('post-new.php?post_type='.bbp_get_topic_post_type())
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-new',
                'id' => 'gdbb-toolbar-new-reply',
                'title' => __("Reply", "gd-bbpress-toolbox"),
                'href' => admin_url('post-new.php?post_type='.bbp_get_reply_post_type())
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id' => 'gdbb-toolbar-edit',
                'title' => __("Edit", "gd-bbpress-toolbox"),
                'href' => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-edit',
                'id' => 'gdbb-toolbar-edit-forums',
                'title' => __("Forums", "gd-bbpress-toolbox"),
                'href' => admin_url('edit.php?post_type='.bbp_get_forum_post_type())
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-edit',
                'id' => 'gdbb-toolbar-edit-topics',
                'title' => __("Topics", "gd-bbpress-toolbox"),
                'href' => admin_url('edit.php?post_type='.bbp_get_topic_post_type())
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-edit',
                'id' => 'gdbb-toolbar-edit-replies',
                'title' => __("Replies", "gd-bbpress-toolbox"),
                'href' => admin_url('edit.php?post_type='.bbp_get_reply_post_type())
            ));

            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id' => 'gdbb-toolbar-settings',
                'title' => __("bbPress", "gd-bbpress-toolbox"),
                'href' => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-settings',
                'id' => 'gdbb-toolbar-settings-main',
                'title' => __("Settings", "gd-bbpress-toolbox"),
                'href' => admin_url('options-general.php?page=bbpress')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-settings',
                'id' => 'gdbb-toolbar-settings-repair',
                'title' => __("Tools", "gd-bbpress-toolbox"),
                'href' => admin_url('tools.php?page=bbp-repair')
            ));
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar-settings',
                'id' => 'gdbb-toolbar-settings-third'
            ));

            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id' => 'gdbb-toolbar-toolbox',
                'title' => __("Toolbox", "gd-bbpress-toolbox"),
                'href' => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox',
                'id' => 'gdbb-toolbar-toolbox-front',
                'title' => __("Front Page", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-front')
            ));
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar-toolbox',
                'id' => 'gdbb-toolbar-toolbox-third'
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox-third',
                'id' => 'gdbb-toolbar-toolbox-features',
                'title' => __("Features", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-features')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox-third',
                'id' => 'gdbb-toolbar-toolbox-settings',
                'title' => __("Settings", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-settings')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox-third',
                'id' => 'gdbb-toolbar-toolbox-attachments',
                'title' => __("Attachments", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-attachments')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox-third',
                'id' => 'gdbb-toolbar-toolbox-users',
                'title' => __("Users", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-users')
            ));

            if (Features::instance()->is_enabled('canned-replies')) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-toolbox-third',
                    'id' => 'gdbb-toolbar-toolbox-canned',
                    'title' => __("Canned Replies", "gd-bbpress-toolbox"),
                    'href' => admin_url('edit.php?post_type=bbx_canned_reply')
                ));
            }

            if (Features::instance()->is_enabled('report')) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-toolbox-third',
                    'id' => 'gdbb-toolbar-toolbox-reported-posts',
                    'title' => __("Reported Posts", "gd-bbpress-toolbox"),
                    'href' => admin_url('admin.php?page=gd-bbpress-reported-posts')
                ));
            }

            if (Features::instance()->is_enabled('thanks')) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-toolbox-third',
                    'id' => 'gdbb-toolbar-toolbox-thanks-list',
                    'title' => __("Thanks List", "gd-bbpress-toolbox"),
                    'href' => admin_url('admin.php?page=gd-bbpress-toolbox-thanks-list')
                ));
            }

            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox-third',
                'id' => 'gdbb-toolbar-toolbox-errors',
                'title' => __("Errors Log", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-errors')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-toolbox-third',
                'id' => 'gdbb-toolbar-toolbox-tools',
                'title' => __("Tools", "gd-bbpress-toolbox"),
                'href' => admin_url('admin.php?page=gd-bbpress-toolbox-tools')
            ));
        }

        if ($this->settings['information']) {
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar',
                'id' => 'gdbb-toolbar-info',
                'meta' => array('class' => 'ab-sub-secondary')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-info',
                'id' => 'gdbb-toolbar-info-links',
                'title' => __("Information", "gd-bbpress-toolbox")
            ));
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar-info-links',
                'id' => 'gdbb-toolbar-info-links-bbp',
                'meta' => array('class' => 'ab-sub-secondary')
            ));
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar-info-links',
                'id' => 'gdbb-toolbar-info-links-toolbox',
                'meta' => array('class' => 'ab-sub-secondary')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-info-links-bbp',
                'id' => 'gdbb-toolbar-bbp-home',
                'title' => __("bbPress Homepage", "gd-bbpress-toolbox"),
                'href' => 'https://bbpress.org/',
                'meta' => array('target' => '_blank', 'rel' => 'nofollow')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-info-links-bbp',
                'id' => 'gdbb-toolbar-d4p-home',
                'title' => __("Dev4Press Homepage", "gd-bbpress-toolbox"),
                'href' => 'https://www.dev4press.com/',
                'meta' => array('target' => '_blank', 'rel' => 'nofollow')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-info-links-toolbox',
                'id' => 'gdbb-toolbar-toolbox-home',
                'title' => __("Plugin Homepage", "gd-bbpress-toolbox"),
                'href' => 'https://plugins.dev4press.com/gd-bbpress-toolbox/',
                'meta' => array('target' => '_blank', 'rel' => 'nofollow')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-info-links-toolbox',
                'id' => 'gdbb-toolbar-toolbox-kb',
                'title' => __("Knowledge Base", "gd-bbpress-toolbox"),
                'href' => 'https://support.dev4press.com/kb/product/gd-bbpress-toolbox/',
                'meta' => array('target' => '_blank', 'rel' => 'nofollow')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-info-links-toolbox',
                'id' => 'gdbb-toolbar-toolbox-forum',
                'title' => __("Support Forum", "gd-bbpress-toolbox"),
                'href' => 'https://support.dev4press.com/forums/forum/plugins/gd-bbpress-toolbox/',
                'meta' => array('target' => '_blank', 'rel' => 'nofollow')
            ));
        }
    }
}
