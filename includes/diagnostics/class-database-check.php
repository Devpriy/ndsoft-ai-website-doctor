<?php
namespace NDsoft\AIWebsiteDoctor\Diagnostics;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Database_Check implements Check_Interface {
    public function run() {
        global $wpdb;
        $value = $wpdb->get_var( 'SELECT 1' ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.PreparedSQL.NotPrepared
        $ok = '1' === (string) $value;
        return array(
            Result::make(
                'database_connection',
                __( 'Database Connection', 'ndsoft-ai-website-doctor' ),
                $ok ? Result::PASS : Result::CRITICAL,
                $ok ? __( 'A read-only database health query completed successfully.', 'ndsoft-ai-website-doctor' ) : __( 'The database health query did not return the expected result.', 'ndsoft-ai-website-doctor' ),
                $ok ? 0 : 30
            ),
        );
    }
}
