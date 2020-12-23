<?php

namespace Dev4Press\Plugin\GDQNT\Admin;

use Dev4Press\Core\Admin\GetBack as BaseGetBack;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GetBack extends BaseGetBack {
	protected function process() {
		parent::process();

		if ( $this->a()->panel === 'dashboard' ) {
			if ( $this->is_single_action( 'clear-cache', 'action' ) ) {
				$this->clear_transient_cache();
			}

			if ( $this->is_single_action( 'activate-quantum', 'action' ) ) {
				$this->quantum_activation( true );
			}

			if ( $this->is_single_action( 'deactivate-quantum', 'action' ) ) {
				$this->quantum_activation( false );
			}
		}

		do_action( 'gdqnt_admin_getback_handler', $this->a()->page );
	}

	private function quantum_activation( $status = true ) {
		if ( $status ) {
			gdqnt()->switch_to_quantum_theme();
		} else {
			gdqnt()->switch_to_bbpress_default_theme();
		}

		wp_redirect( $this->a()->main_url() );
		exit;
	}

	private function clear_transient_cache() {
		gdqnt_db()->delete_custom_style_transients();

		wp_redirect( $this->a()->main_url() );
		exit;
	}
}
