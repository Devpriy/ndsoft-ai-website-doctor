<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Theme_Check implements Check_Interface {
    public function run() {
        $theme = wp_get_theme();
        $updates = get_site_transient( 'update_themes' );
        $count = ( is_object( $updates ) && isset( $updates->response ) && is_array( $updates->response ) ) ? count( $updates->response ) : 0;

        return array(
            Result::make(
                'active_theme',
                __( 'Active Theme', 'ndsoft-ai-website-doctor' ),
                $theme->exists() ? Result::PASS : Result::CRITICAL,
                $theme->exists() ? sprintf( __( '%1$s %2$s is active.', 'ndsoft-ai-website-doctor' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ) : __( 'The active theme could not be resolved.', 'ndsoft-ai-website-doctor' ),
                $theme->exists() ? 0 : 25
            ),
            Result::make(
                'theme_updates',
                __( 'Theme Updates', 'ndsoft-ai-website-doctor' ),
                $count ? Result::WARNING : Result::PASS,
                $count ? sprintf( _n( '%d theme update is available.', '%d theme updates are available.', $count, 'ndsoft-ai-website-doctor' ), $count ) : __( 'No pending theme updates were detected.', 'ndsoft-ai-website-doctor' ),
                $count ? min( 8, 3 + $count ) : 0,
                array( 'count' => $count )
            ),
        );
    }
}
