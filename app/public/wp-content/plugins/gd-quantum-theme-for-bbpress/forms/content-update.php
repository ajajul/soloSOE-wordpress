<div class="d4p-content">
    <div class="d4p-update-info">
        <div class="d4p-install-block">
            <h4>
				<?php _e( "Transient cached styles", "gd-quantum-theme-for-bbpress" ); ?>
            </h4>
			<?php gdqnt_db()->delete_custom_style_transients(); ?>
			<?php _e( "Cleared", "gd-quantum-theme-for-bbpress" ); ?>
        </div>

		<?php

		gdqnt_settings()->set( 'install', false, 'info' );
		gdqnt_settings()->set( 'update', false, 'info', true );

		?>

        <div class="d4p-install-block">
            <h4>
				<?php _e( "All Done", "gd-quantum-theme-for-bbpress" ); ?>
            </h4>
            <div>
				<?php _e( "Update completed.", "gd-quantum-theme-for-bbpress" ); ?>
            </div>
        </div>

        <div class="d4p-install-confirm">
            <a class="button-primary" href="<?php echo d4p_panel()->a()->panel_url( 'about' ) ?>&update"><?php _e( "Click here to continue", "gd-quantum-theme-for-bbpress" ); ?></a>
        </div>
    </div>
	<?php echo gdqnt()->recommend( 'update' ); ?>
</div>