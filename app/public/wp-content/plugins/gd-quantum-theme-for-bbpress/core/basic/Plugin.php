<?php

namespace Dev4Press\Plugin\GDQNT\Basic;

use Dev4Press\Core\Plugins\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin extends Core {
	public $plugin = 'gd-quantum-theme-for-bbpress';

	public $themes_dir;
	public $themes_url;

	private $themes = array();
	private $styles = array();

	public function __construct() {
		$this->url = GDQNT_URL;

		$this->themes_dir = GDQNT_PATH . 'templates/';
		$this->themes_url = GDQNT_URL . 'templates/';

		parent::__construct();
	}

	public function s() {
		return gdqnt_settings();
	}

	public function run() {
		do_action( 'gdqnt_load_settings' );

		add_action( 'bbp_register_theme_packages', array( $this, 'register_theme' ) );
		add_filter( 'bbp_get_template_locations', array( $this, 'template_locations' ) );

		register_deactivation_hook( GDQNT_PATH . 'gd-quantum-theme-for-bbpress.php', array(
			$this,
			'deactivate_plugin'
		) );
	}

	public function after_setup_theme() {
		$this->themes = array(
			'default-gray' => array(
				'label'   => __( "Default Gray", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'classic-gray' => array(
				'label'   => __( "Classic Gray", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'light-gray'   => array(
				'label'   => __( "Light Gray", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			)
		);

		$this->styles = array(
			'default-gray-red'    => array(
				'label'   => __( "Default Gray with Red", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'default-gray-green'  => array(
				'label'   => __( "Default Gray with Green", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'default-gray-orange' => array(
				'label'   => __( "Default Gray with Orange", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'default-gray-blue'   => array(
				'label'   => __( "Default Gray with Blue", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'default-gray-black'  => array(
				'label'   => __( "Default Gray with Black", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'classic-gray-red'    => array(
				'label'   => __( "Classic Gray with Red", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'classic-gray-green'  => array(
				'label'   => __( "Classic Gray with Green", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'classic-gray-orange' => array(
				'label'   => __( "Classic Gray with Orange", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'classic-gray-blue'   => array(
				'label'   => __( "Classic Gray with Blue", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'classic-gray-black'  => array(
				'label'   => __( "Classic Gray with Black", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'light-gray-red'      => array(
				'label'   => __( "Light Gray with Red", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'light-gray-green'    => array(
				'label'   => __( "Light Gray with Green", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'light-gray-orange'   => array(
				'label'   => __( "Light Gray with Orange", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'light-gray-blue'     => array(
				'label'   => __( "Light Gray with Blue", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			),
			'light-gray-black'    => array(
				'label'   => __( "Light Gray with Black", "gd-quantum-theme-for-bbpress" ),
				'url'     => null,
				'url-rtl' => null
			)
		);

		do_action( 'gdqnt_register_styles' );

		if ( $this->is_quantum_active() ) {
			gdqnt_customizer();
		}
	}

	public function deactivate_plugin() {
		$this->switch_to_bbpress_default_theme();
	}

	public function register_theme() {
		bbp_register_theme_package( array(
			'id'      => 'quantum',
			'name'    => 'bbPress Quantum',
			'version' => bbp_get_version(),
			'dir'     => trailingslashit( gdqnt()->themes_dir . 'quantum' ),
			'url'     => trailingslashit( gdqnt()->themes_url . 'quantum' )
		) );
	}

	public function template_locations( $locations ) {
		if ( $this->is_quantum_active() ) {
			$locations = array(
				'bbquantum',
				''
			);
		}

		return $locations;
	}

	public function add_style( $name, $args = array() ) {
		$defaults = array( 'label' => '', 'url' => '' );

		$this->styles[ $name ] = wp_parse_args( $args, $defaults );
	}

	public function get_color_schemes_list() {
		return wp_list_pluck( $this->styles, 'label' );
	}

	public function get_color_themes_list() {
		return wp_list_pluck( $this->themes, 'label' );
	}

	public function get_color_themes_codes() {
		return array_keys( $this->themes );
	}

	public function get_style_url( $name, $rtl = false ) {
		if ( isset( $this->styles[ $name ] ) ) {
			$key = $rtl ? 'url-rtl' : 'url';

			return isset( $this->styles[ $name ][ $key ] ) ? $this->styles[ $name ][ $key ] : null;
		}

		return null;
	}

	public function is_quantum_active() {
		return get_option( '_bbp_theme_package_id' ) == 'quantum';
	}

	public function switch_to_bbpress_default_theme() {
		update_option( '_bbp_theme_package_id', 'default' );
	}

	public function switch_to_quantum_theme() {
		update_option( '_bbp_theme_package_id', 'quantum' );
	}
}
