<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_mod_attachments {
    private $o;

    public $inserted = array();

    /** @var gdbbx_attachments_front */
    public $front;

    function __construct() {
        $this->o = gdbbx()->group_get('attachments');

        add_action('gdbbx_init', array($this, 'load'));

        add_action('before_delete_post', array($this, 'delete_post'));

        if ($this->o['hide_attachments_from_media_library']) {
            add_filter('ajax_query_attachments_args', array($this, 'query_attachments'));

            if (is_admin()) {
                add_action('pre_get_posts', array($this, 'query_attachments_list'));
            }
        }
    }

    public function query_attachments_list($wp_query) {
        global $pagenow;

        if (!in_array($pagenow, array('upload.php'))) {
            return;
        }

        add_filter('posts_clauses', array($this, 'intercept_query_clauses'));
    }

    public function query_attachments($query) {
        add_filter('posts_clauses', array($this, 'intercept_query_clauses'));

        return $query;
    }

    public function intercept_query_clauses($pieces) {
        remove_filter('posts_clauses', array($this, 'intercept_query_clauses'));

        $pieces['join'].= ' LEFT JOIN wp_gdbbx_attachments gdbbxa ON gdbbxa.attachment_id = wp_posts.ID ';
        $pieces['where'].= ' AND gdbbxa.post_id IS NULL ';

        return $pieces;
    }

    public function get($name) {
        return isset($this->o[$name]) ? $this->o[$name] : false;
    }

    public function load() {
        $this->init_thumbnail_size();
        $this->delete_attachments();

        if (!is_admin()) {
            require_once(GDBBX_PATH.'modules/attachments/front.php');
            $this->front = new gdbbx_attachments_front();
        }
    }

    public function attachment_inserted($id, $attachment_id) {
        if (!isset($this->inserted[$id])) {
            $this->inserted[$id] = array();
        }

        $this->inserted[$id][] = absint($attachment_id);
    }

    public function get_inserted_attachments($id) {
        if (isset($this->inserted[$id]) && !empty($this->inserted[$id])) {
            return $this->inserted[$id];
        }

        return array();
    }

    public function init_thumbnail_size() {
        $size = $this->o['image_thumbnail_size'];
        $size = explode('x', $size);

        $args = apply_filters('gdbbx_attachments_thumb_image_size_args', array(
            'width' => $size[0],
            'height' => $size[1],
            'crop' => true
        ));

        add_image_size('gdbbx-thumb', $args['width'], $args['height'], $args['crop']);
    }

    public function deletion_status($author_id) {
        $allow = 'no';

        if (gdbbx_is_current_user_bbp_keymaster()) {
            $allow = gdbbx()->get('delete_visible_to_admins', 'attachments');
        } else if (gdbbx_is_current_user_bbp_moderator()) {
            $allow = gdbbx()->get('delete_visible_to_moderators', 'attachments');
        } else if ($author_id == bbp_get_current_user_id()) {
            $allow = gdbbx()->get('delete_visible_to_author', 'attachments');
        }

        return $allow;
    }

    public function delete_attachment($att_id, $bbp_id, $action) {
        $post = get_post($bbp_id);
        $author_id = $post->post_author;

        $allow = $this->deletion_status($author_id);

        if ($action == 'delete' && ($allow == 'delete' || $allow == 'both')) {
            gdbbx_db()->delete_attachment($bbp_id, $att_id);
        }

        if ($action == 'detach' && ($allow == 'detach' || $allow == 'both')) {
            gdbbx_db()->detach_attachment($bbp_id, $att_id);
        }

        $_topic_id = bbp_is_topic($bbp_id) ? $bbp_id : bbp_get_reply_topic_id($bbp_id);

        gdbbx_db()->update_topic_attachments_count($_topic_id);
    }

    public function delete_attachments() {
        if (isset($_GET['gdbbx-action'])) {
            $action = d4p_sanitize_basic($_GET['gdbbx-action']);
            $att_id = absint($_GET['att_id']);
            $bbp_id = absint($_GET['bbp_id']);

            if ($att_id > 0 && $bbp_id > 0 && ($action == 'delete' || $action == 'detach')) {
                $nonce = wp_verify_nonce($_GET['_wpnonce'], 'gdbbx-attachment-'.$action.'-'.$bbp_id.'-'.$att_id);

                if ($nonce) {
                    $this->delete_attachment($att_id, $bbp_id, $action);
                }
            }

            $url = remove_query_arg(array('_wpnonce', 'gdbbx-action', 'att_id', 'bbp_id'));
            wp_redirect($url);
            exit;
        }
    }

    public function delete_post($id) {
        if (bbp_is_reply($id) || bbp_is_topic($id)) {
            if ($this->get('delete_attachments') == 'delete') {
                $files = gdbbx_get_post_attachments($id);

                if (is_array($files) && !empty($files)) {
                    foreach ($files as $file) {
                        gdbbx_db()->delete_attachment($id, $file->ID);
                    }
                }
            } else if ($this->get('delete_attachments') == 'detach') {
                gdbbx_db()->remove_attachment_assignment($id);

                gdbbx_db()->update(gdbbx_db()->wpdb()->posts, array('post_parent' => 0), array('post_parent' => $id, 'post_type' => 'attachment'));
            }

            if (bbp_is_reply($id)) {
                $topic_id = bbp_get_reply_topic_id($id);

                gdbbx_db()->update_topic_attachments_count($topic_id);
            }
        }
    }

    public function get_file_size($forum_id = 0) {
        $size = gdbbx()->get('max_file_size', 'attachments');

        $forum = gdbbx_forum($forum_id)->attachments()->get('max_file_size_override');
        $override = gdbbx_forum($forum_id)->attachments()->get('max_file_size');

        if ($override > 0 && $forum == 'yes') {
            $size = $override;
        }

        return apply_filters('gdbbx_attchaments_max_file_size', $size, gdbbx_forum()->forum());
    }

    public function get_max_files($forum_id = 0) {
        $files = gdbbx()->get('max_to_upload', 'attachments');

        $forum = gdbbx_forum($forum_id)->attachments()->get('max_to_upload_override');
        $override = gdbbx_forum($forum_id)->attachments()->get('max_to_upload');

        if ($override > 0 && $forum == 'yes') {
            $files = $override;
        }

        return apply_filters('gdbbx_attchaments_max_to_upload', $files, gdbbx_forum()->forum());
    }

    public function filter_mime_types($forum_id = 0) {
        if ($this->is_no_limit()) {
            return null;
        }

        if (gdbbx()->get('mime_types_limit_active', 'attachments')) {
            $full = get_allowed_mime_types();
            $list = gdbbx()->get('mime_types_list', 'attachments');

            $forum = gdbbx_forum($forum_id)->attachments()->get('mime_types_list_override');
            $override = gdbbx_forum($forum_id)->attachments()->get('mime_types_list');

            if (!empty($override) && $forum == 'yes') {
                $list = $override;
            }

            $filtered = array();
            foreach ($full as $key => $mime) {
                if (in_array($key, $list)) {
                    $filtered[$key] = $mime;
                }
            }

            return $filtered;
        } else {
            return null;
        }
    }

    public function get_file_extensions($forum_id = 0) {
        $list = gdbbx()->get('mime_types_list', 'attachments');

        $forum = gdbbx_forum($forum_id)->attachments()->get('mime_types_list_override');
        $override = gdbbx_forum($forum_id)->attachments()->get('mime_types_list');

        if (!empty($override) && $forum == 'yes') {
            $list = $override;
        }

        $show = array();
        foreach ($list as $i) {
            $show = array_merge($show, explode('|', $i));
        }

        return apply_filters('gdbbx_attchaments_extensions_list', $show, gdbbx_forum()->forum());
    }

    public function is_hidden_from_visitors($forum_id = 0) {
        $forum = gdbbx_forum($forum_id)->attachments()->get('hide_from_visitors');

        $hide = false;
        if ($forum == 'default') {
            $hide = gdbbx()->get('hide_from_visitors', 'attachments');
        } else if ($forum == 'yes') {
            $hide = true;
        } else if ($forum == 'no') {
            $hide = false;
        }

        return apply_filters('gdbbx_attchaments_is_hidden_from_visitors', $hide, gdbbx_forum()->forum());
    }

    public function is_preview_for_visitors($forum_id = 0) {
        $forum = gdbbx_forum($forum_id)->attachments()->get('preview_for_visitors');

        $hide = false;
        if ($forum == 'default') {
            $hide = gdbbx()->get('preview_for_visitors', 'attachments');
        } else if ($forum == 'yes') {
            $hide = true;
        } else if ($forum == 'no') {
            $hide = false;
        }

        return apply_filters('gdbbx_attchaments_is_preview_for_visitors', $hide, gdbbx_forum()->forum());
    }

    public function is_active($forum_id = 0) {
        $forum = gdbbx_forum($forum_id)->attachments()->get('status');

        $active = false;
        if ($forum == 'default') {
            $active = gdbbx()->get('attachments_active', 'attachments');
        } else if ($forum == 'yes') {
            $active = true;
        } else if ($forum == 'no') {
            $active = false;
        }

        return apply_filters('gdbbx_attchaments_forum_enabled', $active, gdbbx_forum()->forum());
    }

    public function in_topic_form($forum_id = 0) {
        $forum = gdbbx_forum($forum_id)->attachments()->get('topic_form');

        $active = false;
        if ($forum == 'default') {
            $active = gdbbx()->get('topics', 'attachments');
        } else if ($forum == 'yes') {
            $active = true;
        } else if ($forum == 'no') {
            $active = false;
        }

        return apply_filters('gdbbx_attchaments_forum_topic_form', $active, gdbbx_forum()->forum());
    }

    public function in_reply_form($forum_id = 0) {
        $forum = gdbbx_forum($forum_id)->attachments()->get('reply_form');

        $active = false;
        if ($forum == 'default') {
            $active = gdbbx()->get('replies', 'attachments');
        } else if ($forum == 'yes') {
            $active = true;
        } else if ($forum == 'no') {
            $active = false;
        }

        return apply_filters('gdbbx_attchaments_forum_reply_form', $active, gdbbx_forum()->forum());
    }

    public function is_right_size($file, $forum_id = 0) {
        if ($this->is_no_limit()) {
            return true;
        }

        $file_size = $this->get_file_size($forum_id);

        return $file['size'] <= $file_size * KB_IN_BYTES;
    }

    public function is_user_allowed() {
        $allowed = false;

        if (is_user_logged_in()) {
            if (!isset($this->o['roles_to_upload'])) {
                $allowed = true;
            } else {
                global $current_user;

                $value = $this->get('roles_to_upload');

                if (!is_array($value)) {
                    $allowed = true;
                }

                if (is_array($current_user->roles)) {
                    $matched = array_intersect($current_user->roles, $value);
                    $allowed = !empty($matched);
                }
            }
        }

        return apply_filters('gdbbx_attchaments_is_user_allowed', $allowed);
    }

    public function is_no_limit() {
        $allowed = false;

        if (is_user_logged_in()) {
            $value = $this->get('roles_no_limit');

            if (is_array($value)) {
                global $current_user;

                if (is_array($current_user->roles)) {
                    $matched = array_intersect($current_user->roles, $value);
                    $allowed = !empty($matched);
                }
            }
        }

        return apply_filters('gdbbx_attchaments_is_user_with_no_limit', $allowed);
    }

    public function max_server_allowed() {
        return floor(d4p_php_ini_size_value('upload_max_filesize') / KB_IN_BYTES);
    }
}

global $_gdbbx_attachments;
$_gdbbx_attachments = new gdbbx_mod_attachments();

/** @return gdbbx_mod_attachments */
function gdbbx_attachments() {
    global $_gdbbx_attachments;
    return $_gdbbx_attachments;
}
