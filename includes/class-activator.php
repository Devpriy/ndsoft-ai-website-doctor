<?php
namespace NDsoft\AIWebsiteDoctor;

use NDsoft\AIWebsiteDoctor\Settings\Settings;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Activator {
    public static function activate() {
        if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
            deactivate_plugins( NDSOFT_AIWD_BASENAME );
            wp_die( esc_html__( 'NDsoft AI Website Doctor requires PHP 7.4 or newer.', 'ndsoft-ai-website-doctor' ) );
        }
        update_option( 'ndsoft_aiwd_version', NDSOFT_AIWD_VERSION, false );
        if ( false === get_option( Settings::OPTION, false ) ) {
            add_option( Settings::OPTION, Settings::defaults(), '', false );
        }
        if ( false === get_option( 'ndsoft_aiwd_history', false ) ) {
            add_option( 'ndsoft_aiwd_history', array(), '', false );
        }
    }
}
