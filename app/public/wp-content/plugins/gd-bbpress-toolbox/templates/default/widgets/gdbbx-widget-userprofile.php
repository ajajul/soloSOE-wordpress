<div class="gdbbx-widget-the-profile-default">
    <?php if (is_user_logged_in()) : ?>

    <?php if ($instance['show_profile']) { ?>
        <h3 class="gdbbx-widget-profile-title">

        <?php bbp_user_profile_link(bbp_get_current_user_id()); ?>

        </h3>
    <?php } ?>

    <div class="gdbbx-widget-profile">
        <div class="__left">
            <a href="<?php echo esc_url(bbp_get_user_profile_url(bbp_get_current_user_id())); ?>">
                <?php echo get_avatar(bbp_get_current_user_id(), $instance['avatar_size']); ?>
            </a>

            <?php if ($instance['show_edit']) : ?>

            <a href="<?php echo esc_url(bbp_get_user_profile_edit_url(bbp_get_current_user_id())); ?>"><?php _e("edit profile", "gd-bbpress-toolbox"); ?></a>

            <?php endif; ?>

            <?php if ($instance['show_logout']) : ?>

            <a href="<?php echo wp_logout_url(); ?>"><?php _e("log out", "gd-bbpress-toolbox"); ?></a>

            <?php endif; ?>
        </div>
        <div class="__right">
            <?php if (!empty($profile)) : ?>

            <div class="__profile-stats">
                <h4><?php _e("Profile", "gd-bbpress-toolbox"); ?></h4>

                <ul>
                    <li><?php echo join('</li><li>', $profile); ?></li>
                </ul>
            </div>

            <?php endif; ?>

            <?php if (!empty($links)) : ?>

            <div class="__extended-links">
                <h4><?php _e("Important Links", "gd-bbpress-toolbox"); ?></h4>

                <ul>
                    <li><?php echo join('</li><li>', $links); ?></li>
                </ul>
            </div>

            <?php endif; ?>
        </div>
    </div>

    <?php else : ?>

    <div class="gdbbx-widget-profile-login">
        <h3><?php _e("Login and Registration", "gd-bbpress-toolbox"); ?></h3>

        <ul>
            <li><?php echo join('</li><li>', $login); ?></li>
        </ul>
    </div>

    <?php endif; ?>
</div>