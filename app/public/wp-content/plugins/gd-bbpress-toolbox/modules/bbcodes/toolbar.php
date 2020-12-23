<?php

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;

if (!defined('ABSPATH')) { exit; }

class gdbbx_mod_bbcodes_toolbar {
    function __construct() {
        add_action('bbp_theme_before_topic_form_content', array($this, 'display'), 10000);
        add_action('bbp_theme_before_reply_form_content', array($this, 'display'), 10000);

        add_action('gdbbx_core', array($this, 'load'));
    }

    public function load() {
        if (gdbbx()->get('bbcodes_toolbar_editor_fix', 'tools')) {
            add_filter('bbp_after_get_the_content_parse_args', array($this, 'editor_fix'));
        }
    }

    public function editor_fix($args) {
        $args['editor_class'].= ' gdbbx-editor-fix';

        return $args;
    }

    public function display() {
        echo '<div class="gdbbx-newpost-bbcodes">';

        $toolbar = new gdbbx_mod_bbcodes_toolbar_render();
        $toolbar->display();

        echo '</div>';
    }
}

class gdbbx_mod_bbcodes_toolbar_render {
    public $active = array();
    public $shortcodes = array();

    function __construct() { }

    public function display() {
        $this->active = gdbbx_module_bbcodes()->get_active_bbcodes();

        $this->codes();
        $this->render();

        Enqueue::instance()->toolbar();
    }

    private function render() {
        $class = 'gdbbx-bbcodes-toolbar gdbbx-buttonbar-size-'.gdbbx()->get('bbcodes_toolbar_size', 'tools');

        echo '<div role="toolbar" class="'.$class.'">';
            echo '<div class="gdbbx-buttonbar-inner">';

            do_action('gdbbx_bbcode_toolbar_buttons_before');

            $id = 1;
            foreach ($this->shortcodes as $code => $obj) {
                if (in_array($code, $this->active)) {
                    $this->button($code, $obj, $id);

                    $id++;
                }
            }

            do_action('gdbbx_bbcode_toolbar_buttons_after');

            echo '</div>';
        echo '</div>';
    }

    private function button($code, $obj, $id) {
        $button_id = 'gdbbx-button-'.$id;

        echo '<div id="'.$button_id.'" role="button" class="gdbbx-buttonbar-button gdbbx-buttonbar-button-'.$code.'" aria-labelledby="'.$button_id.'" aria-label="'.$obj['title'].'">';
            echo '<button class="gdbbx-button" role="presentation" type="button" title="'.$obj['title'].'" data-code="'.$code.'" data-bbcode="'.$obj['code'].'">'.$this->icon($code, $obj).'</button>';
        echo '</div>';
    }

    private function icon($code, $obj) {
        $icon = apply_filters('gdbbx_bbcode_toolbar_button_icon', false, $code, $obj);

        if ($icon !== false) {
            return $icon;
        }

        $class = "gdbbx-icon gdbbx-icon-".$obj['icon'];

        if ($code == 'br') {
            $class.= " gdbbx-rotate-90";
        }

        return '<i aria-hidden="true" class="'.$class.'"></i><span class="gdbbx-accessibility-show-for-sr">'.$obj['title'].'</span>';
    }

    private function codes() {
        $this->shortcodes = array(
            'b' => array('icon' => 'bold', 'title' => __("Bold", "gd-bbpress-toolbox"), 'code' => '(b){content}(/b)'),
            'i' => array('icon' => 'italic', 'title' => __("Italic", "gd-bbpress-toolbox"), 'code' => '(i){content}(/i)'),
            'u' => array('icon' => 'underline', 'title' => __("Underline", "gd-bbpress-toolbox"), 'code' => '(u){content}(/u)'),
            's' => array('icon' => 'strikethrough', 'title' => __("Strikethrough", "gd-bbpress-toolbox"), 'code' => '(s){content}(/s)'),
            'center' => array('icon' => 'align-center', 'title' => __("Align: Center", "gd-bbpress-toolbox"), 'code' => '(center){content}(/center)'),
            'right' => array('icon' => 'align-right', 'title' => __("Align: Right", "gd-bbpress-toolbox"), 'code' => '(right){content}(/right)'),
            'left' => array('icon' => 'align-left', 'title' => __("Align: Left", "gd-bbpress-toolbox"), 'code' => '(left){content}(/left)'),
            'justify' => array('icon' => 'align-justify', 'title' => __("Align: Justify", "gd-bbpress-toolbox"), 'code' => '(justify){content}(/justify)'),
            'sub' => array('icon' => 'subscript', 'title' => __("Subscript", "gd-bbpress-toolbox"), 'code' => '(sub){content}(/sub)'),
            'sup' => array('icon' => 'superscript', 'title' => __("Superscript", "gd-bbpress-toolbox"), 'code' => '(sup){content}(/sup)'),
            'br' => array('icon' => 'level-down', 'title' => __("Line Break", "gd-bbpress-toolbox"), 'code' => '(br)'),
            'hr' => array('icon' => 'minus', 'title' => __("Horizontal Line", "gd-bbpress-toolbox"), 'code' => '(hr)'),
            'size' => array('icon' => 'text-height', 'title' => __("Font Size", "gd-bbpress-toolbox"), 'code' => '(size size=\'{size}\'){content}(/size)'),
            'color' => array('icon' => 'tint', 'title' => __("Font Color", "gd-bbpress-toolbox"), 'code' => '(color color=\'{color}\'){content}(/color)'),
            'heading' => array('icon' => 'header', 'title' => __("Heading", "gd-bbpress-toolbox"), 'code' => '(heading){content}(/heading)'),
            'highlight' => array('icon' => 'pencil-square-o', 'title' => __("Highlight", "gd-bbpress-toolbox"), 'code' => '(highlight){content}(/highlight)'),
            'scode' => array('icon' => 'code', 'title' => __("Source Code", "gd-bbpress-toolbox"), 'code' => '(scode lang=\'{language}\'){content}(/scode)'),
            'pre' => array('icon' => 'terminal', 'title' => __("Preformatted", "gd-bbpress-toolbox"), 'code' => '(pre){content}(/pre)'),
            'blockquote' => array('icon' => 'quote-right', 'title' => __("Blockquote", "gd-bbpress-toolbox"), 'code' => '(blockquote){content}(/blockquote)'),
            'ol' => array('icon' => 'list-ol', 'title' => __("List: Ordered", "gd-bbpress-toolbox"), 'code' => '(ol){content}(/ol)'),
            'ul' => array('icon' => 'list-ul', 'title' => __("List: Unordered", "gd-bbpress-toolbox"), 'code' => '(ul){content}(/ul)'),
            'li' => array('icon' => 'list', 'title' => __("List: Item", "gd-bbpress-toolbox"), 'code' => '(li){content}(/li)'),
            'url' => array('icon' => 'external-link', 'title' => __("URL", "gd-bbpress-toolbox"), 'code' => '(url){url}(/url)'),
            'email' => array('icon' => 'envelope', 'title' => __("Email", "gd-bbpress-toolbox"), 'code' => '(email){email}(/email)'),
            'spoiler' => array('icon' => 'square', 'title' => __("Spoiler", "gd-bbpress-toolbox"), 'code' => '(spoiler){content}(/spoiler)'),
            'hide' => array('icon' => 'ban', 'title' => __("Hide", "gd-bbpress-toolbox"), 'code' => '(hide hide=\'reply\'){content}(/hide)'),
            'forum' => array('icon' => 'forum', 'title' => __("Forum", "gd-bbpress-toolbox"), 'code' => '(forum){id}(/forum)'),
            'topic' => array('icon' => 'topic', 'title' => __("Topic", "gd-bbpress-toolbox"), 'code' => '(topic){id}(/topic)'),
            'reply' => array('icon' => 'reply', 'title' => __("Reply", "gd-bbpress-toolbox"), 'code' => '(reply){id}(/reply)')
        );

        if (gdbbx()->get('bbcodes_toolbar_hide_image', 'tools') === false) {
            $this->shortcodes['img'] = array('icon' => 'picture-o', 'title' => __("Image", "gd-bbpress-toolbox"), 'code' => '(img){url}(/img)');
        }

        if (gdbbx()->get('bbcodes_toolbar_hide_video', 'tools') === false) {
            $this->shortcodes['youtube'] = array('icon' => 'youtube-square', 'title' => __("YouTube Video", "gd-bbpress-toolbox"), 'code' => '(youtube){url}(/youtube)');
            $this->shortcodes['vimeo'] = array('icon' => 'vimeo-square', 'title' => __("Vimeo Video", "gd-bbpress-toolbox"), 'code' => '(vimeo){url}(/vimeo)');
        }

        if (gdbbx()->get('bbcodes_toolbar_hide_rare', 'tools') === false) {
            $this->shortcodes['reverse'] = array('icon' => 'exchange', 'title' => __("Reverse", "gd-bbpress-toolbox"), 'code' => '(reverse){content}(/reverse)');
            $this->shortcodes['anchor'] = array('icon' => 'anchor', 'title' => __("Anchor", "gd-bbpress-toolbox"), 'code' => '(anchor anchor=\'{anchor}\'){content}(/anchor)');
            $this->shortcodes['border'] = array('icon' => 'square-o', 'title' => __("Border", "gd-bbpress-toolbox"), 'code' => '(border){content}(/border)');
            $this->shortcodes['area'] = array('icon' => 'arrows', 'title' => __("Area", "gd-bbpress-toolbox"), 'code' => '(area area=\'{title}\'){content}(/area)');
            $this->shortcodes['list'] = array('icon' => 'list-alt', 'title' => __("List", "gd-bbpress-toolbox"), 'code' => '(list){content}(/list)');
            $this->shortcodes['quote'] = array('icon' => 'quote-left', 'title' => __("Quote", "gd-bbpress-toolbox"), 'code' => '(quote){content}(/quote)');
            $this->shortcodes['nfo'] = array('icon' => 'pencil', 'title' => __("NFO", "gd-bbpress-toolbox"), 'code' => '(nfo title=\'{title}\'){content}(/nfo)');
        }

        if (gdbbx()->get('bbcodes_toolbar_hide_media', 'tools') === false) {
            $this->shortcodes['webshot'] = array('icon' => 'camera-retro', 'title' => __("Webshot", "gd-bbpress-toolbox"), 'code' => '(webshot width={width}){url}(/webshot)');
            $this->shortcodes['embed'] = array('icon' => 'plus-square', 'title' => __("Embed using oEmbed", "gd-bbpress-toolbox"), 'code' => '(embed){url}(/embed)');
            $this->shortcodes['google'] = array('icon' => 'google', 'title' => __("Google Search URL", "gd-bbpress-toolbox"), 'code' => '(google){content}(/google)');
        }

        if (gdbbx()->get('bbcodes_toolbar_hide_restricted', 'tools') === false) {
            $this->shortcodes['iframe'] = array('icon' => 'bookmark', 'title' => __("Iframe", "gd-bbpress-toolbox"), 'code' => '(iframe){url}(/iframe)');
            $this->shortcodes['note'] = array('icon' => 'file-o', 'title' => __("Hidden Note", "gd-bbpress-toolbox"), 'code' => '(note){content}(/note)');
        }

        if (gdbbx()->get('bbcodes_toolbar_show_available_only', 'tools')) {
            $_filtered = array();

            $active = gdbbx_module_bbcodes()->get_available_bbcodes();

            foreach ($active as $bbcode) {
                if (isset($this->shortcodes[$bbcode])) {
                    $_filtered[$bbcode] = $this->shortcodes[$bbcode];
                }
            }

            $this->shortcodes = $_filtered;
        }
    }
}
