# Development

Recommended flow:

1. Create a feature branch from `main`.
2. Implement one bounded change.
3. Run PHP syntax checks on every PHP file.
4. Run JavaScript syntax checks.
5. Test activation and the relevant admin workflow on a disposable WordPress site.
6. Commit and push the feature branch.
7. Merge only tested changes into `main`.
8. Tag release versions.

Do not commit `.env`, API keys, release ZIPs, bundles, or checksums into the source tree.
