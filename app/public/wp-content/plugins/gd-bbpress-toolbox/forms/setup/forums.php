<h3><?php _e("Individual forum settings", "gd-bbpress-toolbox"); ?></h3>
<?php

require_once(GDBBX_PATH.'core/admin/install.php');

$info = gdbbx_convert_forum_settings();

if ($info['forums'] > 0) {
    _e("Converted forum settings for", "gd-bbpress-toolbox");

    echo ': '.sprintf(_n("%s forum", "%s forums", $info['forums'], "gd-bbpress-toolbox"), $info['forums']).'.';
} else {
    _e("Nothing to convert.", "gd-bbpress-toolbox");
}

/**
?>
<h3><?php _e("Forums last post date", "gd-bbpress-toolbox"); ?></h3>
<?php

$info = gdbbx_forum_last_post_date();

if ($info['forums'] > 0) {
    _e("Updated last post date for", "gd-bbpress-toolbox");

    echo ': '.sprintf(_n("%s forum", "%s forums", $info['forums'], "gd-bbpress-toolbox"), $info['forums']).'.';
} else {
    _e("Nothing to update.", "gd-bbpress-toolbox");
}
*/
