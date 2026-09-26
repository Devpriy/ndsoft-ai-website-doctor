# Architecture

## Layers

1. **Diagnostics** — WordPress/PHP/database facts and WordPress Site Health adapters.
2. **Health** — normalized result schema, severity, score, and summary.
3. **Diagnosis** — deterministic local prioritization and next-step synthesis.
4. **History** — snapshots and change correlation between scans.
5. **Admin UI** — problem-first Dashboard plus History, Reports, Maintenance, and Settings.
6. **Reports** — privacy-conscious TXT/JSON output.
7. **Maintenance** — explicitly invoked low-risk WordPress-native operations.
8. **AI** — reserved adapter layer; remote/cloud AI is not connected in core v1.0.
9. **API** — authenticated read endpoints for admin/agent integrations.

## Naming

- Product: NDsoft AI Website Doctor
- Slug/text domain: `ndsoft-ai-website-doctor`
- PHP namespace: `NDsoft\\AIWebsiteDoctor`
- Constants: `NDSOFT_AIWD_*`
- Options/actions: `ndsoft_aiwd_*`
- CSS/JS: `ndsoft-aiwd-*`
- REST namespace: `ndsoft-ai-website-doctor/v1`

## Scan pipeline

Snapshot previous state → capture current state → run checks → normalize/sort → calculate score → build local diagnosis → calculate changes → save latest scan → retain bounded history.
