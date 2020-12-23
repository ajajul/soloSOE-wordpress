/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

jQuery(document).ready(function($) {
    function gdqnt_menu_resizer(menu) {
        var l = 0, t = 0;

        if (menu.length === 1) {
            menu.removeClass('bbp-collapse-labels');

            $('li', menu).each(function() {
                l += $(this).outerWidth();
            });

            t = menu.parent().width();

            if (t <= l) {
                menu.addClass('bbp-collapse-labels');
            }
        }
    }

    $(document).on('click', '.bbp-dropdown-open', function(e) {
        e.preventDefault();
    });

    $(window).bind('load resize orientationchange', function() {
        gdqnt_menu_resizer($('#bbp-user-navigation ul'));
    });

    gdqnt_menu_resizer($('#bbp-user-navigation ul'));

    var wrapper = $('.bbpress-gdqnt-popup');

    if (wrapper.length === 1) {
        var title = $('form > fieldset > legend', wrapper).html();

        wrapper.data('title', title);

        wrapper.smartAniPopup({
            settings: {
                onLoad: false,
                zIndex: 100000,
                xContentSize: true,
                containerSelector: '#bbpress-forums',
                style: 'gdqnt-style-popup',
                effect: 'fade',
                height: 'auto',
                maxHeight: '80%',
                width: '90%',
                maxWidth: '720px',
                offsetX: '0px',
                offsetY: '0px',
                closeEscape: false,
                closeOverlay: false,
                footer: false,
                extraClass: 'gdqnt-popup-wrapper'
            }
        });

        $('#start-new-topic a, #start-new-reply a, a.bbp-topic-reply-link').click(function(e) {
            e.preventDefault();

            wrapper.smartAniPopup('open');
        });
    }
});
