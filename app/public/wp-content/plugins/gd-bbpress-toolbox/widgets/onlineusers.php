<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_onlineusers extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_onlineusers';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = false;

    public $defaults = array(
        'title' => 'Users Online',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'before' => '',
        'after' => '',
        'template' => 'gdbbx-widget-onlineusers.php',
        'show_users' => 'profile_link',
        'show_users_avatar' => true,
        'show_users_list' => true,
        'show_max_users' => true,
        'show_user_roles' => true,
        'show_users_limit' => 5
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("List of current online users.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Online Users", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('onlineusers-content')),
            'extra' => array('name' => __("Extra", "gd-bbpress-toolbox"), 'include' => array('shared-wrapper'))
        );

        include(GDBBX_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = d4p_sanitize_basic($new_instance['title']);
        $instance['_display'] = d4p_sanitize_basic($new_instance['_display']);
        $instance['_class'] = d4p_sanitize_basic($new_instance['_class']);
        $instance['_tab'] = d4p_sanitize_basic($new_instance['_tab']);
        $instance['_hook'] = d4p_sanitize_key_expanded($new_instance['_hook']);

        $instance['template'] = d4p_sanitize_basic($new_instance['template']);

        $instance['show_users'] = absint($new_instance['show_users']);
        $instance['show_users_limit'] = d4p_sanitize_basic($new_instance['show_users_limit']);
        $instance['show_users_list'] = isset($new_instance['show_users_list']);
        $instance['show_users_avatar'] = isset($new_instance['show_users_avatar']);
        $instance['show_user_roles'] = isset($new_instance['show_user_roles']);
        $instance['show_max_users'] = isset($new_instance['show_max_users']);

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
        
        gdbbx_widget_render_header($instance, 'gdbbx-widget-onlineusers');

        $template = apply_filters('gdbbx-widget-onlineusers-template', $instance['template'], $results, $this);

        include(gdbbx_get_template_part($template));
        
        gdbbx_widget_render_footer($instance);
    }
}
