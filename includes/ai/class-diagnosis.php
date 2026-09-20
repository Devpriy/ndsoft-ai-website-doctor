<?php
namespace NDsoft\AIWebsiteDoctor\AI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Diagnosis {
    /** @var AI_Client */
    private $client;
    public function __construct() { $this->client = new AI_Client(); }
    public function available() { return false; }
}
