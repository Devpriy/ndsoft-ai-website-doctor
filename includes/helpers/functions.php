<?php
namespace NDsoft\AIWebsiteDoctor\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Normalize a PHP ini size to bytes.
 *
 * @param string|int $value PHP ini value.
 * @return int
 */
function ini_bytes( $value ) {
    if ( is_numeric( $value ) ) {
        return (int) $value;
    }

    $value = trim( (string) $value );
    $unit  = strtolower( substr( $value, -1 ) );
    $size  = (float) $value;

    if ( 'g' === $unit ) {
        $size *= 1024;
        $unit = 'm';
    }
    if ( 'm' === $unit ) {
        $size *= 1024;
        $unit = 'k';
    }
    if ( 'k' === $unit ) {
        $size *= 1024;
    }

    return (int) $size;
}

/**
 * Convert bytes to a readable label without requiring wp-admin helpers.
 *
 * @param int $bytes Bytes.
 * @return string
 */
function readable_bytes( $bytes ) {
    return size_format( max( 0, (int) $bytes ), 1 );
}
