<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="wrap ndsoft-aiwd-wrap">
    <div class="ndsoft-aiwd-header"><div><h1><?php esc_html_e( 'Website Doctor History', 'ndsoft-ai-website-doctor' ); ?></h1><p><?php esc_html_e( 'Compare scan scores and recent WordPress, PHP, theme, plugin, and permalink changes.', 'ndsoft-ai-website-doctor' ); ?></p></div></div>
    <?php if ( isset( $_GET['cleared'] ) ) : ?><div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Scan history cleared.', 'ndsoft-ai-website-doctor' ); ?></p></div><?php endif; ?>
    <?php if ( empty( $history ) ) : ?>
        <div class="ndsoft-aiwd-empty"><h2><?php esc_html_e( 'No scan history yet', 'ndsoft-ai-website-doctor' ); ?></h2><p><?php esc_html_e( 'Run at least one scan from the Dashboard. Changes become most useful after the second scan.', 'ndsoft-ai-website-doctor' ); ?></p></div>
    <?php else : ?>
        <section class="ndsoft-aiwd-card ndsoft-aiwd-history-list">
            <?php foreach ( $history as $index => $entry ) : ?>
                <article class="ndsoft-aiwd-history-entry">
                    <div class="ndsoft-aiwd-history-score"><strong><?php echo esc_html( (int) ( isset( $entry['score'] ) ? $entry['score'] : 0 ) ); ?></strong><span>/100</span></div>
                    <div class="ndsoft-aiwd-history-content">
                        <h2><?php echo esc_html( wp_date( 'M j, Y g:i a', (int) ( isset( $entry['generated_at'] ) ? $entry['generated_at'] : time() ) ) ); ?></h2>
                        <p><?php echo esc_html( isset( $entry['score_label'] ) ? $entry['score_label'] : '' ); ?></p>
                        <?php if ( ! empty( $entry['changes'] ) ) : ?><details<?php echo 0 === $index ? ' open' : ''; ?>><summary><?php printf( esc_html__( '%d changes detected', 'ndsoft-ai-website-doctor' ), count( $entry['changes'] ) ); ?></summary><ul><?php foreach ( $entry['changes'] as $change ) : ?><li><strong><?php echo esc_html( isset( $change['label'] ) ? $change['label'] : '' ); ?></strong> — <?php echo esc_html( isset( $change['detail'] ) ? $change['detail'] : '' ); ?></li><?php endforeach; ?></ul></details><?php endif; ?>
                        <?php if ( ! empty( $entry['top_issues'] ) ) : ?><details><summary><?php esc_html_e( 'Top issues', 'ndsoft-ai-website-doctor' ); ?></summary><ul><?php foreach ( $entry['top_issues'] as $issue ) : ?><li><strong><?php echo esc_html( isset( $issue['label'] ) ? $issue['label'] : '' ); ?></strong> — <?php echo esc_html( isset( $issue['message'] ) ? $issue['message'] : '' ); ?></li><?php endforeach; ?></ul></details><?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ndsoft-aiwd-danger-form" onsubmit="return confirm('<?php echo esc_js( __( 'Clear Website Doctor scan history?', 'ndsoft-ai-website-doctor' ) ); ?>');">
            <input type="hidden" name="action" value="ndsoft_aiwd_clear_history"><?php wp_nonce_field( 'ndsoft_aiwd_clear_history' ); ?><?php submit_button( __( 'Clear History', 'ndsoft-ai-website-doctor' ), 'secondary', 'submit', false ); ?>
        </form>
    <?php endif; ?>
</div>
