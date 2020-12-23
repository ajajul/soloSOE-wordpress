<?php

if (!defined('ABSPATH')) { exit; }

$_classes = array(
    'd4p-wrap', 
    'wpv-'.GDBBX_WPV, 
    'd4p-page-'.gdbbx_admin()->page,
    'd4p-panel',
    'd4p-panel-'.$_panel);

$_tabs = array(
    'whatsnew' => __("What&#8217;s New", "gd-bbpress-toolbox"),
    'info' => __("Info", "gd-bbpress-toolbox"),
    'changelog' => __("Changelog", "gd-bbpress-toolbox"),
    'dev4press' => __("Dev4Press", "gd-bbpress-toolbox")
);

?>

<div class="<?php echo join(' ', $_classes); ?>">
    <h1><?php printf(__("Welcome to GD bbPress Toolbox&nbsp;%s", "gd-bbpress-toolbox"), gdbbx()->info_version); ?></h1>
    <p class="d4p-about-text">
        Expand bbPress powered forums with attachments upload, BBCodes support, signatures, widgets, quotes, toolbar menu, activity tracking, enhanced widgets, extra views...
    </p>
    <div class="d4p-about-badge" style="background-color: #224760;">
        <i class="d4p-icon d4p-plugin-icon-gd-bbpress-toolbox"></i>
        <?php printf(__("Version %s", "gd-bbpress-toolbox"), gdbbx()->info_version); ?>
    </div>

    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php

        foreach ($_tabs as $_tab => $_label) {
            echo '<a href="admin.php?page=gd-bbpress-toolbox-about&panel='.$_tab.'" class="nav-tab'.($_tab == $_panel ? ' nav-tab-active' : '').'">'.$_label.'</a>';
        }

        ?>
    </h2>

    <div class="d4p-about-inner">