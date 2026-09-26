<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$show_technical = isset( $settings['technical_details'] ) && ! empty( $settings['technical_details'] );
foreach ( $checks as $check ) :
    $status         = sanitize_html_class( isset( $check['status'] ) ? $check['status'] : 'info' );
    $meta           = isset( $check['meta'] ) && is_array( $check['meta'] ) ? $check['meta'] : array();
    $recommendation = isset( $meta['recommendation'] ) ? (string) $meta['recommendation'] : '';
    $category       = isset( $meta['category'] ) ? sanitize_key( $meta['category'] ) : '';
?>
    <article class="ndsoft-aiwd-check ndsoft-aiwd-<?php echo esc_attr( $status ); ?>">
        <div class="ndsoft-aiwd-check-icon" aria-hidden="true"></div>
        <div class="ndsoft-aiwd-check-content">
            <div class="ndsoft-aiwd-check-heading"><h3><?php echo esc_html( isset( $check['label'] ) ? $check['label'] : '' ); ?></h3><?php if ( $category ) : ?><span class="ndsoft-aiwd-category"><?php echo esc_html( ucwords( str_replace( '_', ' ', $category ) ) ); ?></span><?php endif; ?></div>
            <p><?php echo esc_html( isset( $check['message'] ) ? $check['message'] : '' ); ?></p>
            <?php if ( $recommendation ) : ?><p class="ndsoft-aiwd-recommendation"><strong><?php esc_html_e( 'Recommended:', 'ndsoft-ai-website-doctor' ); ?></strong> <?php echo esc_html( $recommendation ); ?></p><?php endif; ?>

            <?php if ( 'plugin_requirements' === ( isset( $check['id'] ) ? $check['id'] : '' ) && ! empty( $meta['items'] ) && is_array( $meta['items'] ) ) : ?>
                <details class="ndsoft-aiwd-details"><summary><?php esc_html_e( 'View affected plugins', 'ndsoft-ai-website-doctor' ); ?></summary><ul><?php foreach ( $meta['items'] as $item ) : ?><li><?php echo esc_html( ( isset( $item['name'] ) ? $item['name'] : '' ) . ' — ' . ( isset( $item['reason'] ) ? $item['reason'] : '' ) ); ?></li><?php endforeach; ?></ul></details>
            <?php endif; ?>

            <?php if ( 'error_log_analysis' === ( isset( $check['id'] ) ? $check['id'] : '' ) && ! empty( $meta['sources'] ) && is_array( $meta['sources'] ) ) : ?>
                <?php $source_labels = array(); if ( ! empty( $meta['sources']['plugins'] ) ) { $source_labels[] = __( 'Plugins: ', 'ndsoft-ai-website-doctor' ) . implode( ', ', array_map( 'sanitize_key', $meta['sources']['plugins'] ) ); } if ( ! empty( $meta['sources']['themes'] ) ) { $source_labels[] = __( 'Themes: ', 'ndsoft-ai-website-doctor' ) . implode( ', ', array_map( 'sanitize_key', $meta['sources']['themes'] ) ); } ?>
                <?php if ( $source_labels ) : ?><p class="ndsoft-aiwd-technical"><strong><?php esc_html_e( 'Detected source hints:', 'ndsoft-ai-website-doctor' ); ?></strong> <?php echo esc_html( implode( ' | ', $source_labels ) ); ?></p><?php endif; ?>
            <?php endif; ?>

            <?php if ( $show_technical && $meta ) : ?>
                <details class="ndsoft-aiwd-details"><summary><?php esc_html_e( 'Technical metadata', 'ndsoft-ai-website-doctor' ); ?></summary><pre><?php echo esc_html( wp_json_encode( $meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) ); ?></pre></details>
            <?php endif; ?>
        </div>
        <span class="ndsoft-aiwd-badge"><?php echo esc_html( ucfirst( $status ) ); ?></span>
    </article>
<?php endforeach; ?>
