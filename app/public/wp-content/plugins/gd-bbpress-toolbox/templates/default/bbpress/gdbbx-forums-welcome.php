<div id="bbp-user-welcome" class="gdbbx-forum-index-block">
    <div class="gdbbx-forums-inner-block">
        <?php $_user_visit = gdbbx_forum_index()->user_visit(); ?>
        <h4><?php

            if ($_user_visit['timestamp'] > 0) {
                _e("Welcome back", "gd-bbpress-toolbox");
            } else {
                _e("Welcome", "gd-bbpress-toolbox");
            }

        ?></h4>

        <div>
            <p><?php

            if ($_user_visit['timestamp'] > 0) {
                echo sprintf(
                    __("There have been %s and %s since your last visit at %s on %s.", "gd-bbpress-toolbox"),
                    sprintf(_n("%s new topic", "%s new topics", $_user_visit['topics'], "gd-bbpress-toolbox"), $_user_visit['topics']),
                    sprintf(_n("%s new reply", "%s new replies", $_user_visit['replies'], "gd-bbpress-toolbox"), $_user_visit['replies']),
                    $_user_visit['time'],
                    $_user_visit['date']
                );
            }

            ?></p>

            <?php

            if (gdbbx_forum_index()->get_welcome('links')) {

            ?>

            <p><?php echo join(' &middot; ', gdbbx_forum_index()->user_links()); ?></p>

            <?php

            }

            ?>
        </div>
    </div>
</div>
