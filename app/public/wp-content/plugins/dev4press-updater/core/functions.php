<?php

if (!defined('ABSPATH')) {
    exit;
}

function d4pupd_prepare_host() {
    $ip = preg_replace('/[^0-9a-fA-F:., ]/', '', $_SERVER['SERVER_ADDR']);
    $ip = trim($ip);

    return in_array($ip, array('127.0.0.1', '::1')) ? 'Y' : 'N';
}

function d4pupd_get_api_key() {
    if (d4p_is_current_user_admin()) {
        $key = d4pupd_settings()->get('dev4press_api_key');

        if (empty($key)) {
            return false;
        } else {
            return $key;
        }
    }
}

function d4pupd_prepare_meta($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);

    $y = 0;
    $hash = '';
    for ($x = 0; $x < $strLen; $x++) {
        $ordStr = ord(substr($string, $x, 1));

        if ($y == $keyLen) {
            $y = 0;
        }

        $ordKey = ord(substr($key, $y, 1));
        $y++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }

    return $hash;
}

function dev4upd_debug_log($msg, $object) {
    $dir = wp_upload_dir();
    $root = $dir['basedir'];

    if (is_writable($root)) {
        $path = $root.'/dev4press.log';

        $f = fopen($path, 'a+');

        $obj = print_r($object, true);

        fwrite($f, sprintf("[%s] : %s\r\n", date('Y-m-d h:i:s'), $msg));
        fwrite($f, "$obj");
        fwrite($f, "\r\n");

        fclose($f);
    }
}

function d4pupd_check_update_url() {
    $url = self_admin_url('admin.php?page=dev4press-updater-front');

    $url = add_query_arg('check', 'run', $url);
    $url = wp_nonce_url($url, 'dev4press-updater');

    return $url;
}

function d4pupd_remove_cron($hook = 'dev4press_update_check') {
    $crons = _get_cron_array();

    if (!empty($crons)) {
        $save = false;

        foreach ($crons as $timestamp => $cron) {
            if (isset($cron[$hook])) {
                unset($crons[$timestamp][$hook]);
                $save = true;
            }
        }

        if ($save) {
            _set_cron_array($crons);
        }
    }
}

function d4pupd_mysql_version() {
    global $wpdb;

    if ($wpdb->use_mysqli) {
        $server_info = mysqli_get_server_info($wpdb->dbh);
    } else {
        $server_info = mysql_get_server_info($wpdb->dbh);
    }

    return $server_info;
}
