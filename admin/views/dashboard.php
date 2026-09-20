<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$score = isset( $scan['score'] ) ? (int) $scan['score'] : null;
$summary = isset( $scan['summary'] ) && is_array( $scan['summary'] ) ? $scan['summary'] : array();
$checks = isset( $scan['checks'] ) && is_array( $scan['checks'] ) ? $scan['checks'] : array();
?>
<div class="wrap ndsoft-aiwd-wrap">
    <div class="ndsoft-aiwd-header">
        <div>
            <h1><?php esc_html_e( 'NDsoft AI Website Doctor', 'ndsoft-ai-website-doctor' ); ?></h1>
            <p><?php esc_html_e( 'Understand what needs attention before making changes.', 'ndsoft-ai-website-doctor' ); ?></p>
        </div>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="ndsoft_aiwd_scan">
            <?php wp_nonce_field( 'ndsoft_aiwd_scan' ); ?>
            <?php submit_button( __( 'Scan My Website', 'ndsoft-ai-website-doctor' ), 'primary', 'submit', false ); ?>
        </form>
    </div>

    <?php if ( isset( $_GET['scan'] ) && 'complete' === sanitize_key( wp_unslash( $_GET['scan'] ) ) ) : ?>
        <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Website scan completed.', 'ndsoft-ai-website-doctor' ); ?></p></div>
    <?php endif; ?>

    <?php if ( null === $score ) : ?>
        <div class="ndsoft-aiwd-empty">
            <h2><?php esc_html_e( 'Run your first health scan', 'ndsoft-ai-website-doctor' ); ?></h2>
            <p><?php esc_html_e( 'The foundation scanner is read-only. It does not auto-fix files, change settings, or send site data to an AI service.', 'ndsoft-ai-website-doctor' ); ?></p>
        </div>
    <?php else : ?>
        <div class="ndsoft-aiwd-grid ndsoft-aiwd-overview">
            <section class="ndsoft-aiwd-card ndsoft-aiwd-score">
                <span><?php esc_html_e( 'Website Health', 'ndsoft-ai-website-doctor' ); ?></span>
                <strong><?php echo esc_html( $score ); ?><small>/100</small></strong>
                <p><?php echo esc_html( wp_date( 'M j, Y g:i a', (int) $scan['generated_at'] ) ); ?></p>
            </section>
            <?php foreach ( array( 'critical' => 'Critical', 'warning' => 'Warnings', 'info' => 'Info', 'pass' => 'Healthy' ) as $key => $label ) : ?>
                <section class="ndsoft-aiwd-card ndsoft-aiwd-stat">
                    <strong><?php echo esc_html( (int) ( $summary[ $key ] ?? 0 ) ); ?></strong>
                    <span><?php echo esc_html( $label ); ?></span>
                </section>
            <?php endforeach; ?>
        </div>

        <section class="ndsoft-aiwd-card ndsoft-aiwd-results">
            <div class="ndsoft-aiwd-section-title">
                <h2><?php esc_html_e( 'Problems & Checks', 'ndsoft-ai-website-doctor' ); ?></h2>
                <span><?php esc_html_e( 'Simple view', 'ndsoft-ai-website-doctor' ); ?></span>
            </div>
            <?php require NDSOFT_AIWD_PATH . 'admin/views/scan-results.php'; ?>
        </section>

        <section class="ndsoft-aiwd-card ndsoft-aiwd-report">
            <div class="ndsoft-aiwd-section-title"><h2><?php esc_html_e( 'Support Report', 'ndsoft-ai-website-doctor' ); ?></h2><span><?php esc_html_e( 'Local only', 'ndsoft-ai-website-doctor' ); ?></span></div>
            <textarea id="ndsoft-aiwd-report" readonly rows="8"><?php echo esc_textarea( $report ); ?></textarea>
            <button type="button" class="button" data-ndsoft-copy-report><?php esc_html_e( 'Copy Report', 'ndsoft-ai-website-doctor' ); ?></button>
        </section>
    <?php endif; ?>

    <section class="ndsoft-aiwd-card ndsoft-aiwd-safety">
        <h2><?php esc_html_e( 'Safe Foundation', 'ndsoft-ai-website-doctor' ); ?></h2>
        <p><?php esc_html_e( 'Version 0.1.0 performs read-only diagnostics. AI diagnosis, automated fixes, backups, and rollback are intentionally disabled until their safety flows are implemented and tested.', 'ndsoft-ai-website-doctor' ); ?></p>
    </section>
</div>
