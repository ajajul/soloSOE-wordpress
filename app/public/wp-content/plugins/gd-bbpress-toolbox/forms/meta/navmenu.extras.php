<?php

$views = array();

$_views = array(
    array('group' => 'general', 'name' => 'bbx-home', 'title' => __("Forums Home", "gd-bbpress-toolbox")),
    array('group' => 'profile', 'name' => 'bbx-profile', 'title' => __("Profile", "gd-bbpress-toolbox")),
    array('group' => 'profile', 'name' => 'bbx-topics', 'title' => __("Topics Started", "gd-bbpress-toolbox")),
    array('group' => 'profile', 'name' => 'bbx-replies', 'title' => __("Replies Created", "gd-bbpress-toolbox")),
    array('group' => 'profile', 'name' => 'bbx-favorites', 'title' => __("Favorites", "gd-bbpress-toolbox")),
    array('group' => 'profile', 'name' => 'bbx-subscriptions', 'title' => __("Subscriptions", "gd-bbpress-toolbox")),
    array('group' => 'profile', 'name' => 'bbx-edit', 'title' => __("Profile Edit", "gd-bbpress-toolbox")),
    array('group' => 'access', 'name' => 'bbx-login', 'title' => __("Login", "gd-bbpress-toolbox")),
    array('group' => 'access', 'name' => 'bbx-logout', 'title' => __("Logout", "gd-bbpress-toolbox")),
    array('group' => 'access', 'name' => 'bbx-register', 'title' => __("Register", "gd-bbpress-toolbox"))
);

foreach ($_views as $item) {
    $view = new stdClass();

    $view->classes = array();
    $view->type = $item['name'];
    $view->object_id = $item['name'];
    $view->title = $item['title'];
    $view->object = 'bbx-extra';

    $view->menu_item_parent = null;
    $view->url = null;
    $view->xfn = null;
    $view->db_id = null;
    $view->target = null;
    $view->attr_title = null;

    $views[$item['group']][$item['name']] = $view;
}

$walker = new Walker_Nav_Menu_Checklist(array());

?>
<div id="bbx-extra" class="posttypediv">
    <ul class="taxonomy-tabs add-menu-item-tabs" id="taxonomy-category-tabs">
        <li class="tabs"><?php _e("Extra Pages", "gd-bbpress-toolbox"); ?></li>
    </ul>
    <div id="tabs-panel-bbx-extra" class="tabs-panel tabs-panel-active">
        <h4><?php _e("General Links", "gd-bbpress-toolbox"); ?></h4>
        <ul id="bbx-extra-checklist" class="categorychecklist form-no-clear">
        <?php

            echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $views['general']), 0, (object) array('walker' => $walker));

        ?>
        </ul>

        <h4><?php _e("Logged user Profile", "gd-bbpress-toolbox"); ?></h4>
        <ul id="bbx-extra-checklist" class="categorychecklist form-no-clear">
        <?php

            echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $views['profile']), 0, (object) array('walker' => $walker));

        ?>
        </ul>

        <h4><?php _e("Account Access", "gd-bbpress-toolbox"); ?></h4>
        <ul id="bbx-extra-checklist" class="categorychecklist form-no-clear">
        <?php

            echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $views['access']), 0, (object) array('walker' => $walker));

        ?>
        </ul>
    </div>
</div>
<p class="button-controls">
    <span class="add-to-menu">
        <input type="submit" class="button-secondary submit-add-to-menu" value="<?php esc_attr_e("Add to Menu", "gd-bbpress-toolbox"); ?>" name="add-bbx-extra-menu-item" id="submit-bbx-extra" />
        <span class="spinner"></span>
    </span>
</p>