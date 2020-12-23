<?php

if (!defined('ABSPATH')) exit;

$_classes = array(
    'd4p-wrap', 
    'wpv-'.D4PUPD_WPV, 
    'd4p-page-'.d4pupd_admin()->page,
    'd4p-panel',
    'd4p-panel-'.$_panel);

$_tabs = array(
    'whatsnew' => __("What&#8217;s New", "dev4press-updater"),
    'info' => __("Info", "dev4press-updater"),
    'changelog' => __("Changelog", "dev4press-updater"),
    'dev4press' => __("Dev4Press", "dev4press-updater")
);

?>

<div class="<?php echo join(' ', $_classes); ?>">
    <h1><?php printf(__("Welcome to Dev4Press Updater&nbsp;%s", "dev4press-updater"), d4pupd_settings()->info_version); ?></h1>
    <p class="d4p-about-text">
        Easy to use plugin to install new and update existing Dev4Press premium plugins and themes from within WordPress dashboard, using build in updater system.
    </p>
    <div class="d4p-about-badge" style="background-color: #2791D3;">
        <i class="d4p-icon d4p-logo-dev4press"></i>
        <?php printf(__("Version %s", "dev4press-updater"), d4pupd_settings()->info_version); ?>
    </div>

    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php

        foreach ($_tabs as $_tab => $_label) {
            echo '<a href="admin.php?page=dev4press-updater-about&panel='.$_tab.'" class="nav-tab'.($_tab == $_panel ? ' nav-tab-active' : '').'">'.$_label.'</a>';
        }

        ?>
    </h2>

    <div class="d4p-about-inner">