<?php

namespace Dev4Press\Plugin\GDQNT\Theme\Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ClassicGray extends DefaultGray {
	protected $name = 'classic-gray';

	protected $overrides = array(
		'color-calc-border',
		'color-calc-text',
		'color-calc-link',
		'color-form-button-link',
		'border-radius'
	);

	protected function init() {
		parent::init();

		if ( isset( $this->values['border-radius'] ) ) {
			$this->values['border-radius'] .= 'px';
		}
	}
}
