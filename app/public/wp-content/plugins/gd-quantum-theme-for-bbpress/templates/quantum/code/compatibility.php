<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bbp_get_public_topic_statuses' ) ) {
	function bbp_get_public_topic_statuses() {
		$statuses = array(
			bbp_get_public_status_id(),
			bbp_get_closed_status_id()
		);

		return (array) apply_filters( 'bbp_get_public_topic_statuses', $statuses );
	}
}

if ( ! function_exists( 'bbp_is_single_user_engagements' ) ) {
	function bbp_is_single_user_engagements() {
		return false;
	}
}

if ( ! function_exists( 'bbp_is_engagements_active' ) ) {
	function bbp_is_engagements_active() {
		return false;
	}
}
