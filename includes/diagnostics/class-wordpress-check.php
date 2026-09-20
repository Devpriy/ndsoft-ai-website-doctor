<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class WordPress_Check implements Check_Interface {
    public function run() {
        $results = array();
        $secure  = is_ssl() || 0 === strpos( home_url(), 'https://' );
        $results[] = Result::make(
            'https',
            __( 'HTTPS', 'ndsoft-ai-website-doctor' ),
            $secure ? Result::PASS : Result::WARNING,
            $secure ? __( 'Your site is using HTTPS.', 'ndsoft-ai-website-doctor' ) : __( 'Your site is not using HTTPS. Secure HTTPS is recommended.', 'ndsoft-ai-website-doctor' ),
            $secure ? 0 : 8
        );

        $core = get_site_transient( 'update_core' );
        $pending = false;
        if ( is_object( $core ) && ! empty( $core->updates ) && is_array( $core->updates ) ) {
            foreach ( $core->updates as $update ) {
                if ( isset( $update->response ) && 'upgrade' === $update->response ) { $pending = true; break; }
            }
        }
        $results[] = Result::make(
            'core_updates',
            __( 'WordPress Core', 'ndsoft-ai-website-doctor' ),
            $pending ? Result::WARNING : Result::PASS,
            $pending ? __( 'A WordPress core update appears to be available. Review compatibility and back up before updating.', 'ndsoft-ai-website-doctor' ) : __( 'No pending WordPress core update was detected.', 'ndsoft-ai-website-doctor' ),
            $pending ? 6 : 0
        );

        $debug = defined( 'WP_DEBUG' ) && WP_DEBUG;
        $display = defined( 'WP_DEBUG_DISPLAY' ) ? WP_DEBUG_DISPLAY : $debug;
        $exposed = $debug && $display;
        $results[] = Result::make(
            'debug_display',
            __( 'Debug Display', 'ndsoft-ai-website-doctor' ),
            $exposed ? Result::WARNING : Result::PASS,
            $exposed ? __( 'Debug output may be visible to visitors. Disable public debug display on production sites.', 'ndsoft-ai-website-doctor' ) : __( 'Debug output is not configured for public display.', 'ndsoft-ai-website-doctor' ),
            $exposed ? 7 : 0
        );

        return $results;
    }
}
