<?php

namespace Dev4Press\Plugin\GDQNT\Theme\Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LightGray extends DefaultGray {
	protected $name = 'light-gray';

	protected $overrides = array(
		'color-calc-border',
		'color-calc-background',
		'color-calc-text',
		'color-calc-link',
		'color-form-button-link'
	);
}
