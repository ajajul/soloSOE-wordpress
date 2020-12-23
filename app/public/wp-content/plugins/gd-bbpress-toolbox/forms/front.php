<?php

use Dev4Press\Plugin\GDBBX\Basic\Features;

if (!defined('ABSPATH')) { exit; }

include(GDBBX_PATH.'forms/shared/top.php');
include(GDBBX_PATH.'forms/shared/notices.php');

require_once(GDBBX_PATH.'core/functions/statistics.php');

?>

<div class="d4p-plugin-dashboard">
    <div class="d4p-content-left">
        <div class="d4p-dashboard-badge" style="background-color: #224760">
            <div aria-hidden="true" class="d4p-plugin-logo"><i class="d4p-icon d4p-plugin-icon-gd-bbpress-toolbox"></i></div>
            <h3>GD bbPress Toolbox Pro</h3>

            <h5>
                <?php 

                _e("Version", "gd-bbpress-toolbox");
                echo': '.gdbbx()->info->version;

                if (gdbbx()->info->status != 'stable') {
                    echo ' - <span class="d4p-plugin-unstable" style="color: #fff; font-weight: 900;">'.strtoupper(gdbbx()->info->status).'</span>';
                }

                ?>

            </h5>
        </div>

        <div class="d4p-buttons-group">
            <a class="button-secondary" href="admin.php?page=gd-bbpress-toolbox-features"><i aria-hidden="true" class="fa fa-puzzle-piece fa-fw"></i> <?php _e("Features", "gd-bbpress-toolbox"); ?></a>
            <a class="button-secondary" href="admin.php?page=gd-bbpress-toolbox-settings"><i aria-hidden="true" class="fa fa-cogs fa-fw"></i> <?php _e("Settings", "gd-bbpress-toolbox"); ?></a>
            <a class="button-secondary" href="admin.php?page=gd-bbpress-toolbox-attachments"><i aria-hidden="true" class="fa fa-paperclip fa-fw"></i> <?php _e("Attachments", "gd-bbpress-toolbox"); ?></a>
            <a class="button-secondary" href="admin.php?page=gd-bbpress-toolbox-tools"><i aria-hidden="true" class="fa fa-wrench fa-fw"></i> <?php _e("Tools", "gd-bbpress-toolbox"); ?></a>
        </div>

        <div class="d4p-buttons-group">
            <a class="button-secondary" href="admin.php?page=gd-bbpress-toolbox-about"><i aria-hidden="true" class="fa fa-info-circle fa-fw"></i> <?php _e("About", "gd-bbpress-toolbox"); ?></a>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        include(GDBBX_PATH.'forms/dashboard/basic.php');
        include(GDBBX_PATH.'forms/dashboard/users.php');

        ?>
        <div class="d4p-clearfix"></div>
        <?php

        if (Features::instance()->is_enabled('thanks')) {
            include(GDBBX_PATH.'forms/dashboard/thanks.php');
        }

        if (Features::instance()->is_enabled('report')) {
            include(GDBBX_PATH.'forms/dashboard/report.php');
        }

        ?>
        <div class="d4p-clearfix"></div>
        <?php ?>
    </div>
</div>

<?php 

include(GDBBX_PATH.'forms/shared/bottom.php');
