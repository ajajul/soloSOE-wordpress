<?php

if (!defined('ABSPATH')) exit;

$_panel = d4pupd_admin()->panel === false ? 'whatsnew' : d4pupd_admin()->panel;

if (!in_array($_panel, array('changelog', 'whatsnew', 'info', 'dev4press'))) {
    $_panel = 'whatsnew';
}

include(D4PUPD_PATH.'forms/about/header.php');

include(D4PUPD_PATH.'forms/about/'.$_panel.'.php');

include(D4PUPD_PATH.'forms/about/footer.php');
