<?php

if (!defined('ABSPATH')) { exit; }

class gdbbx_core_info {
    public $code = 'gd-bbpress-toolbox';

    public $version = '6.3.2';
    public $build = 986;
    public $updated = '2020.11.23';
    public $status = 'stable';
    public $edition = 'pro';
    public $url = 'https://plugins.dev4press.com/gd-bbpress-toolbox/';
    public $author_name = 'Milan Petrovic';
    public $author_url = 'https://www.dev4press.com/';
    public $released = '2012.05.27';

    public $php = '5.6';
    public $mysql = '5.1';
    public $wordpress = '4.9';
    public $bbpress = '2.5';

    public $install = false;
    public $update = false;
    public $previous = 0;

    function __construct() { }

    public function to_array() {
        return (array)$this;
    }
}
