<?php

function wppb_toolbox_flush_rewrite_rules() {
    $base = wppb_toolbox_get_settings( 'userlisting', 'modify-permalinks-single' );

    if ( $base == false ) return;

	$rules = get_option( 'rewrite_rules' );

	if ( !isset( $rules['(.+?)/' . $base . '/([^/]+)'] ) ) {
		global $wp_rewrite;

		$wp_rewrite->flush_rules();
	}
}
add_action( 'wp_loaded', 'wppb_toolbox_flush_rewrite_rules' );

function wppb_toolbox_insert_userlisting_rule( $rules ) {
    $base = wppb_toolbox_get_settings( 'userlisting', 'modify-permalinks-single' );

    if ( $base == false ) return $rules;

	$new_rule = array();

	$new_rule['(.+?)/'. $base .'/([^/]+)'] = 'index.php?pagename=$matches[1]&username=$matches[2]';

	return $new_rule + $rules;
}
add_filter( 'rewrite_rules_array', 'wppb_toolbox_insert_userlisting_rule' );

add_action('init', 'wppb_toolbox_remove_ul_rewrite_rules');
function wppb_toolbox_remove_ul_rewrite_rules() {
    remove_action( 'wp_loaded', 'wppb_flush_rewrite_rules' );
    remove_filter( 'rewrite_rules_array', 'wppb_insert_userlisting_rule' );
}

add_filter( 'wppb_userlisting_more_info_link_structure2', 'wppb_toolbox_modify_more_info_link', 20, 3 );
add_filter( 'wppb_userlisting_more_info_link_structure3', 'wppb_toolbox_modify_more_info_link', 20, 3 );
function wppb_toolbox_modify_more_info_link( $final_url, $url, $user_info ) {
    $base = wppb_toolbox_get_settings( 'userlisting', 'modify-permalinks-single' );

    if ( $base == false ) return $final_url;

    if ( apply_filters( 'wppb_userlisting_get_user_by_id', true ) )
        $new_url = trailingslashit( $url ) . $base . '/' . $user_info->ID;
    else
        $new_url = trailingslashit( $url ) . $base . '/' . $user_info;

    return $new_url;
}
