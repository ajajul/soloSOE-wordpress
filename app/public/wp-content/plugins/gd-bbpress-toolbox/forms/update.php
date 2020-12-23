<?php

if (!defined('ABSPATH')) { exit; }

$_classes = array('d4p-wrap', 'wpv-'.GDBBX_WPV, 'd4p-page-update');

?>
<div class="<?php echo join(' ', $_classes); ?>">
    <div class="d4p-header">
        <div class="d4p-plugin">
            GD bbPress Toolbox Pro
        </div>
    </div>
    <div class="d4p-content">
        <div class="d4p-content-left">
            <div class="d4p-panel-title">
                <i aria-hidden="true" class="fa fa-magic"></i>
                <h3><?php _e("Update", "gd-bbpress-toolbox"); ?></h3>
            </div>
            <div class="d4p-panel-info">
                <?php _e("Before you continue, make sure plugin was successfully updated.", "gd-bbpress-toolbox"); ?>
            </div>
        </div>
        <div class="d4p-content-right">
            <div class="d4p-update-info">
                <?php

                include(GDBBX_PATH.'forms/setup/db.php');
                include(GDBBX_PATH.'forms/setup/forums.php');
                include(GDBBX_PATH.'forms/setup/attachments.php');

                ?>

                <h3><?php _e("All Done", "gd-bbpress-toolbox"); ?></h3>
                <?php

                    gdbbx()->set('install', false, 'info');
                    gdbbx()->set('update', false, 'info', true);

                    _e("Update completed.", "gd-bbpress-toolbox");

                ?>
                <br/><br/><a class="button-primary" href="admin.php?page=gd-bbpress-toolbox-about"><?php _e("Click here to continue.", "gd-bbpress-toolbox"); ?></a>
            </div>
            <?php echo gdbbx_plugin()->recommend('update'); ?>
        </div>
    </div>
</div>
