# Security baseline

- Admin scan requires `manage_options`.
- Scan POST requires WordPress nonce verification.
- v0.1.0 scan is read-only except storing the plugin's own scan result options.
- No source/theme/plugin file modification.
- No credential collection.
- No AI/network transmission of diagnostic payloads.
- REST status route is authenticated with `manage_options`.
- Uninstall deletes only plugin-owned options.

## Future safe-fix gate

No fix may ship until it supports: detection, explanation, risk rating, backup, explicit user approval, verification and rollback where technically feasible.
