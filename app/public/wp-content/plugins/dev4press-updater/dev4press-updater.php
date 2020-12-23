<?php

/*
Plugin Name: Dev4Press Updater
Plugin URI: https://plugins.dev4press.com/dev4press-updater/
Description: Dev4Press Updater is a plugin for performing installation and updating of Dev4Press Pro plugins, including alpha, beta and nightly releases, directly from WordPress Updater.
Version: 4.3
Author: Milan Petrovic
Author URI: https://www.dev4press.com/
Private: true
Network: true

== Copyright ==
Copyright 2008 - 2020 Milan Petrovic (email: milan@gdragon.info)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

if (!defined('ABSPATH')) exit;

$d4pupd_dirname_basic = dirname(__FILE__).'/';
$d4pupd_urlname_basic = plugins_url('/dev4press-updater/');

define('D4PUPD_PATH', $d4pupd_dirname_basic);
define('D4PUPD_URL', $d4pupd_urlname_basic);
define('D4PUPD_D4PLIB', $d4pupd_dirname_basic.'d4plib/');

/* D4PLIB */
if (!defined('D4PLIB_PATH')) {
    define('D4PLIB_PATH', D4PUPD_D4PLIB);
}

if (!defined('D4PLIB_URL')) {
    define('D4PLIB_URL', D4PUPD_URL.'d4plib/');
}

require_once(D4PUPD_D4PLIB.'d4p.core.php');
/* D4PLIB */

d4p_includes(array(
    array('name' => 'ip', 'directory' => 'classes'), 
    'functions', 
    'sanitize', 
    'access', 
    'wp'
), D4PUPD_D4PLIB);

global $_d4pupd_plugin, $_d4pupd_settings, $_d4pupd_updater;

require_once(D4PUPD_PATH.'core/functions.php');
require_once(D4PUPD_PATH.'core/plugin.php');
require_once(D4PUPD_PATH.'core/version.php');
require_once(D4PUPD_PATH.'core/settings.php');
require_once(D4PUPD_PATH.'core/updater.php');

$_d4pupd_plugin = new d4pupd_core_plugin();
$_d4pupd_settings = new d4pupd_core_settings();
$_d4pupd_updater = new d4pupd_core_updater();

/* @return d4pupd_core_plugin */
function d4pupd_plugin() {
    global $_d4pupd_plugin;
    return $_d4pupd_plugin;
}

/* @return d4pupd_core_settings */
function d4pupd_settings() {
    global $_d4pupd_settings;
    return $_d4pupd_settings;
}

/* @return d4pupd_core_updater */
function d4pupd_updater() {
    global $_d4pupd_updater;
    return $_d4pupd_updater;
}

if (D4P_ADMIN) {
    require_once(D4PUPD_PATH.'core/admin.php');
}
