<?php

/*
Plugin Name:       GD Quantum Theme Pro for bbPress
Plugin URI:        https://plugins.dev4press.com/gd-quantum-theme-for-bbpress/
Description:       Responsive and modern theme to fully replace default bbPress theme templates and styles, with multiple colour schemes and Customizer integration for more control.
Author:            Milan Petrovic
Author URI:        https://www.dev4press.com/
Text Domain:       demopress
Version:           2.5
Requires at least: 4.9
Tested up to:      5.6
Requires PHP:      5.6
License:           GPLv3 or later
License URI:       https://www.gnu.org/licenses/gpl-3.0.html
Private:           true

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

$gdqnt_dirname_basic = dirname(__FILE__).'/';
$gdqnt_urlname_basic = plugins_url('/gd-quantum-theme-for-bbpress/');

define('GDQNT_PATH', $gdqnt_dirname_basic);
define('GDQNT_URL', $gdqnt_urlname_basic);

define('GDQNT_D4PLIB_PATH', $gdqnt_dirname_basic.'d4plib/');
define('GDQNT_D4PLIB_URL', $gdqnt_urlname_basic.'d4plib/');
define('GDQNT_THEME', $gdqnt_dirname_basic.'templates/quantum/');

require_once(GDQNT_D4PLIB_PATH.'core.php');

require_once(GDQNT_PATH.'core/autoload.php');
require_once(GDQNT_PATH.'core/bridge.php');

gdqnt_settings();

gdqnt();

if (D4P_ADMIN) {
    gdqnt_admin();
}
