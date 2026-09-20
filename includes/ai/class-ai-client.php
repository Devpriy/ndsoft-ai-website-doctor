<?php
namespace NDsoft\AIWebsiteDoctor\AI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class AI_Client {
    /**
     * No remote AI request is allowed in v0.1.0.
     *
     * @return \WP_Error
     */
    public function diagnose() {
        return new \WP_Error( 'ndsoft_aiwd_ai_disabled', __( 'AI diagnosis is not enabled in this foundation release.', 'ndsoft-ai-website-doctor' ) );
    }
}
