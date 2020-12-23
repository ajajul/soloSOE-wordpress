<?php

namespace Dev4Press\Plugin\GDQNT\Theme;

use BBP_Theme_Compat;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Quantum extends BBP_Theme_Compat {
	private $style = 'color-scheme';
	private $force = false;

	private $did_styles = false;
	private $did_scripts = false;

	private $extra_styles = array();
	private $extra_scripts = array();

	private $localize = array();
	private $inline = array();

	private $ajax;
	private $tweaks;
	private $plugins;

	public function __construct( $properties = array() ) {
		parent::__construct( bbp_parse_args( $properties, array(
			'id'      => 'quantum',
			'name'    => 'bbPress Quantum',
			'version' => gdqnt_settings()->info_version,
			'dir'     => trailingslashit( gdqnt()->themes_dir . 'quantum' ),
			'url'     => trailingslashit( gdqnt()->themes_url . 'quantum' )
		), 'quantum_theme' ) );

		$this->setup_objects();
		$this->setup_actions();
	}

	private function setup_objects() {
		require_once( GDQNT_THEME . 'code/compatibility.php' );
		require_once( GDQNT_THEME . 'code/functions.php' );

		$this->ajax    = new Ajax();
		$this->tweaks  = new Tweaks();
		$this->plugins = new Plugins();

		gdqnt_theme();
	}

	private function setup_actions() {
		add_action( 'bbp_init', array( $this, 'prepare_settings' ), 1 );
		add_action( 'bbp_init', array( $this, 'register_styles' ) );
		add_action( 'bbp_init', array( $this, 'register_scripts' ) );

		add_action( 'bbp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'bbp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'bbp_before_main_content', array( $this, 'before_main_content' ) );
		add_action( 'bbp_after_main_content', array( $this, 'after_main_content' ) );

		add_filter( 'bbp_get_template_part', array( $this, 'template_loaded' ), 99, 3 );

		do_action_ref_array( 'bbp_theme_compat_actions', array( &$this ) );
	}

	public function template_loaded( $templates, $slug, $name ) {
		if ( ! $this->did_styles ) {
			$this->_enqueue_styles();
		}

		if ( ! $this->did_scripts ) {
			$this->_enqueue_scripts();
		}

		return $templates;
	}

	public function before_main_content() { ?>

        <div id="bbp-container">
        <div id="bbp-content" role="main" class="gd-quantum-wrapper">

	<?php }

	public function after_main_content() { ?>

        </div>
        </div>

	<?php }

	public function maybe_load_popup() {
		return gdqnt_customizer()->is_ready_new_topic_popup() || gdqnt_customizer()->is_ready_new_reply_popup();
	}

	public function prepare_settings() {
		$this->style = gdqnt_customizer()->get( 'style' );
		$this->force = gdqnt_customizer()->get( 'forced-scripts' );
	}

	public function register_styles() {
		$font = gdqnt_customizer()->get( 'font-embed' ) ? '-embed' : '';
		$rtl  = is_rtl() ? '-rtl' : '';
		$min  = D4P_DEBUG ? '' : '.min';

		$styles = array(
			'gdqnt-grid'     => array(
				'file'         => 'css/grid' . $rtl . $min . '.css',
				'dependencies' => array()
			),
			'gdqnt-font'     => array(
				'file'         => 'css/font' . $font . $min . '.css',
				'dependencies' => array()
			),
			'animated-popup' => array(
				'file'         => GDQNT_D4PLIB_URL . 'resources/libraries/animated-popup/animated-popup.min.css',
				'dependencies' => array()
			)
		);

		if ( $this->style == 'color-scheme' ) {
			$scheme = gdqnt_customizer()->get( 'color-scheme' );
			$url    = gdqnt()->get_style_url( $scheme );

			$styles['gdqnt-core'] = array(
				'file'         => is_null( $url ) ? 'css/theme-' . $scheme . $rtl . $min . '.css' : $url,
				'dependencies' => array( 'gdqnt-grid', 'gdqnt-font' )
			);
		} else if ( $this->style == 'custom-style' ) {
			$styles['gdqnt-core'] = array(
				'file'         => false,
				'dependencies' => array( 'gdqnt-grid', 'gdqnt-font' )
			);
		}

		$default_styles = array_keys( $styles );
		$styles         = apply_filters( 'bbp_default_styles', $styles );

		foreach ( $styles as $handle => $attributes ) {
			if ( $handle == 'animated-popup' ) {
				wp_register_style( $handle, $attributes['file'], $attributes['dependencies'], $this->version );
			} else {
				$this->_register_style( $handle, $attributes['file'], $attributes['dependencies'], $this->version );
			}

			if ( in_array( $handle, $default_styles ) ) {
				$this->extra_styles[] = $handle;
			}
		}
	}

	public function register_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$scripts = array(
			'bbpress-engagements' => array(
				'file'         => 'js/engagements' . $suffix . '.js',
				'dependencies' => array( 'jquery' )
			),
			'bbpress-editor'      => array(
				'file'         => 'js/editor.js',
				'dependencies' => array( 'jquery' )
			),
			'bbpress-reply'       => array(
				'file'         => 'js/reply.js',
				'dependencies' => array( 'jquery' )
			),
			'animated-popup'      => array(
				'file'         => GDQNT_D4PLIB_URL . 'resources/libraries/animated-popup/animated-popup.min.js',
				'dependencies' => array( 'jquery' )
			),
			'bbpress-quantum'     => array(
				'file'         => 'js/quantum' . $suffix . '.js',
				'dependencies' => array( 'jquery', 'bbpress-engagements' )
			)
		);

		if ( bbp_use_wp_editor() ) {
			$scripts['bbpress-quantum']['dependencies'][] = 'bbpress-editor';
		}

		if ( bbp_thread_replies() && ( $this->force || bbp_is_single_topic() ) ) {
			$scripts['bbpress-quantum']['dependencies'][] = 'bbpress-reply';
		}

		$default_scripts = array_keys( $scripts );
		$scripts         = apply_filters( 'bbp_default_scripts', $scripts );

		foreach ( $scripts as $handle => $attributes ) {
			if ( $handle == 'animated-popup' ) {
				wp_register_script( $handle, $attributes['file'], $attributes['dependencies'], $this->version, true );
			} else {
				$this->_register_script( $handle, $attributes['file'], $attributes['dependencies'], $this->version, true );
			}

			if ( in_array( $handle, $default_scripts ) ) {
				$this->extra_scripts[] = $handle;
			}
		}
	}

	public function enqueue_styles() {
		if ( is_bbpress() && ! $this->did_styles ) {
			$this->_enqueue_styles();
		}
	}

	public function enqueue_scripts() {
		if ( is_bbpress() && ! $this->did_scripts ) {
			$this->_enqueue_scripts();
		}
	}

	protected function _register_style( $handle = '', $file = '', $deps = array(), $ver = false, $media = 'all' ) {
		if ( empty( $ver ) ) {
			$ver = bbp_get_version();
		}

		if ( $file === false ) {
			wp_register_style( $handle, false, $deps, $ver, $media );
		} else {
			$located = bbp_locate_enqueueable( $file );

			if ( ! empty( $located ) ) {
				$located = bbp_urlize_enqueueable( $located );

				wp_register_style( $handle, $located, $deps, $ver, $media );
			}
		}
	}

	protected function _register_script( $handle = '', $file = '', $deps = array(), $ver = false, $in_footer = false ) {
		if ( empty( $ver ) ) {
			$ver = bbp_get_version();
		}

		if ( $file === false ) {
			wp_register_script( $handle, false, $deps, $ver, $in_footer );
		} else {
			$located = bbp_locate_enqueueable( $file );

			if ( ! empty( $located ) ) {
				$located = bbp_urlize_enqueueable( $located );

				wp_register_script( $handle, $located, $deps, $ver, $in_footer );
			}
		}
	}

	protected function _enqueue_styles() {
		if ( $this->maybe_load_popup() ) {
			wp_enqueue_style( 'animated-popup' );
		}

		wp_enqueue_style( 'gdqnt-core' );

		foreach ( $this->extra_styles as $handle ) {
			wp_enqueue_style( $handle );
		}

		if ( $this->style == 'custom-style' ) {
			if ( ! in_array( 'custom-style', $this->inline ) ) {
				$theme = gdqnt_customizer()->get( 'color-theme' );

				$path = apply_filters( 'gdqnt_custom_style_class_path', GDQNT_THEME . 'theme/' . $theme . '.php', $theme );

				if ( file_exists( $path ) ) {
					require_once( $path );

					wp_add_inline_style( 'gdqnt-core', gdqnt_theme_custom()->compile() );
				}

				$this->inline[] = 'custom-style';
			}
		}

		if ( ! in_array( 'extra-style', $this->inline ) ) {
			$css = trim( gdqnt_customizer()->get( 'additional-css' ) );

			if ( ! empty( $css ) ) {
				$lines = explode( "\n", $css );
				$lines = array_map( 'trim', $lines );
				$css   = implode( "", $lines );

				wp_add_inline_style( 'gdqnt-core', $css );
			}

			$this->inline[] = 'extra-style';
		}

		$this->did_styles = true;
	}

	protected function _enqueue_scripts() {
		if ( $this->maybe_load_popup() ) {
			wp_enqueue_script( 'animated-popup' );
		}

		if ( bbp_is_single_user_edit() || $this->force ) {
			wp_enqueue_script( 'user-profile' );
		}

		wp_enqueue_script( 'bbpress-quantum' );

		foreach ( $this->extra_scripts as $handle ) {
			wp_enqueue_script( $handle );
		}

		if ( ! in_array( 'engagements', $this->localize ) ) {
			wp_localize_script( 'bbpress-engagements', 'bbpEngagementJS', array(
				'bbp_ajaxurl'        => bbp_get_ajax_url(),
				'generic_ajax_error' => esc_html__( "Something went wrong. Refresh your browser and try again.", "gd-quantum-theme-for-bbpress" )
			) );

			$this->localize[] = 'engagements';
		}

		$this->did_scripts = true;
	}
}
