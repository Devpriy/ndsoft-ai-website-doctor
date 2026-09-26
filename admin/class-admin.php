<?php
namespace NDsoft\AIWebsiteDoctor\Admin;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Admin {
    /** @var Dashboard */
    private $dashboard;

    public function __construct() { $this->dashboard = new Dashboard(); }

    public function register() {
        add_action( 'admin_menu', array( $this, 'menu' ) );
        add_action( 'admin_post_ndsoft_aiwd_scan', array( $this->dashboard, 'handle_scan' ) );
        add_action( 'admin_post_ndsoft_aiwd_save_settings', array( $this->dashboard, 'handle_save_settings' ) );
        add_action( 'admin_post_ndsoft_aiwd_clear_history', array( $this->dashboard, 'handle_clear_history' ) );
        add_action( 'admin_post_ndsoft_aiwd_export_report', array( $this->dashboard, 'handle_export_report' ) );
        add_action( 'admin_post_ndsoft_aiwd_maintenance', array( $this->dashboard, 'handle_maintenance' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
        add_filter( 'plugin_action_links_' . NDSOFT_AIWD_BASENAME, array( $this, 'action_links' ) );
    }

    public function menu() {
        add_menu_page(
            __( 'NDsoft AI Website Doctor', 'ndsoft-ai-website-doctor' ),
            __( 'Website Doctor', 'ndsoft-ai-website-doctor' ),
            'manage_options',
            'ndsoft-ai-website-doctor',
            array( $this->dashboard, 'render_dashboard' ),
            'dashicons-heart',
            58
        );

        add_submenu_page( 'ndsoft-ai-website-doctor', __( 'Dashboard', 'ndsoft-ai-website-doctor' ), __( 'Dashboard', 'ndsoft-ai-website-doctor' ), 'manage_options', 'ndsoft-ai-website-doctor', array( $this->dashboard, 'render_dashboard' ) );
        add_submenu_page( 'ndsoft-ai-website-doctor', __( 'History', 'ndsoft-ai-website-doctor' ), __( 'History', 'ndsoft-ai-website-doctor' ), 'manage_options', 'ndsoft-ai-website-doctor-history', array( $this->dashboard, 'render_history' ) );
        add_submenu_page( 'ndsoft-ai-website-doctor', __( 'Reports', 'ndsoft-ai-website-doctor' ), __( 'Reports', 'ndsoft-ai-website-doctor' ), 'manage_options', 'ndsoft-ai-website-doctor-reports', array( $this->dashboard, 'render_reports' ) );
        add_submenu_page( 'ndsoft-ai-website-doctor', __( 'Maintenance', 'ndsoft-ai-website-doctor' ), __( 'Maintenance', 'ndsoft-ai-website-doctor' ), 'manage_options', 'ndsoft-ai-website-doctor-maintenance', array( $this->dashboard, 'render_maintenance' ) );
        add_submenu_page( 'ndsoft-ai-website-doctor', __( 'Settings', 'ndsoft-ai-website-doctor' ), __( 'Settings', 'ndsoft-ai-website-doctor' ), 'manage_options', 'ndsoft-ai-website-doctor-settings', array( $this->dashboard, 'render_settings' ) );
    }

    public function assets( $hook ) {
        if ( false === strpos( (string) $hook, 'ndsoft-ai-website-doctor' ) ) { return; }
        wp_enqueue_style( 'ndsoft-aiwd-admin', NDSOFT_AIWD_URL . 'admin/assets/css/admin.css', array(), NDSOFT_AIWD_VERSION );
        wp_enqueue_script( 'ndsoft-aiwd-admin', NDSOFT_AIWD_URL . 'admin/assets/js/admin.js', array(), NDSOFT_AIWD_VERSION, true );
    }

    /** @param array<int,string> $links Links. @return array<int,string> */
    public function action_links( $links ) {
        array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=ndsoft-ai-website-doctor' ) ) . '">' . esc_html__( 'Dashboard', 'ndsoft-ai-website-doctor' ) . '</a>' );
        return $links;
    }
}
