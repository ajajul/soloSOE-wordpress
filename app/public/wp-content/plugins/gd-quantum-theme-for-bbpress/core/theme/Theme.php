<?php

namespace Dev4Press\Plugin\GDQNT\Theme;

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Theme {
	protected $rtl = '';
	protected $name = 'theme';
	protected $overrides = array();
	protected $settings = array();
	protected $values = array();

	public function __construct() {
		$this->init();

		$this->rtl = is_rtl() ? '-rtl' : '';
	}

	/** @return Theme */
	public static function instance() {
		static $instance = array();

		$class = get_called_class();

		if ( ! isset( $instance[ $class ] ) ) {
			$instance[ $class ] = new $class();
		}

		return $instance[ $class ];
	}

	public function compile() {
		$import  = join( D4P_EOL, $this->import() );
		$the_key = $this->transient_key( md5( json_encode( $import ) ) );
		$compile = get_transient( $the_key );

		if ( ! $compile ) {
			require_once( GDQNT_PATH . 'libs/scssphp/autoload.php' );

			$scss = new Compiler();
			$scss->setOutputStyle( OutputStyle::COMPRESSED );
			$scss->setImportPaths( $this->import_path() );

			$compile = $scss->compile( $import );
			$compile = str_replace( "\\\"\\\\", '"\\', $compile );
			$compile = str_replace( "\\\"", '"', $compile );

			set_transient( $the_key, $compile );
		}

		return $compile;
	}

	protected function init() {
		foreach ( $this->settings as $name ) {
			$this->values[ $name ] = gdqnt_customizer()->get( 'theme-' . $name );
		}
	}

	protected function import() {
		$lines = array();

		foreach ( $this->values as $key => $val ) {
			$lines[] = '$' . $key . ': ' . $val . ';';
		}

		return $lines;
	}

	protected function transient_key( $md5 ) {
		return 'gdnqt-custom-css-' . $md5 . '-' . gdqnt_settings()->information()->build;
	}

	abstract protected function import_path();
}
