/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.gdqnt = window.wp.gdqnt || {};

    window.wp.gdqnt.customizer = {
        overrides: [
            'light-gray-color-calc-border',
            'light-gray-color-calc-background',
            'light-gray-color-calc-text',
            'light-gray-color-calc-link',
            'light-gray-color-form-button-link',

            'classic-gray-divider-more',
            'classic-gray-color-calc-border',
            'classic-gray-color-calc-text',
            'classic-gray-color-calc-link',
            'classic-gray-border-radius',
            'classic-gray-color-form-button-link',

            'default-gray-color-form-background',
            'default-gray-color-form-border',
            'default-gray-color-form-text',
            'default-gray-color-form-link',
            'default-gray-color-form-search-border',
            'default-gray-color-form-button-link',
            'default-gray-color-list-header-background',
            'default-gray-color-list-header-text',
            'default-gray-color-list-row-background',
            'default-gray-color-list-row-text',
            'default-gray-color-list-row-link',
            'default-gray-color-post-author-background',
            'default-gray-color-post-author-text',
            'default-gray-color-post-author-link',
            'default-gray-color-action-banner-background',
            'default-gray-color-action-banner-text',
            'default-gray-color-action-banner-link',
            'default-gray-color-breadcrumbs-background',
            'default-gray-color-breadcrumbs-text',
            'default-gray-color-breadcrumbs-link',
            'default-gray-color-topic-tag-background',
            'default-gray-color-topic-tag-border',
            'default-gray-color-topic-tag-link'
        ],
        global: [
            'color-text',
            'color-link',
            'color-background',
            'color-common-background',
            'color-sticky-background',
            'color-super-sticky-background',
            'color-spam-background',
            'color-trash-background',
            'color-pending-background',
            'font-size',
            'line-height',
            'divider-color-theme',
            'divider-row-colors',
            'divider-typography-theme',
            'divider-extra-colors'
        ],
        style: function() {
            var i, style = $('#_customize-input-gdqnt-style').val(),
                style_scheme = $('#customize-control-gdqnt-color-scheme'),
                style_theme = $('#customize-control-gdqnt-color-theme'),
                theme = $('#_customize-input-gdqnt-color-theme').val(),
                controls = $('[id^=customize-control-gdqnt-theme-]');

            if (style === 'color-scheme') {
                style_scheme.show();
                style_theme.hide();
                controls.hide();
            } else if (style === 'custom-style') {
                style_scheme.hide();
                style_theme.show();
                controls.hide();

                controls.each(function(idx, ctrl) {
                    var id = ctrl.id, name = id.substring(30);

                    if ($.inArray(name, wp.gdqnt.customizer.global) !== -1) {
                        $(ctrl).show();
                    }
                });

                for (i = 0; i < wp.gdqnt.customizer.overrides.length; i++) {
                    var name = wp.gdqnt.customizer.overrides[i];

                    if (name.substring(0, theme.length) === theme) {
                        var field = 'gdqnt-theme-' + name + '-override';

                        if ($('#customize-control-' + field).length > 0) {
                            wp.gdqnt.customizer.override(wp.customize(field));
                        }
                    }
                }
            }
        },
        override: function(control) {
            var id = '#customize-control-' + control.id,
                value = control.get(),
                box = $(id), next = box.next();

            box.show();

            if (value === true) {
                next.show();
            } else {
                next.hide();
            }
        }
    };

    wp.customize.bind('ready', function() {
        var i;

        wp.customize('gdqnt-style', function(control) {
            control.bind(function(value) {
                wp.gdqnt.customizer.style();
            });
        });

        wp.customize('gdqnt-color-theme', function(control) {
            control.bind(function(value) {
                wp.gdqnt.customizer.style();
            });
        });

        for (i = 0; i < wp.gdqnt.customizer.overrides.length; i++) {
            var field = 'gdqnt-theme-' + wp.gdqnt.customizer.overrides[i] + '-override';

            wp.customize(field, function(control) {
                wp.gdqnt.customizer.override(control);

                control.bind(function(value) {
                    wp.gdqnt.customizer.override(control);
                });
            });
        }

        wp.gdqnt.customizer.style();
    });
})(jQuery, window, document);
