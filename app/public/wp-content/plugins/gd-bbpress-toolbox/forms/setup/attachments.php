<h3><?php _e("Attachments assignments", "gd-bbpress-toolbox"); ?></h3>
<?php

require_once(GDBBX_PATH.'core/admin/install.php');

$rows = gdbbx_convert_attachments_assignments();

if ($rows > 0) {
    _e("Attachments conversion completed.", "gd-bbpress-toolbox");
} else {
    _e("Nothing to convert.", "gd-bbpress-toolbox");
}
