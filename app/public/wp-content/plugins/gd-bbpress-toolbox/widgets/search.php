<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_search extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_search';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = false;

    public $forum_id = 0;

    public $defaults = array(
        'title' => 'Search Forums',
        'title_current' => 'Search current forum',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'search_mode' => 'global',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Expanded search widget.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Search", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'search-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('search-content')),
            'extra' => array('name' => __("Extra", "gd-bbpress-toolbox"), 'include' => array('shared-wrapper'))
        );

        include(GDBBX_PATH.'forms/widgets/shared-loader.php');
    }

    public function widget_output($args, $instance) {
        $this->forum_id = bbp_get_forum_id();

        return parent::widget_output($args, $instance);
    }

    public function title($instance) {
        if ($instance['search_mode'] == 'current' && $this->forum_id > 0) {
            return $instance['title_current'];
        }

        return $instance['title'];
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = d4p_sanitize_basic($new_instance['title']);
        $instance['_display'] = d4p_sanitize_basic($new_instance['_display']);
        $instance['_class'] = d4p_sanitize_basic($new_instance['_class']);
        $instance['_tab'] = d4p_sanitize_basic($new_instance['_tab']);
        $instance['_hook'] = d4p_sanitize_key_expanded($new_instance['_hook']);

        $instance['title_current'] = d4p_sanitize_basic($new_instance['title_current']);
        $instance['search_mode'] = d4p_sanitize_basic($new_instance['search_mode']);

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = d4p_sanitize_html($new_instance['before']);
            $instance['after'] = d4p_sanitize_html($new_instance['after']);
        }

        return $instance;
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        gdbbx_widget_render_header($instance, 'gdbbx-widget-search');

        include(gdbbx_get_template_part('gdbbx-widget-search.php'));

        gdbbx_widget_render_footer($instance);
    }

    public function form_unique_id($instance) {
        return 'gdbbx-search-form-'.$this->number;
    }
}
