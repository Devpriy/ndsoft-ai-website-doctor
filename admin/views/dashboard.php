<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$score       = isset( $scan['score'] ) ? (int) $scan['score'] : null;
$summary     = isset( $scan['summary'] ) && is_array( $scan['summary'] ) ? $scan['summary'] : array();
$checks      = isset( $scan['checks'] ) && is_array( $scan['checks'] ) ? $scan['checks'] : array();
$diagnosis   = isset( $scan['diagnosis'] ) && is_array( $scan['diagnosis'] ) ? $scan['diagnosis'] : array();
$changes     = isset( $scan['changes'] ) && is_array( $scan['changes'] ) ? $scan['changes'] : array();
$score_label = isset( $scan['score_label'] ) ? (string) $scan['score_label'] : '';
?>
<div class="wrap ndsoft-aiwd-wrap">
    <div class="ndsoft-aiwd-header">
        <div>
            <h1><?php esc_html_e( 'NDsoft AI Website Doctor', 'ndsoft-ai-website-doctor' ); ?></h1>
            <p><?php esc_html_e( 'Scan, understand, and troubleshoot WordPress without exposing your site data to a remote AI service.', 'ndsoft-ai-website-doctor' ); ?></p>
        </div>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="ndsoft_aiwd_scan">
            <?php wp_nonce_field( 'ndsoft_aiwd_scan' ); ?>
            <?php submit_button( __( 'Scan My Website', 'ndsoft-ai-website-doctor' ), 'primary', 'submit', false ); ?>
        </form>
    </div>

    <?php if ( isset( $_GET['scan'] ) && 'complete' === sanitize_key( wp_unslash( $_GET['scan'] ) ) ) : ?>
        <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Website scan completed and saved to History.', 'ndsoft-ai-website-doctor' ); ?></p></div>
    <?php endif; ?>

    <?php if ( null === $score ) : ?>
        <div class="ndsoft-aiwd-empty">
            <span class="dashicons dashicons-heart"></span>
            <h2><?php esc_html_e( 'Run your first website health scan', 'ndsoft-ai-website-doctor' ); ?></h2>
            <p><?php esc_html_e( 'Website Doctor checks WordPress, PHP, plugins, themes, scheduled tasks, database health, connectivity, and recent PHP errors. No OpenAI key is required.', 'ndsoft-ai-website-doctor' ); ?></p>
        </div>
    <?php else : ?>
        <div class="ndsoft-aiwd-grid ndsoft-aiwd-overview">
            <section class="ndsoft-aiwd-card ndsoft-aiwd-score">
                <span><?php esc_html_e( 'Website Health', 'ndsoft-ai-website-doctor' ); ?></span>
                <strong><?php echo esc_html( $score ); ?><small>/100</small></strong>
                <?php if ( $score_label ) : ?><b class="ndsoft-aiwd-score-label"><?php echo esc_html( $score_label ); ?></b><?php endif; ?>
                <p><?php echo esc_html( wp_date( 'M j, Y g:i a', (int) $scan['generated_at'] ) ); ?></p>
            </section>
            <?php foreach ( array( 'critical' => __( 'Critical', 'ndsoft-ai-website-doctor' ), 'warning' => __( 'Warnings', 'ndsoft-ai-website-doctor' ), 'info' => __( 'Info', 'ndsoft-ai-website-doctor' ), 'pass' => __( 'Healthy', 'ndsoft-ai-website-doctor' ) ) as $key => $label ) : ?>
                <section class="ndsoft-aiwd-card ndsoft-aiwd-stat ndsoft-aiwd-stat-<?php echo esc_attr( $key ); ?>">
                    <strong><?php echo esc_html( (int) ( isset( $summary[ $key ] ) ? $summary[ $key ] : 0 ) ); ?></strong>
                    <span><?php echo esc_html( $label ); ?></span>
                </section>
            <?php endforeach; ?>
        </div>

        <?php if ( $diagnosis ) : ?>
            <section class="ndsoft-aiwd-card ndsoft-aiwd-diagnosis ndsoft-aiwd-diagnosis-<?php echo esc_attr( sanitize_html_class( isset( $diagnosis['level'] ) ? $diagnosis['level'] : 'info' ) ); ?>">
                <div class="ndsoft-aiwd-section-title"><h2><?php esc_html_e( 'Diagnosis Summary', 'ndsoft-ai-website-doctor' ); ?></h2><span><?php esc_html_e( 'Local analysis', 'ndsoft-ai-website-doctor' ); ?></span></div>
                <h3><?php echo esc_html( isset( $diagnosis['headline'] ) ? $diagnosis['headline'] : '' ); ?></h3>
                <p><?php echo esc_html( isset( $diagnosis['summary'] ) ? $diagnosis['summary'] : '' ); ?></p>
                <?php if ( ! empty( $diagnosis['change_note'] ) ) : ?><p class="ndsoft-aiwd-change-note"><?php echo esc_html( $diagnosis['change_note'] ); ?></p><?php endif; ?>
                <?php if ( ! empty( $diagnosis['next_steps'] ) ) : ?>
                    <div class="ndsoft-aiwd-next-steps"><strong><?php esc_html_e( 'Recommended next steps', 'ndsoft-ai-website-doctor' ); ?></strong><ol><?php foreach ( $diagnosis['next_steps'] as $step ) : ?><li><?php echo esc_html( $step ); ?></li><?php endforeach; ?></ol></div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ( $changes ) : ?>
            <section class="ndsoft-aiwd-card ndsoft-aiwd-changes">
                <div class="ndsoft-aiwd-section-title"><h2><?php esc_html_e( 'What Changed Since the Previous Scan?', 'ndsoft-ai-website-doctor' ); ?></h2><a href="<?php echo esc_url( admin_url( 'admin.php?page=ndsoft-ai-website-doctor-history' ) ); ?>"><?php esc_html_e( 'View history', 'ndsoft-ai-website-doctor' ); ?></a></div>
                <ul><?php foreach ( array_slice( $changes, 0, 8 ) as $change ) : ?><li><strong><?php echo esc_html( isset( $change['label'] ) ? $change['label'] : '' ); ?></strong> — <?php echo esc_html( isset( $change['detail'] ) ? $change['detail'] : '' ); ?></li><?php endforeach; ?></ul>
            </section>
        <?php endif; ?>

        <section class="ndsoft-aiwd-card ndsoft-aiwd-results">
            <div class="ndsoft-aiwd-section-title"><h2><?php esc_html_e( 'Problems & Checks', 'ndsoft-ai-website-doctor' ); ?></h2><span><?php echo ! empty( $settings['technical_details'] ) ? esc_html__( 'Technical details enabled', 'ndsoft-ai-website-doctor' ) : esc_html__( 'Simple view', 'ndsoft-ai-website-doctor' ); ?></span></div>
            <?php require NDSOFT_AIWD_PATH . 'admin/views/scan-results.php'; ?>
        </section>
    <?php endif; ?>

    <section class="ndsoft-aiwd-card ndsoft-aiwd-privacy">
        <div class="ndsoft-aiwd-section-title"><h2><?php esc_html_e( 'Privacy & Safety', 'ndsoft-ai-website-doctor' ); ?></h2><span><?php esc_html_e( 'Core v1.0', 'ndsoft-ai-website-doctor' ); ?></span></div>
        <p><?php esc_html_e( 'Core diagnostics and diagnosis run locally in WordPress. This build does not send diagnostic payloads to OpenAI or another AI provider. Maintenance tools are deliberately limited to low-risk WordPress cleanup/rebuild actions.', 'ndsoft-ai-website-doctor' ); ?></p>
    </section>
</div>
