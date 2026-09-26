=== NDsoft AI Website Doctor ===
Contributors: ndsoftdesign
Tags: diagnostics, troubleshooting, site health, wordpress health, support
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

User-friendly WordPress diagnostics, local diagnosis, change tracking, reports, and safe maintenance tools.

== Description ==

NDsoft AI Website Doctor helps site owners and developers understand WordPress problems without requiring coding knowledge.

Core v1.0 includes:

* One-click health scan and 0-100 score.
* WordPress, PHP, plugins, themes, cron, REST/loopback, database, autoload, and bounded debug-log checks.
* Local Diagnosis Summary with priority and next steps.
* What Changed? scan comparison and retained history.
* TXT/JSON support reports.
* Low-risk WordPress maintenance actions.
* No OpenAI API key or ChatGPT subscription required.
* No diagnostic payload is sent to a remote AI service in core v1.0.

== Installation ==

1. Upload the plugin ZIP in Plugins > Add Plugin > Upload Plugin.
2. Activate NDsoft AI Website Doctor.
3. Open Website Doctor > Dashboard.
4. Click Scan My Website.

== Frequently Asked Questions ==

= Do I need an OpenAI API key? =

No. Core v1.0 diagnostics and local diagnosis work without an API key.

= Does the plugin automatically edit my theme or plugins? =

No. Core v1.0 does not edit theme/plugin source code.

= Does it send my debug log to a remote AI? =

No. Debug-log analysis is local, bounded, and raw lines are not stored in scan history or exported reports.

== Changelog ==

= 1.0.0 =
* Added local diagnosis, change tracking, history, reports, settings, Site Health expansion, safe maintenance tools, and authenticated REST read endpoints.
* Redesigned the dashboard for non-technical users.
