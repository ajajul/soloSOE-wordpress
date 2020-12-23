<?php

use Dev4Press\Plugin\GDBBX\Features\ForumIndex;

$statistics = gdbbx_get_statistics();
$roles = bbp_get_dynamic_roles();
$welcome = ForumIndex::instance();

$max = gdbbx_module_online()->max();

?>

<div class="d4p-group d4p-group-dashboard-card d4p-group-dashboard-users">
    <h3><?php _e("User Statistics", "gd-bbpress-toolbox"); ?></h3>
    <div class="d4p-group-stats">
        <ul>
            <li><a href="admin.php?page=gd-bbpress-toolbox-users">
                    <i aria-hidden="true" class="fa fa-users fa-fw"></i> 
                    <strong><?php echo $statistics['user_count']; ?></strong> 
                    <?php _e("Users", "gd-bbpress-toolbox"); ?></a>
            </li>
        </ul><div class="d4p-clearfix"></div>
        <hr/>
        <ul>
            <?php foreach ($statistics['user_roles_count'] as $role => $count) { ?>
                <li><a href="admin.php?page=gd-bbpress-toolbox-users&filter-role=<?php echo $role; ?>">
                    <i aria-hidden="true" class="fa fa-user fa-fw"></i> 
                    <strong><?php echo $count; ?></strong> 
                    <?php echo $roles[$role]['name']; ?></a>
            </li>
            <?php } ?>
        </ul><div class="d4p-clearfix"></div>
    </div>
    <div class="d4p-group-inner">
        <?php if (gdbbx()->get('track_last_activity_active', 'tools')) { ?>
            <h4><?php _e("Online Users", "gd-bbpress-toolbox"); ?></h4>

            <p>
                <?php echo sprintf(__("Most users ever online was <strong>%s</strong> on %s.", "gd-bbpress-toolbox"), $max['total']['count'], date_i18n(get_option('date_format').', '.get_option('time_format'), $max['total']['timestamp'])); ?>
            </p>

            <h4><?php _e("Users Activity", "gd-bbpress-toolbox"); ?></h4>

            <p><?php

            echo $welcome->users_list(10080, null, array('color' => true, 'avatar' => true, 'link' => true, 'wrapped' => true));

            ?></p>
            <p>
                <?php echo '<label>'.__("Legend", "gd-bbpress-toolbox").':</label> '.$welcome->user_roles_legend(); ?>
            </p>

        <?php } else { ?>

            <p><?php _e("Users activity tracking is disabled.", "gd-bbpress-toolbox"); ?></p>

        <?php } ?>
    </div>
    <div class="d4p-group-footer">
        <a href="admin.php?page=gd-bbpress-toolbox-users" class="button-primary"><?php _e("All Users", "gd-bbpress-toolbox"); ?></a>
    </div>
</div>
