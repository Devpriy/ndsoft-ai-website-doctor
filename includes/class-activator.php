<?php
namespace NDsoft\AIWebsiteDoctor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Activator {
    public static function activate() {
        if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
            deactivate_plugins( NDSOFT_AIWD_BASENAME );
            wp_die( esc_html__( 'NDsoft AI Website Doctor requires PHP 7.4 or newer.', 'ndsoft-ai-website-doctor' ) );
        }
        add_option( 'ndsoft_aiwd_version', NDSOFT_AIWD_VERSION, '', false );
    }
}
