<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_mod_bbcodes_scode {
    public $map = array(
        'applescript',
        'actionscript3 as3',
        'bash shell sh',
        'coldfusion cf',
        'cpp cc c++ c h hpp h++',
        'c# c-sharp csharp',
        'css',
        'delphi pascal pas',
        'diff patch',
        'erl erlang',
        'groovy',
        'haxe hx',
        'java',
        'jfx javafx',
        'js jscript javascript json',
        'perl pl',
        'php',
        'plain text',
        'powershell ps posh',
        'py python',
        'ruby rails ror rb',
        'sass scss',
        'scala',
        'sql',
        'swift',
        'tap',
        'typescript ts',
        'vb vbnet',
        'xml xhtml xslt html plist'
    );

    public $enqueued = false;
    public $brushes = array();

    function __construct() {
        $this->loader();
    }

    public function loader() {
        if (!current_user_can('unfiltered_html')) {
            remove_filter('bbp_new_topic_pre_content', 'bbp_encode_bad', 10);
            remove_filter('bbp_new_reply_pre_content', 'bbp_encode_bad', 10);
            remove_filter('bbp_edit_topic_pre_content', 'bbp_encode_bad', 10);
            remove_filter('bbp_edit_reply_pre_content', 'bbp_encode_bad', 10);

            remove_filter('bbp_new_topic_pre_content', 'bbp_filter_kses', 30);
            remove_filter('bbp_new_reply_pre_content', 'bbp_filter_kses', 30);
            remove_filter('bbp_edit_topic_pre_content', 'bbp_filter_kses', 30);
            remove_filter('bbp_edit_reply_pre_content', 'bbp_filter_kses', 30);

            add_filter('bbp_new_topic_pre_content', array($this, 'kses'), 30);
            add_filter('bbp_new_reply_pre_content', array($this, 'kses'), 30);
            add_filter('bbp_edit_topic_pre_content', array($this, 'kses'), 30);
            add_filter('bbp_edit_reply_pre_content', array($this, 'kses'), 30);
        }

        if (has_filter('bbp_get_topic_content', 'bbp_make_clickable')) {
            remove_filter('bbp_get_topic_content', 'bbp_make_clickable', 4);

            add_filter('bbp_get_topic_content', array($this, 'make_clickable'), 4);
	}

	if (has_filter('bbp_get_reply_content', 'bbp_make_clickable')) {
            remove_filter('bbp_get_reply_content', 'bbp_make_clickable', 4);

            add_filter('bbp_get_reply_content', array($this, 'make_clickable'), 4);
	}

        add_filter('bbp_get_topic_content', array($this, 'escape_code'), 1);
	add_filter('bbp_get_reply_content', array($this, 'escape_code'), 1);
    }

    public function enqueue() {
        if (!$this->enqueued) {
            $theme = strtolower(gdbbx()->get('bbcodes_scode_theme', 'tools'));

            wp_enqueue_style('gdbbx-syntaxhightlight', GDBBX_URL.'d4pjs/syntaxhightlight/css/'.$theme.'.css', array(), gdbbx()->info_version);
            wp_enqueue_script('gdbbx-syntaxhightlight-core', GDBBX_URL.'d4pjs/syntaxhightlight/js/syntaxhighlighter.js', array(), gdbbx()->info_version);

            $this->enqueued = true;
        }
    }

    public function make_clickable($content) {
        if (!preg_match('|(\[scode[^\]]*?\])(.*?)(\[/scode\])|is', $content)) {
            $content = bbp_make_clickable($content);
        }

        return $content;
    }

    public function kses($content) {
        if (!preg_match('|\[scode[^\]]*?\].*?\[/scode\]|is', $content)) {
            $content = bbp_encode_bad($content);

            return bbp_filter_kses($content);
        }

        kses_remove_filters();

        $content = preg_replace_callback('|(\[scode[^\]]*?\])(.*?)(\[/scode\])|is', array($this, 'kses_before'), $content);
        $content = bbp_filter_kses($content);
        $content = preg_replace_callback('|(\[scode[^\]]*?\])(.*?)(\[/scode\])|is', array($this, 'kses_after'), $content);

        return $content;
    }

    public function kses_before($matches) {
        $replaced_code = str_replace('<', '%%GDBBXLT%%', $matches[2]);
        $replaced_code = str_replace('>', '%%GDBBXRT%%', $replaced_code);

        return $matches[1].$replaced_code.$matches[3];
    }

    public function kses_after($matches) {
        $replaced_code = str_replace('%%GDBBXLT%%', '<', $matches[2]);
        $replaced_code = str_replace('%%GDBBXRT%%', '>', $replaced_code);

        return $matches[1].$replaced_code.$matches[3];
    }

    public function escape_code($content) {
        return preg_replace_callback('|(\[scode[^\]]*?\])(.*?)(\[/scode\])|is', array($this, 'escape_code_callback'), $content);
    }

    public function escape_code_callback($matches) {
        $code = $matches[2];

        if (strpos($code, "<") !== false || strpos($code, ">") !== false || strpos($code, '"') !== false || strpos($code, "'") !== false || preg_match('/&(?!lt;)(?!gt;)(?!amp;)(?!quot;)(?!#039;)/i', $code)) {
            if (strpos($code, "<") === false && strpos($code, ">") === false && !preg_match('/&(?!lt;)(?!gt;)(?!amp;)(?!quot;)(?!#039;)/i', $code)) {
                $pre_replaced_code = str_replace(array('"', '”', '“'), '&quot;', $code);

                $replaced_code = $matches[1].str_replace("'", '&#039;', $pre_replaced_code).$matches[3];
            } else {
                $replaced_code = $matches[1].htmlspecialchars($code, ENT_QUOTES).$matches[3];
            }
	} else {
            $replaced_code = $matches[1].$code.$matches[3];
	}

        return $replaced_code;
    }

    public function is_brush_valid($brush) {
        $brushes = strtolower(join(' ', $this->map));
        $brushes = explode(' ', $brushes);

        return in_array($brush, $brushes);
    }
}
