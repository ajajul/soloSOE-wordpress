<?php

namespace Dev4Press\Plugin\GDQNT\Admin;

use Dev4Press\Core\Admin\Submenu\Plugin as BasePlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin extends BasePlugin {
	public $plugin = 'gd-quantum-theme-for-bbpress';
	public $plugin_prefix = 'gdqnt';
	public $plugin_menu = 'GD Quantum Theme';
	public $plugin_title = 'GD Quantum Theme Pro for bbPress';

	public function constructor() {
		$this->url  = GDQNT_URL;
		$this->path = GDQNT_PATH;
	}

	public function after_setup_theme() {
		$this->setup_items = array(
			'install' => array(
				'title' => __( "Install", "gd-quantum-theme-for-bbpress" ),
				'icon'  => 'ui-traffic',
				'type'  => 'setup',
				'info'  => __( "Before you continue, make sure plugin installation was successful.", "gd-quantum-theme-for-bbpress" ),
				'class' => '\\Dev4Press\\Plugin\\GDQNT\\Admin\\Panel\\Install'
			),
			'update'  => array(
				'title' => __( "Update", "gd-quantum-theme-for-bbpress" ),
				'icon'  => 'ui-traffic',
				'type'  => 'setup',
				'info'  => __( "Before you continue, make sure plugin was successfully updated.", "gd-quantum-theme-for-bbpress" ),
				'class' => '\\Dev4Press\\Plugin\\GDQNT\\Admin\\Panel\\Update'
			)
		);

		$this->menu_items = array(
			'dashboard' => array(
				'title' => __( "Getting Started", "gd-quantum-theme-for-bbpress" ),
				'icon'  => 'ui-home',
				'class' => '\\Dev4Press\\Plugin\\GDQNT\\Admin\\Panel\\Dashboard'
			),
			'about'     => array(
				'title' => __( "About", "gd-quantum-theme-for-bbpress" ),
				'icon'  => 'ui-info',
				'class' => '\\Dev4Press\\Plugin\\GDQNT\\Admin\\Panel\\About'
			)
		);
	}

	public function run_getback() {
		new GetBack( $this );
	}

	public function run_postback() {
	}

	public function settings() {
		return gdqnt_settings();
	}

	public function settings_definitions() {
		return null;
	}
}
