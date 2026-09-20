<?php
namespace NDsoft\AIWebsiteDoctor\Fixes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Backup_Manager {
    /** v0.1.0 deliberately does not create or modify backups. */
    public function is_available() { return false; }
}
