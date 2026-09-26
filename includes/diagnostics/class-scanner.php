<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Diagnosis\Diagnosis_Engine;
use NDsoft\AIWebsiteDoctor\Health\Health_Score;
use NDsoft\AIWebsiteDoctor\History\Change_Tracker;
use NDsoft\AIWebsiteDoctor\Settings\Settings;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Scanner {
    /** @var array<int,Check_Interface> */
    private $checks = array();

    public function __construct() {
        $settings     = Settings::get();
        $this->checks = array(
            new WordPress_Check(),
            new PHP_Check(),
            new Platform_Check(),
            new Plugin_Check(),
            new Theme_Check(),
            new Cron_Check(),
        );

        if ( ! empty( $settings['connectivity_tests'] ) ) {
            $this->checks[] = new REST_Check();
        }

        $this->checks[] = new Database_Check();

        if ( ! empty( $settings['error_log_analysis'] ) ) {
            $this->checks[] = new Error_Log_Check();
        }
    }

    /**
     * Run diagnostics. The scan may perform WordPress core loopback/REST tests,
     * but does not edit theme/plugin files or send scan data to a remote AI.
     *
     * @return array<string,mixed>
     */
    public function run() {
        $tracker  = new Change_Tracker();
        $previous = $tracker->latest_snapshot();
        $snapshot = $tracker->snapshot();
        $changes  = $tracker->compare( $previous, $snapshot );
        $results  = array();

        foreach ( $this->checks as $check ) {
            try {
                $result  = $check->run();
                $results = array_merge( $results, is_array( $result ) ? $result : array() );
            } catch ( \Throwable $e ) {
                $results[] = \NDsoft\AIWebsiteDoctor\Health\Result::make(
                    'diagnostic_runtime_' . sanitize_key( get_class( $check ) ),
                    __( 'Diagnostic Check', 'ndsoft-ai-website-doctor' ),
                    \NDsoft\AIWebsiteDoctor\Health\Result::INFO,
                    __( 'One diagnostic check could not complete. The rest of the scan continued safely.', 'ndsoft-ai-website-doctor' ),
                    0,
                    array( 'category' => 'diagnostics' )
                );
            }
        }

        $results   = $this->sort_results( $results );
        $score     = Health_Score::calculate( $results );
        $diagnosis = ( new Diagnosis_Engine() )->build( $results, $changes );

        $scan = array(
            'schema'       => 3,
            'generated_at' => time(),
            'score'        => $score,
            'score_label'  => Health_Score::label( $score ),
            'summary'      => Health_Score::summarize( $results ),
            'diagnosis'    => $diagnosis,
            'changes'      => $changes,
            'checks'       => $results,
            'environment'  => $this->environment(),
            'snapshot'     => $snapshot,
        );

        update_option( 'ndsoft_aiwd_last_scan', $scan, false );
        update_option( 'ndsoft_aiwd_last_scan_at', time(), false );
        $tracker->record( $scan );

        return $scan;
    }

    /** @param array<int,array<string,mixed>> $results Results. @return array<int,array<string,mixed>> */
    private function sort_results( array $results ) {
        $priority = array( 'critical' => 0, 'warning' => 1, 'info' => 2, 'pass' => 3 );
        usort(
            $results,
            static function ( $a, $b ) use ( $priority ) {
                $a_status = isset( $a['status'] ) && isset( $priority[ $a['status'] ] ) ? $a['status'] : 'info';
                $b_status = isset( $b['status'] ) && isset( $priority[ $b['status'] ] ) ? $b['status'] : 'info';
                if ( $priority[ $a_status ] === $priority[ $b_status ] ) {
                    return (int) ( isset( $b['weight'] ) ? $b['weight'] : 0 ) <=> (int) ( isset( $a['weight'] ) ? $a['weight'] : 0 );
                }
                return $priority[ $a_status ] <=> $priority[ $b_status ];
            }
        );
        return $results;
    }

    /** @return array<string,string> */
    private function environment() {
        global $wp_version, $wpdb;
        return array(
            'wordpress' => (string) $wp_version,
            'php'       => PHP_VERSION,
            'database'  => method_exists( $wpdb, 'db_server_info' ) ? (string) $wpdb->db_server_info() : (string) $wpdb->db_version(),
            'server'    => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : __( 'Unknown', 'ndsoft-ai-website-doctor' ),
            'multisite' => is_multisite() ? __( 'Yes', 'ndsoft-ai-website-doctor' ) : __( 'No', 'ndsoft-ai-website-doctor' ),
        );
    }
}
