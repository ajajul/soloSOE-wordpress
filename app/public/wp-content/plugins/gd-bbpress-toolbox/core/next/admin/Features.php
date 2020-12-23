<?php

namespace Dev4Press\Plugin\GDBBX\Admin;

use d4pSettingElement;
use d4pSettingType;
use Dev4Press\Plugin\GDBBX\Basic\Features as Controller;
use Dev4Press\Plugin\GDBBX\Features\AutoCloseTopics;

if (!defined('ABSPATH')) {
    exit;
}

class Features {
    public $list;

    public function __construct() {
        $this->init_features();

        add_filter('gdbbx_internal_settings', array($this, 'internal'));
    }

    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Features();
        }

        return $instance;
    }

    private function init_features() {
        $this->list = array(
            'icons' => array(
                'icon' => 'picture-o',
                'scope' => 'front',
                'title' => __("Icons", "gd-bbpress-toolbox"),
                'info' => __("Control icons or marks added in the content lists for topics or forums.", "gd-bbpress-toolbox")
            ),
            'tweaks' => array(
                'icon' => 'check-square',
                'scope' => 'global',
                'title' => __("Tweaks", "gd-bbpress-toolbox"),
                'info' => __("Control over various tweaks and improvements for the bbPress powered forums.", "gd-bbpress-toolbox")
            ),
            'topic-actions' => array(
                'icon' => 'd4p-icon-bbpress-topic',
                'scope' => 'front',
                'title' => __("Topic Actions", "gd-bbpress-toolbox"),
                'info' => __("Control available bbPress and Toolbox actions for each topic.", "gd-bbpress-toolbox")
            ),
            'reply-actions' => array(
                'icon' => 'd4p-icon-bbpress-reply',
                'scope' => 'front',
                'title' => __("Reply Actions", "gd-bbpress-toolbox"),
                'info' => __("Control available bbPress and Toolbox actions for each reply.", "gd-bbpress-toolbox")
            ),
            'user-settings' => array(
                'icon' => 'user-o',
                'scope' => 'global',
                'title' => __("User Settings", "gd-bbpress-toolbox"),
                'info' => __("Add additional settings into user profile and bbPress user profile edit.", "gd-bbpress-toolbox")
            ),
            'custom-views' => array(
                'icon' => 'files-o',
                'scope' => 'global',
                'title' => __("Custom Topic Views", "gd-bbpress-toolbox"),
                'info' => __("Add more topic views. Plugin can register basic, moderation and private topics views.", "gd-bbpress-toolbox")
            ),
            'rewriter' => array(
                'icon' => 'link',
                'scope' => 'global',
                'title' => __("URL Rewriter", "gd-bbpress-toolbox"),
                'info' => __("Enhance the permalinks structure for forum content and tweak some of the aspects of permalinks structure.", "gd-bbpress-toolbox")
            ),
            'privacy' => array(
                'icon' => 'user-secret',
                'scope' => 'global',
                'title' => __("Privacy", "gd-bbpress-toolbox"),
                'info' => __("Control how the bbPress deals with the user IP address storing and display.", "gd-bbpress-toolbox")
            ),
            'mime-types' => array(
                'icon' => 'file',
                'scope' => 'global',
                'title' => __("Extra MIME Types", "gd-bbpress-toolbox"),
                'info' => __("Add additional MIME types into WordPress files upload system for use with Attachments.", "gd-bbpress-toolbox")
            ),
            'objects' => array(
                'icon' => 'thumb-tack',
                'scope' => 'global',
                'title' => __("Content Objects", "gd-bbpress-toolbox"),
                'info' => __("Expand forums, topics and replies post type objects with additional features.", "gd-bbpress-toolbox")
            ),
            'signatures' => array(
                'icon' => 'user',
                'scope' => 'global',
                'title' => __("Signatures", "gd-bbpress-toolbox"),
                'info' => __("Allow users to setup own signatures that will be added to each topic and reply user posts.", "gd-bbpress-toolbox")
            ),
            'thanks' => array(
                'icon' => 'thumbs-up',
                'scope' => 'global',
                'title' => __("Say Thanks", "gd-bbpress-toolbox"),
                'info' => __("Allow users to say thanks to topic and/or replies authors.", "gd-bbpress-toolbox")
            ),
            'report' => array(
                'icon' => 'exclamation-triangle',
                'scope' => 'global',
                'title' => __("Report", "gd-bbpress-toolbox"),
                'info' => __("Allow users to report topics or replies for errors or inappropriate content.", "gd-bbpress-toolbox")
            ),
            'canned-replies' => array(
                'icon' => 'reply',
                'scope' => 'global',
                'title' => __("Canned Replies", "gd-bbpress-toolbox"),
                'info' => __("Allow forum users to insert predefined replies into the reply content.", "gd-bbpress-toolbox")
            ),
            'toolbar' => array(
                'icon' => 'list-alt',
                'scope' => 'global',
                'title' => __("Toolbar", "gd-bbpress-toolbox"),
                'info' => __("Add new menu into WordPress toolbar with links to forums, views, bbPress related settings and more.", "gd-bbpress-toolbox")
            ),
            'private-topics' => array(
                'icon' => 'user-circle',
                'scope' => 'global',
                'title' => __("Private Topics", "gd-bbpress-toolbox"),
                'info' => __("Allow users to set topics as private and limit who can read the topic.", "gd-bbpress-toolbox")
            ),
            'private-replies' => array(
                'icon' => 'user-circle',
                'scope' => 'global',
                'title' => __("Private Replies", "gd-bbpress-toolbox"),
                'info' => __("Allow users to set replies as private and limit who can read the reply.", "gd-bbpress-toolbox")
            ),
            'lock-forums' => array(
                'icon' => 'lock',
                'scope' => 'global',
                'title' => __("Lock Forums", "gd-bbpress-toolbox"),
                'info' => __("Lock forums and prevent use of new topic or new reply forms with customized messages.", "gd-bbpress-toolbox")
            ),
            'lock-topics' => array(
                'icon' => 'lock',
                'scope' => 'global',
                'title' => __("Lock Topics", "gd-bbpress-toolbox"),
                'info' => __("Lock individual topics from gettings new replies. Locked topics are not gettings closed.", "gd-bbpress-toolbox")
            ),
            'auto-close-topics' => array(
                'icon' => 'eye-slash',
                'scope' => 'global',
                'title' => __("Auto Close Topics", "gd-bbpress-toolbox"),
                'info' => __("Automatic close old and inactive topics using daily maintenance job.", "gd-bbpress-toolbox")
            ),
            'close-topic-control' => array(
                'icon' => 'check-square-o',
                'scope' => 'front',
                'title' => __("Close Topic Control", "gd-bbpress-toolbox"),
                'info' => __("Add checkbox to reply form that can be used to close the topic after reply is saved.", "gd-bbpress-toolbox")
            ),
            'topics' => array(
                'icon' => 'd4p-icon-bbpress-topic',
                'scope' => 'front',
                'title' => __("Topics", "gd-bbpress-toolbox"),
                'info' => __("Various tweaks and features related to the topics.", "gd-bbpress-toolbox")
            ),
            'schedule-topic' => array(
                'icon' => 'calendar-check-o',
                'scope' => 'front',
                'title' => __("Schedule Topic", "gd-bbpress-toolbox"),
                'info' => __("Allow scheduling topics to be published automatically in the future.", "gd-bbpress-toolbox")
            ),
            'replies' => array(
                'icon' => 'd4p-icon-bbpress-reply',
                'scope' => 'front',
                'title' => __("Replies", "gd-bbpress-toolbox"),
                'info' => __("Various tweaks and features related to the replies.", "gd-bbpress-toolbox")
            ),
            'footer-actions' => array(
                'icon' => 'outdent',
                'scope' => 'front',
                'title' => __("Footer Actions", "gd-bbpress-toolbox"),
                'info' => __("Add a footer actions area to topics and replies similar to the actions area in the topics and replies header.", "gd-bbpress-toolbox")
            ),
            'editor' => array(
                'icon' => 'pencil',
                'scope' => 'front',
                'title' => __("Rich Editor", "gd-bbpress-toolbox"),
                'info' => __("Enable TinyMCE Rich Text editor for topics and replies and control various additional settings.", "gd-bbpress-toolbox")
            ),
            'seo-tweaks' => array(
                'icon' => 'search',
                'scope' => 'front',
                'title' => __("SEO Tweaks", "gd-bbpress-toolbox"),
                'info' => __("Control over various tweaks related to search engine optimization of the forums.", "gd-bbpress-toolbox")
            ),
            'snippets' => array(
                'icon' => 'search-plus',
                'scope' => 'front',
                'title' => __("Rich Snippets", "gd-bbpress-toolbox"),
                'info' => __("Add rich snippets used by search engine to enhance the search engine results for the forum.", "gd-bbpress-toolbox")
            ),
            'clickable' => array(
                'icon' => 'hand-pointer-o',
                'scope' => 'front',
                'title' => __("Clickable Control", "gd-bbpress-toolbox"),
                'info' => __("Control automatic conversion of links and mentions into HTML clickable controls.", "gd-bbpress-toolbox")
            ),
            'forum-index' => array(
                'icon' => 'd4p-icon-bbpress-forum',
                'scope' => 'front',
                'title' => __("Forum Index", "gd-bbpress-toolbox"),
                'info' => __("Add welcome and statistics blocks to the main forums index page.", "gd-bbpress-toolbox")
            ),
            'users-stats' => array(
                'icon' => 'user-plus',
                'scope' => 'front',
                'title' => __("Users Stats", "gd-bbpress-toolbox"),
                'info' => __("Add additional user information into author box visible with each topic and reply.", "gd-bbpress-toolbox")
            ),
            'quote' => array(
                'icon' => 'quote-right',
                'scope' => 'front',
                'title' => __("Quotes", "gd-bbpress-toolbox"),
                'info' => __("Implement the topic and reply quotes using HTML or BBCodes.", "gd-bbpress-toolbox")
            ),
            'protect-revisions' => array(
                'icon' => 'calendar-o',
                'scope' => 'front',
                'title' => __("Protect Revisions", "gd-bbpress-toolbox"),
                'info' => __("Hide topic and reply revisions from most users, and select which user roles and authors can see revisions.", "gd-bbpress-toolbox")
            ),
            'visitors-redirect' => array(
                'icon' => 'external-link-square',
                'scope' => 'front',
                'title' => __("Visitors Redirect", "gd-bbpress-toolbox"),
                'info' => __("Prevent non-logged users (visitors or guests) to view some types of the forum pages.", "gd-bbpress-toolbox")
            ),
            'profiles' => array(
                'icon' => 'user',
                'scope' => 'front',
                'title' => __("User Profiles", "gd-bbpress-toolbox"),
                'info' => __("Control the visibility and hide user profiles to guests and display of some extra information inside the profiles.", "gd-bbpress-toolbox")
            ),
            'disable-rss' => array(
                'icon' => 'rss',
                'scope' => 'front',
                'title' => __("Disable RSS Feeds", "gd-bbpress-toolbox"),
                'info' => __("Disable bbPress RSS Feeds and redirect RSS requests to parent topics or forums.", "gd-bbpress-toolbox")
            ),
            'publish' => array(
                'icon' => 'eye',
                'scope' => 'front',
                'title' => __("Forum Public", "gd-bbpress-toolbox"),
                'info' => __("Change the bbPress forums visibility status and make it public or private.", "gd-bbpress-toolbox")
            ),
            'admin-access' => array(
                'icon' => 'exclamation-circle',
                'scope' => 'admin',
                'title' => __("Admin Access", "gd-bbpress-toolbox"),
                'info' => __("Prevent users by user role from being able to access bbPress panels and pages on the admin side.", "gd-bbpress-toolbox")
            ),
            'admin-columns' => array(
                'icon' => 'dashboard',
                'scope' => 'admin',
                'title' => __("Admin Columns", "gd-bbpress-toolbox"),
                'info' => __("Add extra information columns to the admin side Forums, Topics, Replies and Users tables.", "gd-bbpress-toolbox")
            ),
            'admin-widgets' => array(
                'icon' => 'puzzle-piece',
                'scope' => 'admin',
                'title' => __("Admin Widgets", "gd-bbpress-toolbox"),
                'info' => __("Add extra widgets to the WordPress admin side dashboard with forums related information.", "gd-bbpress-toolbox")
            )
        );
    }

    public function get_features_for_display() {
        $list = array(
            'always' => array(
                'icons',
                'tweaks',
                'topic-actions',
                'reply-actions',
                'user-settings',
                'custom-views'
            ),
            'enabled' => array(),
            'disabled' => array()
        );

        foreach (array_keys($this->list) as $feature) {
            if (in_array($feature, $list['always'])) {
                continue;
            }

            if (gdbbx()->get($feature, 'load')) {
                $list['enabled'][] = $feature;
            } else {
                $list['disabled'][] = $feature;
            }
        }

        $out = array();

        $_added = false;
        foreach ($list['always'] as $feature) {
            $value = $this->list[$feature];
            $value['status'] = 'required';

            if (!$_added) {
                $value['break'] = __("Always Enabled", "gd-bbpress-toolbox");
                $_added = true;
            }

            $out[$feature] = $value;
        }

        $_added = false;
        foreach ($list['enabled'] as $feature) {
            $value = $this->list[$feature];
            $value['status'] = 'enabled';

            if (!$_added) {
                $value['break'] = __("Enabled", "gd-bbpress-toolbox");
                $_added = true;
            }

            $out[$feature] = $value;
        }

        $_added = false;
        foreach ($list['disabled'] as $feature) {
            $value = $this->list[$feature];
            $value['status'] = 'disabled';

            if (!$_added) {
                $value['break'] = __("Disabled", "gd-bbpress-toolbox");
                $_added = true;
            }

            $out[$feature] = $value;
        }

        return $out;
    }

    public function internal($settings) {
        $_footer_actions = Controller::instance()->is_enabled('footer-actions');

        $_footer_message = $_footer_actions
            ? __("Footer Actions are enabled.", "gd-bbpress-toolbox")
            :
            sprintf(__("Footer Actions are disabled, %s.", "gd-bbpress-toolbox"), ' <a href="'.gdbbx_admin()->current_url(true).'&gdbbx_handler=getback&action=enable-feature&feature=footer-actions&_wpnonce='.wp_create_nonce('gdbbx-enable-feature-footer-actions').'">'.__("Click to Enable", "gd-bbpress-toolbox").'</a>');

        $settings['icons'] = array(
            'icons' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Active", "gd-bbpress-toolbox"), __("This feature is always active, and it can't be disabled. You can enable or disable individual settings included.", "gd-bbpress-toolbox"), d4pSettingType::INFO)
            )),
            'icons_mode' => array('name' => __("Icons Mode", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'icons__mode', __("For Icons Use", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('icons__mode', 'features'), 'array', $this->data_attachment_icon_method())
            )),
            'icons_forums' => array('name' => __("Forums List Icons", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Forums Visibility", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'icons__forums_mark_visibility_forum', __("Attachments", "gd-bbpress-toolbox"), __("Mark forums as 'private' or 'hidden' if they are not public.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forums_mark_visibility_forum', 'features'), null, array(), array('label' => __("Forum is not public", "gd-bbpress-toolbox"))),
                new d4pSettingElement('', '', __("Additional forum statuses", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'icons__forums_mark_closed_forum', __("Closed", "gd-bbpress-toolbox"), __("Mark forums that are closed for new topics and replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forums_mark_closed_forum', 'features'), null, array(), array('label' => __("Forum is closed for new posts", "gd-bbpress-toolbox")))
            )),
            'icons_topics' => array('name' => __("Topics List Icons", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Topics and Replies with Attachments", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'icons__forum_mark_attachments', __("Attachments", "gd-bbpress-toolbox"), __("Mark topics that have one or more attachments uploaded to topic and/or replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forum_mark_attachments', 'features'), null, array(), array('label' => __("Topic and replies have one or more attachments", "gd-bbpress-toolbox"))),
                new d4pSettingElement('', '', __("Private Topics and Replies", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'icons__private_topics_icon', __("Private topic", "gd-bbpress-toolbox"), __("Mark topics that have set as private.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__private_topics_icon', 'features'), null, array(), array('label' => __("Topic is private", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'icons__private_replies_icon', __("Private replies", "gd-bbpress-toolbox"), __("Mark topics that have private replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__private_replies_icon', 'features'), null, array(), array('label' => __("Topic has private replies", "gd-bbpress-toolbox"))),
                new d4pSettingElement('', '', __("Temporarily locked topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'icons__forum_mark_lock', __("Lock", "gd-bbpress-toolbox"), __("Mark topics that are temporarily locked.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forum_mark_lock', 'features'), null, array(), array('label' => __("Topic is temporarily locked", "gd-bbpress-toolbox"))),
                new d4pSettingElement('', '', __("Additional topic statuses", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'icons__forum_mark_stick', __("Sticky", "gd-bbpress-toolbox"), __("Mark topics that are set as stick or front stick.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forum_mark_stick', 'features'), null, array(), array('label' => __("Topic is stuck, or stuck to front", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'icons__forum_mark_closed', __("Closed", "gd-bbpress-toolbox"), __("Mark topics that are closed for new replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forum_mark_closed', 'features'), null, array(), array('label' => __("Topic is closed for replies", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'icons__forum_mark_replied', __("Reply", "gd-bbpress-toolbox"), __("Mark topics where current user replies at least once.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('icons__forum_mark_replied', 'features'), null, array(), array('label' => __("Logged in user replied in topic", "gd-bbpress-toolbox")))
            ))
        );

        $settings['user-settings'] = array(
            'user-settings' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Active", "gd-bbpress-toolbox"), __("This feature is always active, and it can't be disabled. You can enable or disable individual settings included.", "gd-bbpress-toolbox"), d4pSettingType::INFO)
            ))
        );

        $settings['custom-views'] = array(
            'custom-views' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Active", "gd-bbpress-toolbox"), __("This feature is always active, and it can't be disabled. You can enable or disable individual settings included.", "gd-bbpress-toolbox"), d4pSettingType::INFO)
            )),
            'custom-views-settings' => array('name' => __("Various settings", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'custom-views__enable_feed', __("RSS Feed", "gd-bbpress-toolbox"), __("Enable RSS feed option for all views that don't require user to be logged in.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__enable_feed', 'features')),
                new d4pSettingElement('features', 'custom-views__with_pending', __("Include Pending", "gd-bbpress-toolbox"), __("Including pending topics in some of the views. This affects New Posts views, and view for Latest Topics, only for the users with moderation capabilities.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__with_pending', 'features'))
            )),
            'custom-views-basic' => array('name' => __("Basic custom topics views", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Topics with most replies", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mostreplies_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mostreplies_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mostreplies_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mostreplies_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mostreplies_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mostreplies_slug', 'features')),
                new d4pSettingElement('', '', __("Latest topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__latesttopics_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__latesttopics_active', 'features')),
                new d4pSettingElement('features', 'custom-views__latesttopics_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__latesttopics_title', 'features')),
                new d4pSettingElement('features', 'custom-views__latesttopics_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__latesttopics_slug', 'features')),
                new d4pSettingElement('', '', __("Topics by freshness", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__topicsfresh_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__topicsfresh_active', 'features')),
                new d4pSettingElement('features', 'custom-views__topicsfresh_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__topicsfresh_title', 'features')),
                new d4pSettingElement('features', 'custom-views__topicsfresh_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__topicsfresh_slug', 'features')),
                new d4pSettingElement('', '', __("Most thanked topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mostthanked_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mostthanked_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mostthanked_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mostthanked_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mostthanked_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mostthanked_slug', 'features')),
                new d4pSettingElement('', '', __("New posts: Last day", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__newposts24h_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__newposts24h_active', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts24h_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts24h_title', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts24h_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts24h_slug', 'features')),
                new d4pSettingElement('', '', __("New posts: Last 3 days", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__newposts3dy_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__newposts3dy_active', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts3dy_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts3dy_title', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts3dy_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts3dy_slug', 'features')),
                new d4pSettingElement('', '', __("New posts: Last week", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__newposts7dy_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__newposts7dy_active', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts7dy_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts7dy_title', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts7dy_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts7dy_slug', 'features')),
                new d4pSettingElement('', '', __("New posts: Last month", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__newposts1mn_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__newposts1mn_active', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts1mn_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts1mn_title', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts1mn_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts1mn_slug', 'features'))
            )),
            'custom-views-moderation' => array('name' => __("Moderation custom topics views", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Pending topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__pending_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__pending_active', 'features')),
                new d4pSettingElement('features', 'custom-views__pending_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__pending_title', 'features')),
                new d4pSettingElement('features', 'custom-views__pending_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__pending_slug', 'features')),
                new d4pSettingElement('', '', __("Spammed topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__spam_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__spam_active', 'features')),
                new d4pSettingElement('features', 'custom-views__spam_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__spam_title', 'features')),
                new d4pSettingElement('features', 'custom-views__spam_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__spam_slug', 'features')),
                new d4pSettingElement('', '', __("Trashed topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__trash_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__trash_active', 'features')),
                new d4pSettingElement('features', 'custom-views__trash_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__trash_title', 'features')),
                new d4pSettingElement('features', 'custom-views__trash_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__trash_slug', 'features'))
            )),
            'custom-views-personal' => array('name' => __("Personal custom topics views", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("New posts since last visit", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__newposts_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__newposts_active', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts_title', 'features')),
                new d4pSettingElement('features', 'custom-views__newposts_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__newposts_slug', 'features')),
                new d4pSettingElement('', '', __("My scheduled topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__myfuture_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__myfuture_active', 'features')),
                new d4pSettingElement('features', 'custom-views__myfuture_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__myfuture_title', 'features')),
                new d4pSettingElement('features', 'custom-views__myfuture_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__myfuture_slug', 'features')),
                new d4pSettingElement('', '', __("My active topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__myactive_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__myactive_active', 'features')),
                new d4pSettingElement('features', 'custom-views__myactive_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__myactive_title', 'features')),
                new d4pSettingElement('features', 'custom-views__myactive_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__myactive_slug', 'features')),
                new d4pSettingElement('', '', __("All my topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mytopics_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mytopics_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mytopics_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mytopics_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mytopics_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mytopics_slug', 'features')),
                new d4pSettingElement('', '', __("Topics with my reply", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__myreply_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__myreply_active', 'features')),
                new d4pSettingElement('features', 'custom-views__myreply_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__myreply_title', 'features')),
                new d4pSettingElement('features', 'custom-views__myreply_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__myreply_slug', 'features')),
                new d4pSettingElement('', '', __("My topics with no replies", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mynoreplies_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mynoreplies_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mynoreplies_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mynoreplies_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mynoreplies_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mynoreplies_slug', 'features')),
                new d4pSettingElement('', '', __("My topics with no replies", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mymostreplies_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mymostreplies_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mymostreplies_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mymostreplies_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mymostreplies_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mymostreplies_slug', 'features')),
                new d4pSettingElement('', '', __("My most thanked topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mymostthanked_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mymostthanked_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mymostthanked_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mymostthanked_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mymostthanked_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mymostthanked_slug', 'features')),
                new d4pSettingElement('', '', __("My favorite topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__myfavorite_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__myfavorite_active', 'features')),
                new d4pSettingElement('features', 'custom-views__myfavorite_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__myfavorite_title', 'features')),
                new d4pSettingElement('features', 'custom-views__myfavorite_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__myfavorite_slug', 'features')),
                new d4pSettingElement('', '', __("My subscribed topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'custom-views__mysubscribed_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('custom-views__mysubscribed_active', 'features')),
                new d4pSettingElement('features', 'custom-views__mysubscribed_title', __("Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('custom-views__mysubscribed_title', 'features')),
                new d4pSettingElement('features', 'custom-views__mysubscribed_slug', __("URL Slug", "gd-bbpress-toolbox"), __("Only letters, numbers and dashes are allowed, it has to be URL safe.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('custom-views__mysubscribed_slug', 'features'))
            ))
        );

        $settings['tweaks'] = array(
            'tweaks' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Active", "gd-bbpress-toolbox"), __("This feature is always active, and it can't be disabled. You can enable or disable individual settings included.", "gd-bbpress-toolbox"), d4pSettingType::INFO)
            )),
            'tweaks_status_404' => array('name' => __("Status Header 404", "gd-bbpress-toolbox"),
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'fixing-404-header-error'), 'settings' => array(
                    new d4pSettingElement('features', 'tweaks__fix_404_headers_error', __("Fix the 404 Errors", "gd-bbpress-toolbox"), __("Due to the WordPress query limitations, user profile and views pages in bbPress return with 404 status.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__fix_404_headers_error', 'features'))
                )),
            'tweaks_media_library' => array('name' => __("Allow Participants to use Media Library", "gd-bbpress-toolbox"),
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'media-library-access-for-participants'), 'settings' => array(
                    new d4pSettingElement('features', 'tweaks__participant_media_library_upload', __("Add Media button in TinyMCE", "gd-bbpress-toolbox"), __("If you use TinyMCE editor, Participants can't use Media Library and Add Media button. By enabling this option, you allow Participants to do this.", "gd-bbpress-toolbox").' '.__("Users will have access to own files in the media library, but, they will be able to upload files through media library dialog, and this plugin can't control how this dialog is used.", "gd-bbpress-toolbox").' <strong>'.__("This operation is not recommended, and you are doing it at your own risk!", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__participant_media_library_upload', 'features'))
                )),
            'tweaks_editor_tags' => array('name' => __("Expand KSES allowed HTML tags and attributes", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'tweaks__kses_allowed_override', __("Allowed tags list", "gd-bbpress-toolbox"), __("By default, only some HTML tags and attributes are allowed when adding HTML in topics or replies. This option allows you to expand list of supported tags and attributes.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('tweaks__kses_allowed_override', 'features'), 'array', $this->data_kses_allowed_tags_override())
            )),
            'tweaks_search' => array('name' => __("Search Form", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Notice", "gd-bbpress-toolbox"), __("The search is global, it is not limited to current forum or topic! In some cases, you might need to adjust theme styling for proper display of the form and surrounding elements.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'tweaks__forum_load_search_for_all_forums', __("Search for all forums", "gd-bbpress-toolbox"), __("Default bbPress search form will be displayed on top of all forums.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__forum_load_search_for_all_forums', 'features')),
                new d4pSettingElement('features', 'tweaks__topic_load_search_for_all_topics', __("Search for all topics", "gd-bbpress-toolbox"), __("Default bbPress search form will be displayed on top of all topics.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__topic_load_search_for_all_topics', 'features'))
            )),
            'tweaks_title_length' => array('name' => __("HTML Maximum Title Length", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'tweaks__title_length_override', __("Custom Length", "gd-bbpress-toolbox"), __("This value is set for title HTML tag through default bbPress filter.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__title_length_override', 'features')),
                new d4pSettingElement('features', 'tweaks__title_length_value', __("Maximum Length Allowed", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('tweaks__title_length_value', 'features'))
            )),
            'tweaks_title_prefix' => array('name' => __("Private Title Prefix", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'tweaks__remove_private_title_prefix', __("The prefix", "gd-bbpress-toolbox"), __("WordPress adds 'Private' prefix to private forums or topic titles. With this option, you can remove this prefix.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__remove_private_title_prefix', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox")))
            )),
            'tweaks_breadcrumbs' => array('name' => __("bbPress Breadcrumbs", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'tweaks__disable_bbpress_breadcrumbs', __("Disable Breadcrumbs", "gd-bbpress-toolbox"), __("This option will disable default bbPress breadcrumbs.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__disable_bbpress_breadcrumbs', 'features'), null, array(), array('label' => __("Disable", "gd-bbpress-toolbox")))
            )),
            'tweaks_freshness' => array('name' => __("Freshness Display", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'tweaks__alternative_freshness_display', __("Alternative Format", "gd-bbpress-toolbox"), __("Display freshness using alternative and shorter format. This tweak affects both admin side and frontend.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('tweaks__alternative_freshness_display', 'features'))
            ))
        );

        $settings['topic-actions'] = array(
            'topic-actions' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Active", "gd-bbpress-toolbox"), __("This feature is always active, and it can't be disabled. You can enable or disable individual settings included.", "gd-bbpress-toolbox"), d4pSettingType::INFO)
            )),
            'topic-actions_list' => array('name' => __("Actions Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Information", "gd-bbpress-toolbox"), __("If the 'Footer Actions' feature is disabled, all actions set to be added to Footer, will be added to standard Header actions block.", "gd-bbpress-toolbox").'<br/><strong>'.$_footer_message.'</strong>', d4pSettingType::INFO),
                new d4pSettingElement('', '', __("Public", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'topic-actions__reply', __("Reply", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__reply', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('', '', __("Keymasters and Moderators", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'topic-actions__edit', __("Edit", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__edit', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__merge', __("Merge", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__merge', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__close', __("Close", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__close', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__stick', __("Stick", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__stick', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__trash', __("Trash", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__trash', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__spam', __("Spam", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__spam', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__approve', __("Approve", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__approve', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('', '', __("Toolbox Features", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'topic-actions__duplicate', __("Duplicate", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__duplicate', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__lock', __("Lock", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__lock', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__thanks', __("Thanks", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__thanks', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__report', __("Report", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__report', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'topic-actions__quote', __("Quote", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('topic-actions__quote', 'features'), 'array', $this->data_actions_location())
            ))
        );

        $settings['reply-actions'] = array(
            'reply-actions' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Active", "gd-bbpress-toolbox"), __("This feature is always active, and it can't be disabled. You can enable or disable individual settings included.", "gd-bbpress-toolbox"), d4pSettingType::INFO)
            )),
            'reply-actions_list' => array('name' => __("Actions Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Information", "gd-bbpress-toolbox"), __("If the 'Footer Actions' feature is disabled, all actions set to be added to Footer, will be added to standard Header actions block.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', __("Public", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'reply-actions__reply', __("Reply", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__reply', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('', '', __("Keymasters and Moderators", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'reply-actions__edit', __("Edit", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__edit', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__move', __("Move", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__move', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__split', __("Split", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__split', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__trash', __("Trash", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__trash', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__spam', __("Spam", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__spam', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__approve', __("Approve", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__approve', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('', '', __("Toolbox Features", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'reply-actions__thanks', __("Thanks", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__thanks', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__report', __("Report", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__report', 'features'), 'array', $this->data_actions_location()),
                new d4pSettingElement('features', 'reply-actions__quote', __("Quote", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('reply-actions__quote', 'features'), 'array', $this->data_actions_location())
            ))
        );

        $settings['editor'] = array(
            'editor' => array('name' => __("Feature Status", "gd-bbpress-toolbox"),
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'setup-rich-text-tinymce-editor-for-topics-and-replies'), 'settings' => array(
                    new d4pSettingElement('load', 'editor', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
                )),
            'editor_topics' => array('name' => __("Topic Editor", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'editor__topic_tinymce', __("TinyMCE Editor", "gd-bbpress-toolbox"), __("Full rich text editor.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__topic_tinymce', 'features')),
                new d4pSettingElement('', '', __("TinyMCE Settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'editor__topic_teeny', __("Compact Editor Toolbar", "gd-bbpress-toolbox"), __("This is lightweight version of the editor with only subset of commonly used buttons.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__topic_teeny', 'features')),
                new d4pSettingElement('features', 'editor__topic_media_buttons', __("Media Buttons", "gd-bbpress-toolbox"), __("Displays the section with the media button and other buttons that third party plugins can add. But, in many cases, these extra buttons can be broken because the editor is loaded on the front end.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__topic_media_buttons', 'features')),
                new d4pSettingElement('features', 'editor__topic_quicktags', __("Quicktags", "gd-bbpress-toolbox"), __("Displays the Visual and HTML tabs. If it is disabled, editor will be Visual only.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__topic_quicktags', 'features')),
                new d4pSettingElement('features', 'editor__topic_wpautop', __("WPAutoP Filter", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('editor__topic_wpautop', 'features')),
                new d4pSettingElement('features', 'editor__topic_textarea_rows', __("Editor rows", "gd-bbpress-toolbox"), '', d4pSettingType::NUMBER, gdbbx()->get('editor__topic_textarea_rows', 'features'))
            )),
            'editor_replies' => array('name' => __("Reply Editor", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'editor__reply_tinymce', __("TinyMCE Editor", "gd-bbpress-toolbox"), __("Full rich text editor.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__reply_tinymce', 'features')),
                new d4pSettingElement('', '', __("TinyMCE Settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'editor__reply_teeny', __("Compact Editor Toolbar", "gd-bbpress-toolbox"), __("This is lightweight version of the editor with only subset of commonly used buttons.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__reply_teeny', 'features')),
                new d4pSettingElement('features', 'editor__reply_media_buttons', __("Media Buttons", "gd-bbpress-toolbox"), __("Displays the section with the media button and other buttons that third party plugins can add. But, in many cases, these extra buttons can be broken because the editor is loaded on the front end.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__reply_media_buttons', 'features')),
                new d4pSettingElement('features', 'editor__reply_quicktags', __("Quicktags", "gd-bbpress-toolbox"), __("Displays the Visual and HTML tabs. If it is disabled, editor will be Visual only.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('editor__reply_quicktags', 'features')),
                new d4pSettingElement('features', 'editor__reply_wpautop', __("WPAutoP Filter", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('editor__reply_wpautop', 'features')),
                new d4pSettingElement('features', 'editor__reply_textarea_rows', __("Editor rows", "gd-bbpress-toolbox"), '', d4pSettingType::NUMBER, gdbbx()->get('editor__reply_textarea_rows', 'features'))
            )),
        );

        $settings['rewriter'] = array(
            'rewriter' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'rewriter', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'rewriter_hierarchy' => array('name' => __("Alternative URL hierarchy", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Notice", "gd-bbpress-toolbox"), __("Changing rewrite rules for topics and replies might not work properly if you have some other plugins that are customizing rewrite rules.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'rewriter__topic_hierarchy', __("For Topics", "gd-bbpress-toolbox"), __("URL's for topics will include full forums hierarchy.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__topic_hierarchy', 'features')),
                new d4pSettingElement('features', 'rewriter__reply_hierarchy', __("For Replies", "gd-bbpress-toolbox"), __("URL's for replies will include full forums and parent topic hierarchy. This is used only for reply URL's showing standalone reply or reply edit page.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__reply_hierarchy', 'features'))
            )),
            'rewriter_cleanup' => array('name' => __("Remove rewrite rules", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Notice", "gd-bbpress-toolbox"), __("These options will remove rewrite rules generated by WordPress. If you are not sure what will happen, don't use these options!", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', __("Forums", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'rewriter__forum_remove_attachments_rules', __("Attachments rules", "gd-bbpress-toolbox"), __("This will remove attachments rules used to display individual media files attached to the post.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__forum_remove_attachments_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'rewriter__forum_remove_comments_rules', __("Comments rules", "gd-bbpress-toolbox"), __("This will remove comments page rules used for displaying comments for a post. bbPress content doesn't use comments, and these rules are useless.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__forum_remove_comments_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'rewriter__forum_remove_feeds_rules', __("RSS Feed rules", "gd-bbpress-toolbox"), __("This will remove RSS feed URL's. If you don't use RSS feeds, you can disable these rules.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__forum_remove_feeds_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('', '', __("Topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'rewriter__topic_remove_attachments_rules', __("Attachments rules", "gd-bbpress-toolbox"), __("This will remove attachments rules used to display individual media files attached to the post.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__topic_remove_attachments_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'rewriter__topic_remove_comments_rules', __("Comments rules", "gd-bbpress-toolbox"), __("This will remove comments page rules used for displaying comments for a post. bbPress content doesn't use comments, and these rules are useless.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__topic_remove_comments_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'rewriter__topic_remove_feeds_rules', __("RSS Feed rules", "gd-bbpress-toolbox"), __("This will remove RSS feed URL's. If you don't use RSS feeds, you can disable these rules.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__topic_remove_feeds_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('', '', __("Replies", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'rewriter__reply_remove_attachments_rules', __("Attachments rules", "gd-bbpress-toolbox"), __("This will remove attachments rules used to display individual media files attached to the post.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__reply_remove_attachments_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'rewriter__reply_remove_comments_rules', __("Comments rules", "gd-bbpress-toolbox"), __("This will remove comments page rules used for displaying comments for a post. bbPress content doesn't use comments, and these rules are useless.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__reply_remove_comments_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'rewriter__reply_remove_feeds_rules', __("RSS Feed rules", "gd-bbpress-toolbox"), __("This will remove RSS feed URL's. If you don't use RSS feeds, you can disable these rules.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('rewriter__reply_remove_feeds_rules', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox")))
            ))
        );

        $settings['snippets'] = array(
            'snippets' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'snippets', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('snippets', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'snippets_breadcrumbs' => array('name' => __("Breadcrumbs", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'snippets__breadcrumbs', __("Add JSON-LD snippet", "gd-bbpress-toolbox"), __("This option will modify bbPress generated breadcrumbs to make them Google Rich Snippet compatible. This will work only if you have not modified bbPress breadcrumbs in some other way.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('snippets__breadcrumbs', 'features'))
            )),
            'snippets_topic_dfp' => array('name' => __("Discussion Forum Posting", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'snippets__topic_dfp', __("Add JSON-LD snippet", "gd-bbpress-toolbox"), sprintf(__("This option add %s snippet to every topic.", "gd-bbpress-toolbox"), 'DiscussionForumPosting'), d4pSettingType::BOOLEAN, gdbbx()->get('snippets__topic_dfp', 'features')),
                new d4pSettingElement('', '', __("Fallback Image", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'snippets__topic_dfp_fallback_image', __("Fallback Image", "gd-bbpress-toolbox"), __("Each snippet has to have image. If your topic doesn't have featured image, you need to specify the fallback image to be used for all topics without featured image. If you use Attachments upload, you can enable option to automatically make first attached image a featured image for the topic.", "gd-bbpress-toolbox"), d4pSettingType::IMAGE, gdbbx()->get('snippets__topic_dfp_fallback_image', 'features')),
                new d4pSettingElement('', '', __("Optional Elements", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'snippets__topic_dfp_include_article_body', __("Topic Content", "gd-bbpress-toolbox"), __("If you choose to include the topic content, it will filtered and all HTML and empty lines will be stripped. Plugin will attempt to return very much stripped down version of the content.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('snippets__topic_dfp_include_article_body', 'features')),
                new d4pSettingElement('', '', __("Topic Author", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'snippets__topic_dfp_include_author_profile_url', __("Include profile URL", "gd-bbpress-toolbox"), __("Include URL to the author forum profile.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('snippets__topic_dfp_include_author_profile_url', 'features')),
                new d4pSettingElement('features', 'snippets__topic_dfp_include_author_website_url', __("Include website URL", "gd-bbpress-toolbox"), __("Include URL to the author website, if the website URL is provided through the profile.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('snippets__topic_dfp_include_author_website_url', 'features')),
                new d4pSettingElement('', '', __("Publisher Information", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'snippets__topic_dfp_publisher_type', __("Type", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('snippets__topic_dfp_publisher_type', 'features'), 'array', $this->data_snippet_type()),
                new d4pSettingElement('features', 'snippets__topic_dfp_publisher_name', __("Name", "gd-bbpress-toolbox"), __("This element is required.", "gd-bbpress-toolbox").' '.__("If empty, website name will be used.", "gd-bbpress-toolbox"), d4pSettingType::TEXT, gdbbx()->get('snippets__topic_dfp_publisher_name', 'features')),
                new d4pSettingElement('features', 'snippets__topic_dfp_publisher_logo', __("Logo", "gd-bbpress-toolbox"), __("This element is required.", "gd-bbpress-toolbox"), d4pSettingType::IMAGE, gdbbx()->get('snippets__topic_dfp_publisher_logo', 'features')),
            ))
        );

        $settings['clickable'] = array(
            'clickable' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'clickable', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'clickable_filters' => array('name' => __("Disable Clickable Filters", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'clickable__disable_make_clickable_topic', __("For Topics", "gd-bbpress-toolbox"), __("This filter will convert strings into clickable HTML elements for URL, email and other things.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable__disable_make_clickable_topic', 'features'), null, array(), array('label' => __("Disable Filter", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'clickable__disable_make_clickable_reply', __("For Replies", "gd-bbpress-toolbox"), __("This filter will convert strings into clickable HTML elements for URL, email and other things.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable__disable_make_clickable_reply', 'features'), null, array(), array('label' => __("Disable Filter", "gd-bbpress-toolbox")))
            )),
            'clickable_actions' => array('name' => __("Remove Clickable Actions", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Notice", "gd-bbpress-toolbox"), __("These actions will be executed if one or both 'Make Clickable' filters are active.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'clickable__remove_clickable_urls', __("URLs", "gd-bbpress-toolbox"), __("Remove replacing the text URLs with the working link tags.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable__remove_clickable_urls', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'clickable__remove_clickable_ftps', __("FTPs", "gd-bbpress-toolbox"), __("Remove replacing the text FTPs with the working link tags.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable__remove_clickable_ftps', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'clickable__remove_clickable_emails', __("Emails", "gd-bbpress-toolbox"), __("Remove replacing the text emails with the working link tags.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable__remove_clickable_emails', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'clickable__remove_clickable_mentions', __("@Mentions", "gd-bbpress-toolbox"), __("Remove replacing the @mentions with the links to the user profiles.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('clickable__remove_clickable_mentions', 'features'), null, array(), array('label' => __("Remove", "gd-bbpress-toolbox"))),
            ))
        );

        $settings['privacy'] = array(
            'privacy' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'privacy', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('privacy', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'privacy_ip' => array('name' => __("IP", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'privacy__disable_ip_logging', __("IP Logging", "gd-bbpress-toolbox"), __("This will stop bbPress from logging IP addresses with each post.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('privacy__disable_ip_logging', 'features'), null, array(), array('label' => __("Disabled", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'privacy__disable_ip_display', __("IP Display", "gd-bbpress-toolbox"), __("IP addresses are visible to forum keymaster role. This will stop bbPress from displaying IP addresses.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('privacy__disable_ip_display', 'features'), null, array(), array('label' => __("Disabled", "gd-bbpress-toolbox")))
            ))
        );

        $settings['seo-tweaks'] = array(
            'seo-tweaks' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'seo-tweaks', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'seo-tweaks_private' => array('name' => __("Private Topics and Replies", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'seo-tweaks__noindex_private_topic', __("Private Topic", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks__noindex_private_topic', 'features'), null, array(), array('label' => __("Robots Meta NoIndex", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'seo-tweaks__noindex_private_reply', __("Private Reply", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks__noindex_private_reply', 'features'), null, array(), array('label' => __("Robots Meta NoIndex", "gd-bbpress-toolbox")))
            )),
            'seo-tweaks_nofollow' => array('name' => __("bbPress NoFollow for Links", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'seo-tweaks__nofollow_topic_content', __("Topic Content", "gd-bbpress-toolbox"), __("bbPress modifies all links in topic content and adds (and overrides) 'nofollow' rel attribute.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks__nofollow_topic_content', 'features'), null, array(), array('label' => __("Enabled NoFollow", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'seo-tweaks__nofollow_reply_content', __("Reply Content", "gd-bbpress-toolbox"), __("bbPress modifies all links in reply content and adds (and overrides) 'nofollow' rel attribute.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks__nofollow_reply_content', 'features'), null, array(), array('label' => __("Enabled NoFollow", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'seo-tweaks__nofollow_topic_author', __("Topic Author Link", "gd-bbpress-toolbox"), __("bbPress modifies topic author links and adds (and overrides) 'nofollow' rel attribute.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks__nofollow_topic_author', 'features'), null, array(), array('label' => __("Enabled NoFollow", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'seo-tweaks__nofollow_reply_author', __("Reply Author Link", "gd-bbpress-toolbox"), __("bbPress modifies reply author links and adds (and overrides) 'nofollow' rel attribute.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('seo-tweaks__nofollow_reply_author', 'features'), null, array(), array('label' => __("Enabled NoFollow", "gd-bbpress-toolbox")))
            ))
        );

        $settings['users-stats'] = array(
            'users-stats' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'users-stats', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('users-stats', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'users-stats_visibility' => array('name' => __("Show user statistics", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'users-stats__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__super_admin', 'features')),
                new d4pSettingElement('features', 'users-stats__visitor', __("Available to visitors", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__visitor', 'features')),
                new d4pSettingElement('features', 'users-stats__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('users-stats__roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            )),
            'users-stats_elements' => array('name' => __("Choose what to show", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'users-stats__show_online_status', __("Show online status", "gd-bbpress-toolbox"), __("Only if online status tracking is enabled.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__show_online_status', 'features')),
                new d4pSettingElement('features', 'users-stats__show_registration_date', __("Show registration date", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__show_registration_date', 'features')),
                new d4pSettingElement('features', 'users-stats__show_topics', __("Show topics count", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__show_topics', 'features')),
                new d4pSettingElement('features', 'users-stats__show_replies', __("Show replies count", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__show_replies', 'features')),
                new d4pSettingElement('features', 'users-stats__show_thanks_given', __("Show thanks given count", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__show_thanks_given', 'features')),
                new d4pSettingElement('features', 'users-stats__show_thanks_received', __("Show thanks received count", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('users-stats__show_thanks_received', 'features'))
            ))
        );

        $settings['quote'] = array(
            'quote' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'quote', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('quote', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'quote_allowed' => array('name' => __("Allow use of Quotes", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'quote__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('quote__super_admin', 'features')),
                new d4pSettingElement('features', 'quote__visitor', __("Available to visitors", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('quote__visitor', 'features')),
                new d4pSettingElement('features', 'quote__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('quote__roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            )),
            'quote_settings' => array('name' => __("Basic Settings", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'quote__method', __("Quote Method", "gd-bbpress-toolbox"), __("If you want to use BBCode method, you need to enable BBCodes support also.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('quote__method', 'features'), 'array', $this->data_quote_button_method()),
                new d4pSettingElement('features', 'quote__full_content', __("BBCode to use", "gd-bbpress-toolbox"), __("If Post Quote is selected, when quote button is used for full post (not selection), BBCode 'postquote' will be used with post ID only.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('quote__full_content', 'features'), 'array', $this->data_quote_bbcode())
            ))
        );

        $settings['visitors-redirect'] = array(
            'visitors-redirect' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'visitors-redirect', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('visitors-redirect', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'visitors-redirect_nonlogged' => array('name' => __("Redirect visitors to custom URL", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'visitors-redirect__for_visitors', __("Status", "gd-bbpress-toolbox"), __("If non-logged user (or visitor) attempts to access any forum page, it will be redirected to custom URL or home page.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('visitors-redirect__for_visitors', 'features'), null, array(), array('label' => __("Redirect non-logged visitors", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'visitors-redirect__for_visitors_url', __("Redirect to", "gd-bbpress-toolbox"), __("If empty, it will redirect to website home page.", "gd-bbpress-toolbox"), d4pSettingType::LINK, gdbbx()->get('visitors-redirect__for_visitors_url', 'features'))
            )),
            'visitors-redirect_hidden' => array('name' => __("Redirect hidden forums access attempt to custom URL", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'visitors-redirect__hidden_forums', __("Status", "gd-bbpress-toolbox"), __("Any user trying to access hidden forum, and has no rights to do that, will be redirected to custom URL. If this option is disabled, user will see the 404 page.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('visitors-redirect__hidden_forums', 'features')),
                new d4pSettingElement('features', 'visitors-redirect__hidden_forums_url', __("Redirect to", "gd-bbpress-toolbox"), __("If empty, it will redirect to website home page.", "gd-bbpress-toolbox"), d4pSettingType::LINK, gdbbx()->get('visitors-redirect__hidden_forums_url', 'features'))
            )),
            'visitors-redirect_private' => array('name' => __("Redirect private forums access attempt to custom URL", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'visitors-redirect__private_forums', __("Status", "gd-bbpress-toolbox"), __("Any user trying to access a private forum, and has no rights to do that, will be redirected to custom URL. If this option is disabled, user will see the  404 page.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('visitors-redirect__private_forums', 'features')),
                new d4pSettingElement('features', 'visitors-redirect__private_forums_url', __("Redirect to", "gd-bbpress-toolbox"), __("If empty, it will redirect to website home page.", "gd-bbpress-toolbox"), d4pSettingType::LINK, gdbbx()->get('visitors-redirect__private_forums_url', 'features'))
            )),
            'visitors-redirect_blocked' => array('name' => __("Redirect blocked users to custom URL", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'visitors-redirect__blocked_users', __("Status", "gd-bbpress-toolbox"), __("Any blocked user trying to access forums, will be redirected to custom URL. If this option is disabled, user will see the 404 page.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('visitors-redirect__blocked_users', 'features')),
                new d4pSettingElement('features', 'visitors-redirect__blocked_users_url', __("Redirect to", "gd-bbpress-toolbox"), __("If empty, it will redirect to website home page.", "gd-bbpress-toolbox"), d4pSettingType::LINK, gdbbx()->get('visitors-redirect__blocked_users_url', 'features'))
            ))
        );

        $settings['toolbar'] = array(
            'toolbar' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'toolbar', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('toolbar', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'toolbar__control' => array('name' => __("Toolbar Control", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'toolbar__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('toolbar__super_admin', 'features')),
                new d4pSettingElement('features', 'toolbar__visitor', __("Available to visitors", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('toolbar__visitor', 'features')),
                new d4pSettingElement('features', 'toolbar__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('toolbar__roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            )),
            'toolbar__looks' => array('name' => __("Additional Settings", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'toolbar__title', __("Menu Title", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('toolbar__title', 'features')),
                new d4pSettingElement('features', 'toolbar__information', __("Information Submenu", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('toolbar__information', 'features'))
            ))
        );

        $settings['objects'] = array(
            'objects' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'objects', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('objects', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'objects_forum' => array('name' => __("Forum Extra Features", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'objects__add_forum_features', __("Forum Features", "gd-bbpress-toolbox"), __("These will be added when registering forum post type.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('objects__add_forum_features', 'features'), 'array', $this->data_extra_features(), array('class' => 'gdbbx-bbcodes'))
            )),
            'objects_topic' => array('name' => __("Topic Extra Features", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'objects__add_topic_features', __("Topic Features", "gd-bbpress-toolbox"), __("These will be added when registering topic post type.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('objects__add_topic_features', 'features'), 'array', $this->data_extra_features(), array('class' => 'gdbbx-bbcodes'))
            )),
            'objects_reply' => array('name' => __("Reply Extra Features", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'objects__add_reply_features', __("Reply Features", "gd-bbpress-toolbox"), __("These will be added when registering reply post type.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('objects__add_reply_features', 'features'), 'array', $this->data_extra_features(), array('class' => 'gdbbx-bbcodes'))
            ))
        );

        $settings['publish'] = array(
            'publish' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'publish', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('publish', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'publish_status' => array('name' => __("Site public status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'publish__bbp_is_site_public', __("Status", "gd-bbpress-toolbox"), __("Some bbPress features depend on the site public status. This option will override the default status generated based on the WordPress settings.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('publish__bbp_is_site_public', 'features'), 'array', $this->data_site_public())
            ))
        );

        $settings['mime-types'] = array(
            'mime-types' => array('name' => __("Feature Status", "gd-bbpress-toolbox"),
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'attachments-mime-types'), 'settings' => array(
                    new d4pSettingElement('load', 'mime-types', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('mime-types', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
                )),
            'mime-types_list' => array('name' => __("Additional MIME Types", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'mime-types__list', __("MIME Types", "gd-bbpress-toolbox"), '', d4pSettingType::EXPANDABLE_PAIRS, gdbbx()->get('mime-types__list', 'features'), '', array(), array('label_key' => __("Extensions (Vertical pipe separated)", "gd-bbpress-toolbox"), 'label_value' => __("MIME Type", "gd-bbpress-toolbox"), 'label_button_add' => __("Add New MIME Type", "gd-bbpress-toolbox"), 'label_buttom_remove' => __("Remove", "gd-bbpress-toolbox"))),
            ))
        );

        $settings['private-topics'] = array(
            'private-topics' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'private-topics', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-topics', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'private-topics_settings' => array('name' => __("Private Topics", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'private-topics__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('private-topics__super_admin', 'features')),
                new d4pSettingElement('features', 'private-topics__visitor', __("Available to visitors", "gd-bbpress-toolbox"), __("If anonymous (visitor) creates private topic only administrators and moderators can read the topic.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-topics__visitor', 'features')),
                new d4pSettingElement('features', 'private-topics__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('private-topics__roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'private-topics__moderators_can_read', __("Moderators Access", "gd-bbpress-toolbox"), __("By default, all moderators (and administrators) can read private posts. You can disable that with this option. But, this is only frontend option, moderators and administrators can read everything on the admin side.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-topics__moderators_can_read', 'features')),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'private-topics__default', __("Default", "gd-bbpress-toolbox"), __("This is related to new topics only, not edits.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('private-topics__default', 'features'), 'array', $this->data_private_checked_status()),
                new d4pSettingElement('features', 'private-topics__form_position', __("Form Position", "gd-bbpress-toolbox"), __("Choose where the private checkbox is displayed.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('private-topics__form_position', 'features'), 'array', $this->data_form_position_topic())
            ))
        );

        $settings['private-replies'] = array(
            'private-replies' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'private-replies', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-replies', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'private-replies_settings' => array('name' => __("Private Replies", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'private-replies__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('private-replies__super_admin', 'features')),
                new d4pSettingElement('features', 'private-replies__visitor', __("Available to visitors", "gd-bbpress-toolbox"), __("If anonymous (visitor) creates private reply only administrators and moderators can read the reply.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-replies__visitor', 'features')),
                new d4pSettingElement('features', 'private-replies__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('private-replies__roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'private-replies__moderators_can_read', __("Moderators Access", "gd-bbpress-toolbox"), __("By default, all moderators (and administrators) can read private posts. You can disable that with this option. But, this is only frontend option, moderators and administrators can read everything on the admin side.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-replies__moderators_can_read', 'features')),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'private-replies__default', __("Default", "gd-bbpress-toolbox"), __("This is related to new replies only, not edits.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('private-replies__default', 'features'), 'array', $this->data_private_checked_status()),
                new d4pSettingElement('features', 'private-replies__threaded', __("Threaded Replies", "gd-bbpress-toolbox"), __("If enabled, plugin will support threaded replies. Author of parent reply will see private replies to his replies. Currently, this works only for direct descendant replies only.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-replies__threaded', 'features')),
                new d4pSettingElement('features', 'private-replies__form_position', __("Form Position", "gd-bbpress-toolbox"), __("Choose where the private checkbox is displayed.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('private-replies__form_position', 'features'), 'array', $this->data_form_position_reply()),
                new d4pSettingElement('features', 'private-replies__css_hide', __("Hide using CSS/JS", "gd-bbpress-toolbox"), __("Hide private reply in the topic thread from users with no access rights using CSS and JavaScript (this might not work with every theme).", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('private-replies__css_hide', 'features'))
            ))
        );

        $settings['thanks'] = array(
            'thanks' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'thanks', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('thanks', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'thanks_allow' => array('name' => __("Available for roles", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'thanks__allow_super_admin', __("Super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('thanks__allow_super_admin', 'features')),
                new d4pSettingElement('features', 'thanks__allow_roles', __("Roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('thanks__allow_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            )),
            'thanks_options' => array('name' => __("Controls", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'thanks__removal', __("Allow thanks removal", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('thanks__removal', 'features')),
                new d4pSettingElement('features', 'thanks__topic', __("Available for Topics", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('thanks__topic', 'features')),
                new d4pSettingElement('features', 'thanks__reply', __("Available for Replies", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('thanks__reply', 'features'))
            )),
            'thanks_display' => array('name' => __("Display", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'thanks__limit_display', __("Limit displayed", "gd-bbpress-toolbox"), __("This will limit number of users to show inside the thanks block. Too many users displayed can slow down loading.", "gd-bbpress-toolbox"), d4pSettingType::INTEGER, gdbbx()->get('thanks__limit_display', 'features')),
                new d4pSettingElement('features', 'thanks__display_date', __("Thanks date", "gd-bbpress-toolbox"), __("Show date or age of the thanks with each displayed user.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('thanks__display_date', 'features'), 'array', $this->data_thanks_date_display())
            )),
            'thanks_notify' => array('name' => __("Notifications", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'thanks__notify_active', __("To author", "gd-bbpress-toolbox"), __("Send notification to topic or reply authors when they get new thanks.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('thanks__notify_active', 'features')),
                new d4pSettingElement('', '', __("Override notification content", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'thanks__notify_override', __("Override content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('thanks__notify_override', 'features')),
                new d4pSettingElement('features', 'thanks__notify_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %THANKS_AUTHOR%, %POST_TITLE%, %POST_LINK%, %FORUM_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('thanks__notify_content', 'features')),
                new d4pSettingElement('features', 'thanks__notify_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %THANKS_AUTHOR%, %POST_TITLE%, %FORUM_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('thanks__notify_subject', 'features')),
                new d4pSettingElement('', '', __("Additional settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'thanks__notify_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('thanks__notify_shortcodes', 'features'))
            ))
        );

        $settings['admin-access'] = array(
            'admin-access' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'admin-access', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-access', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'admin-access_roles' => array('name' => __("Select roles to have access", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'admin-access__disable_roles', __("Access for roles", "gd-bbpress-toolbox"), __("Super admin will always have full access. All roles with limited access will still have limited access even if allowed access here.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('admin-access__disable_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            ))
        );

        $settings['report'] = array(
            'report' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'report', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('report', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'report_status' => array('name' => __("Reporting Basics", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'report__report_mode', __("Mode", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('report__report_mode', 'features'), 'array', $this->data_report_mode()),
                new d4pSettingElement('features', 'report__allow_roles', __("Roles", "gd-bbpress-toolbox"), __("Only users with selected roles can post reports.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('report__allow_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'report__scroll_form', __("Scroll to Form", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('report__scroll_form', 'features')),
            )),
            'report_info' => array('name' => __("Display Report Information", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'report__show_report_status', __("Status", "gd-bbpress-toolbox"), __("For each reported topic or reply show the notice that it is reported.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('report__show_report_status', 'features')),
                new d4pSettingElement('features', 'report__show_report_status_to_moderators_only', __("To Moderators only", "gd-bbpress-toolbox"), __("Only keymasters and moderators will be able to see the reported message.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('report__show_report_status_to_moderators_only', 'features'))
            )),
            'report_notify' => array('name' => __("Notifications", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'report__notify_active', __("Send", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('report__notify_active', 'features')),
                new d4pSettingElement('features', 'report__notify_keymasters', __("Send to Keymasters", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('report__notify_keymasters', 'features')),
                new d4pSettingElement('features', 'report__notify_moderators', __("Send to Moderators", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('report__notify_moderators', 'features')),
                new d4pSettingElement('features', 'report__notify_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('report__notify_shortcodes', 'features')),
                new d4pSettingElement('features', 'report__notify_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %REPORT_AUTHOR%, %REPORT_CONTENT%, %REPORT_LINK%, %REPORT_TITLE%, %REPORTS_LIST%, %FORUM_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('report__notify_content', 'features')),
                new d4pSettingElement('features', 'report__notify_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %REPORT_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('report__notify_subject', 'features'))
            ))
        );

        $settings['signatures'] = array(
            'signatures' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'signatures', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('signatures', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'signatures_control' => array('name' => __("User Signatures", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'signatures__limiter', __("Limit Counter", "gd-bbpress-toolbox"), __("Use JavaScript to show signature length and limit. This will not work if the TinyMCE editor is used for signatures.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('signatures__limiter', 'features')),
                new d4pSettingElement('features', 'signatures__length', __("Maximum Length", "gd-bbpress-toolbox"), '', d4pSettingType::NUMBER, gdbbx()->get('signatures__length', 'features')),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'signatures__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('signatures__super_admin', 'features')),
                new d4pSettingElement('features', 'signatures__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('signatures__roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'signatures__scope', __("Store signature as", "gd-bbpress-toolbox"), __("If you run WordPress Network, with bbPress used on more then one website in the network, it is better to use Local storage, or signature would be the same on each website.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('signatures__scope', 'features'), 'array', $this->data_signature_scopes())
            )),
            'signatures_editing' => array('name' => __("Signatures Editing", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Important", "gd-bbpress-toolbox"), __("You can limit the ability to edit the signatures only to selected roles. This way, signatures will be enabled, but only some users will be able to edit them. You can set only for the Keymaster to be able to edit signatures for other users.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                new d4pSettingElement('features', 'signatures__edit_super_admin', __("Super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('signatures__edit_super_admin', 'features')),
                new d4pSettingElement('features', 'signatures__edit_roles', __("Roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('signatures__edit_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            )),
            'signatures_enhanced' => array('name' => __("Enhanced Signatures", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'signatures__enhanced_active', __("Active", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('signatures__enhanced_active', 'features')),
                new d4pSettingElement('features', 'signatures__enhanced_super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('signatures__enhanced_super_admin', 'features')),
                new d4pSettingElement('features', 'signatures__enhanced_roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('signatures__enhanced_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'signatures__enhanced_method', __("Allowed Content", "gd-bbpress-toolbox"), __("If the editor type is set to TinyMCE, HTML will be allowed regardless of this option.", "gd-bbpress-toolbox").' <strong>'.sprintf(__("Make sure to read <a href='%s' target='_blank'>this article</a> before configuring this option to understand limitations related to frontend signature editing.", "gd-bbpress-toolbox"), 'https://support.dev4press.com/kb/article/signatures-with-bbcodes-editing-limitations/').'</strong>', d4pSettingType::SELECT, gdbbx()->get('signatures__enhanced_method', 'features'), 'array', $this->data_enhanced_signature_method()),
                new d4pSettingElement('features', 'signatures__editor', __("Editor Type", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('signatures__editor', 'features'), 'array', $this->data_enhanced_editor_types())
            )),
            'signatures_processing' => array('name' => __("Display Processing", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'signatures__process_smilies', __("Convert Smilies", "gd-bbpress-toolbox"), __("Convert smilies characters into inline images.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('signatures__process_smilies', 'features')),
                new d4pSettingElement('features', 'signatures__process_chars', __("Convert Chars", "gd-bbpress-toolbox"), __("Run standard WordPress Unicode chars conversion and cleanup.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('signatures__process_chars', 'features')),
                new d4pSettingElement('features', 'signatures__process_autop', __("Convert AutoP", "gd-bbpress-toolbox"), __("Run standard WordPress AutoP function.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('signatures__process_autop', 'features'))
            ))
        );

        $settings['lock-topics'] = array(
            'lock-topics' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'lock-topics', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('lock-topics', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'lock-forums_topic_form' => array('name' => __("Lock Topic Control", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'lock-topics__lock', __("Status", "gd-bbpress-toolbox"), __("Show lock/unlock options for individual topics. The option will not be available in the topics belonging to the forums that are already locked.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('lock-topics__lock', 'features'))
            ))
        );

        $settings['lock-forums'] = array(
            'lock-forums' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'lock-forums', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('lock-forums', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'lock-forums_topic_form' => array('name' => __("Topic Form", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'lock-forums__topic_form_locked', __("Status", "gd-bbpress-toolbox"), __("Topic form (edit or new) will be disabled. Only user roles listed below can create or edit topics.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('lock-forums__topic_form_locked', 'features'), null, array(), array('label' => __("Disable Topic Form", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'lock-forums__topic_form_allow_super_admin', __("Allowed to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('lock-forums__topic_form_allow_super_admin', 'features')),
                new d4pSettingElement('features', 'lock-forums__topic_form_allow_roles', __("Allowed to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('lock-forums__topic_form_allow_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'lock-forums__topic_form_message', __("Lock message", "gd-bbpress-toolbox"), __("If the form is locked, this message will be displayed instead.", "gd-bbpress-toolbox"), d4pSettingType::TEXT_HTML, gdbbx()->get('lock-forums__topic_form_message', 'features'))
            )),
            'lock-forums_reply_form' => array('name' => __("Reply Form", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'lock-forums__reply_form_locked', __("Status", "gd-bbpress-toolbox"), __("Reply form (edit or new) will be disabled. Only user roles listed below can create or edit replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('lock-forums__reply_form_locked', 'features'), null, array(), array('label' => __("Disable Reply Form", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'lock-forums__reply_form_allow_super_admin', __("Allowed to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('lock-forums__reply_form_allow_super_admin', 'features')),
                new d4pSettingElement('features', 'lock-forums__reply_form_allow_roles', __("Allowed to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('lock-forums__reply_form_allow_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'lock-forums__reply_form_message', __("Lock message", "gd-bbpress-toolbox"), __("If the form is locked, this message will be displayed instead.", "gd-bbpress-toolbox"), d4pSettingType::TEXT_HTML, gdbbx()->get('lock-forums__reply_form_message', 'features'))
            ))
        );

        $settings['canned-replies'] = array(
            'canned-replies' => array('name' => __("Feature Status", "gd-bbpress-toolbox"),
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'canned-replies'), 'settings' => array(
                    new d4pSettingElement('load', 'canned-replies', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('canned-replies', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
                )),
            'canned-replies_status' => array('name' => __("Activity", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'canned-replies__canned_roles', __("User roles", "gd-bbpress-toolbox"), __("User with selected roles will be able to see the list of canned replies and insert them into content.", "gd-bbpress-toolbox"), d4pSettingType::CHECKBOXES, gdbbx()->get('canned-replies__canned_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'canned-replies__use_taxonomy', __("Use Categories", "gd-bbpress-toolbox"), __("If you plan to add many canned replies, it is a good idea to keep them categorized.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('canned-replies__use_taxonomy', 'features')),
                new d4pSettingElement('features', 'canned-replies__auto_close_on_insert', __("Auto close on insert", "gd-bbpress-toolbox"), __("Canned Replies box will auto close when you click to insert reply into editor.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('canned-replies__auto_close_on_insert', 'features'))
            )),
            'canned-replies_labels' => array('name' => __("Labels", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Post Type", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'canned-replies__post_type_singular', __("Singular", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('canned-replies__post_type_singular', 'features')),
                new d4pSettingElement('features', 'canned-replies__post_type_plural', __("Plural", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('canned-replies__post_type_plural', 'features')),
                new d4pSettingElement('', '', __("Category", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'canned-replies__taxonomy_singular', __("Singular", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('canned-replies__taxonomy_singular', 'features')),
                new d4pSettingElement('features', 'canned-replies__taxonomy_plural', __("Plural", "gd-bbpress-toolbox"), '', d4pSettingType::TEXT, gdbbx()->get('canned-replies__taxonomy_plural', 'features'))
            ))
        );

        $settings['protect-revisions'] = array(
            'protect-revisions' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'protect-revisions', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('protect-revisions', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'protect-revisions_access' => array('name' => __("Select who can view revisions", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Authors", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'protect-revisions__allow_author', __("Post author", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('protect-revisions__allow_author', 'features')),
                new d4pSettingElement('features', 'protect-revisions__allow_topic_author', __("Topic author (for replies)", "gd-bbpress-toolbox"), __("If the post is reply, this will take into account author of the topic too.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('protect-revisions__allow_topic_author', 'features')),
                new d4pSettingElement('', '', __("Other Users and Visitors", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'protect-revisions__allow_super_admin', __("Super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('protect-revisions__allow_super_admin', 'features')),
                new d4pSettingElement('features', 'protect-revisions__allow_visitor', __("Visitors/Guests", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('protect-revisions__allow_visitor', 'features')),
                new d4pSettingElement('features', 'protect-revisions__allow_roles', __("User Roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('protect-revisions__allow_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            ))
        );

        $settings['footer-actions'] = array(
            'footer-actions' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'footer-actions', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('footer-actions', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            ))
        );

        $settings['admin-widgets'] = array(
            'admin-widgets' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'admin-widgets', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-widgets', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'admin-widgets_list' => array('name' => __("Add Widgets", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'admin-widgets__online', __("Online Users", "gd-bbpress-toolbox"), __("This will add Online Users dashboard widget.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-widgets__online', 'features'), null, array(), array('label' => __("Add Widget", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'admin-widgets__activity', __("Latest Activity", "gd-bbpress-toolbox"), __("This will add Latest Activity dashboard widget that includes recent topics and replies.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-widgets__activity', 'features'), null, array(), array('label' => __("Add Widget", "gd-bbpress-toolbox")))
            ))
        );

        $settings['admin-columns'] = array(
            'admin-columns' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'admin-columns', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'admin-columns_forums' => array('name' => __("Forums Panel", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'admin-columns__forum_subscriptions', __("Subscribers Count", "gd-bbpress-toolbox"), __("Column with count of users that subscribed to the forum.", "gd-bbpress-toolbox").'<br/><strong>'.__("This feature requires bbPress 2.6 or newer.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__forum_subscriptions', 'features'))
            )),
            'admin-columns_topics' => array('name' => __("Topics Panel", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'admin-columns__topic_attachments', __("Attachments Count", "gd-bbpress-toolbox"), __("Column with number of attachments.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__topic_attachments', 'features')),
                new d4pSettingElement('features', 'admin-columns__topic_private', __("Private Status", "gd-bbpress-toolbox"), __("Column with privacy status.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__topic_private', 'features')),
                new d4pSettingElement('features', 'admin-columns__topic_subscriptions', __("Subscribers Count", "gd-bbpress-toolbox"), __("Column with count of users that subscribed to the topic.", "gd-bbpress-toolbox").'<br/><strong>'.__("This feature requires bbPress 2.6 or newer.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__topic_subscriptions', 'features')),
                new d4pSettingElement('features', 'admin-columns__topic_favorites', __("Favourites Count", "gd-bbpress-toolbox"), __("Column with count of users that favorited the topic.", "gd-bbpress-toolbox").'<br/><strong>'.__("This feature requires bbPress 2.6 or newer.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__topic_favorites', 'features'))
            )),
            'admin-columns_replies' => array('name' => __("Replies Panel", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'admin-columns__reply_attachments', __("Attachments Count", "gd-bbpress-toolbox"), __("Column with number of attachments.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__reply_attachments', 'features')),
                new d4pSettingElement('features', 'admin-columns__reply_private', __("Private Status", "gd-bbpress-toolbox"), __("Column with privacy status.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__reply_private', 'features'))
            )),
            'admin-columns_users' => array('name' => __("Users Panel", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'admin-columns__user_content', __("Topics/Replies Count", "gd-bbpress-toolbox"), __("Two columns for topics and replies with counts and links to filter them by user.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__user_content', 'features')),
                new d4pSettingElement('features', 'admin-columns__user_last_activity', __("Last activity", "gd-bbpress-toolbox"), __("Column with the user last activity date and time.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('admin-columns__user_last_activity', 'features'))
            ))
        );

        $settings['forum-index'] = array(
            'forum-index' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'forum-index', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('forum-index', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'forum-index_welcome' => array('name' => __("User welcome overview", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'forum-index__welcome_front', __("Load", "gd-bbpress-toolbox"), __("Main forums index, underneath the list of forums, will show the basic forums statistics.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__welcome_front', 'features')),
                new d4pSettingElement('features', 'forum-index__welcome_filter', __("Location", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('forum-index__welcome_filter', 'features'), 'array', $this->data_forum_index_filters()),
                new d4pSettingElement('features', 'forum-index__welcome_front_roles', __("Show to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('forum-index__welcome_front_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('', '', __("Welcome Back Block", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'forum-index__welcome_show_links', __("Show important links for a user", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__welcome_show_links', 'features'))
            )),
            'forum-index_stats' => array('name' => __("Forums statistics overview", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'forum-index__statistics_front', __("Load", "gd-bbpress-toolbox"), __("Main forums index, underneath the list of forums, will show the basic forums statistics.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_front', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_filter', __("Location", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('forum-index__statistics_filter', 'features'), 'array', $this->data_forum_index_filters()),
                new d4pSettingElement('features', 'forum-index__statistics_front_roles', __("Show to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('forum-index__statistics_front_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'forum-index__statistics_front_visitor', __("Show to visitors", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_front_visitor', 'features')),
                new d4pSettingElement('', '', __("Users Block", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'forum-index__statistics_show_online', __("Show active users block", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_online', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_online_overview', __("Show online users overview", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_online_overview', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_online_top', __("Show most online users", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_online_top', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_users', __("Show active users", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('forum-index__statistics_show_users', 'features'), 'array', $this->data_active_users_period()),
                new d4pSettingElement('features', 'forum-index__statistics_show_users_colors', __("Show users color coded", "gd-bbpress-toolbox"), __("Each user will be displayed with different color according to user role.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_users_colors', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_users_avatars', __("Show users avatars", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_users_avatars', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_users_links', __("Show users linked", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_users_links', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_users_limit', __("Limit displayed users", "gd-bbpress-toolbox"), __("Showing long list of users can be performance intensive.", "gd-bbpress-toolbox"), d4pSettingType::ABSINT, gdbbx()->get('forum-index__statistics_show_users_limit', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_legend', __("Show colors legend", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_legend', 'features')),
                new d4pSettingElement('', '', __("Statistics Block", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'forum-index__statistics_show_statistics', __("Show statistics block", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_statistics', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_statistics_totals', __("Show totals counts", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_statistics_totals', 'features')),
                new d4pSettingElement('features', 'forum-index__statistics_show_statistics_newest_user', __("Show newest user", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('forum-index__statistics_show_statistics_newest_user', 'features'))
            ))
        );

        $settings['profiles'] = array(
            'profiles' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'profiles', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'profiles_protect' => array('name' => __("Protect Profile Pages", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'profiles__hide_from_visitors', __("Hide from visitors", "gd-bbpress-toolbox"), __("If enabled, user profile pages content will be hidden from non-logged users (visitors).", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles__hide_from_visitors', 'features'))
            )),
            'profiles_thanks' => array('name' => __("Thanks Information BLock", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'profiles__thanks_display', __("Show the block", "gd-bbpress-toolbox"), __("Show the number of thanks user has given and received.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles__thanks_display', 'features')),
                new d4pSettingElement('features', 'profiles__thanks_private', __("Keep the block private", "gd-bbpress-toolbox"), __("Only account owner will be able to see this block on own profile, it will be hidden from other users.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles__thanks_private', 'features'))
            )),
            'profiles_extras' => array('name' => __("Extra Information Block", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'profiles__extras_display', __("Show the block", "gd-bbpress-toolbox"), __("Profile page will include extra information block that includes overview of the subscriptions and favorites.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles__extras_display', 'features')),
                new d4pSettingElement('features', 'profiles__extras_actions', __("Show actions with the block", "gd-bbpress-toolbox"), __("Actions to unsubscribe from all forums and topics and remove all favorites. Only account owner can see these actions.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles__extras_actions', 'features')),
                new d4pSettingElement('features', 'profiles__extras_private', __("Keep the block private", "gd-bbpress-toolbox"), __("Only account owner will be able to see this block on own profile, it will be hidden from other users.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('profiles__extras_private', 'features'))
            ))
        );

        $settings['topics'] = array(
            'topics' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'topics', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('topics', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'topics_minmax' => array('name' => __("Save Topic - Title and Content length", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'topics__new_topic_minmax_active', __("Length control", "gd-bbpress-toolbox"), __("When new topic is saved, minimal and maximal length for title and content will be enforced.", "gd-bbpress-toolbox").' '.__("Set value to zero to ignore it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('topics__new_topic_minmax_active', 'features')),
                new d4pSettingElement('features', 'topics__new_topic_min_title_length', __("Min Title Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('topics__new_topic_min_title_length', 'features')),
                new d4pSettingElement('features', 'topics__new_topic_max_title_length', __("Max Title Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('topics__new_topic_max_title_length', 'features')),
                new d4pSettingElement('features', 'topics__new_topic_min_content_length', __("Min Content Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('topics__new_topic_min_content_length', 'features')),
                new d4pSettingElement('features', 'topics__new_topic_max_content_length', __("Max Content Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('topics__new_topic_max_content_length', 'features'))
            )),
            'topics_tweaks' => array('name' => __("Various Settings", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'topics__enable_lead_topic', __("Display Lead Topic", "gd-bbpress-toolbox"), __("Show main thread topic on top separated from replies.", "gd-bbpress-toolbox").' <strong>'.__("This option might not work with every theme, make sure to test it!", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('topics__enable_lead_topic', 'features')),
                new d4pSettingElement('features', 'topics__enable_topic_reversed_replies', __("Reversed replies Order", "gd-bbpress-toolbox"), __("When displaying topic, replies will be reversed, and on top you will see latest reply. If the Lead topic is enabled, topic post will remain on the top, if not, topic post will be the last.", "gd-bbpress-toolbox").' <strong>'.__("This feature is not compatible with bbPress Replies Threading.", "gd-bbpress-toolbox").'</strong>', d4pSettingType::BOOLEAN, gdbbx()->get('topics__enable_topic_reversed_replies', 'features')),
                new d4pSettingElement('features', 'topics__forum_list_topic_thumbnail', __("Show Thumbnail", "gd-bbpress-toolbox"), __("If there is a thumbnail (featured image) set for topic, or plugin can find image in topic content, it will display the thumbnail before topic title in the topics list.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('topics__forum_list_topic_thumbnail', 'features'))
            ))
        );

        $settings['replies'] = array(
            'replies' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'replies', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('replies', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'reply_minmax' => array('name' => __("Save Reply - Title and Content length", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'replies__new_reply_minmax_active', __("Length control", "gd-bbpress-toolbox"), __("When new reply is saved, minimal and maximal length for title and content will be enforced.", "gd-bbpress-toolbox").' '.__("Set value to zero to ignore it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('replies__new_reply_minmax_active', 'features')),
                new d4pSettingElement('features', 'replies__new_reply_min_title_length', __("Min Title Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('replies__new_reply_min_title_length', 'features')),
                new d4pSettingElement('features', 'replies__new_reply_max_title_length', __("Max Title Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('replies__new_reply_max_title_length', 'features')),
                new d4pSettingElement('features', 'replies__new_reply_min_content_length', __("Min Content Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('replies__new_reply_min_content_length', 'features')),
                new d4pSettingElement('features', 'replies__new_reply_max_content_length', __("Max Content Length", "gd-bbpress-toolbox"), '', d4pSettingType::INTEGER, gdbbx()->get('replies__new_reply_max_content_length', 'features'))
            )),
            'reply_tags' => array('name' => __("Various Settings", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'replies__tags_in_reply_form_only_for_author', __("Topic tags in reply form", "gd-bbpress-toolbox"), __("Reply form contains topic tags box, and anyone replying can change the tags assigned. If enabled, this option will show this field only for topic author.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('replies__tags_in_reply_form_only_for_author', 'features'), null, array(), array('label' => __("Only for topic author", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'replies__reply_titles', __("Reply Titles", "gd-bbpress-toolbox"), __("By default, replies don't have titles. But, with this option, reply editor will have an extra field to set the reply title.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('replies__reply_titles', 'features'))
            ))
        );

        $settings['disable-rss'] = array(
            'disable-rss' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'disable-rss', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('disable-rss', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'disable-rssviews' => array('name' => __("Topic Views RSS", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'disable-rss__view_feed', __("Status", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('disable-rss__view_feed', 'features'), null, array(), array('label' => __("Disable Feed", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'disable-rss__view_feed_redirect', __("Redirect to", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('disable-rss__view_feed_redirect', 'features'), 'array', $this->data_disable_rss())
            )),
            'disable-rss_forum' => array('name' => __("Forums RSS", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'disable-rss__forum_feed', __("Status", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('disable-rss__forum_feed', 'features'), null, array(), array('label' => __("Disable Feed", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'disable-rss__forum_feed_redirect', __("Redirect to", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('disable-rss__forum_feed_redirect', 'features'), 'array', $this->data_disable_rss())
            )),
            'disable-rss_topic' => array('name' => __("Topics RSS", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'disable-rss__topic_feed', __("Status", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('disable-rss__topic_feed', 'features'), null, array(), array('label' => __("Disable Feed", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'disable-rss__topic_feed_redirect', __("Redirect to", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('disable-rss__topic_feed_redirect', 'features'), 'array', $this->data_disable_rss())
            )),
            'disable-rss_reply' => array('name' => __("Replies RSS", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'disable-rss__reply_feed', __("Status", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('disable-rss__reply_feed', 'features'), null, array(), array('label' => __("Disable Feed", "gd-bbpress-toolbox"))),
                new d4pSettingElement('features', 'disable-rss__reply_feed_redirect', __("Redirect to", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('disable-rss__reply_feed_redirect', 'features'), 'array', $this->data_disable_rss())
            ))
        );

        $settings['auto-close-topics'] = array(
            'auto-close-topics' => array('name' => __("Feature Status", "gd-bbpress-toolbox"),
                'kb' => array('label' => __("KB", "gd-bbpress-toolbox"), 'url' => 'auto-close-inactive-topics'), 'settings' => array(
                    new d4pSettingElement('load', 'auto-close-topics', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
                )),
            'auto-close-topics_settings' => array('name' => __("Auto close inactive topics", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('', '', __("Notice", "gd-bbpress-toolbox"), __("These options can be set and overridden for individual forums. You can even disable global Auto Close below, and only enable it for some forums by editing individual forums.", "gd-bbpress-toolbox"), d4pSettingType::INFO),
                new d4pSettingElement('', '', __("Global auto close settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'auto-close-topics__active', __("Auto Close", "gd-bbpress-toolbox"), __("If the topic doesn't get any new replies after predefined amount of time, it will be automatically closed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__active', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__notice', __("Show Notice", "gd-bbpress-toolbox"), __("Notice will be displayed inside the reply form about the auto-closing.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__notice', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__days', __("Days of inactivity", "gd-bbpress-toolbox"), '', d4pSettingType::ABSINT, gdbbx()->get('auto-close-topics__days', 'features'), '', '', array('min' => AutoCloseTopics::minimum_days_allowed()))
            )),
            'auto-close-topics_modify' => array('name' => __("Modify close terms", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'auto-close-topics__modify_topic_form', __("For topic form", "gd-bbpress-toolbox"), __("Include the auto close controls in the new or edit topic form allowing change of the auto close rules.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__modify_topic_form', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__modify_topic_form_location', __("Topic Form Position", "gd-bbpress-toolbox"), __("Choose where the modify auto close block is displayed.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('auto-close-topics__modify_topic_form_location', 'features'), 'array', $this->data_form_position_topic()),
                new d4pSettingElement('features', 'auto-close-topics__modify_reply_form', __("For reply form", "gd-bbpress-toolbox"), __("Include the auto close controls in the new or edit reply form allowing change of the auto close rules for the topic reply belongs to.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__modify_reply_form', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__modify_reply_form_location', __("Reply Form Position", "gd-bbpress-toolbox"), __("Choose where the modify auto close block is displayed.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('auto-close-topics__modify_reply_form_location', 'features'), 'array', $this->data_form_position_reply()),
                new d4pSettingElement('', '', __("Members allowed to modify the terms", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'auto-close-topics__modify_author', __("Allowed for topic author", "gd-bbpress-toolbox"), __("Topic author will be allowed to change auto close topic rules.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__modify_author', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__modify_moderators', __("Allowed for moderators", "gd-bbpress-toolbox"), __("Moderators and keymasters will be allowed to change auto close topic rules.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__modify_moderators', 'features'))
            )),
            'auto-close-topics_notify' => array('name' => __("Notifications", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'auto-close-topics__notify_author', _x("To author", "Sending email notification", "gd-bbpress-toolbox"), __("Topic author will receive email notification when the topic is closed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__notify_author', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__notify_subscribers', _x("To subscribers", "Sending email notification", "gd-bbpress-toolbox"), __("All topic subscribers will receive email notification when the topic is closed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__after_notify_subscribers', 'features')),
                new d4pSettingElement('', '', __("Override notification content", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'auto-close-topics__notify_active', __("Override content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__notify_active', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__notify_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %FORUM_LINK%, %TOPIC_AUTHOR%, %TOPIC_CONTENT%, %TOPIC_LINK%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('auto-close-topics__notify_content', 'features')),
                new d4pSettingElement('features', 'auto-close-topics__notify_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('auto-close-topics__notify_subject', 'features')),
                new d4pSettingElement('', '', __("Additional settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'auto-close-topics__notify_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('auto-close-topics__notify_shortcodes', 'features'))
            ))
        );

        $settings['schedule-topic'] = array(
            'schedule-topic' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'schedule-topic', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('schedule-topic', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'schedule-topic_available' => array('name' => __("Schedule topics", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'schedule-topic__form_location', __("Topic Form Position", "gd-bbpress-toolbox"), __("Choose where the schedule topic block is displayed.", "gd-bbpress-toolbox"), d4pSettingType::SELECT, gdbbx()->get('schedule-topic__form_location', 'features'), 'array', $this->data_form_position_topic()),
                new d4pSettingElement('', '', __("Members allowed to schedule topics", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'schedule-topic__allow_super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('schedule-topic__allow_super_admin', 'features')),
                new d4pSettingElement('features', 'schedule-topic__allow_roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('schedule-topic__allow_roles', 'features'), 'array', gdbbx_get_user_roles(), array('class' => 'gdbbx-roles'))
            ))
        );

        $settings['close-topic-control'] = array(
            'close-topic-control' => array('name' => __("Feature Status", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('load', 'close-topic-control', __("Active", "gd-bbpress-toolbox"), __("This feature will be loaded only if activated. If you don't need this feature, disable it.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control', 'load'), null, array(), array('label' => __("Feature is active", "gd-bbpress-toolbox")))
            )),
            'close-topic-control_settings' => array('name' => __("Close topic checkbox in reply form", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'close-topic-control__topic_author', __("Available to topic author", "gd-bbpress-toolbox"), __("If the post is reply, this will take into account author of the topic too.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control__topic_author', 'features')),
                new d4pSettingElement('features', 'close-topic-control__super_admin', __("Available to super admin", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control__super_admin', 'features')),
                new d4pSettingElement('features', 'close-topic-control__roles', __("Available to roles", "gd-bbpress-toolbox"), '', d4pSettingType::CHECKBOXES, gdbbx()->get('close-topic-control__roles', 'features'), 'array', $this->data_high_level_user_roles(), array('class' => 'gdbbx-roles')),
                new d4pSettingElement('features', 'close-topic-control__form_position', __("Form Position", "gd-bbpress-toolbox"), '', d4pSettingType::SELECT, gdbbx()->get('close-topic-control__form_position', 'features'), 'array', $this->data_form_position_reply())
            )),
            'close-topic-control_notify' => array('name' => __("Notifications", "gd-bbpress-toolbox"), 'settings' => array(
                new d4pSettingElement('features', 'close-topic-control__notify_author', _x("To author", "Sending email notification", "gd-bbpress-toolbox"), __("Topic author will receive email notification when the topic is closed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control__notify_author', 'features')),
                new d4pSettingElement('features', 'close-topic-control__notify_subscribers', _x("To subscribers", "Sending email notification", "gd-bbpress-toolbox"), __("All topic subscribers will receive email notification when the topic is closed.", "gd-bbpress-toolbox"), d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control__notify_subscribers', 'features')),
                new d4pSettingElement('', '', __("Override notification content", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'close-topic-control__notify_active', __("Modify notification content", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control__notify_active', 'features')),
                new d4pSettingElement('features', 'close-topic-control__notify_content', __("Notification content", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %FORUM_LINK%, %TOPIC_AUTHOR%, %CLOSED_USER%, %TOPIC_CONTENT%, %TOPIC_LINK%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::HTML, gdbbx()->get('close-topic-control__notify_content', 'features')),
                new d4pSettingElement('features', 'close-topic-control__notify_subject', __("Notification subject", "gd-bbpress-toolbox"), __("You can use special tags that will be replaced with actual values", "gd-bbpress-toolbox").': %FORUM_TITLE%, %CLOSED_USER%, %TOPIC_TITLE%, %BLOG_NAME%', d4pSettingType::TEXT, gdbbx()->get('close-topic-control__notify_subject', 'features')),
                new d4pSettingElement('', '', __("Additional settings", "gd-bbpress-toolbox"), '', d4pSettingType::HR),
                new d4pSettingElement('features', 'close-topic-control__notify_shortcodes', __("Process shortcodes", "gd-bbpress-toolbox"), '', d4pSettingType::BOOLEAN, gdbbx()->get('close-topic-control__notify_shortcodes', 'features'))
            ))
        );

        return $settings;
    }

    private function data_extra_features() {
        return array(
            'thumbnail' => __("Thumbnail", "gd-bbpress-toolbox"),
            'excerpt' => __("Excerpt", "gd-bbpress-toolbox"),
            'custom-fields' => __("Custom Fields", "gd-bbpress-toolbox")
        );
    }

    private function data_site_public() {
        return array(
            'auto' => __("No change", "gd-bbpress-toolbox"),
            'public' => __("Site is public", "gd-bbpress-toolbox"),
            'private' => __("Site is private", "gd-bbpress-toolbox")
        );
    }

    private function data_snippet_type() {
        return array(
            'Organization' => __("Organization", "gd-bbpress-toolbox"),
            'Person' => __("Person", "gd-bbpress-toolbox")
        );
    }

    private function data_quote_button_location() {
        return array(
            'header' => __("Reply or Topic header", "gd-bbpress-toolbox"),
            'footer' => __("Reply or Topic footer", "gd-bbpress-toolbox")
        );
    }

    private function data_thanks_date_display() {
        return array(
            'no' => __("Don't show", "gd-bbpress-toolbox"),
            'date' => __("Show date", "gd-bbpress-toolbox"),
            'age' => __("Show age", "gd-bbpress-toolbox")
        );
    }

    private function data_kses_allowed_tags_override() {
        return array(
            'bbpress' => __("Default bbPress list of tags and attributes", "gd-bbpress-toolbox"),
            'expanded' => __("Expanded range of tags and attributes", "gd-bbpress-toolbox"),
            'post' => __("Wide range of tags and attributes as for WordPress posts", "gd-bbpress-toolbox")
        );
    }

    private function data_actions_location() {
        return array(
            'header' => __("Header - bbPress Default", "gd-bbpress-toolbox"),
            'footer' => __("Footer - Added by Toolbox Plugin", "gd-bbpress-toolbox"),
            'hide' => __("Hide", "gd-bbpress-toolbox")
        );
    }

    private function data_attachment_icon_method() {
        return array(
            'images' => __("Images", "gd-bbpress-toolbox"),
            'font' => __("Font Icons", "gd-bbpress-toolbox")
        );
    }

    private function data_forum_index_filters() {
        return array(
            'before' => __("Before Forum Index", "gd-bbpress-toolbox"),
            'after' => __("After Forum Index", "gd-bbpress-toolbox")
        );
    }

    private function data_active_users_period() {
        return array(
            0 => __("Currently online", "gd-bbpress-toolbox"),
            30 => __("Active in the past 30 minutes", "gd-bbpress-toolbox"),
            60 => __("Active in the past 60 minutes", "gd-bbpress-toolbox"),
            120 => __("Active in the past 2 hours", "gd-bbpress-toolbox"),
            720 => __("Active in the past 12 hours", "gd-bbpress-toolbox"),
            1440 => __("Active in the past 24 hours", "gd-bbpress-toolbox"),
            10080 => __("Active in the past 7 days", "gd-bbpress-toolbox")
        );
    }

    private function data_disable_rss() {
        return array(
            'home' => __("Home Page", "gd-bbpress-toolbox"),
            '404' => __("Error 404 Page", "gd-bbpress-toolbox"),
            'forums' => __("Main Forums Page", "gd-bbpress-toolbox"),
            'parent' => __("Parent Page", "gd-bbpress-toolbox")
        );
    }

    private function data_quote_button_method() {
        return array(
            'bbcode' => 'BBCode',
            'html' => 'HTML'
        );
    }

    private function data_quote_bbcode() {
        return array(
            'quote' => __("Quote", "gd-bbpress-toolbox"),
            'postquote' => __("Post Quote", "gd-bbpress-toolbox")
        );
    }

    private function data_signature_scopes() {
        return array(
            'global' => __("Global for the whole network", "gd-bbpress-toolbox"),
            'blog' => __("Local for each blog", "gd-bbpress-toolbox")
        );
    }

    private function data_enhanced_editor_types() {
        return array(
            'textarea' => __("Normal Textarea", "gd-bbpress-toolbox"),
            'tinymce' => __("TinyMCE Full", "gd-bbpress-toolbox"),
            'tinymce_compact' => __("TinyMCE Compact", "gd-bbpress-toolbox"),
            'bbcodes' => __("BBCodes Toolbar", "gd-bbpress-toolbox")
        );
    }

    private function data_enhanced_signature_method() {
        return array(
            'plain' => __("Plain Text", "gd-bbpress-toolbox"),
            'html' => __("HTML", "gd-bbpress-toolbox"),
            'bbcode' => __("BBCodes", "gd-bbpress-toolbox"),
            'full' => __("HTML and BBCodes", "gd-bbpress-toolbox")
        );
    }

    private function data_report_mode() {
        return array(
            'form' => __("Standard form with required message", "gd-bbpress-toolbox"),
            'confirm' => __("Simple confirmation dialog to send report", "gd-bbpress-toolbox"),
            'button' => __("Send report without any confirmation", "gd-bbpress-toolbox")
        );
    }

    private function data_private_checked_status() {
        return array(
            'unchecked' => __("Unchecked", "gd-bbpress-toolbox"),
            'checked' => __("Checked", "gd-bbpress-toolbox")
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

    private function data_high_level_user_roles() {
        return array(
            bbp_get_keymaster_role() => __("Keymaster", "gd-bbpress-toolbox"),
            bbp_get_moderator_role() => __("Moderator", "gd-bbpress-toolbox")
        );
    }
}
