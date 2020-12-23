<?php

if (!defined('ABSPATH')) { exit; }

class d4pbbpWidget_topicsviews extends d4p_widget_core {
    public $widget_base = 'd4p_bbw_topicsviews';
    public $widget_domain = 'gdbbx_widgets';
    public $cache_prefix = 'gdbbx-widget';

    public $cache_active = true;

    public $defaults = array(
        'title' => 'Topics Views List',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'views' => array(),
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("List of the selected topic views.", "gd-bbpress-toolbox");
        $this->widget_name = 'GD bbPress Toolbox: '.__("Topics Views", "gd-bbpress-toolbox");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-bbpress-toolbox"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-bbpress-toolbox"), 'include' => array('topicsviews-content'), 'class' => 'gdbbx-tab-topics-views'),
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

        $instance['views'] = array();
        if (isset($new_instance['views'])) {
            $_views = (array)$new_instance['views'];
            $_all = array_keys(bbp_get_views());

            foreach ($_views as $key) {
                if (in_array($key, $_all)) {
                    $instance['views'][] = $key;
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
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        if (empty($instance['views'])) {
            $instance['views'] = array_keys(bbp_get_views());
        }

        gdbbx_widget_render_header($instance, 'gdbbx-widget-topicsviews');

        echo '<ul>'.D4P_EOL;

        $current_view = bbp_is_single_view() ? get_query_var('bbp_view') : '';

        foreach ($instance['views'] as $view) {
            $view = bbp_get_view_id($view);

            if (empty($view)) {
                continue;
            }

            $class = 'bbp-view-'.$view;
            if ($view == $current_view) {
                $class.= ' current';
            }

            echo '<li class="'.$class.'">'.D4P_EOL.D4P_TAB;
                echo '<a title="'.sprintf(__("Topic View: %s", "gd-bbpress-toolbox"), bbp_get_view_title($view)).'" href="'.bbp_get_view_url($view).'">'.bbp_get_view_title($view).'</a>';
            echo D4P_EOL."</li>".D4P_EOL;
        }

        echo '</ul>'.D4P_EOL;

        gdbbx_widget_render_footer($instance);
    }
}
