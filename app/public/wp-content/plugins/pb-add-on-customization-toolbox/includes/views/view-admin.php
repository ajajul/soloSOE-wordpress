<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
    $settings = get_option( 'wppb_toolbox_admin_settings' );
?>

<form method="post" action="options.php">

    <?php settings_fields( 'wppb_toolbox_admin_settings' ); ?>

    <table class="form-table">

        <tr>
            <th><?php _e( 'Allow users with the \'delete_users\' capability to view the Admin Approval list', 'profile-builder' ); ?></th>

            <td>
                <label><input type="checkbox" name="wppb_toolbox_admin_settings[admin-approval-access]"<?php echo ( ( isset( $settings['admin-approval-access'] ) && ( $settings['admin-approval-access'] == 'yes' ) ) ? ' checked' : '' ); ?> value="yes">
                    <?php _e( 'Yes', 'profile-builder' ); ?>
                </label>

                <ul>
                    <li class="description">
                        <?php _e( 'By checking this option, you will allow users that have the \'delete_users\' capability to access and use the Admin Approval list.', 'profile-builder' ); ?>
                    </li>
                </ul>
            </td>
        </tr>

        <tr>
            <th><?php _e( 'Allow users with the \'delete_users\' capability to view the list of Unconfirmed Emails', 'profile-builder' ); ?></th>

            <td>
                <label><input type="checkbox" name="wppb_toolbox_admin_settings[email-confirmation-access]"<?php echo ( ( isset( $settings['email-confirmation-access'] ) && ( $settings['email-confirmation-access'] == 'yes' ) ) ? ' checked' : '' ); ?> value="yes">
                    <?php _e( 'Yes', 'profile-builder' ); ?>
                </label>

                <ul>
                    <li class="description">
                        <?php _e( 'By checking this option, you will allow users that have the \'delete_users\' capability to see the list of Unconfirmed Email Addresses.', 'profile-builder' ); ?>
                    </li>
                </ul>
            </td>
        </tr>

    </table>

    <?php submit_button( __( 'Save Changes', 'profile-builder' ) ); ?>

</form>
