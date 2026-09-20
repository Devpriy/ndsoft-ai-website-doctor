<?php
namespace NDsoft\AIWebsiteDoctor\Fixes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Fix_Manager {
    /**
     * Safe baseline: automated fixes are disabled until backup, verification,
     * explicit approval, and rollback flows are implemented and tested.
     */
    public function is_enabled() { return false; }
}
