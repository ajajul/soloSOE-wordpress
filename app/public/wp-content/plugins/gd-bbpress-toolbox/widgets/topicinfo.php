<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_topicinfo extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_topicinfo';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = false;

    public $defaults = array(
        'title' => 'Topic Information',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'before' => '',
        'after' => '',
        'template' => 'gdbbx-widget-topicinfo.php',
        'show_forum' => true,
        'show_author' => true,
        'show_post_date' => true,
        'show_last_activity' => true,
        'show_status' => true,
        'show_count_replies' => true,
        'show_count_voices' => true,
        'show_participants' => true,
        'show_subscribe_favorite' => false
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Information about current topic.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Topic Information", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('topicinfo-content')),
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

        $instance['show_forum'] = isset($new_instance['show_forum']);
        $instance['show_author'] = isset($new_instance['show_author']);
        $instance['show_post_date'] = isset($new_instance['show_post_date']);
        $instance['show_last_activity'] = isset($new_instance['show_last_activity']);
        $instance['show_status'] = isset($new_instance['show_status']);
        $instance['show_count_replies'] = isset($new_instance['show_count_replies']);
        $instance['show_count_voices'] = isset($new_instance['show_count_voices']);
        $instance['show_participants'] = isset($new_instance['show_participants']);
        $instance['show_subscribe_favorite'] = isset($new_instance['show_subscribe_favorite']);

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
        return bbp_is_single_topic();
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $topic_id = bbp_get_topic_id();

        $list = array();

        if ($instance['show_forum']) {
            $forum_id = bbp_get_topic_forum_id();

            $list['show_forum'] = array(
                'type' => 'link',
                'icon' => 'forum',
                'label' => __("Forum", "gd-bbpress-toolbox"),
                'value' => '<a href="'.bbp_get_forum_permalink($forum_id).'">'.bbp_get_forum_title($forum_id).'</a>'
            );
        }

        if ($instance['show_author']) {
            $list['show_author'] = array(
                'type' => 'link',
                'icon' => 'user',
                'label' => _x("Author", "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => bbp_get_topic_author_link(array('type' => 'name'))
            );
        }

        if ($instance['show_post_date']) {
            $post_date = get_post_field('post_date', $topic_id);

            $list['show_post_date'] = array(
                'type' => 'date',
                'icon' => 'calendar-o',
                'label' => _x("Posted", "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => bbp_get_time_since(bbp_convert_date($post_date))
            );
        }

        if ($instance['show_last_activity']) {
            $list['show_last_activity'] = array(
                'type' => 'date',
                'icon' => 'clock-o',
                'label' => _x("Last activity", "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => bbp_get_topic_last_active_time($topic_id)
            );
        }

        if ($instance['show_status']) {
            $list['show_status'] = array(
                'type' => 'text',
                'icon' => 'thumb-tack',
                'label' => _x("Status", "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => bbp_is_topic_open($topic_id) ? __("Open", "gd-bbpress-toolbox") : __("Closed", "gd-bbpress-toolbox")
            );
        }

        if ($instance['show_count_replies']) {
            $value = bbp_get_topic_reply_count($topic_id);

            $list['show_count_replies'] = array(
                'type' => 'count',
                'icon' => 'reply',
                'label' => _x("Replies", "Topic Information Widget", "gd-bbpress-toolbox"),
                'label_alt' => _nx("%s reply", "%s replies", $value, "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => $value
            );
        }

        if ($instance['show_count_voices']) {
            $value = bbp_get_topic_voice_count($topic_id);

            $list['show_count_voices'] = array(
                'type' => 'count',
                'icon' => 'users',
                'label' => _x("Voices", "Topic Information Widget", "gd-bbpress-toolbox"),
                'label_alt' => _nx("%s voice", "%s voices", $value, "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => $value
            );
        }

        if ($instance['show_participants'] && bbp_get_topic_voice_count($topic_id) > 1) {
            $users = gdbbx_db()->get_topic_participants($topic_id);

            $participants = array();
            foreach ($users as $id) {
                if (get_userdata($id) !== false) {
                    $participants[] = bbp_get_user_profile_link($id);
                }
            }

            $list['show_participants'] = array(
                'type' => 'list',
                'icon' => 'users',
                'label' => _x("Participants", "Topic Information Widget", "gd-bbpress-toolbox"),
                'value' => join(', ', $participants)
            );
        }

        if (is_user_logged_in() && $instance['show_subscribe_favorite']) {
            $list['show_subscribe_favorite'] = array(
                'type' => 'action',
                'icon' => 'bookmark',
                'label' => _x("Actions", "Forum Information Widget", "gd-bbpress-toolbox"),
                'value' => bbp_get_topic_subscription_link(array('before' => '', 'after' => '')).'<br/>'.bbp_get_topic_favorite_link(array('before' => '', 'after' => ''))
            );
        }

        $list = apply_filters('gdbbx-widget-topicinfo-list', $list, $this);

        return $list;
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());
        
        gdbbx_widget_render_header($instance, 'gdbbx-widget-topicinfo');

        $template = apply_filters('gdbbx-widget-topicinfo-template', $instance['template'], $results, $this);

        include(gdbbx_get_template_part($template));
        
        gdbbx_widget_render_footer($instance);
    }
}
