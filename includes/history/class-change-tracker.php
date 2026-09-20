<?php
namespace NDsoft\AIWebsiteDoctor\History;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Change_Tracker {
    /**
     * Reserved foundation for the future "What changed?" feature.
     * No automatic tracking is enabled in v0.1.0.
     *
     * @return bool
     */
    public function enabled() {
        return false;
    }
}
