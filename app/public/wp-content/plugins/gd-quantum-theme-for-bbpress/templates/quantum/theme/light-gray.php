<?php

use Dev4Press\Plugin\GDQNT\Theme\Themes\LightGray;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gdqnt_theme_custom() {
	return LightGray::instance();
}
