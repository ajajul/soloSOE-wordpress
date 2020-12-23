<?php

namespace Dev4Press\Plugin\GDQNT\Basic;

use Dev4Press\Core\Plugins\Settings as BaseSettings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings extends BaseSettings {
	public $base = 'gdqnt';

	public $settings = array(
		'core'     => array(
			'notice_gdqnt_hide' => true,
			'notice_gdfon_hide' => false,
			'notice_gdtox_hide' => false,
			'notice_gdpol_hide' => false,
			'notice_gdbbx_hide' => false,
			'notice_gdpos_hide' => false,
			'notice_gdmed_hide' => false,
			'activated'         => 0
		),
		'settings' => array(
			'custom_style' => 'transient'
		)
	);

	protected function constructor() {
		$this->info = new Information();

		add_action( 'gdqnt_load_settings', array( $this, 'init' ) );
	}

	protected function _name( $name ) {
		return 'dev4press_' . $this->info->code . '_' . $name;
	}
}
