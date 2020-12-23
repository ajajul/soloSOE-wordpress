<?php defined( 'ABSPATH' ) || exit; ?>

<?php if ( bbp_allow_search() ) : ?>

    <div class="bbp-search-form">
        <form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
            <label class="screen-reader-text hidden"
                    for="ts"><?php _e( "Search for:", "gd-quantum-theme-for-bbpress" ); ?></label>
            <input type="hidden" name="action" value="bbp-search-request"/>
            <input tabindex="<?php bbp_tab_index(); ?>" type="text"
                    value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="ts" id="ts"/>
            <button tabindex="<?php bbp_tab_index(); ?>" type="submit" id="bbp_search_submit"
                    aria-label="<?php esc_attr_e( "Search", "gd-quantum-theme-for-bbpress" ); ?>"><i
                        class="gdqnt-icon gdqnt-icon-search"></i></button>
        </form>
    </div>

<?php endif;
