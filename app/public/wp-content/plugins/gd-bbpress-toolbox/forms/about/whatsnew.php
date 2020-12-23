<?php include(GDBBX_PATH.'forms/about/minor.php'); ?>

<div class="d4p-about-whatsnew">
    <div class="d4p-whatsnew-section d4p-whatsnew-heading">
        <div class="d4p-layout-grid">
            <div class="d4p-layout-unit whole align-center">
                <h2 style="font-size: 52px;">Topic Views</h2>
                <p class="lead-description">
                    Now available as new Features
                </p>
                <p>
                    The work continues on the unifying 'Features', this time bringing the various topics views registered by the plugin under the one roof as 'Custom Topic Views' feature with many more enhancements.
                </p>

                <?php if (isset($_GET['install']) && $_GET['install'] == 'on') { ?>
                    <a class="button-primary" href="admin.php?page=gd-bbpress-toolbox-wizard"><?php _e("Run Setup Wizard", "gd-bbpress-toolbox"); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="d4p-whatsnew-section">
        <div class="d4p-layout-grid">
            <div class="d4p-layout-unit half align-left">
                <h3>Custom Topic Views</h3>
                <p>
                    All custom topic views added by GD bbPress Toolbox Pro are now unified under the new 'Custom Topic Views' feature, with several additional views included and few new settings.
                </p>
                <p>
                    New version adds 3 new views to show only spammed, trashed and pending topics. And, there are new options to enable RSS feed option for public feeds, and option to include pending topics in the time based recent topics views.
                </p>
            </div>
            <div class="d4p-layout-unit half align-left">
                <img src="https://dev4press.s3.amazonaws.com/plugins/gd-bbpress-toolbox/6.2/about/views.jpg" />
            </div>
        </div>
    </div>

    <div class="d4p-whatsnew-section">
        <div class="d4p-layout-grid">
            <div class="d4p-layout-unit half align-left">
                <h3>Improved Performance</h3>
                <p>
                    The plugin cache subsystem has been improved and expanded to cache several more mass queries with the goal of improving the performance for the topics views and all other topics lists.
                </p>
                <p>
                    New use for cache is now included in the forums read tracking, aiming to improve performance on forum home page and in any forums list.
                </p>
            </div>
            <div class="d4p-layout-unit half align-left">
                <h3>Updates and Fixes</h3>
                <p>
                    As it is usual, new plugin update brings various improvements. This time, focus was on the tracking, user stats feature and overall plugin performance.
                </p>
                <p>
                    And, there are several important bugs fixed, including issues with private replies color coding, performance, tracking, user stats and few more things.
                </p>
            </div>
        </div>
    </div>
</div>
