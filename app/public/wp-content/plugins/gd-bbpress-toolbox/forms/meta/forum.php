<?php

use Dev4Press\Plugin\GDBBX\Basic\Features;

function gdbbx_select_forum_settings() {
    return array(
        'default' => __("Default", "gd-bbpress-toolbox"),
        'inherit' => __("Inherit", "gd-bbpress-toolbox"),
        'yes' => __("Yes", "gd-bbpress-toolbox"),
        'no' => __("No", "gd-bbpress-toolbox")
    );
}

function gdbbx_select_forum_override() {
    return array(
        'default' => __("Default", "gd-bbpress-toolbox"),
        'inherit' => __("Inherit", "gd-bbpress-toolbox"),
        'yes' => __("Override", "gd-bbpress-toolbox")
    );
}

global $post_ID, $_meta;

$tabs = apply_filters('gdbbx_admin_toolbox_meta', array(
    'attachments' => array('label' => __("Attachments", "gd-bbpress-toolbox"), 'icon' => 'paperclip'),
    'privacy' => array('label' => __("Privacy", "gd-bbpress-toolbox"), 'icon' => 'vault'),
    'locking' => array('label' => __("Forum Lock", "gd-bbpress-toolbox"), 'icon' => 'lock'),
    'closing' => array('label' => __("Auto Close Topics", "gd-bbpress-toolbox"), 'icon' => 'hidden')
));

if (!Features::instance()->is_enabled('private-topics') && !Features::instance()->is_enabled('private-replies')) {
    unset($tabs['privacy']);
}

if (!Features::instance()->is_enabled('lock-forums')) {
    unset($tabs['locking']);
}

if (!Features::instance()->is_enabled('auto-close-topics')) {
    unset($tabs['closing']);
}

$_meta = get_post_meta($post_ID, '_gdbbx_settings', true);

if (!is_array($_meta)) {
    $_meta = gdbbx_default_forum_settings();
} else {
    $_meta = wp_parse_args($_meta, gdbbx_default_forum_settings());
}

?>
<div class="d4plib-metabox-wrapper">
    <input type="hidden" name="gdbbx_forum_settings" value="edit" />

    <ul class="wp-tab-bar">
        <?php

        $active = true;
        foreach ($tabs as $tab => $obj) {
            $label = $obj['label'];
            $icon = $obj['icon'];

            echo '<li class="'.($active ? 'wp-tab-active' : '').'"><a href="#gdbbx-meta-'.$tab.'">';
            echo '<span aria-hidden="true" aria-labelledby="gdbbx-forums-metatab-'.$tab.'" class="dashicons dashicons-'.$icon.'" title="'.$label.'"></span>';
            echo '<span id="gdbbx-forums-metatab-'.$tab.'" class="d4plib-metatab-label">'.$label.'</span>';
            echo '</a></li>';

            $active = false;
        }

        ?>
    </ul>
    <?php

    $active = true;
    foreach ($tabs as $tab => $label) {
        echo '<div id="gdbbx-meta-'.$tab.'" class="wp-tab-panel '.($active ? 'tabs-panel-active' : 'tabs-panel-inactive').'">';

        do_action('gdbbx_admin_toolbox_forums_meta_content_'.$tab, $post_ID);

        echo '</div>';

        $active = false;
    }

    ?>
</div>
