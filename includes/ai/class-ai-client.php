<?php
namespace NDsoft\AIWebsiteDoctor\AI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class AI_Client {
    /**
     * Remote AI is intentionally not bundled with core v1.0. The plugin's
     * useful diagnosis is generated locally by Diagnosis_Engine.
     *
     * @return \WP_Error
     */
    public function diagnose() {
        return new \WP_Error( 'ndsoft_aiwd_cloud_ai_unavailable', __( 'Remote AI is not connected in this core build. Local diagnosis remains available without an API key.', 'ndsoft-ai-website-doctor' ) );
    }
}
