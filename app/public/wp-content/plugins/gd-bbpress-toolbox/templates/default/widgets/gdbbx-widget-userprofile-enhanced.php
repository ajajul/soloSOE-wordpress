<div class="gdbbx-widget-the-profile-enhanced">
    <?php if (is_user_logged_in()) : ?>

    <?php if ($instance['show_profile']) { ?>
        <h3 class="gdbbx-widget-profile-title">

        <?php bbp_user_profile_link(bbp_get_current_user_id()); ?>

        </h3>
    <?php } ?>

    <div class="gdbbx-widget-profile">
        <a href="<?php echo esc_url(bbp_get_user_profile_url(bbp_get_current_user_id())); ?>">
            <?php echo get_avatar(bbp_get_current_user_id(), $instance['avatar_size']); ?>
        </a>

        <?php

        $links_profile = array();

        if ($instance['show_edit']) {
            $links_profile[] = '<a href="'.esc_url(bbp_get_user_profile_edit_url(bbp_get_current_user_id())).'">'.__("edit profile", "gd-bbpress-toolbox").'</a>';
        }

        if ($instance['show_logout']) {
            $links_profile[] = '<a href="'.wp_logout_url().'">'.__("log out", "gd-bbpress-toolbox").'</a>';
        }

        if (!empty($links_profile)) {
        
        ?>

        <div class="__profile-links"><?php echo join(' &middot; ', $links_profile); ?></div>

        <?php } if (!empty($links_profile)) { ?>

        <div class="__extended-links">
            <?php echo join(' &middot; ', $links); ?>
        </div>

        <?php } if (!empty($profile)) { ?>

        <div class="__profile-stats">
            <ul>
                <li><?php echo join('</li><li>', $profile); ?></li>
            </ul>
        </div>

        <?php } ?>

    </div>

    <?php else : ?>

    <div class="gdbbx-widget-profile-login">
        <h3><?php _e("Login and Registration", "gd-bbpress-toolbox"); ?></h3>

        <div class="">
            <?php echo join(' &middot; ', $login); ?>
        </div>
    </div>

    <?php endif; ?>
</div>
