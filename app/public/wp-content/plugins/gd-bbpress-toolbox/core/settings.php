<?php

if (!defined('ABSPATH')) {
    exit;
}

class gdbbx_core_settings {
    private $_inside_content_shortcode = array();

    public $info;
    public $temp = array();
    public $current = array();
    public $settings = array(
        'core' => array(
            'unread_cutoff' => 0,
            'notice_gdfon_hide' => false,
            'notice_gdmed_hide' => false,
            'notice_gdtox_hide' => false,
            'notice_gdpol_hide' => false,
            'notice_gdpos_hide' => false,
            'notice_gdqnt_hide' => false
        ),
        'rules' => array(
            'forums_auto_close' => array()
        ),
        'settings' => array(
            'load_always' => false,
            'load_fitvids' => true
        ),
        'load' => array(
            'rewriter' => false,
            'thanks' => false,
            'topic-actions' => true,
            'reply-actions' => true,
            'user-settings' => true,
            'custom-views' => true,

            'mime-types' => true,
            'protect-revisions' => false,
            'admin-access' => false,
            'tweaks' => true,
            'editor' => true,
            'snippets' => true,
            'clickable' => true,
            'privacy' => true,
            'objects' => true,
            'publish' => true,
            'icons' => true,
            'footer-actions' => true,
            'profiles' => true,
            'topics' => true,
            'replies' => true,
            'private-topics' => false,
            'private-replies' => false,
            'forum-index' => true,
            'disable-rss' => false,
            'visitors-redirect' => true,
            'toolbar' => true,
            'quote' => true,
            'signatures' => true,
            'seo-tweaks' => true,
            'users-stats' => true,
            'admin-columns' => true,
            'admin-widgets' => true,
            'canned-replies' => false,
            'lock-forums' => true,
            'lock-topics' => true,
            'report' => false,
            'auto-close-topics' => false,
            'schedule-topic' => false,
            'close-topic-control' => true
        ),
        'features' => array(
            'mime-types__list' => array('txt' => 'text/plain'),

            'lock-topics__lock' => true,

            'custom-views__enable_feed' => false,
            'custom-views__with_pending' => false,
            'custom-views__pending_active' => true,
            'custom-views__pending_slug' => 'pending',
            'custom-views__pending_title' => 'Pending Topics',
            'custom-views__spam_active' => false,
            'custom-views__spam_slug' => 'spam',
            'custom-views__spam_title' => 'Spammed Topics',
            'custom-views__trash_active' => false,
            'custom-views__trash_slug' => 'trash',
            'custom-views__trash_title' => 'Trashed Topics',
            'custom-views__newposts_active' => true,
            'custom-views__newposts_slug' => 'new-posts-last-visits',
            'custom-views__newposts_title' => 'New posts since last visit',
            'custom-views__topicsfresh_active' => true,
            'custom-views__topicsfresh_slug' => 'topics-freshness',
            'custom-views__topicsfresh_title' => 'Topics Freshness',
            'custom-views__newposts24h_active' => true,
            'custom-views__newposts24h_slug' => 'new-posts-last-day',
            'custom-views__newposts24h_title' => 'New posts: Last day',
            'custom-views__newposts3dy_active' => true,
            'custom-views__newposts3dy_slug' => 'new-posts-last-three-days',
            'custom-views__newposts3dy_title' => 'New posts: Last three days',
            'custom-views__newposts7dy_active' => true,
            'custom-views__newposts7dy_slug' => 'new-posts-last-week',
            'custom-views__newposts7dy_title' => 'New posts: Last week',
            'custom-views__newposts1mn_active' => true,
            'custom-views__newposts1mn_slug' => 'new-posts-last-month',
            'custom-views__newposts1mn_title' => 'New posts: Last month',
            'custom-views__mostreplies_active' => true,
            'custom-views__mostreplies_slug' => 'most-replies',
            'custom-views__mostreplies_title' => 'Topics with most replies',
            'custom-views__latesttopics_active' => true,
            'custom-views__latesttopics_slug' => 'latest-topics',
            'custom-views__latesttopics_title' => 'Latest topics',
            'custom-views__mostthanked_active' => false,
            'custom-views__mostthanked_slug' => 'most-thanked-topics',
            'custom-views__mostthanked_title' => 'Most thanked topics',
            'custom-views__attachments_active' => false,
            'custom-views__attachments_slug' => 'topics-with-attachments',
            'custom-views__attachments_title' => 'Topics with attachments',
            'custom-views__myfuture_active' => false,
            'custom-views__myfuture_slug' => 'my-scheduled-topics',
            'custom-views__myfuture_title' => 'My Scheduled Topics',
            'custom-views__myattachments_active' => false,
            'custom-views__myattachments_slug' => 'my-topics-with-attachments',
            'custom-views__myattachments_title' => 'My topics with attachments',
            'custom-views__myactive_active' => false,
            'custom-views__myactive_slug' => 'my-active-topics',
            'custom-views__myactive_title' => 'My active topics',
            'custom-views__mytopics_active' => false,
            'custom-views__mytopics_slug' => 'my-topics',
            'custom-views__mytopics_title' => 'All my topics',
            'custom-views__myreply_active' => false,
            'custom-views__myreply_slug' => 'with-my-reply',
            'custom-views__myreply_title' => 'Topics with my reply',
            'custom-views__mynoreplies_active' => false,
            'custom-views__mynoreplies_slug' => 'my-topics-no-replies',
            'custom-views__mynoreplies_title' => 'My topics with no replies',
            'custom-views__mymostreplies_active' => true,
            'custom-views__mymostreplies_slug' => 'my-topics-most-replies',
            'custom-views__mymostreplies_title' => 'My topics with most replies',
            'custom-views__mymostthanked_active' => false,
            'custom-views__mymostthanked_slug' => 'my-most-thanked-topics',
            'custom-views__mymostthanked_title' => 'My most thanked topics',
            'custom-views__myfavorite_active' => true,
            'custom-views__myfavorite_slug' => 'my-favorite-topics',
            'custom-views__myfavorite_title' => 'My favorite topics',
            'custom-views__mysubscribed_active' => true,
            'custom-views__mysubscribed_slug' => 'my-subscribed-topics',
            'custom-views__mysubscribed_title' => 'My subscribed topics',

            'editor__topic_tinymce' => false,
            'editor__topic_teeny' => false,
            'editor__topic_media_buttons' => false,
            'editor__topic_wpautop' => true,
            'editor__topic_quicktags' => true,
            'editor__topic_textarea_rows' => 12,
            'editor__reply_tinymce' => false,
            'editor__reply_teeny' => false,
            'editor__reply_media_buttons' => false,
            'editor__reply_wpautop' => true,
            'editor__reply_quicktags' => true,
            'editor__reply_textarea_rows' => 12,

            'rewriter__topic_hierarchy' => false,
            'rewriter__reply_hierarchy' => false,
            'rewriter__forum_remove_attachments_rules' => false,
            'rewriter__topic_remove_attachments_rules' => false,
            'rewriter__reply_remove_attachments_rules' => false,
            'rewriter__forum_remove_comments_rules' => false,
            'rewriter__topic_remove_comments_rules' => false,
            'rewriter__reply_remove_comments_rules' => false,
            'rewriter__forum_remove_feeds_rules' => false,
            'rewriter__topic_remove_feeds_rules' => false,
            'rewriter__reply_remove_feeds_rules' => false,

            'snippets__breadcrumbs' => true,
            'snippets__topic_dfp' => false,
            'snippets__topic_dfp_fallback_image' => 0,
            'snippets__topic_dfp_include_article_body' => false,
            'snippets__topic_dfp_include_author_profile_url' => true,
            'snippets__topic_dfp_include_author_website_url' => true,
            'snippets__topic_dfp_publisher_type' => 'Organization',
            'snippets__topic_dfp_publisher_name' => '',
            'snippets__topic_dfp_publisher_logo' => 0,

            'clickable__disable_make_clickable_topic' => false,
            'clickable__disable_make_clickable_reply' => false,
            'clickable__remove_clickable_urls' => false,
            'clickable__remove_clickable_ftps' => false,
            'clickable__remove_clickable_emails' => false,
            'clickable__remove_clickable_mentions' => false,

            'privacy__disable_ip_logging' => false,
            'privacy__disable_ip_display' => false,

            'objects__add_forum_features' => array(),
            'objects__add_topic_features' => array(),
            'objects__add_reply_features' => array(),

            'publish__bbp_is_site_public' => 'auto',

            'schedule-topic__allow_super_admin' => true,
            'schedule-topic__allow_roles' => array('bbp_keymaster', 'bbp_moderator'),
            'schedule-topic__form_location' => 'bbp_theme_after_topic_form_content',

            'thanks__removal' => false,
            'thanks__topic' => true,
            'thanks__reply' => true,
            'thanks__allow_super_admin' => true,
            'thanks__allow_roles' => null,
            'thanks__limit_display' => 20,
            'thanks__display_date' => 'no',
            'thanks__notify_active' => false,
            'thanks__notify_override' => false,
            'thanks__notify_shortcodes' => true,
            'thanks__notify_content' => '',
            'thanks__notify_subject' => '[%BLOG_NAME%] Thanks received: %POST_TITLE%',

            'tweaks__topic_load_search_for_all_topics' => false,
            'tweaks__forum_load_search_for_all_forums' => false,
            'tweaks__fix_404_headers_error' => true,
            'tweaks__title_length_override' => false,
            'tweaks__title_length_value' => 80,
            'tweaks__remove_private_title_prefix' => false,
            'tweaks__participant_media_library_upload' => false,
            'tweaks__kses_allowed_override' => 'bbpress',
            'tweaks__disable_bbpress_breadcrumbs' => false,
            'tweaks__apply_fitvids_to_content' => true,
            'tweaks__alternative_freshness_display' => false,

            'profiles__hide_from_visitors' => false,
            'profiles__thanks_display' => false,
            'profiles__thanks_private' => false,
            'profiles__extras_display' => false,
            'profiles__extras_actions' => true,
            'profiles__extras_private' => true,

            'protect-revisions__allow_author' => true,
            'protect-revisions__allow_topic_author' => true,
            'protect-revisions__allow_super_admin' => true,
            'protect-revisions__allow_roles' => null,
            'protect-revisions__allow_visitor' => false,

            'admin-access__disable_roles' => array('bbp_keymaster', 'bbp_moderator'),

            'topics__new_topic_minmax_active' => false,
            'topics__new_topic_min_title_length' => 0,
            'topics__new_topic_min_content_length' => 0,
            'topics__new_topic_max_title_length' => 0,
            'topics__new_topic_max_content_length' => 0,
            'topics__enable_lead_topic' => false,
            'topics__enable_topic_reversed_replies' => false,
            'topics__forum_list_topic_thumbnail' => false,

            'replies__new_reply_minmax_active' => false,
            'replies__new_reply_min_title_length' => 0,
            'replies__new_reply_min_content_length' => 0,
            'replies__new_reply_max_title_length' => 0,
            'replies__new_reply_max_content_length' => 0,
            'replies__tags_in_reply_form_only_for_author' => false,
            'replies__reply_titles' => false,

            'topic-actions__edit' => 'header',
            'topic-actions__merge' => 'header',
            'topic-actions__close' => 'header',
            'topic-actions__stick' => 'header',
            'topic-actions__trash' => 'header',
            'topic-actions__spam' => 'header',
            'topic-actions__approve' => 'header',
            'topic-actions__reply' => 'header',
            'topic-actions__lock' => 'footer',
            'topic-actions__duplicate' => 'hide',
            'topic-actions__thanks' => 'footer',
            'topic-actions__quote' => 'footer',
            'topic-actions__report' => 'footer',
            'reply-actions__edit' => 'header',
            'reply-actions__move' => 'header',
            'reply-actions__split' => 'header',
            'reply-actions__trash' => 'header',
            'reply-actions__spam' => 'header',
            'reply-actions__approve' => 'header',
            'reply-actions__reply' => 'header',
            'reply-actions__thanks' => 'footer',
            'reply-actions__quote' => 'footer',
            'reply-actions__report' => 'footer',

            'icons__mode' => 'font',
            'icons__forums_mark_closed_forum' => true,
            'icons__forums_mark_visibility_forum' => true,
            'icons__forum_mark_attachments' => true,
            'icons__forum_mark_stick' => true,
            'icons__forum_mark_lock' => true,
            'icons__forum_mark_closed' => true,
            'icons__forum_mark_replied' => false,
            'icons__private_topics_icon' => true,
            'icons__private_replies_icon' => false,

            'forum-index__welcome_front' => false,
            'forum-index__welcome_filter' => 'before',
            'forum-index__welcome_front_roles' => null,
            'forum-index__welcome_show_links' => true,
            'forum-index__statistics_front' => false,
            'forum-index__statistics_filter' => 'after',
            'forum-index__statistics_front_roles' => null,
            'forum-index__statistics_front_visitor' => false,
            'forum-index__statistics_show_online' => true,
            'forum-index__statistics_show_online_overview' => true,
            'forum-index__statistics_show_online_top' => true,
            'forum-index__statistics_show_users' => 0,
            'forum-index__statistics_show_users_colors' => false,
            'forum-index__statistics_show_users_avatars' => false,
            'forum-index__statistics_show_users_links' => false,
            'forum-index__statistics_show_users_limit' => 32,
            'forum-index__statistics_show_legend' => false,
            'forum-index__statistics_show_statistics' => true,
            'forum-index__statistics_show_statistics_totals' => true,
            'forum-index__statistics_show_statistics_newest_user' => false,

            'disable-rss__view_feed' => false,
            'disable-rss__view_feed_redirect' => 'parent',
            'disable-rss__forum_feed' => false,
            'disable-rss__forum_feed_redirect' => 'parent',
            'disable-rss__topic_feed' => false,
            'disable-rss__topic_feed_redirect' => 'parent',
            'disable-rss__reply_feed' => false,
            'disable-rss__reply_feed_redirect' => 'forums',

            'visitors-redirect__for_visitors' => false,
            'visitors-redirect__for_visitors_url' => '',
            'visitors-redirect__hidden_forums' => false,
            'visitors-redirect__hidden_forums_url' => '',
            'visitors-redirect__private_forums' => false,
            'visitors-redirect__private_forums_url' => '',
            'visitors-redirect__blocked_users' => false,
            'visitors-redirect__blocked_users_url' => '',

            'toolbar__super_admin' => true,
            'toolbar__visitor' => true,
            'toolbar__roles' => null,
            'toolbar__title' => 'Forums',
            'toolbar__information' => true,

            'quote__method' => 'bbcode',
            'quote__full_content' => 'postquote',
            'quote__super_admin' => true,
            'quote__visitor' => false,
            'quote__roles' => null,

            'users-stats__super_admin' => true,
            'users-stats__visitor' => false,
            'users-stats__roles' => null,
            'users-stats__show_online_status' => true,
            'users-stats__show_registration_date' => false,
            'users-stats__show_topics' => true,
            'users-stats__show_replies' => true,
            'users-stats__show_thanks_given' => false,
            'users-stats__show_thanks_received' => false,

            'admin-widgets__activity' => true,
            'admin-widgets__online' => false,

            'admin-columns__forum_subscriptions' => true,
            'admin-columns__topic_attachments' => true,
            'admin-columns__topic_private' => true,
            'admin-columns__topic_subscriptions' => true,
            'admin-columns__topic_favorites' => true,
            'admin-columns__reply_attachments' => true,
            'admin-columns__reply_private' => true,
            'admin-columns__user_content' => true,
            'admin-columns__user_last_activity' => true,

            'canned-replies__canned_roles' => array('bbp_keymaster', 'bbp_moderator'),
            'canned-replies__post_type_singular' => 'Canned Reply',
            'canned-replies__post_type_plural' => 'Canned Replies',
            'canned-replies__use_taxonomy' => false,
            'canned-replies__taxonomy_singular' => 'Category',
            'canned-replies__taxonomy_plural' => 'Categories',
            'canned-replies__auto_close_on_insert' => true,

            'signatures__scope' => 'global',
            'signatures__limiter' => true,
            'signatures__length' => 512,
            'signatures__super_admin' => true,
            'signatures__roles' => null,
            'signatures__edit_super_admin' => true,
            'signatures__edit_roles' => null,
            'signatures__editor' => 'textarea',
            'signatures__enhanced_active' => true,
            'signatures__enhanced_method' => 'html',
            'signatures__enhanced_super_admin' => true,
            'signatures__enhanced_roles' => null,
            'signatures__process_smilies' => true,
            'signatures__process_chars' => true,
            'signatures__process_autop' => true,

            'lock-forums__topic_form_locked' => false,
            'lock-forums__topic_form_allow_super_admin' => true,
            'lock-forums__topic_form_allow_roles' => array('bbp_keymaster'),
            'lock-forums__topic_form_message' => 'Forums are currently locked.',
            'lock-forums__reply_form_locked' => false,
            'lock-forums__reply_form_allow_super_admin' => true,
            'lock-forums__reply_form_allow_roles' => array('bbp_keymaster'),
            'lock-forums__reply_form_message' => 'Forums are currently locked.',

            'seo-tweaks__noindex_private_topic' => true,
            'seo-tweaks__noindex_private_reply' => true,
            'seo-tweaks__nofollow_topic_content' => true,
            'seo-tweaks__nofollow_reply_content' => true,
            'seo-tweaks__nofollow_topic_author' => true,
            'seo-tweaks__nofollow_reply_author' => true,

            'report__allow_roles' => null,
            'report__report_mode' => 'form',
            'report__scroll_form' => true,
            'report__show_report_status' => false,
            'report__show_report_status_to_moderators_only' => true,
            'report__notify_active' => true,
            'report__notify_keymasters' => true,
            'report__notify_moderators' => true,
            'report__notify_shortcodes' => true,
            'report__notify_content' => '',
            'report__notify_subject' => '[%BLOG_NAME%] Post reported: %REPORT_TITLE%',

            'private-topics__form_position' => 'bbp_theme_before_topic_form_submit_wrapper',
            'private-topics__super_admin' => true,
            'private-topics__roles' => null,
            'private-topics__visitor' => false,
            'private-topics__default' => 'unchecked',
            'private-topics__moderators_can_read' => true,

            'private-replies__form_position' => 'bbp_theme_before_reply_form_submit_wrapper',
            'private-replies__super_admin' => true,
            'private-replies__roles' => null,
            'private-replies__visitor' => false,
            'private-replies__default' => 'unchecked',
            'private-replies__moderators_can_read' => true,
            'private-replies__threaded' => true,
            'private-replies__css_hide' => false,

            'auto-close-topics__status' => false,
            'auto-close-topics__active' => false,
            'auto-close-topics__notice' => true,
            'auto-close-topics__days' => 90,
            'auto-close-topics__modify_topic_form' => false,
            'auto-close-topics__modify_reply_form' => false,
            'auto-close-topics__modify_author' => false,
            'auto-close-topics__modify_moderators' => true,
            'auto-close-topics__modify_topic_form_location' => 'bbp_theme_after_topic_form_content',
            'auto-close-topics__modify_reply_form_location' => 'bbp_theme_after_reply_form_content',
            'auto-close-topics__notify_author' => false,
            'auto-close-topics__notify_subscribers' => false,
            'auto-close-topics__notify_active' => false,
            'auto-close-topics__notify_shortcodes' => true,
            'auto-close-topics__notify_content' => '',
            'auto-close-topics__notify_subject' => "[%BLOG_NAME%] The topic '%TOPIC_TITLE%' is now closed",

            'close-topic-control__topic_author' => true,
            'close-topic-control__super_admin' => true,
            'close-topic-control__roles' => array('bbp_keymaster'),
            'close-topic-control__form_position' => 'bbp_theme_before_reply_form_submit_wrapper',
            'close-topic-control__notify_author' => false,
            'close-topic-control__notify_subscribers' => false,
            'close-topic-control__notify_active' => false,
            'close-topic-control__notify_shortcodes' => true,
            'close-topic-control__notify_content' => '',
            'close-topic-control__notify_subject' => "[%BLOG_NAME%] The topic '%TOPIC_TITLE%' is now closed"
        ),
        'buddypress' => array(
            'xprofile_support' => false,
            'xprofile_signature_field_id' => 0,
            'xprofile_signature_field_add' => false,
            'xprofile_signature_field_del' => false,
            'disable_profile_override' => false,
            'notifications_support' => false,
            'notifications_thanks_received' => false,
            'notifications_post_reported' => false
        ),
        'online' => array(
            'active' => true,
            'window' => 180,
            'track_users' => true,
            'track_guests' => true,
            'users_stats' => false,

            'current_timestamp' => 0,
            'current_users_count' => 0,
            'current_guests_count' => 0,
            'current_total_count' => 0,
            'current_roles_counts' => array(),

            'max_users_count' => 0,
            'max_users_timestamp' => 0,
            'max_guests_count' => 0,
            'max_guests_timestamp' => 0,
            'max_total_count' => 0,
            'max_total_timestamp' => 0,

            'notice_for_forum' => false,
            'notice_for_topic' => false,
            'notice_for_view' => false,
            'notice_for_profile' => false
        ),
        'attachments' => array(
            'attachments_active' => true,
            'topics' => true,
            'replies' => true,
            'forum_not_defined' => 'hide',
            'validation_active' => true,
            'enhanced_auto_new' => true,
            'enhanced_set_caption' => true,
            'insert_into_content' => true,
            'insert_into_content_roles' => null,
            'hide_attachments_when_in_content' => false,
            'hide_attachments_from_media_library' => false,
            'form_position_topic' => 'bbp_theme_before_topic_form_submit_wrapper',
            'form_position_reply' => 'bbp_theme_before_reply_form_submit_wrapper',
            'files_list_position' => 'content',
            'mime_types_limit_active' => false,
            'mime_types_limit_display' => false,
            'mime_types_list' => array(),

            'upload_dir_override' => false,
            'upload_dir_structure' => '/forums/forum-name',
            'upload_dir_forums_base' => 'forums',
            'topic_featured_image' => false,
            'reply_featured_image' => false,
            'grid_topic_counter' => true,
            'grid_reply_counter' => true,
            'delete_method' => 'default',
            'delete_attachments' => 'detach',
            'hide_from_visitors' => true,
            'preview_for_visitors' => false,
            'max_file_size' => 512,
            'max_to_upload' => 8,
            'max_to_upload_per_post' => 8,
            'file_target_blank' => false,
            'bulk_download' => false,
            'bulk_download_listed' => true,
            'bulk_download_roles' => null,
            'bulk_download_visitor' => false,
            'roles_to_upload' => null,
            'roles_no_limit' => array('bbp_keymaster'),
            'attachment_icon' => true,
            'attachment_icons' => true,

            'download_link_attribute' => true,
            'image_thumbnail_active' => true,
            'image_thumbnail_inline' => true,
            'image_thumbnail_caption' => true,
            'image_thumbnail_rel' => 'lightbox',
            'image_thumbnail_css' => '',
            'image_thumbnail_size' => '128x72',
            'log_upload_errors' => true,
            'errors_visible_to_admins' => true,
            'errors_visible_to_moderators' => true,
            'errors_visible_to_author' => true,
            'delete_visible_to_admins' => 'both',
            'delete_visible_to_moderators' => 'no',
            'delete_visible_to_author' => 'no'
        ),
        'seo' => array(
            'document_title_parts' => true,
            'override_forum_title_replace' => false,
            'override_forum_title_text' => 'Forum: %FORUM_TITLE%',
            'override_topic_title_replace' => false,
            'override_topic_title_text' => '%FORUM_TITLE% - Topic: %TOPIC_TITLE%',
            'override_reply_title_replace' => false,
            'override_reply_title_text' => '%REPLY_TITLE%',
            'override_forum_excerpt' => false,
            'override_topic_excerpt' => false,
            'override_topic_length' => 150,
            'private_topic_excerpt_replace' => true,
            'private_topic_excerpt_text' => "Topic '%TOPIC_TITLE%' is marked as private.",
            'override_reply_excerpt' => false,
            'override_reply_length' => 150,
            'private_reply_excerpt_replace' => true,
            'private_reply_excerpt_text' => "Reply to topic '%TOPIC_TITLE%' is marked as private.",
            'meta_description_forum' => false,
            'meta_description_topic' => false,
            'meta_description_reply' => false
        ),
        'bbpress' => array(
            'new_topic_notification_keymaster' => false,
            'new_topic_notification_moderator' => false,
            'topic_notification_on_edit' => false,
            'reply_notification_on_edit' => false,

            'notify_subscribers_override_active' => false,
            'notify_subscribers_override_shortcodes' => true,
            'notify_subscribers_override_content' => '',
            'notify_subscribers_override_subject' => '[%BLOG_NAME%] New reply for: %TOPIC_TITLE%',
            'notify_subscribers_forum_override_active' => false,
            'notify_subscribers_forum_override_shortcodes' => true,
            'notify_subscribers_forum_override_content' => '',
            'notify_subscribers_forum_override_subject' => '[%BLOG_NAME%] New topic in forum %FORUM_TITLE%: %TOPIC_TITLE%',
            'notify_subscribers_edit_active' => false,
            'notify_subscribers_edit_shortcodes' => true,
            'notify_subscribers_edit_content' => '',
            'notify_subscribers_edit_subject' => '[%BLOG_NAME%] Topic edited: %TOPIC_TITLE%',
            'notify_subscribers_reply_edit_active' => false,
            'notify_subscribers_reply_edit_shortcodes' => true,
            'notify_subscribers_reply_edit_content' => '',
            'notify_subscribers_reply_edit_subject' => '[%BLOG_NAME%] Reply edited: %REPLY_TITLE%',
            'notify_moderators_topic_active' => false,
            'notify_moderators_topic_shortcodes' => true,
            'notify_moderators_topic_content' => '',
            'notify_moderators_topic_subject' => '[%BLOG_NAME%] New topic in forum %FORUM_TITLE%: %TOPIC_TITLE%',
            'notify_subscribers_sender_active' => false,
            'notify_subscribers_sender_name' => '',
            'notify_subscribers_sender_email' => ''
        ),
        'tools' => array(
            'latest_track_users_topic' => true,
            'latest_use_cutoff_timestamp' => true,
            'latest_topic_new_replies_badge' => true,
            'latest_topic_new_replies_mark' => true,
            'latest_topic_new_replies_strong_title' => true,
            'latest_topic_new_replies_in_thread' => true,
            'latest_topic_new_topic_badge' => true,
            'latest_topic_new_topic_strong_title' => true,
            'latest_topic_unread_topic_badge' => true,
            'latest_topic_unread_topic_strong_title' => true,

            'latest_forum_new_posts_badge' => true,
            'latest_forum_new_posts_strong_title' => false,
            'latest_forum_unread_forum_badge' => false,
            'latest_forum_unread_forum_strong_title' => false,

            'track_last_activity_active' => true,
            'track_current_session_cookie_expiration' => 60,
            'track_basic_cookie_expiration' => 365,

            'shortcodes_general_active' => true,
            'shortcodes_general_super_admin' => true,
            'shortcodes_general_visitor' => false,
            'shortcodes_general_roles' => null,
            'shortcodes_bbpress_active' => true,
            'shortcodes_bbpress_super_admin' => true,
            'shortcodes_bbpress_visitor' => false,
            'shortcodes_bbpress_roles' => null,

            'bbcodes_toolbar_active' => true,
            'bbcodes_toolbar_size' => 'small',
            'bbcodes_toolbar_hide_image' => false,
            'bbcodes_toolbar_hide_video' => false,
            'bbcodes_toolbar_hide_rare' => true,
            'bbcodes_toolbar_hide_media' => true,
            'bbcodes_toolbar_hide_restricted' => true,
            'bbcodes_toolbar_show_available_only' => true,
            'bbcodes_toolbar_editor_fix' => true,
            'bbcodes_active' => true,
            'bbcodes_notice' => true,
            'bbcodes_bbpress_only' => false,
            'bbcodes_special_super_admin' => true,
            'bbcodes_special_roles' => null,
            'bbcodes_special_visitor' => false,
            'bbcodes_special_action' => 'info',
            'bbcodes_restricted_super_admin' => true,
            'bbcodes_restricted_administrator' => false,
            'bbcodes_deactivated' => array(),
            'bbcodes_hide_title' => 'Hidden Content',
            'bbcodes_hide_content_normal' => 'You must be logged in to see hidden content.',
            'bbcodes_hide_content_count' => 'You must be logged in and have at least %post_count% posts on this website.',
            'bbcodes_hide_content_reply' => 'You must reply before you can see hidden content.',
            'bbcodes_hide_content_thanks' => 'You must say thanks to topic author before you can see hidden content.',
            'bbcodes_hide_keymaster_always_allowed' => true,
            'bbcodes_spoiler_color' => '#111111',
            'bbcodes_spoiler_hover' => '#eeeeee',
            'bbcodes_attachment_caption' => 'hide',
            'bbcodes_attachment_video_caption' => 'hide',
            'bbcodes_attachment_audio_caption' => 'hide',
            'bbcodes_quote_title' => 'user',
            'bbcodes_scode_theme' => 'Default',
            'bbcodes_highlight_color' => '#222222',
            'bbcodes_highlight_background' => '#ffffb0',
            'bbcodes_heading_size' => 3
        ),
        'widgets' => array(
            'default_disable_recenttopics' => false,
            'default_disable_recentreplies' => false,
            'default_disable_topicviewslist' => false,
            'default_disable_login' => false,
            'default_disable_stats' => false,
            'default_disable_search' => false,
            'widget_foruminfo' => true,
            'widget_topicinfo' => true,
            'widget_search' => true,
            'widget_statistics' => true,
            'widget_onlineusers' => true,
            'widget_topicsviews' => true,
            'widget_newposts' => true,
            'widget_userprofile' => true,
            'widget_usersthanks' => true
        )
    );
    public $migration = array('privacy', 'thanks', 'disable_rss', 'canned', 'report', 'lock');

    public function __construct() {
        $this->info = new gdbbx_core_info();

        add_action('gdbbx_plugin_core_ready', array($this, 'init'));
        add_filter('gdbbx_settings_get', array($this, 'override_get'), 10, 3);
    }

    public function __get($name) {
        $get = explode('_', $name, 2);

        return $this->get($get[1], $get[0]);
    }

    private function _name($name) {
        return 'dev4press_'.$this->info->code.'_'.$name;
    }

    private function _install() {
        $this->current = $this->_merge();
        $this->current['info'] = $this->info->to_array();
        $this->current['info']['install'] = true;
        $this->current['info']['update'] = false;

        foreach ($this->current as $key => $data) {
            update_option($this->_name($key), $data);
        }

        $this->_db();
    }

    private function _update() {
        $old_build = $this->current['info']['build'];

        $this->current['info'] = $this->info->to_array();
        $this->current['info']['install'] = false;
        $this->current['info']['update'] = true;
        $this->current['info']['previous'] = $old_build;

        update_option($this->_name('info'), $this->current['info']);

        $settings = $this->_merge();

        foreach ($this->migration as $key) {
            $settings[$key] = array();
        }

        foreach ($settings as $key => $data) {
            $now = get_option($this->_name($key));

            if ($now !== false && is_array($now)) {
                $this->temp[$key] = $now;
            }

            if (!in_array($key, $this->migration)) {
                if (!is_array($now)) {
                    $now = $data;
                } else {
                    $now = $this->_upgrade($now, $data);
                }

                $this->current[$key] = $now;

                update_option($this->_name($key), $now);
            } else {
                delete_option($this->_name($key));
            }
        }

        $this->_db();
        $this->_migrate();
    }

    private function _upgrade($old, $new) {
        foreach ($new as $key => $value) {
            if (!array_key_exists($key, $old)) {
                $old[$key] = $value;
            }
        }

        $unset = array();
        foreach ($old as $key => $value) {
            if (!array_key_exists($key, $new)) {
                $unset[] = $key;
            }
        }

        if (!empty($unset)) {
            foreach ($unset as $key) {
                unset($old[$key]);
            }
        }

        return $old;
    }

    private function _groups() {
        return array_keys($this->settings);
    }

    private function _merge() {
        $merged = array();

        foreach ($this->settings as $key => $data) {
            $merged[$key] = array();

            foreach ($data as $name => $value) {
                $merged[$key][$name] = $value;
            }
        }

        return $merged;
    }

    private function _migrate() {
        require_once(GDBBX_PATH.'core/admin/migrate.php');
        require_once(GDBBX_PATH.'core/admin/install.php');

        gdbbx_settings_migration();
        gdbbx_convert_attachments_assignments();
    }

    private function _db() {
        require_once(GDBBX_PATH.'core/admin/install.php');

        gdbbx_install_database();
    }

    public function init() {
        $this->current['info'] = get_option($this->_name('info'));

        $installed = is_array($this->current['info']) && isset($this->current['info']['build']);

        if (!$installed) {
            $this->_install();
        } else {
            $update = $this->current['info']['build'] != $this->info->build;

            if ($update) {
                $this->_update();
            } else {
                $groups = $this->_groups();

                foreach ($groups as $key) {
                    $this->current[$key] = get_option($this->_name($key));

                    if (!is_array($this->current[$key])) {
                        $data = $this->group($key);

                        if (!is_null($data)) {
                            $this->current[$key] = $data;

                            update_option($this->_name($key), $data);
                        }
                    }
                }
            }
        }

        $this->current['rules']['forums_auto_close'] = (array)$this->current['rules']['forums_auto_close'];
        $this->current['features']['mime-types__list'] = (array)$this->current['features']['mime-types__list'];

        do_action('gdbbx_plugin_settings_loaded');
    }

    public function group($group) {
        if (isset($this->settings[$group])) {
            return $this->settings[$group];
        }

        return null;
    }

    public function exists($name, $group = 'settings') {
        if (isset($this->current[$group][$name])) {
            return true;
        } else if (isset($this->settings[$group][$name])) {
            return true;
        } else {
            return false;
        }
    }

    public function allowed($name, $group = 'settings', $visitor = false, $super_admin = true) {
        $allowed = false;
        $clean = trim($name, '_');

        if (current_user_can('d4p_bbpt_'.$clean, 'do_not_allow') || current_user_can('gdbbx_cap_'.$clean, 'do_not_allow')) {
            $allowed = true;
        }

        if ($super_admin && !$allowed && is_super_admin()) {
            $allowed = $this->get($name.'_super_admin', $group);
        }

        if (!$allowed && is_user_logged_in()) {
            $roles = $this->get($name.'_roles', $group);

            if (is_null($roles)) {
                $allowed = true;
            } else if (is_array($roles) && empty($roles)) {
                $allowed = false;
            } else if (is_array($roles) && !empty($roles)) {
                global $current_user;

                if (is_array($current_user->roles)) {
                    $matched = array_intersect($current_user->roles, $roles);
                    $allowed = !empty($matched);
                }
            }
        }

        if ($visitor && !$allowed && !is_user_logged_in()) {
            $allowed = $this->get($name.'_visitor', $group);
        }

        return apply_filters('gdbbx_allowed_'.$clean, $allowed);
    }

    public function prefix_get($prefix, $group = 'settings', $get_full_keys = false, $get_defaults = false) {
        $settings = array_keys($this->group($group));

        $results = array();

        foreach ($settings as $key) {
            if (substr($key, 0, strlen($prefix)) == $prefix) {
                $new = $get_full_keys ? $key : substr($key, strlen($prefix));

                $results[$new] = $get_defaults ? $this->get_default($key, $group) :
                                                 $this->get($key, $group);
            }
        }

        return $results;
    }

    public function group_get($group) {
        return $this->current[$group];
    }

    public function get_core($name) {
        return $this->get($name, 'core');
    }

    public function get_default($name, $group = 'settings', $default = null) {
        $exit = $default;

        if (isset($this->settings[$group][$name])) {
            $exit = $this->settings[$group][$name];
        }

        return $exit;
    }

    public function get($name, $group = 'settings', $default = null) {
        $exit = $default;

        if (isset($this->current[$group][$name])) {
            $exit = $this->current[$group][$name];
        } else if (isset($this->settings[$group][$name])) {
            $exit = $this->settings[$group][$name];
        }

        return apply_filters('gdbbx_settings_get', $exit, $name, $group);
    }

    public function set($name, $value, $group = 'settings', $save = false) {
        $this->current[$group][$name] = $value;

        if ($save) {
            $this->save($group);
        }
    }

    public function reset_feature($name) {
        $list = $this->prefix_get($name.'__', 'features', true, true);

        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $this->set($key, $value, 'features');
            }

            $this->save('features');
        }
    }

    public function save($group) {
        update_option($this->_name($group), $this->current[$group]);
    }

    public function is_install() {
        return $this->get('install', 'info');
    }

    public function is_update() {
        return $this->get('update', 'info');
    }

    public function mark_for_update() {
        $this->current['info']['update'] = true;

        $this->save('info');
    }

    public function override_get($value, $name, $group) {
        if ($group == 'bbpress' && $name == 'notify_subscribers_forum_override_content' && $value == '') {
            $value = _x("%TOPIC_AUTHOR% created new topic '%TOPIC_TITLE%' in forum: %FORUM_TITLE%.
You can see this topic here: %TOPIC_LINK%

-----------
You are receiving this email because you subscribed to a forum. Login and visit your profile page to unsubscribe from these emails.

Forum Link: %FORUM_LINK%
-----------
Do not reply to this email!", "Email message override: notify forum subscribers", "gd-bbpress-toolbox");
        }

        if ($group == 'bbpress' && $name == 'notify_subscribers_reply_edit_content' && $value == '') {
            $value = _x("%REPLY_EDITOR% edited reply: %REPLY_TITLE%.

Edit log:
%REPLY_EDIT%

You can see edited topic: %REPLY_LINK%

-----------
You are receiving this email because you subscribed to a forum topic. Login and visit the topic to unsubscribe from these emails.

-----------
Do not reply to this email!", "Email message override: notify subscribers on reply edit", "gd-bbpress-toolbox");
        }

        if ($group == 'report' && $name == 'notify_content' && $value == '') {
            $value = _x("%REPORT_AUTHOR% reported '%REPORT_TITLE%' in forum: '%FORUM_TITLE%'.
You can see this post here: %REPORT_LINK%

Report content:
%REPORT_CONTENT%

List of all reports:
%REPORTS_LIST%
-----------
Do not reply to this email!", "Email message override: notify about post report", "gd-bbpress-toolbox");
        }

        if ($group == 'features' && $name == 'thanks__notify_content' && $value == '') {
            $value = _x("%THANKS_AUTHOR% said thanks for '%POST_TITLE%' in forum: '%FORUM_TITLE%'.

You can see this post here: %POST_LINK%
-----------
Do not reply to this email!", "Email message: notify about post thanks", "gd-bbpress-toolbox");
        }

        if ($group == 'bbpress' && $name == 'notify_subscribers_override_content' && $value == '') {
            $value = _x("%REPLY_AUTHOR% replied to topic: %TOPIC_TITLE%.
You can see his reply here: %REPLY_LINK%

-----------
You are receiving this email because you subscribed to a forum topic. Login and visit the topic to unsubscribe from these emails.

Topic Link: %TOPIC_LINK%
-----------
Do not reply to this email!", "Email message override: notify topic subscribers", "gd-bbpress-toolbox");
        }

        if ($group == 'bbpress' && $name == 'notify_subscribers_edit_content' && $value == '') {
            $value = _x("%TOPIC_EDITOR% edited topic: %TOPIC_TITLE%.

Edit log:
%TOPIC_EDIT%

You can see edited topic: %TOPIC_LINK%

-----------
You are receiving this email because you subscribed to a forum topic. Login and visit the topic to unsubscribe from these emails.

-----------
Do not reply to this email!", "Email message override: notify subscribers on topic edit", "gd-bbpress-toolbox");
        }

        if ($group == 'bbpress' && $name == 'notify_moderators_topic_content' && $value == '') {
            $value = _x("%TOPIC_AUTHOR% created new topic: %TOPIC_TITLE%
In the forum: %FORUM_TITLE%
You can see the topic here: %TOPIC_LINK%

-----------
This email is sent to keymasters and moderators when new topic is created.

-----------
Do not reply to this email!", "Email message override: notify moderators on new topic", "gd-bbpress-toolbox");
        }

        if ($group == 'features' && $name == 'auto-close-topics__notify_content' && $value == '') {
            $value = _x("Topic: %TOPIC_TITLE%
In the forum: %FORUM_TITLE%
Has been automatically closed due to inactivity.

Topic Link: %TOPIC_LINK%
-----------
You are receiving this email because you subscribed to a forum topic. Login and visit the topic to unsubscribe from these emails.

-----------
Do not reply to this email!", "Email message: notify on topic auto close", "gd-bbpress-toolbox");
        }

        if ($group == 'features' && $name == 'close-topic-control__notify_content' && $value == '') {
            $value = _x("Topic: %TOPIC_TITLE%
In the forum: %FORUM_TITLE%
Has been closed by %CLOSED_USER%.

Topic Link: %TOPIC_LINK%
-----------
You are receiving this email because you subscribed to a forum topic. Login and visit the topic to unsubscribe from these emails.

-----------
Do not reply to this email!", "Email message: notify on topic manual close", "gd-bbpress-toolbox");
        }

        if ($group == 'attachments' && $name == 'mime_types_list' && empty($value)) {
            $list = get_allowed_mime_types();
            $value = array_keys($list);
        }

        if ($group == 'core' && $name == 'unread_cutoff' && $value == 0) {
            $value = time();

            $this->set('unread_cutoff', $value, 'core', true);
        }

        return $value;
    }

    public function remove_all_plugin_settings() {
        foreach ($this->_groups() as $group) {
            delete_option($this->_name($group));
        }
    }

    public function remove_selected_settings($groups = array()) {
        foreach ($groups as $group) {
            delete_option($this->_name($group));
        }
    }

    public function remove_forums_settings() {
        $sql = "DELETE FROM ".gdbbx_db()->wpdb()->postmeta." WHERE meta_key = '_gdbbatt_settings'";

        gdbbx_db()->query($sql);
    }

    public function remove_tracking_settings() {
        $sql = "DELETE FROM ".gdbbx_db()->wpdb()->usermeta." WHERE meta_key = '".gdbbx_plugin()->user_meta_key_last_activity()."'";

        gdbbx_db()->query($sql);
    }

    public function remove_signature_settings() {
        $sql = "DELETE FROM ".gdbbx_db()->wpdb()->usermeta." WHERE meta_key = 'signature'";

        gdbbx_db()->query($sql);
    }

    public function import_from_object($import, $list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        foreach ($import as $key => $data) {
            if (in_array($key, $list)) {
                $this->current[$key] = (array)$data;

                $this->save($key);
            }
        }
    }

    protected function _settings_to_array($list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        $data = array(
            'info' => $this->current['info']
        );

        foreach ($list as $name) {
            $data[$name] = $this->current[$name];
        }

        return $data;
    }

    public function import_from_secure_json($import, $groups = array()) {
        $message = 'invalid-import';

        $name = isset($import['name']) ? $import['name'] : false;
        $ctrl = isset($import['ctrl']) ? $import['ctrl'] : false;
        $raw = isset($import['data']) ? $import['data'] : false;

        $data = gzuncompress(base64_decode(urldecode($raw)));

        if ($ctrl && $data && strlen($ctrl) == 64) {
            $ctrl = substr($ctrl, 8, 32);
            $size_import = mb_strlen($data);
            $ctrl_import = $name === false ? md5($data.$size_import) : md5($data.'gd-bbpress-toolbox'.$size_import);

            if ($ctrl_import === $ctrl) {
                $data = json_decode($data, true);
                $this->import_from_object($data, $groups);

                $message = 'imported';
            }
        }

        return $message;
    }

    public function export_to_secure_json($list = array()) {
        $export = $this->_settings_to_array($list);

        $encoded = json_encode($export);

        if ($encoded === false) {
            return false;
        }

        $size = mb_strlen($encoded);

        $export = array(
            'name' => 'gd-bbpress-toolbox',
            'ctrl' => strtolower(wp_generate_password(8, false)).md5($encoded.'gd-bbpress-toolbox'.$size).strtolower(wp_generate_password(24, false)),
            'data' => urlencode(base64_encode(gzcompress($encoded, 9)))
        );

        return json_encode($export, JSON_PRETTY_PRINT);
    }

    public function session_cookie_expiration() {
        return time() + $this->get('track_current_session_cookie_expiration', 'tools') * 60;
    }

    public function tracking_cookie_expiration() {
        return time() + $this->get('track_basic_cookie_expiration', 'tools') * 3600 * 24;
    }

    public function has_free_plugins() {
        $list = array();

        if (defined('GDBBPRESSATTACHMENTS_INSTALLED')) {
            $list[] = 'GD bbPress Attachments';
        }

        if (defined('GDBBPRESSTOOLS_INSTALLED')) {
            $list[] = 'GD bbPress Tools';
        }

        if (defined('GDBBPRESSWIDGETS_INSTALLED')) {
            $list[] = 'GD bbPress Widgets';
        }

        return $list;
    }

    public function is_inside_content_shortcode($id = 0) {
        if ($id == 0) {
            $id = bbp_get_topic_id();
        }

        return isset($this->_inside_content_shortcode[$id]);
    }

    public function set_inside_content_shortcode($id, $set = true) {
        if ($set) {
            $this->_inside_content_shortcode[$id] = $set;
        } else {
            unset($this->_inside_content_shortcode[$id]);
        }
    }

    public function file_version() {
        return $this->info_version.'.'.$this->info_build;
    }

    public function get_image_extensions() {
        return apply_filters('gdbbx_attachment_image_extensions', array('svg', 'png', 'gif', 'jpg', 'jpeg', 'jpe', 'bmp'));
    }

    public function get_video_extensions() {
        return apply_filters('gdbbx_attachment_video_extensions', wp_get_video_extensions());
    }

    public function get_audio_extensions() {
        return apply_filters('gdbbx_attachment_audio_extensions', wp_get_audio_extensions());
    }
}
