<?php

namespace Dev4Press\Plugin\GDQNT\Customizer;

use Dev4Press\WordPress\Customizer\Control\Divider;
use Dev4Press\WordPress\Customizer\Control\Slider;
use Dev4Press\WordPress\Customizer\Manager as Dev4PressManager;
use Dev4Press\WordPress\Customizer\Section\Link;
use WP_Customize_Code_Editor_Control;
use WP_Customize_Color_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Manager extends Dev4PressManager {
	protected $_prefix = 'gdqnt-';
	protected $_panel = 'gd-quantum-bbpress';

	protected $_defaults = array(
		'style' => 'color-scheme',

		'color-scheme' => 'default-gray-red',
		'color-theme'  => 'default-gray',

		'theme-color-text'                    => '#222222',
		'theme-color-link'                    => '#990000',
		'theme-color-background'              => '#ffffff',
		'theme-color-common-background'       => '#eeeeee',
		'theme-color-sticky-background'       => '#ffffe0',
		'theme-color-super-sticky-background' => '#ffffe0',
		'theme-color-spam-background'         => '#ffeeee',
		'theme-color-trash-background'        => '#ffe0ff',
		'theme-color-pending-background'      => '#eeeeff',
		'theme-font-size'                     => 14,
		'theme-line-height'                   => 22,

		'theme-light-gray-color-calc-background-override'  => false,
		'theme-light-gray-color-calc-background'           => '#f6f6f6',
		'theme-light-gray-color-calc-border-override'      => false,
		'theme-light-gray-color-calc-border'               => '#dcdcdc',
		'theme-light-gray-color-calc-text-override'        => false,
		'theme-light-gray-color-calc-text'                 => '#222222',
		'theme-light-gray-color-calc-link-override'        => false,
		'theme-light-gray-color-calc-link'                 => '#990000',
		'theme-light-gray-color-form-button-link-override' => false,
		'theme-light-gray-color-form-button-link'          => '#990000',

		'theme-classic-gray-color-calc-border-override'      => false,
		'theme-classic-gray-color-calc-border'               => '#dcdcdc',
		'theme-classic-gray-color-calc-text-override'        => false,
		'theme-classic-gray-color-calc-text'                 => '#222222',
		'theme-classic-gray-color-calc-link-override'        => false,
		'theme-classic-gray-color-calc-link'                 => '#990000',
		'theme-classic-gray-border-radius-override'          => false,
		'theme-classic-gray-border-radius'                   => 3,
		'theme-classic-gray-color-form-button-link-override' => false,
		'theme-classic-gray-color-form-button-link'          => '#990000',

		'theme-default-gray-color-form-background-override'          => false,
		'theme-default-gray-color-form-background'                   => '#ffffff',
		'theme-default-gray-color-form-border-override'              => false,
		'theme-default-gray-color-form-border'                       => '#e3e3e3',
		'theme-default-gray-color-form-text-override'                => false,
		'theme-default-gray-color-form-text'                         => '#222222',
		'theme-default-gray-color-form-link-override'                => false,
		'theme-default-gray-color-form-link'                         => '#990000',
		'theme-default-gray-color-form-button-link-override'         => false,
		'theme-default-gray-color-form-button-link'                  => '#990000',
		'theme-default-gray-color-form-search-border-override'       => false,
		'theme-default-gray-color-form-search-border'                => '#e3e3e3',
		'theme-default-gray-color-list-header-background-override'   => false,
		'theme-default-gray-color-list-header-background'            => '#e3e3e3',
		'theme-default-gray-color-list-header-text-override'         => false,
		'theme-default-gray-color-list-header-text'                  => '#222222',
		'theme-default-gray-color-list-row-background-override'      => false,
		'theme-default-gray-color-list-row-background'               => '#eeeeee',
		'theme-default-gray-color-list-row-text-override'            => false,
		'theme-default-gray-color-list-row-text'                     => '#222222',
		'theme-default-gray-color-list-row-link-override'            => false,
		'theme-default-gray-color-list-row-link'                     => '#990000',
		'theme-default-gray-color-post-author-background-override'   => false,
		'theme-default-gray-color-post-author-background'            => '#eeeeee',
		'theme-default-gray-color-post-author-text-override'         => false,
		'theme-default-gray-color-post-author-text'                  => '#222222',
		'theme-default-gray-color-post-author-link-override'         => false,
		'theme-default-gray-color-post-author-link'                  => '#990000',
		'theme-default-gray-color-action-banner-background-override' => false,
		'theme-default-gray-color-action-banner-background'          => '#eeeeee',
		'theme-default-gray-color-action-banner-text-override'       => false,
		'theme-default-gray-color-action-banner-text'                => '#222222',
		'theme-default-gray-color-action-banner-link-override'       => false,
		'theme-default-gray-color-action-banner-link'                => '#990000',
		'theme-default-gray-color-breadcrumbs-background-override'   => false,
		'theme-default-gray-color-breadcrumbs-background'            => '#eeeeee',
		'theme-default-gray-color-breadcrumbs-text-override'         => false,
		'theme-default-gray-color-breadcrumbs-text'                  => '#222222',
		'theme-default-gray-color-breadcrumbs-link-override'         => false,
		'theme-default-gray-color-breadcrumbs-link'                  => '#990000',
		'theme-default-gray-color-topic-tag-background-override'     => false,
		'theme-default-gray-color-topic-tag-background'              => '#eeeeee',
		'theme-default-gray-color-topic-tag-border-override'         => false,
		'theme-default-gray-color-topic-tag-border'                  => '#222222',
		'theme-default-gray-color-topic-tag-link-override'           => false,
		'theme-default-gray-color-topic-tag-link'                    => '#990000',
		'theme-default-gray-color-pager-numbers-background-override' => false,
		'theme-default-gray-color-pager-numbers-background'          => '#eeeeee',
		'theme-default-gray-color-pager-numbers-link-override'       => false,
		'theme-default-gray-color-pager-numbers-link'                => '#990000',

		'breadcrumbs'      => true,
		'search-show-form' => true,
		'font-embed'       => true,
		'forced-scripts'   => false,

		'profile-show-registration-date'  => true,
		'profile-favorites-tab-is-public' => true,

		'forum-colum-four'       => 'freshness',
		'forum-list-subforums'   => true,
		'forum-single-content'   => false,
		'forum-action-new-topic' => true,
		'forum-popup-new-topic'  => false,
		'topic-lead-topic'       => true,
		'topic-action-new-reply' => true,
		'topic-actions-block'    => false,
		'topic-popup-new-reply'  => false,
		'posts-controls'         => 'dropdown',

		'popup-topic-show-cta' => true,
		'popup-reply-show-cta' => true,

		'additional-css' => ''
	);

	/** @return Manager */
	public static function instance() {
		static $_gdqnt_manager = null;

		if ( ! isset( $_gdqnt_manager ) ) {
			$_gdqnt_manager = new Manager();
		}

		return $_gdqnt_manager;
	}

	public function enqueue() {
		parent::enqueue();

		wp_enqueue_script( 'gdqnt-customizer', gdqnt()->file( 'js', 'customizer' ), array( 'd4p-customizer' ), gdqnt_settings()->file_version(), true );
	}

	public function is_ready_new_topic_popup() {
		return bbp_is_single_forum() && gdqnt_customizer()->get( 'forum-popup-new-topic' );
	}

	public function is_ready_new_reply_popup() {
		return bbp_is_single_topic() && ! bbp_allow_threaded_replies() && gdqnt_customizer()->get( 'topic-popup-new-reply' );
	}

	protected function _init() {
		$this->_lib_path = GDQNT_D4PLIB_PATH;
		$this->_lib_url  = GDQNT_URL . 'd4plib/';
	}

	protected function _panels() {
		$this->c()->add_panel( $this->_panel, array(
			'title'       => __( "bbPress Quantum", "gd-quantum-theme-for-bbpress" ),
			'description' => esc_html__( "Control settings for the Quantum theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );
	}

	protected function _sections() {
		$this->c()->add_section( $this->section( 'style' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Style", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control styling for GD Quantum Theme for bbPress. You can use predefined colour scheme, or you can build your own by changing basic colors, typography and override additional colors.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'profile' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "User Profile", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control over the user profile pages for GD Quantum Theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'forums' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Forums", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control over the forums pages for GD Quantum Theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'topics' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Topics", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control over the topics pages for GD Quantum Theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'popups' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Popups", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control settings for popup dialogs for GD Quantum Theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'settings' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Settings", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control general settings for GD Quantum Theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'advanced' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Advanced", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Control advanced settings for GD Quantum Theme for bbPress.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( $this->section( 'css' ), array(
			'panel'              => $this->_panel,
			'title'              => __( "Additional CSS", "gd-quantum-theme-for-bbpress" ),
			'description_hidden' => true,
			'description'        => esc_html__( "Add CSS styling for some additional customizations. This CSS will be added after the main plugin CSS styling. And, it will be loaded only on the bbPress related content pages.", "gd-quantum-theme-for-bbpress" )
		) );

		$this->c()->add_section( new Link( $this->c(), $this->section( 'bbpress' ),
			array(
				'panel'     => $this->_panel,
				'title'     => __( "More bbPress Plugins", "gd-quantum-theme-for-bbpress" ),
				'url'       => 'https://bbpress.dev4press.com',
				'backcolor' => '#376122',
				'textcolor' => '#ffffff'
			)
		) );
	}

	protected function _settings() {
		$this->c()->add_setting( $this->name( 'additional-css' ), array(
			'default' => $this->get_default( 'additional-css' )
		) );

		$this->c()->add_setting( $this->name( 'style' ), array(
			'default'           => $this->get_default( 'style' ),
			'sanitize_callback' => 'wp_filter_nohtml_kses'
		) );

		$this->c()->add_setting( $this->name( 'color-scheme' ), array(
			'default'           => $this->get_default( 'color-scheme' ),
			'sanitize_callback' => 'wp_filter_nohtml_kses'
		) );

		$this->c()->add_setting( $this->name( 'color-theme' ), array(
			'default'           => $this->get_default( 'color-theme' ),
			'sanitize_callback' => 'wp_filter_nohtml_kses'
		) );

		$this->c()->add_setting( $this->name( 'theme-color-text' ), array(
			'default'           => $this->get_default( 'theme-color-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-link' ), array(
			'default'           => $this->get_default( 'theme-color-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-background' ), array(
			'default'           => $this->get_default( 'theme-color-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-common-background' ), array(
			'default'           => $this->get_default( 'theme-color-common-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-sticky-background' ), array(
			'default'           => $this->get_default( 'theme-color-sticky-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-super-sticky-background' ), array(
			'default'           => $this->get_default( 'theme-color-super-sticky-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-spam-background' ), array(
			'default'           => $this->get_default( 'theme-color-spam-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-trash-background' ), array(
			'default'           => $this->get_default( 'theme-color-trash-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-color-pending-background' ), array(
			'default'           => $this->get_default( 'theme-color-pending-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-font-size' ), array(
			'default'           => $this->get_default( 'theme-font-size' ),
			'sanitize_callback' => array( $this, 'sanitize_slider' )
		) );

		$this->c()->add_setting( $this->name( 'theme-line-height' ), array(
			'default'           => $this->get_default( 'theme-line-height' ),
			'sanitize_callback' => array( $this, 'sanitize_slider' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-border-radius-override' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-border-radius-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-border-radius' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-border-radius' ),
			'sanitize_callback' => array( $this, 'sanitize_slider' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-background-override' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-background' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-border-override' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-border-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-border' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-border' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-text-override' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-text' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-link-override' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-calc-link' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-calc-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-form-button-link-override' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-form-button-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-light-gray-color-form-button-link' ), array(
			'default'           => $this->get_default( 'theme-light-gray-color-form-button-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-calc-border-override' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-calc-border-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-calc-border' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-calc-border' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-calc-text-override' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-calc-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-calc-text' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-calc-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-calc-link-override' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-calc-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-calc-link' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-calc-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-form-button-link-override' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-form-button-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-classic-gray-color-form-button-link' ), array(
			'default'           => $this->get_default( 'theme-classic-gray-color-form-button-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-border-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-border-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-border' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-border' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-text-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-text' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-search-border-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-search-border-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-search-border' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-search-border' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-button-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-button-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-form-button-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-form-button-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-header-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-header-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-header-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-header-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-header-text-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-header-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-header-text' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-header-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-row-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-row-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-row-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-row-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-row-text-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-row-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-row-text' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-row-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-row-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-row-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-list-row-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-list-row-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-post-author-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-post-author-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-post-author-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-post-author-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-post-author-text-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-post-author-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-post-author-text' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-post-author-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-post-author-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-post-author-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-post-author-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-post-author-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-action-banner-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-action-banner-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-action-banner-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-action-banner-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-action-banner-text-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-action-banner-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-action-banner-text' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-action-banner-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-action-banner-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-action-banner-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-action-banner-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-action-banner-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-breadcrumbs-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-breadcrumbs-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-breadcrumbs-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-breadcrumbs-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-breadcrumbs-text-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-breadcrumbs-text-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-breadcrumbs-text' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-breadcrumbs-text' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-breadcrumbs-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-breadcrumbs-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-breadcrumbs-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-breadcrumbs-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-topic-tag-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-topic-tag-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-topic-tag-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-topic-tag-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-topic-tag-border-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-topic-tag-border-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-topic-tag-border' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-topic-tag-border' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-topic-tag-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-topic-tag-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-topic-tag-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-topic-tag-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-pager-numbers-background-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-pager-numbers-background-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-pager-numbers-background' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-pager-numbers-background' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-pager-numbers-link-override' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-pager-numbers-link-override' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'theme-default-gray-color-pager-numbers-link' ), array(
			'default'           => $this->get_default( 'theme-default-gray-color-pager-numbers-link' ),
			'sanitize_callback' => array( $this, 'sanitize_color' )
		) );

		$this->c()->add_setting( $this->name( 'breadcrumbs' ), array(
			'default'           => $this->get_default( 'breadcrumbs' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'font-embed' ), array(
			'default'           => $this->get_default( 'font-embed' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'forced-scripts' ), array(
			'default'           => $this->get_default( 'forced-scripts' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'forum-colum-four' ), array(
			'default'           => $this->get_default( 'forum-colum-four' ),
			'sanitize_callback' => 'wp_filter_nohtml_kses'
		) );

		$this->c()->add_setting( $this->name( 'forum-list-subforums' ), array(
			'default'           => $this->get_default( 'forum-list-subforums' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'forum-action-new-topic' ), array(
			'default'           => $this->get_default( 'forum-action-new-topic' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'forum-popup-new-topic' ), array(
			'default'           => $this->get_default( 'forum-popup-new-topic' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'search-show-form' ), array(
			'default'           => $this->get_default( 'search-show-form' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'forum-single-content' ), array(
			'default'           => $this->get_default( 'forum-single-content' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'topic-actions-block' ), array(
			'default'           => $this->get_default( 'topic-actions-block' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'topic-action-new-reply' ), array(
			'default'           => $this->get_default( 'topic-action-new-reply' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'topic-popup-new-reply' ), array(
			'default'           => $this->get_default( 'topic-popup-new-reply' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'topic-lead-topic' ), array(
			'default'           => $this->get_default( 'topic-lead-topic' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'posts-controls' ), array(
			'default'           => $this->get_default( 'posts-controls' ),
			'sanitize_callback' => 'wp_filter_nohtml_kses'
		) );

		$this->c()->add_setting( $this->name( 'profile-show-registration-date' ), array(
			'default'           => $this->get_default( 'profile-show-registration-date' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'profile-favorites-tab-is-public' ), array(
			'default'           => $this->get_default( 'profile-favorites-tab-is-public' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'popup-topic-show-cta' ), array(
			'default'           => $this->get_default( 'popup-topic-show-cta' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'popup-reply-show-cta' ), array(
			'default'           => $this->get_default( 'popup-reply-show-cta' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );

		$this->c()->add_setting( $this->name( 'divider-profile-tweaks' ) );
		$this->c()->add_setting( $this->name( 'divider-popups-tweaks' ) );
		$this->c()->add_setting( $this->name( 'divider-forums-tweaks' ) );
		$this->c()->add_setting( $this->name( 'divider-topics-tweaks' ) );
		$this->c()->add_setting( $this->name( 'divider-settings-tweaks' ) );
		$this->c()->add_setting( $this->name( 'divider-settings-fonts' ) );
		$this->c()->add_setting( $this->name( 'divider-settings-scripts' ) );
		$this->c()->add_setting( $this->name( 'theme-classic-gray-divider-more' ) );
		$this->c()->add_setting( $this->name( 'theme-divider-color-theme' ) );
		$this->c()->add_setting( $this->name( 'theme-divider-row-colors' ) );
		$this->c()->add_setting( $this->name( 'theme-divider-typography-theme' ) );
		$this->c()->add_setting( $this->name( 'theme-divider-extra-colors' ) );
		$this->c()->add_setting( $this->name( 'more-bbpress-link' ) );
	}

	protected function _controls() {
		$this->c()->add_control( $this->name( 'style' ), array(
			'label'       => __( "Style", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Choose which colour scheme styles to load.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' ),
			'type'        => 'select',
			'choices'     => $this->_styles_list()
		) );

		$this->c()->add_control( $this->name( 'color-scheme' ), array(
			'label'       => __( "Color Scheme", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Choose which colour scheme styles to load.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' ),
			'type'        => 'select',
			'choices'     => gdqnt()->get_color_schemes_list()
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'theme-divider-color-theme' ), array(
			'label'       => __( "Custom Colour Styling", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Select basic styling and custom colors to use.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'color-theme' ), array(
			'label'   => __( "Basic Colour Theme", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'select',
			'choices' => gdqnt()->get_color_themes_list()
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-text' ), array(
			'label'   => __( "Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-link' ), array(
			'label'   => __( "Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-background' ), array(
			'label'   => __( "Main Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-common-background' ), array(
			'label'   => __( "Common Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'theme-divider-typography-theme' ), array(
			'label'       => __( "Custom Typography", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Set various typography related settings.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new Slider( $this->c(), $this->name( 'theme-font-size' ), array(
			'label'       => __( "Font Size", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' ),
			'input_attrs' => array(
				'min'  => 8,
				'max'  => 24,
				'step' => 1
			)
		) ) );

		$this->c()->add_control( new Slider( $this->c(), $this->name( 'theme-line-height' ), array(
			'label'       => __( "Line Height", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' ),
			'input_attrs' => array(
				'min'  => 12,
				'max'  => 36,
				'step' => 1
			)
		) ) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'theme-divider-row-colors' ), array(
			'label'       => __( "Row background colors", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Colors for sticky, spam, pending and trash topics.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-sticky-background' ), array(
			'label'   => __( "Sticky Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-super-sticky-background' ), array(
			'label'   => __( "Super Sticky Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-spam-background' ), array(
			'label'   => __( "Spam Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-trash-background' ), array(
			'label'   => __( "Trash Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-color-pending-background' ), array(
			'label'   => __( "Pending Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'theme-classic-gray-divider-more' ), array(
			'label'       => __( "Additional Settings", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Set additional settings for the theme.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-classic-gray-border-radius-override' ), array(
			'label'   => __( "Border Radius", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new Slider( $this->c(), $this->name( 'theme-classic-gray-border-radius' ), array(
			'section'     => $this->section( 'style' ),
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 15,
				'step' => 1
			)
		) ) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'theme-divider-extra-colors' ), array(
			'label'       => __( "Additional Colors Override", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Set additional colors used for various theme elements.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-light-gray-color-calc-background-override' ), array(
			'label'   => __( "Elements Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-light-gray-color-calc-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-light-gray-color-calc-border-override' ), array(
			'label'   => __( "Border Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-light-gray-color-calc-border' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-light-gray-color-calc-text-override' ), array(
			'label'   => __( "Elements Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-light-gray-color-calc-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-light-gray-color-calc-link-override' ), array(
			'label'   => __( "Elements Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-light-gray-color-calc-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-light-gray-color-form-button-link-override' ), array(
			'label'   => __( "Button Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-light-gray-color-form-button-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-classic-gray-color-calc-border-override' ), array(
			'label'   => __( "Border Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-classic-gray-color-calc-border' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-classic-gray-color-calc-text-override' ), array(
			'label'   => __( "Elements Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-classic-gray-color-calc-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-classic-gray-color-calc-link-override' ), array(
			'label'   => __( "Elements Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-classic-gray-color-calc-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-classic-gray-color-form-button-link-override' ), array(
			'label'   => __( "Button Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-classic-gray-color-form-button-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-form-background-override' ), array(
			'label'   => __( "Form Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-form-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-form-border-override' ), array(
			'label'   => __( "Form Border Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-form-border' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-form-text-override' ), array(
			'label'   => __( "Form Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-form-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-form-link-override' ), array(
			'label'   => __( "Form Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-form-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-form-search-border-override' ), array(
			'label'   => __( "Form Search Border Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-form-search-border' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-form-button-link-override' ), array(
			'label'   => __( "Button Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-form-button-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-list-header-background-override' ), array(
			'label'   => __( "List Header Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-list-header-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-list-header-text-override' ), array(
			'label'   => __( "List Header Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-list-header-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-list-row-background-override' ), array(
			'label'   => __( "List Row Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-list-row-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-list-row-text-override' ), array(
			'label'   => __( "List Row Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-list-row-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-list-row-link-override' ), array(
			'label'   => __( "List Row Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-list-row-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-post-author-background-override' ), array(
			'label'   => __( "Post Author Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-post-author-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-post-author-text-override' ), array(
			'label'   => __( "Post Author Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-post-author-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-post-author-link-override' ), array(
			'label'   => __( "Post Author Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-post-author-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-action-banner-background-override' ), array(
			'label'   => __( "Action Banner Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-action-banner-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-action-banner-text-override' ), array(
			'label'   => __( "Action Banner Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-action-banner-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-action-banner-link-override' ), array(
			'label'   => __( "Action Banner Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-action-banner-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-breadcrumbs-background-override' ), array(
			'label'   => __( "Breadcrumbs Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-breadcrumbs-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-breadcrumbs-text-override' ), array(
			'label'   => __( "Breadcrumbs Text Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-breadcrumbs-text' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-breadcrumbs-link-override' ), array(
			'label'   => __( "Breadcrumbs Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-breadcrumbs-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-topic-tag-background-override' ), array(
			'label'   => __( "Topic Tag Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-topic-tag-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-topic-tag-border-override' ), array(
			'label'   => __( "Topic Tag Border Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-topic-tag-border' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-topic-tag-link-override' ), array(
			'label'   => __( "Topic Tag Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-topic-tag-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-pager-numbers-background-override' ), array(
			'label'   => __( "Pager Numbers Background Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-pager-numbers-background' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( $this->name( 'theme-default-gray-color-pager-numbers-link-override' ), array(
			'label'   => __( "Pager Numbers Link Color", "gd-quantum-theme-for-bbpress" ),
			'section' => $this->section( 'style' ),
			'type'    => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Color_Control( $this->c(), $this->name( 'theme-default-gray-color-pager-numbers-link' ), array(
			'section' => $this->section( 'style' )
		) ) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-profile-tweaks' ), array(
			'label'       => __( "Profile Tweaks", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Additional settings for configuring the display of user profile pages.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'profile' ),
			'input_attrs' => array( 'hide_line' => true )
		) ) );

		$this->c()->add_control( $this->name( 'profile-show-registration-date' ), array(
			'label'       => __( "Show registered information", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Show when the user account was registered.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'profile' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'profile-favorites-tab-is-public' ), array(
			'label'       => __( "Everyone can see Favorites page", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Favorites tab is public by default, with this option you can make it private.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'profile' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'forum-colum-four' ), array(
			'label'       => __( "Forums list Last Column", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "This option controls the content of the last column of the forums lists.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'forums' ),
			'type'        => 'select',
			'choices'     => $this->_forum_column_four()
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-forums-tweaks' ), array(
			'label'       => __( "Forum Tweaks", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Additional settings for configuring the display of forums pages.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'forums' )
		) ) );

		$this->c()->add_control( $this->name( 'forum-list-subforums' ), array(
			'label'       => __( "List subforums in Forums lists", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "If the forum has subforums, the subforums will be listed in forum index lists.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'forums' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'forum-single-content' ), array(
			'label'       => __( "Show forum description", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "If the forum has a description set, it will be displayed on the top of the forum single page.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'forums' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'forum-action-new-topic' ), array(
			'label'       => __( "Show New Topic Action", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Show button for New Topic in each forum inside the top action bar, if the user can post new topic in the current forum.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'forums' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'forum-popup-new-topic' ), array(
			'label'       => __( "Show New Topic in a popup", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "New topic form will be hidden, and displayed as a popup.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'forums' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-topics-tweaks' ), array(
			'label'       => __( "Topic Tweaks", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Additional settings for configuring the display of topics pages.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'topics' ),
			'input_attrs' => array( 'hide_line' => true )
		) ) );

		$this->c()->add_control( $this->name( 'topic-actions-block' ), array(
			'label'       => __( "Show actions block", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Show actions block similar to forums on the single topic page above the topics and replies.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'topics' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'topic-action-new-reply' ), array(
			'label'       => __( "Show New Reply action", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Show button for New Reply in each topic inside the top action bar or topic heading, if the user can post new reply for the current topic.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'topics' ),
			'type'        => 'checkbox'
		) );

		if ( ! bbp_allow_threaded_replies() ) {
			$this->c()->add_control( $this->name( 'topic-popup-new-reply' ), array(
				'label'       => __( "Show New Reply in a popup", "gd-quantum-theme-for-bbpress" ),
				'description' => __( "New reply form will be hidden, and displayed as a popup.", "gd-quantum-theme-for-bbpress" ),
				'section'     => $this->section( 'topics' ),
				'type'        => 'checkbox'
			) );
		}

		$this->c()->add_control( $this->name( 'topic-lead-topic' ), array(
			'label'       => __( "Show lead topic", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Show main topic separated from the replies on the single topic page.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'topics' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'posts-controls' ), array(
			'label'       => __( "Posts Controls", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "This option affects the way Topics and Replies controls inside the single topic threads are displayed.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'settings' ),
			'type'        => 'select',
			'choices'     => $this->_posts_controls()
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-settings-tweaks' ), array(
			'label'       => __( "More Tweaks", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Additional tweaks for various forum features.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'settings' )
		) ) );

		$this->c()->add_control( $this->name( 'breadcrumbs' ), array(
			'label'       => __( "Show breadcrumbs", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Breadcrumbs are displayed on each forum page by default, with this option you can disable them.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'settings' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'search-show-form' ), array(
			'label'       => __( "Show form on search page", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Always show search form on the search results page.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'settings' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-popups-tweaks' ), array(
			'label'       => __( "Popups Tweaks", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Additional settings for configuring the display of topic and reply popups.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'popups' ),
			'input_attrs' => array( 'hide_line' => true )
		) ) );

		$this->c()->add_control( $this->name( 'popup-topic-show-cta' ), array(
			'label'       => __( "Show New Topic Banner", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "If new topic popup is enabled, this option will add simple banner control with the New Topic button to open the popup.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'popups' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( $this->name( 'popup-reply-show-cta' ), array(
			'label'       => __( "Show New Reply Banner", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "If new reply popup is enabled, this option will add simple banner control with the New Reply button to open the popup.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'popups' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-settings-fonts' ), array(
			'label'       => __( "Font Icons", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Control over loading of font icons.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'advanced' ),
			'input_attrs' => array( 'hide_line' => true )
		) ) );

		$this->c()->add_control( $this->name( 'font-embed' ), array(
			'label'       => __( "Load WOFF/WOFF2 Embedded CSS", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Because of the small font size, it is beneficial to load embedded version of the font CSS where the WOFF and WOFF2 font variants are inside the CSS, and not required to load as external files.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'advanced' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( new Divider( $this->c(), $this->name( 'divider-settings-scripts' ), array(
			'label'       => __( "JavaScript", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Control over loading of JavaScript.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'advanced' ),
		) ) );

		$this->c()->add_control( $this->name( 'forced-scripts' ), array(
			'label'       => __( "Force loading of JavaScript files", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "If you use shortcodes to embed forums or topics into static pages, it is recommended to force loading of JavaScript files because the bbPress pages can't be properly detected.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'advanced' ),
			'type'        => 'checkbox'
		) );

		$this->c()->add_control( new WP_Customize_Code_Editor_Control( $this->c(), $this->name( 'additional-css' ), array(
			'label'       => __( "CSS Code", "gd-quantum-theme-for-bbpress" ),
			'description' => __( "Set additional colors used for various theme elements.", "gd-quantum-theme-for-bbpress" ),
			'section'     => $this->section( 'css' ),
			'code_type'   => 'text/css',
			'input_attrs' => array(
				'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
			)
		) ) );

		$this->c()->add_control( $this->name( 'more-bbpress-link' ), array(
			'section' => $this->section( 'bbpress' )
		) );
	}

	private function _forum_column_four() {
		return array(
			'freshness' => __( "Freshness", "gd-quantum-theme-for-bbpress" ),
			'activity'  => __( "Last Activity", "gd-quantum-theme-for-bbpress" )
		);
	}

	private function _posts_controls() {
		return array(
			'dropdown' => __( "Dropdown", "gd-quantum-theme-for-bbpress" ),
			'links'    => __( "Links", "gd-quantum-theme-for-bbpress" )
		);
	}

	private function _styles_list() {
		return array(
			'color-scheme' => __( "Predefined Colour Scheme", "gd-quantum-theme-for-bbpress" ),
			'custom-style' => __( "Custom Colour Styling", "gd-quantum-theme-for-bbpress" )
		);
	}
}
