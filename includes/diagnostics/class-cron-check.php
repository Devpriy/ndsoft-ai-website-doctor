<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Cron_Check implements Check_Interface {
    public function run() {
        $disabled = defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON;
        return array(
            Result::make(
                'wp_cron',
                __( 'Scheduled Tasks', 'ndsoft-ai-website-doctor' ),
                $disabled ? Result::INFO : Result::PASS,
                $disabled ? __( 'WP-Cron is disabled. This may be intentional if the server runs a real cron job.', 'ndsoft-ai-website-doctor' ) : __( 'WordPress scheduled tasks are enabled.', 'ndsoft-ai-website-doctor' ),
                $disabled ? 1 : 0
            ),
        );
    }
}
