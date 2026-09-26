<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="wrap ndsoft-aiwd-wrap">
    <div class="ndsoft-aiwd-header"><div><h1><?php esc_html_e( 'Website Doctor Reports', 'ndsoft-ai-website-doctor' ); ?></h1><p><?php esc_html_e( 'Copy or export a privacy-conscious diagnostic report for a developer, host, or support ticket.', 'ndsoft-ai-website-doctor' ); ?></p></div></div>
    <?php if ( ! $report ) : ?>
        <div class="ndsoft-aiwd-empty"><h2><?php esc_html_e( 'No report yet', 'ndsoft-ai-website-doctor' ); ?></h2><p><?php esc_html_e( 'Run a scan first.', 'ndsoft-ai-website-doctor' ); ?></p></div>
    <?php else : ?>
        <section class="ndsoft-aiwd-card ndsoft-aiwd-report"><textarea id="ndsoft-aiwd-report" readonly rows="22"><?php echo esc_textarea( $report ); ?></textarea><div class="ndsoft-aiwd-actions"><button type="button" class="button" data-ndsoft-copy-report><?php esc_html_e( 'Copy Report', 'ndsoft-ai-website-doctor' ); ?></button>
            <?php foreach ( array( 'txt' => __( 'Download TXT', 'ndsoft-ai-website-doctor' ), 'json' => __( 'Download JSON', 'ndsoft-ai-website-doctor' ) ) as $format => $label ) : ?><form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"><input type="hidden" name="action" value="ndsoft_aiwd_export_report"><input type="hidden" name="format" value="<?php echo esc_attr( $format ); ?>"><?php wp_nonce_field( 'ndsoft_aiwd_export_report' ); ?><button class="button" type="submit"><?php echo esc_html( $label ); ?></button></form><?php endforeach; ?>
        </div><p class="description"><?php esc_html_e( 'Reports intentionally exclude raw debug-log lines, cookies, passwords, tokens, and full filesystem paths.', 'ndsoft-ai-website-doctor' ); ?></p></section>
    <?php endif; ?>
</div>
