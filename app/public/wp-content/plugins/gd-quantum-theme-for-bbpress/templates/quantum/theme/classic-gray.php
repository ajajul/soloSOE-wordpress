<?php

use Dev4Press\Plugin\GDQNT\Theme\Themes\ClassicGray;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gdqnt_theme_custom() {
	return ClassicGray::instance();
}
