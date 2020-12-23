<?php

namespace Dev4Press\Plugin\GDQNT\Theme\Walkers;

use BBP_Walker_Reply;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Reply extends BBP_Walker_Reply {
	public function start_lvl( &$output = '', $depth = 0, $args = array() ) {
		bbpress()->reply_query->reply_depth = (int) $depth + 1;

		$output .= "<li class='bbp-threaded-replies-wrapper'><ul class='bbp-threaded-replies'>\n";
	}

	public function end_lvl( &$output = '', $depth = 0, $args = array() ) {
		bbpress()->reply_query->reply_depth = (int) $depth + 1;

		$output .= "</li></ul>\n";
	}

	public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$depth ++;

		bbpress()->reply_query->reply_depth = (int) $depth;
		bbpress()->reply_query->post        = $object;
		bbpress()->current_reply_id         = $object->ID;

		if ( ! empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $object, $args, $depth );
			$output .= ob_get_clean();

			return;
		}

		$output .= bbp_buffer_template_part( 'loop', 'single-reply', false );
	}

	public function end_el( &$output = '', $object = false, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $object, $args, $depth );
			$output .= ob_get_clean();

			return;
		}
	}
}