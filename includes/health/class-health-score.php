<?php
namespace NDsoft\AIWebsiteDoctor\Health;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Health_Score {
    /**
     * Calculate a simple bounded 0-100 score.
     *
     * @param array<int,array<string,mixed>> $checks Results.
     * @return int
     */
    public static function calculate( array $checks ) {
        $score = 100;
        foreach ( $checks as $check ) {
            if ( Result::PASS !== ( $check['status'] ?? '' ) ) {
                $score -= (int) ( $check['weight'] ?? 0 );
            }
        }
        return max( 0, min( 100, $score ) );
    }

    /**
     * @param array<int,array<string,mixed>> $checks Results.
     * @return array<string,int>
     */
    public static function summarize( array $checks ) {
        $summary = array( 'pass' => 0, 'info' => 0, 'warning' => 0, 'critical' => 0 );
        foreach ( $checks as $check ) {
            $status = $check['status'] ?? 'info';
            if ( isset( $summary[ $status ] ) ) {
                ++$summary[ $status ];
            }
        }
        return $summary;
    }
}
