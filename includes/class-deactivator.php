<?php
namespace NDsoft\AIWebsiteDoctor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Deactivator {
    public static function deactivate() {
        // Keep scan history on deactivation. uninstall.php handles explicit deletion.
    }
}
