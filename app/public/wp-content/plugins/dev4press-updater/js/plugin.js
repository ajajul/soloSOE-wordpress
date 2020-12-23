/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global d4pupd_data*/
var d4pup_plugin;

;(function($, window, document, undefined) {
    d4pup_plugin = {
        init: function() {
            if (d4pupd_data.page === "products") {
                $(".dev4press-listed-plugins .d4pupd-single-plugin.d4pupd-plugin-status-not_found").prependTo(".dev4press-listed-plugins > div");
                $(".dev4press-listed-plugins .d4pupd-single-plugin.d4pupd-update-available").prependTo(".dev4press-listed-plugins > div");
            }

            $(".dev4press-switcher select").change(function(){
                var type = $(this).val();

                $(".d4p-content-right > div").hide();
                $(".d4p-content-right .dev4press-listed-" + type).fadeIn();
            });
        }
    };

    d4pup_plugin.init();
})(jQuery, window, document);
