# Vaarta release checklist

Use this checklist before creating a tagged release.

## Source

- [ ] `style.css` and `package.json` versions match.
- [ ] Validate workflow is green on `main`.
- [ ] No development-only secrets or local files are present.
- [ ] `CHANGELOG.md` reflects the target version.
- [ ] Clean-install accessibility gate is green on every configured WordPress version.

## Package

- [ ] **WordPress Integration Smoke** is green for every configured WordPress version.
- [ ] Run `npm run package`.
- [ ] Install the generated ZIP on a clean WordPress site.
- [ ] Activate without PHP warnings or fatal errors.
- [ ] Confirm Site Editor loads templates, patterns and style variations.
- [ ] Confirm custom blocks appear under **Vaarta Editorial**.

## Demo

- [ ] Run `wp eval-file wp-content/themes/vaarta/tools/setup-demo-site.php`.
- [ ] Confirm Tech is the front page.
- [ ] Confirm `/firmware/`, `/datacrunch/`, `/foundr/`, `/artboard/`, `/design-loft/` and `/blog/`.
- [ ] Switch through all six Global Style variations.

## Editorial flows

- [ ] Publish a post with featured image, categories and excerpt.
- [ ] Check all three alternate article templates.
- [ ] Check author/contributor output.
- [ ] Check comments open/closed states.
- [ ] Check side and bottom share layouts.
- [ ] Check related stories and continuous reading.
- [ ] Check search overlay and dark mode.

## Forms and providers

- [ ] Verify WordPress mail delivery before testing Contact Form.
- [ ] Submit a valid Contact Form message.
- [ ] Confirm invalid email and rate-limit states.
- [ ] Configure a newsletter endpoint and verify submission.
- [ ] Connect a test `vaarta_ad_slot_html` filter and verify dormant ad slots expand only when populated.

## Quality

- [ ] Run visual regression at all configured viewports.
- [ ] Review the automated clean-install accessibility results; run `npm run test:a11y` locally when investigating regressions.
- [ ] Run Lighthouse audit against representative homepage/article/archive pages.
- [ ] Check keyboard-only navigation.
- [ ] Check reduced-motion mode.
- [ ] Check 360px, 390px, 430px, 768px, 1024px, 1280px and 1440px layouts.

## Release

- [ ] Tag the release as `vX.Y.Z`.
- [ ] Confirm **Package Vaarta** workflow succeeds.
- [ ] Download and install the GitHub release ZIP one final time.
