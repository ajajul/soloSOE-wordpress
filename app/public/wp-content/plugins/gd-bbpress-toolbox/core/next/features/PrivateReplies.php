<?php

namespace Dev4Press\Plugin\GDBBX\Features;

use Dev4Press\Plugin\GDBBX\Basic\Feature;

if (!defined('ABSPATH')) {
    exit;
}

class PrivateReplies extends Feature {
    public $feature_name = 'private-replies';
    public $settings = array(
        'form_position' => 'bbp_theme_before_reply_form_submit_wrapper',
        'threaded' => true,
        'super_admin' => true,
        'roles' => null,
        'visitor' => false,
        'default' => 'unchecked',
        'moderators_can_read' => true,
        'css_hide' => false
    );

    public $replies = false;
    public $reply_id = 0;
    public $threaded = false;

    public function __construct() {
        parent::__construct();

        $this->threaded = bbp_thread_replies();

        add_action('gdbbx_template', array($this, 'loader'));
    }

    public function loader() {
        $this->replies = $this->is_enabled_reply_private();

        if ($this->replies) {
            if ($this->allowed()) {
                add_action($this->settings['form_position'], array($this, 'reply_checkbox'), 8);

                add_action('bbp_new_reply', array($this, 'reply_save'), 1, 2);
                add_action('bbp_edit_reply', array($this, 'reply_save'), 1, 2);
            }

            add_filter('bbp_get_reply_excerpt', array($this, 'reply_hidding'), 10000, 2);
            add_filter('bbp_get_reply_content', array($this, 'reply_hidding'), 10000, 2);

            add_filter('bbp_get_reply_class', array($this, 'reply_post_class'), 10, 2);
            add_filter('bbp_get_topic_subscribers', array($this, 'topic_subscribers'));
            add_filter('bbp_activity_reply_create_excerpt', array($this, 'reply_activity_stream'));
        }
    }

    /** @return bool|\Dev4Press\Plugin\GDBBX\Features\PrivateReplies */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new PrivateReplies();
        }

        return $instance;
    }

    public function is_enabled_reply_private() {
        $forum_id = gdbbx_get_forum_id();
        $forum = gdbbx_forum($forum_id)->privacy()->get('enable_reply_private');

        $active = false;
        if ($forum == 'default' || $forum == 'yes') {
            $active = true;
        } else if ($forum == 'no') {
            $active = false;
        }

        return apply_filters('gdbbx_privacy_is_enabled_reply_private', $active);
    }

    public function reply_activity_stream($content) {
        if ($this->is_private($this->reply_id)) {
            $content = __("Reply is marked as private.", "gd-bbpress-toolbox");
        }

        return $content;
    }

    public function topic_subscribers($users) {
        $final = array();

        foreach ($users as $user_id) {
            if ($this->is_user_allowed($this->reply_id, $user_id)) {
                $final[] = $user_id;
            }
        }

        return $final;
    }

    public function reply_hidding($content, $reply_id) {
        if (!$this->is_user_allowed($reply_id)) {
            $content = __("This reply has been set as private.", "gd-bbpress-toolbox");
        }

        return $content;
    }

    public function reply_save($reply_id = 0, $topic_id = 0) {
        $this->reply_id = $reply_id;

        if (isset($_POST['gdbbx_private_reply'])) {
            update_post_meta($reply_id, '_bbp_reply_is_private', '1');
        } else {
            delete_post_meta($reply_id, '_bbp_reply_is_private');
        }
    }

    public function reply_checkbox() {
        $edit = bbp_is_reply_edit();
        $status = $edit ? $this->is_private() : ($this->settings['default'] == "checked");

        $label = apply_filters('gdbbx_private_reply_checkbox_label', __("Set this as private reply", "gd-bbpress-toolbox"));

        ?>

        <p>
            <input name="gdbbx_private_reply" id="gdbbx_private_reply" type="checkbox"<?php checked('1', $status); ?> value="1"/>
            <label for="gdbbx_private_reply"><?php echo $label; ?></label>
        </p>

        <?php
    }

    public function reply_post_class($classes, $reply_id) {
        if ($this->is_private($reply_id)) {
            $classes[] = 'gdbbx-private-reply';

            if (!$this->is_user_allowed($reply_id)) {
                $classes[] = 'gdbbx-private-reply-locked';

                if ($this->settings['css_hide']) {
                    $classes[] = 'gdbbx-private-reply-hidden';
                }
            }
        }

        return $classes;
    }

    public function is_user_allowed($reply_id = 0, $user_id = 0) {
        if ($reply_id == 0) {
            $reply_id = bbp_get_reply_id();
        }

        if ($user_id == 0) {
            $user_id = bbp_get_current_user_id();
        }

        $allowed = true;
        $private = false;

        if ($this->is_private($reply_id)) {
            $private = true;

            $author_id = bbp_get_reply_author_id($reply_id);

            $allowed = false;

            if ($user_id > 0) {
                $allowed = $author_id == $user_id;
            }

            if (!$allowed) {
                $topic_id = bbp_get_reply_topic_id($reply_id);
                $topic_author_id = bbp_get_topic_author_id($topic_id);

                if ($user_id > 0) {
                    $allowed = $topic_author_id == $user_id;
                }
            }

            if (!$allowed && $this->threaded && $this->settings['threaded']) {
                $reply_to_id = (int)get_post_meta($reply_id, '_bbp_reply_to', true);
                $reply_to_author_id = bbp_get_reply_author_id($reply_to_id);

                if ($user_id > 0 && $reply_to_id > 0) {
                    $allowed = $reply_to_author_id == $user_id;
                }
            }

            if (!$allowed && $this->settings['moderators_can_read']) {
                $allowed = gdbbx_can_user_moderate();
            }
        }

        return apply_filters('gdbbx_private_is_user_allowed_to_reply', $allowed, $private, $reply_id, $user_id);
    }

    public function has_private_replies($topic_id = 0) {
        $topic_id = $topic_id == 0 ? bbp_get_topic_id($topic_id) : absint($topic_id);

        return gdbbx_cache()->private_count_topic_replies($topic_id);
    }

    public function is_private($reply_id = 0) {
        if ($reply_id == 0) {
            $reply_id = bbp_get_reply_id();
        }

        $status = gdbbx_cache()->private_post($reply_id);

        return apply_filters('gdbbx_is_reply_private', $status, $reply_id);
    }
}
