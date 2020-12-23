<?php

$attachments = gdbbx_get_post_attachments($post_id);

if (empty($attachments)) {
    echo '<p>'.__("No attachments here.", "gd-bbpress-toolbox").'</p>';
} else {
    require_once(GDBBX_PATH.'core/functions/admin.php');

    echo '<ul style="list-style: decimal outside; margin-left: 1.5em;">';

    foreach ($attachments as $attachment) {
        echo gdbbx_admin_render_attachment_for_metabox($post_id, $attachment->ID);
    }

    echo '</ul>';
}

echo '<hr/>';

echo '<p>'.__("You can add more attachments using Media Library.", "gd-bbpress-toolbox").'</p>';

echo '<a class="button-primary gdbbx-edit-attachment-attach" data-nonce="'.wp_create_nonce('gdbbx-att-'.$post_id).'" data-post="'.$post_id.'" href="#">'.__("Add attachment", "gd-bbpress-toolbox").'</a><br/><br/>';
