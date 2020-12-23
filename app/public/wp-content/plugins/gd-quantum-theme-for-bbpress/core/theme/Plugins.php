<?php

namespace Dev4Press\Plugin\GDQNT\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugins {
	public function __construct() {
		add_filter( 'gdpol_response_template_button_remove', array( $this, 'gdpol_icon_remove' ) );
		add_filter( 'gdpol_response_template_button_down', array( $this, 'gdpol_icon_down' ) );
		add_filter( 'gdpol_response_template_button_up', array( $this, 'gdpol_icon_up' ) );
	}

	public function gdpol_icon_remove( $icon ) {
		return '<i class="gdqnt-icon gdqnt-icon-times"></i>';
	}

	public function gdpol_icon_down( $icon ) {
		return '<i class="gdqnt-icon gdqnt-icon-arrow-down"></i>';
	}

	public function gdpol_icon_up( $icon ) {
		return '<i class="gdqnt-icon gdqnt-icon-arrow-up"></i>';
	}
}
