<?php

use Dev4Press\Plugin\GDBBX\Basic\Features;

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_usersthanks extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_usersthanks';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = true;

    public $defaults = array(
        'title' => 'Top Thanked Users',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'template' => 'gdbbx-widget-usersthanks.php',
        'limit' => 10,
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("List of users with most thanks received.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Top Thanked Users", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('usersthanks-content')),
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

        $instance['limit'] = absint($new_instance['limit']);

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
        if (!Features::instance()->is_enabled('thanks')) {
            return array();
        }

        return gdbbx_say_thanks()->get_list_top_thanked_users(array(
            'limit' => $instance['limit'],
            'return' => 'list'
        ));
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        gdbbx_widget_render_header($instance, 'gdbbx-widget-usersthanks');

        if (empty($results)) {
            echo '<span class="gdbbx-no-users">'.__("No users found", "gd-bbpress-toolbox").'</span>';
        } else {
            echo '<ul>'.D4P_EOL;

            $template = apply_filters('gdbbx-widget-usersthanks-template', $instance['template'], $results, $this);
            $path = gdbbx_get_template_part($template);

            foreach ($results as $user) {
                include($path);
            }

            echo '</ul>'.D4P_EOL;
        }

        gdbbx_widget_render_footer($instance);
    }
}
