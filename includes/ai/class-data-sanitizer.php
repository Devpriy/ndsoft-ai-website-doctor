<?php
namespace NDsoft\AIWebsiteDoctor\AI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Data_Sanitizer {
    /**
     * Reserved for future cloud AI payload minimization.
     *
     * @param array<string,mixed> $data Data.
     * @return array<string,mixed>
     */
    public function sanitize( array $data ) {
        unset( $data['secrets'], $data['credentials'], $data['tokens'] );
        return $data;
    }
}
