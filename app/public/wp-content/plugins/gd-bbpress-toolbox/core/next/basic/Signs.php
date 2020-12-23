<?php

namespace Dev4Press\Plugin\GDBBX\Basic;

use Dev4Press\Plugin\GDBBX\Features\Icons;

if (!defined('ABSPATH')) {
    exit;
}

class Signs {
    public $mode = 'font';

    public function __construct() {
        $this->mode = Icons::instance()->settings['mode'];
    }

    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Signs();
        }

        return $instance;
    }

    public function attachments($count) {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-paperclip" title="'.sprintf(_n("%s attachment", "%s attachments", $count, "gd-bbpress-toolbox"), $count).'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-paperclip" title="'.sprintf(_n("%s attachment", "%s attachments", $count, "gd-bbpress-toolbox"), $count).'"></i> ';
        }

        return $render;
    }

    public function new_replies() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-arrow" title="'.__("First new reply", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-chevron-circle-right" title="'.__("First new reply", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_new_replies', $render, $this->mode);
    }

    public function private_topic() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-private" title="'.__("Private topic", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-eye-slash" title="'.__("Private topic", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_private_topic', $render, $this->mode);
    }

    public function private_replies() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-private" title="'.__("Topic has private replies", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-eye-slash" title="'.__("Topic has private replies", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_private_replies', $render, $this->mode);
    }

    public function replied_to_topic() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-reply" title="'.__("Replied to this topic", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-comments-o" title="'.__("Replied to this topic", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_replied_to_topic', $render, $this->mode);
    }

    public function sticky_topic() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-stick" title="'.__("This is sticky topic", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-thumb-tack" title="'.__("This is sticky topic", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_sticky_topic', $render, $this->mode);
    }

    public function locked_topic() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-lock" title="'.__("Locked Topic", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-lock" title="'.__("Locked Topic", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_locked_topic', $render, $this->mode);
    }

    public function closed_topic() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-close" title="'.__("Closed Topic", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-times-circle" title="'.__("Closed Topic", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_closed_topic', $render, $this->mode);
    }

    public function hidden_forum() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-private" title="'.__("Hidden forum", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-eye-slash" title="'.__("Hidden forum", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_private_forum', $render, $this->mode);
    }

    public function private_forum() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-private" title="'.__("Private forum", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-user-secret" title="'.__("Private forum", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_private_forum', $render, $this->mode);
    }

    public function closed_forum() {
        $render = '';

        if ($this->mode == 'images') {
            $render = '<span class="gdbbx-image-mark gdbbx-image-close" title="'.__("Closed Forum", "gd-bbpress-toolbox").'"></span>';
        } else if ($this->mode == 'font') {
            $render = '<i class="gdbbx-icon-mark gdbbx-icon gdbbx-icon-times-circle" title="'.__("Closed Forum", "gd-bbpress-toolbox").'"></i> ';
        }

        return apply_filters('gdbbx_icon_for_closed_forum', $render, $this->mode);
    }
}
