<?php
namespace NDsoft\AIWebsiteDoctor\Health;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Result {
    public const PASS = 'pass';
    public const INFO = 'info';
    public const WARNING = 'warning';
    public const CRITICAL = 'critical';

    /**
     * Build a normalized diagnostic result.
     *
     * @param string $id      Stable machine id.
     * @param string $label   Human label.
     * @param string $status  pass|info|warning|critical.
     * @param string $message Plain-language explanation.
     * @param int    $weight  Score penalty when not passing.
     * @param array  $meta    Optional non-secret metadata.
     * @return array<string,mixed>
     */
    public static function make( $id, $label, $status, $message, $weight = 0, $meta = array() ) {
        $allowed = array( self::PASS, self::INFO, self::WARNING, self::CRITICAL );
        if ( ! in_array( $status, $allowed, true ) ) {
            $status = self::INFO;
        }

        return array(
            'id'      => sanitize_key( $id ),
            'label'   => (string) $label,
            'status'  => $status,
            'message' => (string) $message,
            'weight'  => max( 0, (int) $weight ),
            'meta'    => is_array( $meta ) ? $meta : array(),
        );
    }
}
