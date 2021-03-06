<?php

global $user_ID;

$post = get_post($post_id);
$author_id = $post->post_author;

if ((gdbbx()->get('errors_visible_to_author', 'attachments') == 1 && $author_id == $user_ID) || (gdbbx()->get('errors_visible_to_admins', 'attachments') == 1 && d4p_is_current_user_admin()) || (gdbbx()->get('errors_visible_to_moderators', 'attachments') == 1 && gdbbx_is_current_user_bbp_moderator())) {
    $errors = get_post_meta($post_id, "_bbp_attachment_upload_error");

    if (!empty($errors)) {
        echo '<ul style="list-style: decimal outside; margin-left: 1.5em;">';
        foreach ($errors as $error) {
            echo '<li><strong>'.esc_html($error["file"]).'</strong>:<br/>'.__($error["message"], "gd-bbpress-toolbox").'</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>'.__("No upload errors.", "gd-bbpress-toolbox").'</p>';
    }
} else {
    echo '<p>'.__("Nothing to show here.", "gd-bbpress-toolbox").'</p>';
}
