<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;
use function NDsoft\AIWebsiteDoctor\Helpers\ini_bytes;
use function NDsoft\AIWebsiteDoctor\Helpers\readable_bytes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class PHP_Check implements Check_Interface {
    public function run() {
        $results = array();
        $supported = version_compare( PHP_VERSION, '7.4', '>=' );
        $results[] = Result::make(
            'php_version',
            __( 'PHP Version', 'ndsoft-ai-website-doctor' ),
            $supported ? Result::PASS : Result::CRITICAL,
            $supported ? sprintf( __( 'PHP %s is active.', 'ndsoft-ai-website-doctor' ), PHP_VERSION ) : sprintf( __( 'PHP %s is below the plugin minimum of PHP 7.4.', 'ndsoft-ai-website-doctor' ), PHP_VERSION ),
            $supported ? 0 : 30,
            array( 'version' => PHP_VERSION )
        );

        $limit = ini_bytes( ini_get( 'memory_limit' ) );
        $low = $limit > 0 && $limit < 128 * 1024 * 1024;
        $results[] = Result::make(
            'php_memory',
            __( 'PHP Memory', 'ndsoft-ai-website-doctor' ),
            $low ? Result::INFO : Result::PASS,
            $low ? sprintf( __( 'PHP memory limit is %s. Some larger WordPress sites may need more.', 'ndsoft-ai-website-doctor' ), readable_bytes( $limit ) ) : sprintf( __( 'PHP memory limit is %s.', 'ndsoft-ai-website-doctor' ), readable_bytes( $limit ) ),
            $low ? 2 : 0,
            array( 'bytes' => $limit )
        );
        return $results;
    }
}
