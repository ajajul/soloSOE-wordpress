<?php defined( 'ABSPATH' ) || exit; ?>

<li id="post-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
    <div class="bbp-search-result-header">
        <div class="bbp-forum-title">

			<?php do_action( 'bbp_theme_before_forum_title' ); ?>

            <h3><?php esc_html_e( "Forum:", "gd-quantum-theme-for-bbpress" ); ?>
                <a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h3>

			<?php do_action( 'bbp_theme_after_forum_title' ); ?>

        </div>
    </div>
    <div class="bbp-item bbp-body">
        <div class="bbp-post-author">
        </div>
        <div class="bbp-post-wrapper">
            <div class="bbp-forum-content">

				<?php do_action( 'bbp_theme_before_forum_content' ); ?>

				<?php bbp_forum_content(); ?>

				<?php do_action( 'bbp_theme_after_forum_content' ); ?>

            </div>
        </div>
    </div>
</li>