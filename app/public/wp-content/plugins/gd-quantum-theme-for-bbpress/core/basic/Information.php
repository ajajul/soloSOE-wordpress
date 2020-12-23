<?php

namespace Dev4Press\Plugin\GDQNT\Basic;

use Dev4Press\Core\Plugins\Information as BaseInformation;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Information extends BaseInformation {
	public $code = 'gd-quantum-theme-for-bbpress';

	public $version = '2.5';
	public $build = 160;
	public $updated = '2020.11.23';
	public $status = 'stable';
	public $edition = 'pro';
	public $released = '2019.03.07';

	public $is_bbpress_plugin = true;

	public $translations = array(
		'da_DK' => array( 'version' => '2.5' ),
		'de_AT' => array( 'version' => '2.5' ),
		'de_DE' => array( 'version' => '2.5' ),
		'de_CH' => array( 'version' => '2.5' ),
		'es_AR' => array( 'version' => '2.5' ),
		'es_ES' => array( 'version' => '2.5' ),
		'es_MX' => array( 'version' => '2.5' ),
		'fr_BE' => array( 'version' => '2.5' ),
		'fr_CA' => array( 'version' => '2.5' ),
		'fr_FR' => array( 'version' => '2.5' ),
		'it_IT' => array( 'version' => '2.5' ),
		'nl_NL' => array( 'version' => '2.5' ),
		'pl_PL' => array( 'version' => '2.5' ),
		'pt_BR' => array( 'version' => '2.5' ),
		'pt_PT' => array( 'version' => '2.5' ),
		'ru_RU' => array( 'version' => '2.5' ),
		'sr_RS' => array( 'version' => '2.5' )
	);

	public function __construct() {
		$this->plugins['bbpress'] = '2.6.2';
	}
}
