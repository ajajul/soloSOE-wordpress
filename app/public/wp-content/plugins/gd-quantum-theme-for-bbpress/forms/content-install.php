<div class="d4p-content">
    <div class="d4p-update-info">
		<?php

		gdqnt_settings()->set( 'install', false, 'info' );
		gdqnt_settings()->set( 'update', false, 'info', true );

		?>

        <div class="d4p-install-block">
            <h3>
				<?php _e( "All Done", "gd-quantum-theme-for-bbpress" ); ?>
            </h3>
            <div>
				<?php _e( "Installation completed.", "gd-quantum-theme-for-bbpress" ); ?>
            </div>
        </div>

        <div class="d4p-install-confirm">
            <a class="button-primary" href="<?php echo d4p_panel()->a()->panel_url( 'about' ) ?>&install"><?php _e( "Click here to continue", "gd-quantum-theme-for-bbpress" ); ?></a>
        </div>
    </div>
	<?php echo gdqnt()->recommend( 'install' ); ?>
</div>