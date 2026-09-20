<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Health_Score;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Scanner {
    /** @var array<int,Check_Interface> */
    private $checks = array();

    public function __construct() {
        $this->checks = array(
            new WordPress_Check(),
            new PHP_Check(),
            new Plugin_Check(),
            new Theme_Check(),
            new Cron_Check(),
            new REST_Check(),
            new Database_Check(),
            new Error_Log_Check(),
        );
    }

    /**
     * Run safe, read-only diagnostics.
     *
     * @return array<string,mixed>
     */
    public function run() {
        $results = array();
        foreach ( $this->checks as $check ) {
            $results = array_merge( $results, $check->run() );
        }

        $scan = array(
            'schema'       => 1,
            'generated_at' => time(),
            'score'        => Health_Score::calculate( $results ),
            'summary'      => Health_Score::summarize( $results ),
            'checks'       => $results,
            'environment'  => $this->environment(),
        );

        update_option( 'ndsoft_aiwd_last_scan', $scan, false );
        update_option( 'ndsoft_aiwd_last_scan_at', time(), false );
        return $scan;
    }

    /** @return array<string,string> */
    private function environment() {
        global $wp_version;
        return array(
            'wordpress' => (string) $wp_version,
            'php'       => PHP_VERSION,
            'server'    => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : __( 'Unknown', 'ndsoft-ai-website-doctor' ),
            'multisite' => is_multisite() ? __( 'Yes', 'ndsoft-ai-website-doctor' ) : __( 'No', 'ndsoft-ai-website-doctor' ),
        );
    }
}
