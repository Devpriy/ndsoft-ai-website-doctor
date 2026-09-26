<?php
namespace NDsoft\AIWebsiteDoctor\Fixes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Rollback_Manager {
    /** The included v1.0 maintenance actions do not alter theme/plugin code. */
    public function is_available() { return false; }
}
