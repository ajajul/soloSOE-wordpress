<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_core_wizard {
    public $panel = false;
    public $panels = array();

    public $_default = array(
        'toolbar' => array(
            'toolbar__super_admin' => true,
            'toolbar__visitor' => true,
            'toolbar__roles' => null,
            'toolbar__title' => 'Forums',
            'toolbar__information' => true
        ),
        'signatures' => array(
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
            'signatures__process_autop' => true
        ),
        'quotes' => array(
            'quote__method' => 'bbcode',
            'quote__full_content' => 'postquote',
            'quote__super_admin' => true,
            'quote__visitor' => false,
            'quote__roles' => null
        ),
        'canned' => array(
            'canned-replies__canned_roles' => array('bbp_keymaster', 'bbp_moderator'),
            'canned-replies__post_type_singular' => 'Canned Reply',
            'canned-replies__post_type_plural' => 'Canned Replies',
            'canned-replies__use_taxonomy' => false,
            'canned-replies__taxonomy_singular' => 'Category',
            'canned-replies__taxonomy_plural' => 'Categories',
            'canned-replies__auto_close_on_insert' => true
        ),
        'thanks' => array(
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
            'thanks__notify_subject' => '[%BLOG_NAME%] Thanks received: %POST_TITLE%'
        ),
        'report' => array(
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
            'report__notify_subject' => '[%BLOG_NAME%] Post reported: %REPORT_TITLE%'
        ),
        'private' => array(
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
            'private-replies__css_hide' => false
        ),
        'stats' => array(
            'users-stats__super_admin' => true,
            'users-stats__visitor' => false,
            'users-stats__roles' => null,
            'users-stats__show_online_status' => true,
            'users-stats__show_registration_date' => false,
            'users-stats__show_topics' => true,
            'users-stats__show_replies' => true,
            'users-stats__show_thanks_given' => false,
            'users-stats__show_thanks_received' => false
        ),
        'attachments' => array(
            'hide_from_visitors' => true,
            'preview_for_visitors' => false,
            'max_file_size' => 512,
            'max_to_upload' => 4,
            'file_target_blank' => false,
            'roles_to_upload' => null,
            'roles_no_limit' => array('bbp_keymaster'),
            'attachment_icon' => true,
            'attachment_icons' => true,
            'download_link_attribute' => true
        ),
        'tinymce' => array(
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
            'editor__reply_textarea_rows' => 12
        ),
        'activity_off' => array(
            'latest_track_users_topic' => false,
            'latest_topic_new_replies_badge' => false,
            'latest_topic_new_replies_mark' => false,
            'latest_topic_new_replies_strong_title' => false,
            'latest_topic_new_replies_in_thread' => false,
            'latest_topic_new_topic_badge' => false,
            'latest_topic_new_topic_strong_title' => false,
            'latest_topic_unread_topic_badge' => false,
            'latest_topic_unread_topic_strong_title' => false,
            'latest_forum_new_posts_badge' => false,
            'latest_forum_new_posts_strong_title' => false,
            'latest_forum_unread_forum_badge' => false,
            'latest_forum_unread_forum_strong_title' => false,
            'track_last_activity_active' => false
        ),
        'activity' => array(
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
            'latest_forum_unread_forum_badge' => true,
            'latest_forum_unread_forum_strong_title' => false,
            'track_last_activity_active' => true,
            'track_current_session_cookie_expiration' => 60,
            'track_basic_cookie_expiration' => 365
        )
    );
    
    public function __construct() {
        $this->_init_panels();
    }

    private function _init_panels() {
        $this->panels = array(
            'intro' => array('label' => __("Intro", "gd-bbpress-toolbox")),
            'features' => array('label' => __("Features", "gd-bbpress-toolbox")),
            'editors' => array('label' => __("Editors", "gd-bbpress-toolbox")),
            'attachments' => array('label' => __("Attachments", "gd-bbpress-toolbox")),
            'tracking' => array('label' => __("Tracking", "gd-bbpress-toolbox")),
            'finish' => array('label' => __("Finish", "gd-bbpress-toolbox"))
        );

        $this->setup_panel(gdbbx_admin()->panel);
    }

    public function setup_panel($panel) {
        $this->panel = $panel;

        if (!isset($this->panels[$panel]) || $panel === false || is_null($panel)) {
            $this->panel = 'intro';
        }
    }

    public function current_panel() {
        return $this->panel;
    }

    public function panels_index() {
        return array_keys($this->panels);
    }

    public function next_panel() {
        $panel = $this->current_panel();
        $all = $this->panels_index();

        $index = array_search($panel, $all);
        $next = $index + 1;

        if ($next == count($all)) {
            $next = 0;
        }

        return $all[$next];
    }

    public function is_last_panel() {
        $panel = $this->current_panel();
        $all = $this->panels_index();

        $index = array_search($panel, $all);

        return $index + 1 == count($all);
    }

    public function get_form_action() {
        return 'admin.php?page=gd-bbpress-toolbox-wizard&panel='.$this->next_panel();
    }

    public function get_form_nonce() {
        return wp_create_nonce('gdbbx-wizard-nonce-'.$this->current_panel());
    }

    public function panel_postback() {
        $post = $_POST['gdbbx']['wizard'];

        $this->setup_panel($post['_page']);

        if (wp_verify_nonce($post['_nonce'], 'gdbbx-wizard-nonce-'.$this->current_panel())) {
            $data = isset($post[$this->current_panel()]) ? (array)$post[$this->current_panel()] : array();

            switch ($this->current_panel()) {
                case 'intro':
                    $this->_postback_intro($data);
                    break;
                case 'features':
                    $this->_postback_features($data);
                    break;
                case 'attachments':
                    $this->_postback_attachments($data);
                    break;
                case 'editors':
                    $this->_postback_editors($data);
                    break;
                case 'tracking':
                    $this->_postback_tracking($data);
                    break;
            }

            wp_redirect('admin.php?page=gd-bbpress-toolbox-wizard&panel='.$this->next_panel());
            exit;
        } else {
            wp_redirect('admin.php?page=gd-bbpress-toolbox-wizard&panel='.$this->current_panel());
            exit;
        }
    }

    private function _copy_settings($what, $group = 'features') {
        foreach ($this->_default[$what] as $key => $value) {
            gdbbx()->set($key, $value, $group);
        }
    }

    private function _postback_intro($data) {
        if (isset($data['toolbar']) && $data['toolbar'] == 'yes') {
            gdbbx()->set('toolbar', true, 'load');

            $this->_copy_settings('toolbar');
        } else {
            gdbbx()->set('toolbar', false, 'load');
        }

        if (isset($data['signatures']) && $data['signatures'] == 'yes') {
            gdbbx()->set('signatures', true, 'load');

            $this->_copy_settings('signatures');
        } else {
            gdbbx()->set('signatures', false, 'load');
        }

        if (isset($data['bbcodes']) && $data['bbcodes'] == 'yes') {
            gdbbx()->set('bbcodes_active', true, 'tools');
        } else {
            gdbbx()->set('bbcodes_active', false, 'tools');
        }

        if (isset($data['quotes']) && $data['quotes'] == 'yes') {
            gdbbx()->set('quote', true, 'load');

            $this->_copy_settings('quotes');

            gdbbx()->set('tweaks__kses_allowed_override', 'expanded', 'features');

            if (isset($data['bbcodes']) && $data['bbcodes'] == 'yes') {
                gdbbx()->set('quote__method', 'bbcode', 'features');
            } else {
                gdbbx()->set('quote__method', 'html', 'features');
            }
        } else {
            gdbbx()->set('quote', false, 'load');
        }

        gdbbx()->save('load');
        gdbbx()->save('features');
        gdbbx()->save('tools');
        gdbbx()->save('bbpress');
    }

    private function _postback_features($data) {
        if (isset($data['canned']) && $data['canned'] == 'yes') {
            gdbbx()->set('canned-replies', true, 'load');

            $this->_copy_settings('canned');
        } else {
            gdbbx()->set('canned-replies', false, 'load');
        }

        if (isset($data['thanks']) && $data['thanks'] == 'yes') {
            gdbbx()->set('thanks', true, 'load');

            $this->_copy_settings('thanks');
        } else {
            gdbbx()->set('thanks', false, 'load');
        }

        if (isset($data['report']) && $data['report'] == 'yes') {
            gdbbx()->set('report', true, 'load');

            $this->_copy_settings('report');
        } else {
            gdbbx()->set('report', false, 'load');
        }

        if (isset($data['private']) && $data['private'] == 'yes') {
            gdbbx()->set('private-topics', true, 'load');
            gdbbx()->set('private-replies', true, 'load');

            $this->_copy_settings('private');
        } else {
            gdbbx()->set('private-topics', false, 'load');
            gdbbx()->set('private-replies', false, 'load');
        }

        if (isset($data['stats']) && $data['stats'] == 'yes') {
            gdbbx()->set('users-stats', true, 'load');

            $this->_copy_settings('stats');

            if (isset($data['thanks']) && $data['thanks'] == 'yes') {
                gdbbx()->set('users-stats__show_thanks_given', true, 'features');
                gdbbx()->set('users-stats__show_thanks_received', true, 'features');
            }
        } else {
            gdbbx()->set('users-stats', false, 'load');
        }

        gdbbx()->save('load');
        gdbbx()->save('features');
    }

    private function _postback_editors($data) {
        $update_tinymce_settings = false;

        bbp_wp_editor_status(false);

        gdbbx()->set('editor', false, 'load');
        gdbbx()->set('bbcodes_toolbar_active', false, 'tools');
        gdbbx()->set('editor__topic_tinymce', false, 'features');
        gdbbx()->set('editor__reply_tinymce', false, 'features');

        if (isset($data['replace']) && $data['replace'] == 'yes') {
            switch ($data['editor']) {
                case 'quicktags':
                    bbp_wp_editor_status();
                    break;
                case 'bbcodes':
                    gdbbx()->set('bbcodes_toolbar_active', true, 'tools');
                    break;
                case 'teeny':
                case 'tinymce':
                    $update_tinymce_settings = true;
                    bbp_wp_editor_status();

                    $this->_copy_settings('tinymce');

                    gdbbx()->set('editor', true, 'load');
                    break;
            }

            if ($data['editor'] == 'teeny') {
                gdbbx()->set('editor__topic_teeny', true, 'features');
                gdbbx()->set('editor__reply_teeny', true, 'features');
            }
        }

        if (isset($data['library']) && $data['library'] == 'yes') {
            gdbbx()->set('tweaks__participant_media_library_upload', true, 'features');

            if ($update_tinymce_settings) {
                gdbbx()->set('editor__topic_media_buttons', true, 'features');
                gdbbx()->set('editor__reply_media_buttons', true, 'features');
            }
        } else {
            gdbbx()->set('tweaks__participant_media_library_upload', false, 'features');
        }

        gdbbx()->save('load');
        gdbbx()->save('features');
        gdbbx()->save('tools');
    }

    private function _postback_attachments($data) {
        if (isset($data['attach']) && $data['attach'] == 'yes') {
            gdbbx()->set('attachments_active', true, 'attachments');

            foreach ($this->_default['attachments'] as $key => $value) {
                gdbbx()->set($key, $value, 'attachments');
            }

            if (isset($data['enhance']) && $data['enhance'] == 'yes') {
                gdbbx()->set('validation_active', true, 'attachments');
            } else {
                gdbbx()->set('validation_active', false, 'attachments');
            }

            if (isset($data['images']) && $data['images'] == 'yes') {
                gdbbx()->set('image_thumbnail_active', true, 'attachments');
            } else {
                gdbbx()->set('image_thumbnail_active', false, 'attachments');
            }

            $mime = isset($data['mime']) ? sanitize_text_field($data['mime']) : 'all';

            switch ($mime) {
                default:
                case 'all':
                    $value = array();
                    break;
                case 'images':
                    $value = array('jpg|jpeg|jpe', 'png', 'gif');
                    break;
                case 'media':
                    $value = array('jpg|jpeg|jpe', 'png', 'gif', 'mp3|m4a|m4b', 'mov|qt', 'avi', 'wmv', 'mid|midi');
                    break;
            }

            gdbbx()->set('mime_types_list', $value, 'attachments');
        } else {
            gdbbx()->set('attachments_active', false, 'attachments');
        }

        gdbbx()->save('attachments');
    }

    private function _postback_tracking($data) {
        if (isset($data['online']) && $data['online'] == 'yes') {
            gdbbx()->set('active', true, 'online');
            gdbbx()->set('track_users', true, 'online');
            gdbbx()->set('track_guests', true, 'online');
        } else {
            gdbbx()->set('active', false, 'online');
        }

        if (isset($data['activity']) && $data['activity'] == 'yes') {
            foreach ($this->_default['activity'] as $key => $value) {
                gdbbx()->set($key, $value, 'tools');
            }
        } else {
            foreach ($this->_default['activity_off'] as $key => $value) {
                gdbbx()->set($key, $value, 'tools');
            }
        }

        gdbbx()->save('online');
        gdbbx()->save('tools');
    }
}

global $_gdbbx_the_wizard;
$_gdbbx_the_wizard = new gdbbx_core_wizard();

/** @return gdbbx_core_wizard */
function gdbbx_wizard() {
    global $_gdbbx_the_wizard;
    return $_gdbbx_the_wizard;
}
