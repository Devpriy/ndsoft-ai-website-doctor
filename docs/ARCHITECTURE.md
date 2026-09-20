# Architecture

## Layers

1. **Diagnostics** — read-only facts from WordPress/PHP/database state.
2. **Health** — normalized results and score calculation.
3. **Admin UI** — simple default experience; technical detail stays secondary.
4. **Reports** — local summaries safe to copy into support tickets.
5. **History** — reserved for change correlation.
6. **Fixes** — disabled until backup/approval/verify/rollback is complete.
7. **AI** — disabled until payload minimization, privacy controls and backend authentication are complete.
8. **API** — private admin-only status endpoint; future agent integrations build here.

## Naming

- Product: NDsoft AI Website Doctor
- Slug/text domain: `ndsoft-ai-website-doctor`
- PHP namespace: `NDsoft\\AIWebsiteDoctor`
- Constants: `NDSOFT_AIWD_*`
- Options/actions: `ndsoft_aiwd_*`
- CSS/JS: `ndsoft-aiwd-*`
- REST namespace: `ndsoft-ai-website-doctor/v1`
