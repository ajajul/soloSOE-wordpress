<?php defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'bbp_template_before_search_results_loop' ); ?>

    <div id="bbp-search-results" class="bbp-the-list bbp-list-content bbp-search-results">
        <div class="bbp-item bbp-header">
            <div class="bbp-item-info bbp-search-info"><?php _e( "Author", "gd-quantum-theme-for-bbpress" ); ?></div>
            <div class="bbp-item-meta bbp-search-meta">
                <div class="bbp-item-results bbp-search-results"><?php _e( "Search Results", "gd-quantum-theme-for-bbpress" ); ?></div>
            </div>
        </div>
        <div class="bbp-body">
            <ul class="bbp-items-list">
				<?php

				while ( bbp_search_results() ) : bbp_the_search_result();
					bbp_get_template_part( 'loop', 'search-' . get_post_type() );
				endwhile;

				?>
            </ul>
        </div>
    </div>

<?php do_action( 'bbp_template_after_search_results_loop' );