<?php
namespace NDsoft\AIWebsiteDoctor\Reports;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Report_Generator {
    /**
     * Build a plain-text local report suitable for copying into support tickets.
     *
     * @param array<string,mixed> $scan Scan data.
     * @return string
     */
    public function plain_text( array $scan ) {
        $lines = array();
        $lines[] = 'NDsoft AI Website Doctor';
        $lines[] = 'Health score: ' . (int) ( $scan['score'] ?? 0 ) . '/100';
        $lines[] = 'Generated: ' . wp_date( 'Y-m-d H:i:s', (int) ( $scan['generated_at'] ?? time() ) );
        $lines[] = '';
        foreach ( (array) ( $scan['checks'] ?? array() ) as $check ) {
            $lines[] = '[' . strtoupper( (string) ( $check['status'] ?? 'info' ) ) . '] ' . (string) ( $check['label'] ?? '' );
            $lines[] = (string) ( $check['message'] ?? '' );
            $lines[] = '';
        }
        return implode( "\n", $lines );
    }
}
