# Changelog

## 1.0.0 - 2026-09-22

### Added
- Production-style admin navigation: Dashboard, History, Reports, Maintenance, and Settings.
- Local Diagnosis Summary with prioritized issue explanation and recommended next steps.
- "What Changed?" snapshot comparison for WordPress/PHP versions, active theme, plugin activation/version changes, and permalinks.
- Configurable scan-history retention.
- WordPress Site Health-based PHP support, PHP extensions, HTTP requests, file uploads, timezone, and PHP-session checks.
- TXT and JSON report downloads.
- Low-risk maintenance tools for expired transients and soft rewrite-rule refresh.
- Authenticated REST endpoints for status, latest scan, and history.
- Plugin action link to the Website Doctor Dashboard.
- Expanded privacy, architecture, security, development, and roadmap documentation.

### Changed
- Scan schema upgraded to version 3.
- Version bumped to 1.0.0.
- Dashboard redesigned around non-technical problem-first language.
- Core diagnosis is explicitly local and deterministic; no remote AI claim is made.

### Safety
- No remote AI payload transmission.
- No theme/plugin source editing.
- No automatic plugin/theme deletion.
- No DNS, PHP-version, or `wp-config.php` modification.
- Maintenance actions require `manage_options`, nonce verification, and explicit confirmation.

## 0.2.0 - 2026-09-21

- Added deeper PHP, compatibility, cron, REST/loopback, database/autoload, and bounded error-log diagnostics.

## 0.1.0 - 2026-09-20

- Initial modular safety-first diagnostic foundation.
