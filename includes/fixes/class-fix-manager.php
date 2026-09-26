<?php
namespace NDsoft\AIWebsiteDoctor\Fixes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Fix_Manager {
    /** @return array<string,array<string,string>> */
    public function actions() {
        return array(
            'clear_expired_transients' => array(
                'label'       => __( 'Clear expired transients', 'ndsoft-ai-website-doctor' ),
                'description' => __( 'Removes only expired WordPress transient cache records. Active cached values are not intentionally removed.', 'ndsoft-ai-website-doctor' ),
                'risk'        => __( 'Low', 'ndsoft-ai-website-doctor' ),
            ),
            'refresh_rewrite_rules' => array(
                'label'       => __( 'Refresh rewrite rules', 'ndsoft-ai-website-doctor' ),
                'description' => __( 'Rebuilds WordPress rewrite rules in the database without writing .htaccess. Useful after permalink or routing changes.', 'ndsoft-ai-website-doctor' ),
                'risk'        => __( 'Low', 'ndsoft-ai-website-doctor' ),
            ),
        );
    }

    public function is_enabled() { return true; }

    /** @param string $action Action key. @return array<string,mixed>|\WP_Error */
    public function execute( $action ) {
        $actions = $this->actions();
        if ( ! isset( $actions[ $action ] ) ) {
            return new \WP_Error( 'ndsoft_aiwd_unknown_action', __( 'Unknown maintenance action.', 'ndsoft-ai-website-doctor' ) );
        }

        if ( 'clear_expired_transients' === $action ) {
            delete_expired_transients( true );
            return array( 'success' => true, 'message' => __( 'Expired transients were cleared.', 'ndsoft-ai-website-doctor' ) );
        }

        if ( 'refresh_rewrite_rules' === $action ) {
            flush_rewrite_rules( false );
            return array( 'success' => true, 'message' => __( 'WordPress rewrite rules were refreshed.', 'ndsoft-ai-website-doctor' ) );
        }

        return new \WP_Error( 'ndsoft_aiwd_action_failed', __( 'The maintenance action could not be completed.', 'ndsoft-ai-website-doctor' ) );
    }
}
