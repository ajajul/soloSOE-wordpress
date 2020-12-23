<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_foruminfo extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_foruminfo';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = false;

    public $defaults = array(
        'title' => 'Forum Information',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'before' => '',
        'after' => '',
        'template' => 'gdbbx-widget-foruminfo.php',
        'show_parent_forum' => true,
        'show_count_topics' => true,
        'show_count_replies' => true,
        'show_last_post_user' => true,
        'show_last_activity' => true,
        'show_subscribe' => true
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Information about current forum.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Forum Information", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('foruminfo-content')),
            'extra' => array('name' => __("Extra", "gd-bbpress-toolbox"), 'include' => array('shared-wrapper'))
        );

        include(GDBBX_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = d4p_sanitize_basic($new_instance['title']);
        $instance['_display'] = d4p_sanitize_basic($new_instance['_display']);
        $instance['_cached'] = absint($new_instance['_cached']);
        $instance['_class'] = d4p_sanitize_basic($new_instance['_class']);
        $instance['_tab'] = d4p_sanitize_basic($new_instance['_tab']);
        $instance['_hook'] = d4p_sanitize_key_expanded($new_instance['_hook']);

        $instance['template'] = d4p_sanitize_basic($new_instance['template']);

        $instance['show_parent_forum'] = isset($new_instance['show_parent_forum']);
        $instance['show_count_topics'] = isset($new_instance['show_count_topics']);
        $instance['show_count_replies'] = isset($new_instance['show_count_replies']);
        $instance['show_last_post_user'] = isset($new_instance['show_last_post_user']);
        $instance['show_last_activity'] = isset($new_instance['show_last_activity']);
        $instance['show_subscribe'] = isset($new_instance['show_subscribe']);

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = d4p_sanitize_html($new_instance['before']);
            $instance['after'] = d4p_sanitize_html($new_instance['after']);
        }

        return $instance;
    }

    public function is_visible($instance) {
        return bbp_is_single_forum();
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $forum_id = bbp_get_forum_id();

        $list = array();

        if ($instance['show_parent_forum']) {
            $parent_forum_id = bbp_get_forum_parent_id();

            if ($parent_forum_id > 0) {
                $list['show_parent_forum'] = array(
                    'type' => 'link',
                    'icon' => 'forum',
                    'label' => _x("Parent forum", "Forum Information Widget", "gd-bbpress-toolbox"),
                    'value' => '<a href="'.bbp_get_forum_permalink($parent_forum_id).'">'.bbp_get_forum_title($parent_forum_id).'</a>'
                );
            }
        }

        if ($instance['show_count_topics']) {
            $value = bbp_get_forum_topic_count($forum_id);

            $list['show_count_topics'] = array(
                'type' => 'count',
                'icon' => 'topic',
                'label' => _x("Topics", "Forum Information Widget", "gd-bbpress-toolbox"),
                'label_alt' => _nx("%s topic", "%s topics", $value, "Forum Information Widget", "gd-bbpress-toolbox"),
                'value' => $value
            );
        }

        if ($instance['show_count_replies']) {
            $value = bbp_get_forum_reply_count($forum_id);

            $list['show_count_replies'] = array(
                'type' => 'count',
                'icon' => 'reply',
                'label' => _x("Replies", "Forum Information Widget", "gd-bbpress-toolbox"),
                'label_alt' => _nx("%s reply", "%s replies", $value, "Forum Information Widget", "gd-bbpress-toolbox"),
                'value' => $value
            );
        }

        if ($instance['show_last_post_user']) {
            $last_active = bbp_get_forum_last_active_id($forum_id);

            if ($last_active > 0) {
                $list['show_last_post_user'] = array(
                    'type' => 'link',
                    'icon' => 'user',
                    'label' => _x("Last post by", "Forum Information Widget", "gd-bbpress-toolbox"),
                    'value' => bbp_get_user_profile_link(bbp_get_reply_author_id($last_active))
                );
            }
        }

        if ($instance['show_last_activity']) {
            $last_active = bbp_get_forum_last_active_time($forum_id);

            if (!empty($last_active)) {
                $list['show_last_activity'] = array(
                    'type' => 'date',
                    'icon' => 'clock-o',
                    'label' => _x("Last activity", "Forum Information Widget", "gd-bbpress-toolbox"),
                    'value' => $last_active
                );
            }
        }

        if (is_user_logged_in() && $instance['show_subscribe'] && !bbp_is_forum_category()) {
            $list['show_subscribe'] = array(
                'type' => 'action',
                'icon' => 'bookmark',
                'label' => _x("Actions", "Forum Information Widget", "gd-bbpress-toolbox"),
                'value' => bbp_get_forum_subscription_link()
            );
        }

        $list = apply_filters('gdbbx-widget-foruminfo-list', $list, $this);

        return $list;
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        gdbbx_widget_render_header($instance, 'gdbbx-widget-foruminfo');

        $template = apply_filters('gdbbx-widget-foruminfo-template', $instance['template'], $results, $this);

        include(gdbbx_get_template_part($template));

        gdbbx_widget_render_footer($instance);
    }
}
