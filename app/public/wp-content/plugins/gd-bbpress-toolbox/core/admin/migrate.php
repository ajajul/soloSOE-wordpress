<?php

if (!defined('ABSPATH')) { exit; }

function gdbbx_settings_migration() {
    $_save = array();

    // views //
    if (isset(gdbbx()->temp['tools']['view_newposts_active'])) {
        foreach (gdbbx()->temp['tools'] as $key => $value) {
            if (substr($key, 0, 5) == 'view_') {
                $new = str_replace('view_', 'custom-views__', $key);
                gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
            }
        }

        $_save[] = 'features';
    }

    // mime-types //
    if (isset(gdbbx()->temp['tools']['extra_mime_types'])) {
        gdbbx()->set('mime-types__list', gdbbx()->temp['tools']['extra_mime_types'], 'features');

        $_save[] = 'features';
    }

    // buddypress //
    if (isset(gdbbx()->temp['bbpress']['disable_buddypress_profile_override'])) {
        gdbbx()->set('disable_profile_override', gdbbx()->temp['bbpress']['disable_buddypress_profile_override'], 'buddypress');

        $_save[] = 'buddypress';
    }

    // clickable //
    if (isset(gdbbx()->temp['bbpress']['disable_make_clickable_topic'])) {
        $list = array('disable_make_clickable_topic', 'disable_make_clickable_reply', 'remove_clickable_urls', 'remove_clickable_ftps', 'remove_clickable_emails', 'remove_clickable_mentions');

        foreach ($list as $key) {
            gdbbx()->set('clickable__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // privacy //
    if (isset(gdbbx()->temp['privacy']['disable_ip_logging'])) {
        $list = array('disable_ip_logging', 'disable_ip_display');

        foreach ($list as $key) {
            gdbbx()->set('privacy__'.$key, gdbbx()->temp['privacy'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // objects //
    if (isset(gdbbx()->temp['tools']['add_forum_features'])) {
        $list = array('add_forum_features', 'add_topic_features', 'add_reply_features');

        foreach ($list as $key) {
            gdbbx()->set('objects__'.$key, gdbbx()->temp['tools'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // publish //
    if (isset(gdbbx()->temp['bbpress']['bbp_is_site_public'])) {
        $list = array('bbp_is_site_public');

        foreach ($list as $key) {
            gdbbx()->set('publish__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // editor //
    if (isset(gdbbx()->temp['tools']['editor_topic_tinymce'])) {
        $list = array('editor_topic_tinymce', 'editor_topic_teeny', 'editor_topic_media_buttons', 'editor_topic_wpautop', 'editor_topic_quicktags', 'editor_topic_textarea_rows', 'editor_reply_tinymce', 'editor_reply_teeny', 'editor_reply_media_buttons', 'editor_reply_wpautop', 'editor_reply_quicktags', 'editor_reply_textarea_rows');

        foreach ($list as $key) {
            $new = str_replace('editor_', 'editor__', $key);
            gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
        }

        $load = gdbbx()->temp['tools']['editor_reply_active'] || gdbbx()->temp['tools']['editor_topic_active'];
        gdbbx()->set('editor', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // thanks //
    if (isset(gdbbx()->temp['thanks']['active'])) {
        $list = array('removal', 'topic', 'reply', 'allow_super_admin', 'allow_roles', 'limit_display', 'display_date', 'notify_active', 'notify_shortcodes', 'notify_content', 'notify_subject');

        foreach ($list as $key) {
            gdbbx()->set('thanks__'.$key, gdbbx()->temp['thanks'][$key], 'features');
        }

        $load = gdbbx()->temp['thanks']['active'];
        gdbbx()->set('thanks', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // protect-revisions //
    if (isset(gdbbx()->temp['bbpress']['revisions_reply_protection_active'])) {
        $list = array('revisions_reply_protection_author', 'revisions_reply_protection_topic_author', 'revisions_reply_protection_super_admin', 'revisions_reply_protection_roles', 'revisions_reply_protection_visitor');

        foreach ($list as $key) {
            $new = str_replace('revisions_reply_protection_', 'protect-revisions__allow_', $key);
            gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
        }

        $load = gdbbx()->temp['bbpress']['revisions_reply_protection_active'];
        gdbbx()->set('protect-revisions', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // admin-access //
    if (isset(gdbbx()->temp['tools']['admin_disable_active'])) {
        gdbbx()->set('admin-access__disable_roles', gdbbx()->temp['thanks']['admin_disable_roles'], 'features');

        $load = gdbbx()->temp['tools']['admin_disable_active'];
        gdbbx()->set('admin-access', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // tweaks //
    if (isset(gdbbx()->temp['bbpress']['topic_load_search_for_all_topics'])) {
        $list = array('topic_load_search_for_all_topics', 'forum_load_search_for_all_forums', 'fix_404_headers_error', 'remove_private_title_prefix',  'participant_media_library_upload',  'kses_allowed_override' => 'bbpress', 'disable_bbpress_breadcrumbs',  'title_length_override',  'title_length_value', 'apply_fitvids_to_content');

        foreach ($list as $key) {
            gdbbx()->set('tweaks__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // profiles //
    if (isset(gdbbx()->temp['bbpress']['user_profile_hide_from_visitors'])) {
        $list = array('user_profile_hide_from_visitors', 'user_profile_extras_display', 'user_profile_extras_actions', 'user_profile_extras_private');

        foreach ($list as $key) {
            $new = str_replace('user_profile_', 'profiles__', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // topics //
    if (isset(gdbbx()->temp['bbpress']['new_topic_minmax_active'])) {
        $list = array('new_topic_minmax_active', 'new_topic_min_title_length', 'new_topic_min_content_length', 'new_topic_max_title_length', 'new_topic_max_content_length', 'enable_lead_topic', 'enable_topic_reversed_replies', 'forum_list_topic_thumbnail');

        foreach ($list as $key) {
            gdbbx()->set('topics__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // replies //
    if (isset(gdbbx()->temp['bbpress']['new_reply_minmax_active'])) {
        $list = array('new_reply_minmax_active', 'new_reply_min_title_length', 'new_reply_min_content_length', 'new_reply_max_title_length', 'new_reply_max_content_length', 'tags_in_reply_form_only_for_author', 'reply_titles');

        foreach ($list as $key) {
            gdbbx()->set('replies__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // topic-actions //
    if (isset(gdbbx()->temp['bbpress']['topic_links_remove_merge'])) {
        gdbbx()->set('topic-actions__merge', gdbbx()->temp['bbpress']['topic_links_remove_merge'] ? 'hide' : 'header', 'features');
        gdbbx()->set('topic-actions__edit', gdbbx()->temp['bbpress']['topic_links_edit_footer'] ? 'footer' : 'header', 'features');
        gdbbx()->set('topic-actions__reply', gdbbx()->temp['bbpress']['topic_links_reply_footer'] ? 'footer' : 'header', 'features');

        if (gdbbx()->temp['bbpress']['topic_single_copy_active']) {
            gdbbx()->set('topic-actions__duplicate', gdbbx()->temp['bbpress']['topic_single_copy_location'] == 'footer' ? 'footer' : 'header', 'features');
        } else {
            gdbbx()->set('topic-actions__duplicate', 'hide', 'features');
        }

        gdbbx()->set('topic-actions__lock', gdbbx()->temp['lock']['button_topic_lock_location'] == 'footer' ? 'footer' : 'header', 'features');
        gdbbx()->set('topic-actions__report', gdbbx()->temp['report']['location'] == 'footer' ? 'footer' : 'header', 'features');
        gdbbx()->set('topic-actions__thanks', gdbbx()->temp['thanks']['location'] == 'footer' ? 'footer' : 'header', 'features');
        gdbbx()->set('topic-actions__quote', gdbbx()->temp['tools']['quote_location'] == 'footer' ? 'footer' : 'header', 'features');

        $_save[] = 'features';
    }

    // reply-actions //
    if (isset(gdbbx()->temp['bbpress']['reply_links_remove_split'])) {
        gdbbx()->set('reply-actions__split', gdbbx()->temp['bbpress']['reply_links_remove_split'] ? 'hide' : 'header', 'features');
        gdbbx()->set('reply-actions__edit', gdbbx()->temp['bbpress']['reply_links_edit_footer'] ? 'footer' : 'header', 'features');
        gdbbx()->set('reply-actions__reply', gdbbx()->temp['bbpress']['reply_links_reply_footer'] ? 'footer' : 'header', 'features');

        gdbbx()->set('reply-actions__report', gdbbx()->temp['report']['location'] == 'footer' ? 'footer' : 'header', 'features');
        gdbbx()->set('reply-actions__thanks', gdbbx()->temp['thanks']['location'] == 'footer' ? 'footer' : 'header', 'features');
        gdbbx()->set('reply-actions__quote', gdbbx()->temp['tools']['quote_location'] == 'footer' ? 'footer' : 'header', 'features');

        $_save[] = 'features';
    }

    // icons //
    if (isset(gdbbx()->temp['bbpress']['forum_mark_stick'])) {
        $list = array('forum_mark_stick', 'forum_mark_lock', 'forum_mark_replied', 'private_topics_icon');

        foreach ($list as $key) {
            gdbbx()->set('icons__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // forum-index //
    if (isset(gdbbx()->temp['bbpress']['forum_load_welcome_front'])) {
        foreach (gdbbx()->temp['bbpress'] as $key => $value) {
            if (strpos($key, 'forum_load_') === 0) {
                $new = str_replace('forum_load_', 'forum-index__', $key);
                gdbbx()->set($new, $value, 'features');
            }
        }

        $load = gdbbx()->temp['bbpress']['forum_load_welcome_front'] || gdbbx()->temp['bbpress']['forum_load_statistics_front'];
        gdbbx()->set('forum-index', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // disable-rss //
    if (isset(gdbbx()->temp['disable_rss']['active'])) {
        foreach (gdbbx()->temp['disable_rss'] as $key => $value) {
            if ($key != 'active') {
                gdbbx()->set('disable-rss__'.$key, $value, 'features');
            }
        }

        $load = gdbbx()->temp['disable_rss']['active'];
        gdbbx()->set('disable-rss', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // visitors-redirect //
    if (isset(gdbbx()->temp['lock']['redirect_for_visitors'])) {
        $list = array('redirect_for_visitors', 'redirect_for_visitors_url', 'redirect_hidden_forums', 'redirect_hidden_forums_url', 'redirect_private_forums', 'redirect_private_forums_url', 'redirect_blocked_users', 'redirect_blocked_users_url');

        foreach ($list as $key) {
            $new = str_replace('redirect_', 'visitors-redirect__', $key);
            gdbbx()->set($new, gdbbx()->temp['lock'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // toolbar //
    if (isset(gdbbx()->temp['tools']['toolbar_active'])) {
        $list = array('toolbar_super_admin', 'toolbar_visitor', 'toolbar_roles', 'toolbar_title', 'toolbar_information');

        foreach ($list as $key) {
            $new = str_replace('toolbar_', 'toolbar__', $key);
            gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
        }

        $load = gdbbx()->temp['tools']['toolbar_active'];
        gdbbx()->set('toolbar', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // quote //
    if (isset(gdbbx()->temp['tools']['quote_active'])) {
        $list = array('quote_method', 'quote_super_admin', 'quote_visitor', 'quote_roles', 'quote_full_content');

        foreach ($list as $key) {
            $new = str_replace('quote_', 'quote__', $key);
            gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
        }

        $load = gdbbx()->temp['tools']['quote_active'];
        gdbbx()->set('quote', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // users-stats //
    if (isset(gdbbx()->temp['tools']['users_stats_active'])) {
        $list = array('users_stats_super_admin', 'users_stats_visitor', 'users_stats_roles', 'users_stats_show_registration_date', 'users_stats_show_topics', 'users_stats_show_replies', 'users_stats_show_thanks_given', 'users_stats_show_thanks_received');

        foreach ($list as $key) {
            $new = str_replace('users_stats_', 'users-stats__', $key);
            gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
        }

        $load = gdbbx()->temp['tools']['users_stats_active'];
        gdbbx()->set('users-stats', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // admin-widgets //
    if (isset(gdbbx()->temp['tools']['dashboard_widget_activity'])) {
        gdbbx()->set('admin-widgets__activity', gdbbx()->temp['tools']['dashboard_widget_activity'], 'features');
        gdbbx()->set('admin-widgets__online', gdbbx()->temp['online']['dashboard_widget'], 'features');

        $load = gdbbx()->temp['tools']['dashboard_widget_activity'] || gdbbx()->temp['online']['dashboard_widget'];
        gdbbx()->set('admin-widgets', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // canned-replies //
    if (isset(gdbbx()->temp['canned']['active'])) {
        foreach (gdbbx()->temp['canned'] as $key => $value) {
            if ($key != 'active') {
                gdbbx()->set('canned-replies__'.$key, $value, 'features');
            }
        }

        $load = gdbbx()->temp['canned']['active'];
        gdbbx()->set('canned-replies', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // lock-forums //
    if (isset(gdbbx()->temp['lock']['topic_form_locked'])) {
        foreach (gdbbx()->temp['lock'] as $key => $value) {
            gdbbx()->set('lock-forums__'.$key, $value, 'features');
        }

        $_save[] = 'features';
    }

    // signatures //
    if (isset(gdbbx()->temp['tools']['signature_active'])) {
        $list = array('signature_active', 'signature_scope', 'signature_limiter', 'signature_length', 'signature_super_admin', 'signature_roles', 'signature_edit_super_admin', 'signature_edit_roles', 'signature_editor', 'signature_enhanced_active', 'signature_enhanced_method', 'signature_enhanced_super_admin', 'signature_enhanced_roles', 'signature_process_smilies', 'signature_process_chars', 'signature_process_autop');

        foreach ($list as $key) {
            $new = str_replace('signature_', 'signatures__', $key);
            gdbbx()->set($new, gdbbx()->temp['tools'][$key], 'features');
        }

        $load = gdbbx()->temp['tools']['signature_active'];
        gdbbx()->set('signatures', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // seo-tweaks //
    if (isset(gdbbx()->temp['bbpress']['nofollow_topic_content'])) {
        $list = array('nofollow_topic_content', 'nofollow_reply_content', 'nofollow_topic_author', 'nofollow_reply_author');

        foreach ($list as $key) {
            gdbbx()->set('seo-tweaks__'.$key, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // report //
    if (isset(gdbbx()->temp['report']['active'])) {
        foreach (gdbbx()->temp['report'] as $key => $value) {
            if ($key != 'active') {
                gdbbx()->set('report__'.$key, $value, 'features');
            }
        }

        $load = gdbbx()->temp['report']['active'];
        gdbbx()->set('report', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // private-topics //
    if (isset(gdbbx()->temp['bbpress']['private_topics'])) {
        $list = array('private_topics_super_admin', 'private_topics_roles', 'private_topics_visitor', 'private_topics_default', 'private_topics_moderators_can_read');

        foreach ($list as $key) {
            $new = str_replace('private_topics_', 'private-topics__', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $load = gdbbx()->temp['bbpress']['private_topics'];
        gdbbx()->set('private-topics', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // private-replies //
    if (isset(gdbbx()->temp['bbpress']['private_replies'])) {
        $list = array('private_topics_super_admin', 'private_topics_roles', 'private_topics_visitor', 'private_topics_default', 'private_topics_moderators_can_read');

        foreach ($list as $key) {
            $new = str_replace('private_replies_', 'private-replies__', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $load = gdbbx()->temp['bbpress']['private_replies'];
        gdbbx()->set('private-replies', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // auto-close-topics //
    if (isset(gdbbx()->temp['bbpress']['topic_auto_close_after_status'])) {
        $list = array('topic_auto_close_after_active', 'topic_auto_close_after_notice', 'topic_auto_close_after_days', 'topic_auto_close_after_notify_author', 'topic_auto_close_after_notify_subscribers');

        foreach ($list as $key) {
            $new = str_replace('topic_auto_close_after_', 'auto-close-topics__', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $load = gdbbx()->temp['bbpress']['topic_auto_close_after_status'];
        gdbbx()->set('auto-close-topics', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // auto-close-topics - notify //
    if (isset(gdbbx()->temp['bbpress']['notify_on_topic_auto_close_active'])) {
        $list = array('notify_on_topic_auto_close_active', 'notify_on_topic_auto_close_shortcodes', 'notify_on_topic_auto_close_content', 'notify_on_topic_auto_close_subject');

        foreach ($list as $key) {
            $new = str_replace('notify_on_topic_auto_close_', 'auto-close-topics__notify_', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    // close-topic-control //
    if (isset(gdbbx()->temp['bbpress']['reply_close_topic_checkbox_active'])) {
        $list = array('reply_close_topic_checkbox_topic_author', 'reply_close_topic_checkbox_super_admin', 'reply_close_topic_checkbox_roles', 'reply_close_topic_checkbox_form_position', 'reply_close_topic_checkbox_notify_author', 'reply_close_topic_checkbox_notify_subscribers');

        foreach ($list as $key) {
            $new = str_replace('reply_close_topic_checkbox_', 'close-topic-control__', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $load = gdbbx()->temp['bbpress']['reply_close_topic_checkbox_active'];
        gdbbx()->set('close-topic-control', $load, 'load');

        $_save[] = 'features';
        $_save[] = 'load';
    }

    // close-topic-control - notify //
    if (isset(gdbbx()->temp['bbpress']['notify_on_topic_checkbox_close_active'])) {
        $list = array('notify_on_topic_checkbox_close_active', 'notify_on_topic_checkbox_close_shortcodes', 'notify_on_topic_checkbox_close_content', 'notify_on_topic_checkbox_close_subject');

        foreach ($list as $key) {
            $new = str_replace('notify_on_topic_checkbox_close_', 'close-topic-control__notify_', $key);
            gdbbx()->set($new, gdbbx()->temp['bbpress'][$key], 'features');
        }

        $_save[] = 'features';
    }

    $_save = array_unique($_save);

    foreach ($_save as $key) {
        gdbbx()->save($key);
    }
}
