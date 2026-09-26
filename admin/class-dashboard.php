<?php
namespace NDsoft\AIWebsiteDoctor\Admin;

use NDsoft\AIWebsiteDoctor\Diagnostics\Scanner;
use NDsoft\AIWebsiteDoctor\Fixes\Fix_Manager;
use NDsoft\AIWebsiteDoctor\History\Change_Tracker;
use NDsoft\AIWebsiteDoctor\Reports\Report_Generator;
use NDsoft\AIWebsiteDoctor\Settings\Settings;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Dashboard {
    /** @var Scanner */
    private $scanner;

    public function __construct() { $this->scanner = new Scanner(); }

    private function authorize( $nonce_action ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to perform this action.', 'ndsoft-ai-website-doctor' ) );
        }
        check_admin_referer( $nonce_action );
    }

    public function handle_scan() {
        $this->authorize( 'ndsoft_aiwd_scan' );
        $this->scanner->run();
        wp_safe_redirect( add_query_arg( array( 'page' => 'ndsoft-ai-website-doctor', 'scan' => 'complete' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    public function handle_save_settings() {
        $this->authorize( 'ndsoft_aiwd_save_settings' );
        $input = isset( $_POST['ndsoft_aiwd'] ) && is_array( $_POST['ndsoft_aiwd'] ) ? wp_unslash( $_POST['ndsoft_aiwd'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        Settings::update( $input );
        wp_safe_redirect( add_query_arg( array( 'page' => 'ndsoft-ai-website-doctor-settings', 'saved' => '1' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    public function handle_clear_history() {
        $this->authorize( 'ndsoft_aiwd_clear_history' );
        ( new Change_Tracker() )->clear();
        wp_safe_redirect( add_query_arg( array( 'page' => 'ndsoft-ai-website-doctor-history', 'cleared' => '1' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    public function handle_export_report() {
        $this->authorize( 'ndsoft_aiwd_export_report' );
        $scan = get_option( 'ndsoft_aiwd_last_scan', array() );
        if ( ! is_array( $scan ) || empty( $scan ) ) {
            wp_die( esc_html__( 'No scan report is available yet.', 'ndsoft-ai-website-doctor' ) );
        }

        $format    = isset( $_POST['format'] ) ? sanitize_key( wp_unslash( $_POST['format'] ) ) : 'txt';
        $generator = new Report_Generator();
        $content   = 'json' === $format ? $generator->json( $scan ) : $generator->plain_text( $scan );
        $extension = 'json' === $format ? 'json' : 'txt';
        $mime      = 'json' === $format ? 'application/json; charset=utf-8' : 'text/plain; charset=utf-8';

        nocache_headers();
        header( 'Content-Type: ' . $mime );
        header( 'Content-Disposition: attachment; filename="ndsoft-website-doctor-report-' . gmdate( 'Ymd-His' ) . '.' . $extension . '"' );
        echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Downloaded plain text/JSON generated from escaped/sanitized diagnostic values.
        exit;
    }

    public function handle_maintenance() {
        $this->authorize( 'ndsoft_aiwd_maintenance' );
        $action  = isset( $_POST['maintenance_action'] ) ? sanitize_key( wp_unslash( $_POST['maintenance_action'] ) ) : '';
        $result  = ( new Fix_Manager() )->execute( $action );
        $args    = array( 'page' => 'ndsoft-ai-website-doctor-maintenance' );
        if ( is_wp_error( $result ) ) {
            $args['maintenance'] = 'error';
            $args['message']     = $result->get_error_message();
        } else {
            $args['maintenance'] = 'complete';
            $args['message']     = isset( $result['message'] ) ? (string) $result['message'] : '';
        }
        wp_safe_redirect( add_query_arg( $args, admin_url( 'admin.php' ) ) );
        exit;
    }

    public function render_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $scan     = get_option( 'ndsoft_aiwd_last_scan', array() );
        $settings = Settings::get();
        require NDSOFT_AIWD_PATH . 'admin/views/dashboard.php';
    }

    public function render_history() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $history = ( new Change_Tracker() )->history();
        require NDSOFT_AIWD_PATH . 'admin/views/history.php';
    }

    public function render_reports() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $scan   = get_option( 'ndsoft_aiwd_last_scan', array() );
        $report = is_array( $scan ) && $scan ? ( new Report_Generator() )->plain_text( $scan ) : '';
        require NDSOFT_AIWD_PATH . 'admin/views/reports.php';
    }

    public function render_maintenance() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $actions = ( new Fix_Manager() )->actions();
        require NDSOFT_AIWD_PATH . 'admin/views/maintenance.php';
    }

    public function render_settings() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $settings = Settings::get();
        require NDSOFT_AIWD_PATH . 'admin/views/settings.php';
    }
}
