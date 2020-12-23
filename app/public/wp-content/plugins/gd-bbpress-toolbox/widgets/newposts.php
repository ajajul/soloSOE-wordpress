<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_newposts extends d4p_widget_core {
    private $replies = array();

    public $widget_base = 'd4p_bbw_newposts';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = true;

    public $defaults = array(
        'title' => 'New Posts',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'template' => 'gdbbx-widget-newposts.php',
        'period' => 'last_day',
        'scope' => 'topic,reply',
        'display_date' => 'yes',
        'display_author' => 'no',
        'display_author_avatar' => 'no',
        'exclude_private' => 'yes',
        'exclude_forums_ids' => array(),
        'include_forums_ids' => array(),
        'limit' => 10,
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("New topics or topics with new replies.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("New Posts", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('newposts-filter')),
            'display' => array('name' => __("Display", "gd-bbpress-toolbox"), 'include' => array('newposts-content')),
            'extra' => array('name' => __("Extra", "gd-bbpress-toolbox"), 'include' => array('shared-wrapper'))
        );

        include(GDBBX_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = d4p_sanitize_basic($new_instance['title']);
        $instance['_display'] = d4p_sanitize_basic($new_instance['_display']);
        $instance['_cached'] = intval($new_instance['_cached']);
        $instance['_class'] = d4p_sanitize_basic($new_instance['_class']);
        $instance['_tab'] = d4p_sanitize_basic($new_instance['_tab']);
        $instance['_hook'] = d4p_sanitize_key_expanded($new_instance['_hook']);

        $instance['template'] = d4p_sanitize_basic($new_instance['template']);

        $instance['period'] = d4p_sanitize_basic($new_instance['period']);
        $instance['scope'] = d4p_sanitize_basic($new_instance['scope']);
        $instance['limit'] = absint($new_instance['limit']);
        $instance['display_date'] = d4p_sanitize_basic($new_instance['display_date']);
        $instance['display_author'] = d4p_sanitize_basic($new_instance['display_author']);
        $instance['display_author_avatar'] = d4p_sanitize_basic($new_instance['display_author_avatar']);
        $instance['exclude_private'] = d4p_sanitize_basic($new_instance['exclude_private']);

        $instance['exclude_forums_ids'] = d4p_ids_from_string($new_instance['exclude_forums_ids']);
        $instance['include_forums_ids'] = d4p_ids_from_string($new_instance['include_forums_ids']);

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = d4p_sanitize_html($new_instance['before']);
            $instance['after'] = d4p_sanitize_html($new_instance['after']);
        }

        return $instance;
    }

    public function results($instance) {
        require_once(GDBBX_PATH.'core/functions/posts.php');

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $month = 0;
        $days = 0;
        $years = 0;
        $hours = 1;

        $scope = $instance['scope'];

        switch ($instance['period']) {
            case 'last_hour':
                $hours = 2;
                break;
            default:
            case 'last_day':
                $days = 1;
                break;
            case 'last_week':
                $days = 7;
                break;
            case 'last_fortnight':
                $days = 14;
                break;
            case 'last_month':
                $month = 1;
                break;
            case 'last_3months':
                $month = 3;
                break;
            case 'last_6months':
                $month = 6;
                break;
            case 'last_year':
                $years = 1;
                break;
        }

        $timestamp = mktime(date('H') - $hours, 0, 0, date('n') - $month, date('j') - $days, date('Y') - $years);
        $timestamp = $timestamp + d4p_gmt_offset() * 3600;

        $atts = array(
            'timestamp' => $timestamp,
            'limit' => $instance['limit'],
            'access_check' => $instance['exclude_private'],
            'include_forums' => $instance['include_forums_ids'],
            'exclude_forums' => $instance['exclude_forums_ids']
        );

        switch ($scope) {
            case 'topic,reply':
                return gdbbx_get_new_posts($atts);
            case 'topic':
                return gdbbx_get_new_posts_topics($atts);
            case 'reply':
                return gdbbx_get_new_posts_replies($atts);
        }
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        gdbbx_widget_render_header($instance, 'gdbbx-widget-newposts');

        if (empty($results)) {
            echo '<span class="gdbbx-no-topics">'.__("No topics found", "gd-bbpress-toolbox").'</span>';
        } else {
            echo '<ul>'.D4P_EOL;

            $show_date = isset($instance['display_date']) && $instance['display_date'] == 'yes';
            $show_author = isset($instance['display_author']) && $instance['display_author'] == 'yes';
            $show_avatar = isset($instance['display_author_avatar']) && $instance['display_author_avatar'] == 'yes';

            $template = apply_filters('gdbbx-widget-newposts-template', $instance['template'], $results, $this);
            $path = gdbbx_get_template_part($template);

            foreach ($results as $post) {
                include($path);
            }

            echo '</ul>'.D4P_EOL;
        }

        gdbbx_widget_render_footer($instance);
    }
}
