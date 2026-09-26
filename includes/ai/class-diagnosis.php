<?php
namespace NDsoft\AIWebsiteDoctor\AI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Diagnosis {
    public function available() { return false; }
    public function label() { return __( 'Optional cloud AI is not connected', 'ndsoft-ai-website-doctor' ); }
}
