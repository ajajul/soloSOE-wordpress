<?php

if (!defined('ABSPATH')) {
    exit;
}

function gdbbx_get_forum_from_wp_query() {
    global $wp_query;

    $forum_id = 0;

    if (is_404() && isset($wp_query->query['name'])) {
        $post = get_page_by_path($wp_query->query['name'], OBJECT, bbp_get_forum_post_type());

        if ($post) {
            $forum_id = $post->ID;
        }
    } else {
        switch ($wp_query->get('post_type')) {
            case bbp_get_forum_post_type() :
                $forum_id = bbp_get_forum_id($wp_query->post->ID);
                break;
            case bbp_get_topic_post_type() :
                $forum_id = bbp_get_topic_forum_id($wp_query->post->ID);
                break;
            case bbp_get_reply_post_type() :
                $forum_id = bbp_get_reply_forum_id($wp_query->post->ID);
                break;
        }
    }

    return $forum_id;
}
