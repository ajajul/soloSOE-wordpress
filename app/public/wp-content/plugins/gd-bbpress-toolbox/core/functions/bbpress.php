<?php

if (!defined('ABSPATH')) {
    exit;
}

function gdbbx_has_bbpress() {
    if (function_exists('bbp_get_version')) {
        $version = bbp_get_version();
        $version = intval(substr(str_replace('.', '', $version), 0, 2));

        return $version > 24;
    } else {
        return false;
    }
}

function gdbbx_bbpress_version($ret = 'code') {
    if (!gdbbx_has_bbpress()) {
        return null;
    }

    $version = bbp_get_version();

    if (isset($version)) {
        if ($ret == 'code') {
            return substr(str_replace('.', '', $version), 0, 2);
        } else {
            return $version;
        }
    }

    return null;
}

function gdbbx_is_bbpress() {
    $is = gdbbx_has_bbpress() ? is_bbpress() : false;

    return apply_filters('gdbbx_is_bbpress', $is);
}

function bbp_form_reply_title() {
    echo bbp_get_form_reply_title();
}

function bbp_wp_editor_status($status = true) {
    update_option('_bbp_use_wp_editor', $status);
}

function bbp_get_form_reply_title() {
    $reply_title = '';

    if (bbp_is_post_request() && isset($_POST['bbp_reply_title'])) {
        $reply_title = $_POST['bbp_reply_title'];
    } else if (bbp_is_reply_edit()) {
        $reply_title = bbp_get_global_post_field('post_title', 'raw');
    }

    return apply_filters('bbp_get_form_reply_title', esc_attr($reply_title));
}

function gdbbx_has_buddypress() {
    if (d4p_is_plugin_active('buddypress/bp-loader.php') && function_exists('bp_get_version')) {
        $version = bp_get_version();
        $version = intval(substr(str_replace('.', '', $version), 0, 2));

        return $version > 26;
    } else {
        return false;
    }
}

function gdbbx_get_all_topic_statuses() {
    return array(
        bbp_get_private_status_id(),
        bbp_get_public_status_id(),
        bbp_get_hidden_status_id(),
        bbp_get_closed_status_id()
    );
}

function gdbbx_get_last_active_time($topic_id) {
    $last_active = get_post_meta($topic_id, '_bbp_last_active_time', true);

    if (empty($last_active)) {
        $reply_id = bbp_get_topic_last_reply_id($topic_id);

        if (!empty($reply_id)) {
            $last_active = get_post_field('post_date', $reply_id);
        } else {
            $last_active = get_post_field('post_date', $topic_id);
        }
    }

    return $last_active;
}

function gdbbx_get_forum_id() {
    $forum_id = bbp_get_forum_id();

    if ($forum_id == 0) {
        if (bbp_is_topic_edit()) {
            $topic_id = bbp_get_topic_id();
            $forum_id = bbp_get_topic_forum_id($topic_id);
        } else if (bbp_is_reply_edit()) {
            $reply_id = bbp_get_reply_id();
            $forum_id = bbp_get_reply_forum_id($reply_id);
        }
    }

    return $forum_id;
}