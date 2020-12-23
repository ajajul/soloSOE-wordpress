<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;
use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class Editor extends Feature {
    public $feature_name = 'editor';
    public $context = array(
        'topic' => array(
            'tinymce' => false,
            'teeny' => false,
            'media_buttons' => false,
            'wpautop' => true,
            'quicktags' => true,
            'textarea_rows' => 12
        ),
        'reply' => array(
            'tinymce' => false,
            'teeny' => false,
            'media_buttons' => false,
            'wpautop' => true,
            'quicktags' => true,
            'textarea_rows' => 12
        )
    );

    public function __construct() {
        parent::__construct();

        $this->context['topic'] = gdbbx()->prefix_get('editor__topic_', 'features');
        $this->context['reply'] = gdbbx()->prefix_get('editor__reply_', 'features');

        add_filter('bbp_after_get_the_content_parse_args', array($this, 'control'));
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\Editor */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Editor();
        }

        return $instance;
    }

    public function control($args) {
        $context = $args['context'];

        if (isset($this->context[$context]) && $this->context[$context]['tinymce']) {
            foreach ($this->context[$context] as $key => $val) {
                $args[$key] = $val;
            }
        }

        gdbbx_roles()->update_roles();
        gdbbx_roles()->update_role_before_render();

        Enqueue::instance()->tinymce();

        return $args;
    }
}