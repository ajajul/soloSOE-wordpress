<?php

namespace Dev4Press\Plugin\GDBBX\Tasks;

if (!defined('ABSPATH')) {
    exit;
}

class Cleanup {
    public function __construct() {
    }

    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Cleanup();
        }

        return $instance;
    }

    public function count_thanks_for_missing_posts() {
        $sql = "SELECT COUNT(*) FROM ".gdbbx_db()->actions." WHERE `action` = 'thanks' AND post_id NOT IN (SELECT ID FROM ".gdbbx_db()->wpdb()->posts.")";

        return gdbbx_db()->get_var($sql);
    }

    public function delete_thanks_for_missing_posts() {
        $sql = "DELETE FROM ".gdbbx_db()->actions." WHERE `action` = 'thanks' AND post_id NOT IN (SELECT ID FROM ".gdbbx_db()->wpdb()->posts.")";

        gdbbx_db()->query($sql);
        return gdbbx_db()->rows_affected();
    }

    public function delete_author_ips_from_postmeta() {
        $sql = "DELETE FROM ".gdbbx_db()->wpdb()->postmeta." WHERE `meta_key` = '_bbp_author_ip'";

        gdbbx_db()->query($sql);
        return gdbbx_db()->rows_affected();
    }

    public function clear_user_favorites($user_id) {
        $ids = bbp_get_user_favorites_topic_ids($user_id);

        foreach ($ids as $id) {
            bbp_remove_user_favorite($user_id, $id);
        }
    }

    public function clear_user_topic_subscriptions($user_id) {
        $ids = bbp_get_user_subscribed_topic_ids($user_id);

        foreach ($ids as $id) {
            bbp_remove_user_subscription($user_id, $id);
        }
    }

    public function clear_user_forum_subscriptions($user_id) {
        $ids = bbp_get_user_subscribed_forum_ids($user_id);

        foreach ($ids as $id) {
            bbp_remove_user_subscription($user_id, $id);
        }
    }
}
