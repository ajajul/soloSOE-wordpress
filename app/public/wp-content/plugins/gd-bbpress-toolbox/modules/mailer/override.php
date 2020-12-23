<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_mailer_override {
    public function __construct() {
        if (gdbbx()->get('notify_moderators_topic_active', 'bbpress')) {
            add_filter('bbp_new_topic_moderators_mail_message', array($this, 'new_topic_moderators_mail_message'), 10, 3);
            add_filter('bbp_new_topic_moderators_mail_title', array($this, 'new_topic_moderators_mail_title'), 10, 3);
        }

        if (gdbbx()->get('notify_subscribers_reply_edit_active', 'bbpress')) {
            add_filter('bbp_reply_edit_subscription_mail_message', array($this, 'subscription_reply_edit_mail_message'), 10, 2);
            add_filter('bbp_reply_edit_subscription_mail_title', array($this, 'subscription_reply_edit_mail_title'), 10, 2);
        }

        if (gdbbx()->get('notify_subscribers_edit_active', 'bbpress')) {
            add_filter('bbp_topic_edit_subscription_mail_message', array($this, 'subscription_topic_edit_mail_message'), 10, 2);
            add_filter('bbp_topic_edit_subscription_mail_title', array($this, 'subscription_topic_edit_mail_title'), 10, 2);
        }

        if (gdbbx()->get('notify_subscribers_forum_override_active', 'bbpress')) {
            add_filter('bbp_forum_subscription_mail_message', array($this, 'subscription_forum_mail_message'), 10, 3);
            add_filter('bbp_forum_subscription_mail_title', array($this, 'subscription_forum_mail_title'), 10, 3);
        }

        if (gdbbx()->get('notify_subscribers_override_active', 'bbpress')) {
            add_filter('bbp_subscription_mail_message', array($this, 'subscription_mail_message'), 10, 3);
            add_filter('bbp_subscription_mail_title', array($this, 'subscription_mail_title'), 10, 3);
        }
    }

    public function subscription_reply_edit_mail_message($message, $reply_id) {
        $start = gdbbx()->get('notify_subscribers_reply_edit_content', 'bbpress');

        if ($start != '') {
            $topic_id = bbp_get_reply_topic_id($reply_id);

            $tags = apply_filters('gdbbx_tags_subscription_reply_edit_mail_message', array(
                'BLOG_NAME' => get_option('blogname'),
                'FORUM_TITLE' => bbp_get_forum_title(bbp_get_topic_forum_id($topic_id)),
                'TOPIC_TITLE' => bbp_get_topic_title($topic_id),
                'REPLY_TITLE' => gdbbx_get_reply_title($reply_id),
                'REPLY_LINK' => bbp_get_reply_url($reply_id),
                'REPLY_EDITOR' => gdbbx_get_user_display_name(),
                'REPLY_AUTHOR' => bbp_get_reply_author_display_name($reply_id),
                'REPLY_CONTENT' => bbp_get_reply_content($reply_id),
                'REPLY_EDIT' => gdbbx_module_mailer()->reply_revision_log($reply_id)
            ), $reply_id);

            if (gdbbx()->get('notify_subscribers_reply_edit_shortcodes', 'bbpress')) {
                $start = do_shortcode($start);
                $tags['REPLY_CONTENT'] = do_shortcode($tags['REPLY_CONTENT']);
            }

            $message = d4p_replace_tags_in_content($start, $tags);
            $message = gdbbx_email_clean_content($message);
        }

        return $message;
    }

    public function subscription_reply_edit_mail_title($title, $reply_id) {
        $start = gdbbx()->get('notify_subscribers_reply_edit_subject', 'bbpress');

        if ($start != '') {
            $topic_id = bbp_get_reply_topic_id($reply_id);

            $tags = apply_filters('gdbbx_tags_subscription_reply_edit_mail_title', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => strip_tags(bbp_get_topic_title($topic_id)),
                'REPLY_TITLE' => strip_tags(gdbbx_get_reply_title($reply_id))
            ), $reply_id);

            $title = d4p_replace_tags_in_content($start, $tags);
            $title = gdbbx_email_clean_content($title, apply_filters('gdbbx_cleanup_subscription_reply_edit_mail_title_strip_tags', true));
        }

        return $title;
    }

    public function subscription_topic_edit_mail_message($message, $topic_id) {
        $start = gdbbx()->get('notify_subscribers_edit_content', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('gdbbx_tags_subscription_topic_edit_mail_message', array(
                'BLOG_NAME' => get_option('blogname'),
                'FORUM_TITLE' => bbp_get_forum_title(bbp_get_topic_forum_id($topic_id)),
                'TOPIC_TITLE' => bbp_get_topic_title($topic_id),
                'TOPIC_LINK' => get_permalink($topic_id),
                'TOPIC_EDITOR' => gdbbx_get_user_display_name(),
                'TOPIC_AUTHOR' => bbp_get_topic_author_display_name($topic_id),
                'TOPIC_CONTENT' => bbp_get_topic_content($topic_id),
                'TOPIC_EDIT' => gdbbx_module_mailer()->topic_revision_log($topic_id)
            ), $topic_id);

            if (gdbbx()->get('notify_subscribers_edit_shortcodes', 'bbpress')) {
                $start = do_shortcode($start);
                $tags['TOPIC_CONTENT'] = do_shortcode($tags['TOPIC_CONTENT']);
            }

            $message = d4p_replace_tags_in_content($start, $tags);
            $message = gdbbx_email_clean_content($message, apply_filters('gdbbx_cleanup_subscription_topic_edit_mail_message_strip_tags', false));
        }

        return $message;
    }

    public function subscription_topic_edit_mail_title($title, $topic_id) {
        $start = gdbbx()->get('notify_subscribers_edit_subject', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('subscription_topic_edit_mail_title', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => strip_tags(bbp_get_topic_title($topic_id)),
                'FORUM_TITLE' => bbp_get_forum_title(bbp_get_topic_forum_id($topic_id))
            ), $topic_id);

            $title = d4p_replace_tags_in_content($start, $tags);
            $title = gdbbx_email_clean_content($title);
        }

        return $title;
    }

    public function subscription_mail_message($message, $reply_id, $topic_id) {
        $start = gdbbx()->get('notify_subscribers_override_content', 'bbpress');

        if ($start != '') {
            $tags = $tags = apply_filters('gdbbx_tags_subscription_mail_message', array(
                'BLOG_NAME' => get_option('blogname'),
                'FORUM_TITLE' => bbp_get_forum_title(bbp_get_topic_forum_id($topic_id)),
                'TOPIC_TITLE' => bbp_get_topic_title($topic_id),
                'TOPIC_LINK' => get_permalink($topic_id),
                'TOPIC_AUTHOR' => bbp_get_topic_author_display_name($topic_id),
                'REPLY_LINK' => bbp_get_reply_url($reply_id),
                'REPLY_AUTHOR' => bbp_get_reply_author_display_name($reply_id),
                'REPLY_CONTENT' => bbp_get_reply_content($reply_id),
                'REPLY_TITLE' => gdbbx_get_reply_title($reply_id)
            ), $reply_id, $topic_id);

            if (gdbbx()->get('notify_subscribers_override_shortcodes', 'bbpress')) {
                $start = do_shortcode($start);
                $tags['REPLY_CONTENT'] = do_shortcode($tags['REPLY_CONTENT']);
            }

            $message = d4p_replace_tags_in_content($start, $tags);
            $message = gdbbx_email_clean_content($message, apply_filters('gdbbx_cleanup_subscription_mail_message_strip_tags', true));
        }

        return $message;
    }

    public function subscription_mail_title($title, $reply_id, $topic_id) {
        $start = gdbbx()->get('notify_subscribers_override_subject', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('gdbbx_tags_subscription_topic_edit_mail_title', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => strip_tags(bbp_get_topic_title($topic_id)),
                'FORUM_TITLE' => bbp_get_forum_title(bbp_get_topic_forum_id($topic_id))
            ), $reply_id, $topic_id);

            $title = d4p_replace_tags_in_content($start, $tags);
            $title = gdbbx_email_clean_content($title);
        }

        return $title;
    }

    public function subscription_forum_mail_message($message, $topic_id, $forum_id) {
        $start = gdbbx()->get('notify_subscribers_forum_override_content', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('gdbbx_tags_subscription_forum_mail_message', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => bbp_get_topic_title($topic_id),
                'TOPIC_LINK' => get_permalink($topic_id),
                'TOPIC_AUTHOR' => bbp_get_topic_author_display_name($topic_id),
                'TOPIC_CONTENT' => bbp_get_topic_content($topic_id),
                'FORUM_LINK' => bbp_get_forum_permalink($forum_id),
                'FORUM_TITLE' => bbp_get_forum_title($forum_id)
            ), $topic_id, $forum_id);

            if (gdbbx()->get('notify_subscribers_forum_override_shortcodes', 'bbpress')) {
                $start = do_shortcode($start);
                $tags['TOPIC_CONTENT'] = do_shortcode($tags['TOPIC_CONTENT']);
            }

            $message = d4p_replace_tags_in_content($start, $tags);
            $message = gdbbx_email_clean_content($message, apply_filters('gdbbx_cleanup_subscription_forum_mail_message_strip_tags', true));
        }

        return $message;
    }

    public function subscription_forum_mail_title($title, $topic_id, $forum_id) {
        $start = gdbbx()->get('notify_subscribers_forum_override_subject', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('gdbbx_tags_subscription_forum_mail_title', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => strip_tags(bbp_get_topic_title($topic_id)),
                'FORUM_TITLE' => strip_tags(bbp_get_forum_title($forum_id))
            ), $topic_id, $forum_id);

            $title = d4p_replace_tags_in_content($start, $tags);
            $title = gdbbx_email_clean_content($title);
        }

        return $title;
    }

    public function new_topic_moderators_mail_message($message, $topic_id, $forum_id) {
        $start = gdbbx()->get('notify_moderators_topic_content', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('gdbbx_tags_new_topic_moderators_mail_message', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => strip_tags(bbp_get_topic_title($topic_id)),
                'TOPIC_LINK' => get_permalink($topic_id),
                'TOPIC_AUTHOR' => bbp_get_topic_author_display_name($topic_id),
                'TOPIC_CONTENT' => bbp_get_topic_content($topic_id),
                'FORUM_TITLE' => bbp_get_forum_title($forum_id),
                'FORUM_LINK' => get_permalink($forum_id)
            ), $topic_id, $forum_id);

            if (gdbbx()->get('notify_moderators_topic_shortcodes', 'bbpress')) {
                $start = do_shortcode($start);
                $tags['TOPIC_CONTENT'] = do_shortcode($tags['TOPIC_CONTENT']);
            }

            $message = d4p_replace_tags_in_content($start, $tags);
            $message = gdbbx_email_clean_content($message, apply_filters('gdbbx_cleanup_new_topic_moderators_mail_message_strip_tags', true));
        }

        return $message;
    }

    public function new_topic_moderators_mail_title($title, $topic_id, $forum_id) {
        $start = gdbbx()->get('notify_moderators_topic_subject', 'bbpress');

        if ($start != '') {
            $tags = apply_filters('gdbbx_tags_new_topic_moderators_mail_title', array(
                'BLOG_NAME' => get_option('blogname'),
                'TOPIC_TITLE' => strip_tags(bbp_get_topic_title($topic_id)),
                'FORUM_TITLE' => strip_tags(bbp_get_forum_title($forum_id))
            ), $topic_id, $forum_id);

            $title = d4p_replace_tags_in_content($start, $tags);
            $title = gdbbx_email_clean_content($title);
        }

        return $title;
    }
}
