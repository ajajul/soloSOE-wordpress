<?php

use Dev4Press\Plugin\GDQNT\Theme\Walkers\Reply;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bbp_forum_new_topic_link() {
	echo bbp_get_forum_new_topic_link();
}

function bbp_get_forum_new_topic_link() {
	return '<span class="banner-button" id="start-new-topic"><a href="#new-post"><i title="' . esc_attr__( "New Topic", "gd-quantum-theme-for-bbpress" ) . '" class="gdqnt-icon gdqnt-icon-plus"></i> ' . __( "New Topic", "gd-quantum-theme-for-bbpress" ) . '</a></span>';
}

function bbp_topic_new_reply_link() {
	echo bbp_get_topic_new_reply_link();
}

function bbp_get_topic_new_reply_link() {
	return '<span class="banner-button" id="start-new-reply"><a href="#new-post"><i title="' . esc_attr__( "New Reply", "gd-quantum-theme-for-bbpress" ) . '" class="gdqnt-icon gdqnt-icon-plus"></i> ' . __( "New Reply", "gd-quantum-theme-for-bbpress" ) . '</a></span>';
}

function bbp_forum_topics_and_replies_counts( $forum_id = 0 ) {
	echo bbp_get_forum_topics_and_replies_counts( $forum_id );
}

function bbp_get_forum_topics_and_replies_counts( $forum_id = 0 ) {
	$forum_id = bbp_get_forum_id( $forum_id );

	$_topics  = bbp_get_forum_topic_count( $forum_id, true, true );
	$_replies = bbp_get_forum_reply_count( $forum_id, true, true );

	$display = __( "Topics", "gd-quantum-theme-for-bbpress" ) . ': ' . $_topics . ', ' . __( "Replies", "gd-quantum-theme-for-bbpress" ) . ': ' . $_replies;

	return apply_filters( 'bbp_get_forum_topics_and_replies_counts', $display, $forum_id );
}

function bbp_topic_voices_and_replies_counts( $topic_id = 0 ) {
	echo bbp_get_topic_voices_and_replies_counts( $topic_id );
}

function bbp_get_topic_voices_and_replies_counts( $topic_id = 0 ) {
	$topic_id = bbp_get_topic_id( $topic_id );

	$_voices  = bbp_get_topic_voice_count( $topic_id, true );
	$_replies = bbp_get_topic_reply_count( $topic_id, true );

	$display = __( "Voices", "gd-quantum-theme-for-bbpress" ) . ': ' . $_voices . ', ' . __( "Replies", "gd-quantum-theme-for-bbpress" ) . ': ' . $_replies;

	return apply_filters( 'bbp_get_topic_voices_and_replies_counts', $display, $topic_id );
}

function bbp_forum_last_activity_link( $forum_id = 0 ) {
	echo bbp_get_forum_last_activity_link( $forum_id );
}

function bbp_get_forum_last_activity_link( $forum_id = 0 ) {
	$link_url = '';
	$title    = '';

	$forum_id = bbp_get_forum_id( $forum_id );
	$topic_id = 0;

	$active_id = bbp_get_forum_last_reply_id( $forum_id );

	if ( empty( $active_id ) ) {
		$topic_id = bbp_get_reply_topic_id( $active_id );
	}

	if ( empty( $active_id ) ) {
		$active_id = bbp_get_forum_last_topic_id( $forum_id );
		$topic_id  = $active_id;
	}

	if ( bbp_is_topic( $active_id ) ) {
		$link_url = bbp_get_forum_last_topic_permalink( $forum_id );
		$title    = bbp_get_forum_last_topic_title( $forum_id );
	} else if ( bbp_is_reply( $active_id ) ) {
		$link_url = bbp_get_forum_last_reply_url( $forum_id );
		$title    = bbp_get_forum_last_topic_title( $topic_id );
	}

	$time_since = bbp_get_forum_last_active_time( $forum_id );

	if ( ! empty( $time_since ) && ! empty( $link_url ) ) {
		$anchor = '<a href="' . esc_url( $link_url ) . '">' . esc_html( $title ) . '</a>';
	} else {
		$anchor = esc_html__( "No Topics", "gd-quantum-theme-for-bbpress" );
	}

	return apply_filters( 'bbp_get_forum_last_activity_link', $anchor, $forum_id, $time_since, $link_url, $title, $active_id, $topic_id );
}

function bbp_forum_last_activity_date( $forum_id = 0 ) {
	echo bbp_get_forum_last_activity_date( $forum_id );
}

function bbp_get_forum_last_activity_date( $forum_id = 0, $gmt = false ) {
	$forum_id = bbp_get_forum_id( $forum_id );

	$active_id = bbp_get_forum_last_reply_id( $forum_id );

	if ( empty( $active_id ) ) {
		$active_id = bbp_get_forum_last_topic_id( $forum_id );
	}

	$date   = get_post_time( get_option( 'date_format' ), $gmt, $active_id, true );
	$time   = get_post_time( get_option( 'time_format' ), $gmt, $active_id, true );
	$result = sprintf( _x( '%1$s at %2$s', 'date at time', "gd-quantum-theme-for-bbpress" ), $date, $time );

	return apply_filters( 'bbp_get_forum_last_activity_date', $result, $forum_id, $active_id );
}

function bbp_forum_description( $forum_id = 0 ) {
	echo bbp_get_forum_description( $forum_id );
}

function bbp_get_forum_description( $forum_id = 0 ) {
	$forum_id = bbp_get_forum_id( $forum_id );

	$content = '';

	if ( $forum_id > 0 ) {
		$content = get_post_field( 'post_content', $forum_id );
	}

	return apply_filters( 'bbp_get_forum_description', $content, $forum_id );
}

function bbp_topics_archive_description( $args = array() ) {
	echo bbp_get_topics_archive_description( $args );
}

function bbp_get_topics_archive_description( $args = array() ) {
	$r = bbp_parse_args( $args, array(
		'before' => '<div class="bbp-template-notice info"><ul><li class="bbp-forum-description">',
		'after'  => '</li></ul></div>'
	), 'get_topics_archive_description' );

	$topics  = wp_count_posts( bbp_get_topic_post_type() );
	$replies = wp_count_posts( bbp_get_reply_post_type() );

	$topics_count        = $topics->publish + $topics->closed;
	$topics_hidden_count = $topics->pending + $topics->spam + $topics->trash;
	$replies_count       = $replies->publish;

	$url         = get_post_type_archive_link( bbp_get_topic_post_type() );
	$text_topics = sprintf( _n( "%s topic", "%s topics", $topics_count, "gd-quantum-theme-for-bbpress" ), $topics_count );

	$parts_topics = bbp_get_view_all( 'edit_others_topics' )
		? "<a href='" . esc_url( $url ) . "'>" . esc_html( $text_topics ) . "</a>"
		: esc_html( $text_topics );

	if ( $topics_hidden_count > 0 && current_user_can( 'edit_others_topics' ) ) {
		$text_hidden = sprintf( _n( "(+%s hidden)", "(+%s hidden)", $topics_hidden_count, "gd-quantum-theme-for-bbpress" ), $topics_hidden_count );

		$parts_topics .= ! bbp_get_view_all( 'edit_others_topics' )
			? " <a href='" . esc_url( bbp_add_view_all( $url, true ) ) . "'>" . esc_html( $text_hidden ) . "</a>"
			: " " . $text_hidden;
	}

	$parts_replies = '';
	if ( $replies_count > 0 ) {
		$parts_replies = sprintf( _n( "%s reply", "%s replies", $topics_count, "gd-quantum-theme-for-bbpress" ), $topics_count );
	}

	if ( $topics_count > 0 ) {
		if ( $replies_count == 0 ) {
			$retstr = sprintf( __( "Forums have %s.", "gd-quantum-theme-for-bbpress" ), $parts_topics );
		} else {
			$retstr = sprintf( __( "Forums have %s and %s.", "gd-quantum-theme-for-bbpress" ), $parts_topics, $parts_replies );
		}
	} else {
		$retstr = __( "There are not topics in the forums.", "gd-quantum-theme-for-bbpress" );
	}

	$retstr = $r['before'] . $retstr . $r['after'];

	return apply_filters( 'bbp_get_topics_archive_description', $retstr, $r, $args );
}

function gdqnt_list_threaded_replies( $args = array() ) {
	$bbp = bbpress();

	$bbp->reply_query->reply_depth = 0;
	$bbp->reply_query->in_the_loop = true;

	$r = bbp_parse_args( $args, array(
		'walker'       => new Reply(),
		'max_depth'    => bbp_thread_replies_depth(),
		'style'        => 'ul',
		'callback'     => null,
		'end_callback' => null,
		'page'         => 1,
		'per_page'     => - 1
	), 'list_replies' );

	echo $r['walker']->paged_walk( $bbp->reply_query->posts, $r['max_depth'], $r['page'], $r['per_page'], $r );

	$bbp->max_num_pages            = $r['walker']->max_pages;
	$bbp->reply_query->in_the_loop = false;
}
