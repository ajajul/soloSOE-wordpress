<?php

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;

if (!defined('ABSPATH')) { exit; }

class gdbbx_mod_bbcodes {
    /** @var gdbbx_mod_bbcodes_scode */
    public $code;

    private $shortcodes = array();

    private $active_shortcodes = array();

    private $list_deactivated = array();
    private $list_advanced = array();
    private $list_restricted = array();

    private $list_to_strip = array();

    private $remove_advanced = false;
    private $remove_restricted = true;

    private $removal = 'info';
    private $notice = true;
    private $force_enqueue = false;
    private $bbpress_only = false;

    function __construct() {
        $this->bbpress_only = gdbbx()->get('bbcodes_bbpress_only', 'tools');

        $this->remove_advanced = !gdbbx()->allowed('bbcodes_special', 'tools', true);
        $this->remove_restricted = !(gdbbx()->get('bbcodes_restricted_super_admin', 'tools') && is_super_admin()) || (gdbbx()->get('bbcodes_restricted_administrator', 'tools') && d4p_is_current_user_admin());

        $this->list_deactivated = gdbbx()->get('bbcodes_deactivated', 'tools');

        $this->notice = gdbbx()->get('bbcodes_notice', 'tools');
        $this->removal = gdbbx()->get('bbcodes_special_action', 'tools');

        $this->_init();

        $list = array_keys($this->shortcodes);
        foreach ($list as $shortcode) {
            if (isset($this->shortcodes[$shortcode]['class'])) {
                $_list = 'list_'.$this->shortcodes[$shortcode]['class'];

                $this->{$_list}[] = $shortcode;
                $this->{$_list}[] = strtoupper($shortcode);
            }

            $deactivate = in_array($shortcode, $this->list_deactivated);

            $to_remove = apply_filters('gdbbx_bbcode_remove_'.$shortcode, $deactivate);
            $to_remove = apply_filters('gdbbx_bbcode_remove', $to_remove, $shortcode);

            if (!$to_remove) {
                add_shortcode($shortcode, array($this, 'shortcode_'.$shortcode));
                add_shortcode(strtoupper($shortcode), array($this, 'shortcode_'.$shortcode));

                $this->active_shortcodes[] = $shortcode;
            }

            $to_strip = apply_filters('gdbbx_bbcode_strip_'.$shortcode, false, $to_remove);
            $to_strip = apply_filters('gdbbx_bbcode_strip', $to_strip, $shortcode, $to_remove);

            if ($to_strip) {
                $this->list_to_strip[] = $shortcode;
                $this->list_to_strip[] = strtoupper($shortcode);
            }
        }

        if ($this->notice) {
            add_action('bbp_theme_before_reply_form_notices', array($this, 'show_notice'));
            add_action('bbp_theme_before_topic_form_notices', array($this, 'show_notice'));
        }

        $_filters = array(
            'bbp_new_reply_pre_insert', 
            'bbp_new_topic_pre_insert', 
            'bbp_edit_reply_pre_insert', 
            'bbp_edit_topic_pre_insert');

        if ($this->remove_advanced) {
            d4p_add_filter($_filters, array($this, 'content_strip_advanced'));
        }

        if ($this->remove_restricted) {
            d4p_add_filter($_filters, array($this, 'content_strip_restricted'));
        }

        if (!empty($this->list_to_strip)) {
            d4p_add_filter($_filters, array($this, 'content_strip_listed'));
        }

        add_filter('bbp_get_reply_content', 'do_shortcode');
        add_filter('bbp_get_topic_content', 'do_shortcode');

        add_action('gdbbx_template', array($this, 'load'));
    }

    public function load() {
        add_filter('gdbbx_script_values', array($this, 'script_values'));

        if (!in_array('scode', $this->list_deactivated)) {
            require_once(GDBBX_PATH.'modules/bbcodes/scode.php');

            $this->code = new gdbbx_mod_bbcodes_scode();
        }
    }

    public function script_values($values) {
        $values['load'][] = 'bbcodes';

        return $values;
    }

    public function get_available_bbcodes() {
        $list = array_diff($this->active_shortcodes, $this->list_deactivated);

        if ($this->remove_advanced) {
            $list = array_diff($list, $this->list_advanced);
        }

        if ($this->remove_restricted) {
            $list = array_diff($list, $this->list_restricted);
        }

        return array_values($list);
    }

    private function _init() {
        $this->shortcodes = array(
            'b' => array(
                'name' => __("Bold", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'i' => array(
                'name' => __("Italic", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'u' => array(
                'name' => __("Underline", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'args' => array('style' => 'text-decoration: underline;')
            ),
            's' => array(
                'name' => __("Strikethrough", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'center' => array(
                'name' => __("Align Center", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'args' => array('style' => 'text-align: center;')
            ),
            'right' => array(
                'name' => __("Align Right", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'args' => array('style' => 'text-align: right;')
            ),
            'left' => array(
                'name' => __("Align Left", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'args' => array('style' => 'text-align: left;')
            ),
            'justify' => array(
                'name' => __("Align Justify", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'args' => array('style' => 'text-align: justify;')
            ),
            'sub' => array(
                'name' => __("Subscript", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'sup' => array(
                'name' => __("Superscript", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'pre' => array(
                'name' => __("Preformatted", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 1)
            ),
            'scode' => array(
                'name' => __("Source Code", "gd-bbpress-toolbox"),
                'atts' => array('raw' => 0, 'lang' => 'text', 'line' => 1, 'gutter' => true, 'collapse' => true, 'class' => '', 'highlight' => '')
            ),
            'reverse' => array(
                'name' => __("Reverse", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'args' => array('dir' => 'rtl')
            ),
            'list' => array(
                'name' => __("List", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'ol' => array(
                'name' => __("List: Ordered", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'ul' => array(
                'name' => __("List: Unordered", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'li' => array(
                'name' => __("List: Item", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'blockquote' => array(
                'name' => __("Blockquote", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'area' => array(
                'name' => __("Area", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'border' => array(
                'name' => __("Border", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'div' => array(
                'name' => __("Block", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'br' => array(
                'name' => __("Line Break", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '')
            ),
            'hr' => array(
                'name' => __("Horizontal Line", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '')
            ),
            'anchor' => array(
                'name' => __("Anchor", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '')
            ),
            'size' => array(
                'name' => __("Font Size", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'color' => array(
                'name' => __("Font Color", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'quote' => array(
                'name' => __("Quote", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'postquote' => array(
                'name' => __("Post Quote", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'quote' => 0, 'raw' => 0)
            ),
            'hide' => array(
                'name' => __("Hide", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'spoiler' => array(
                'name' => __("Spoiler", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'color' => '', 'hover' => '', 'raw' => 0)
            ),
            'highlight' => array(
                'name' => __("Highlight", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'color' => '', 'background' => '', 'raw' => 0)
            ),
            'heading' => array(
                'name' => __("Heading", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'size' => '', 'raw' => 0)
            ),
            'forum' => array(
                'name' => __("Link Forum", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'topic' => array(
                'name' => __("Link Topic", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'reply' => array(
                'name' => __("Link Reply", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0)
            ),
            'url' => array(
                'name' => __("URL", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'target' => '_blank', 'rel' => '', 'raw' => 0),
                'class' => 'advanced'
            ),
            'email' => array(
                'name' => __("eMail", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'raw' => 0),
                'class' => 'advanced'
            ),
            'nfo' => array(
                'name' => __("NFO", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'title' => ''),
                'class' => 'advanced'
            ),
            'embed' => array(
                'name' => __("Embed", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'width' => '', 'height' => ''),
                'class' => 'advanced'
            ),
            'google' => array(
                'name' => __("Google Search", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'target' => '_blank', 'rel' => '', 'raw' => 0),
                'class' => 'advanced'
            ),
            'img' => array(
                'name' => __("Image", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'alt' => '', 'title' => '', 'width' => '', 'height' => '', 'float' => ''),
                'class' => 'advanced'
            ),
            'attachment' => array(
                'name' => __("Attachment", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'file' => '', 'target' => '_blank', 'rel' => '', 'alt' => '', 'title' => '', 'width' => '', 'height' => '', 'align' => 'alignnone', 'autoplay' => false, 'loop' => false),
                'class' => 'advanced'
            ),
            'webshot' => array(
                'name' => __("Webshot", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'alt' => '', 'title' => '', 'width' => ''),
                'class' => 'advanced'
            ),
            'youtube' => array(
                'name' => __("YouTube Video", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'width' => '', 'height' => ''),
                'class' => 'advanced'
            ),
            'vimeo' => array(
                'name' => __("Vimeo Video", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'width' => '', 'height' => ''),
                'class' => 'advanced'
            ),
            'note' => array(
                'name' => __("Note", "gd-bbpress-toolbox"),
                'atts' => array('raw' => 0),
                'class' => 'restricted'
            ),
            'iframe' => array(
                'name' => __("iframe", "gd-bbpress-toolbox"),
                'atts' => array('style' => '', 'class' => '', 'width' => '', 'height' => '', 'frameborder' => 0),
                'class' => 'restricted'
            )
        );
    }

    private function _args($code) {
        return isset($this->shortcodes[$code]['args']) ? $this->shortcodes[$code]['args'] : array();
    }

    private function _atts($code, $atts = array()) {
        if (isset($atts[0])) {
            $atts[$code] = substr($atts[0], 1);
            unset($atts[0]);
        }

        $default = $this->shortcodes[$code]['atts'];
        $default[$code] = '';

        if ($code == 'spoiler') {
            $default['color'] = gdbbx()->get('bbcodes_spoiler_color', 'tools');
            $default['hover'] = gdbbx()->get('bbcodes_spoiler_hover', 'tools');
        } else if ($code == 'highlight') {
            $default['color'] = gdbbx()->get('bbcodes_highlight_color', 'tools');
            $default['background'] = gdbbx()->get('bbcodes_highlight_background', 'tools');
        } else if ($code == 'heading') {
            $default['size'] = gdbbx()->get('bbcodes_heading_size', 'tools');
        }

        $atts = shortcode_atts($default, $atts);

        return $atts;
    }

    private function _merge($atts, $args, $attributes = array()) {
        foreach ($atts as $key => $value) {
            if (isset($attributes[$key]) && ($key == 'class' || $key == 'style')) {
                $attributes[$key].= ' '.$value;
            } else {
                $attributes[$key] = $value;
            }
        }

        foreach ($args as $key => $value) {
            if (isset($attributes[$key]) && ($key == 'class' || $key == 'style')) {
                $attributes[$key].= ' '.$value;
            } else {
                $attributes[$key] = $value;
            }
        }

        return $attributes;
    }

    private function _content($content, $raw = false) {
        if ($raw) {
            return $content;
        } else {
            return do_shortcode($content);
        }
    }

    private function _tag($tag, $name, $content = null, $atts = array(), $args = array(), $no_class = false) {
        $standard = $no_class ? array() : array('class' => 'gdbbx-bbcode-'.$name);
        $attributes = $this->_merge($atts, $args, $standard);

        $render = '<'.$tag;

        foreach ($attributes as $key => $value) {
            if (trim($value) != '' && $key != 'raw' && $key != $name) {
                $render.= ' '.$key.'="'.trim($value).'"';
            }
        }

        if (is_null($content)) {
            $render.= ' />';
        } else {
            $raw = isset($atts['raw']) && $atts['raw'] == 1;

            $render.= '>';
            $render.= $this->_content($content, $raw);
            $render.= '</'.$tag.'>';
        }

        if (!$this->force_enqueue) {
            Enqueue::instance()->core();
        }

        return $render;
    }

    private function _simple($code, $tag, $name, $atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts($code, $atts);
        $args = $this->_args($code);

        return $this->_tag($tag, $name, $content, $atts, $args);
    }

    private function _regex($list) {
	$tagregexp = join('|', $list);

	return    '\\['
		. '(\\[?)'
		. "($tagregexp)"
		. '\\b'
		. '('
		.     '[^\\]\\/]*'
		.     '(?:'
		.         '\\/(?!\\])'
		.         '[^\\]\\/]*'
		.     ')*?'
		. ')'
		. '(?:'
		.     '(\\/)'
		.     '\\]'
		. '|'
		.     '\\]'
		.     '(?:'
		.         '('
		.             '[^\\[]*+'
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])'
		.                 '[^\\[]*+'
		.             ')*+'
		.         ')'
		.         '\\[\\/\\2\\]'
		.     ')?'
		. ')'
		. '(\\]?)';

    }

    private function _strip($m) {
        if ($this->removal == 'info') {
            return '[blockquote]'.__("BBCode you used is not allowed.", "gd-bbpress-toolbox").'[/blockquote]';
        } else {
            return '';
        }
    }

    private function _webshot($url, $width = 0) {
        $_url = is_ssl() ? 'https' : 'http';
        $_url.= '://s.wordpress.com/mshots/v1/'.urlencode($url);

        if ($width > 0) {
            $_url.= '?w='.$width;
        }

        return $_url;
    }

    private function _content_cleanup($content) {
        $clean = trim($content, " \t\n\r\0\x0B{}");
        $clean = preg_replace("/(^\s+)|(\s+$)/us", '', $clean);

        return $clean;
    }

    public function get_active_bbcodes() {
        return $this->active_shortcodes;
    }

    public function strip_advanced($content) {
        $pattern = $this->_regex(apply_filters('gdbbx_bbcodes_advanced_list', $this->list_advanced));
        return preg_replace_callback("/$pattern/s", array($this, '_strip'), $content);
    }

    public function strip_restricted($content) {
        $pattern = $this->_regex(apply_filters('gdbbx_bbcodes_restricted_list', $this->list_restricted));
        return preg_replace_callback("/$pattern/s", array($this, '_strip'), $content);
    }

    public function strip_listed($content) {
        $pattern = $this->_regex(apply_filters('gdbbx_bbcodes_stripped_list', $this->list_to_strip));
        return preg_replace_callback("/$pattern/s", array($this, '_strip'), $content);
    }

    public function content_strip_advanced($reply_data) {
        $reply_data['post_content'] = $this->strip_advanced($reply_data['post_content']);
        return $reply_data;
    }

    public function content_strip_restricted($reply_data) {
        $reply_data['post_content'] = $this->strip_restricted($reply_data['post_content']);
        return $reply_data;
    }

    public function content_strip_listed($reply_data) {
        $reply_data['post_content'] = $this->strip_listed($reply_data['post_content']);
        return $reply_data;
    }

    public function show_notice() {
        $messages = array(
            apply_filters('gdbbx_notice_bbcodes_message_format', __("You can use BBCodes to format your content.", "gd-bbpress-toolbox"))
        );

        if ($this->remove_advanced) {
            $messages[] = apply_filters('gdbbx_notice_bbcodes_message_advanced', __("Your account can't use Advanced BBCodes, they will be stripped before saving.", "gd-bbpress-toolbox"));
        }

        $notice = '<div class="bbp-template-notice"><p>'.join('<br/>', $messages).'</p></div>';

        echo apply_filters('gdbbx_notice_bbcodes_status', $notice, $messages);
    }

    public function shortcode_b($atts, $content = null) {
        return $this->_simple('b', 'strong', 'bold', $atts, $content);
    }

    public function shortcode_i($atts, $content = null) {
        return $this->_simple('i', 'em', 'italic', $atts, $content);
    }

    public function shortcode_u($atts, $content = null) {
        return $this->_simple('u', 'span', 'underline', $atts, $content);
    }

    public function shortcode_s($atts, $content = null) {
        return $this->_simple('s', 'del', 'strikethrough', $atts, $content);
    }

    public function shortcode_right($atts, $content = null) {
        return $this->_simple('right', 'div', 'align-right', $atts, $content);
    }

    public function shortcode_center($atts, $content = null) {
        return $this->_simple('center', 'div', 'align-center', $atts, $content);
    }

    public function shortcode_left($atts, $content = null) {
        return $this->_simple('left', 'div', 'align-left', $atts, $content);
    }

    public function shortcode_justify($atts, $content = null) {
        return $this->_simple('justify', 'div', 'align-justify', $atts, $content);
    }

    public function shortcode_sub($atts, $content = null) {
        return $this->_simple('sub', 'sub', 'sub', $atts, $content);
    }

    public function shortcode_sup($atts, $content = null) {
        return $this->_simple('sup', 'sup', 'sup', $atts, $content);
    }

    public function shortcode_scode($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $args = array('class' => array(), 'raw' => 1);

        $atts = $this->_atts('scode', $atts);
        $atts['class'] = trim('gdbbx-bbcode-scode '.$atts['class']);

        $lang = strtolower($atts['lang']);

        if (isset($this->code) && is_object($this->code)) {
            $this->code->enqueue();

            if (!$this->code->is_brush_valid($lang)) {
                $lang = 'text';
            }
        }

        $args['class'][] = "brush: ".$lang;
        $args['class'][] = "first-line: ".absint($atts['line']);
        $args['class'][] = "gutter: ".($atts['gutter'] == 'true' ? 'true' : 'false');
        $args['class'][] = "class-name: '".d4p_sanitize_html_classes($atts['class'])."'";

        if (!empty($atts['highlight'])) {
            $highlight = explode(',', $atts['highlight']);
            $highlight = array_map('trim', $highlight);
            $highlight = array_map('absint', $highlight);
            $highlight = array_filter($highlight);

            if (!empty($highlight)) {
                $args['class'][] = 'highlight: ['.join(',', $highlight).']';
            }
        }

        $args['class'] = join('; ', $args['class']);

        return $this->_tag('pre', 'pre', $content, $args, array(), true);
    }

    public function shortcode_pre($atts, $content = null) {
        return $this->_simple('pre', 'pre', 'pre', $atts, $content);
    }

    public function shortcode_border($atts, $content = null) {
        return $this->_simple('border', 'fieldset', 'border', $atts, $content);
    }

    public function shortcode_reverse($atts, $content = null) {
        return $this->_simple('reverse', 'bdo', 'reverse', $atts, $content);
    }

    public function shortcode_blockquote($atts, $content = null) {
        return $this->_simple('blockquote', 'blockquote', 'blockquote', $atts, $content);
    }

    public function shortcode_heading($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('heading', $atts);
        $size = absint($atts['size']);

        if ($size < 1 || $size > 6) {
            $size = 3;
        }

        $tag = 'h'.$size;

        unset($atts['size']);

        return $this->_tag($tag, 'heading', $content, $atts);
    }

    public function shortcode_highlight($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('highlight', $atts);
        $args = array('style' => 'color: '.$atts['color'].'; background: '.$atts['background']);

        unset($atts['color']);
        unset($atts['background']);

        return $this->_tag('span', 'highlight', $content, $atts, $args);
    }

    public function shortcode_spoiler($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('spoiler', $atts);
        $args = array('style' => 'color: '.$atts['color'].'; background: '.$atts['color'], 'data-color' => $atts['color'], 'data-hover' => $atts['hover']);

        unset($atts['color']);
        unset($atts['hover']);

        return $this->_tag('span', 'spoiler', $content, $atts, $args);
    }

    public function shortcode_list($atts, $content = null) {
        return $this->_simple('list', 'ol', 'ol', $atts, $content);
    }

    public function shortcode_ol($atts, $content = null) {
        return $this->_simple('ol', 'ol', 'ol', $atts, $content);
    }

    public function shortcode_ul($atts, $content = null) {
        return $this->_simple('ul', 'ul', 'ul', $atts, $content);
    }

    public function shortcode_li($atts, $content = null) {
        return $this->_simple('li', 'li', 'li', $atts, $content);
    }

    public function shortcode_div($atts, $content = null) {
        return $this->_simple('div', 'div', 'div', $atts, $content);
    }

    public function shortcode_size($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('size', $atts);
        $args = isset($this->shortcodes['size']['args']) ? $this->shortcodes['size']['args'] : array();

        if ($atts['size'] != '') {
            $args['style'] = 'font-size: '.$atts['size'];

            if (is_numeric($atts['size'])) {
                $args['style'].= 'px';
            }

            unset($atts['size']);
        }

        return $this->_tag('span', 'font-size', $content, $atts, $args);
    }

    public function shortcode_color($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('color', $atts);
        $args = isset($this->shortcodes['color']['args']) ? $this->shortcodes['color']['args'] : array();

        if ($atts['color'] != '') {
            $args['style'] = 'color: '.$atts['color'];

            unset($atts['color']);
        }

        return $this->_tag('span', 'font-color', $content, $atts, $args);
    }

    public function shortcode_area($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('area', $atts);
        $args = $this->_args('area');

        if ($atts['area'] != '') {
            $content = '<legend>'.$atts['area'].'</legend>'.$content;
        }

        return $this->_tag('fieldset', 'area', $content, $atts, $args);
    }

    public function shortcode_anchor($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('anchor', $atts);
        $args = $this->_args('anchor');

        if ($atts['anchor'] != '') {
            $args['name'] = $atts['anchor'];
        }

        return $this->_tag('a', 'anchor', $content, $atts, $args);
    }

    public function shortcode_br($atts) {
        $atts = $this->_atts('br', $atts);

        return $this->_tag('br', 'br', null, $atts);
    }

    public function shortcode_hr($atts) {
        $atts = $this->_atts('hr', $atts);

        return $this->_tag('hr', 'hr', null, $atts);
    }

    public function shortcode_postquote($atts) {
        $atts = $this->_atts('postquote', $atts);

        $quote = absint($atts['quote']);
        $post = get_post($quote);

        if ($post && (bbp_is_topic($quote) || bbp_is_reply($quote))) {
            $url = '';
            $ath = '';
            $title = '';
            $content = '';
            $private = false;
            $header = gdbbx()->get('bbcodes_quote_title', 'tools');

            if (bbp_is_topic($quote)) {
                $url = get_permalink($quote);
                $ath = $header == 'user' ? bbp_get_topic_author_display_name($quote) : '#'.$quote;
                $private = !gdbbx_is_user_allowed_to_topic($quote);
            } else if (bbp_is_reply($quote)) {
                $url = bbp_get_reply_url($quote);
                $ath = $header == 'user' ? bbp_get_reply_author_display_name($quote) : '#'.$quote;
                $private = !gdbbx_is_user_allowed_to_reply($quote);
            }

            if (!empty($url) && $header != 'hide') {
                $full = $header == 'user' ? $ath.' '.__("wrote", "gd-bbpress-toolbox") : $ath;
                $title = '<div class="gdbbx-quote-title"><a href="'.$url.'">'.$full.':</a></div>';
            }

            if ($private) {
                $content = __("This quote contains content marked as private.", "gd-bbpress-toolbox");

                $atts['class'] = 'gdbbx-quote-is-private';
            } else {
                gdbbx()->set_inside_content_shortcode($quote);

                if (bbp_is_topic($quote)) {
                    $content = bbp_get_topic_content($quote);
                } else if (bbp_is_reply($quote)) {
                    $content = bbp_get_reply_content($quote);
                }

                gdbbx()->set_inside_content_shortcode($quote, false);
            }

            return $this->_tag('blockquote', 'quote', $title.$content, $atts);
        }

        return '';
    }

    public function shortcode_quote($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('quote', $atts);

        $title = '';
        $private = false;
        $header = gdbbx()->get('bbcodes_quote_title', 'tools');
        if ($atts['quote'] != '' && $header != 'hide') {
            $url = '';
            $ath = '';

            $id = absint($atts['quote']);

            if (bbp_is_topic($id)) {
                $url = get_permalink($id);
                $ath = $header == 'user' ? bbp_get_topic_author_display_name($id) : '#'.$id;
                $private = !gdbbx_is_user_allowed_to_topic($id);
            } else if (bbp_is_reply($id)) {
                $url = bbp_get_reply_url($id);
                $ath = $header == 'user' ? bbp_get_reply_author_display_name($id) : '#'.$id;
                $private = !gdbbx_is_user_allowed_to_reply($id);
            }

            if (!empty($url)) {
                $full = $header == 'user' ? $ath.' '.__("wrote", "gd-bbpress-toolbox") : $ath;
                $title = '<div class="gdbbx-quote-title"><a href="'.$url.'">'.$full.':</a></div>';
            }
        }

        if ($private) {
            $content = __("This quote contains content marked as private.", "gd-bbpress-toolbox");

            $atts['class'] = 'gdbbx-quote-is-private';
        }

        return $this->_tag('blockquote', 'quote', $title.$content, $atts);
    }

    public function shortcode_nfo($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('nfo', $atts);
        $title = $atts['title'] == '' ? 'NFO' : $atts['title'];

        $render = '<table class="gdbbx-bbcode-nfo '.$atts['class'].'" style="'.$atts['style'].'"><tbody><tr><td class="gdbbx-bbcode-el-title">'.$title.':</td></tr>';
        $render.= '<tr><td class="gdbbx-bbcode-el-content"><pre>'.$content.'</pre></td></tr></tbody></table>';

        return $render;
    }

    public function shortcode_reply($atts, $content = null) {
        $atts = $this->_atts('reply', $atts);

        $label = '';
        if ($atts['reply'] != '') {
            $id = absint($atts['reply']);

            if (is_string($content)) {
                $label = $content;
            }
        } else {
            $id = $content;
        }

        $atts['href'] = get_permalink($id);

        if ($label == '') {
            $label = $atts['href'];
        }

        return $this->_tag('a', 'reply-link', $label, $atts);
    }

    public function shortcode_topic($atts, $content = null) {
        $atts = $this->_atts('topic', $atts);

        $label = '';
        if ($atts['topic'] != '') {
            $id = absint($atts['topic']);

            if (is_string($content)) {
                $label = $content;
            }
        } else {
            $id = $content;
        }

        $atts['href'] = get_permalink($id);

        if ($label == '') {
            $label = $atts['href'];
        }

        return $this->_tag('a', 'topic-link', $label, $atts);
    }

    public function shortcode_forum($atts, $content = null) {
        $atts = $this->_atts('v', $atts);

        $label = '';
        if ($atts['forum'] != '') {
            $id = absint($atts['forum']);

            if (is_string($content)) {
                $label = $content;
            }
        } else {
            $id = $content;
        }

        $atts['href'] = get_permalink($id);

        if ($label == '') {
            $label = $atts['href'];
        }

        return $this->_tag('a', 'forum-link', $label, $atts);
    }

    public function shortcode_hide($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('hide', $atts);

        $count = 0;
        if ($atts['hide'] != '') {
            if ($atts['hide'] == 'reply') {
                $count = -1;
            } else if ($atts['hide'] == 'thanks') {
                $count = -2;
            } else {
                $count = absint($atts['hide']);
            }
        }

        $template = '';

        $topic = bbp_get_topic_id();
        $user = bbp_get_current_user_id();

        if (is_user_logged_in()) {
            if (bbp_is_user_keymaster() && gdbbx()->get('bbcodes_hide_keymaster_always_allowed', 'tools')) {
                $to_hide = false;
            } else if ($user == bbp_get_topic_author_id()) {
                $to_hide = false;
            } else if ($count == -2) {
                $template = gdbbx()->get('bbcodes_hide_content_thanks', 'tools');

                $to_hide = !gdbbx_check_if_user_said_thanks_to_topic($topic, $user);
            } else if ($count == -1) {
                $template = gdbbx()->get('bbcodes_hide_content_reply', 'tools');

                $to_hide = !gdbbx_check_if_user_replied_to_topic($topic, $user);
            } else if ($count > 0) {
                $total = bbp_get_user_reply_count_raw(bbp_get_current_user_id()) +
                         bbp_get_user_topic_count_raw(bbp_get_current_user_id());

                $to_hide = $count > $total;

                if ($to_hide) {
                    $_tpl = gdbbx()->get('bbcodes_hide_content_count', 'tools');
                    $template = str_replace('%post_count%', $count, $_tpl);
                }
            } else {
                $to_hide = false;
            }
        } else {
            $template = gdbbx()->get('bbcodes_hide_content_normal', 'tools');

            $to_hide = true;
        }

        $render = '<div class="gdbbx-bbcode-hide gdbbx-hide-'.($to_hide ? 'hidden' : 'visible').'">';
        $render.= '<div class="gdbbx-hide-title">'.gdbbx()->get('bbcodes_hide_title', 'tools').'</div>';
        $render.= '<div class="gdbbx-hide-content">';

        if ($to_hide) {
            $render.= do_shortcode(__($template, "gd-bbpress-toolbox"));
        } else {
            $render.= do_shortcode($content);
        }

        $render.= '</div></div>';

        return $render;
    }

    public function shortcode_embed($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('embed', $atts);
        $content = $this->_content_cleanup($content);

        if ($atts['embed'] != '') {
            $parts = explode('x', $atts['embed'], 2);

            if (count($parts) == 2) {
                $args['width'] = absint($parts[0]);
                $args['height'] = absint($parts[1]);
            }
        }

        $data = array();
        if ($atts['width'] > 0) {
            $data['width'] = $atts['width'];
        }

        if ($atts['height'] > 0) {
            $data['height'] = $atts['height'];
        }

        global $wp_embed;
        return $wp_embed->shortcode($data, $content);
    }

    public function shortcode_url($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('url', $atts);
        $content = $this->_content_cleanup($content);

        $args = $this->_args('url');

        if ($atts['url'] != '') {
            $args['href'] = str_replace(array('"', "'"), '', $atts['url']);
        } else {
            $args['href'] = $content;
        }

        return $this->_tag('a', 'url', $content, $atts, $args);
    }

    public function shortcode_email($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('email', $atts);
        $content = $this->_content_cleanup($content);

        $args = $this->_args('email');

        if ($atts['email'] != '') {
            $args['href'] = $atts['email'];
        } else {
            $args['href'] = $content;
            $content = antispambot($content);
        }

        $args['href'] = 'mailto:'.antispambot($args['href'], 1);

        return $this->_tag('a', 'url', $content, $atts, $args);
    }

    public function shortcode_webshot($atts, $content = null) {
        if (is_null($content) || $content == '') {
            return '';
        }

        $atts = $this->_atts('webshot', $atts);
        $content = $this->_content_cleanup($content);

        $args = $this->_args('webshot');
        $args['src'] = $this->_webshot($content, $args['width']);

        $image = $this->_tag('img', 'image', null, $atts, $args);
        return $this->_tag('a', 'url', $image, $atts, array('href' => $args['src']));
    }

    public function shortcode_img($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('img', $atts);
        $content = $this->_content_cleanup($content);

        $args = $this->_args('img');
        $args['src'] = $content;

        if ($atts['img'] != '') {
            $parts = explode('x', $atts['img'], 2);

            if (count($parts) == 2) {
                $args['width'] = absint($parts[0]);
                $args['height'] = absint($parts[1]);
            }
        }

        if ($atts['float'] == 'left' || $atts['float'] == 'right') {
            $atts['style'].= ';float:'.$atts['float'].';';
        }

        unset($atts['float']);

        return $this->_tag('img', 'image', null, $atts, $args);
    }

    public function shortcode_google($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('google', $atts);

        $args = isset($this->shortcodes['google']['args']) ? $this->shortcodes['google']['args'] : array();

        $protocol = is_ssl() ? 'https' : 'http';
        $link = $protocol.'://www.google.';

        if ($atts['google'] != '') {
            $link.= $atts['google'];
        } else {
            $link.= 'com';
        }

        $link.= '/search?q='.urlencode($content);

        $args['href'] = $link;

        return $this->_tag('a', 'google', $content, $atts, $args);
    }

    public function shortcode_youtube($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('youtube', $atts);
        $content = $this->_content_cleanup($content);

        if (strpos($content, 'youtube.com') === false && strpos($content, 'youtu.be') === false) {
            $protocol = is_ssl() ? 'https' : 'http';
            $url = $protocol.'://www.youtube.com/watch?v='.$content;
        } else {
            $url = $content;

            if (is_ssl() && substr($url, 0, 5) != 'https') {
                $url = 'https'.substr($url, 4);
            }
        }

        if ($atts['youtube'] != '') {
            $parts = explode('x', $atts['youtube'], 2);

            if (count($parts) == 2) {
                $args['width'] = absint($parts[0]);
                $args['height'] = absint($parts[1]);
            }
        }

        $data = array();
        if ($atts['width'] > 0) {
            $data['width'] = $atts['width'];
        }

        if ($atts['height'] > 0) {
            $data['height'] = $atts['height'];
        }

        global $wp_embed;
        return $wp_embed->shortcode($data, $url);
    }

    public function shortcode_vimeo($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('vimeo', $atts);
        $content = $this->_content_cleanup($content);

        if (strpos($content, 'vimeo.com') === false) {
            $protocol = is_ssl() ? 'https' : 'http';
            $url = $protocol.'://www.vimeo.com/'.$content;
        } else {
            $url = $content;

            if (is_ssl() && substr($url, 0, 5) != 'https') {
                $url = 'https'.substr($url, 4);
            }
        }

        if ($atts['vimeo'] != '') {
            $parts = explode('x', $atts['vimeo'], 2);

            if (count($parts) == 2) {
                $args['width'] = absint($parts[0]);
                $args['height'] = absint($parts[1]);
            }
        }

        $data = array();
        if ($atts['width'] > 0) {
            $data['width'] = $atts['width'];
        }

        if ($atts['height'] > 0) {
            $data['height'] = $atts['height'];
        }

        global $wp_embed;
        return $wp_embed->shortcode($data, $url);
    }

    public function shortcode_iframe($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        $atts = $this->_atts('iframe', $atts);
        $content = $this->_content_cleanup($content);

        return '<iframe src="'.$content.'" width="'.$atts['width'].'" height="'.$atts['height'].'" frameborder="'.$atts['frameborder'].'"></iframe>';
    }

    public function shortcode_note($atts, $content = null) {
        if (is_null($content)) {
            return '';
        }

        return '<!-- '.$this->_content($content).' -->';
    }

    public function shortcode_attachment($atts, $content = null) {
        $atts = $this->_atts('attachment', $atts);

        if (empty($atts['title'])) {
            unset($atts['title']);
        }

        if (empty($atts['alt'])) {
            unset($atts['alt']);
        }

        if (!empty($atts['file'])) {
            $attachment = gdbbx_get_attachment_id_from_name($atts['file']);

            if ($attachment > 0) {
                $file = get_attached_file($attachment);
                $ext = pathinfo($file, PATHINFO_EXTENSION);

                if (function_exists('gdbbx_attachments')) {
                    $id = bbp_get_reply_id();
                    $id = $id > 0 ? $id : bbp_get_topic_id();
                    $id = $id > 0 ? $id : get_the_ID();

                    gdbbx_attachments()->attachment_inserted($id, $attachment);
                }

                $ax = get_post($attachment);

                if (in_array($ext, gdbbx()->get_image_extensions())) {
                    $title = trim($ax->post_title);
                    $caption = trim($ax->post_excerpt);

                    $the_caption = '';
                    $show_caption = gdbbx()->get('bbcodes_attachment_caption', 'tools');

                    if ($show_caption == 'auto') {
                        $the_caption = empty($caption) ? $title : $caption;
                    }
                    else if ($show_caption == 'caption') {
                        $the_caption = empty($caption) ? '' : $caption;
                    }

                    $the_align = $atts['align'];

                    if (!empty($the_caption)) {
                        unset($atts['align']);
                    }

                    $defaults = apply_filters('gdbbx_attachment_image_defaults', array(
                        'a' => array(
                            'target' => '_blank',
                            'rel' => '',
                            'style' => '',
                            'class' => '',
                            'title' => empty($caption) ? $title : $caption),
                        'img' => array(
                            'width' => '',
                            'height' => '',
                            'alt' => empty($caption) ? $title : $caption),
                        'thumb' => 'full'
                    ), $attachment);

                    $atts_a = shortcode_atts($defaults['a'], $atts);
                    $atts_img = shortcode_atts($defaults['img'], $atts);

                    $atts_a['href'] = wp_get_attachment_url($attachment);
                    $atts_img['src'] = $atts_a['href'];

                    $image = wp_get_attachment_image_src($attachment, $defaults['thumb']);
                    if ($image) {
                        $atts_img['src'] = $image[0];
                    }

                    if (empty($the_caption)) {
                        return $this->_tag('a', 'attachment', $this->_tag('img', 'attachment-image', null, $atts_img), $atts_a);
                    } else {
                        $_img = $this->_tag('a', 'attachment', $this->_tag('img', 'attachment-image', null, $atts_img), $atts_a);
                        $_cap = $this->_tag('figcaption', 'caption', $the_caption, array('class' => 'wp-caption-text'), array(), true);

                        return $this->_tag('figure', 'attachment gdbbx-with-caption '.$the_align, $_img.$_cap, array('class' => 'wp-caption'));
                    }
                } else if (in_array($ext, gdbbx()->get_video_extensions())) {
                    $title = trim($ax->post_title);
                    $caption = trim($ax->post_excerpt);

                    $the_caption = '';
                    $show_caption = gdbbx()->get('bbcodes_attachment_video_caption', 'tools');

                    if ($show_caption == 'auto') {
                        $the_caption = empty($caption) ? $title : $caption;
                    }
                    else if ($show_caption == 'caption') {
                        $the_caption = empty($caption) ? '' : $caption;
                    }

                    $atts_v = array(
                        'src' => wp_get_attachment_url($attachment),
                        'loop' => $atts['loop'],
                        'autoplay' => $atts['autoplay']
                    );

                    if (!empty($atts['width'])) {
                        $atts_v['width'] = absint(($atts['width']));
                    }

                    if (!empty($atts['height'])) {
                        $atts_v['height'] = absint(($atts['height']));
                    }

                    $the_video = wp_video_shortcode($atts_v);

                    if (empty($the_caption)) {
                        return $this->_tag('div', 'attachment', $the_video);
                    } else {
                        $_cap = $this->_tag('div', 'caption', $the_caption, array('class' => 'wp-caption-text'), array(), true);

                        return $this->_tag('div', 'attachment gdbbx-with-caption', $the_video.$_cap);
                    }
                } else if (in_array($ext, gdbbx()->get_audio_extensions())) {
                    $title = trim($ax->post_title);
                    $caption = trim($ax->post_excerpt);

                    $the_caption = '';
                    $show_caption = gdbbx()->get('bbcodes_attachment_audio_caption', 'tools');

                    if ($show_caption == 'auto') {
                        $the_caption = empty($caption) ? $title : $caption;
                    }
                    else if ($show_caption == 'caption') {
                        $the_caption = empty($caption) ? '' : $caption;
                    }

                    $atts_v = array(
                        'src' => wp_get_attachment_url($attachment),
                        'loop' => $atts['loop'],
                        'autoplay' => $atts['autoplay']
                    );

                    $the_audio = wp_audio_shortcode($atts_v);

                    if (empty($the_caption)) {
                        return $this->_tag('div', 'attachment', $the_audio);
                    } else {
                        $_cap = $this->_tag('div', 'caption', $the_caption, array('class' => 'wp-caption-text'), array(), true);

                        return $this->_tag('div', 'attachment gdbbx-with-caption', $the_audio.$_cap);
                     }
                } else {
                    $defaults = apply_filters('gdbbx_attachment_file_defaults', array(
                        'target' => '_blank',
                        'rel' => '',
                        'style' => '',
                        'class' => '',
                        'title' => get_the_title($attachment)
                    ), $attachment);

                    $atts_a = shortcode_atts($defaults, $atts);
                    $atts_a['href'] = wp_get_attachment_url($attachment);

                    return $this->_tag('a', 'attachment', get_the_title($attachment), $atts_a);
                }
            }
        }

        return '';
    }
}

/** @return gdbbx_mod_bbcodes  */
function gdbbx_module_bbcodes() {
    return gdbbx_loader()->modules['bbcodes'];
}

if (!function_exists('gdbbx_render_the_bbcode')){
    function gdbbx_render_the_bbcode($name, $atts, $content = null) {
        if (method_exists(gdbbx_module_bbcodes(), 'shortcode_'.$name)) {
            return gdbbx_module_bbcodes()->{'shortcode_'.$name}($atts, $content);
        }

        return false;
    }
}
