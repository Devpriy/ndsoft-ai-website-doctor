<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }

delete_option( 'ndsoft_aiwd_version' );
delete_option( 'ndsoft_aiwd_last_scan' );
delete_option( 'ndsoft_aiwd_last_scan_at' );
