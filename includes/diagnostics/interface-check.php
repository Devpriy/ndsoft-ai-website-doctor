<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

interface Check_Interface {
    /**
     * @return array<int,array<string,mixed>>
     */
    public function run();
}
