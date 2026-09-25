# WordPress integration smoke test

Vaarta has two layers of CI:

1. **Validate Vaarta** checks source syntax, Gutenberg manifests/markup, version consistency and ZIP integrity.
2. **WordPress Integration Smoke** installs the generated ZIP into clean WordPress sites and exercises the runtime.

## Matrix

The integration workflow currently covers:

- WordPress 6.8.10 — maintained patch release from Vaarta's declared minimum major/minor line
- WordPress 7.1.2 — current maintained WordPress release when this matrix was introduced

Both run on PHP 8.2, Vaarta's declared PHP minimum.

## Runtime verification

For each WordPress version the workflow:

- builds the installable Vaarta ZIP
- installs a clean WordPress database/site
- installs and activates the ZIP, not the repository working tree
- enables pretty permalinks
- runs the installed theme's demo bootstrap
- verifies key Vaarta blocks are registered
- verifies Contact, Team and Coming Soon template assignments
- starts a real WordPress HTTP server
- requests all six demo routes, Blog and editorial utility pages
- fails if a frontend route renders WordPress's critical-error message
- queries the Vaarta search REST endpoint
- confirms invalid Contact Form requests are rejected server-side

The version matrix should be refreshed as WordPress security releases advance.
