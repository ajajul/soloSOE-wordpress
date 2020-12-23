<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_mailer_core {
    private $_override;
    private $_notifications;

    public function __construct() {
        if (gdbbx()->get('notify_subscribers_sender_active', 'bbpress')) {
            add_action('bbp_pre_notify_subscribers', array($this, 'subscription_notify_hook_sender'));
            add_action('bbp_pre_notify_forum_subscribers', array($this, 'subscription_notify_hook_sender'));
            add_action('bbp_pre_notify_topic_edit_subscribers', array($this, 'subscription_notify_hook_sender'));
            add_action('bbp_pre_notify_reply_edit_subscribers', array($this, 'subscription_notify_hook_sender'));
            add_action('bbp_pre_notify_new_topic_moderators', array($this, 'subscription_notify_hook_sender'));
            add_action('bbp_pre_notify_topic_auto_close', array($this, 'subscription_notify_hook_sender'));
            add_action('bbp_pre_notify_topic_manual_close', array($this, 'subscription_notify_hook_sender'));

            add_action('bbp_post_notify_subscribers', array($this, 'subscription_notify_unhook_sender'));
            add_action('bbp_post_notify_forum_subscribers', array($this, 'subscription_notify_unhook_sender'));
            add_action('bbp_post_notify_topic_edit_subscribers', array($this, 'subscription_notify_unhook_sender'));
            add_action('bbp_post_notify_reply_edit_subscribers', array($this, 'subscription_notify_unhook_sender'));
            add_action('bbp_post_notify_new_topic_moderators', array($this, 'subscription_notify_unhook_sender'));
            add_action('bbp_post_notify_topic_auto_close', array($this, 'subscription_notify_unhook_sender'));
            add_action('bbp_post_notify_topic_manual_close', array($this, 'subscription_notify_unhook_sender'));
        }

        if (gdbbx()->get('topic_notification_on_edit', 'bbpress')) {
            add_action('bbp_edit_topic_post_extras', array($this, 'notify_subscribers_on_topic_edit'));
            add_action('bbp_theme_before_topic_form_submit_wrapper', array($this, 'topic_notify_on_update_checkbox'));
        }

        if (gdbbx()->get('reply_notification_on_edit', 'bbpress')) {
            add_action('bbp_edit_reply_post_extras', array($this, 'notify_subscribers_on_reply_edit'));
            add_action('bbp_theme_before_reply_form_submit_wrapper', array($this, 'reply_notify_on_update_checkbox'));
        }

        if (gdbbx()->get('new_topic_notification_keymaster', 'bbpress') || gdbbx()->get('new_topic_notification_moderator', 'bbpress')) {
            add_action('bbp_new_topic', array($this, 'notify_moderators_on_new_topic'), 15, 2);
        }

        $this->_override = new gdbbx_mailer_override();
        $this->_notifications = new gdbbx_mailer_notifications();
    }

    /** @return gdbbx_mailer_override */
    public function override() {
        return $this->_override;
    }

    /** @return gdbbx_mailer_notifications */
    public function notifications() {
        return $this->_notifications;
    }

    public function notify_subscribers_on_reply_edit($reply_id) {
        $this->notifications()->reply_subscribers_on_edit($reply_id);
    }

    public function notify_subscribers_on_topic_edit($topic_id) {
        $this->notifications()->topic_subscribers_on_edit($topic_id);
    }

    public function notify_moderators_on_new_topic($topic_id = 0, $forum_id = 0) {
        $this->notifications()->moderators_on_new_topic($topic_id, $forum_id);
    }

    public function subscription_notify_hook_sender() {
        add_filter('wp_mail_from', array($this, 'mail_from_email'), 10000000);
        add_filter('wp_mail_from_name', array($this, 'mail_from_name'), 10000000);
    }

    public function subscription_notify_unhook_sender() {
        remove_filter('wp_mail_from', array($this, 'mail_from_email'), 10000000);
        remove_filter('wp_mail_from_name', array($this, 'mail_from_name'), 10000000);
    }

    public function mail_from_email($email) {
        $start = gdbbx()->get('notify_subscribers_sender_email', 'bbpress');

        if ($start != '') {
            $email = $start;
        }

        return $email;
    }

    public function mail_from_name($name) {
        $start = gdbbx()->get('notify_subscribers_sender_name', 'bbpress');

        if ($start != '') {
            $name = $start;
        }

        return $name;
    }

    public function topic_notify_on_update_checkbox() {
        if (bbp_is_topic_edit()) {
            include(gdbbx_get_template_part('gdbbx-form-notify-on-topic-edit.php'));
        }
    }

    public function reply_notify_on_update_checkbox() {
        if (bbp_is_reply_edit()) {
            include(gdbbx_get_template_part('gdbbx-form-notify-on-reply-edit.php'));
        }
    }

    public function topic_revision_log($topic_id = 0) {
        $topic_id = bbp_get_topic_id($topic_id);
        $revision_log = bbp_get_topic_raw_revision_log($topic_id);

        if (empty($topic_id) || empty($revision_log) || !is_array($revision_log)) {
            return __("No log saved.", "gd-bbpress-toolbox");
        }

        $revisions = bbp_get_topic_revisions($topic_id);
        if (empty($revisions)) {
            return __("No log saved.", "gd-bbpress-toolbox");
        }

        $r = '';

        foreach ((array)$revisions as $revision) {
            $reason = '';
            if (!empty($revision_log[$revision->ID])) {
                $reason = $revision_log[$revision->ID]['reason'];
            }

            $author = bbp_get_topic_author_display_name($revision->ID);

            if (!empty($reason)) {
                $r.= sprintf(__("This topic was modified by %s. Reason: %s", "gd-bbpress-toolbox"), $author, esc_html($reason))."\n";
            }
        }

        if (empty($r)) {
            return __("No log saved.", "gd-bbpress-toolbox");
        }

        return $r;
    }

    public function reply_revision_log($reply_id = 0) {
        $reply_id = bbp_get_reply_id($reply_id);
        $revision_log = bbp_get_reply_raw_revision_log($reply_id);

        if (empty($reply_id) || empty($revision_log) || !is_array($revision_log)) {
            return __("No log saved.", "gd-bbpress-toolbox");
        }

        $revisions = bbp_get_reply_revisions($reply_id);
        if (empty($revisions)) {
            return __("No log saved.", "gd-bbpress-toolbox");
        }

        $r = '';

        foreach ((array)$revisions as $revision) {
            $reason = '';

            if (!empty($revision_log[$revision->ID])) {
                $reason = $revision_log[$revision->ID]['reason'];
            }

            $author = bbp_get_reply_author_display_name($revision->ID);

            if (!empty($reason)) {
                $r.= sprintf(__("This reply was modified by %s. Reason: %s", "gd-bbpress-toolbox"), $author, esc_html($reason))."\n";
            }
        }

        if (empty($r)) {
            return __("No log saved.", "gd-bbpress-toolbox");
        }

        return $r;
    }

    public function get_topic_content($topic_id) {
        remove_all_filters('bbp_get_topic_content');
        remove_all_filters('bbp_get_topic_title');
        remove_all_filters('bbp_get_forum_title');
        remove_all_filters('the_title');

        $topic_title = gdbbx_email_clean_content(bbp_get_topic_title($topic_id));
        $forum_title = gdbbx_email_clean_content(bbp_get_forum_title($topic_id));
        $topic_content = gdbbx_email_clean_content(bbp_get_topic_content($topic_id));
        $blog_name = gdbbx_email_clean_content(get_option('blogname'));

        return compact('topic_title', 'topic_content', 'blog_name', 'forum_title');
    }

    public function get_reply_content($reply_id, $topic_id) {
        remove_all_filters('bbp_get_topic_content');
        remove_all_filters('bbp_get_reply_content');
        remove_all_filters('bbp_get_topic_title');
        remove_all_filters('bbp_get_reply_title');
        remove_all_filters('bbp_get_forum_title');
        remove_all_filters('the_title');

        $forum_title = gdbbx_email_clean_content(bbp_get_forum_title($topic_id));
        $topic_title = gdbbx_email_clean_content(bbp_get_topic_title($topic_id));
        $reply_title = gdbbx_email_clean_content(gdbbx_get_reply_title($reply_id));
        $reply_content = gdbbx_email_clean_content(bbp_get_reply_content($reply_id));
        $blog_name = gdbbx_email_clean_content(get_option('blogname'));

        return compact('topic_title', 'reply_title', 'reply_content', 'blog_name', 'forum_title');
    }

    public function get_topic_author_and_subscribers($topic_id, $filter, $_send_to_author = true, $_send_to_subscribers = true, $option_key = '') {
        $user_ids = array();
        $emails = array();
        $author = bbp_get_topic_author_id($topic_id);

        if ($_send_to_author && (empty($option_key) || gdbbx_user($author)->get($option_key))) {
            $user_ids[] = $author;
        }

        if ($_send_to_subscribers) {
            $user_ids = array_merge($user_ids, bbp_get_topic_subscribers($topic_id));
        }

        $user_ids = apply_filters($filter, $user_ids);

        if (empty($user_ids)) {
            return array();
        }

        $user_ids = array_unique($user_ids);
        $user_ids = array_filter($user_ids);

        foreach ((array)$user_ids as $user_id) {
            if ((int)$user_id === (int)get_current_user_id() || $user_id == 0) {
                continue;
            }

            $user = get_userdata($user_id);

            if ($user) {
                $emails[] = $user->user_email;
            }
        }

        return array('user_ids' => $user_ids, 'emails' => $emails);
    }
}

/** @return gdbbx_mailer_core  */
function gdbbx_module_mailer() {
    return gdbbx_loader()->modules['mailer'];
}
