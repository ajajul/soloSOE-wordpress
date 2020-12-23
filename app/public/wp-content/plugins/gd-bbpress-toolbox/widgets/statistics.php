<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_statistics extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_statistics';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = true;

    public $defaults = array(
        'title' => 'Forum Statistics',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'template' => 'gdbbx-widget-statistics-list.php',
        'stats' => array(),
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Forum statistics information.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Statistics", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('statistics-content'), 'class' => 'gdbbx-tab-topics-stats'),
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

        $instance['stats'] = array();
        if (isset($new_instance['stats'])) {
            $_stats = (array)$new_instance['stats'];
            $_all = array_keys(gdbbx_list_of_statistics_elements());

            foreach ($_stats as $key) {
                if (in_array($key, $_all)) {
                    $instance['stats'][] = $key;
                }
            }
        }

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
        require_once(GDBBX_PATH.'core/functions/statistics.php');

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $elements = gdbbx_list_of_statistics_elements();
        $statistics = gdbbx_get_statistics();

        if (empty($instance['stats'])) {
            $instance['stats'] = array_keys($elements);
        }

        gdbbx_widget_render_header($instance, 'gdbbx-widget-statistics');

        $template = apply_filters('gdbbx-widget-statistics-template', $instance['template'], $results, $this);

        include(gdbbx_get_template_part($template));

        gdbbx_widget_render_footer($instance);
    }
}
