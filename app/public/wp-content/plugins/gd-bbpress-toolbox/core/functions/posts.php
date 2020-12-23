<?php

if (!defined('ABSPATH')) {
    exit;
}

function gdbbx_filter_pre_fetch_posts($list) {
    $items = array_merge(wp_list_pluck($list, 'topic'), wp_list_pluck($list, 'id'), wp_list_pluck($list, 'forum'));
    $items = array_map('absint', $items);
    $items = array_unique($items);

    sort($items);

    d4p_posts_cache_by_ids($items);
    update_meta_cache('post', $items);
}

function gdbbx_filter_update_freshness($list) {
    gdbbx_filter_pre_fetch_posts($list);

    foreach ($list as &$item) {
        $item['activity'] = bbp_get_topic_last_active_time($item['topic']);
    }

    return $list;
}

function gdbbx_filter_user_access_rights($list, $limit) {
    gdbbx_filter_pre_fetch_posts($list);

    $results = array();

    $user_id = bbp_get_current_user_id();

    foreach ($list as $item) {
        $include = true;
        $forum_id = $item['forum'];

        if (bbp_is_forum_private($forum_id)) {
            if (!current_user_can('read_private_forums')) {
                $include = false;
            }
        } else if (bbp_is_forum_hidden($forum_id)) {
            if (!current_user_can('read_hidden_forums')) {
                $include = false;
            }
        }

        if ($include) {
            if ($item['type'] == 'topic') {
                if (!gdbbx_is_user_allowed_to_topic($item['id'], $user_id)) {
                    $include = false;
                }
            } else if ($item['type'] == 'reply') {
                if (!gdbbx_is_user_allowed_to_reply($item['id'], $user_id)) {
                    $include = false;
                }
            }
        }

        if ($include) {
            $results[] = $item;
        }

        if (count($results) == $limit) {
            break;
        }
    }

    return $results;
}

function gdbbx_get_new_posts_replies($atts = array()) {
    $defaults = array(
        'timestamp' => 0, 'offset' => 0, 'limit' => 1000, 'access_check' => true,
        'include_forums' => array(), 'exclude_forums' => array(),
        'post_status' => array(bbp_get_public_status_id(), bbp_get_closed_status_id())
    );

    $args = wp_parse_args($atts, $defaults);

    $sql = "SELECT p.ID, p.post_type, p.post_date as post_date, p.post_author, 
            CAST(t.meta_value as UNSIGNED) as topic, CAST(m.meta_value as UNSIGNED) as forum
            FROM ".gdbbx_db()->wpdb()->posts." p 
            INNER JOIN ".gdbbx_db()->wpdb()->postmeta." m ON p.ID = m.post_id AND m.meta_key = '_bbp_forum_id'
            INNER JOIN ".gdbbx_db()->wpdb()->postmeta." t ON p.ID = t.post_id AND t.meta_key = '_bbp_topic_id'
            WHERE p.post_type = '".bbp_get_reply_post_type()."'";

    if (!empty($args['post_status'])) {
        $sql .= " AND p.post_status IN ('".join("', '", $args['post_status'])."')";
    }

    if (!empty($args['include_forums'])) {
        $sql .= " AND CAST(m.meta_value as UNSIGNED) IN (".join(", ", $args['include_forums']).")";
    } else if (!empty($args['exclude_forums'])) {
        $sql .= " AND CAST(m.meta_value as UNSIGNED) NOT IN (".join(", ", $args['exclude_forums']).")";
    }

    if ($args['timestamp'] > 0) {
        $sql .= " AND p.post_date > '".date('Y-m-d H:i:s', $args['timestamp'])."'";
    }

    $sql .= " ORDER BY p.ID DESC LIMIT ".$args['offset'].", 1024";

    $raw = gdbbx_db()->get_results($sql);

    $list = array();

    foreach ($raw as $row) {
        $date = bbp_get_time_since(bbp_convert_date($row->post_date));

        $list[] = array(
            'type' => 'reply',
            'id' => $row->ID,
            'author' => $row->post_author,
            'parent' => $row->topic,
            'forum' => $row->forum,
            'activity' => $date,
            'topic' => $row->topic
        );
    }

    if ($args['access_check']) {
        $list = gdbbx_filter_user_access_rights($list, $args['limit']);
    }

    return array_slice($list, 0, $args['limit']);
}

function gdbbx_get_new_posts_topics($atts = array()) {
    $defaults = array(
        'timestamp' => 0, 'offset' => 0, 'limit' => 32, 'access_check' => true,
        'include_forums' => array(), 'exclude_forums' => array(),
        'post_status' => array(bbp_get_public_status_id(), bbp_get_closed_status_id())
    );

    $args = wp_parse_args($atts, $defaults);

    $sql = "SELECT p.ID, p.post_date, p.post_author, CAST(m.meta_value as UNSIGNED) as forum
            FROM ".gdbbx_db()->wpdb()->posts." p 
            INNER JOIN ".gdbbx_db()->wpdb()->postmeta." m ON p.ID = m.post_id AND m.meta_key = '_bbp_forum_id'
            WHERE p.post_type = '".bbp_get_topic_post_type()."'";

    if (!empty($args['post_status'])) {
        $sql .= " AND p.post_status IN ('".join("', '", $args['post_status'])."')";
    }

    if (!empty($args['include_forums'])) {
        $sql .= " AND CAST(m.meta_value as UNSIGNED) IN (".join(", ", $args['include_forums']).")";
    } else if (!empty($args['exclude_forums'])) {
        $sql .= " AND CAST(m.meta_value as UNSIGNED) NOT IN (".join(", ", $args['exclude_forums']).")";
    }

    if ($args['timestamp'] > 0) {
        $sql .= " AND p.post_date > '".date('Y-m-d H:i:s', $args['timestamp'])."'";
    }

    $sql .= " ORDER BY p.ID DESC LIMIT ".$args['offset'].", 1024";

    $raw = gdbbx_db()->get_results($sql);

    $list = array();

    foreach ($raw as $row) {
        $date = bbp_get_time_since(bbp_convert_date($row->post_date));

        $list[] = array(
            'type' => 'topic',
            'id' => $row->ID,
            'author' => $row->post_author,
            'parent' => 0,
            'forum' => $row->forum,
            'activity' => $date,
            'topic' => $row->ID
        );
    }

    if ($args['access_check']) {
        $list = gdbbx_filter_user_access_rights($list, $args['limit']);
    }

    return array_slice($list, 0, $args['limit']);
}

function gdbbx_get_new_posts($atts = array()) {
    $defaults = array(
        'timestamp' => 0, 'offset' => 0, 'limit' => 32, 'access_check' => true,
        'include_forums' => array(), 'exclude_forums' => array(),
        'post_status' => array(bbp_get_public_status_id(), bbp_get_closed_status_id())
    );

    $args = wp_parse_args($atts, $defaults);

    $post_types = array(bbp_get_topic_post_type(), bbp_get_reply_post_type());

    $topics = array();
    $list = array();

    $sql = "SELECT p.ID, p.post_type, p.post_author, 
            CAST(t.meta_value as UNSIGNED) as topic, CAST(m.meta_value as UNSIGNED) as forum
            FROM ".gdbbx_db()->wpdb()->posts." p 
            INNER JOIN ".gdbbx_db()->wpdb()->postmeta." m ON p.ID = m.post_id AND m.meta_key = '_bbp_forum_id'
            INNER JOIN ".gdbbx_db()->wpdb()->postmeta." t ON p.ID = t.post_id AND t.meta_key = '_bbp_topic_id'
            WHERE p.post_type in ('".join("', '", $post_types)."')";

    if (!empty($args['post_status'])) {
        $sql .= " AND p.post_status IN ('".join("', '", $args['post_status'])."')";
    }

    if (!empty($args['include_forums'])) {
        $sql .= " AND CAST(m.meta_value as UNSIGNED) IN (".join(", ", $args['include_forums']).")";
    } else if (!empty($args['exclude_forums'])) {
        $sql .= " AND CAST(m.meta_value as UNSIGNED) NOT IN (".join(", ", $args['exclude_forums']).")";
    }

    if ($args['timestamp'] > 0) {
        $sql .= " AND p.post_date > '".date('Y-m-d H:i:s', $args['timestamp'])."'";
    }

    $sql .= " ORDER BY p.ID DESC LIMIT ".$args['offset'].", 1024";

    $raw = gdbbx_db()->get_results($sql);

    foreach ($raw as $row) {
        $topic = $row->post_type == bbp_get_topic_post_type() ? $row->ID : $row->topic;

        if (!in_array($topic, $topics)) {
            $topics[] = $topic;

            $list[] = array(
                'type' => $row->post_type,
                'id' => $row->ID,
                'author' => $row->post_author,
                'parent' => $row->topic,
                'forum' => $row->forum,
                'activity' => '',
                'topic' => $topic
            );
        }
    }

    if ($args['access_check']) {
        $list = gdbbx_filter_user_access_rights($list, $args['limit']);
    }

    $items = array_slice($list, 0, $args['limit']);

    return gdbbx_filter_update_freshness($items);
}
