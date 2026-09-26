# Security

## Authorization

- All admin pages require `manage_options`.
- Scan, settings, history deletion, exports, and maintenance actions are protected by WordPress nonces.
- REST endpoints require `manage_options` and WordPress REST authentication.

## Data handling

- No passwords, tokens, cookies, or credentials are intentionally collected.
- Debug-log analysis reads at most a bounded recent tail sample.
- Raw debug-log lines and full debug-log paths are not stored in scan history or exported reports.
- Core v1.0 sends no diagnostic payload to an external AI service.

## Write actions

Core v1.0 does not edit theme/plugin PHP files, delete themes/plugins, alter DNS, change PHP versions, or edit `wp-config.php`.

Maintenance actions are allow-listed and require explicit administrator approval:

- delete expired WordPress transient records using WordPress core behavior;
- soft refresh of rewrite rules (database rules only, no `.htaccess` hard flush).

## Future remote AI gate

Any future cloud-AI feature must add authenticated transport, explicit privacy disclosure, payload minimization, rate limiting, redaction, and a user-visible enable/disable control before activation.
