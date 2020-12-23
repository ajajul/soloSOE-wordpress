<?php

use Dev4Press\Plugin\GDQNT\Theme\Themes\DefaultGray;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gdqnt_theme_custom() {
	return DefaultGray::instance();
}
