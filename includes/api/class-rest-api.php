<?php
namespace NDsoft\AIWebsiteDoctor\API;

use NDsoft\AIWebsiteDoctor\History\Change_Tracker;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class REST_API {
    public function register() { add_action( 'rest_api_init', array( $this, 'routes' ) ); }

    public function routes() {
        $permission = static function () { return current_user_can( 'manage_options' ); };
        register_rest_route( 'ndsoft-ai-website-doctor/v1', '/status', array( 'methods' => 'GET', 'callback' => array( $this, 'status' ), 'permission_callback' => $permission ) );
        register_rest_route( 'ndsoft-ai-website-doctor/v1', '/latest-scan', array( 'methods' => 'GET', 'callback' => array( $this, 'latest_scan' ), 'permission_callback' => $permission ) );
        register_rest_route( 'ndsoft-ai-website-doctor/v1', '/history', array( 'methods' => 'GET', 'callback' => array( $this, 'history' ), 'permission_callback' => $permission ) );
    }

    public function status() {
        $history = ( new Change_Tracker() )->history();
        return rest_ensure_response( array( 'version' => NDSOFT_AIWD_VERSION, 'core_diagnostics' => true, 'local_diagnosis' => true, 'maintenance_tools' => true, 'cloud_ai_enabled' => false, 'last_scan_at' => (int) get_option( 'ndsoft_aiwd_last_scan_at', 0 ), 'history_entries' => count( $history ) ) );
    }

    public function latest_scan() { return rest_ensure_response( get_option( 'ndsoft_aiwd_last_scan', array() ) ); }
    public function history() { return rest_ensure_response( ( new Change_Tracker() )->history() ); }
}
