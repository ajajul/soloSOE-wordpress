<?php defined( 'ABSPATH' ) || exit; ?>

<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
    <label class="screen-reader-text hidden"
            for="bbp_search"><?php _e( "Search for:", "gd-quantum-theme-for-bbpress" ); ?></label>
    <input type="hidden" name="action" value="bbp-search-request"/>
    <input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>"
            name="bbp_search" id="bbp_search"/>
    <button tabindex="<?php bbp_tab_index(); ?>" type="submit" id="bbp_search_submit"
            aria-label="<?php esc_attr_e( "Search", "gd-quantum-theme-for-bbpress" ); ?>"><i
                class="gdqnt-icon gdqnt-icon-search"></i></button>
</form>
