<?php defined( 'ABSPATH' ) || exit; ?>

<div>
    <label for="role"><?php esc_html_e( "Blog Role", "gd-quantum-theme-for-bbpress" ) ?></label>
	<?php bbp_edit_user_blog_role(); ?>
</div>

<div>
    <label for="forum-role"><?php esc_html_e( "Forum Role", "gd-quantum-theme-for-bbpress" ) ?></label>
	<?php bbp_edit_user_forums_role(); ?>
</div>
