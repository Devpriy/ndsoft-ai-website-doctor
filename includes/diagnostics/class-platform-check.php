<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Platform_Check implements Check_Interface {
    public function run() {
        $bridge  = new Site_Health_Bridge();
        $results = array();
        $tests   = array(
            'get_test_php_version' => array( 'php_core_support', __( 'PHP Support Status', 'ndsoft-ai-website-doctor' ), 'environment', 20, 8 ),
            'get_test_php_extensions' => array( 'php_extensions', __( 'PHP Extensions', 'ndsoft-ai-website-doctor' ), 'environment', 16, 6 ),
            'get_test_http_requests' => array( 'http_requests', __( 'Outbound HTTP Requests', 'ndsoft-ai-website-doctor' ), 'connectivity', 14, 6 ),
            'get_test_file_uploads' => array( 'file_uploads', __( 'File Uploads', 'ndsoft-ai-website-doctor' ), 'environment', 12, 5 ),
            'get_test_php_default_timezone' => array( 'php_timezone', __( 'PHP Default Timezone', 'ndsoft-ai-website-doctor' ), 'environment', 5, 2 ),
            'get_test_php_sessions' => array( 'php_sessions', __( 'PHP Session', 'ndsoft-ai-website-doctor' ), 'performance', 7, 3 ),
        );

        foreach ( $tests as $method => $config ) {
            $core = $bridge->run( $method );
            if ( ! $core ) { continue; }
            $status = Site_Health_Bridge::map_status( isset( $core['status'] ) ? $core['status'] : '' );
            $weight = Result::CRITICAL === $status ? $config[3] : ( Result::WARNING === $status ? $config[4] : 0 );
            $results[] = Result::make(
                $config[0],
                $config[1],
                $status,
                Site_Health_Bridge::plain_description( isset( $core['description'] ) ? $core['description'] : '' ),
                $weight,
                array(
                    'category'       => $config[2],
                    'recommendation' => Result::PASS === $status ? '' : __( 'Review the related WordPress Site Health recommendation and hosting/server configuration before changing code.', 'ndsoft-ai-website-doctor' ),
                )
            );
        }

        return $results;
    }
}
