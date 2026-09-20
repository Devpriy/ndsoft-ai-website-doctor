<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class REST_Check implements Check_Interface {
    public function run() {
        $url = rest_url();
        $parts = wp_parse_url( $url );
        $valid = is_array( $parts ) && ! empty( $parts['scheme'] ) && ! empty( $parts['host'] );
        return array(
            Result::make(
                'rest_url',
                __( 'REST API URL', 'ndsoft-ai-website-doctor' ),
                $valid ? Result::PASS : Result::WARNING,
                $valid ? __( 'A valid WordPress REST API URL is available. Network loopback testing is intentionally deferred in this safe baseline.', 'ndsoft-ai-website-doctor' ) : __( 'WordPress could not produce a valid REST API URL.', 'ndsoft-ai-website-doctor' ),
                $valid ? 0 : 8
            ),
        );
    }
}
