jQuery( '#toolbox-bypass-ec' ).select2();

jQuery( '#toolbox-restricted-emails').select2({
    tags: true,
    width: '100%'
});

jQuery( '.wppb-toolbox-switch' ).on( 'click', function() {
    if ( jQuery(this).prop('checked') )
        jQuery( '.wppb-toolbox-accordion' ).show();
    else
        jQuery( '.wppb-toolbox-accordion' ).hide();
});

jQuery( '#wppb-toolbox-send-credentials-hide' ).on( 'click', function() {
    if ( jQuery(this).prop('checked') )
        jQuery( '#toolbox-send-credentials-text' ).parent().hide();
    else
        jQuery( '#toolbox-send-credentials-text' ).parent().show();
});

jQuery( '#wppb-toolbox-redirect-users-hide' ).on( 'click', function() {
    if ( jQuery(this).prop('checked') )
        jQuery( '#toolbox-redirect-users-url' ).parent().show();
    else
        jQuery( '#toolbox-redirect-users-url' ).parent().hide();
});

jQuery(document).ready( function() {
    if ( jQuery( '.wppb-toolbox-switch' ).prop( 'checked' ) )
        jQuery( '.wppb-toolbox-accordion' ).show();

    if ( jQuery( '#wppb-toolbox-send-credentials-hide' ).prop( 'checked' ) )
        jQuery( '#toolbox-send-credentials-text' ).parent().hide();

    if ( jQuery( '#wppb-toolbox-redirect-users-hide' ).prop( 'checked' ) )
        jQuery( '#toolbox-redirect-users-url' ).parent().show();
});
