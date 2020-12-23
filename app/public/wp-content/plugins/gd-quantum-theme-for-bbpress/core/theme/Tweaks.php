<?php

namespace Dev4Press\Plugin\GDQNT\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tweaks {
	public function __construct() {
		add_filter( 'gdpol_topic_list_poll_icon', array( $this, 'poll_icon' ) );
		add_filter( 'dynamic_sidebar_params', array( $this, 'add_widget_class' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 100000 );

		add_action( 'bbp_user_edit_before', array( $this, 'genesis_profile' ) );
	}

	public function poll_icon( $icon ) {
		return '<i class="gdqnt-icon gdqnt-icon-poll"></i>';
	}

	public function enqueue_scripts() {
		wp_dequeue_style( 'oceanwp-bbpress' );
	}

	public function add_widget_class( $args ) {
		if ( isset( $args[0]['before_widget'] ) ) {
			$args[0]['before_widget'] = str_replace( 'class="', 'class="gdqnt-widget ', $args[0]['before_widget'] );
		}

		return $args;
	}

	public function genesis_profile() {
		remove_action( 'show_user_profile', 'genesis_user_options_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
		remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );
	}
}