<?php

/*
* Function that registers the settings for the bbPress options page
*
* @since v1.0.0
*
*/
function wppb_bbpress_register_settings() {
    register_setting( 'wppb_bbpress_settings', 'wppb_bbpress_settings', 'wppb_bbpress_settings_sanitize' );
}
if ( is_admin() ) {
    add_action('admin_init', 'wppb_bbpress_register_settings');
}

/**
 * Function that creates the "bbPress" submenu page
 *
 * @since v.1.0.0
 *
 * @return void
 */
function wppb_bbp_settings_submenu_page() {
    add_submenu_page( 'profile-builder', __( 'bbPress', 'profile-builder' ), __( 'bbPress', 'profile-builder' ), 'manage_options', 'profile-builder-bbpress', 'wppb_bbpress_settings_content' );
}
add_action( 'admin_menu', 'wppb_bbp_settings_submenu_page', 19 );  // this priority adds bbPress Sync below the Addons tab in PB menu


// set default values for bbPress settings page
function wppb_bbpress_settings_defaults(){
    $wppb_bbpress_settings = get_option( 'wppb_bbpress_settings', 'not_found' );

    $edit_profile_form = 'wppb-default-edit-profile';

    // Check Profile Builder version, display User Listing only for Pro
    if ( defined('PROFILE_BUILDER') && ( PROFILE_BUILDER == 'Profile Builder Pro' ) )
        $user_listing = 'Userlisting';
    else {
        $user_listing = '';
        update_option( 'wppb_bbpress_settings', array( 'UserListing' => $user_listing, 'EditProfileForm' => $edit_profile_form ) );
    }


    // set default values
    if ( $wppb_bbpress_settings == 'not_found' )
        update_option( 'wppb_bbpress_settings', array( 'UserListing' => $user_listing, 'EditProfileForm' => $edit_profile_form ) );

}


/**
 * Function that adds content to the "bbPress" submenu page
 *
 * @since v.1.0.0
 *
 * @return string
 */
function wppb_bbpress_settings_content() {

    // set default values for bbPress settings page
    wppb_bbpress_settings_defaults();

    ?>
    <div class="wrap wppb-wrap">
        <form method="post" action="options.php">
            <?php $wppb_bbpress_settings = get_option( 'wppb_bbpress_settings' ); ?>
            <?php settings_fields( 'wppb_bbpress_settings' ); ?>

            <h2><?php _e( 'bbPress Integration', 'profile-builder' ); ?></h2>

            <table class="form-table">

                <?php // Check Profile Builder version, display User Listing only for Pro
                if ( defined('PROFILE_BUILDER') && ( PROFILE_BUILDER == 'Profile Builder Pro' ) ) { ?>

                <tr>
                    <th scope="row">
                        <?php _e( 'Choose (Single) User Listing to display under bbPress user Profile tab:', 'profile-builder' ); ?>
                    </th>
                    <td>
                        <select name="wppb_bbpress_settings[UserListing]" class="wppb-select">
                            <option value=""> <?php _e( 'None', 'profile-builder' ); ?></option>
                            <?php
                            $args = array(
                                'post_type' => 'wppb-ul-cpt',
                                'post_status' => 'publish',
                                'numberposts' => -1,
                                'orderby' => 'date',
                                'order' => 'ASC'
                            );
                            $user_listings = get_posts( apply_filters( 'wppb_bbpress_user_listings_args', $args) );

                            foreach ( $user_listings as $key => $value ){
                                echo '<option value="'.$value->post_title.'"';
                                if ( isset($wppb_bbpress_settings['UserListing']) && ( $wppb_bbpress_settings['UserListing'] == $value->post_title ) )
                                    echo ' selected';

                                echo '>' . $value->post_title . '</option>';
                            }
                            ?>

                        </select>

                        <p class="description">
                            <?php _e( 'Select which Single User-listing managed via Profile Builder should replace the default bbPress user profile.', 'profile-builder' ); ?>
                        </p>
                    </td>
                </tr>
                <?php } ?>

                <tr>
                    <th scope="row">
                        <?php _e( 'Choose Edit Profile form to display under bbPress Profile Edit tab:', 'profile-builder' ); ?>
                    </th>
                    <td>
                        <select name="wppb_bbpress_settings[EditProfileForm]" class="wppb-select">
                            <option value=""> <?php _e( 'None', 'profile-builder' ); ?></option>
                            <option value="wppb-default-edit-profile" <?php if ( $wppb_bbpress_settings['EditProfileForm'] == 'wppb-default-edit-profile' ) echo 'selected'; ?>><?php _e( 'Default Edit Profile', 'profile-builder' ); ?></option>
                            <?php
                            $args = array(
                                'post_type' => 'wppb-epf-cpt',
                                'post_status' => 'publish',
                                'numberposts' => -1,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            $edit_profile_forms = get_posts( apply_filters( 'wppb_bbpress_edit_profile_forms_args', $args) );

                            foreach ( $edit_profile_forms as $key => $value ){
                                echo '<option value="'.$value->post_title.'"';
                                if ( $wppb_bbpress_settings['EditProfileForm'] == $value->post_title )
                                    echo ' selected';

                                echo '>' . $value->post_title . '</option>';
                            }
                            ?>

                        </select>

                        <p class="description">
                            <?php _e( 'Select Profile Builder Edit Profile form to replace the bbPress Profile Edit tab.', 'profile-builder' ); ?>
                        </p>
                    </td>
                </tr>


                <?php do_action( 'wppb_extra_bbpress_settings', $wppb_bbpress_settings ); ?>
            </table>


            <p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" /></p>
        </form>
    </div>

<?php
}

/*
 * Function that sanitizes the bbPress settings
 *
 * @param array $wppb_bbpress_settings
 *
 * @since v.1.0.0
 */
function wppb_bbpress_settings_sanitize( $wppb_bbpress_settings ) {

    $wppb_bbpress_settings = apply_filters( 'wppb_bbpress_settings_sanitize_extra', $wppb_bbpress_settings );

    return $wppb_bbpress_settings;
}


/*
 * Function that pushes settings errors to the user
 *
 * @since v.1.0.0
 */
function wppb_bbpress_settings_admin_notices() {
    settings_errors( 'wppb_bbpress_settings' );
}
add_action( 'admin_notices', 'wppb_bbpress_settings_admin_notices' );

