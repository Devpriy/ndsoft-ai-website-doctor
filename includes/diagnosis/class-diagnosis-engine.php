<?php
namespace NDsoft\AIWebsiteDoctor\Diagnosis;

use NDsoft\AIWebsiteDoctor\Health\Result;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Diagnosis_Engine {
    /**
     * Build a deterministic local diagnosis from scan facts. This is not a
     * remote AI response and does not transmit site data.
     *
     * @param array<int,array<string,mixed>> $checks Diagnostic results.
     * @param array<int,array<string,string>> $changes Recent changes.
     * @return array<string,mixed>
     */
    public function build( array $checks, array $changes = array() ) {
        $priority = null;
        foreach ( $checks as $check ) {
            $status = isset( $check['status'] ) ? (string) $check['status'] : Result::INFO;
            if ( Result::CRITICAL === $status || Result::WARNING === $status ) {
                $priority = $check;
                break;
            }
        }

        $steps = array();
        foreach ( $checks as $check ) {
            $meta = isset( $check['meta'] ) && is_array( $check['meta'] ) ? $check['meta'] : array();
            if ( ! empty( $meta['recommendation'] ) ) {
                $step = trim( (string) $meta['recommendation'] );
                if ( $step && ! in_array( $step, $steps, true ) ) {
                    $steps[] = $step;
                }
            }
            if ( count( $steps ) >= 3 ) {
                break;
            }
        }

        if ( ! $priority ) {
            return array(
                'level'       => Result::PASS,
                'headline'    => __( 'No urgent problem detected', 'ndsoft-ai-website-doctor' ),
                'summary'     => __( 'The current scan did not find a critical or warning-level issue. Review informational items and keep regular backups and updates in place.', 'ndsoft-ai-website-doctor' ),
                'next_steps'  => $steps,
                'change_note' => $changes ? __( 'Recent site changes were detected. They are recorded in History for reference.', 'ndsoft-ai-website-doctor' ) : '',
            );
        }

        $id      = isset( $priority['id'] ) ? (string) $priority['id'] : '';
        $label   = isset( $priority['label'] ) ? (string) $priority['label'] : __( 'Site issue', 'ndsoft-ai-website-doctor' );
        $message = isset( $priority['message'] ) ? (string) $priority['message'] : '';
        $summary = $message;

        $cause_map = array(
            'error_log_analysis'  => __( 'Recent PHP errors suggest a code-level problem. Start with the detected plugin/theme source hints and any recent updates.', 'ndsoft-ai-website-doctor' ),
            'plugin_requirements' => __( 'One or more active plugins declare runtime requirements that the current WordPress/PHP environment does not satisfy.', 'ndsoft-ai-website-doctor' ),
            'theme_requirements'  => __( 'The active theme declares runtime requirements that the current WordPress/PHP environment does not satisfy.', 'ndsoft-ai-website-doctor' ),
            'rest_availability'   => __( 'A security rule, cache/CDN layer, authentication rule, or server restriction may be blocking WordPress REST communication.', 'ndsoft-ai-website-doctor' ),
            'loopback_requests'   => __( 'The site cannot reliably call itself. Basic Auth, firewall/CDN rules, SSL, DNS, or hosting restrictions are common causes.', 'ndsoft-ai-website-doctor' ),
            'scheduled_events'    => __( 'WordPress scheduled tasks appear delayed or blocked. Cron configuration and loopback availability are the first areas to review.', 'ndsoft-ai-website-doctor' ),
            'autoloaded_options'  => __( 'A large autoloaded-options payload may add database work to every WordPress request. Review large autoloaded options carefully before deleting anything.', 'ndsoft-ai-website-doctor' ),
            'debug_display'       => __( 'Debug output may be exposed to visitors. This is primarily a production configuration and information-disclosure risk.', 'ndsoft-ai-website-doctor' ),
        );

        if ( isset( $cause_map[ $id ] ) ) {
            $summary = $cause_map[ $id ];
        }

        return array(
            'level'       => isset( $priority['status'] ) ? (string) $priority['status'] : Result::WARNING,
            'headline'    => sprintf( __( 'Priority: %s', 'ndsoft-ai-website-doctor' ), $label ),
            'summary'     => $summary,
            'next_steps'  => $steps,
            'change_note' => $changes ? __( 'Recent changes were detected. If the problem started recently, compare the timing with the History entries before changing multiple things at once.', 'ndsoft-ai-website-doctor' ) : '',
        );
    }
}
