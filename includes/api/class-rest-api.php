<?php
namespace NDsoft\AIWebsiteDoctor\API;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class REST_API {
    public function register() {
        add_action( 'rest_api_init', array( $this, 'routes' ) );
    }

    public function routes() {
        register_rest_route(
            'ndsoft-ai-website-doctor/v1',
            '/status',
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'status' ),
                'permission_callback' => static function () { return current_user_can( 'manage_options' ); },
            )
        );
    }

    public function status() {
        return rest_ensure_response(
            array(
                'version'        => NDSOFT_AIWD_VERSION,
                'fixes_enabled'  => false,
                'ai_enabled'     => false,
                'last_scan_at'   => (int) get_option( 'ndsoft_aiwd_last_scan_at', 0 ),
            )
        );
    }
}
