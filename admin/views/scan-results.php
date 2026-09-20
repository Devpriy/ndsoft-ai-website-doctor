<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
foreach ( $checks as $check ) :
    $status = sanitize_html_class( $check['status'] ?? 'info' );
?>
    <article class="ndsoft-aiwd-check ndsoft-aiwd-<?php echo esc_attr( $status ); ?>">
        <div class="ndsoft-aiwd-check-icon" aria-hidden="true"></div>
        <div>
            <h3><?php echo esc_html( $check['label'] ?? '' ); ?></h3>
            <p><?php echo esc_html( $check['message'] ?? '' ); ?></p>
        </div>
        <span class="ndsoft-aiwd-badge"><?php echo esc_html( ucfirst( $status ) ); ?></span>
    </article>
<?php endforeach; ?>
