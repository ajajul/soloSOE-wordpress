/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.gdbbx = window.wp.gdbbx || {};

    window.wp.gdbbx.toolbar = {
        init: function() {
            $(".gdbbx-editor-bbcodes").each(function(){
                wp.gdbbx.toolbar.run($(this), $(this));
            });

            $(".gdbbx-newpost-bbcodes").each(function(){
                wp.gdbbx.toolbar.run($(this), $(".bbp-the-content-wrapper"));
            });

            $(".gdbbx-signature.gdbbx-limiter-enabled").each(function(){
                wp.gdbbx.toolbar.limit($(this));
            });
        },
        run: function(toolbar, textarea) {
            $(".gdbbx-buttonbar-button button", toolbar).keypress(function(e){
                if (e.keyCode === 32 || e.keyCode === 13) {
                    e.preventDefault();

                    wp.gdbbx.toolbar.click(this, textarea);
                }
            });

            $(".gdbbx-buttonbar-button button", toolbar).click(function(e) {
                e.preventDefault();

                wp.gdbbx.toolbar.click(this, textarea);
            });
        },
        click: function(button, textarea) {
            var bbcode = $(button).data("bbcode");

            bbcode = bbcode.replace(/\(/g, "[")
                           .replace(/\)/g, "]")
                           .replace(/\'/g, '"');

            var wrap = {
                    content: bbcode.indexOf("{content}") > -1,
                    id: bbcode.indexOf("{id}") > -1,
                    url: bbcode.indexOf("{url}") > -1,
                    email: bbcode.indexOf("{email}") > -1
                },
                editor = $("textarea", textarea),
                selected = editor.textrange();

            if (selected.length > 0) {
                if (wrap.content) {
                    bbcode = bbcode.replace("{content}", selected.text);
                } else if (wrap.id) {
                    bbcode = bbcode.replace("{id}", selected.text);
                } else if (wrap.url) {
                    bbcode = bbcode.replace("{url}", selected.text);
                } else if (wrap.email) {
                    bbcode = bbcode.replace("{email}", selected.text);
                }
            }

            editor.textrange("replace", bbcode);
        },
        limit: function(textarea) {
            var args = {
                maxChars: $(textarea).data("chars"),
                maxCharsWarning: $(textarea).data("warning"),
                msgFontSize: "inherit",
                msgFontFamily: "inherit",
                msgFontColor: "inherit"
            };

            $(textarea).jqEasyCounter(args);
        }
    };

    $(document).ready(function() {
        wp.gdbbx.toolbar.init();
    });
})(jQuery, window, document);
