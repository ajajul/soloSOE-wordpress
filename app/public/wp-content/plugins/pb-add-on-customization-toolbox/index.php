<?php
/*
	Plugin Name: Profile Builder - Customization Toolbox Add-On
	Plugin URI: https://www.cozmoslabs.com/
	Description: Extends the capabilites of Profile Builder by adding more settings under the Toolbox tab.
	Version: 1.1.2
	Author: Cozmoslabs, Georgian Cocora
	Author URI: https://www.cozmoslabs.com/
	License: GPL2

	== Copyright ==
	Copyright 2015 Cozmoslabs (www.cozmoslabs.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
if ( ! defined( 'ABSPATH' ) ) exit;

class WPPB_toolbox {

    public $tabs;
    public $plugin_url;
    public $plugin_dir;
    public $plugin_basename;
    protected $active_tab = 'forms';

    public function __construct() {
        define( 'PB_TOOLBOX_VERSION', '1.1.2' );

        $this->tabs = array(
            'forms'       => __( 'Forms', 'profile-builder' ),
            'fields'      => __( 'Fields', 'profile-builder' ),
            'userlisting' => __( 'Userlisting', 'profile-builder' ),
            'shortcodes'  => __( 'Shortcodes', 'profile-builder' ),
            'admin'       => __( 'Admin', 'profile-builder' ),
        );

        $this->plugin_url      = plugin_dir_url( __FILE__ );
        $this->plugin_dir      = plugin_dir_path( __FILE__ );
        $this->plugin_basename = plugin_basename( __FILE__ );

        $this->generate_settings();

        add_action( 'admin_menu',            array( &$this, 'register_submenu_page' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
        add_action( 'admin_init',            array( &$this, 'register_settings' ) );
        add_filter( 'plugin_action_links',   array( &$this, 'plugin_action_links'), 10, 2 );

        $this->setup_functions();
    }

    public function register_submenu_page() {
        add_submenu_page( 'profile-builder', __( 'Customization Toolbox', 'profile-builder' ), __( 'Toolbox', 'profile-builder' ), 'manage_options', 'profile-builder-toolbox-settings', array( &$this, 'submenu_page_callback' ) );
    }

    public function submenu_page_callback() {
        reset( $this->tabs );

        if ( isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->tabs) )
            $this->active_tab = sanitize_text_field( $_GET['tab'] );
        ?>
        <div class="wrap wppb-wrap wppb-toolbox-wrap">
            <h2><?php _e( 'Customization Toolbox', 'profile-builder'); ?></h2>

            <h3 class="nav-tab-wrapper">
                <?php
                    foreach ( $this->tabs as $slug => $name ) {
                        if ( $slug == 'userlisting' ) {
                            $wppb_module_settings = get_option('wppb_module_settings');

                            if ( !file_exists( WPPB_PLUGIN_DIR . '/modules/modules.php' ) || !isset( $wppb_module_settings['wppb_userListing'] ) || $wppb_module_settings['wppb_userListing'] != 'show' )
                                continue;
                        }

                        echo '<a href="' . esc_url( add_query_arg( array( 'tab' => $slug ) ) ) . '"  class="nav-tab ' . ( $this->active_tab == $slug ? 'nav-tab-active' : '' ) . '">'. $name .'</a>';
                    }
                ?>
            </h3>

            <?php
                if ( file_exists( $this->plugin_dir . 'includes/views/view-' . $this->active_tab . '.php' ) ) {
                    settings_errors();
                    include_once 'includes/views/view-' . $this->active_tab . '.php';
                }
            ?>
        </div>

        <?php
    }

    private function generate_settings() {
        add_option( 'wppb_toolbox_forms_settings',
            array(
                'ec-bypass'                        => array(),
                'restricted-email-domains-data'    => array(),
                'restricted-email-domains-message' => 'The email address you are trying to register with is not allowed on this website.',
            )
        );

        add_option( 'wppb_toolbox_fields_settings',
            array(
                'restricted-words-fields'  => array(),
                'restricted-words-data'    => array(),
                'restricted-words-message' => 'Your submission contains banned words.',
            )
        );

        add_option( 'wppb_toolbox_userlisting_settings', array() );
        add_option( 'wppb_toolbox_shortcodes_settings', array() );
        add_option( 'wppb_toolbox_admin_settings', array() );
    }

    public function register_settings() {
        register_setting( 'wppb_toolbox_forms_settings',       'wppb_toolbox_forms_settings', array( $this, 'sanitize_forms_settings' ) );
        register_setting( 'wppb_toolbox_fields_settings',      'wppb_toolbox_fields_settings' );
        register_setting( 'wppb_toolbox_userlisting_settings', 'wppb_toolbox_userlisting_settings' );
        register_setting( 'wppb_toolbox_shortcodes_settings',  'wppb_toolbox_shortcodes_settings' );
        register_setting( 'wppb_toolbox_admin_settings',       'wppb_toolbox_admin_settings' );
    }

    public function enqueue_scripts( $hook ) {
        if ( $hook == 'profile-builder_page_profile-builder-toolbox-settings' ) {
            wp_enqueue_script( 'wppb-select2', WPPB_PLUGIN_URL . 'assets/js/select2/select2.min.js', array(), PROFILE_BUILDER_VERSION, true );
            wp_enqueue_style( 'wppb-select2-style', WPPB_PLUGIN_URL . 'assets/css/select2/select2.min.css', false, PROFILE_BUILDER_VERSION );

            wp_enqueue_script( 'wppb-toolbox-scripts', $this->plugin_url . 'assets/js/script.js', array( 'jquery' ), PB_TOOLBOX_VERSION, true );
            wp_enqueue_style( 'wppb-toolbox-style', $this->plugin_url . 'assets/css/style.css', false, PB_TOOLBOX_VERSION );
        }
    }

    public function plugin_action_links( $links, $file ) {
        if ( $file != $this->plugin_basename ) return $links;

        if ( ! current_user_can( 'manage_options' ) ) return $links;

        $settings_link = sprintf( '<a href="%1$s">%2$s</a>',
            menu_page_url( 'profile-builder-toolbox-settings', false ),
            esc_html( __( 'Settings', 'profile-builder' ) ) );

        array_unshift( $links, $settings_link );

        return $links;
    }

    public function sanitize_forms_settings( $settings ) {
        if( !empty( $settings['restricted-email-domains-data'] ) ){
            foreach( $settings['restricted-email-domains-data'] as $key => $email )
                $settings['restricted-email-domains-data'][$key] = strtolower( $email );
        }

        return $settings;
    }

    private function setup_functions() {
        foreach( $this->tabs as $slug => $label ) {
            $settings = get_option( 'wppb_toolbox_' . $slug . '_settings' );

            if ( $settings != false ) {
                foreach ( $settings as $key => $value ) {
                    if ( !empty( $value ) || ( $key == 'redirect-delay-timer' && $value == 0 ) ) {
                        $path = 'includes/' . $slug . '/' . $key . '.php';

                        if ( file_exists( $this->plugin_dir . $path ) )
                            include_once $path;
                    }
                }
            }
        }
    }

}

function wppb_toolbox_init() {
    if ( function_exists( 'wppb_return_bytes' ) ) {
        include 'includes/functions.php';

        new WPPB_toolbox;
    }
}
add_action( 'plugins_loaded', 'wppb_toolbox_init', 11 );
