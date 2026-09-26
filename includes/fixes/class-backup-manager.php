<?php
namespace NDsoft\AIWebsiteDoctor\Fixes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Backup_Manager {
    /**
     * Full-site backups are intentionally outside the core plugin. The v1.0
     * maintenance actions are limited to low-risk rebuild/cleanup operations.
     */
    public function is_available() { return false; }
}
