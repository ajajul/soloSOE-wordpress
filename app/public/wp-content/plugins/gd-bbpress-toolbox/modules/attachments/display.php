<?php

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;

if (!defined('ABSPATH')) { exit; }

class gdbbx_attachments_display {
    /** @var gdbbx_attachments_front */
    public $front;

    public $id = 0;
    public $post;
    public $attachments;
    public $attachments_all;
    public $author_id;

    public $thumb_types;
    public $icons;
    public $type;
    public $download;
    public $deletion;

    public function __construct($front) {
        $this->front = $front;
    }

    public function show($id) {
        $this->id = absint($id);
        $this->post = get_post($this->id);
        $this->author_id = $this->post->post_author;

        $this->attachments_all = gdbbx_get_post_attachments($id);

        if (gdbbx()->get('hide_attachments_when_in_content', 'attachments')) {
            $inserted = gdbbx_attachments()->get_inserted_attachments($id);

            $this->attachments = array();

            foreach ($this->attachments_all as $file) {
                if (!in_array(absint($file->ID), $inserted)) {
                    $this->attachments[] = $file;
                }
            }
        } else {
            $this->attachments = $this->attachments_all;
        }

        $content = '';
        $bulk = $this->_bulk();

        if (!empty($this->attachments) || !empty($bulk)) {
            $this->thumb_types = apply_filters('gdbbx_attachment_thumb_extensions', array('pdf', 'svg', 'png', 'gif', 'jpg', 'jpeg', 'jpe', 'bmp'));

            $this->icons = gdbbx()->get('attachment_icons', 'attachments');
            $this->type = gdbbx()->get('icons_mode', 'attachments');

            $this->download = gdbbx()->get('download_link_attribute', 'attachments') ? ' download' : '';
            $this->deletion = gdbbx()->get('delete_method', 'attachments') == 'default';

            $content.= '<div class="gdbbx-attachments">';
            $content.= '<h6>'.__("Attachments", "gd-bbpress-toolbox").':</h6>';

            if ($this->_hidden()) {
                $content.= $this->_visitor();
            } else {
                $content.= $this->_user();
                $content.= $this->_bulk();
            }

            $content.= '</div>';
        }

        Enqueue::instance()->attachments();

        return $content;
    }

    public function show_errors($id) {
        global $user_ID;

        if ($this->id == 0 || $this->id != $id) {
            $this->id = absint($id);
            $this->post = get_post($this->id);
            $this->author_id = $this->post->post_author;
        }

        $content = '';

        if ((gdbbx()->get('errors_visible_to_author', 'attachments') == 1 && $this->author_id == $user_ID) || (gdbbx()->get('errors_visible_to_admins', 'attachments') == 1 && d4p_is_current_user_admin()) || (gdbbx()->get('errors_visible_to_moderators', 'attachments') == 1 && gdbbx_is_current_user_bbp_moderator())) {
            $content.= $this->_errors();
        }

        Enqueue::instance()->attachments();

        return $content;
    }

    private function _bulk() {
        $bulk = '';

        if (count($this->attachments_all) > 1) {
            if (gdbbx()->get('bulk_download', 'attachments') && gdbbx()->allowed('bulk_download', 'attachments', true, false)) {
                $do = gdbbx()->get('bulk_download_listed', 'attachments') ? !empty($this->attachments) : true;

                if ($do) {
                    $topic_id = bbp_get_topic_id();

                    $url = get_permalink($topic_id);
                    $url = add_query_arg('gdbbx-bulk-download', $this->id, $url);

                    $bulk.= '<div class="gdbbx-attachments-bulk">';
                    $bulk.= '<a href="'.$url.'">'.__("Download All Files", "gd-bbpress-toolbox").'</a>';
                    $bulk.= '</div>';
                }
            }
        }

        return $bulk;
    }

    private function _visitor() {
        $content = '';

        if (!gdbbx_attachments()->is_hidden_from_visitors() && gdbbx_attachments()->is_preview_for_visitors()) {
            $content.= $this->_visitor_files();
        }

        $message = sprintf(__("You must be <a href='%s'>logged in</a> to access attached files.", "gd-bbpress-toolbox"), wp_login_url(get_permalink()));

        $content.= apply_filters('gdbbx_notice_attachments_visitor', '<div class="gdbbx-attachments-login-message bbp-template-notice"><p>'.$message.'</p></div>', $message);

        return $content;
    }

    private function _visitor_files() {
        $files = array(
            'img' => array(),
            'lst' => array()
        );

        foreach ($this->attachments as $attachment) {
            $file = get_attached_file($attachment->ID);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = pathinfo($file, PATHINFO_BASENAME);

            $item_classes = array(
                'gdbbx-attachment',
                'gdbbx-attachment-'.$ext
            );

            $html = '';
            $caption = false;
            $a_title = $attachment->post_excerpt != '' ? $attachment->post_excerpt : $filename;

            $img = false;
            if (gdbbx()->get('image_thumbnail_active', 'attachments')) {
                if (in_array($ext, $this->thumb_types)) {
                    $html = wp_get_attachment_image($attachment->ID, 'gdbbx-thumb');

                    if ($html != '') {
                        $img = true;

                        $item_classes[] = 'gdbbx-attachment-thumb';

                        if (gdbbx()->get('image_thumbnail_inline', 'attachments') == 1) {
                            $item_classes[] = ' gdbbx-thumb-inline';
                        }

                        $caption = gdbbx()->get('image_thumbnail_caption', 'attachments');
                    }
                }
            }

            if ($html == '') {
                $html = $filename;

                if ($this->icons && $this->type == 'images') {
                    $item_classes[] = 'gdbbx-image';
                    $item_classes[] = 'gdbbx-image-'.$this->front->icon($ext);
                }

                if ($this->icons && $this->type == 'font') {
                    $html = $this->front->render_attachment_icon($ext).$html;
                }
            }

            $item_classes = apply_filters('gdbbx_attachments_display_visitor_file_classes', $item_classes, $attachment);

            $item = '<li id="gdbbx-attachment-id-'.$attachment->ID.'" class="'.join(' ', $item_classes).'">';

            if ($caption) {
                $size = gdbbx()->get('image_thumbnail_size', 'attachments');
                $size = explode('x', $size);

                $item.= '<div style="width: '.$size[0].'px" class="wp-caption">';
            }

            $item.= $html;

            if ($caption) {
                $item.= '<p class="wp-caption-text">'.$a_title.'</p></div>';
            }

            $item.= '</li>';

            if ($img) {
                $files['img'][] = apply_filters('gdbbx_attachments_display_visitor_file_item_image', $item, $attachment);
            } else {
                $files['lst'][] = apply_filters('gdbbx_attachments_display_visitor_file_item_file', $item, $attachment);
            }
        }

        $content = '';

        if (!empty($files['img'])) {
            $files['img'] = apply_filters('gdbbx_attachments_display_visitor_list_images', $files['img']);
            $content.= '<ol class="with-thumbnails">'.join('', $files['img']).'</ol>';
        }

        if (!empty($files['lst'])) {
            $list_class = '';
            if ($this->icons) {
                switch ($this->type) {
                    case 'images':
                        $list_class = 'with-icons';
                        break;
                    case 'font':
                        $list_class = 'with-font-icons';
                        break;
                }
            }

            $files['lst'] = apply_filters('gdbbx_attachments_display_visitor_list_files', $files['lst']);
            $content.= '<ol class="'.$list_class.'">'.join('', $files['lst']).'</ol>';
        }

        return $content;
    }

    private function _user() {
        $files = array(
            'img' => array(),
            'lst' => array()
        );

        foreach ($this->attachments as $attachment) {
            $actions = array();

            if ($this->deletion) {
                $action_url = add_query_arg('att_id', $attachment->ID);
                $action_url = add_query_arg('bbp_id', $this->id, $action_url);

                $allow = gdbbx_attachments()->deletion_status($this->author_id);

                if ($allow == 'delete' || $allow == 'both') {
                    $_url = add_query_arg('_wpnonce', wp_create_nonce('gdbbx-attachment-delete-'.$this->id.'-'.$attachment->ID), $action_url);
                    $actions[] = '<a class="gdbbx-attachment-confirm" href="'.esc_url(add_query_arg('gdbbx-action', 'delete', $_url)).'">'.__("delete", "gd-bbpress-toolbox").'</a>';
                }

                if ($allow == 'detach' || $allow == 'both') {
                    $_url = add_query_arg('_wpnonce', wp_create_nonce('gdbbx-attachment-detach-'.$this->id.'-'.$attachment->ID), $action_url);
                    $actions[] = '<a class="gdbbx-attachment-confirm" href="'.esc_url(add_query_arg('gdbbx-action', 'detach', $_url)).'">'.__("detach", "gd-bbpress-toolbox").'</a>';
                }
            }

            $file = get_attached_file($attachment->ID);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = pathinfo($file, PATHINFO_BASENAME);
            $url = wp_get_attachment_url($attachment->ID);

            $item_classes = array(
                'gdbbx-attachment',
                'gdbbx-attachment-'.$ext
            );

            $html = $class_a = $rel_a = '';
            $caption = false;
            $a_title = $attachment->post_excerpt != '' ? $attachment->post_excerpt : $filename;
            $a_target = gdbbx()->get('file_target_blank', 'attachments') ? '_blank' : '_self';

            $img = false;
            if (gdbbx()->get('image_thumbnail_active', 'attachments')) {
                if (in_array($ext, $this->thumb_types)) {
                    $html = wp_get_attachment_image($attachment->ID, 'gdbbx-thumb');

                    if ($html != '') {
                        $img = true;

                        $item_classes[] = 'gdbbx-attachment-thumb';
                        if (gdbbx()->get('image_thumbnail_inline', 'attachments') == 1) {
                            $item_classes[] = 'gdbbx-thumb-inline';
                        }

                        $class_a = gdbbx()->get('image_thumbnail_css', 'attachments');
                        $caption = gdbbx()->get('image_thumbnail_caption', 'attachments');

                        $class_a.= ' ext-'.$ext;

                        $rel_a = apply_filters('gdbbx_image_thumbnail_rel', gdbbx()->get('image_thumbnail_rel', 'attachments'), $attachment, $ext);

                        if (!empty($rel_a)) {
                            $rel_a = ' rel="'.$rel_a.'"';
                            $rel_a = str_replace('%ID%', $this->id, $rel_a);
                            $rel_a = str_replace('%TOPIC%', bbp_get_topic_id(), $rel_a);
                            $rel_a = str_replace('%EXT%', $ext, $rel_a);
                        }
                    }
                }
            }

            if (empty($html)) {
                $html = $filename;

                if ($this->icons && $this->type == 'images') {
                    $item_classes[] = 'gdbbx-image';
                    $item_classes[] = 'gdbbx-image-'.$this->front->icon($ext);
                }

                if ($this->icons && $this->type == 'font') {
                    $html = $this->front->render_attachment_icon($ext).$html;
                }
            }

            $item_classes = apply_filters('gdbbx_attachments_display_user_file_classes', $item_classes, $attachment);

            $item = '<li id="gdbbx-attachment-id-'.$attachment->ID.'" class="'.join(' ', $item_classes).'">';

            if ($caption) {
                $size = gdbbx()->get('image_thumbnail_size', 'attachments');
                $size = explode('x', $size);

                $item.= '<div style="width: '.$size[0].'px" class="wp-caption">';
            }

            if ($img) {
                $item.= '<a class="'.trim($class_a).'"'.$rel_a.' href="'.$url.'" title="'.$a_title.'" target="'.$a_target.'">'.$html.'</a>';
            } else {
                $item.= '<a class="'.trim($class_a).'"'.$rel_a.$this->download.' href="'.$url.'" title="'.$a_title.'" target="'.$a_target.'">'.$html.'</a>';
            }

            if ($caption) {
                $a_title = '<a href="'.$url.'"'.$this->download.' target="'.$a_target.'">'.$a_title.'</a>';

                $item.= '<p class="wp-caption-text">'.$a_title;
                $item.= !empty($actions) ? '<br/>['.join(' | ', $actions).']' : '';
                $item.= '</p></div>';
            } else {
                $item.= !empty($actions) ? ' ['.join(' | ', $actions).']' : '';
            }

            $item.= '</li>';

            if ($img) {
                $files['img'][] = apply_filters('gdbbx_attachments_display_user_file_item_image', $item, $attachment);
            } else {
                $files['lst'][] = apply_filters('gdbbx_attachments_display_user_file_item_file', $item, $attachment);
            }
        }

        $content = '';

        if (!empty($files['img'])) {
            $files['img'] = apply_filters('gdbbx_attachments_display_user_list_images', $files['img']);
            $content.= '<ol class="with-thumbnails">'.join('', $files['img']).'</ol>';
        }

        if (!empty($files['lst'])) {
            $list_class = '';
            if ($this->icons) {
                switch ($this->type) {
                    case 'images':
                        $list_class = 'with-icons';
                        break;
                    case 'font':
                        $list_class = 'with-font-icons';
                        break;
                }
            }

            $files['lst'] = apply_filters('gdbbx_attachments_display_user_list_files', $files['lst']);
            $content.= '<ol class="'.$list_class.'">'.join('', $files['lst']).'</ol>';
        }

        return $content;
    }

    private function _errors() {
        $content = '';

        $errors = get_post_meta($this->id, '_bbp_attachment_upload_error');

        if (!empty($errors)) {
            $content.= '<div class="gdbbx-attachments-errors">';
            $content.= '<h6>'.__("Upload Errors", "gd-bbpress-toolbox").':</h6>';
            $content.= '<ol>';

            foreach ($errors as $error) {
                $content.= '<li><strong>'.esc_html($error['file']).'</strong>: '.__($error['message'], "gd-bbpress-toolbox").'</li>';
            }

            $content.= '</ol></div>';
        }

        return $content;
    }

    private function _hidden() {
        if (!is_user_logged_in()) {
            return gdbbx_attachments()->is_hidden_from_visitors() || gdbbx_attachments()->is_preview_for_visitors();
        }

        return false;
    }
}
