<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_core_db extends d4p_wpdb_core {
    public $db_site = array();

    public $_prefix = 'gdbbx';
    public $_tables = array(
        'actions', 
        'actionmeta',
        'attachments',
        'online',
        'tracker'
    );
    public $_metas = array(
        'action' => 'action_id'
    );

    /** @global wpdb $wpdb */
    public function init() {
        global $wpdb;

        $plugin = new stdClass();
        $this->db = new stdClass();
        $this->db_site = array();

        foreach ($this->_tables as $name) {
            $prefix = in_array($name, $this->_network_tables) ? $wpdb->base_prefix : $wpdb->prefix;

            $wpdb_name = $this->_prefix.'_'.$name;
            $real_name = $prefix.$wpdb_name;

            $plugin->$name = $real_name;
            $this->db->$name = $real_name;

            $wpdb->$wpdb_name = $real_name;

            if (!in_array($name, $this->_network_tables)) {
                $this->db_site[] = $real_name;
            }
        }

        $wpdb->{$this->_prefix} = $plugin;

        if (!empty($this->_prefix) && !empty($this->_metas)) {
            foreach ($this->_metas as $key => $id) {
                $this->_meta_translate[$this->_prefix.'_'.$key.'_id'] = $id;
            }

            add_filter('sanitize_key', array($this, 'sanitize_meta'));
        }
    }

    public function count_attachments_per_type() {
        $sql = "SELECT p.post_type, COUNT(*) AS attachments FROM ".$this->attachments." a INNER JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id
                WHERE p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."') GROUP BY p.post_type";
        $raw = $this->get_results($sql);

        $results = array(
            bbp_get_topic_post_type() => 0,
            bbp_get_reply_post_type() => 0
        );

        foreach ($raw as $row) {
            $results[$row->post_type] = $row->attachments;
        }

        return $results;
    }

    public function count_unique_attachments() {
        $sql = "SELECT COUNT(DISTINCT attachment_id) AS attachments FROM ".$this->attachments;
        return $this->get_var($sql);
    }

    public function assign_attachment($post_id, $attachment_id) {
        $this->insert($this->attachments, array('post_id' => $post_id, 'attachment_id' => $attachment_id));
    }

    public function is_assign_attachment_possible($post_id, $attachment_id) {
        $sql = $this->prepare("SELECT COUNT(*) FROM ".$this->attachments." WHERE post_id = %d AND attachment_id = %d", $post_id, $attachment_id);
        $raw = $this->get_var($sql);

        return absint($raw) == 0;
    }

    public function remove_attachment_assignment($post_id, $attachment_id = 0) {
        if ($attachment_id == 0) {
            $sql = $this->prepare("DELETE FROM ".$this->attachments." WHERE post_id = %d", $post_id);
        } else {
            $sql = $this->prepare("DELETE FROM ".$this->attachments." WHERE post_id = %d AND attachment_id = %d", $post_id, $attachment_id);
        }

        $this->query($sql);
    }

    public function delete_attachment($post_id, $attachment_id) {
        $this->remove_attachment_assignment($post_id, $attachment_id);

        wp_delete_attachment($attachment_id);
    }

    public function detach_attachment($post_id, $attachment_id) {
        $this->remove_attachment_assignment($post_id, $attachment_id);

        $attachment = get_post($attachment_id);
        if ($attachment->post_parent == $post_id) {
            $this->update($this->wpdb()->posts, array('post_parent' => 0), array('ID' => $attachment_id));
        }
    }

    public function get_attachment_id_from_name($name) {
        $query = $this->wpdb()->prepare(
            "SELECT post_id FROM ".$this->wpdb()->postmeta." WHERE meta_key = '_bbp_attachment_name' AND meta_value = '%s';",
            $name);

        $result = $this->get_var($query);

        return $result ? absint($result) : 0;
    }

    public function get_attachment_id_from_name_alt($name) {
        $query = $this->wpdb()->prepare(
            "SELECT post_id FROM ".$this->wpdb()->postmeta." WHERE meta_key = '_wp_attached_file' AND meta_value LIKE '%s';",
            '%'.$name);

        $result = $this->get_var($query);

        return $result ? absint($result) : 0;
    }

    public function get_topic_thread_attachments_ids($topic_id) {
        $topic_id = absint($topic_id);

        $sql = "SELECT attachment_id as ID FROM ".$this->attachments." WHERE post_id IN (".$this->_reply_inner_query($topic_id).") OR post_id = ".$topic_id;
        $raw = $this->get_results($sql);

        $attachments = wp_list_pluck($raw, 'ID');

        if (!empty($attachments)) {
            $attachments = array_map('absint', $attachments);
            $attachments = array_filter($attachments);

            return $attachments;
        }

        return array();
    }

    public function update_topic_attachments_count($topic_id) {
        $topic_id = absint($topic_id);

        $sql = "SELECT COUNT(*) FROM ".$this->attachments." WHERE post_id IN (".$this->_reply_inner_query($topic_id).") OR post_id = ".$topic_id;

        $count = absint($this->get_var($sql));

        update_post_meta($topic_id, '_bbp_attachments_count', $count);

        return $count;
    }

    public function add_online_entry($entry) {
        $defaults = array(
            'user_type' => '',
            'user_key' => '',
            'user_role' => '',
            'content' => 'general',
            'forum_id' => 0,
            'topic_id' => 0,
            'profile_id' => 0,
            'topic_view' => ''
        );

        $entry = wp_parse_args($entry, $defaults);

        $sql = $this->prepare("SELECT id FROM ".$this->online." WHERE `user_type` = %s AND `user_key` = %s AND `user_role` = %s AND `content` = %s AND `forum_id` = %d AND `topic_id` = %d and `profile_id` = %d and `topic_view` = %s",
            $entry['user_type'], $entry['user_key'], $entry['user_role'], $entry['content'], $entry['forum_id'], $entry['topic_id'], $entry['profile_id'], $entry['topic_view']);

        $raw = $this->get_results($sql);

        if (empty($raw)) {
            $this->insert($this->online, $entry);

            return 'added';
        } else {
            $ids = wp_list_pluck($raw, 'id');
            $ids = array_map('absint', $ids);

            $update = "UPDATE ".$this->online." SET `logged` = CURRENT_TIMESTAMP() WHERE id IN (".join(', ', $ids).")";
            $this->query($update);

            return 'updated';
        }
    }

    public function clean_online_table($window) {
        $sql = $this->prepare("DELETE FROM ".$this->online." WHERE logged < SUBDATE(NOW(), INTERVAL %d SECOND)", $window);

        $this->query($sql);

        return $this->rows_affected();
    }

    public function count_online_overview() {
        $sql = "SELECT user_type, user_role, count(DISTINCT user_key) AS online FROM ".$this->online." GROUP BY user_type, user_role;";
        $raw = $this->get_results($sql);

        $out = array('users' => 0, 'guests' => 0, 'roles' => array());

        $roles = gdbbx_get_user_roles();
        foreach (array_keys($roles) as $role) {
            $out['roles'][$role] = 0;
        }

        foreach ($raw as $row) {
            $online = absint($row->online);

            if ($row->user_type == 'guest') {
                $out['guests'] = $online;
            } else {
                $out['users'] = $online;

                if (isset($out['roles'][$row->user_role])) {
                    $out['roles'][$row->user_role] = $online;
                }
            }
        }

        return $out;
    }

    public function get_online_users_list() {
        $sql = "SELECT DISTINCT user_role, user_key FROM ".$this->online." WHERE user_type = 'user'";
        $raw = $this->get_results($sql);

        $out = array();

        $roles = gdbbx_get_user_roles();
        foreach (array_keys($roles) as $role) {
            $out[$role] = array();
        }

        foreach ($raw as $row) {
            if (isset($out[$row->user_role])) {
                $user_id = absint($row->user_key);
                $out[$row->user_role][] = $user_id;

                gdbbx_cache()->set('user-is-online', $user_id, true);
            }
        }

        return $out;
    }

    public function get_user_favorites_topic_ids($user_id = 0) {
        $user_id = bbp_get_user_id($user_id);

        if ($user_id > 0) {
            if (gdbbx_bbpress_version() < 26) {
                $ids = get_user_option('_bbp_favorites', $user_id);
                $ids = array_filter(wp_parse_id_list($ids));

                return $ids;
            } else {
                return bbp_get_user_favorites_topic_ids($user_id);
            }
        }

        return array();
    }

    public function get_user_subscribed_topic_ids($user_id = 0) {
        $user_id = bbp_get_user_id($user_id);

        if ($user_id > 0) {
            if (gdbbx_bbpress_version() < 26) {
                $ids = get_user_option('_bbp_subscriptions', $user_id);
                $ids = array_filter(wp_parse_id_list($ids));

                return $ids;
            } else {
                return bbp_get_user_subscribed_topic_ids($user_id);
            }
        }

        return array();
    }

    public function get_user_subscription_favorites_counts($user_id) {
        $sql = "SELECT SUBSTR(m.meta_key, 6) as type, p.post_type, COUNT(*) AS counter FROM ".$this->wpdb()->postmeta." m INNER JOIN ".$this->wpdb()->posts." p ON p.ID = m.post_id 
                WHERE m.meta_value = ".absint($user_id)." AND m.meta_key IN ('_bbp_subscription', '_bbp_favorite') AND post_type IN ('".bbp_get_forum_post_type()."', '".bbp_get_topic_post_type()."')
                GROUP BY m.meta_key, p.post_type";
        $raw = $this->get_results($sql);

        $results = array(
            'topic_subscriptions' => 0,
            'forum_subscriptions' => 0,
            'topic_favorites' => 0
        );

        foreach ($raw as $row) {
            if ($row->post_type == bbp_get_forum_post_type() && $row->type == 'subscription') {
                $results['forum_subscriptions'] = absint($row->counter);
            }

            if ($row->post_type == bbp_get_topic_post_type() && $row->type == 'subscription') {
                $results['topic_subscriptions'] = absint($row->counter);
            }

            if ($row->post_type == bbp_get_topic_post_type() && $row->type == 'favorite') {
                $results['topic_favorites'] = absint($row->counter);
            }
        }

        return $results;
    }

    public function get_topics_count_since($timestamp, $gmt = true) {
        $timestamp = $gmt ? gdbbx_plugin()->datetime()->timestamp_gmt_to_local($timestamp) : $timestamp;
        $from = date('Y-m-d H:i:s', $timestamp);

        $sql = "SELECT COUNT(*) FROM ".$this->wpdb()->posts."
                WHERE post_date > '".$from."' AND post_type = '".bbp_get_topic_post_type()."' 
                AND post_status IN ('publish', 'closed')";

        return $this->get_var($sql);
    }

    public function get_replies_count_since($timestamp, $gmt = true) {
        $timestamp = $gmt ? gdbbx_plugin()->datetime()->timestamp_gmt_to_local($timestamp) : $timestamp;
        $from = date('Y-m-d H:i:s', $timestamp);

        $sql = "SELECT COUNT(*) FROM ".$this->wpdb()->posts."
                WHERE post_date > '".$from."' AND post_type = '".bbp_get_reply_post_type()."' 
                AND post_status IN ('publish', 'closed')";

        return $this->get_var($sql);
    }

    public function track_topic_visit($user_id, $topic_id, $forum_id, $reply_id) {
        $previous = gdbbx_cache()->tracking_topic_last_visit($topic_id, $user_id);

        $latest = $this->datetime();

        if ($previous === false) {
            $this->insert($this->tracker, array(
                'user_id' => $user_id,
                'topic_id' => $topic_id,
                'forum_id' => $forum_id,
                'reply_id' => $reply_id,
                'latest' => $latest
            ));
        } else {
            $this->update($this->tracker, array(
                'forum_id' => $forum_id,
                'reply_id' => $reply_id,
                'latest' => $latest
            ), array(
                'user_id' => $user_id,
                'topic_id' => $topic_id
            ));
        }
    }

    public function get_topic_replies_ids($topic_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT ID FROM ".$this->wpdb()->posts." WHERE post_type = %s AND ID IN 
                (".$this->_reply_inner_query($topic_id).") AND post_status IN ('publish', 'closed')", 
                bbp_get_reply_post_type()
            );

        $raw = $this->get_results($sql);

        return wp_list_pluck($raw, 'ID');
    }

    public function get_topic_participants($topic_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT DISTINCT post_author FROM ".$this->wpdb()->posts." WHERE post_type = %s AND ID IN 
                (".$this->_reply_inner_query($topic_id).") AND post_status IN ('publish', 'closed')", 
                bbp_get_reply_post_type()
            );

        $raw = $this->get_results($sql);

        $users = array(absint(bbp_get_topic_author_id($topic_id)));

        foreach ($raw as $user) {
            $users[] = absint($user->post_author);
        }

        return array_unique(array_filter($users));
    }

    public function get_topic_last_visit($user_id, $topic_id) {
        $query = $this->wpdb()->prepare(
            "SELECT forum_id, reply_id, latest FROM ".$this->tracker." WHERE user_id = %s AND topic_id = %s",
                $user_id, $topic_id);

        $latest = $this->get_row($query);
        
        if (is_null($latest)) {
            return false;
        } else {
            $latest->latest = mysql2date('G', $latest->latest);
        }

        return $latest;
    }

    public function get_topic_next_reply_id($topic_id, $reply_id) {
        $query = $this->wpdb()->prepare(
            "SELECT post_id FROM ".$this->wpdb()->postmeta." WHERE meta_key = '_bbp_topic_id' 
            AND meta_value = %s AND post_id > %d ORDER BY post_id ASC LIMIT 0, 1",
                $topic_id, $reply_id
            );

        $next_reply_id = $this->get_var($query);

        return is_null($next_reply_id) ? false : intval($next_reply_id);
    }

    public function get_users_active_in_past($seconds = 86400, $limit = 0) {
        $min = intval($this->timestamp() - $seconds);

        $sql = "SELECT user_id, CAST(meta_value AS UNSIGNED) as last_active
                FROM ".$this->wpdb()->usermeta."
                WHERE meta_key = '".gdbbx_plugin()->user_meta_key_last_activity()."'
                AND CAST(meta_value AS UNSIGNED) > ".$min."
                ORDER BY last_active DESC";

        if ($limit > 0) {
            $sql.= " LIMIT 0, ".absint($limit);
        }

        $raw = $this->get_results($sql);

        $users = array();

        foreach ($raw as $user) {
            $users[$user->user_id] = $user->last_active;
        }

        return $users;
    }

    public function get_topics_with_user_reply($user_id, $offset = 0, $limit = 4096) {
        $sql = $this->wpdb()->prepare("SELECT DISTINCT CAST(m.meta_value AS UNSIGNED) as topic
                FROM ".$this->wpdb()->posts." p INNER JOIN ".$this->wpdb()->postmeta." m 
                ON m.post_id = p.ID AND m.meta_key = '_bbp_topic_id'
                WHERE p.post_type = '".bbp_get_reply_post_type()."' AND p.post_author = %d
                ORDER BY p.ID DESC LIMIT %d, %d", $user_id, $offset, $limit);
        $raw = $this->get_results($sql);

        return wp_list_pluck($raw, 'topic');
    }

    public function get_forum_children($forum_id) {
        $query = $this->wpdb()->prepare(
                "SELECT ID FROM ".$this->wpdb()->posts." WHERE post_parent = %d 
                AND post_type = %s AND post_status IN ('publish', 'private')", 
                $forum_id, bbp_get_forum_post_type()
            );
        $raw = $this->get_results($query);

        if (empty($raw)) {
            return array();
        } else {
            return wp_list_pluck($raw, 'ID');
        }
    }

    public function user_replied_to_topic($topic_id = 0, $user_id = 0) {
        if ($topic_id == 0) {
            $topic_id = bbp_get_topic_id();
        }

        if ($user_id == 0) {
            $user_id = bbp_get_current_user_id();
        }

        $sql = $this->wpdb()->prepare(
            "SELECT COUNT(*) FROM ".$this->wpdb()->posts." WHERE post_author = %d AND 
                ID IN (".$this->_reply_inner_query($topic_id).") AND post_type = %s", 
                $user_id, bbp_get_reply_post_type()
            );

        return $this->get_var($sql) > 0;
    }

    public function thanks_list_recent($limit = 3) {
        $sql = "SELECT a.user_id, a.post_id, p.post_author, p.post_type
                FROM ".$this->actions." a
                LEFT JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id AND p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."')
                WHERE a.`action` = 'thanks'
                ORDER BY a.action_id DESC
                LIMIT 0, ".$limit;
        return $this->get_results($sql);
    }

    public function thanks_statistics() {
        $statistics = array(
            'types' => array(
                bbp_get_topic_post_type() => 0,
                bbp_get_reply_post_type() => 0),
            'users' => array(
                'from' => 0, 
                'to' => 0)
        );

        $sql = "SELECT p.post_type, COUNT(*) AS thanks FROM ".$this->actions." a
                INNER JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id AND p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."')
                WHERE a.`action` = 'thanks' GROUP BY p.post_type";

        $raw = $this->get_results($sql);

        foreach ($raw as $r) {
            $statistics['types'][$r->post_type] = $r->thanks;
        }

        $sql = "SELECT count(distinct(a.user_id)) as thanks_from FROM ".$this->actions." a
                INNER JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id AND p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."')
                WHERE a.`action` = 'thanks'";
        $statistics['users']['from'] = $this->get_var($sql);

        $sql = "SELECT count(distinct(p.post_author)) as thanks_to FROM ".$this->actions." a
                INNER JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id AND p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."')
                WHERE a.`action` = 'thanks'";
        $statistics['users']['to'] = $this->get_var($sql);

        return $statistics;
    }

    public function thanks_item($thanks_id) {
        $sql = $this->wpdb()->prepare("SELECT * FROM ".$this->actions." WHERE `action_id` = %d", $thanks_id);

        return $this->get_row($sql);
    }

    public function thanks_add($post_id, $user_id) {
        $this->thanks_remove($post_id, $user_id);

        $this->insert($this->actions, array('user_id' => $user_id, 'post_id' => $post_id, 'logged' => $this->datetime(), 'action' => 'thanks'));

        return $this->get_insert_id();
    }

    public function thanks_remove($post_id, $user_id) {
        return $this->delete($this->actions, array('user_id' => $user_id, 'post_id' => $post_id, 'action' => 'thanks'));
    }

    public function thanks_given($post_id, $user_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT COUNT(*) FROM ".$this->actions." WHERE post_id = %d AND user_id = %d AND action = 'thanks'", 
                $post_id, $user_id
            );

        return $this->get_var($sql) > 0;
    }

    public function thanks_list($post_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT SQL_CALC_FOUND_ROWS user_id, logged FROM ".$this->actions." WHERE action = 'thanks' AND 
            post_id = %d ORDER BY logged DESC",
            $post_id
        );

        return $this->run($sql);
    }

    public function top_thanked_users($limit = 10) {
        $sql = $this->wpdb()->prepare(
                "SELECT u.ID, COUNT(*) AS thanks
                FROM ".$this->actions." a 
                INNER JOIN ".$this->wpdb()->posts." p ON a.post_id = p.ID
                INNER JOIN ".$this->wpdb()->users." u ON p.post_author = u.ID AND p.post_author > 0
                WHERE a.`action` = 'thanks'
                GROUP BY u.ID
                ORDER BY count(*) DESC, u.ID DESC
                LIMIT %d", $limit);

        $raw = $this->run($sql);

        if (empty($raw)) {
            return array();
        } else {
            return wp_list_pluck($raw, 'thanks', 'ID');
        }
    }

    public function count_all_thanks_given($user_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT COUNT(*) FROM ".$this->actions." WHERE action = 'thanks' AND user_id = %d", 
                $user_id
            );

        return $this->get_var($sql);
    }

    public function count_all_thanks_received($user_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT COUNT(*) FROM ".$this->wpdb()->posts." p INNER JOIN ".$this->actions." a ON 
            a.post_id = p.ID WHERE a.action = 'thanks' AND p.post_author = %d", 
                $user_id
            );

        return $this->get_var($sql);
    }

    public function bulk_thanks_list($posts) {
        if (empty($posts)) {
            return array();
        }

        $sql = "SELECT SQL_CALC_FOUND_ROWS post_id, user_id FROM ".$this->actions." WHERE action = 'thanks' AND 
            post_id IN (".join(',', (array)$posts).") ORDER BY post_id ASC, logged DESC";

        $raw = $this->run($sql);
        $results = array();

        foreach ($raw as $row) {
            if (!isset($results[$row->post_id])) {
                $results[$row->post_id] = array();
            }

            $results[$row->post_id][] = $row->user_id;
        }

        return $results;
    }

    public function bulk_thanks_given($posts, $user_id) {
        if (empty($posts) || empty($user_id)) {
            return array();
        }

        $sql = $this->wpdb()->prepare(
            "SELECT post_id FROM ".$this->actions." WHERE post_id IN (".join(', ', $posts).") AND 
             user_id = %d AND action = 'thanks'", 
                $user_id
            );

        return $this->get_results($sql);
    }

    public function bulk_count_all_thanks_given($users) {
        if (empty($users)) {
            return array();
        }

        $sql = "SELECT user_id, COUNT(*) as thanks FROM ".$this->actions." WHERE action = 'thanks' AND 
            user_id IN (".join(', ', (array)$users).") GROUP BY user_id";

        return $this->get_results($sql);
    }

    public function bulk_count_all_thanks_received($users) {
        if (empty($users)) {
            return array();
        }

        $sql = "SELECT p.post_author as user_id, COUNT(*) as thanks FROM ".$this->wpdb()->posts." p INNER JOIN ".$this->actions." a ON 
            a.post_id = p.ID WHERE a.action = 'thanks' AND p.post_author IN (".join(', ', (array)$users).") 
            GROUP BY p.post_author";

        return $this->get_results($sql);
    }

    public function bulk_users_online_status($users) {
        if (empty($users)) {
            return array();
        }

        $sql = "SELECT DISTINCT user_key FROM ".$this->online." WHERE user_type = 'user' AND user_key IN ('".join("', '", $users)."')";
        $raw = $this->get_results($sql);

        if (empty($raw)) {
            return array();
        }

        $list = wp_list_pluck($raw, 'user_key');
        $list = array_map('absint', $list);
        $list = array_filter($list);

        return $list;
    }

    public function bulk_content_online_status($content, $ids = array()) {
        switch ($content) {
            default:
            case 'forum':
                $column = 'forum_id';
                break;
            case 'topic':
                $column = 'topic_id';
                break;
            case 'view':
                $column = 'topic_view';
                $ids = preg_filter('/^/', "'", $ids);
                $ids = preg_filter('/$/', "'", $ids);
                break;
            case 'profile':
                $column = 'profile_id';
                break;
        }

        $sql = "SELECT ".$column." as id, user_type, user_role, count(DISTINCT user_key) AS online FROM ".$this->online;

        if (!empty($column)) {
            $sql.= " WHERE ".$column." IN (".join(", ", $ids).")";
        }

        $sql.= " GROUP BY ".$column.", user_type, user_role";

        $raw = $this->get_results($sql);

        $out = array();

        $items = array();
        foreach ($raw as $row) {
            if (!isset($items[$row->id])) {
                $items[$row->id] = array();
            }

            $items[$row->id][] = $row;
        }

        foreach ($items as $id => $raw) {
            $item = array('users' => 0, 'guests' => 0, 'roles' => array());

            $roles = gdbbx_get_user_roles();
            foreach (array_keys($roles) as $role) {
                $item['roles'][$role] = 0;
            }

            foreach ($raw as $row) {
                $online = absint($row->online);

                if ($row->user_type == 'guest') {
                    $item['guests'] = $online;
                } else {
                    $item['users'] = $online;

                    if (isset($item['roles'][$row->user_role])) {
                        $item['roles'][$row->user_role] = $online;
                    }
                }
            }

            $out[$id] = $item;
        }

        return $out;
    }

    public function bulk_count_all_topics_replies($users) {
        if (empty($users)) {
            return array();
        }

        $sql = "SELECT post_author AS user_id, post_type, COUNT(*) AS posts FROM ".$this->wpdb()->posts."  
            WHERE post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."') 
            AND post_status IN ('publish', 'private', 'closed') 
            AND post_author IN (".join(', ', (array)$users).") GROUP BY post_author, post_type";

        $raw = $this->get_results($sql);
        $results = array();

        foreach ($raw as $row) {
            if (!isset($results[$row->user_id])) {
                $results[$row->user_id] = array(
                    bbp_get_topic_post_type() => 0,
                    bbp_get_reply_post_type() => 0
                );
            }

            $results[$row->user_id][$row->post_type] = $row->posts;
        }

        return $results;
    }

    public function bulk_get_attachments_errors_ids($posts) {
        if (empty($posts)) {
            return array();
        }

        $sql = "SELECT post_id FROM ".$this->wpdb()->postmeta." WHERE post_id IN (".join(',', (array)$posts).") AND meta_key = '_bbp_attachment_upload_error'";
        $raw = $this->run($sql);

        return wp_list_pluck($raw, 'post_id');
    }

    public function bulk_get_attachments_ids($posts) {
        if (empty($posts)) {
            return array();
        }

        $sql = "SELECT * FROM ".$this->attachments." WHERE post_id IN (".join(',', (array)$posts).")";

        $raw = $this->run($sql);
        $results = array();

        foreach ($raw as $row) {
            if (!isset($results[$row->post_id])) {
                $results[$row->post_id] = array();
            }

            $results[$row->post_id][] = $row->attachment_id;
        }

        return $results;
    }

    public function bulk_count_topic_attachments($posts) {
        if (empty($posts)) {
            return array();
        }

        $sql = "SELECT post_id, CAST(meta_value AS UNSIGNED) AS attachments FROM ".$this->wpdb()->postmeta." WHERE 
                meta_key = '_bbp_attachments_count' AND post_id IN (".join(',', (array)$posts).")";

        $raw = $this->run($sql);
        $results = array();

        foreach ($raw as $row) {
            $results[$row->post_id] = $row->attachments;
        }

        return $results;
    }

    public function bulk_user_replied_to_topics($topics, $user_id) {
        if (empty($topics) || empty($user_id)) {
            return array();
        }

        $sql = $this->wpdb()->prepare(
            "SELECT DISTINCT CAST(m.meta_value AS UNSIGNED) AS topic_id FROM ".$this->wpdb()->postmeta." m 
             INNER JOIN ".$this->wpdb()->posts." p ON p.ID = m.post_id 
             WHERE m.meta_key = '_bbp_topic_id' AND m.meta_value IN (".join(', ', (array)$topics).") AND 
             m.post_id != m.meta_value AND p.post_author = %d", 
                $user_id
            );

        return wp_list_pluck($this->get_results($sql), 'topic_id');
    }

    public function bulk_list_topic_replies($topics) {
        if (empty($topics)) {
            return array();
        }

        $sql = "SELECT CAST(meta_value as UNSIGNED) as reply FROM ".$this->wpdb()->postmeta." WHERE 
                meta_value != '0' AND meta_key = '_bbp_last_reply_id' AND post_id IN (".join(', ', (array)$topics).")";
        $raw = $this->run($sql);

        return wp_list_pluck($raw, 'reply');
    }

    public function bulk_list_topics_last_visit($topics, $user_id) {
        if (empty($topics) || empty($user_id)) {
            return array();
        }

        $query = $this->wpdb()->prepare(
            "SELECT forum_id, topic_id, reply_id, latest FROM ".$this->tracker." WHERE 
             user_id = %s AND topic_id IN (".join(',', (array)$topics).")",
                $user_id);

        $raw = $this->run($query);
        $results = array();

        foreach ($raw as $row) {
            $row->latest = mysql2date('G', $row->latest);
            $results[$row->topic_id] = $row;
        }

        return $results;
    }

    public function bulk_find_forum_children_ids() {
        $query = $this->wpdb()->prepare(
            "SELECT ID, post_parent FROM ".$this->wpdb()->posts." WHERE post_type = %s AND post_status IN ('publish', 'private')",
            bbp_get_forum_post_type()
        );

        $raw = d4p_transient_sql_query($query, gdbbx_plugin()->get_transient_key('forums_children_ids'), 'results');

        return wp_list_pluck($raw, 'post_parent', 'ID');
    }

    public function bulk_list_private_posts($posts) {
        if (empty($posts)) {
            return array();
        }

        $sql = "SELECT post_id FROM ".$this->wpdb()->postmeta." WHERE meta_value = '1' 
                AND meta_key IN ('_bbp_topic_is_private', '_bbp_reply_is_private') AND post_id IN (".join(', ', (array)$posts).")";
        $raw = $this->run($sql);

        return wp_list_pluck($raw, 'post_id');
    }

    public function report_list_recent($limit = 3) {
        $sql = "SELECT a.user_id, a.post_id, p.post_author, p.post_type, r.meta_value as report
                FROM ".$this->actions." a
                LEFT JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id AND p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."')
                INNER JOIN ".$this->actionmeta." m ON m.action_id = a.action_id AND m.meta_key = 'status'
                INNER JOIN ".$this->actionmeta." r ON r.action_id = a.action_id AND r.meta_key = 'content'
                WHERE a.`action` = 'report' AND m.meta_value = 'waiting'
                ORDER BY a.action_id DESC
                LIMIT 0, ".$limit;
        return $this->get_results($sql);
    }

    public function report_statistics() {
        $sql = "SELECT r.post_type, r.report, COUNT(*) AS reported
                FROM (
                    SELECT t.meta_value AS post_type, IF (p.ID IS NULL, 'closed', m.meta_value) AS report
                    FROM ".$this->actions." a
                    LEFT JOIN ".$this->wpdb()->posts." p ON p.ID = a.post_id 
                         AND p.post_type IN ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."')
                    INNER JOIN ".$this->actionmeta." m ON m.action_id = a.action_id AND m.meta_key = 'status'
                    INNER JOIN ".$this->actionmeta." t ON t.action_id = a.action_id AND t.meta_key = 'type'
                    WHERE a.action = 'report') r
                GROUP BY r.post_type, r.report";
        $raw = $this->get_results($sql);

        $list = array();

        foreach ($raw as $r) {
            if (!isset($list[$r->post_type])) {
                $list[$r->post_type] = array('total' => 0, 'active' => 0);
            }

            $list[$r->post_type]['total']+= $r->reported;

            if ($r->report == 'waiting') {
                $list[$r->post_type]['active']+= $r->reported;
            }
        }

        return $list;
    }

    public function report_given($post_id, $user_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT COUNT(*) FROM ".$this->actions." a INNER JOIN ".$this->actionmeta." m ON m.action_id = a.action_id
            WHERE a.post_id = %d AND a.user_id = %d AND a.action = 'report' AND m.meta_key = 'status' AND m.meta_value = 'waiting'", 
                $post_id, $user_id
            );

        return $this->get_var($sql) > 0;
    }

    public function report_add($post_id, $user_id, $content = '') {
        $this->insert($this->actions, array('user_id' => $user_id, 'post_id' => $post_id, 'logged' => $this->datetime(), 'action' => 'report'));

        $action_id = $this->get_insert_id();
        $type = bbp_is_reply($post_id) ? bbp_get_reply_post_type() : bbp_get_topic_post_type();

        $this->insert($this->actionmeta, array('action_id' => $action_id, 'meta_key' => 'content', 'meta_value' => $content));
        $this->insert($this->actionmeta, array('action_id' => $action_id, 'meta_key' => 'type', 'meta_value' => $type));
        $this->insert($this->actionmeta, array('action_id' => $action_id, 'meta_key' => 'status', 'meta_value' => 'waiting'));
    }

    public function report_closed($id, $user_id) {
        $sql = "SELECT post_id FROM ".$this->actions." WHERE action_id = ".$id;
        $post_id = absint($this->get_var($sql));

        if ($post_id > 0) {
            $this->insert($this->actions, array('user_id' => $user_id, 'post_id' => $post_id, 'logged' => $this->datetime(), 'action' => 'report-closed', 'reference_id' => $id));
        }
    }

    public function report_status($report_id, $status) {
        $this->update($this->actionmeta, array('meta_value' => $status), array('action_id' => $report_id, 'meta_key' => 'status'));
    }

    public function reported($post_id) {
        $sql = $this->wpdb()->prepare(
            "SELECT user_id FROM ".$this->actions." a INNER JOIN ".$this->actionmeta." m ON m.action_id = a.action_id
            WHERE a.post_id = %d AND a.action = 'report' AND m.meta_key = 'status' AND m.meta_value = 'waiting'", 
                $post_id
            );

        return wp_list_pluck($this->run($sql), 'user_id');
    }

    public function bulk_reported($posts) {
        $sql = "SELECT a.post_id, a.user_id FROM ".$this->actions." a INNER JOIN ".$this->actionmeta." m ON m.action_id = a.action_id
            WHERE a.post_id IN (".join(',', (array)$posts).") AND a.action = 'report' AND m.meta_key = 'status' AND m.meta_value = 'waiting'";

        $raw = $this->run($sql);
        $results = array();

        foreach ($raw as $row) {
            if (!isset($results[$row->post_id])) {
                $results[$row->post_id] = array();
            }

            $results[$row->post_id][] = $row->user_id;
        }

        return $results;
    }

    public function get_id_from_slug($slug, $post_type) {
        $sql = "SELECT ID FROM ".$this->wpdb()->posts." WHERE post_name = '$slug' AND post_type = '$post_type'";

        $pages = gdbbx_db()->get_results($sql);

        if (count($pages) == 1) {
            return $pages[0]->ID;
        }

        return null;
    }

    public function close_old_topics($days) {
        $sql = "UPDATE ".$this->wpdb()->posts." SET post_status = '".bbp_get_closed_status_id()."'
                WHERE post_type = '".bbp_get_topic_post_type()."'
                AND post_status = '".bbp_get_public_status_id()."' AND post_date < DATE_SUB(curdate(), interval ".intval($days)." day)";

        return $this->query($sql);
    }

    public function close_inactive_topics($days) {
        $sql = "UPDATE ".$this->wpdb()->posts." p INNER JOIN ".$this->wpdb()->postmeta." m ON m.post_id = p.ID
                SET p.post_status = '".bbp_get_closed_status_id()."'
                WHERE p.post_type = '".bbp_get_topic_post_type()."'
                AND p.post_status = '".bbp_get_public_status_id()."' 
                AND m.meta_key = '_bbp_last_active_time' 
                AND STR_TO_DATE(m.meta_value, '%Y-%m-%d %T') < DATE_SUB(curdate(), interval ".intval($days)." day)";

        return $this->query($sql);
    }

    public function bulk_count_private_replies_in_topic($topics) {
        $sql = "SELECT i.meta_value AS topic, COUNT(*) AS replies
                FROM ".$this->wpdb()->postmeta." p 
                INNER JOIN ".$this->wpdb()->postmeta." i ON i.post_id = p.post_id AND i.meta_value IN (".join(',', (array)$topics).") 
                WHERE p.meta_value = '1' 
                AND p.meta_key = '_bbp_reply_is_private'
                AND i.meta_key = '_bbp_topic_id'
                GROUP BY i.meta_value";

        $raw = $this->get_results($sql);

        if (!empty($raw)) {
            return wp_list_pluck($raw, 'replies', 'topic');
        }

        return array();
    }

    public function count_private_replies_in_topic($topic_id) {
        $sql = "SELECT COUNT(*)
                FROM ".$this->wpdb()->postmeta." p 
                INNER JOIN ".$this->wpdb()->postmeta." i ON i.post_id = p.post_id AND i.meta_value = '".absint($topic_id)."'
                WHERE p.meta_value = '1' 
                AND p.meta_key = '_bbp_reply_is_private'
                AND i.meta_key = '_bbp_topic_id'";

        return $this->get_var($sql);
    }

    public function count_recent_posts($seconds, $until = null, $gmt = false) {
        $post_types = array(
            bbp_get_topic_post_type(),
            bbp_get_reply_post_type()
        );

        $post_statuses = array(
            bbp_get_public_status_id(),
            bbp_get_private_status_id(),
            bbp_get_closed_status_id()
        );

        $until = is_null($until) ? $this->datetime($gmt) : $until;
        $column = $gmt ? 'post_date_gmt' : 'post_date';

        $sql = "SELECT post_type, count(*) AS posts FROM ".$this->wpdb()->posts." WHERE post_type IN ('".join("', '", $post_types)."') AND post_status IN ('".join("', '", $post_statuses)."') AND ".$column." > DATE_SUB(%s, INTERVAL %d SECOND) AND ".$column." <= %s GROUP BY post_type";
        $sql = $this->prepare($sql, $until, $seconds, $until);

        $raw = $this->get_results($sql);
        $out = array();

        foreach ($raw as $r) {
            $out[$r->post_type] = absint($r->posts);
        }

        return $out;
    }

    public function tracking_forums_user_tracking($user_id) {
        $sql = "SELECT t.forum_id, t.topic_id, t.reply_id, t.latest
                FROM ".$this->tracker." t INNER JOIN (
                SELECT forum_id, MAX(latest) AS latest FROM ".$this->tracker." 
                WHERE user_id = ".absint($user_id)." GROUP BY forum_id) r 
                ON r.forum_id = t.forum_id AND r.latest = t.latest
                ORDER BY t.forum_id";

        $raw = $this->get_results($sql, ARRAY_A);

        $list = array();

        foreach ($raw as $row) {
            $row['latest'] = strtotime($row['latest']);
            $list[$row['forum_id']] = $row;
        }

        return $list;
    }

    public function tracking_forums_activity() {
        $post_statuses = array(
            bbp_get_public_status_id(),
            bbp_get_private_status_id(),
            bbp_get_hidden_status_id()
        );

        $sql = "SELECT p.ID AS `id`, m.meta_value AS `active`, l.meta_value AS `posted`
                FROM ".$this->wpdb()->posts." p 
                LEFT JOIN ".$this->wpdb()->postmeta." m ON m.post_id = p.ID AND m.meta_key = '_bbp_last_active_time'
                LEFT JOIN ".$this->wpdb()->postmeta." l ON l.post_id = p.ID AND l.meta_key = '_bbp_last_post_time'
                WHERE p.post_type = '".bbp_get_forum_post_type()."' AND p.post_status IN ('".join("', '", $post_statuses)."') 
                ORDER BY p.ID ASC";
        $raw = $this->get_results($sql);

        $list = array();

        foreach ($raw as $row) {
            $list[$row->id] = array(
                'active' => $row->active ? gdbbx_plugin()->datetime()->timestamp_local_to_gmt(strtotime($row->active)) : 0,
                'posted' => $row->posted ? gdbbx_plugin()->datetime()->timestamp_local_to_gmt(strtotime($row->posted)) : 0
            );
        }

        return $list;
    }

    private function _reply_inner_query($topic_id) {
        return $this->wpdb()->prepare(
            "SELECT ID FROM ".$this->wpdb()->posts." WHERE post_parent = %d and post_type = %s",
            $topic_id,
            bbp_get_reply_post_type());
    }
}
