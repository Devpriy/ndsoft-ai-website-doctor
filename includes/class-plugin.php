<?php
namespace NDsoft\AIWebsiteDoctor;

use NDsoft\AIWebsiteDoctor\Admin\Admin;
use NDsoft\AIWebsiteDoctor\API\REST_API;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Plugin {
    /** @var self|null */
    private static $instance = null;
    private function __construct() {}
    private function __clone() {}

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    public function run() {
        load_plugin_textdomain( 'ndsoft-ai-website-doctor', false, dirname( NDSOFT_AIWD_BASENAME ) . '/languages' );
        if ( is_admin() ) { ( new Admin() )->register(); }
        ( new REST_API() )->register();
        if ( get_option( 'ndsoft_aiwd_version' ) !== NDSOFT_AIWD_VERSION ) {
            update_option( 'ndsoft_aiwd_version', NDSOFT_AIWD_VERSION, false );
        }
    }
}
