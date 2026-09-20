<?php
namespace NDsoft\AIWebsiteDoctor\Fixes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Rollback_Manager {
    /** v0.1.0 deliberately has no write/rollback actions. */
    public function is_available() { return false; }
}
