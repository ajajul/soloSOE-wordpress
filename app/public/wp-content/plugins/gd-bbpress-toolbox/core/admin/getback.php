<?php

use Dev4Press\Plugin\GDBBX\Tasks\Cleanup;

if (!defined('ABSPATH')) { exit; }

class gdbbx_admin_getback {
    public function __construct() {
        if (isset($_GET['action']) && $_GET['action'] == 'enable-feature') {
            $this->feature_enable();
        }

        if (isset($_GET['action']) && $_GET['action'] == 'disable-feature') {
            $this->feature_disable();
        }

        if (gdbbx_admin()->page === 'features') {
            if (isset($_GET['action']) && $_GET['action'] == 'reset-feature') {
                $this->feature_reset();
            }
        }

        if (gdbbx_admin()->page === 'front') {
            if (isset($_GET['action']) && $_GET['action'] == 'gdbbx-disable-free') {
                $this->front_disable_free();
            }

            if (isset($_GET['action']) && $_GET['action'] == 'dismiss-power-search') {
                $this->front_dismiss_search();
            }

            if (isset($_GET['action']) && $_GET['action'] == 'dismiss-topic-prefix') {
                $this->front_dismiss_prefix();
            }

            if (isset($_GET['action']) && $_GET['action'] == 'dismiss-topic-polls') {
                $this->front_dismiss_polls();
            }

            if (isset($_GET['action']) && $_GET['action'] == 'dismiss-quantum-theme') {
                $this->front_dismiss_quantum();
            }

            if (isset($_GET['action']) && $_GET['action'] == 'dismiss-members-directory') {
                $this->front_dismiss_members();
            }

            if (isset($_GET['action']) && $_GET['action'] == 'dismiss-forum-notices') {
                $this->front_dismiss_forum();
            }
        }

        if (gdbbx_admin()->page === 'reported-posts') {
            if (isset($_GET['single-action'])) {
                $this->reported_posts_action();
            }
        }

        if (gdbbx_admin()->page === 'attachments') {
            if (isset($_GET['single-action'])) {
                $this->attachments_single_action();
            }

            if (isset($_GET['action']) || isset($_GET['action2'])) {
                $this->attachments_bulk_action();
            }
        }

        if (gdbbx_admin()->page === 'users') {
            if (isset($_GET['action']) || isset($_GET['action2'])) {
                $this->users_bulk_action();
            }
        }

        if (gdbbx_admin()->page === 'errors') {
            if (isset($_GET['single-action'])) {
                $this->errors_single_action();
            }

            if (isset($_GET['action']) || isset($_GET['action2'])) {
                $this->errors_bulk_action();
            }
        }

        if (gdbbx_admin()->page === 'tools') {
            if (isset($_GET['run']) && $_GET['run'] == 'export') {
                $this->tools_export();
            }
        }
    }

    private function action_delete_errors($ids) {
        foreach ($ids as $meta_id) {
            delete_metadata_by_mid('post', $meta_id);
        }
    }

    private function feature_enable() {
        $feature = isset($_GET['feature']) ? d4p_sanitize_key_expanded($_GET['feature']) : '';

        check_ajax_referer('gdbbx-enable-feature-'.$feature);

        gdbbx()->set($feature, true, 'load', true);

        $url = gdbbx_admin()->current_url(true);
        wp_redirect($url.'&message=saved');
        exit;
    }

    private function feature_disable() {
        $feature = isset($_GET['feature']) ? d4p_sanitize_key_expanded($_GET['feature']) : '';

        check_ajax_referer('gdbbx-disable-feature-'.$feature);

        gdbbx()->set($feature, false, 'load', true);

        $url = gdbbx_admin()->current_url(true);
        wp_redirect($url.'&message=saved');
        exit;
    }

    private function feature_reset() {
        $feature = isset($_GET['feature']) ? d4p_sanitize_key_expanded($_GET['feature']) : '';

        check_ajax_referer('gdbbx-reset-feature-'.$feature);

        gdbbx()->reset_feature($feature);

        $url = gdbbx_admin()->current_url(true);
        wp_redirect($url.'&message=saved');
        exit;
    }

    private function tools_export() {
        check_ajax_referer('dev4press-plugin-export');

        if (!d4p_is_current_user_admin()) {
            wp_die(__("Only administrators can use export features.", "gd-bbpress-toolbox"));
        }

        $export_date = date('Y-m-d-H-m-s');
        $export_name = 'gd-bbpress-toolbox-settings-'.$export_date.'.json';

        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename="'.$export_name.'"');

        die(gdbbx()->export_to_secure_json());
    }

    private function front_disable_free() {
        deactivate_plugins(array(
            'gd-bbpress-attachments/gd-bbpress-attachments.php',
            'gd-bbpress-tools/gd-bbpress-tools.php',
            'gd-bbpress-widgets/gd-bbpress-widgets.php'
        ));

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front&message=free-disabled');
        exit;
    }

    private function front_dismiss_prefix() {
        gdbbx()->set('notice_gdtox_hide', true, 'core', true);

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front');
        exit;
    }

    private function front_dismiss_search() {
        gdbbx()->set('notice_gdpos_hide', true, 'core', true);

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front');
        exit;
    }

    private function front_dismiss_polls() {
        gdbbx()->set('notice_gdpol_hide', true, 'core', true);

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front');
        exit;
    }

    private function front_dismiss_quantum() {
        gdbbx()->set('notice_gdqnt_hide', true, 'core', true);

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front');
        exit;
    }

    private function front_dismiss_members() {
        gdbbx()->set('notice_gdmed_hide', true, 'core', true);

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front');
        exit;
    }

    private function front_dismiss_forum() {
        gdbbx()->set('notice_gdfon_hide', true, 'core', true);

        wp_redirect('admin.php?page=gd-bbpress-toolbox-front');
        exit;
    }

    private function reported_posts_action() {
        $nonce = isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '';

        if (wp_verify_nonce($nonce, 'gd-bbpress-toolbox-report') !== false) {
            $user = get_current_user_id();
            $action = $_GET['single-action'];
            $id = isset($_GET['report']) ? absint($_GET['report']) : 0;

            if ($action == 'close-report' && $id > 0) {
                gdbbx_db()->report_status($id, 'closed');
                gdbbx_db()->report_closed($id, $user);

                wp_redirect('admin.php?page=gd-bbpress-toolbox-reported-posts');
                exit;
            }
        }
    }

    private function attachments_single_action() {
        $action = isset($_GET['single-action']) ? d4p_sanitize_basic($_GET['single-action']) : '';
        $nonce = isset($_GET['_wpnonce']) ? d4p_sanitize_basic($_GET['_wpnonce']) : '';
        $id = isset($_GET['attachment']) ? absint($_GET['attachment']) : 0;
        $post = isset($_GET['post']) ? absint($_GET['post']) : 0;

        if (wp_verify_nonce($nonce, 'gd-attachment-'.$action.'-'.$id.'-'.$post) !== false) {
            if ($action == 'delete') {
                gdbbx_db()->delete_attachment($post, $id);
            } else if ($action == 'detach') {
                gdbbx_db()->detach_attachment($post, $id);
            }

            $topic_id = bbp_is_topic($post) ? $post : bbp_get_reply_topic_id($post);

            gdbbx_db()->update_topic_attachments_count($topic_id);

            wp_redirect('admin.php?page=gd-bbpress-toolbox-attachments&message=attachment-'.$action);
            exit;
        }
    }

    private function attachments_bulk_action() {
        check_admin_referer('bulk-attachments');

        $action = $this->_get_bulk_action();

        if ($action != '') {
            $ids = isset($_GET['attachment']) ? (array)$_GET['attachment'] : array();

            if (!empty($ids)) {
                foreach ($ids as $one) {
                    $parts = explode('-', $one);

                    if (count($parts) == 2) {
                        $post = absint($parts[0]);
                        $id = absint($parts[1]);

                        if ($post > 0 && $id > 0) {
                            if ($action == 'delete') {
                                gdbbx_db()->delete_attachment($post, $id);
                            } else if ($action == 'detach') {
                                gdbbx_db()->detach_attachment($post, $id);
                            }

                            $topic_id = bbp_is_topic($post) ? $post : bbp_get_reply_topic_id($post);

                            gdbbx_db()->update_topic_attachments_count($topic_id);
                        }
                    }
                }
            }

            wp_redirect('admin.php?page=gd-bbpress-toolbox-attachments&message=attachments-'.$action);
            exit;
        }
    }

    private function errors_single_action() {
        $nonce = isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '';

        if (wp_verify_nonce($nonce, 'gd-bbpress-toolbox-error') !== false) {
            $action = $_GET['single-action'];
            $id = isset($_GET['error']) ? array($_GET['error']) : array();

            if ($action == 'delete') {
                $this->action_delete_errors($id);
            }

            wp_redirect('admin.php?page=gd-bbpress-toolbox-errors&message=error-deleted');
            exit;
        }
    }

    private function users_bulk_action() {
        check_admin_referer('bulk-users');

        $action = $this->_get_bulk_action();

        if ($action != '') {
            $ids = isset($_GET['user']) ? (array)$_GET['user'] : array();
            $ids = gdbbx_db()->clean_ids_list($ids);

            if (!empty($ids)) {
                foreach ($ids as $user_id) {
                    if ($action == 'unsubfav' || $action == 'unfavtop') {
                        Cleanup::instance()->clear_user_favorites($user_id);
                    }

                    if ($action == 'unsubfav' || $action == 'unsuball' || $action == 'unsubfor') {
                        Cleanup::instance()->clear_user_forum_subscriptions($user_id);
                    }

                    if ($action == 'unsubfav' || $action == 'unsuball' || $action == 'unsubtop') {
                        Cleanup::instance()->clear_user_topic_subscriptions($user_id);
                    }
                }
            }

            wp_redirect('admin.php?page=gd-bbpress-toolbox-users&message=users-updated');
            exit;
        }
    }

    private function errors_bulk_action() {
        check_admin_referer('bulk-errors');

        $action = $this->_get_bulk_action();

        if ($action != '') {
            $ids = isset($_GET['error']) ? (array)$_GET['error'] : array();
            $ids = gdbbx_db()->clean_ids_list($ids);

            if (!empty($ids)) {
                if ($action == 'delete') {
                    $this->action_delete_errors($ids);
                }
            }

            wp_redirect('admin.php?page=gd-bbpress-toolbox-errors&message=errors-deleted');
            exit;
        }
    }

    private function _get_bulk_action() {
        $action = isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] != '-1' ? $_GET['action'] : '';

        if ($action == '') {
            $action = isset($_GET['action2']) && $_GET['action2'] != '' && $_GET['action2'] != '-1' ? $_GET['action2'] : '';
        }

        return $action;
    }
}
