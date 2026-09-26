<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="wrap ndsoft-aiwd-wrap">
    <div class="ndsoft-aiwd-header"><div><h1><?php esc_html_e( 'Safe Maintenance', 'ndsoft-ai-website-doctor' ); ?></h1><p><?php esc_html_e( 'Only low-risk WordPress maintenance actions are included in core v1.0. No theme/plugin code is edited here.', 'ndsoft-ai-website-doctor' ); ?></p></div></div>
    <?php if ( isset( $_GET['maintenance'] ) ) : $ok = 'complete' === sanitize_key( wp_unslash( $_GET['maintenance'] ) ); $message = isset( $_GET['message'] ) ? sanitize_text_field( wp_unslash( $_GET['message'] ) ) : ''; ?><div class="notice <?php echo $ok ? 'notice-success' : 'notice-error'; ?> is-dismissible"><p><?php echo esc_html( $message ); ?></p></div><?php endif; ?>
    <div class="ndsoft-aiwd-grid ndsoft-aiwd-maintenance-grid">
        <?php foreach ( $actions as $key => $action_data ) : ?>
            <section class="ndsoft-aiwd-card"><div class="ndsoft-aiwd-risk"><?php printf( esc_html__( 'Risk: %s', 'ndsoft-ai-website-doctor' ), esc_html( $action_data['risk'] ) ); ?></div><h2><?php echo esc_html( $action_data['label'] ); ?></h2><p><?php echo esc_html( $action_data['description'] ); ?></p><form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('<?php echo esc_js( __( 'Run this maintenance action now?', 'ndsoft-ai-website-doctor' ) ); ?>');"><input type="hidden" name="action" value="ndsoft_aiwd_maintenance"><input type="hidden" name="maintenance_action" value="<?php echo esc_attr( $key ); ?>"><?php wp_nonce_field( 'ndsoft_aiwd_maintenance' ); ?><button type="submit" class="button button-secondary"><?php esc_html_e( 'Run Safely', 'ndsoft-ai-website-doctor' ); ?></button></form></section>
        <?php endforeach; ?>
    </div>
</div>
