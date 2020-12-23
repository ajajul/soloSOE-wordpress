<?php

if (!defined('ABSPATH')) { exit; }

$panels = array(
    'index' => array(
        'title' => __("Tools Index", "gd-bbpress-toolbox"), 'icon' => 'wrench', 
        'info' => __("All plugin tools are split into several panels, and you access each starting from the right.", "gd-bbpress-toolbox")),
    'close' => array(
        'title' => __("Close Topics", "gd-bbpress-toolbox"), 'icon' => 'eye-slash', 
        'break' => __("bbPress", "gd-bbpress-toolbox"), 
        'button' => 'submit', 'button_text' => __("Close", "gd-bbpress-toolbox"),
        'info' => __("Using this tool, you can easily close old and inactive topics based on two criteria: when was topic created and when the topic was last active.", "gd-bbpress-toolbox")),
    'removeips' => array(
        'title' => __("Remove Logged IP's", "gd-bbpress-toolbox"), 'icon' => 'user-secret', 
        'button' => 'submit', 'button_text' => __("Remove", "gd-bbpress-toolbox"),
        'info' => __("Using this tool, you can remove all previously logged IP's from all the forum content.", "gd-bbpress-toolbox")),
    'standard' => array(
        'title' => __("Standard BBCodes", "gd-bbpress-toolbox"), 'icon' => 'pencil', 'type' => 'bbcodes',
        'break' => __("List of BBCodes", "gd-bbpress-toolbox"), 'button' => 'none',
        'info' => __("List of the standard BBCodes used for content formatting.", "gd-bbpress-toolbox")),
    'advanced' => array(
        'title' => __("Advanced BBCodes", "gd-bbpress-toolbox"), 'icon' => 'pencil-square-o', 'type' => 'bbcodes',
        'button' => 'none',
        'info' => __("List of the advanced BBCodes used embedding external content: videos, links...", "gd-bbpress-toolbox")),
    'restricted' => array(
        'title' => __("Restricted BBCodes", "gd-bbpress-toolbox"), 'icon' => 'pencil-square', 'type' => 'bbcodes',
        'button' => 'none',
        'info' => __("List of the restricted BBCodes that should not be available to regular users, and only administrators can choose to use them.", "gd-bbpress-toolbox")),
    'updater' => array(
        'title' => __("Recheck and Update", "gd-bbpress-toolbox"), 'icon' => 'refresh', 
        'break' => __("Maintenance", "gd-bbpress-toolbox"), 
        'button' => 'none', 'button_text' => '',
        'info' => __("Use this tool to recheck plugin database tables and update plugin settings if needed.", "gd-bbpress-toolbox")),
    'cleanup' => array(
        'title' => __("Data Cleanup", "gd-bbpress-toolbox"), 'icon' => 'trash', 
        'button' => 'submit', 'button_text' => __("Cleanup", "gd-bbpress-toolbox"),
        'info' => __("Using this tool, you can cleanup old and obsolete plugin data.", "gd-bbpress-toolbox")),
    'export' => array(
        'title' => __("Export Settings", "gd-bbpress-toolbox"), 'icon' => 'download', 
        'button' => 'button', 'button_text' => __("Export", "gd-bbpress-toolbox"),
        'link' => admin_url('admin.php?page=gd-bbpress-toolbox-tools&run=export&gdbbx_handler=getback&_ajax_nonce='.wp_create_nonce('dev4press-plugin-export')),
        'info' => __("Using this tool, you can export all plugin settings into JSON formatted file with compressed output.", "gd-bbpress-toolbox")),
    'import' => array(
        'title' => __("Import Settings", "gd-bbpress-toolbox"), 'icon' => 'upload', 
        'button' => 'submit', 'button_text' => __("Import", "gd-bbpress-toolbox"),
        'info' => __("Using this tool, you can import all plugin settings from valid export file.", "gd-bbpress-toolbox")),
    'remove' => array(
        'title' => __("Reset / Remove", "gd-bbpress-toolbox"), 'icon' => 'remove',
        'button' => 'submit', 'button_text' => __("Remove", "gd-bbpress-toolbox"),
        'info' => __("Using this tool, you can remove selected plugin settings, database tables and other information, and disable the plugin.", "gd-bbpress-toolbox"))
);

include(GDBBX_PATH.'forms/shared/top.php');

?>

<form method="post" action="" enctype="multipart/form-data">
    <?php settings_fields('gd-bbpress-toolbox-tools'); ?>
    <input type="hidden" value="<?php echo $_panel; ?>" name="gdbbxtools[panel]" />
    <input type="hidden" name="gdbbx_handler" value="postback" />

    <div class="d4p-content-left">
        <div class="d4p-panel-title">
            <i aria-hidden="true" class="fa fa-wrench"></i>
            <h3><?php _e("Tools", "gd-bbpress-toolbox"); ?></h3>
            <?php if ($_panel != 'index') { ?>
            <h4><i aria-hidden="true" class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
            <?php } ?>
        </div>
        <div class="d4p-panel-info">
            <?php echo $panels[$_panel]['info']; ?>
        </div>
        <?php if ($_panel != 'index' && $panels[$_panel]['button'] != 'none') { ?>
            <div class="d4p-panel-buttons">
                <?php if (isset($panels[$_panel]['link'])) { ?>
                    <a id="gdbbx-tool-<?php echo $_panel; ?>" class="button-primary" href="<?php echo $panels[$_panel]['link']; ?>"><?php echo $panels[$_panel]['button_text']; ?></a>
                <?php } else { ?>
                    <input id="gdbbx-tool-<?php echo $_panel; ?>" class="button-primary" type="<?php echo $panels[$_panel]['button']; ?>" value="<?php echo $panels[$_panel]['button_text']; ?>" />
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'admin.php?page=gd-bbpress-toolbox-'.$_page.'&panel='.$panel;

                if (isset($obj['break'])) { ?>

                    <div style="clear: both"></div>
                    <div class="d4p-panel-break d4p-clearfix">
                        <h4><?php echo $obj['break']; ?></h4>
                    </div>
                    <div style="clear: both"></div>

                <?php } ?>

                <div class="d4p-options-panel">
                    <i aria-hidden="true" class="fa fa-<?php echo $obj['icon']; ?>"></i>
                    <h5 aria-label="<?php echo $obj['info']; ?>" data-balloon-pos="up-left" data-balloon-length="large"><?php echo $obj['title']; ?></h5>
                    <div>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Open", "gd-bbpress-toolbox"); ?></a>
                    </div>
                </div>

                <?php
            }
        } else {
            if (isset($panels[$_panel]['type']) && $panels[$_panel]['type'] == 'bbcodes') {
                require_once(GDBBX_PATH.'core/functions/bbcodes.php');

                foreach (gdbbx_get_bbcodes_list() as $code => $obj) {
                    if ((!isset($obj['class']) && $_panel == 'standard') || (isset($obj['class']) && $obj['class'] == $_panel)) { ?>
                        <div class="d4p-group d4p-group-bbcodeslist">
                            <h3>[<?php echo $code; ?>] - <?php echo $obj['title']; ?></h3>
                            <div class="d4p-group-inner">
                                <?php echo join('<br/>', $obj['examples']); ?>
                            </div>
                        </div>
                    <?php }
                }
            } else {
                include(GDBBX_PATH.'forms/tools/'.$_panel.'.php');

                if ($_panel != 'index' && $_panel != 'export' && $panels[$_panel]['button'] != 'none') {

                    ?>

                    <div class="clear"></div>
                    <div style="padding-top: 15px; border-top: 1px solid #777; max-width: 800px;">
                        <input id="gdbbx-tool-<?php echo $_panel; ?>-sec" class="button-primary" type="<?php echo $panels[$_panel]['button']; ?>" value="<?php echo $panels[$_panel]['button_text']; ?>" />
                    </div>

                    <?php
                }
            }
        }

        ?>
    </div>
</form>

<?php 

include(GDBBX_PATH.'forms/shared/bottom.php');
