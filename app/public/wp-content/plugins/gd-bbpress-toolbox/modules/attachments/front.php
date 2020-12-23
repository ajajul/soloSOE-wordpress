<?php

use Dev4Press\Plugin\GDBBX\Basic\Enqueue;

if (!defined('ABSPATH')) { exit; }

class gdbbx_attachments_front {
    public $enabled = false;
    public $file_size = 0;

    public $forum_id;
    public $user_id;

    /** @var gdbbx_attachments_display */
    public $display;

    private $_update_attachments;

    private $icons = array(
        'code' => 'c|cc|h|js|class|json', 
        'xml' => 'xml', 
        'excel' => 'xla|xls|xlsx|xlt|xlw|xlam|xlsb|xlsm|xltm', 
        'word' => 'docx|dotx|docm|dotm', 
        'image' => 'png|gif|jpg|jpeg|jpe|jp|bmp|tif|tiff', 
        'psd' => 'psd', 
        'ai' => 'ai', 
        'archive' => 'zip|rar|gz|gzip|tar',
        'text' => 'txt|asc|nfo', 
        'powerpoint' => 'pot|pps|ppt|pptx|ppam|pptm|sldm|ppsm|potm', 
        'pdf' => 'pdf', 
        'html' => 'htm|html|css', 
        'video' => 'avi|asf|asx|wax|wmv|wmx|divx|flv|mov|qt|mpeg|mpg|mpe|mp4|m4v|ogv|mkv', 
        'documents' => 'odt|odp|ods|odg|odc|odb|odf|wp|wpd|rtf',
        'audio' => 'mp3|m4a|m4b|mp4|m4v|wav|ra|ram|ogg|oga|mid|midi|wma|mka',
        'icon' => 'ico'
    );

    private $fonti = array(
        'file-code-o' => 'code|xml|html',
        'file-picture-o' => 'image|psd|ai|icon',
        'file-pdf-o' => 'pdf',
        'file-excel-o' => 'excel',
        'file-word-o' => 'word',
        'file-powerpoint-o' => 'powerpoint',
        'file-text-o' => 'text|documents',
        'file-video-o' => 'video',
        'file-archive-o' => 'archive',
        'file-audio-o' => 'audio',
        'file-o' => 'generic'
    );

    function __construct() {
        add_action('gdbbx_core', array($this, 'load'));
    }

    public function load() {
        $this->icons = apply_filters('gdbbx_attachments_icons_sets', $this->icons);
        $this->fonti = apply_filters('gdbbx_attachments_font_icons_sets', $this->fonti);

        add_action('gdbbx_template_before_replies_loop', array($this, 'before_replies_loop'), 10, 2);
        add_action('gdbbx_template_before_topics_loop', array($this, 'before_topics_loop'), 10, 2);

        add_filter('gdbbx_script_values', array($this, 'script_values'));
        add_action('gdbbx_attachments_form_notices', array($this, 'form_notices'));

        add_action(gdbbx()->get('form_position_reply', 'attachments'), array($this, 'embed_form_reply'));
        add_action(gdbbx()->get('form_position_topic', 'attachments'), array($this, 'embed_form_topic'));

        add_action('bbp_edit_reply', array($this, 'save_reply'), 10, 5);
        add_action('bbp_edit_topic', array($this, 'save_topic'), 10, 4);
        add_action('bbp_new_reply', array($this, 'save_reply'), 10, 5);
        add_action('bbp_new_topic', array($this, 'save_topic'), 10, 4);

        $this->add_content_filters();
        $this->run_bulk_downloader();
    }

    public function run_bulk_downloader() {
        if (isset($_GET['gdbbx-bulk-download']) && !empty($_GET['gdbbx-bulk-download'])) {
            $id = absint($_GET['gdbbx-bulk-download']);

            if ($id > 0) {
                if (gdbbx()->get('bulk_download', 'attachments') && gdbbx()->allowed('bulk_download', 'attachments', true, false)) {
                    $files = gdbbx_get_post_attachments($id);
                    $url = bbp_is_topic($id) ? get_permalink($id) : 
                           (bbp_is_reply($id) ? bbp_get_reply_url($id) : site_url());

                    if (!empty($files)) {
                        $this->bulk_download($files, $id);
                    }

                    wp_redirect($url);
                    exit;
                }
            }
        }
    }

    public function bulk_download($files, $id) {
        $dir = wp_upload_dir();

        if ($dir['error'] === false) {
            $file_name = 'attachments-for-'.$id.'-'.time().'.zip';
            $file_temp = 'att-'.time().'-'.$id.'.bbx';
            $file_path = trailingslashit($dir['basedir']).'gdbbx/';

            $proceed = true;
            if (!file_exists($file_path)) {
                $proceed = wp_mkdir_p($file_path);
            }

            if ($proceed) {
                $this->bulk_htaccess($file_path);

                if (!defined('PCLZIP_TEMPORARY_DIR')) {
                    define('PCLZIP_TEMPORARY_DIR', $file_path);
                }

                require_once(ABSPATH.'wp-admin/includes/class-pclzip.php');

                $zip = new PclZip($file_path.$file_temp);

                foreach ($files as $file) {
                    $path = get_attached_file($file->ID);
                    $folder = pathinfo($path, PATHINFO_DIRNAME);

                    $zip->add($path, PCLZIP_OPT_REMOVE_PATH, $folder, PCLZIP_OPT_ADD_TEMP_FILE_ON);
                }

                if (!wp_next_scheduled('gdbbx_clear_bulk_directory')) {
                    wp_schedule_single_event(time() + HOUR_IN_SECONDS, 'gdbbx_clear_bulk_directory');
                }

                d4p_includes(array(
                    array('name' => 'file-download', 'directory' => 'functions')
                ), GDBBX_D4PLIB);

                d4p_download_resume($file_path.$file_temp, $file_name);

                exit;
            }
        }
    }

    public function bulk_htaccess($file_path) {
        $htaccess = $file_path.'.htaccess';

        if (file_exists($htaccess)) {
            return;
        }

        $file = array(
            'Options All -Indexes',
            '',
            '<Files ~ ".*\..*">',
            'order allow,deny',
            'deny from all',
            '</Files>'
        );

        file_put_contents($htaccess, implode(PHP_EOL, $file));
    }

    public function upload_dir($args) {
        $newdir = $this->_upload_dir_structure();

        $args['path'] = str_replace($args['subdir'], '', $args['path']);
        $args['url'] = str_replace($args['subdir'], '', $args['url']);      
        $args['subdir'] = $newdir;
        $args['path'].= $newdir; 
        $args['url'].= $newdir;

        return $args;
    }

    public function before_replies_loop($posts, $users) {
        gdbbx_cache()->attachments_run_bulk_counts($posts);
        gdbbx_cache()->attachments_errors_run_bulk_counts($posts);
    }

    public function before_topics_loop($posts, $users) {
        gdbbx_cache()->attachments_run_bulk_topics_counts($posts);
    }

    public function add_content_filters() {
        if (!$this->enabled) {
            $this->enabled = true;

            if (gdbbx()->get('files_list_position', 'attachments') == 'content') {
                add_filter('bbp_get_reply_content', array($this, 'embed_attachments'), 100, 2);
                add_filter('bbp_get_topic_content', array($this, 'embed_attachments'), 100, 2);
            } else if (gdbbx()->get('files_list_position', 'attachments') == 'after') {
                add_action('bbp_theme_after_topic_content', array($this, 'after_attachments'), 20);
                add_action('bbp_theme_after_reply_content', array($this, 'after_attachments'), 20);
            }
        }
    }

    public function remove_content_filters() {
        $this->enabled = false;

        remove_filter('bbp_get_topic_content', array($this, 'embed_attachments'), 100);
        remove_filter('bbp_get_reply_content', array($this, 'embed_attachments'), 100);
    }

    public function script_values($values) {
        $forum_id = gdbbx_get_forum_id();

        $allowed_extensions = false;
        $insert_into_content = false;

        if (gdbbx_attachments()->get('insert_into_content')) {
            if (gdbbx()->allowed('insert_into_content', 'attachments', false, false)) {
                $insert_into_content = true;
            }
        }

        if (gdbbx()->get('mime_types_limit_active', 'attachments')) {
            $allowed_extensions = strtolower(join(' ', gdbbx_attachments()->get_file_extensions($forum_id)));
        }

        $values['load'][] = 'attachments';
        $values['attachments'] = apply_filters('gdbbx_attachments_script_values', array(
            'validate' => gdbbx_attachments()->get('validation_active'),
            'max_files' => gdbbx_attachments()->get_max_files($forum_id),
            'max_size' => gdbbx_attachments()->get_file_size($forum_id) * 1024,
            'limiter' => !gdbbx_attachments()->is_no_limit(),
            'auto_new_file' => gdbbx_attachments()->get('enhanced_auto_new'),
            'set_caption_file' => gdbbx_attachments()->get('enhanced_set_caption'),
            'allowed_extensions' => $allowed_extensions,
            'insert_into_content' => $insert_into_content,
            'text' => array(
                'select_file' => _x("Select File", "Attachments Dialog", "gd-bbpress-toolbox"),
                'file_name' => _x("Name", "Attachments Dialog, File Name", "gd-bbpress-toolbox"),
                'file_size' => _x("Size", "Attachments Dialog, File Size", "gd-bbpress-toolbox"),
                'file_type' => _x("Extension", "Attachments Dialog, File Extension", "gd-bbpress-toolbox"),
                'file_validation' => _x("Error!", "Attachments Dialog, Validation", "gd-bbpress-toolbox"),
                'file_validation_size' => _x("The file is too big.", "Attachments Dialog, Validation", "gd-bbpress-toolbox"),
                'file_validation_type' => _x("File type not allowed.", "Attachments Dialog, Validation", "gd-bbpress-toolbox"),
                'file_validation_duplicate' => _x("You can't select the same file twice.", "Attachments Dialog, Validation", "gd-bbpress-toolbox"),
                'file_remove' => _x("Remove this file", "Attachments Dialog", "gd-bbpress-toolbox"),
                'file_shortcode' => _x("Insert into content", "Attachments Dialog", "gd-bbpress-toolbox"),
                'file_caption' => _x("Set file caption", "Attachments Dialog", "gd-bbpress-toolbox"),
                'file_caption_placeholder' => _x("Caption...", "Attachments Dialog", "gd-bbpress-toolbox"),
            )
        ));

        return $values;
    }

    public function form_notices() {
        if (gdbbx_attachments()->is_no_limit()) {
            $message = __("Your account has the ability to upload any attachment regardless of size and type.", "gd-bbpress-toolbox");

            echo apply_filters('gdbbx_notice_attachments_no_limit', '<div class="bbp-template-notice info"><p>'.$message.'</p></div>', $message);
        } else {
            $file_size = d4p_filesize_format($this->file_size * 1024, 2);

            $message = sprintf(__("Maximum file size allowed is %s.", "gd-bbpress-toolbox"), '<strong>'.$file_size.'</strong>');

            echo apply_filters('gdbbx_notice_attachments_limit_file_size', '<div class="bbp-template-notice"><p>'.$message.'</p></div>', $message, $file_size);

            if (gdbbx()->get('mime_types_limit_active', 'attachments') && gdbbx()->get('mime_types_limit_display', 'attachments')) {
                $show = gdbbx_attachments()->get_file_extensions();

                $message = sprintf(__("File types allowed for upload: %s.", "gd-bbpress-toolbox"), '<strong>.'.join('</strong>, <strong>.', $show).'</strong>');

                echo apply_filters('gdbbx_notice_attachments_limit_file_types', '<div class="bbp-template-notice"><p>'.$message.'</p></div>', $message, $show);
            }
        }
    }

    public function save_topic($topic_id, $forum_id, $anonymous_data, $topic_author) {
        $this->save_reply(0, $topic_id, $forum_id, $anonymous_data, $topic_author);
    }

    public function save_reply($reply_id, $topic_id, $forum_id, $anonymous_data, $reply_author) {
        $is_topic = $reply_id == 0;

        $post_id = $reply_id == 0 ? $topic_id : $reply_id;

        if (isset($_POST['gdbbx']['remove-attachment'])) {
            $attachments = (array)$_POST['gdbbx']['remove-attachment'];

            foreach ($attachments as $id => $action) {
                $attachment_id = absint($id);

                if ($action == 'delete' || $action == 'detach') {
                    gdbbx_attachments()->delete_attachment($attachment_id, $post_id, $action);
                }
            }
        }

        $uploads = array();
        $original = array();
        $uploads_captions = array();

        $featured = false; 
        if ($is_topic) {
            $featured = gdbbx()->get('topic_featured_image', 'attachments');
        } else {
            $featured = gdbbx()->get('reply_featured_image', 'attachments');
        }

        $counter = 0;
        $captions = isset($_POST['gdbbx-attachment_caption']) ? (array)$_POST['gdbbx-attachment_caption'] : array();

        if (!empty($_FILES) && !empty($_FILES['gdbbx-attachment'])) {
            require_once(ABSPATH.'wp-admin/includes/file.php');

            $errors = new gdbbx_error();
            $overrides = array(
                'test_form' => false, 
                'upload_error_handler' => 'gdbbx_attachment_handle_upload_error'
            );

            foreach ($_FILES['gdbbx-attachment']['error'] as $key => $error) {
                $file_name = $_FILES['gdbbx-attachment']['name'][$key];

                if ($error == UPLOAD_ERR_OK) {
                    $file = array('name' => $file_name,
                        'type' => $_FILES['gdbbx-attachment']['type'][$key],
                        'size' => $_FILES['gdbbx-attachment']['size'][$key],
                        'tmp_name' => $_FILES['gdbbx-attachment']['tmp_name'][$key],
                        'error' => $_FILES['gdbbx-attachment']['error'][$key]
                    );

                    $file_name = sanitize_file_name($file_name);

                    if (gdbbx_attachments()->is_right_size($file, $forum_id)) {
                        $mimes = gdbbx_attachments()->filter_mime_types($forum_id);
                        if (!is_null($mimes) && !empty($mimes)) {
                            $overrides['mimes'] = $mimes;
                        }

                        $this->forum_id = $forum_id;
                        $this->user_id = $reply_author;

                        if (gdbbx()->get('upload_dir_override', 'attachments')) {
                            add_filter('upload_dir', array($this, 'upload_dir'));
                        }

                        $upload = wp_handle_upload($file, $overrides);

                        if (gdbbx()->get('upload_dir_override', 'attachments')) {
                            remove_filter('upload_dir', array($this, 'upload_dir'));
                        }

                        $caption = isset($captions[$counter]) ? sanitize_text_field($captions[$counter]) : '';

                        if (!is_wp_error($upload)) {
                            $uploads[] = $upload;
                            $original[] = $file_name;
                            $uploads_captions[] = $caption;
                        } else {
                            $errors->add('wp_upload', $upload->errors['wp_upload_error'][0], $file_name);
                        }
                    } else {
                        $errors->add('d4p_upload', 'File exceeds allowed file size.', $file_name);
                    }
                } else {
                    switch ($error) {
                        default:
                        case 'UPLOAD_ERR_NO_FILE':
                            $errors->add('php_upload', 'File not uploaded.', $file_name);
                            break;
                        case 'UPLOAD_ERR_INI_SIZE':
                            $errors->add('php_upload', 'Upload file size exceeds PHP maximum file size allowed.', $file_name);
                            break;
                        case 'UPLOAD_ERR_FORM_SIZE':
                            $errors->add('php_upload', 'Upload file size exceeds FORM specified file size.', $file_name);
                            break;
                        case 'UPLOAD_ERR_PARTIAL':
                            $errors->add('php_upload', 'Upload file only partially uploaded.', $file_name);
                            break;
                        case 'UPLOAD_ERR_CANT_WRITE':
                            $errors->add('php_upload', 'Can\'t write file to the disk.', $file_name);
                            break;
                        case 'UPLOAD_ERR_NO_TMP_DIR':
                            $errors->add('php_upload', 'Temporary folder for upload is missing.', $file_name);
                            break;
                        case 'UPLOAD_ERR_EXTENSION':
                            $errors->add('php_upload', 'Server extension restriction stopped upload.', $file_name);
                            break;
                    }
                }

                $counter++;
            }
        }

        if (!empty($errors->errors) && gdbbx()->get('log_upload_errors', 'attachments') == 1) {
            foreach ($errors->errors as $code => $errs) {
                foreach ($errs as $error) {
                    if ($error[0] != '' && $error[1] != '') {
                        add_post_meta($post_id, '_bbp_attachment_upload_error', array(
                            'code' => $code, 'file' => $error[1], 'message' => $error[0])
                        );
                    }
                }
            }
        }

        if (!empty($uploads)) {
            require_once(ABSPATH.'wp-admin/includes/media.php');
            require_once(ABSPATH.'wp-admin/includes/image.php');

            $counter = 0;
            $update_attachments = array();
            foreach ($uploads as $_key => $upload) {
                $wp_filetype = wp_check_filetype(basename($upload['file']));

                $att_name = basename($upload['file']);
                $org_name = $original[$_key];

                $attachment = array('post_mime_type' => $wp_filetype['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', $att_name),
                    'post_excerpt' => $uploads_captions[$counter],
                    'post_content' => '','post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);

                gdbbx_db()->assign_attachment($post_id, $attach_id);

                wp_update_attachment_metadata($attach_id, $attach_data);

                update_post_meta($attach_id, '_bbp_attachment', '1');
                update_post_meta($attach_id, '_bbp_attachment_name', $att_name);
                update_post_meta($attach_id, '_bbp_attachment_original_name', $org_name);

                $update_attachments[] = array('name' => $org_name, 'id' => $attach_id);

                $counter++;
            }

            if (!empty($update_attachments)) {
                $this->_update_attachments = $update_attachments;

                if ($is_topic) {
                    add_action('bbp_edit_topic_post_extras', array($this, 'update_post_content'));
                    add_action('bbp_new_topic_post_extras', array($this, 'update_post_content'));
                } else {
                    add_action('bbp_edit_reply_post_extras', array($this, 'update_post_content'));
                    add_action('bbp_new_reply_post_extras', array($this, 'update_post_content'));
                }
            }

            if (current_theme_supports('post-thumbnails')) {
                if ($featured && !has_post_thumbnail($post_id)) {
                    $ids = gdbbx_cache()->attachments_get_attachments_ids($post_id);

                    $args = array(
                        'post_type' => 'attachment',
                        'numberposts' => 1,
                        'post_status' => null,
                        'post_mime_type' => 'image',
                        'post__in' => $ids,
                        'orderby' => 'ID',
                        'order' => 'ASC',
                        'ignore_sticky_posts' => true
                    );

                    $images = get_posts($args);

                    if (!empty($images)) {
                        foreach ($images as $image) {
                            set_post_thumbnail($post_id, $image->ID);
                        }
                    }
                }
            }
        }

        gdbbx_db()->update_topic_attachments_count($topic_id);
    }

    public function update_post_content($post_id) {
        if (empty($this->_update_attachments)) {
            return;
        }

        $post = get_post($post_id);
        $content = $post->post_content;

        $matches = array();
        $new_list = array();

        $preg = preg_match_all('/\[attachment.+?file=["\'](?<attachment>.+?)["\']\]/i', $content, $matches);
        $list = isset($matches['attachment']) ? $matches['attachment'] : array();
        $modd = array_map('sanitize_file_name', $list);

        if (!empty($modd)) {
            foreach ($this->_update_attachments as $att) {
                $search = $att['name'];
                $replace = $att['id'];

                foreach ($modd as $_key => $file) {
                    if (stripos($file, $search) !== false) {
                        $nfile = str_replace($search, $replace, $file);
                        $new_list[$_key] = $nfile;
                        break;
                    }
                }
            }

            if (!empty($new_list)) {
                foreach ($list as $_key => $att) {
                    if (isset($new_list[$_key])) {
                        $content = str_replace($att, $new_list[$_key], $content);
                    }
                }

                wp_update_post(array(
                    'ID' => $post->ID,
                    'post_content' => $content
                ));
            }

            $this->_update_attachments = array();
        }
    }

    public function embed_attachments_edit($attachments, $post_id) {
        d4p_include('functions', 'admin', GDBBX_D4PLIB);

        $_icons = gdbbx()->get('attachment_icons', 'attachments');
        $_type = gdbbx()->get('icons_mode', 'attachments');

        $_deletion = gdbbx()->get('delete_method', 'attachments') == 'edit';

        $actions = array();

        if ($_deletion) {
            $post = get_post($post_id);
            $author_id = $post->post_author;

            $allow = gdbbx_attachments()->deletion_status($author_id);

            if ($allow != 'no') {
                $actions[''] = __("Do Nothing", "gd-bbpress-toolbox");

                if ($allow == 'delete' || $allow == 'both') {
                    $actions['delete'] = __("Delete", "gd-bbpress-toolbox");
                }

                if ($allow == 'detach' || $allow == 'both') {
                    $actions['detach'] = __("Detach", "gd-bbpress-toolbox");
                }
            }
        }

        $content = '<div class="gdbbx-attachments gdbbx-attachments-edit">';
        $content.= '<input type="hidden" />';
        $content.= '<ol';

        if ($_icons) {
            switch ($_type) {
                case 'images':
                    $content.= ' class="with-icons"';
                    break;
                case 'font':
                    $content.= ' class="with-font-icons"';
                    break;
            }
        }

        $content.= '>';

        foreach ($attachments as $attachment) {
            $insert = array('<a role="button" class="gdbbx-attachment-insert" href="#'.$attachment->ID.'">'.__("insert into content", "gd-bbpress-toolbox").'</a>');

            $file = get_attached_file($attachment->ID);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = pathinfo($file, PATHINFO_BASENAME);
            $url = wp_get_attachment_url($attachment->ID);

            $a_title = $filename;
            $html = $filename;
            $class_li = '';

            if ($_icons && $_type == 'images') {
                $class_li = "gdbbx-image gdbbx-image-".$this->icon($ext);
            }

            if ($_icons && $_type == 'font') {
                $html = $this->render_attachment_icon($ext).$html;
            }

            $item = '<li id="gdbbx-attachment-id-'.$attachment->ID.'" class="gdbbx-attachment gdbbx-attachment-'.$ext.' '.$class_li.'">';
            $item.= '<a href="'.$url.'" title="'.$a_title.'" download>'.$html.'</a>';
            $item.= ' ['.join(' | ', $insert).']';

            if (!empty($actions)) {
                $item.= d4p_render_select($actions, array('name' => 'gdbbx[remove-attachment]['.$attachment->ID.']', 'echo' => false), array('title' => __("Attachment Actions", "gd-bbpress-toolbox")));
            }

            $item.= '</li>';

            $content.= $item;
        }

        $content.= '</ol>';
        $content.= '</div>';

        return $content;
    }

    public function after_attachments() {
        $id = bbp_get_reply_id();

        if ($id == 0) {
            $id = bbp_get_topic_id();
        }

        echo $this->embed_attachments('', $id);
    }

    public function embed_attachments($content, $id) {
        if (gdbbx()->is_inside_content_shortcode($id)) {
            return $content;
        }

        if (gdbbx_is_feed()) {
            return $content;
        }

        if (gdbbx_cache()->attachments_has_attachments($id) || gdbbx_cache()->attachments_has_attachments_errors($id)) {
            require_once(GDBBX_PATH.'modules/attachments/display.php');
            $this->display = new gdbbx_attachments_display($this);

            if (gdbbx_cache()->attachments_has_attachments($id)) {
                $content .= $this->display->show($id);
            }

            if (gdbbx_cache()->attachments_has_attachments_errors($id)) {
                $content.= $this->display->show_errors($id);
            }
        }

        return $content;
    }

    public function embed_form_topic() {
        $forum_id = gdbbx_get_forum_id();

        if ($forum_id == 0) {
            if (gdbbx()->get('forum_not_defined', 'attachments') == 'show') {
                $this->embed_form(true);
            }
        } else {
            if (gdbbx_attachments()->in_topic_form($forum_id)) {
                $this->embed_form();
            }
        }
    }

    public function embed_form_reply() {
        $forum_id = gdbbx_get_forum_id();

        if (gdbbx_attachments()->in_reply_form($forum_id)) {
            $this->embed_form();
        }
    }

    public function embed_form($forced = false) {
        $forum_id = gdbbx_get_forum_id();
        $is_this_edit = bbp_is_topic_edit() || bbp_is_reply_edit();

        $can_upload = apply_filters('gdbbx_attchaments_allow_upload', gdbbx_attachments()->is_user_allowed(), $forum_id);

        if ($can_upload) {
            if ($forced || gdbbx_attachments()->is_active($forum_id)) {
                $this->file_size = apply_filters('gdbbx_attchaments_max_file_size', gdbbx_attachments()->get_file_size($forum_id), $forum_id);

                if ($is_this_edit) {
                    $id = bbp_is_topic_edit() ? bbp_get_topic_id() : bbp_get_reply_id();

                    $attachments = gdbbx_get_post_attachments($id);

                    if (!empty($attachments)) {
                        include(gdbbx_get_template_part('gdbbx-form-attachment-edit.php'));
                    }
                }

                include(gdbbx_get_template_part('gdbbx-form-attachment.php'));

                Enqueue::instance()->attachments();
            }
        }
    }

    public function render_attachment_icon($ext) {
        $icon = $this->icon($ext);

        $cls = 'gdbbx-icon gdbbx-icon-';
        foreach ($this->fonti as $fa => $list) {
            $list = explode('|', $list);

            if (in_array($icon, $list)) {
                $cls.= $fa;
            }
        }

        return '<i class="'.$cls.' gdbbx-fw"></i> ';
    }

    public function icon($ext) {
        foreach ($this->icons as $icon => $list) {
            $list = explode('|', $list);

            if (in_array($ext, $list)) {
                return $icon;
            }
        }

        return 'generic';
    }

    private function _upload_dir_structure() {
        $base = d4p_sanitize_file_path(gdbbx()->get('upload_dir_forums_base', 'attachments'));
        $structure = gdbbx()->get('upload_dir_structure', 'attachments');

        $forum = get_post($this->forum_id);
        $forum_name = $forum->post_name;

        switch ($structure) {
            default:
            case '/forums':
                return '/'.$base;
            case '/forums/forum-id':
                return '/'.$base.'/'.$this->forum_id;
            case '/forums/forum-name':
                return '/'.$base.'/'.$forum_name;
            case '/forums/user-id':
                return '/'.$base.'/'.$this->user_id;
        }
    }
}
