<?php

if (!defined('ABSPATH')) {
    exit;
}

class gdbbx_grid_attachments extends d4p_grid {
    public $_sanitize_orderby_fields = array('p.ID', 'p.post_title', 'p.post_author', 'a.post_id');
    public $_checkbox_field = 'ID';
    public $_table_class_name = 'gdbbx-grid-attachments';

    public function __construct($args = array()) {
        parent::__construct(array(
            'singular' => 'attachment',
            'plural' => 'attachments',
            'ajax' => false
        ));
    }

    protected function extra_tablenav($which) {
        if ($which == 'top') {
            $attached = array(
                '' => __("For Topics And Replies", "gd-bbpress-toolbox"),
                bbp_get_topic_post_type() => __("For Topics Only", "gd-bbpress-toolbox"),
                bbp_get_reply_post_type() => __("For Replies Only", "gd-bbpress-toolbox")
            );

            $_sel_attached = isset($_GET['filter-attached']) && !empty($_GET['filter-attached']) ? d4p_sanitize_slug($_GET['filter-attached']) : '';

            echo '<div class="alignleft actions">';
            d4p_render_select($attached, array('selected' => $_sel_attached, 'name' => 'filter-attached'));
            submit_button(__("Filter", "gd-bbpress-toolbox"), 'button', false, false, array('id' => 'gdbbx-attchments-submit'));
            echo '</div>';
        }
    }

    public function rows_per_page() {
        $user = get_current_user_id();
        $per_page = get_user_meta($user, 'gdbbx_rows_per_page_attachments', true);

        if (empty($per_page) || $per_page < 1) {
            $per_page = 25;
        }

        return $per_page;
    }

    public function get_columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'id' => __("ID", "gd-bbpress-toolbox"),
            'thumbnail' => '',
            'file' => __("File", "gd-bbpress-toolbox"),
            'author' => __("Uploader", "gd-bbpress-toolbox"),
            'topic' => __("Topic / Reply", "gd-bbpress-toolbox"),
            'forum' => __("Forum", "gd-bbpress-toolbox"),
            'date' => __("Date", "gd-bbpress-toolbox")
        );
    }

    protected function get_sortable_columns() {
        return array(
            'id' => array('p.ID', false),
            'file' => array('p.post_title', false),
            'author' => array('p.post_author', false),
            'topic' => array('a.post_id', false)
        );
    }

    protected function get_bulk_actions() {
        return array(
            'delete' => __("Delete", "gd-bbpress-toolbox"),
            'detach' => __("Detach", "gd-bbpress-toolbox")
        );
    }

    protected function column_cb($item) {
        $id = $item->post_id.'-'.$item->ID;

        return sprintf('<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $id);
    }

    public function column_id($item) {
        return $item->ID;
    }

    public function column_file($item) {
        $actions = array(
            'delete' => sprintf('<a href="admin.php?page=gd-bbpress-toolbox-attachments&single-action=%s&gdbbx_handler=getback&attachment=%s&post=%s&_wpnonce=%s">%s</a>', 'delete', $item->ID, $item->post_id, wp_create_nonce('gd-attachment-delete-'.$item->ID.'-'.$item->post_id), __("Delete", "gd-bbpress-toolbox")),
            'unattach' => sprintf('<a href="admin.php?page=gd-bbpress-toolbox-attachments&single-action=%s&gdbbx_handler=getback&attachment=%s&post=%s&_wpnonce=%s">%s</a>', 'detach', $item->ID, $item->post_id, wp_create_nonce('gd-attachment-detach-'.$item->ID.'-'.$item->post_id), __("Detach", "gd-bbpress-toolbox")),
        );

        $type = $this->attachment_type($item);

        $render = !empty($type) ? $type.': ' : '';
        $render .= '<a href="upload.php?item='.$item->ID.'"><strong>'.esc_html($item->post_title).'</strong></a>';

        if (!empty($item->post_excerpt)) {
            $render .= '<br/>'.__("Caption", "gd-bbpress-toolbox").': <strong>'.esc_html($item->post_excerpt).'</strong>';
        }

        return $render.$this->row_actions($actions);
    }

    public function column_topic($item) {
        $topic_id = $item->post_id;

        $title = '';

        if ($item->post_type == bbp_get_reply_post_type()) {
            $title .= __("Reply", "gd-bbpress-toolbox").': <strong>'.$item->post_id.'</strong><br/>';
            $title .= bbp_get_reply_title_fallback(bbp_get_reply_title($item->post_id), $item->post_id);
            $url = bbp_get_reply_url($item->post_id);
        } else {
            $title .= __("Topic", "gd-bbpress-toolbox").': <strong>'.$item->post_id.'</strong><br/>';
            $title .= bbp_get_topic_title($topic_id);
            $url = get_permalink($topic_id);
        }

        $actions = array(
            'narrow' => sprintf('<a href="admin.php?page=gd-bbpress-toolbox-attachments&bbp_topic_id=%s">%s</a>', $topic_id, __("Filter", "gd-bbpress-toolbox")),
            'visit' => sprintf('<a href="%s">%s</a>', $url, __("Visit", "gd-bbpress-toolbox")),
            'edit' => sprintf('<a href="post.php?post=%s&action=edit">%s</a>', $item->post_id, __("Edit", "gd-bbpress-toolbox")),
        );

        return $title.$this->row_actions($actions);
    }

    public function column_forum($item) {
        if ($item->post_type == bbp_get_topic_post_type()) {
            $forum_id = bbp_get_topic_forum_id($item->post_id);
        } else {
            $forum_id = bbp_get_reply_forum_id($item->post_id);
        }

        $actions = array(
            'visit' => sprintf('<a href="%s">%s</a>', get_permalink($forum_id), __("Visit", "gd-bbpress-toolbox")),
            'edit' => sprintf('<a href="post.php?post=%s&action=edit">%s</a>', $forum_id, __("Edit", "gd-bbpress-toolbox")),
            'topics' => sprintf('<a href="edit.php?post_type=topic&bbp_forum_id=%s">%s</a>', $forum_id, __("Topics", "gd-bbpress-toolbox"))
        );

        return bbp_get_forum_title($forum_id).$this->row_actions($actions);
    }

    public function column_author($item) {
        $user = get_user_by('id', $item->post_author);

        if ($user) {
            return '<a href="user-edit.php?user_id='.$item->post_author.'">'.$user->display_name.'</a>';
        } else {
            return '-';
        }
    }

    public function column_thumbnail($item) {
        return wp_get_attachment_image($item->ID, array(80, 80), true);
    }

    public function column_date($item) {
        return mysql2date('Y.m.d', $item->post_date).'<br/>@ '.mysql2date('H:m:s', $item->post_date);
    }

    private function attachment_type($item) {
        if (preg_match('/^.*?\.(\w+)$/', get_attached_file($item->ID), $matches)) {
            return esc_html(strtoupper($matches[1]));
        } else {
            return strtoupper(str_replace('image/', '', get_post_mime_type()));
        }
    }

    public function prepare_items() {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $per_page = $this->rows_per_page();

        $_sel_attached = isset($_GET['filter-attached']) && !empty($_GET['filter-attached']) ? d4p_sanitize_slug($_GET['filter-attached']) : "";
        $_sel_topic = isset($_GET['bbp_topic_id']) && !empty($_GET['bbp_topic_id']) ? absint($_GET['bbp_topic_id']) : '';

        $query_where = array("p.post_type = 'attachment'");
        $query_attachments = "SELECT SQL_CALC_FOUND_ROWS a.post_id, b.post_type, p.ID, p.post_parent, p.post_date, p.post_author, p.post_title, p.post_excerpt FROM ".gdbbx_db()->attachments." a INNER JOIN ".gdbbx_db()->wpdb()->posts." p ON p.ID = a.attachment_id INNER JOIN ".gdbbx_db()->wpdb()->posts." b ON b.ID = a.post_id";

        if (!empty($_sel_attached) && gdbbx_is_bbpress_post_type($_sel_attached)) {
            $query_where[] = "b.post_type = '".$_sel_attached."'";
        }

        if ($_sel_topic != '') {
            $replies = gdbbx_db()->get_topic_replies_ids($_sel_topic);
            $replies[] = $_sel_topic;
            $query_where[] = "a.post_id in (".join(', ', $replies).")";
        }

        if (isset($_GET['s']) && $_GET['s'] != '') {
            $query_where[] = "(p.`post_title` LIKE '%".$_GET['s']."%' OR p.`post_excerpt` LIKE '%".$_GET['s']."%')";
        }

        if (!empty($query_where)) {
            $query_attachments .= ' WHERE '.join(' AND ', $query_where);
        }

        $orderby = !empty($_GET['orderby']) ? $this->sanitize_field('orderby', $_GET['orderby'], 'p.ID') : 'p.ID';
        $order = !empty($_GET['order']) ? $this->sanitize_field('order', $_GET['order'], 'DESC') : 'DESC';

        $query_attachments .= " ORDER BY $orderby $order";

        $paged = !empty($_GET['paged']) ? absint($_GET['paged']) : '';
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }

        $offset = intval(($paged - 1) * $per_page);
        $query_attachments .= " LIMIT $offset, $per_page";

        $this->items = gdbbx_db()->get_results($query_attachments);

        $total_rows = gdbbx_db()->get_found_rows();

        $this->set_pagination_args(array(
            'total_items' => $total_rows,
            'total_pages' => ceil($total_rows / $per_page),
            'per_page' => $per_page,
        ));
    }
}
