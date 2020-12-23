<?php

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;

if (!defined('ABSPATH')) {
    exit;
}

function gdbbx_enqueue_files_force() {
    _deprecated_function(__FUNCTION__, '6.0', 'Enqueue::instance()->core()');

    Enqueue::instance()->core();
}

function gdbbx_settings() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx()');

    return gdbbx();
}

function gdbbx_module_signature() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_signature()');

    return gdbbx_signature();
}

function gdbbx_module_report() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_report()');

    return gdbbx_report();
}

function gdbbx_module_private() {
    _deprecated_function(__FUNCTION__, '6.0', '');

    return null;
}

function gdbbx_module_lock() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_lock_forums()');

    return gdbbx_lock_forums();
}

function gdbbx_module_profiles() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_user_profiles()');

    return gdbbx_user_profiles();
}

function gdbbx_module_front() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_forum_index()');

    return gdbbx_forum_index();
}

function gdbbx_module_canned() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_canned_replies()');

    return gdbbx_canned_replies();
}

function gdbbx_module_thanks() {
    _deprecated_function(__FUNCTION__, '6.0', 'gdbbx_say_thanks()');

    return gdbbx_say_thanks();
}
