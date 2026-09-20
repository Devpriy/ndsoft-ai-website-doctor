<?php
namespace NDsoft\AIWebsiteDoctor\Admin;

use NDsoft\AIWebsiteDoctor\Diagnostics\Scanner;
use NDsoft\AIWebsiteDoctor\Reports\Report_Generator;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Dashboard {
    /** @var Scanner */
    private $scanner;

    public function __construct() { $this->scanner = new Scanner(); }

    public function handle_scan() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to run this scan.', 'ndsoft-ai-website-doctor' ) );
        }
        check_admin_referer( 'ndsoft_aiwd_scan' );
        $this->scanner->run();
        wp_safe_redirect( add_query_arg( array( 'page' => 'ndsoft-ai-website-doctor', 'scan' => 'complete' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    public function render() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $scan = get_option( 'ndsoft_aiwd_last_scan', array() );
        $report = $scan ? ( new Report_Generator() )->plain_text( $scan ) : '';
        require NDSOFT_AIWD_PATH . 'admin/views/dashboard.php';
    }
}
