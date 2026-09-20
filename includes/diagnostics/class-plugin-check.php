<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Plugin_Check implements Check_Interface {
    public function run() {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $all = get_plugins();
        $active = (array) get_option( 'active_plugins', array() );
        $inactive = array_diff( array_keys( $all ), $active );
        $count = count( $inactive );

        $updates = get_site_transient( 'update_plugins' );
        $update_count = ( is_object( $updates ) && isset( $updates->response ) && is_array( $updates->response ) ) ? count( $updates->response ) : 0;

        return array(
            Result::make(
                'plugin_updates',
                __( 'Plugin Updates', 'ndsoft-ai-website-doctor' ),
                $update_count ? Result::WARNING : Result::PASS,
                $update_count ? sprintf( _n( '%d plugin update is available.', '%d plugin updates are available.', $update_count, 'ndsoft-ai-website-doctor' ), $update_count ) : __( 'No pending plugin updates were detected.', 'ndsoft-ai-website-doctor' ),
                $update_count ? min( 10, 2 + $update_count ) : 0,
                array( 'count' => $update_count )
            ),
            Result::make(
                'inactive_plugins',
                __( 'Inactive Plugins', 'ndsoft-ai-website-doctor' ),
                $count ? Result::INFO : Result::PASS,
                $count ? sprintf( _n( '%d inactive plugin is installed.', '%d inactive plugins are installed.', $count, 'ndsoft-ai-website-doctor' ), $count ) : __( 'No inactive plugins were detected.', 'ndsoft-ai-website-doctor' ),
                $count ? min( 4, $count ) : 0,
                array( 'count' => $count )
            ),
        );
    }
}
