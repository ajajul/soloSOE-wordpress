<div class="d4p-content">
    <div class="d4p-group d4p-group-import d4p-group-about">
        <h3><?php _e( "Theme Activation Control", "gd-quantum-theme-for-bbpress" ); ?></h3>
        <div class="d4p-group-inner">
			<?php if ( gdqnt()->is_quantum_active() ) { ?>
                <p><?php _e( "Quantum theme for bbPress is currently active and in use. If you want to disable it, and switch back to the bbPress Default, click the button below.", "gd-quantum-theme-for-bbpress" ); ?></p>
                <a href="<?php echo gdqnt_admin()->current_url( false, false ); ?>&gdqnt_handler=getback&action=deactivate-quantum" class="button-secondary" style="margin-top: 1em; padding: .5em 1em; height: auto; font-size: 1.2em;"><?php _e( "Deactivate Quantum Theme", "gd-quantum-theme-for-bbpress" ); ?></a>
			<?php } else { ?>
                <p><?php _e( "To activate Quantum Theme, you need to configure bbPress to use bbPress Quantum instead of the bbPress Default. You can do that from the bbPress plugin settings panel, or you can simply click the button below.", "gd-quantum-theme-for-bbpress" ); ?></p>
                <a href="<?php echo gdqnt_admin()->current_url( false, false ); ?>&gdqnt_handler=getback&action=activate-quantum" class="button-primary" style="margin-top: 1em; padding: .5em 1em; height: auto; font-size: 1.4em;"><?php _e( "Activate Quantum Theme", "gd-quantum-theme-for-bbpress" ); ?></a>
			<?php } ?>
        </div>
    </div>

    <div class="d4p-group d4p-group-import d4p-group-about">
        <h3><?php _e( "Custom Styles Transient Cache", "gd-quantum-theme-for-bbpress" ); ?></h3>
        <div class="d4p-group-inner">
            <p><?php _e( "If you create custom styling for Quantum using the Customizer, the plugin creates transient cache entries with the generated CSS.", "gd-quantum-theme-for-bbpress" ); ?></p>
            <p><?php printf( __( "Currently, there are %s transient rows in the database.", "gd-quantum-theme-for-bbpress" ), gdqnt_db()->count_custom_style_transients() ); ?></p>
            <a href="<?php echo gdqnt_admin()->current_url( false, false ); ?>&gdqnt_handler=getback&action=clear-cache" class="button-secondary" style="margin-top: 1em; padding: .25em 1em; height: auto; font-size: 1em;"><?php _e( "Delete all Cached Styles", "gd-quantum-theme-for-bbpress" ); ?></a>
        </div>
    </div>
</div>
