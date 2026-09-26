<?php
namespace NDsoft\AIWebsiteDoctor\Settings;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Settings {
    const OPTION = 'ndsoft_aiwd_settings';

    /** @return array<string,mixed> */
    public static function defaults() {
        return array(
            'connectivity_tests'    => 1,
            'error_log_analysis'    => 1,
            'history_limit'         => 10,
            'technical_details'     => 0,
        );
    }

    /** @return array<string,mixed> */
    public static function get() {
        $saved = get_option( self::OPTION, array() );
        if ( ! is_array( $saved ) ) {
            $saved = array();
        }
        return self::sanitize( wp_parse_args( $saved, self::defaults() ) );
    }

    /** @param array<string,mixed> $input Settings. @return array<string,mixed> */
    public static function sanitize( array $input ) {
        $defaults = self::defaults();
        $history  = isset( $input['history_limit'] ) ? absint( $input['history_limit'] ) : (int) $defaults['history_limit'];
        $history  = max( 3, min( 30, $history ) );

        return array(
            'connectivity_tests' => ! empty( $input['connectivity_tests'] ) ? 1 : 0,
            'error_log_analysis' => ! empty( $input['error_log_analysis'] ) ? 1 : 0,
            'history_limit'      => $history,
            'technical_details'  => ! empty( $input['technical_details'] ) ? 1 : 0,
        );
    }

    /** @param array<string,mixed> $input Settings. @return bool */
    public static function update( array $input ) {
        return update_option( self::OPTION, self::sanitize( $input ), false );
    }
}
