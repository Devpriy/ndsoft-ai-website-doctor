# NDsoft AI Website Doctor

NDsoft AI Website Doctor is a safety-first WordPress troubleshooting plugin for site owners, freelancers, and agencies.

## What v1.0 does

- One-click WordPress health scan
- 0–100 health score with Critical / Warning / Info / Healthy grouping
- WordPress, PHP, required extension, upload, HTTP, plugin, theme, cron, REST/loopback, database and autoload diagnostics
- Bounded local `debug.log` analysis with fatal/warning/deprecated/notice counts
- Local **Diagnosis Summary** that prioritizes the most important problem and next steps
- **What Changed?** comparison between scans for WordPress, PHP, active theme, active plugin versions/activation state, and permalink structure
- Scan history with configurable retention
- Privacy-conscious TXT and JSON support reports
- Low-risk maintenance tools: clear expired transients and soft-refresh rewrite rules
- Authenticated admin-only REST endpoints for status, latest scan, and history
- Zero OpenAI/API-key requirement for core features

## Important AI note

The product name is **NDsoft AI Website Doctor**, but the core v1.0 diagnosis is deterministic local analysis, not a remote generative-AI response. Remote/cloud AI is intentionally not connected in this build. That keeps v1.0 useful without an API key, ChatGPT subscription, or separate AI purchase and avoids transmitting diagnostic payloads off-site.

## Safety model

Diagnostics are read-mostly. Core v1.0 does not edit theme/plugin PHP files, delete plugins/themes, change PHP versions, modify DNS, or automatically alter `wp-config.php`.

The two Maintenance actions are explicitly initiated by an administrator and are restricted to WordPress-native low-risk cleanup/rebuild operations.

## Privacy

- Scan results and history are stored in the local WordPress database.
- Raw debug-log lines are not stored in scan history or exported reports.
- Core v1.0 sends no diagnostic payload to OpenAI or another AI provider.
- Reports intentionally exclude passwords, tokens, cookies, raw log lines, and full filesystem paths.

## Installation

1. Upload the release ZIP in **Plugins → Add Plugin → Upload Plugin**.
2. Activate **NDsoft AI Website Doctor**.
3. Open **Website Doctor → Dashboard**.
4. Click **Scan My Website**.

## Development

- Product: `NDsoft AI Website Doctor`
- Slug/text domain: `ndsoft-ai-website-doctor`
- Namespace: `NDsoft\\AIWebsiteDoctor`
- Options/actions prefix: `ndsoft_aiwd_`
- REST namespace: `ndsoft-ai-website-doctor/v1`

See `docs/ARCHITECTURE.md`, `docs/SECURITY.md`, and `docs/PRIVACY.md`.
