# Development

## Stable branch

`main` contains tested code only.

Suggested feature branches:

- `feature/core-scanner`
- `feature/error-diagnostics`
- `feature/dashboard`
- `feature/recent-changes`
- `feature/safe-fixes`
- `feature/ai-diagnosis`

## Release flow

1. Implement a focused feature branch.
2. Run PHP syntax checks and WordPress smoke tests.
3. Review safety/privacy implications.
4. Commit with a clear conventional message.
5. Merge to `main`.
6. Tag milestone (`v0.1.0`, `v0.2.0`, ...).
7. Generate plugin ZIP from tracked distributable files.
