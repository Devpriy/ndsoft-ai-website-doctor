<?php
namespace NDsoft\AIWebsiteDoctor\History;

use NDsoft\AIWebsiteDoctor\Settings\Settings;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Change_Tracker {
    const OPTION = 'ndsoft_aiwd_history';

    /** @return array<string,mixed> */
    public function snapshot() {
        global $wp_version;

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $plugins        = get_plugins();
        $active         = (array) get_option( 'active_plugins', array() );
        $network_active = is_multisite() ? array_keys( (array) get_site_option( 'active_sitewide_plugins', array() ) ) : array();
        $active         = array_values( array_unique( array_merge( $active, $network_active ) ) );
        $active_data    = array();

        foreach ( $active as $file ) {
            if ( ! isset( $plugins[ $file ] ) ) { continue; }
            $active_data[ $file ] = array(
                'name'    => isset( $plugins[ $file ]['Name'] ) ? (string) $plugins[ $file ]['Name'] : $file,
                'version' => isset( $plugins[ $file ]['Version'] ) ? (string) $plugins[ $file ]['Version'] : '',
            );
        }
        ksort( $active_data );

        $theme = wp_get_theme();

        return array(
            'wordpress'       => (string) $wp_version,
            'php'             => PHP_VERSION,
            'theme_slug'      => $theme->get_stylesheet(),
            'theme_name'      => (string) $theme->get( 'Name' ),
            'theme_version'   => (string) $theme->get( 'Version' ),
            'active_plugins'  => $active_data,
            'permalink'       => (string) get_option( 'permalink_structure', '' ),
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function history() {
        $history = get_option( self::OPTION, array() );
        return is_array( $history ) ? array_values( $history ) : array();
    }

    /** @return array<string,mixed> */
    public function latest_snapshot() {
        $history = $this->history();
        if ( empty( $history ) ) { return array(); }
        $latest = reset( $history );
        return isset( $latest['snapshot'] ) && is_array( $latest['snapshot'] ) ? $latest['snapshot'] : array();
    }

    /**
     * @param array<string,mixed> $before Previous snapshot.
     * @param array<string,mixed> $after Current snapshot.
     * @return array<int,array<string,string>>
     */
    public function compare( array $before, array $after ) {
        if ( empty( $before ) ) { return array(); }
        $changes = array();

        foreach ( array( 'wordpress' => 'WordPress', 'php' => 'PHP' ) as $key => $label ) {
            $old = isset( $before[ $key ] ) ? (string) $before[ $key ] : '';
            $new = isset( $after[ $key ] ) ? (string) $after[ $key ] : '';
            if ( $old && $new && $old !== $new ) {
                $changes[] = array( 'type' => 'version', 'label' => $label, 'detail' => sprintf( '%s → %s', $old, $new ) );
            }
        }

        $old_theme = isset( $before['theme_slug'] ) ? (string) $before['theme_slug'] : '';
        $new_theme = isset( $after['theme_slug'] ) ? (string) $after['theme_slug'] : '';
        if ( $old_theme !== $new_theme ) {
            $changes[] = array( 'type' => 'theme', 'label' => __( 'Active theme changed', 'ndsoft-ai-website-doctor' ), 'detail' => sprintf( '%s → %s', $old_theme ?: '—', $new_theme ?: '—' ) );
        } elseif ( ! empty( $before['theme_version'] ) && ! empty( $after['theme_version'] ) && $before['theme_version'] !== $after['theme_version'] ) {
            $changes[] = array( 'type' => 'theme', 'label' => isset( $after['theme_name'] ) ? (string) $after['theme_name'] : __( 'Theme', 'ndsoft-ai-website-doctor' ), 'detail' => sprintf( '%s → %s', $before['theme_version'], $after['theme_version'] ) );
        }

        $old_plugins = isset( $before['active_plugins'] ) && is_array( $before['active_plugins'] ) ? $before['active_plugins'] : array();
        $new_plugins = isset( $after['active_plugins'] ) && is_array( $after['active_plugins'] ) ? $after['active_plugins'] : array();

        foreach ( array_diff_key( $new_plugins, $old_plugins ) as $file => $data ) {
            $changes[] = array( 'type' => 'plugin_activated', 'label' => isset( $data['name'] ) ? (string) $data['name'] : $file, 'detail' => __( 'Activated', 'ndsoft-ai-website-doctor' ) );
        }
        foreach ( array_diff_key( $old_plugins, $new_plugins ) as $file => $data ) {
            $changes[] = array( 'type' => 'plugin_deactivated', 'label' => isset( $data['name'] ) ? (string) $data['name'] : $file, 'detail' => __( 'Deactivated', 'ndsoft-ai-website-doctor' ) );
        }
        foreach ( array_intersect_key( $new_plugins, $old_plugins ) as $file => $data ) {
            $old_version = isset( $old_plugins[ $file ]['version'] ) ? (string) $old_plugins[ $file ]['version'] : '';
            $new_version = isset( $data['version'] ) ? (string) $data['version'] : '';
            if ( $old_version && $new_version && $old_version !== $new_version ) {
                $changes[] = array( 'type' => 'plugin_version', 'label' => isset( $data['name'] ) ? (string) $data['name'] : $file, 'detail' => sprintf( '%s → %s', $old_version, $new_version ) );
            }
        }

        $old_permalink = isset( $before['permalink'] ) ? (string) $before['permalink'] : '';
        $new_permalink = isset( $after['permalink'] ) ? (string) $after['permalink'] : '';
        if ( $old_permalink !== $new_permalink ) {
            $changes[] = array( 'type' => 'configuration', 'label' => __( 'Permalink structure changed', 'ndsoft-ai-website-doctor' ), 'detail' => sprintf( '%s → %s', $old_permalink ?: 'Plain', $new_permalink ?: 'Plain' ) );
        }

        return array_slice( $changes, 0, 25 );
    }

    /** @param array<string,mixed> $scan Scan. */
    public function record( array $scan ) {
        $history = $this->history();
        $issues  = array();
        foreach ( (array) ( isset( $scan['checks'] ) ? $scan['checks'] : array() ) as $check ) {
            $status = isset( $check['status'] ) ? (string) $check['status'] : '';
            if ( 'critical' !== $status && 'warning' !== $status ) { continue; }
            $issues[] = array(
                'id'      => isset( $check['id'] ) ? (string) $check['id'] : '',
                'label'   => isset( $check['label'] ) ? (string) $check['label'] : '',
                'status'  => $status,
                'message' => isset( $check['message'] ) ? (string) $check['message'] : '',
            );
            if ( count( $issues ) >= 5 ) { break; }
        }

        array_unshift(
            $history,
            array(
                'generated_at' => isset( $scan['generated_at'] ) ? (int) $scan['generated_at'] : time(),
                'score'        => isset( $scan['score'] ) ? (int) $scan['score'] : 0,
                'score_label'  => isset( $scan['score_label'] ) ? (string) $scan['score_label'] : '',
                'summary'      => isset( $scan['summary'] ) && is_array( $scan['summary'] ) ? $scan['summary'] : array(),
                'changes'      => isset( $scan['changes'] ) && is_array( $scan['changes'] ) ? $scan['changes'] : array(),
                'top_issues'   => $issues,
                'snapshot'     => isset( $scan['snapshot'] ) && is_array( $scan['snapshot'] ) ? $scan['snapshot'] : array(),
            )
        );

        $settings = Settings::get();
        $limit    = isset( $settings['history_limit'] ) ? (int) $settings['history_limit'] : 10;
        update_option( self::OPTION, array_slice( $history, 0, $limit ), false );
    }

    public function clear() {
        delete_option( self::OPTION );
    }
}
