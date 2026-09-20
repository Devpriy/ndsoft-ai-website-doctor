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
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
    }

    public function menu() {
        add_menu_page(
            __( 'NDsoft AI Website Doctor', 'ndsoft-ai-website-doctor' ),
            __( 'Website Doctor', 'ndsoft-ai-website-doctor' ),
            'manage_options',
            'ndsoft-ai-website-doctor',
            array( $this->dashboard, 'render' ),
            'dashicons-heart',
            58
        );
    }

    public function assets( $hook ) {
        if ( 'toplevel_page_ndsoft-ai-website-doctor' !== $hook ) { return; }
        wp_enqueue_style( 'ndsoft-aiwd-admin', NDSOFT_AIWD_URL . 'admin/assets/css/admin.css', array(), NDSOFT_AIWD_VERSION );
        wp_enqueue_script( 'ndsoft-aiwd-admin', NDSOFT_AIWD_URL . 'admin/assets/js/admin.js', array(), NDSOFT_AIWD_VERSION, true );
    }
}
