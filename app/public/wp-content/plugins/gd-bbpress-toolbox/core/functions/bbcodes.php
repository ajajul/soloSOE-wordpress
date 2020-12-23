<?php

if (!defined('ABSPATH')) {
    exit;
}

function gdbbx_get_bbcodes_list() {
    return array(
        'br' => array('title' => __("Line Break", "gd-bbpress-toolbox"), 'examples' => array('[br]')),
        'hr' => array('title' => __("Horizontal Line", "gd-bbpress-toolbox"), 'examples' => array('[hr]')),
        'b' => array('title' => __("Bold", "gd-bbpress-toolbox"), 'examples' => array('[b]{content}[/b]')),
        'i' => array('title' => __("Italic", "gd-bbpress-toolbox"), 'examples' => array('[i]{content}[/i]')),
        'u' => array('title' => __("Underline", "gd-bbpress-toolbox"), 'examples' => array('[u]{content}[/u]')),
        's' => array('title' => __("Strikethrough", "gd-bbpress-toolbox"), 'examples' => array('[s]{content}[/s]')),
        'heading' => array('title' => __("Heading", "gd-bbpress-toolbox"), 'examples' => array('[heading]{content}[/heading]', '[heading size={size}]{content}[/heading]')),
        'highlight' => array('title' => __("Highlight", "gd-bbpress-toolbox"), 'examples' => array('[highlight]{content}[/highlight]', '[highlight color="{color}" background="{color}"]{content}[/highlight]')),
        'center' => array('title' => __("Align: Center", "gd-bbpress-toolbox"), 'examples' => array('[center]{content}[/center]')),
        'right' => array('title' => __("Align: Right", "gd-bbpress-toolbox"), 'examples' => array('[right]{content}[/right]')),
        'left' => array('title' => __("Align: Left", "gd-bbpress-toolbox"), 'examples' => array('[left]{content}[/left]')),
        'justify' => array('title' => __("Align: Justify", "gd-bbpress-toolbox"), 'examples' => array('[justify]{content}[/justify]')),
        'sub' => array('title' => __("Subscript", "gd-bbpress-toolbox"), 'examples' => array('[sub]{content}[/sub]')),
        'sup' => array('title' => __("Superscript", "gd-bbpress-toolbox"), 'examples' => array('[sup]{content}[/sup]')),
        'reverse' => array('title' => __("Reverse", "gd-bbpress-toolbox"), 'examples' => array('[reverse]{content}[/reverse]')),
        'size' => array('title' => __("Font Size", "gd-bbpress-toolbox"), 'examples' => array('[size size="{size}"]{content}[/size]')),
        'color' => array('title' => __("Font Color", "gd-bbpress-toolbox"), 'examples' => array('[color color="{color}"]{content}[/color]')),
        'pre' => array('title' => __("Preformatted", "gd-bbpress-toolbox"), 'examples' => array('[pre]{content}[/pre]')),
        'scode' => array('title' => __("Source Code", "gd-bbpress-toolbox"), 'examples' => array('[scode]{content}[/scode]', '[scode lang="{language}"]{content}[/scode]')),
        'blockquote' => array('title' => __("Blockquote", "gd-bbpress-toolbox"), 'examples' => array('[blockquote]{content}[/blockquote]')),
        'border' => array('title' => __("Border", "gd-bbpress-toolbox"), 'examples' => array('[border]{content}[/border]')),
        'area' => array('title' => __("Area", "gd-bbpress-toolbox"), 'examples' => array('[area]{content}[/area]', '[area area="{title}"]{content}[/area]')),
        'list' => array('title' => __("List", "gd-bbpress-toolbox"), 'examples' => array('[list]{content}[/list]')),
        'ol' => array('title' => __("List: Ordered", "gd-bbpress-toolbox"), 'examples' => array('[ol]{content}[/ol]')),
        'ul' => array('title' => __("List: Unordered", "gd-bbpress-toolbox"), 'examples' => array('[ul]{content}[/ul]')),
        'li' => array('title' => __("List: Item", "gd-bbpress-toolbox"), 'examples' => array('[li]{content}[/li]')),
        'anchor' => array('title' => __("Anchor", "gd-bbpress-toolbox"), 'examples' => array('[anchor anchor="{anchor}"]{text}[/anchor]')),
        'quote' => array('title' => __("Quote", "gd-bbpress-toolbox"), 'examples' => array('[quote]{content}[/quote]', '[quote quote={id}]{content}[/quote]')),
        'spoiler' => array('title' => __("Spoiler", "gd-bbpress-toolbox"), 'examples' => array('[spoiler]{content}[/spoiler]', '[spoiler color="{color}" hover="{color}"]{content}[/spoiler]')),
        'hide' => array('title' => __("Hide", "gd-bbpress-toolbox"), 'examples' => array('[hide]{content}[/hide]', '[hide hide={post_count}]{content}[/hide]', '[hide hide="reply"]{content}[/hide]', '[hide hide="thanks"]{content}[/hide]')),
        'forum' => array('title' => __("Forum", "gd-bbpress-toolbox"), 'examples' => array('[forum]{id}[/forum]', '[forum forum={id}]{title}[/forum]')),
        'topic' => array('title' => __("Topic", "gd-bbpress-toolbox"), 'examples' => array('[topic]{id}[/topic]', '[topic topic={id}]{title}[/topic]')),
        'reply' => array('title' => __("Reply", "gd-bbpress-toolbox"), 'examples' => array('[reply]{id}[/reply]', '[reply topic={id}]{title}[/reply]')),
        'nfo' => array('title' => __("NFO", "gd-bbpress-toolbox"), 'examples' => array('[nfo]{content}[/nfo]', '[nfo title="{title}"]{content}[/nfo]'), 'class' => 'advanced'),
        'url' => array('title' => __("URL", "gd-bbpress-toolbox"), 'examples' => array('[url]{link}[/url]', '[url url="{link}"]{text}[/url]'), 'class' => 'advanced'),
        'email' => array('title' => __("Email", "gd-bbpress-toolbox"), 'examples' => array('[email]{email}[/email]', '[email email="{email}"]{text}[/email]'), 'class' => 'advanced'),
        'img' => array('title' => __("Image", "gd-bbpress-toolbox"), 'examples' => array('[img]{image_url}[/img]', '[img img="{width}x{height}"]{image_url}[/img]', '[img width={x} height={y}]{image_url}[/img]'), 'class' => 'advanced'),
        'attachment' => array('title' => __("Attachment", "gd-bbpress-toolbox"), 'examples' => array('[attachment file="{file}"]', '[attachment file="{file}" width={x} height={y}]'), 'class' => 'advanced'),
        'webshot' => array('title' => __("Webshot", "gd-bbpress-toolbox"), 'examples' => array('[webshot]{url}[/webshot]', '[webshot width={width}]{url}[/webshot]'), 'class' => 'advanced'),
        'embed' => array('title' => __("Embed using oEmbed", "gd-bbpress-toolbox"), 'examples' => array('[embed]{url}[/embed]', '[embed embed="{width}x{height}"]{url}[/embed]', '[embed width={x} height={y}]{url}[/embed]'), 'class' => 'advanced'),
        'youtube' => array('title' => __("YouTube Video", "gd-bbpress-toolbox"), 'examples' => array('[youtube]{id}[/youtube]', '[youtube youtube={width}x{height}]{id}[/youtube]', '[youtube width={x} height={y}]{id}[/youtube]', '[youtube]{url}[/youtube]', '[youtube youtube="{width}x{height}"]{url}[/youtube]', '[youtube width={x} height={y}]{url}[/youtube]'), 'class' => 'advanced'),
        'vimeo' => array('title' => __("Vimeo Video", "gd-bbpress-toolbox"), 'examples' => array('[vimeo]{id}[/vimeo]', '[vimeo vimeo="{width}x{height}"]{id}[/vimeo]', '[vimeo width={x} height={y}]{id}[/vimeo]', '[vimeo]{url}[/vimeo]', '[vimeo vimeo="{width}x{height}"]{url}[/vimeo]', '[vimeo width={x} height={y}]{url}[/vimeo]'), 'class' => 'advanced'),
        'google' => array('title' => __("Google Search URL", "gd-bbpress-toolbox"), 'examples' => array('[google]{search}[/google]'), 'class' => 'advanced'),
        'iframe' => array('title' => __("Iframe", "gd-bbpress-toolbox"), 'examples' => array('[iframe]{url}[/iframe]', '[iframe width={x} height={y} border="{width}"]{url}[/iframe]'), 'class' => 'restricted'),
        'note' => array('title' => __("Hidden Note", "gd-bbpress-toolbox"), 'examples' => array('[note]{content}[/note]'), 'class' => 'restricted')
    );
}
