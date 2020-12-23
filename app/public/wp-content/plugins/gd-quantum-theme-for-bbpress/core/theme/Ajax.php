<?php

namespace Dev4Press\Plugin\GDQNT\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ajax {
	public function __construct() {
		add_action( 'bbp_ajax_favorite', array( $this, 'ajax_favorite' ) );
		add_action( 'bbp_ajax_subscription', array( $this, 'ajax_subscription' ) );
	}

	public function ajax_favorite() {
		if ( ! bbp_is_favorites_active() ) {
			bbp_ajax_response( false, esc_html__( "Favourites are not active.", "gd-quantum-theme-for-bbpress" ), 300 );
		}

		if ( ! is_user_logged_in() ) {
			bbp_ajax_response( false, esc_html__( "Please login to add to favourites.", "gd-quantum-theme-for-bbpress" ), 301 );
		}

		$user_id = bbp_get_current_user_id();
		$id      = ! empty( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		$type    = ! empty( $_POST['type'] ) ? sanitize_key( $_POST['type'] ) : 'post';

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			bbp_ajax_response( false, esc_html__( "You do not have permission to do this.", "gd-quantum-theme-for-bbpress" ), 302 );
		}

		if ( 'post' === $type ) {
			$object = get_post( $id );
		}

		if ( empty( $object ) ) {
			bbp_ajax_response( false, esc_html__( "Favorite failed.", "gd-quantum-theme-for-bbpress" ), 303 );
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'toggle-favorite_' . $object->ID ) ) {
			bbp_ajax_response( false, esc_html__( "Request is not valid.", "gd-quantum-theme-for-bbpress" ), 304 );
		}

		$status = bbp_is_user_favorite( $user_id, $object->ID )
			? bbp_remove_user_favorite( $user_id, $object->ID )
			: bbp_add_user_favorite( $user_id, $object->ID );

		if ( empty( $status ) ) {
			bbp_ajax_response( false, esc_html__( "The request was unsuccessful. Please try again.", "gd-quantum-theme-for-bbpress" ), 305 );
		}

		$attrs = array(
			'object_id'   => $object->ID,
			'object_type' => $type,
			'user_id'     => $user_id
		);

		bbp_ajax_response( true, bbp_get_user_favorites_link( $attrs, $user_id, false ), 200 );
	}

	public function ajax_subscription() {
		if ( ! bbp_is_subscriptions_active() ) {
			bbp_ajax_response( false, esc_html__( "Subscriptions are not active.", "gd-quantum-theme-for-bbpress" ), 300 );
		}

		if ( ! is_user_logged_in() ) {
			bbp_ajax_response( false, esc_html__( "Please login to subscribe.", "gd-quantum-theme-for-bbpress" ), 301 );
		}

		$user_id = bbp_get_current_user_id();
		$id      = ! empty( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		$type    = ! empty( $_POST['type'] ) ? sanitize_key( $_POST['type'] ) : 'post';

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			bbp_ajax_response( false, esc_html__( "You do not have permission to do this.", "gd-quantum-theme-for-bbpress" ), 302 );
		}

		if ( 'post' === $type ) {
			$object = get_post( $id );
		}

		if ( empty( $object ) ) {
			bbp_ajax_response( false, esc_html__( "Subscription failed.", "gd-quantum-theme-for-bbpress" ), 303 );
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'toggle-subscription_' . $object->ID ) ) {
			bbp_ajax_response( false, esc_html__( "Request is not valid.", "gd-quantum-theme-for-bbpress" ), 304 );
		}

		$status = bbp_is_user_subscribed( $user_id, $object->ID )
			? bbp_remove_user_subscription( $user_id, $object->ID )
			: bbp_add_user_subscription( $user_id, $object->ID );

		if ( empty( $status ) ) {
			bbp_ajax_response( false, esc_html__( "The request was unsuccessful. Please try again.", "gd-quantum-theme-for-bbpress" ), 305 );
		}

		$attrs = array(
			'object_id'   => $object->ID,
			'object_type' => $type,
			'user_id'     => $user_id
		);

		bbp_ajax_response( true, bbp_get_user_subscribe_link( $attrs, $user_id, false ), 200 );
	}
}