<?php
namespace NDsoft\AIWebsiteDoctor\AI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Data_Sanitizer {
    /** @param array<string,mixed> $data Data. @return array<string,mixed> */
    public function sanitize( array $data ) {
        $blocked = array( 'password', 'passwords', 'secret', 'secrets', 'token', 'tokens', 'credential', 'credentials', 'cookie', 'cookies', 'authorization', 'api_key', 'apikey' );
        foreach ( $data as $key => $value ) {
            if ( in_array( strtolower( (string) $key ), $blocked, true ) ) {
                unset( $data[ $key ] );
                continue;
            }
            if ( is_array( $value ) ) {
                $data[ $key ] = $this->sanitize( $value );
            }
        }
        return $data;
    }
}
