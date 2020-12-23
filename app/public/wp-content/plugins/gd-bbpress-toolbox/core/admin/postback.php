<?php

use Dev4Press\Plugin\GDBBX\Tasks\Cleanup;

if (!defined('ABSPATH')) { exit; }

class gdbbx_admin_postback {
    public function __construct() {
        $page = isset($_POST['option_page']) ? $_POST['option_page'] : false;

        if ($page !== false) {
            if ($page == 'gd-bbpress-toolbox-tools') {
                $this->tools();
            }

            if ($page == 'gd-bbpress-toolbox-settings') {
                $this->settings();
            }

            if ($page == 'gd-bbpress-toolbox-wizard') {
                $this->wizard();
            }

            do_action('gdbbx_admin_postback_handler', $page);
        }
    }

    private function tools() {
        check_admin_referer('gd-bbpress-toolbox-tools-options');

        $post = $_POST['gdbbxtools'];
        $action = $post['panel'];

        $url = 'admin.php?page=gd-bbpress-toolbox-tools&panel='.$action;

        $message = 'nothing';

        if ($action == 'remove') {
            $remove = isset($post['remove']) ? (array)$post['remove'] : array();

            if (!empty($remove)) {
                $message = 'removed';

                if (isset($remove['settings']) && !empty($remove['settings'])) {
                    $settings = $remove['settings'];

                    if (isset($settings['all']) && $settings['all'] == 'on') {
                        gdbbx()->remove_all_plugin_settings();
                    } else {
                        $_remove = array();

                        if (isset($settings['settings']) && $settings['settings'] == 'on') {
                            $_remove[] = 'settings';
                            $_remove[] = 'bbpress';
                            $_remove[] = 'tools';
                        }

                        if (isset($settings['features']) && $settings['features'] == 'on') {
                            $_remove[] = 'load';
                            $_remove[] = 'features';
                        }

                        if (isset($settings['attachments']) && $settings['attachments'] == 'on') {
                            $_remove[] = 'attachments';
                        }

                        if (isset($settings['online']) && $settings['online'] == 'on') {
                            $_remove[] = 'online';
                        }

                        if (isset($settings['seo']) && $settings['seo'] == 'on') {
                            $_remove[] = 'seo';
                        }

                        if (isset($settings['widgets']) && $settings['widgets'] == 'on') {
                            $_remove[] = 'widgets';
                        }

                        if (isset($settings['buddypress']) && $settings['buddypress'] == 'on') {
                            $_remove[] = 'buddypress';
                        }

                        if (!empty($_remove)) {
                            gdbbx()->remove_selected_settings($_remove);
                        }
                    }
                }

                if (isset($remove['forums']) && $remove['forums'] == 'on') {
                    gdbbx()->remove_forums_settings();
                }

                if (isset($remove['tracking']) && $remove['tracking'] == 'on') {
                    gdbbx()->remove_tracking_settings();
                }

                if (isset($remove['signature']) && $remove['signature'] == 'on') {
                    gdbbx()->remove_signature_settings();
                }

                if (isset($remove['cron']) && $remove['cron'] == 'on') {
                    d4p_remove_cron('gdbbx_cron_daily_maintenance_job');
                }

                if (isset($remove['drop']) && $remove['drop'] == 'on') {
                    require_once(GDBBX_PATH.'core/admin/install.php');

                    gdbbx_drop_database_tables();

                    if (!isset($remove['disable'])) {
                        gdbbx()->mark_for_update();
                    }
                } else if (isset($remove['truncate']) && $remove['truncate'] == 'on') {
                    require_once(GDBBX_PATH.'core/admin/install.php');

                    gdbbx_truncate_database_tables();
                }

                if (isset($remove['disable']) && $remove['disable'] == 'on') {
                    deactivate_plugins('gd-bbpress-toolbox/gd-bbpress-toolbox.php', false, false);

                    wp_redirect(admin_url('plugins.php'));
                    exit;
                }
            }
        } else if ($action == 'removeips') {
            if (isset($post['removeips']['remove']) && $post['removeips']['remove'] == 'on') {
                $_ips_count = Cleanup::instance()->delete_author_ips_from_postmeta();

                if ($_ips_count > 0) {
                    $message = 'ips-removed&ips='.$_ips_count;
                }
            }
        } else if ($action == 'cleanup') {
            if (isset($post['cleanup']['thanks']) && $post['cleanup']['thanks'] == 'on') {
                $_thanks_count = Cleanup::instance()->delete_thanks_for_missing_posts();

                if ($_thanks_count > 0) {
                    $message = 'cleanup-thanks&thanks='.$_thanks_count;
                }
            }
        } else if ($action == 'close') {
            $_topics_closed = 0;

            if (isset($post['close']['inactive']) && $post['close']['inactive'] == 'on') {
                $days = intval($post['close']['inactivity']);

                if ($days > 0) {
                    $_topics_closed+= gdbbx_db()->close_inactive_topics($days);
                }
            }

            if (isset($post['close']['old']) && $post['close']['old'] == 'on') {
                $days = intval($post['close']['age']);

                if ($days > 0) {
                    $_topics_closed+= gdbbx_db()->close_old_topics($days);
                }
            }

            if ($_topics_closed > 0) {
                $message = 'closed&topics='.$_topics_closed;
            }
        } else if ($action == 'import') {
            if (is_uploaded_file($_FILES['import_file']['tmp_name'])) {
                $data = file_get_contents($_FILES['import_file']['tmp_name']);
                $data = json_decode($data, true);

                if (!is_array($data)) {
                    $message = 'invalid-import';
                } else {
                    $import = isset($post['import']) ? $post['import'] : array();

                    if (empty($import)) {
                        $message = 'nothing-to-import';
                    } else {
                        $groups = array();

                        if (isset($import['settings']) && $import['settings'] == 'on') {
                            $groups[] = 'settings';
                            $groups[] = 'bbpress';
                            $groups[] = 'tools';
                        }

                        if (isset($import['features']) && $import['features'] == 'on') {
                            $groups[] = 'load';
                            $groups[] = 'features';
                        }

                        if (isset($import['attachments']) && $import['attachments'] == 'on') {
                            $groups[] = 'attachments';
                        }

                        if (isset($import['online']) && $import['online'] == 'on') {
                            $groups[] = 'online';
                        }

                        if (isset($import['seo']) && $import['seo'] == 'on') {
                            $groups[] = 'seo';
                        }

                        if (isset($import['widgets']) && $import['widgets'] == 'on') {
                            $groups[] = 'widgets';
                        }

                        if (isset($import['buddypress']) && $import['buddypress'] == 'on') {
                            $groups[] = 'buddypress';
                        }

                        $message = gdbbx()->import_from_secure_json($data, $groups);
                    }
                }
            }
        }

        wp_redirect($url.'&message='.$message);
        exit;
    }

    private function settings() {
        check_admin_referer('gd-bbpress-toolbox-settings-options');

        d4p_includes(array(
            array('name' => 'walkers', 'directory' => 'admin'),
            array('name' => 'settings', 'directory' => 'admin')
        ), GDBBX_D4PLIB);

        include(GDBBX_PATH.'core/admin/internal.php');

        $_panel = gdbbx_admin()->panel;
        if (gdbbx_admin()->page == 'features' && (!$_panel || $_panel == 'index')) {
            $_panel = 'load';
        }

        $options = new gdbbx_admin_settings();
        $settings = $_panel == 'load' ? $options->features_load() : $options->settings($_panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdbbxvalue';

        $data = $processor->process();

        foreach ($data as $group => $values) {
            foreach ($values as $name => $value) {
                gdbbx()->set($name, $value, $group);

                do_action('gdbbx_save_settings_value', $group, $name, $value);
            }

            gdbbx()->save($group);
        }

        if (gdbbx_admin()->page == 'views') {
            wp_flush_rewrite_rules();
        }

        $url = 'admin.php?page=gd-bbpress-toolbox-'.gdbbx_admin()->page.'&panel='.gdbbx_admin()->panel;
        wp_redirect($url.'&message=saved');
        exit;
    }

    private function wizard() {
        require_once(GDBBX_PATH.'modules/features/core.wizard.php');

        gdbbx_wizard()->panel_postback();
    }
}
