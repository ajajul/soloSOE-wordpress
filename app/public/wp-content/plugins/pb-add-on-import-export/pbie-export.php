<?php

/* include export class */
require_once 'inc/class-pbie-export.php';

/* add scripts */
add_action( 'admin_init', 'pbie_export_our_json' );

/* export class arguments and call */
function pbie_export_our_json() {
	if( isset( $_POST['cozmos-export'] ) ) {
		/* get Profile Builder version */
		if ( PROFILE_BUILDER == 'Profile Builder Pro' ) {
			$version = 'pro';
		} elseif( PROFILE_BUILDER == 'Profile Builder Hobbyist' ) {
			$version = 'hobbyist';
		}

		$pbie_args = array(
			'options' => array(
				// Admin Bar Settings
				'wppb_display_admin_settings',
				// General Settings
				'wppb_general_settings',
				// Content Restriction
				'wppb_content_restriction_settings',
				// Roles Editor
				'wppb_roles_editor_capabilities',
				// Serial Settings
				'wppb_profile_builder_'.$version.'_serial_status',
				'wppb_profile_builder_'.$version.'_serial',
				// Manage Fields
				'wppb_manage_fields',
				// Module Settings
				'wppb_module_settings',
				'wppb_module_settings_description',
				// Email Customizer Settings
				'wppb_emailc_common_settings_from_name',
				'wppb_emailc_common_settings_from_reply_to_email',
				// Email Customizer for Admins
				'wppb_admin_emailc_default_registration_email_subject',
				'wppb_admin_emailc_default_registration_email_content',
				'wppb_admin_emailc_registration_with_admin_approval_email_subject',
				'wppb_admin_emailc_registration_with_admin_approval_email_content',
				'wppb_admin_emailc_user_password_reset_email_subject',
				'wppb_admin_emailc_user_password_reset_email_content',
				// Email Customizer for Users
				'wppb_user_emailc_default_registration_email_subject',
				'wppb_user_emailc_default_registration_email_content',
				'wppb_user_emailc_registr_w_email_confirm_email_subject',
				'wppb_user_emailc_registr_w_email_confirm_email_content',
				'wppb_user_emailc_registration_with_admin_approval_email_subject',
				'wppb_user_emailc_registration_with_admin_approval_email_content',
				'wppb_user_emailc_admin_approval_notif_approved_email_subject',
				'wppb_user_emailc_admin_approval_notif_approved_email_content',
				'wppb_user_emailc_admin_approval_notif_unapproved_email_subject',
				'wppb_user_emailc_admin_approval_notif_unapproved_email_content',
				'wppb_user_emailc_reset_email_subject',
				'wppb_user_emailc_reset_email_content',
				'wppb_user_emailc_reset_success_email_subject',
				'wppb_user_emailc_reset_success_email_content',
				'wppb_user_emailc_change_email_address_subject',
				'wppb_user_emailc_change_email_address_content',
				// Custom Redirects
				'wppb_cr_user',
				'wppb_cr_role',
				'wppb_cr_global',
				'wppb_cr_default_wp_pages',
				'customRedirectSettings', // this is the old version of custom redirects, we only keep this for backwards compatibility
				// Private Website
				'wppb_private_website_settings',
				// Add-on: Multi-Step Forms
				'wppb_msf_options',
				'wppb_msf_break_points',
				'wppb_msf_tab_titles',
				// Add-on: Social Connect
				'wppb_social_connect_settings',
				// Add-on: bbPress
				'wppb_bbpress_settings',
				// Add-on: BuddyPress
				'wppb_buddypress_settings',
				// Add-on: Campaign Monitor
				'wppb_cmi_settings',
				'wppb_cmi_api_key_validated',
				// Add-on: MailChimp
				'wppb_mci_settings',
				'wppb_mailchimp_api_key_validated',
				// Add-on: WooSync
				'wppb_woosync_settings',
				// Add-on: Toolbox
				'wppb_toolbox_forms_settings',
				'wppb_toolbox_fields_settings',
				'wppb_toolbox_userlisting_settings',
				'wppb_toolbox_shortcodes_settings',
			),
			'cpts' => array(
				// User Listing
				'wppb-ul-cpt',
				// Register Forms
				'wppb-rf-cpt',
				// Edit Profile Forms
				'wppb-epf-cpt',
			)
		);

		pbie_add_repeater_meta_names($pbie_args);

		$pb_prefix = 'PB_';
		$pbie_json_export = new WPPB_IE_Export( $pbie_args );
		$pbie_json_export->download_to_json_format( $pb_prefix );
	}
}

/* Export tab content function */
function pbie_export() {
	?>
	<p><?php _e( 'Export Profile Builder options as a .json file. This allows you to easily import the configuration into another site.', 'profile-builder' ); ?></p>
	<div class="wrap">
		<form action="" method="post"><input class="button-secondary" type="submit" name="cozmos-export" value=<?php _e( 'Export', 'profile-builder' ); ?> id="cozmos-export" /></form>
	</div>
<?php
}

function pbie_add_repeater_meta_names( &$args ) {
	$fields = get_option('wppb_manage_fields');

	foreach ($fields as $field) {
		if ($field['field'] == 'Repeater')
			$args['options'][] = $field['meta-name'];
	}
}
