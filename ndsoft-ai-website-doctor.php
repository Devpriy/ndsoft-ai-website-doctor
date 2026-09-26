<?php
/**
 * Plugin Name: NDsoft AI Website Doctor
 * Plugin URI: https://ndsoftdesign.com/
 * Description: User-friendly WordPress diagnostics, local diagnosis, change tracking, reports, and safe maintenance tools.
 * Version: 1.0.0
 * Author: NDsoftDesign
 * Author URI: https://ndsoftdesign.com/
 * Text Domain: ndsoft-ai-website-doctor
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'NDSOFT_AIWD_VERSION', '1.0.0' );
define( 'NDSOFT_AIWD_FILE', __FILE__ );
define( 'NDSOFT_AIWD_PATH', plugin_dir_path( __FILE__ ) );
define( 'NDSOFT_AIWD_URL', plugin_dir_url( __FILE__ ) );
define( 'NDSOFT_AIWD_BASENAME', plugin_basename( __FILE__ ) );

require_once NDSOFT_AIWD_PATH . 'includes/helpers/functions.php';
require_once NDSOFT_AIWD_PATH . 'includes/settings/class-settings.php';
require_once NDSOFT_AIWD_PATH . 'includes/health/class-result.php';
require_once NDSOFT_AIWD_PATH . 'includes/health/class-health-score.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/interface-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-site-health-bridge.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-wordpress-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-php-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-platform-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-plugin-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-theme-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-cron-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-rest-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-database-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-error-log-check.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnosis/class-diagnosis-engine.php';
require_once NDSOFT_AIWD_PATH . 'includes/history/class-change-tracker.php';
require_once NDSOFT_AIWD_PATH . 'includes/diagnostics/class-scanner.php';
require_once NDSOFT_AIWD_PATH . 'includes/reports/class-report-generator.php';
require_once NDSOFT_AIWD_PATH . 'includes/fixes/class-backup-manager.php';
require_once NDSOFT_AIWD_PATH . 'includes/fixes/class-rollback-manager.php';
require_once NDSOFT_AIWD_PATH . 'includes/fixes/class-fix-manager.php';
require_once NDSOFT_AIWD_PATH . 'includes/ai/class-data-sanitizer.php';
require_once NDSOFT_AIWD_PATH . 'includes/ai/class-ai-client.php';
require_once NDSOFT_AIWD_PATH . 'includes/ai/class-diagnosis.php';
require_once NDSOFT_AIWD_PATH . 'includes/api/class-rest-api.php';
require_once NDSOFT_AIWD_PATH . 'admin/class-dashboard.php';
require_once NDSOFT_AIWD_PATH . 'admin/class-admin.php';
require_once NDSOFT_AIWD_PATH . 'includes/class-activator.php';
require_once NDSOFT_AIWD_PATH . 'includes/class-deactivator.php';
require_once NDSOFT_AIWD_PATH . 'includes/class-plugin.php';

register_activation_hook( __FILE__, array( 'NDsoft\\AIWebsiteDoctor\\Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'NDsoft\\AIWebsiteDoctor\\Deactivator', 'deactivate' ) );

add_action( 'plugins_loaded', static function () { NDsoft\AIWebsiteDoctor\Plugin::instance()->run(); } );
