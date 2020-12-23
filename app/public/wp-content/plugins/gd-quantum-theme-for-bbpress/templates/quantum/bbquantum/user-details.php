<?php defined( 'ABSPATH' ) || exit; ?>

<div class="bbp-user-details-wrapper">
    <div id="bbp-user-avatar">
		<span class='vcard'>
			<a class="url fn n" href="<?php bbp_user_profile_url(); ?>"
                    title="<?php bbp_displayed_user_field( 'display_name' ); ?>" rel="me">
				<?php echo get_avatar( bbp_get_displayed_user_field( 'user_email', 'raw' ), apply_filters( 'bbp_single_user_details_avatar_size', 115 ) ); ?>
			</a>
		</span>
    </div>
    <div id="bbp-user-information">
        <h2><?php bbp_displayed_user_field( 'display_name' ); ?></h2>
        <h3>@<?php bbp_displayed_user_field( 'user_nicename' ); ?></h3>

        <div class="bbp-user-info-block">
            <p><?php printf( esc_html__( "Forum Role: %s", "gd-quantum-theme-for-bbpress" ), '<strong>' . bbp_get_user_display_role() . '</strong>' ); ?></p>
			<?php if ( gdqnt_customizer()->get( 'profile-show-registration-date' ) ) { ?>
                <p><?php printf( esc_html__( "Registered: %s", "gd-quantum-theme-for-bbpress" ), '<strong>' . bbp_get_time_since( bbp_get_displayed_user_field( 'user_registered' ) ) . '</strong>' ); ?></p>
			<?php } ?>
        </div>
    </div>
</div>
<div id="bbp-user-navigation">
    <nav>
        <ul><?php

			$links = gdqnt_theme()->user_profile_navigation();

			foreach ( $links as $link ) {
				?>
            <li class="<?php echo $link['current'] ? 'current' : ''; ?>"><span
                        class="<?php echo $link['class']; ?>"><a href="<?php echo $link['url']; ?>"><i
                                title="<?php echo $link['label']; ?>"
                                class="gdqnt-icon gdqnt-icon-<?php echo $link['icon']; ?>"></i><span> <?php echo $link['label']; ?></span></a></a></span>
                </li><?php

			}

			?></ul>
    </nav>
</div>