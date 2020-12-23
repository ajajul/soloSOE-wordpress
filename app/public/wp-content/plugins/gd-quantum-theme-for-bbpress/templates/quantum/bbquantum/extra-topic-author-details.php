<?php

do_action( 'bbp_theme_before_topic_author_admin_details' );

$_ip = bbp_get_author_ip();

if ( ! empty( $_ip ) ) {
	echo '<div class="bbp-topic-ip">' . $_ip . '</div>';
}

do_action( 'bbp_theme_before_topic_author_admin_details' );
