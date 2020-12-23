<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_core_widgets {
    public $widgets = array(
        'newposts', 
        'topicinfo',
        'foruminfo',
        'search',
        'statistics', 
        'onlineusers',
        'topicsviews',
        'userprofile',
        'usersthanks'
    );

    public function __construct() {
        add_action('gdbbx_init', array($this, 'disable'));
        add_action('widgets_init', array($this, 'init'));
    }

    public function disable() {
        if (gdbbx()->get('default_disable_recenttopics', 'widgets')) {
            remove_action('bbp_widgets_init', array('BBP_Topics_Widget', 'register_widget'), 10);
        }

        if (gdbbx()->get('default_disable_recentreplies', 'widgets')) {
            remove_action('bbp_widgets_init', array('BBP_Replies_Widget', 'register_widget'), 10);
        }

        if (gdbbx()->get('default_disable_topicviewslist', 'widgets')) {
            remove_action('bbp_widgets_init', array('BBP_Views_Widget', 'register_widget'), 10);
        }

        if (gdbbx()->get('default_disable_login', 'widgets')) {
            remove_action('bbp_widgets_init', array('BBP_Login_Widget', 'register_widget'), 10);
        }

        if (gdbbx()->get('default_disable_search', 'widgets')) {
            remove_action('bbp_widgets_init', array('BBP_Search_Widget', 'register_widget'), 10);
        }

        if (gdbbx()->get('default_disable_stats', 'widgets')) {
            remove_action('bbp_widgets_init', array('BBP_Stats_Widget', 'register_widget'), 10);
        }
    }

    public function init() {
        foreach ($this->widgets as $widget) {
            if (gdbbx()->get('widget_'.$widget, 'widgets')) {
                require_once(GDBBX_PATH.'widgets/'.$widget.'.php');

                register_widget('d4pbbpWidget_'.$widget);
            }
        }
    }
}
