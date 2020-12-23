<?php

use Dev4Press\Plugin\GDQNT\Admin\Plugin as AdminPlugin;
use Dev4Press\Plugin\GDQNT\Basic\DB;
use Dev4Press\Plugin\GDQNT\Basic\Plugin;
use Dev4Press\Plugin\GDQNT\Basic\Settings;
use Dev4Press\Plugin\GDQNT\Customizer\Manager;
use Dev4Press\Plugin\GDQNT\Theme\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @return Dev4Press\Plugin\GDQNT\Basic\Plugin */
function gdqnt() {
	return Plugin::instance();
}

/** return Dev4Press\Plugin\GDQNT\Basic\Settings */
function gdqnt_settings() {
	return Settings::instance();
}

/** return Dev4Press\Plugin\GDQNT\Basic\DB */
function gdqnt_db() {
	return DB::instance();
}

/** return Dev4Press\Plugin\GDQNT\Customizer\Manager */
function gdqnt_customizer() {
	return Manager::instance();
}

/** return Dev4Press\Plugin\GDQNT\Theme\Core */
function gdqnt_theme() {
	return Core::instance();
}

/** @return Dev4Press\Plugin\GDQNT\Admin\Plugin */
function gdqnt_admin() {
	return AdminPlugin::instance();
}

function is_quantum_theme_active() {
	return gdqnt()->is_quantum_active();
}
