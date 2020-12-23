<?php

if (!defined('ABSPATH')) {
    exit;
}

function gdbbx_admin_render_attachment_for_metabox($post_id, $attachment_id) {
    $file = get_attached_file($attachment_id);
    $filename = pathinfo($file, PATHINFO_BASENAME);

    $return = '<li class="gdbbx-attachment-id-'.$attachment_id.'">'.$filename.' - <span>';
    $return .= '<a target="_blank" href="'.admin_url('upload.php?item='.$attachment_id).'">'.__("edit", "gd-bbpress-toolbox").'</a>';
    $return .= ' | <a class="gdbbx-edit-attachment-detach" href="#" data-nonce="'.wp_create_nonce('gdbbx-det-'.$post_id.'-'.$attachment_id).'" data-id="'.$attachment_id.'" data-post="'.$post_id.'">'.__("detach", "gd-bbpress-toolbox").'</a>';
    $return .= ' | <a class="gdbbx-edit-attachment-delete" href="#" data-nonce="'.wp_create_nonce('gdbbx-del-'.$post_id.'-'.$attachment_id).'" data-id="'.$attachment_id.'" data-post="'.$post_id.'">'.__("delete", "gd-bbpress-toolbox").'</a>';
    $return .= '</span></li>';

    return $return;
}
