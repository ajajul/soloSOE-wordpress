<?php

/**
 * Single User Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="bbpress-forums">

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php do_action( 'bbp_template_before_user_wrapper' ); ?>

    <div id="bbp-user-wrapper">
        <div class="bbp-user-header">
			<?php bbp_get_template_part( 'user', 'details' ); ?>
        </div>
        <div class="bbp-user-page-content">
			<?php

			do_action( 'bbp_template_before_user_page_content' );

			if ( bbp_is_favorites() ) {
				bbp_get_template_part( 'user', 'favorites' );
			} else if ( bbp_is_subscriptions() ) {
				bbp_get_template_part( 'user', 'subscriptions' );
			} else if ( bbp_is_single_user_engagements() ) {
				bbp_get_template_part( 'user', 'engagements' );
			} else if ( bbp_is_single_user_topics() ) {
				bbp_get_template_part( 'user', 'topics-created' );
			} else if ( bbp_is_single_user_replies() ) {
				bbp_get_template_part( 'user', 'replies-created' );
			} else if ( bbp_is_single_user_edit() ) {
				bbp_get_template_part( 'form', 'user-edit' );
			} else if ( bbp_is_single_user_profile() ) {
				bbp_get_template_part( 'user', 'profile' );
			}

			do_action( 'bbp_template_after_user_page_content' );

			?>
        </div>
    </div>

	<?php do_action( 'bbp_template_after_user_wrapper' ); ?>

</div>
