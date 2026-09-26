<?php
namespace NDsoft\AIWebsiteDoctor\Reports;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Report_Generator {
    /** @param array<string,mixed> $scan Scan. @return string */
    public function plain_text( array $scan ) {
        $lines   = array();
        $lines[] = 'NDsoft AI Website Doctor';
        $lines[] = 'Health score: ' . (int) ( isset( $scan['score'] ) ? $scan['score'] : 0 ) . '/100';
        if ( ! empty( $scan['score_label'] ) ) { $lines[] = 'Status: ' . (string) $scan['score_label']; }
        $lines[] = 'Generated: ' . wp_date( 'Y-m-d H:i:s', (int) ( isset( $scan['generated_at'] ) ? $scan['generated_at'] : time() ) );

        if ( ! empty( $scan['diagnosis'] ) && is_array( $scan['diagnosis'] ) ) {
            $lines[] = '';
            $lines[] = 'Diagnosis summary';
            $lines[] = (string) ( isset( $scan['diagnosis']['headline'] ) ? $scan['diagnosis']['headline'] : '' );
            $lines[] = (string) ( isset( $scan['diagnosis']['summary'] ) ? $scan['diagnosis']['summary'] : '' );
            foreach ( (array) ( isset( $scan['diagnosis']['next_steps'] ) ? $scan['diagnosis']['next_steps'] : array() ) as $step ) {
                $lines[] = '- ' . (string) $step;
            }
        }

        if ( ! empty( $scan['changes'] ) ) {
            $lines[] = '';
            $lines[] = 'Recent changes';
            foreach ( (array) $scan['changes'] as $change ) {
                $lines[] = '- ' . (string) ( isset( $change['label'] ) ? $change['label'] : '' ) . ': ' . (string) ( isset( $change['detail'] ) ? $change['detail'] : '' );
            }
        }

        $lines[] = '';
        $lines[] = 'Checks';
        foreach ( (array) ( isset( $scan['checks'] ) ? $scan['checks'] : array() ) as $check ) {
            $lines[] = '[' . strtoupper( (string) ( isset( $check['status'] ) ? $check['status'] : 'info' ) ) . '] ' . (string) ( isset( $check['label'] ) ? $check['label'] : '' );
            $lines[] = (string) ( isset( $check['message'] ) ? $check['message'] : '' );
            $meta = isset( $check['meta'] ) && is_array( $check['meta'] ) ? $check['meta'] : array();
            if ( ! empty( $meta['recommendation'] ) ) { $lines[] = 'Recommended: ' . (string) $meta['recommendation']; }
            $lines[] = '';
        }
        return implode( "\n", $lines );
    }

    /** @param array<string,mixed> $scan Scan. @return string */
    public function json( array $scan ) {
        $safe = array(
            'plugin'       => 'NDsoft AI Website Doctor',
            'version'      => defined( 'NDSOFT_AIWD_VERSION' ) ? NDSOFT_AIWD_VERSION : '',
            'generated_at' => isset( $scan['generated_at'] ) ? (int) $scan['generated_at'] : time(),
            'score'        => isset( $scan['score'] ) ? (int) $scan['score'] : 0,
            'score_label'  => isset( $scan['score_label'] ) ? (string) $scan['score_label'] : '',
            'summary'      => isset( $scan['summary'] ) ? $scan['summary'] : array(),
            'diagnosis'    => isset( $scan['diagnosis'] ) ? $scan['diagnosis'] : array(),
            'changes'      => isset( $scan['changes'] ) ? $scan['changes'] : array(),
            'checks'       => isset( $scan['checks'] ) ? $scan['checks'] : array(),
            'environment'  => isset( $scan['environment'] ) ? $scan['environment'] : array(),
        );
        return (string) wp_json_encode( $safe, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    }
}
