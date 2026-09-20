<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Error_Log_Check implements Check_Interface {
    public function run() {
        $enabled = defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG;
        $message = $enabled
            ? __( 'WordPress debug logging is enabled. Version 0.1.0 does not read or transmit log contents.', 'ndsoft-ai-website-doctor' )
            : __( 'WordPress debug logging is not enabled. Error-log analysis can be added later with explicit controls.', 'ndsoft-ai-website-doctor' );

        return array(
            Result::make(
                'debug_log',
                __( 'Error Log', 'ndsoft-ai-website-doctor' ),
                Result::INFO,
                $message,
                0,
                array( 'enabled' => (bool) $enabled )
            ),
        );
    }
}
