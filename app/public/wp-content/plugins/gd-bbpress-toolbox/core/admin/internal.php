<?php

use Dev4Press\Plugin\GDBBX\Basic\Features;

if (!defined('ABSPATH')) { exit; }

class gdbbx_admin_settings {
    private $settings;

    function __construct() {
        $this->init();
    }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function features_load() {
        $list = array();

        foreach ($this->settings as $block) {
            foreach ($block as $obj) {
                foreach ($obj['settings'] as $o) {
                    if ($o->type == 'load') {
                        $list[] = $o;
                    }
                }
            }
        }

        return $list;
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    private function init() {
        $_max_size_kb = gdbbx_attachments()->max_server_allowed();

        $this->settings = array(
            'files' => array(
                'loading_js' => array('name' => __("Additional Libiraries", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('settings', 'load_fitvids', __("FitVids", "gd-bbpress-toolbox"), __("Load FitVids library for making YouTube and Vimeo videos responsive. If you already load this library in some other way, disable this option to avoid duplication.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('load_fitvids'))
                )),
                'advanced_load' => array('name' => __("CSS and JS files loading", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('settings', 'load_always', __("Always Load", "gd-bbpress-toolbox"), __("If you use shortcodes to embed forums, and you rely on plugin to add JS and CSS, you also need to enable this option to skip checking for bbPress specific pages.", "gd-bbpress-toolbox").' '.__("This option is not needed anymore, but if you still have issues with loaded files, enable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('load_always'))
                ))
            ),
            'widgets' => array(
                'widgets' => array('name' => __("Plugin Widgets", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('widgets', 'widget_userprofile', __("User Profile", "gd-bbpress-toolbox"), __("Logged in user profile with useful links and stats.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_userprofile', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_usersthanks', __("Top Thanked Users", "gd-bbpress-toolbox"), __("Logged in user profile with useful links and stats.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_usersthanks', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_statistics', __("Statistics", "gd-bbpress-toolbox"), __("Enhanced list of important forum statistics.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_statistics', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_topicinfo', __("Topic Information", "gd-bbpress-toolbox"), __("Show information about the topic currently displayed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_topicinfo', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_foruminfo', __("Forum Information", "gd-bbpress-toolbox"), __("Show information about the forum currently displayed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_foruminfo', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_search', __("Search", "gd-bbpress-toolbox"), __("Expanded search widget with option to search current forum only.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_search', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_onlineusers', __("Online Users", "gd-bbpress-toolbox"), __("Show the list of users currently online.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_onlineusers', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_newposts', __("New posts List", "gd-bbpress-toolbox"), __("List of new topics or topics with new replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_newposts', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'widget_topicsviews', __("Topics Views List", "gd-bbpress-toolbox"), __("Selectable list of topics views.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('widget_topicsviews', 'widgets'), null, array(), array('label' => __("Enable Widget", "gd-bbpress-toolbox")))
                )),
                'default_widgets' => array('name' => __("Default bbPress Widgets", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('widgets', 'default_disable_recenttopics', __("Recent Topics", "gd-bbpress-toolbox"), __("If you use this plugin 'New Posts List' widget, you can disable default one.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('default_disable_recenttopics', 'widgets'), null, array(), array('label' => __("Disable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'default_disable_recentreplies', __("Recent Replies", "gd-bbpress-toolbox"), __("If you use this plugin 'New Posts List' widget, you can disable default one.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('default_disable_recentreplies', 'widgets'), null, array(), array('label' => __("Disable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'default_disable_topicviewslist', __("Topics Views List", "gd-bbpress-toolbox"), __("If you use this plugin 'Topics Views List' widget, you can disable default one.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('default_disable_topicviewslist', 'widgets'), null, array(), array('label' => __("Disable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'default_disable_login', __("Login", "gd-bbpress-toolbox"), __("If you use this plugin 'User Profile' widget, you can disable default one.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('default_disable_login', 'widgets'), null, array(), array('label' => __("Disable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'default_disable_search', __("Search", "gd-bbpress-toolbox"), __("If you use this plugin 'Search' widget, you can disable default one.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('default_disable_search', 'widgets'), null, array(), array('label' => __("Disable Widget", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('widgets', 'default_disable_stats', __("Statistics", "gd-bbpress-toolbox"), __("If you use this plugin 'Statistics' widget, you can disable default one.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('default_disable_stats', 'widgets'), null, array(), array('label' => __("Disable Widget", "gd-bbpress-toolbox")))
                ))
            ),
            'seo' => array(
                'head_title' => array('name' => __("Title Tag", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('seo', 'document_title_parts', __("Support for new themes", "gd-bbpress-toolbox"), __("Themes with the 'title-tag' support don't show the default bbPress generated TITLE tag. With this option, support for new themes is added.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('document_title_parts', 'seo'))
                )),
                'forums_seo' => array('name' => __("Forum", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('seo', 'override_forum_title_replace', __("Meta Title", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('override_forum_title_replace', 'seo'), null, array(), array('label' => __("Replace with Custom Text", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'override_forum_title_text', '', __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%', d4pSettingType::TEXT, gdbbx()->get('override_forum_title_text', 'seo')),
                    new d4pSettingElement('seo', 'meta_description_forum', __("Meta Description Tag", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('meta_description_forum', 'seo'))
                )),
                'topics_seo' => array('name' => __("Topic", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('seo', 'override_topic_title_replace', __("Meta Title", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('override_topic_title_replace', 'seo'), null, array(), array('label' => __("Replace with Custom Text", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'override_topic_title_text', '', __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_TITLE%, %FORUM_TITLE%', d4pSettingType::TEXT, gdbbx()->get('override_topic_title_text', 'seo')),
                    new d4pSettingElement('seo', 'override_topic_excerpt', __("Excerpt", "gd-bbpress-toolbox"), __("Use this only if you want to take private content into account or have extra control, or your SEO plugin has problems with getting proper excerpt.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('override_topic_excerpt', 'seo'), null, array(), array('label' => __("Override Default", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'override_topic_length', __("Excerpt Length", "gd-bbpress-toolbox"), '', d4pSettingType::NUMBER, gdbbx()->get('override_topic_length', 'seo')),
                    new d4pSettingElement('seo', 'private_topic_excerpt_replace', __("Private Topics Excerpt", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('private_topic_excerpt_replace', 'seo'), null, array(), array('label' => __("Replace with Custom Text", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'private_topic_excerpt_text', '', __("Private topic content will be replaced with this text. You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_TITLE%', d4pSettingType::TEXT, gdbbx()->get('private_topic_excerpt_text', 'seo')),
                    new d4pSettingElement('seo', 'meta_description_topic', __("Meta Description Tag", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('meta_description_topic', 'seo'))
                )),
                'replies_seo' => array('name' => __("Reply", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('seo', 'override_reply_title_replace', __("Meta Title", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('override_reply_title_replace', 'seo'), null, array(), array('label' => __("Replace with Custom Text", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'override_reply_title_text', '', __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %REPLY_TITLE%, %TOPIC_TITLE%, %FORUM_TITLE%', d4pSettingType::TEXT, gdbbx()->get('override_reply_title_text', 'seo')),
                    new d4pSettingElement('seo', 'override_reply_excerpt', __("Excerpt", "gd-bbpress-toolbox"), __("Use this only if you want to take private content into account or have extra control, or your SEO plugin has problems with getting proper excerpt.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('override_reply_excerpt', 'seo'), null, array(), array('label' => __("Override Default", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'override_reply_length', __("Excerpt Length", "gd-bbpress-toolbox"), '', d4pSettingType::NUMBER, gdbbx()->get('override_reply_length', 'seo')),
                    new d4pSettingElement('seo', 'private_reply_excerpt_replace', __("Private Reply Excerpt", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('private_reply_excerpt_replace', 'seo'), null, array(), array('label' => __("Replace with Custom Text", "gd-bbpress-toolbox"))),
                    new d4pSettingElement('seo', 'private_reply_excerpt_text', '', __("Private topic content will be replaced with this text. You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_TITLE%', d4pSettingType::TEXT, gdbbx()->get('private_reply_excerpt_text', 'seo')),
                    new d4pSettingElement('seo', 'meta_description_reply', __("Meta Description Tag", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('meta_description_reply', 'seo'))
                ))
            ),
            'notifications' => array(
                'notify_new' => array('name' => __("Notify when new topic is added", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'new_topic_notification_keymaster', __("Notify Keymasters", "gd-bbpress-toolbox"), __("When a new topic is added, keymasters will be notified.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('new_topic_notification_keymaster', 'bbpress')),
                    new d4pSettingElement('bbpress', 'new_topic_notification_moderator', __("Notify Moderators", "gd-bbpress-toolbox"), __("When a new topic is added, moderators will be notified.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('new_topic_notification_moderator', 'bbpress'))
                )),
                'notify_topic' => array('name' => __("Notify on Topic edit", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'topic_notification_on_edit', __("Include in edit form", "gd-bbpress-toolbox"), __("Plugin will add new block with checkboxes to send notifications to topic author and/or subscribers when the topic was edited.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('topic_notification_on_edit', 'bbpress'))
                )),
                'notify_reply' => array('name' => __("Notify on Reply edit", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'reply_notification_on_edit', __("Include in edit form", "gd-bbpress-toolbox"), __("Plugin will add new block with checkboxes to send notifications to reply author and/or topic subscribers when the reply was edited.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('reply_notification_on_edit', 'bbpress'))
                )),
                'notify_sender' => array('name' => __("Notifications Sender", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'notify_subscribers_sender_active', __("Modify notification sender", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_sender_active', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_sender_name', __("Sender name", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('notify_subscribers_sender_name', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_sender_email', __("Sender email", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('notify_subscribers_sender_email', 'bbpress')),
                ))
            ),
            'notify_templates_bbx' => array(
                'notify_on_topic_edit' => array('name' => __("Topic Edit Notify Subscribers", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'notify_subscribers_edit_active', __("Modify notification content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_edit_active', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_edit_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_edit_shortcodes', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_edit_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_EDITOR%, %TOPIC_AUTHOR%, %TOPIC_CONTENT%, %TOPIC_EDIT%, %TOPIC_LINK%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('notify_subscribers_edit_content', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_edit_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('notify_subscribers_edit_subject', 'bbpress'))
                )),
                'notify_on_reply_edit' => array('name' => __("Reply Edit Notify Subscribers", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'notify_subscribers_reply_edit_active', __("Modify notification content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_reply_edit_active', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_reply_edit_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_reply_edit_shortcodes', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_reply_edit_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_TITLE%, %REPLY_EDITOR%, %REPLY_CONTENT% %REPLY_AUTHOR%, %REPLY_EDIT%, %REPLY_LINK%, %REPLY_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('notify_subscribers_reply_edit_content', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_reply_edit_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %REPLY_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('notify_subscribers_reply_edit_subject', 'bbpress'))
                )),
                'notify_topic_mod' => array('name' => __("New Topic for Keymasters and Moderators", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'notify_moderators_topic_active', __("Modify notification content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_moderators_topic_active', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_moderators_topic_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_moderators_topic_shortcodes', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_moderators_topic_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %FORUM_LINK%, %TOPIC_AUTHOR%, %TOPIC_CONTENT%, %TOPIC_LINK%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('notify_moderators_topic_content', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_moderators_topic_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('notify_moderators_topic_subject', 'bbpress'))
                ))
            ),
            'notify_templates_bbp' => array(
                'notify_email' => array('name' => __("Topic Subscribe Notifications Email", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'notify_subscribers_override_active', __("Modify notification content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_override_active', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_override_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_override_shortcodes', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_override_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %REPLY_AUTHOR%, %REPLY_CONTENT%, %REPLY_TITLE%, %REPLY_LINK%, %TOPIC_AUTHOR%, %TOPIC_LINK%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('notify_subscribers_override_content', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_override_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('notify_subscribers_override_subject', 'bbpress'))
                )),
                'notify_forum' => array('name' => __("Forum Subscribe Notifications Email", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('bbpress', 'notify_subscribers_forum_override_active', __("Modify notification content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_forum_override_active', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_forum_override_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notify_subscribers_forum_override_shortcodes', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_forum_override_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %FORUM_LINK%, %TOPIC_AUTHOR%, %TOPIC_TITLE%, %TOPIC_LINK%, %TOPIC_CONTENT%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('notify_subscribers_forum_override_content', 'bbpress')),
                    new d4pSettingElement('bbpress', 'notify_subscribers_forum_override_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('notify_subscribers_forum_override_subject', 'bbpress'))
                ))
            ),
            'attachments_mime' => array(
                'mime' => array('name' => __("Basic Control", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'mime_types_limit_active', __("Filter by MIME Type", "gd-bbpress-toolbox"), __("If this option is active, only MIME Types selected below will be allowed to upload.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('mime_types_limit_active', 'attachments')),
                    new d4pSettingElement('attachments', 'mime_types_limit_display', __("Display allowed types", "gd-bbpress-toolbox"), __("If active, plugin will show list of allowed types in the upload form as notice.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('mime_types_limit_display', 'attachments'))
                )),
                'mime_list' => array('name' => __("MIME Types allowed to upload", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'mime_types_list', __("Allowed MIME Types", "gd-bbpress-toolbox"), __("List shows extensions allowed by WordPress, and if you hover over the names of the extensions you will see which MIME type they belong to.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('mime_types_list', 'attachments'), 'array', gdbbx_mime_types_list(), array('class' => 'gdbbx-bbcodes'))
                ))
            ),
            'attachments_advanced' => array(
                'errors' => array('name' => __("Errors Logging", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'log_upload_errors', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('log_upload_errors', 'attachments')),
                    new d4pSettingElement('attachments', 'errors_visible_to_admins', __("Visible to administrators", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('errors_visible_to_admins', 'attachments')),
                    new d4pSettingElement('attachments', 'errors_visible_to_moderators', __("Visible to moderators", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('errors_visible_to_moderators', 'attachments')),
                    new d4pSettingElement('attachments', 'errors_visible_to_author', __("Visible to author", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('errors_visible_to_author', 'attachments'))
                )),
                'files_list' => array('name' => __("Attachments List", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'hide_attachments_when_in_content', __("Hide files inserted into content", "gd-bbpress-toolbox"), __("If the attachment is inserted into content using [attachment] BBCode, it will be hidden from the list of attachments below the post.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('hide_attachments_when_in_content', 'attachments'))
                )),
                'forum_not_defined' => array('name' => __("Topic form integration", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'forum_not_defined', __("Forum not defined", "gd-bbpress-toolbox"), __("If the forum ID for the topic form can't be detected (the form is not part of the forum), the attachment form is not available by default. You can change that here, but be careful - if you use forum based attachments control, users may be able to upload files in the forum that you have disabled for attachments use.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('forum_not_defined', 'attachments'), 'array', $this->data_forum_not_defined())
                )),
                'upload_dir' => array('name' => __("Upload Directory", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("Read all the provided information first. Do not enable this option unless you are sure what it will do exactly.", "gd-bbpress-toolbox").$this->info_upload_dir(), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('attachments', 'upload_dir_override', __("Override upload directory", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('upload_dir_override', 'attachments')),
                    new d4pSettingElement('attachments', 'upload_dir_forums_base', __("Base directory name", "gd-bbpress-toolbox"), __("This will be used to format the directory name selected below. This has to be file system safe, slug string using alphanumeric characters only including dashes, with no spaces or special characters.", "gd-bbpress-toolbox"), d4pSettingType::SLUG, gdbbx()->get('upload_dir_forums_base', 'attachments')),
                    new d4pSettingElement('attachments', 'upload_dir_structure', __("Directory structure", "gd-bbpress-toolbox"), __("Selected format will be replaced with these values before upload.", "gd-bbpress-toolbox").$this->info_upload_dir_format(), d4pSettingType::SELECT, gdbbx()->get('upload_dir_structure', 'attachments'), 'array', $this->data_upload_dir_format())
                )),
                'bulk_download' => array('name' => __("Bulk Download", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'bulk_download', __("Bulk Download Link", "gd-bbpress-toolbox"), __("If the topic or reply has more then one attachment, you will be able to use the Link 'Download all attachments'.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bulk_download', 'attachments')),
                    new d4pSettingElement('attachments', 'bulk_download_listed', __("Only when listing attachments", "gd-bbpress-toolbox"), __("If enabled, Bulk Download link will be displayed only if the Attachments area is visible. If you enabled option to hide attachments that are added to the content, Attachments area might be hidden if no files are to be listed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bulk_download_listed', 'attachments')),
                    new d4pSettingElement('attachments', 'bulk_download_visitor', __("Available to visitors", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('bulk_download_visitor', 'attachments')),
                    new d4pSettingElement('attachments', 'bulk_download_roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('bulk_download_roles', 'attachments'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                )),
                'media_library' => array('name' => __("Media Library", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'hide_attachments_from_media_library', __("Hide files from Media Library", "gd-bbpress-toolbox"), __("Since all attachments are added to WordPress Media Library, they will show up in the media selection popups. If you want to avoid that, and hide attachments from showing in Media Library, you can enable this option - attachments will still use Media Library, but you will not see them when browsing media library.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('hide_attachments_from_media_library', 'attachments')),
                ))
            ),
            'attachments_integration' => array(
                'form_position' => array('name' => __("Form Position", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'form_position_topic', __("Topic Form", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('form_position_topic', 'attachments'), 'array', $this->data_form_position_topic()),
                    new d4pSettingElement('attachments', 'form_position_reply', __("Reply Form", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('form_position_reply', 'attachments'), 'array', $this->data_form_position_reply())
                )),
                'file_list' => array('name' => __("Files List", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'files_list_position', __("Embed Position", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('files_list_position', 'attachments'), 'array', $this->data_files_position_topic()),
                    new d4pSettingElement('', '', __("For visitors", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('attachments', 'hide_from_visitors', __("Hide attachments list", "gd-bbpress-toolbox"), __("If enabled, only logged in users will be able to see attachments list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('hide_from_visitors', 'attachments')),
                    new d4pSettingElement('attachments', 'preview_for_visitors', __("Show previews only", "gd-bbpress-toolbox"), __("If enabled, attachments list will be visible. But, only file names and image thumbnails will be visible, no links will be included", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('preview_for_visitors', 'attachments')),
                    new d4pSettingElement('', '', __("Extra settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('attachments', 'file_target_blank', __("Link opens blank page", "gd-bbpress-toolbox"), __("All displayed attachments links will lead to open blank page to display attachment (for images or documents).", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('file_target_blank', 'attachments')),
                    new d4pSettingElement('attachments', 'download_link_attribute', __("Download Attribute", "gd-bbpress-toolbox"), __("Each link will have download attribute set, and for supported browser will force click on the link to download the file.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('download_link_attribute', 'attachments')),
                )),
                'icons' => array('name' => __("Attachment Icons", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'attachment_icon', __("Attachment Icon", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('attachment_icon', 'attachments')),
                    new d4pSettingElement('attachments', 'attachment_icons', __("File Type Icons", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('attachment_icons', 'attachments'))
                )),
                'featured' => array('name' => __("Auto-generate featured image", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'topic_featured_image', __("For Topic", "gd-bbpress-toolbox"), __("First image uploaded to topic, will be set as featured (if topic has no featured image set already).", "gd-bbpress-toolbox").' <strong>'.__("For this to work, theme must have Post Thumbnails support.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('topic_featured_image', 'attachments')),
                    new d4pSettingElement('attachments', 'reply_featured_image', __("For Reply", "gd-bbpress-toolbox"), __("First image uploaded to reply, will be set as featured (if reply has no featured image set already).", "gd-bbpress-toolbox").' <strong>'.__("For this to work, theme must have Post Thumbnails support.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('reply_featured_image', 'attachments'))
                ))
            ),
            'attachments_images' => array(
                'thumbnails' => array('name' => __("Show as Thumbnails", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'image_thumbnail_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('image_thumbnail_active', 'attachments'))
                )),
                'thumbnails_display' => array('name' => __("Display control", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'image_thumbnail_size', __("Thumbnails Size", "gd-bbpress-toolbox"), __("Changing thumbnails size affects only new image attachments. To use new size for old attachments, resize them using Regenerate Thumbnails plugin.", "gd-bbpress-toolbox"), d4pSettingType::X_BY_Y, gdbbx()->get('image_thumbnail_size', 'attachments')),
                    new d4pSettingElement('attachments', 'image_thumbnail_caption', __("With caption", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('image_thumbnail_caption', 'attachments')),
                    new d4pSettingElement('attachments', 'image_thumbnail_inline', __("Inline", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('image_thumbnail_inline', 'attachments'))
                )),
                'thumbnails_attr' => array('name' => __("Thumbnail attributes", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'image_thumbnail_css', __("CSS class", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('image_thumbnail_css', 'attachments')),
                    new d4pSettingElement('attachments', 'image_thumbnail_rel', __("REL attribute", "gd-bbpress-toolbox"), __("You can use these tags", "gd-bbpress-toolbox").' %ID%, %TOPIC%', d4pSettingType::TEXT, gdbbx()->get('image_thumbnail_rel', 'attachments'))
                ))
            ),
            'attachments' => array(
                'main_files' => array('name' => __("Basic Settings", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'attachments_active', __("Attachments active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('attachments_active', 'attachments')),
                    new d4pSettingElement('', '', __("Attachments Interface", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('attachments', 'validation_active', __("Enhanced Interface", "gd-bbpress-toolbox"), __("Enables validation of attachments added by user: size and file type allowed, and will not allow form to submit if validation fails. Uploaded file (image) preview and validation works only with modern browsers with HTML5 support.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('validation_active', 'attachments')),
                    new d4pSettingElement('', '', __("Attachments Activation", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('attachments', 'topics', __("For Topics", "gd-bbpress-toolbox"), __("Add attachments upload to topic form.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('topics', 'attachments')),
                    new d4pSettingElement('attachments', 'replies', __("For Replies", "gd-bbpress-toolbox"), __("Add attachments upload to reply form.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('replies', 'attachments'))
                )),
                'attach_enhanced' => array('name' => __("Enhanced Interface Control", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'enhanced_set_caption', __("Set caption for file", "gd-bbpress-toolbox"), __("If the file has some generic name, users can set the textual caption to be used instead of the real file name.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('enhanced_set_caption', 'attachments')),
                    new d4pSettingElement('attachments', 'enhanced_auto_new', __("Auto-add new file", "gd-bbpress-toolbox"), __("Hide button to add another file, and instead attaching a file, automatically adds new file control.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('enhanced_auto_new', 'attachments')),
                    new d4pSettingElement('', '', __("Insert into content", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('attachments', 'insert_into_content', __("Include Insert button", "gd-bbpress-toolbox"), __("If enabled, the plugin will show 'Insert into content' button for each attachment.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('insert_into_content', 'attachments')),
                    new d4pSettingElement('attachments', 'insert_into_content_roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('insert_into_content_roles', 'attachments'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
                )),
                'default_limits' => array('name' => __("Default Limits", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'max_file_size', __("Maximum file size", "gd-bbpress-toolbox"), __("Size set in KB.", "gd-bbpress-toolbox").' '.sprintf(__("Current server configuration allows maximum file size of <strong>%s KB</strong>.", "gd-bbpress-toolbox"), $_max_size_kb), d4pSettingType::ABSINT, gdbbx()->get('max_file_size', 'attachments'), '', '', array('max' => $_max_size_kb, 'min' => 1)),
                    new d4pSettingElement('attachments', 'max_to_upload', __("Maximum files to upload", "gd-bbpress-toolbox"), '', d4pSettingType::NUMBER, gdbbx()->get('max_to_upload', 'attachments')),
                    new d4pSettingElement('attachments', 'roles_to_upload', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('roles_to_upload', 'attachments'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
                )),
                'no_limits' => array('name' => __("No Limits Upload", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'roles_no_limit', __("Available to roles", "gd-bbpress-toolbox"), __("Users with these roles will be able to upload files regardless of the limits. These users will be able to upload files of any size and any number of files and any file type allowed by the system.", "gd-bbpress-toolbox").' '.sprintf(__("Current server configuration allows maximum file size of <strong>%s KB</strong>.", "gd-bbpress-toolbox"), $_max_size_kb), d4pSettingType::CHECKBOXES, gdbbx()->get('roles_no_limit', 'attachments'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
                ))
            ),
            'attachments_deletion' => array(
                'delete_method' => array('name' => __("Attachments deletion", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'delete_method', __("Method", "gd-bbpress-toolbox"), __("This will control how the options to delete attachments are presented.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('delete_method', 'attachments'), 'array', $this->data_attachment_delete_method())
                )),
                'delete_topics' => array('name' => __("Deletion of Topics and Replies", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'delete_attachments', __("Action", "gd-bbpress-toolbox"), __("This control what happens to attachments once the topic or reply with attachments is deleted.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('delete_attachments', 'attachments'), 'array', $this->data_attachment_topic_delete())
                )),
                'delete_files' => array('name' => __("Deletion of Attachments", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('attachments', 'delete_visible_to_admins', __("Administrators", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('delete_visible_to_admins', 'attachments'), 'array', $this->data_attachment_file_delete()),
                    new d4pSettingElement('attachments', 'delete_visible_to_moderators', __("Moderators", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('delete_visible_to_moderators', 'attachments'), 'array', $this->data_attachment_file_delete()),
                    new d4pSettingElement('attachments', 'delete_visible_to_author', __("Author", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('delete_visible_to_author', 'attachments'), 'array', $this->data_attachment_file_delete())
                ))
            ),
            'bbcodes_single' => array(
                'code_scode' => array('name' => __("Source Code", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_scode_theme', __("Color Theme", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('bbcodes_scode_theme', 'tools'), 'array', $this->data_bbcodes_scode_theme())
                )),
                'code_attachment' => array('name' => __("Attachment", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_attachment_caption', __("Caption for images", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('bbcodes_attachment_caption', 'tools'), 'array', $this->data_bbcodes_attachment_caption()),
                    new d4pSettingElement('tools', 'bbcodes_attachment_video_caption', __("Caption for videos", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('bbcodes_attachment_video_caption', 'tools'), 'array', $this->data_bbcodes_attachment_caption()),
                    new d4pSettingElement('tools', 'bbcodes_attachment_audio_caption', __("Caption for audios", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('bbcodes_attachment_audio_caption', 'tools'), 'array', $this->data_bbcodes_attachment_caption())
                )),
                'code_quote' => array('name' => __("Quote", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_quote_title', __("Title", "gd-bbpress-toolbox"), __("Quoted text can have a title. This option controls what title is displayed.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('bbcodes_quote_title', 'tools'), 'array', $this->data_bbcodes_quote_titles())
                )),
                'code_hide' => array('name' => __("Hide", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_hide_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::HTML, gdbbx()->get('bbcodes_hide_title', 'tools')),
                    new d4pSettingElement('', '', __("Show when hidden", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'bbcodes_hide_content_normal', __("Content: Normal", "gd-bbpress-toolbox"), __("When HIDE is set with no value, user must be logged in to see hidden content.", "gd-bbpress-toolbox"), d4pSettingType::HTML, gdbbx()->get('bbcodes_hide_content_normal', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_hide_content_count', __("Content: Counts", "gd-bbpress-toolbox"), __("When HIDE is set to integer value, user must be logged in and have at least the amount of posts in the forum as specified to see the content.", "gd-bbpress-toolbox").' '.__("This condition can be checked only for logged-in users, anonymous posts can't be taken into account.", "gd-bbpress-toolbox"), d4pSettingType::HTML, gdbbx()->get('bbcodes_hide_content_count', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_hide_content_reply', __("Content: Reply", "gd-bbpress-toolbox"), __("When HIDE is set to 'reply', user must reply to the topic to see the content.", "gd-bbpress-toolbox").' '.__("This condition can be checked only for logged-in users, anonymous posts can't be taken into account.", "gd-bbpress-toolbox").' '.__("For non-logged in visitors, a Normal message will be displayed.", "gd-bbpress-toolbox"), d4pSettingType::HTML, gdbbx()->get('bbcodes_hide_content_reply', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_hide_content_thanks', __("Content: Say Thanks", "gd-bbpress-toolbox"), __("When HIDE is set to 'thanks', user must say thanks to the topic author to see the content.", "gd-bbpress-toolbox").' '.__("For non-logged in visitors, normal message will be displayed.", "gd-bbpress-toolbox"), d4pSettingType::HTML, gdbbx()->get('bbcodes_hide_content_thanks', 'tools')),
                    new d4pSettingElement('', '', __("Exceptions", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'bbcodes_hide_keymaster_always_allowed', __("Keymaster always allowed", "gd-bbpress-toolbox"), __("If enabled, keymaster will be able to always see hidden content.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_hide_keymaster_always_allowed', 'tools'))
                )),
                'code_spoiler' => array('name' => __("Spoiler", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_spoiler_color', __("Main Color", "gd-bbpress-toolbox"), '', d4pSettingType::COLOR, gdbbx()->get('bbcodes_spoiler_color', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_spoiler_hover', __("Hover Background Color", "gd-bbpress-toolbox"), '', d4pSettingType::COLOR, gdbbx()->get('bbcodes_spoiler_hover', 'tools'))
                )),
                'code_highlight' => array('name' => __("Highlight", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_highlight_color', __("Text Color", "gd-bbpress-toolbox"), '', d4pSettingType::COLOR, gdbbx()->get('bbcodes_highlight_color', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_highlight_background', __("Background Color", "gd-bbpress-toolbox"), '', d4pSettingType::COLOR, gdbbx()->get('bbcodes_highlight_background', 'tools'))
                )),
                'code_heading' => array('name' => __("Heading", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_heading_size', __("Default Size", "gd-bbpress-toolbox"), __("Heading will render H{size} tag.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('bbcodes_heading_size', 'tools'), 'array', $this->data_bbcodes_heading())
                ))
            ),
            'bbcodes_toolbar' => array(
                'toolbar' => array('name' => __("Status", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_toolbar_active', __("BBCodes Toolbar Active", "gd-bbpress-toolbox"), __("This toolbar will appear only if you don't use any editor toolbars normally added by bbPress. To disable these, disable checkbox under 'Post Formatting' on this page:", "gd-bbpress-toolbox").' <a href="options-general.php?page=bbpress">'.__("bbPress Settings", "gd-bbpress-toolbox").'</a>.', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_active', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_toolbar_size', __("Toolbar Icons Size", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('bbcodes_toolbar_size', 'tools'), 'array', $this->data_bbcodes_toolbar_size()),
                    new d4pSettingElement('tools', 'bbcodes_toolbar_editor_fix', __("Apply editor styling fix", "gd-bbpress-toolbox"), __("By default, editor textarea is not styled as fixed and it can look bad if the toolbar is active. This fix will apply styling changes to textarea editor to fit better with the toolbar and most themes.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_editor_fix', 'tools'))
                )),
                'hide_codes' => array('name' => __("Hide BBCodes", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_toolbar_hide_rare', __("Hide Rarely used BBCodes", "gd-bbpress-toolbox"), __("This will hide several BBCodes from toolbar", "gd-bbpress-toolbox").': reverse, anchor, border, area, list, quote, nfo.', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_hide_rare', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_toolbar_hide_image', __("Hide Image BBCode", "gd-bbpress-toolbox"), __("This will hide image BBCode from toolbar.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_hide_image', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_toolbar_hide_video', __("Hide Video related BBCodes", "gd-bbpress-toolbox"), __("This will hide several BBCodes from toolbar", "gd-bbpress-toolbox").': youtube, vimeo', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_hide_video', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_toolbar_hide_media', __("Hide Media related BBCodes", "gd-bbpress-toolbox"), __("This will hide several BBCodes from toolbar", "gd-bbpress-toolbox").': webshot, embed, google', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_hide_media', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_toolbar_hide_restricted', __("Hide Restricted BBCodes", "gd-bbpress-toolbox"), __("This will hide several BBCodes from toolbar", "gd-bbpress-toolbox").': iframe, note', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_hide_restricted', 'tools'))
                )),
                'filter_codes' => array('name' => __("Filter BBCodes", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_toolbar_show_available_only', __("Show only available BBCodes", "gd-bbpress-toolbox"), __("This will hide disabled BBCodes, or BBCodes that are not available to current user role.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_toolbar_show_available_only', 'tools'))
                ))
            ),
            'bbcodes_basic' => array(
                'main_codes' => array('name' => __("Standard Settings", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_active', __("BBCodes Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_active', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_notice', __("Form Notice", "gd-bbpress-toolbox"), __("If the BBCodes support is active, you can display notice in the new topic/reply form.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_notice', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_bbpress_only', __("bbPress Only", "gd-bbpress-toolbox"), __("Processing of the BBCodes can be limited only to bbPress implemented forums, topics and replies.", "gd-bbpress-toolbox").' <strong>'.__("If you are using BuddyPress Nuovo templates, BBCode for Italic can cause the problem with some elements of the BuddyPress using underscore templates to render. To avoid that, you need to enable this option, or disable Italic BBCode.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_bbpress_only', 'tools'))
                )),
                'advanced_codes' => array('name' => __("Advanced Codes", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_special_super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_special_super_admin', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_special_roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('bbcodes_special_roles', 'tools'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                    new d4pSettingElement('tools', 'bbcodes_special_visitor', __("Available to visitors", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_special_visitor', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_special_action', __("Restriction action", "gd-bbpress-toolbox"), __("If the advanced codes are used when not allowed, plugin can delete it or replace it with notice.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('bbcodes_special_action', 'tools'), 'array', $this->data_bbcodes_replacement())
                )),
                'restricted_codes' => array('name' => __("Restricted Codes", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_restricted_super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_restricted_super_admin', 'tools')),
                    new d4pSettingElement('tools', 'bbcodes_restricted_administrator', __("Available to administrators", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('bbcodes_restricted_administrator', 'tools'))
                )),
                'deactivate_codes' => array('name' => __("Deactivate Selected Codes", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'bbcodes_deactivated', __("Deactivate", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('bbcodes_deactivated', 'tools'), 'array', $this->data_list_bbcodes(), array('class' => 'gdbbx-bbcodes'))
                ))
            ),
            'forum_read' => array(
                'forum_read_new_posts' => array('name' => __("New Posts", "gd-bbpress-toolbox"),
                    'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'forums-logged-in-users-read-tracking'), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("If the new topic or reply is posted since the last user visit, forum this topic belongs to, will be marked. For this to work, you need to enable user activity tracking.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'latest_forum_new_posts_badge', __("Add new posts badge", "gd-bbpress-toolbox"), __("Add badge before the forum title.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_forum_new_posts_badge', 'tools')),
                    new d4pSettingElement('tools', 'latest_forum_new_posts_strong_title', __("Wrap title in strong tag", "gd-bbpress-toolbox"), __("Wrap the forum title in the STRONG to attempt display it as bold to stand out in the list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_forum_new_posts_strong_title', 'tools'))
                )),
                'forum_read_unread_forum' => array('name' => __("Unread Forum", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("If the forum is not read by the user (taking into account the cutoff timestamp), forum will be marked as unread.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'latest_forum_unread_forum_badge', __("Add unread forum badge", "gd-bbpress-toolbox"), __("Add badge before the forum title.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_forum_unread_forum_badge', 'tools')),
                    new d4pSettingElement('tools', 'latest_forum_unread_forum_strong_title', __("Wrap title in strong tag", "gd-bbpress-toolbox"), __("Wrap the forum title in the STRONG to attempt display it as bold to stand out in the list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_forum_unread_forum_strong_title', 'tools'))
                ))
            ),
            'topic_read' => array(
                'topic_read_tracking' => array('name' => __("User read status tracking", "gd-bbpress-toolbox"),
                    'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'topics-logged-in-users-read-tracking'), 'settings' => array(
                    new d4pSettingElement('tools', 'latest_track_users_topic', __("Active", "gd-bbpress-toolbox"), __("Track users access to topics, latest reply for topic and use it to mark unread content.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_track_users_topic', 'tools')),
                    new d4pSettingElement('tools', 'latest_use_cutoff_timestamp', __("Use cutoff timestamp", "gd-bbpress-toolbox"), __("Tracking data begins storing when plugin version 4.5 is installed. This moment will be stored to serve as cutoff for displaying unread topics to users. If this is not used, all old topics will be initially marked as 'unread' to all users.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_use_cutoff_timestamp', 'tools'))
                )),
                'topic_read_new_replies' => array('name' => __("New Replies", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("If one or more new replies are added to the topic since the last time user visited a topic, this topic will be marked and link placed to lead to the first new reply for the current user.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'latest_topic_new_replies_badge', __("Add new reply badge", "gd-bbpress-toolbox"), __("Add badge before the topic title.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_new_replies_badge', 'tools')),
                    new d4pSettingElement('tools', 'latest_topic_new_replies_mark', __("Add new replies icon", "gd-bbpress-toolbox"), __("Add icon and link to the first new reply in the topic.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_new_replies_mark', 'tools')),
                    new d4pSettingElement('tools', 'latest_topic_new_replies_strong_title', __("Wrap title in strong tag", "gd-bbpress-toolbox"), __("Wrap the topic title in the STRONG to attempt display it as bold to stand out in the list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_new_replies_strong_title', 'tools')),
                    new d4pSettingElement('tools', 'latest_topic_new_replies_in_thread', __("Mark replies in topic thread", "gd-bbpress-toolbox"), __("When topic is opened, all new replies will get a 'new reply' badge.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_new_replies_in_thread', 'tools'))
                )),
                'topic_read_new_topics' => array('name' => __("New Topics", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("If the new topic is posted since the last user visit, they will be marked. For this to work, you need to enable user activity tracking.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'latest_topic_new_topic_badge', __("Add new topic badge", "gd-bbpress-toolbox"), __("Add badge before the topic title.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_new_topic_badge', 'tools')),
                    new d4pSettingElement('tools', 'latest_topic_new_topic_strong_title', __("Wrap title in strong tag", "gd-bbpress-toolbox"), __("Wrap the topic title in the STRONG to attempt display it as bold to stand out in the list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_new_topic_strong_title', 'tools'))
                )),
                'topic_read_unread_topics' => array('name' => __("Unread Topics", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("If the topic is not read by the user (taking into account the cutoff timestamp), it will be marked as unread.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('tools', 'latest_topic_unread_topic_badge', __("Add unread topic badge", "gd-bbpress-toolbox"), __("Add badge before the topic title.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_unread_topic_badge', 'tools')),
                    new d4pSettingElement('tools', 'latest_topic_unread_topic_strong_title', __("Wrap title in strong tag", "gd-bbpress-toolbox"), __("Wrap the topic title in the STRONG to attempt display it as bold to stand out in the list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('latest_topic_unread_topic_strong_title', 'tools'))
                ))
            ),
            'tracking' => array(
                'user_tracking' => array('name' => __("User activity tracking", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'track_last_activity_active', __("Active", "gd-bbpress-toolbox"), __("Everytime user opens any forum, topic or reply page plugin will save activity timestamp.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('track_last_activity_active', 'tools')),
                    new d4pSettingElement('tools', 'track_basic_cookie_expiration', __("Cookie Expiration", "gd-bbpress-toolbox"), __("Value is in days.", "gd-bbpress-toolbox"), d4pSettingType::NUMBER, gdbbx()->get('track_basic_cookie_expiration', 'tools'))
                )),
                'last_visit_cookie' => array('name' => __("Current session cookie", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('tools', 'track_current_session_cookie_expiration', __("Expiration", "gd-bbpress-toolbox"), __("Value is in minutes.", "gd-bbpress-toolbox"), d4pSettingType::NUMBER, gdbbx()->get('track_current_session_cookie_expiration', 'tools'))
                )),
                'online_status' => array('name' => __("Track online status for users and guests", "gd-bbpress-toolbox"), 'settings' => array(
                    new d4pSettingElement('online', 'active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('active', 'online')),
                    new d4pSettingElement('online', 'track_users', __("Track Users", "gd-bbpress-toolbox"), __("If enabled, plugin will track online status logged in users.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('track_users', 'online')),
                    new d4pSettingElement('online', 'track_guests', __("Track Guests", "gd-bbpress-toolbox"), __("If enabled, plugin will track online status for guests - users that are not logged in.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('track_guests', 'online')),
                    new d4pSettingElement('online', 'window', __("Online period", "gd-bbpress-toolbox"), __("Value is in seconds.", "gd-bbpress-toolbox"), d4pSettingType::INTEGER, gdbbx()->get('window', 'online')),
                    new d4pSettingElement('', '', __("Notices with online counts", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                    new d4pSettingElement('', '', __("Description", "gd-bbpress-toolbox"), __("Notices are displayed on top of the page, and they will show number of users and guests currently viewing the forum, topic, profile or view.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                    new d4pSettingElement('online', 'notice_for_forum', __("For Forums", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notice_for_forum', 'online')),
                    new d4pSettingElement('online', 'notice_for_topic', __("For Topics", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notice_for_topic', 'online')),
                    new d4pSettingElement('online', 'notice_for_view', __("For Topics Views", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notice_for_view', 'online')),
                    new d4pSettingElement('online', 'notice_for_profile', __("For User Profiles", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notice_for_profile', 'online'))
                ))
            ),
            'buddypress' => $this->_fields_for_buddypress()
        );

        $this->settings = apply_filters('gdbbx_internal_settings', $this->settings);
    }

    private function _fields_for_buddypress() {
        $items = array(
            'buddypress_xprofile' => array('name' => __("Extended Profile", "gd-bbpress-toolbox"), 
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'signatures-editing-in-buddypress'), 'settings' => array(
                new d4pSettingElement('buddypress', 'xprofile_support', __("XProfile Integration", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('xprofile_support', 'buddypress'))
            )),
            'buddypress_notifications' => array('name' => __("Notifications", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('buddypress', 'notifications_support', __("Notifications Integration", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('notifications_support', 'buddypress')),
                new d4pSettingElement('buddypress', 'notifications_thanks_received', __("Notify on Thanks Received", "gd-bbpress-toolbox"), __("When the user receives thanks for own topic or reply, notification will be added to BuddyPress notifications system.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('notifications_thanks_received', 'buddypress')),
                new d4pSettingElement('buddypress', 'notifications_post_reported', __("Notify on Topic/Reply Report", "gd-bbpress-toolbox"), __("When the topic or reply gets reported, notification will be added to BuddyPress notifications system for administrators and moderators.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('notifications_post_reported', 'buddypress'))
            )),
            'buddypress_override' => array('name' => __("BuddyPress Overriding URL's", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('buddypress', 'disable_profile_override', __("Stop Profile Override", "gd-bbpress-toolbox"), __("Prevent BuddyPress changing user profile pages override, and linking them to BuddyPress profile page.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('disable_profile_override', 'buddypress'))
            ))
        );

        if (!gdbbx_has_buddypress() || !bp_is_active('xprofile')) {
            unset($items['buddypress_xprofile']);
        } else {
            $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('', '', __("Forum Signature", "gd-bbpress-toolbox"), '', d4pSettingType::HR);
            $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("The plugin adds specialized 'Signature Textarea' field type. Please, do not use this field for other extended profile fields, it should be used only for the field created by this plugin.", "gd-bbpress-toolbox"), d4pSettingType::INFO);

            if (Features::instance()->is_enabled('signatures')) {
                $_field_id = gdbbx()->get('xprofile_signature_field_id', 'buddypress');

                if ($_field_id == 0) {
                    $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('', '', __("XProfile Field", "gd-bbpress-toolbox"), __("The signature field for Extended profile is not added to the BuddyPress yet. Use the option below to create this field if you want for your users to be able to edit forum signature from their BuddyPress Extended profile.", "gd-bbpress-toolbox"), d4pSettingType::INFO);
                    $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('buddypress', 'xprofile_signature_field_add', __("Create Field", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('xprofile_signature_field_add', 'buddypress'));
                } else if (!gdbbx_module_buddypress()->has_signature_field()) {
                    $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('', '', __("XProfile Field", "gd-bbpress-toolbox"), __("The signature field for Extended profile was created earlier, but it is missing now. Use the option below to create this field again if you want for your users to be able to edit forum signature from their BuddyPress Extended profile.", "gd-bbpress-toolbox"), d4pSettingType::INFO);
                    $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('buddypress', 'xprofile_signature_field_add', '', '', d4pSettingType::BOOLEAN, gdbbx()->get('xprofile_signature_field_add', 'buddypress'), '', '', array('label' => __("Create the signature field", "gd-bbpress-toolbox")));
                } else {
                    $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('', '', __("XProfile Field", "gd-bbpress-toolbox"), __("The signature field for Extended profile configured properly. You can modify the field to change it's name, but make sure it is always set to use 'Signature Textarea' field type, or the field will not work as expected.", "gd-bbpress-toolbox"), d4pSettingType::INFO);
                    $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('buddypress', 'xprofile_signature_field_del', '', '', d4pSettingType::BOOLEAN, gdbbx()->get('xprofile_signature_field_del', 'buddypress'), '', '', array('label' => __("Remove the signature field", "gd-bbpress-toolbox")));
                }
            } else {
                $items['buddypress_xprofile']['settings'][] = new d4pSettingElement('', '', __("Signatures Disabled", "gd-bbpress-toolbox"), __("The signatures module is disabled.", "gd-bbpress-toolbox"), d4pSettingType::INFO);
            }
        }

        return $items;
    }

    private function data_quote_button_location() {
        return array(
            'header' => __("Reply or Topic header", "gd-bbpress-toolbox"),
            'footer' => __("Reply or Topic footer", "gd-bbpress-toolbox")
        );
    }

    private function data_bbcodes_replacement() {
        return array(
            'info' => __("Replace with notice", "gd-bbpress-toolbox"),
            'delete' => __("Remove from content", "gd-bbpress-toolbox")
        );
    }

    private function data_bbcodes_scode_theme() {
        return array(
            'default' => __("Default", "gd-bbpress-toolbox"),
            'django' => __("Django", "gd-bbpress-toolbox"),
            'eclipse' => __("Eclipse", "gd-bbpress-toolbox"),
            'emacs' => __("Emacs", "gd-bbpress-toolbox"),
            'fadetogrey' => __("Fade To Grey", "gd-bbpress-toolbox"),
            'mdultra' => __("MD Ultra", "gd-bbpress-toolbox"),
            'midnight' => __("Midnight", "gd-bbpress-toolbox"),
            'rdark' => __("Dark", "gd-bbpress-toolbox"),
            'swift' => __("Swift", "gd-bbpress-toolbox")
        );
    }

    private function data_bbcodes_toolbar_size() {
        return array(
            'small' => __("Small", "gd-bbpress-toolbox"),
            'medium' => __("Medium", "gd-bbpress-toolbox"),
            'large' => __("Large", "gd-bbpress-toolbox")
        );
    }

    private function data_list_bbcodes() {
        require_once(GDBBX_PATH.'core/functions/bbcodes.php');

        $list = array();
        foreach (gdbbx_get_bbcodes_list() as $key => $code) {
            $list[$key] = $code['title'].' ['.$key.']';
        }

        return $list;
    }

    private function data_attachment_icon_method() {
        return array(
            'images' => __("Images", "gd-bbpress-toolbox"),
            'font' => __("Font Icons", "gd-bbpress-toolbox")
        );
    }

    private function data_files_position_topic() {
        return array(
            'content' => __("Attach at the end of post content", "gd-bbpress-toolbox"),
            'after' => __("Place after the post content", "gd-bbpress-toolbox")
        );
    }

    private function data_form_position_topic() {
        return array(
            'bbp_theme_before_topic_form_title' => __("Before title", "gd-bbpress-toolbox"),
            'bbp_theme_after_topic_form_title' => __("After title", "gd-bbpress-toolbox"),
            'bbp_theme_before_topic_form_content' => __("Before content", "gd-bbpress-toolbox"),
            'bbp_theme_after_topic_form_content' => __("After content", "gd-bbpress-toolbox"),
            'bbp_theme_before_topic_form_submit_wrapper' => __("At the end", "gd-bbpress-toolbox")
        );
    }

    private function data_form_position_reply() {
        return array(
            'bbp_theme_before_reply_form_content' => __("Before content", "gd-bbpress-toolbox"),
            'bbp_theme_after_reply_form_content' => __("After content", "gd-bbpress-toolbox"),
            'bbp_theme_before_reply_form_submit_wrapper' => __("At the end", "gd-bbpress-toolbox")
        );
    }

    private function data_attachment_topic_delete() {
        return array(
            'detach' => __("Leave attachments in media library", "gd-bbpress-toolbox"),
            'delete' => __("Delete attachments", "gd-bbpress-toolbox"),
            'nohing' => __("Do nothing", "gd-bbpress-toolbox")
        );
    }

    private function data_attachment_delete_method() {
        return array(
            'default' => __("Default, inline links", "gd-bbpress-toolbox"),
            'edit' => __("Advanced, through edit pages", "gd-bbpress-toolbox"),
            'hide' => __("Hide deletion options", "gd-bbpress-toolbox")
        );
    }

    private function data_attachment_file_delete() {
        return array(
            'no' => __("Don't allow to delete", "gd-bbpress-toolbox"),
            'detach' => __("Only detach from topic/reply", "gd-bbpress-toolbox"),
            'delete' => __("Delete from Media Library", "gd-bbpress-toolbox"),
            'both' => __("Allow both delete and detach", "gd-bbpress-toolbox")
        );
    }

    private function data_private_checked_status() {
        return array(
            'unchecked' => __("Unchecked", "gd-bbpress-toolbox"),
            'checked' => __("Checked", "gd-bbpress-toolbox")
        );
    }

    private function data_bbcodes_attachment_caption() {
        return array(
            'hide' => __("Hide", "gd-bbpress-toolbox"),
            'auto' => __("Attachment caption or file name", "gd-bbpress-toolbox"),
            'caption' => __("Attachment caption only", "gd-bbpress-toolbox")
        );
    }

    private function data_bbcodes_quote_titles() {
        return array(
            'hide' => __("Hide", "gd-bbpress-toolbox"),
            'user' => __("Quoted text author display name", "gd-bbpress-toolbox"),
            'id' => __("Quoted text topic or reply ID", "gd-bbpress-toolbox")
        );
    }

    private function data_forum_not_defined() {
        return array(
            'hide' => __("Hide attachment uploader", "gd-bbpress-toolbox"),
            'show' => __("Show attachment uploader with global settings", "gd-bbpress-toolbox")
        );
    }

    private function data_bbcodes_heading() {
        return array(
            1 => 'H1',
            2 => 'H2',
            3 => 'H3',
            4 => 'H4',
            5 => 'H5',
            6 => 'H6'
        );
    }

    private function data_upload_dir_format() {
        return array(
            '/forums' => '/forums',
            '/forums/user-id' => '/forums/user-id',
            '/forums/forum-name' => '/forums/forum-name',
            '/forums/forum-id' => '/forums/forum-id'
        );
    }

    private function info_upload_dir() {
        $items = array(
            __("Enabling or disabling this feature doesn't affect any of the attachments that are uploaded previously.", "gd-bbpress-toolbox"),
            __("There is no reliable way to move already uploaded files to newly activated upload directory structure.", "gd-bbpress-toolbox"),
            __("Uploads are still located in the base website uploads directory, that can't be changed, changes are only for directory under the uploads directory.", "gd-bbpress-toolbox"),
            __("This only affects the location of the files in the file system, it has no impact on the files visibility or accessibility.", "gd-bbpress-toolbox")
        );

        return '<ul><li>'.join('</li><li>', $items).'</li></ul>';
    }

    private function info_upload_dir_format() {
        $items = array(
            '&middot; <strong>forums</strong>: '.__("Replaced by the base directory name set above.", "gd-bbpress-toolbox"),
            '&middot; <strong>user-id</strong>: '.__("Replaced by the ID of the user upload the file.", "gd-bbpress-toolbox"),
            '&middot; <strong>forum-id</strong>: '.__("Replaced by the ID of the current forum.", "gd-bbpress-toolbox"),
            '&middot; <strong>forum-name</strong>: '.__("Replaced by the slug of the current forum.", "gd-bbpress-toolbox")
        );

        return '<br/>'.join('<br/>', $items);
    }
}
