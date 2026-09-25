# Vaarta

Vaarta is a Gutenberg-native editorial WordPress block theme for news, magazine and multi-vertical publishing.

The repository itself is the installable theme source. Vaarta uses Core blocks first, theme-owned dynamic blocks only where they add editorial value, `theme.json` design tokens, block patterns, templates, Global Style variations and the WordPress Interactivity API.

## Status

Current pre-release: **0.9.0**

Vaarta is under active clean-room development. The visual system is informed by editorial patterns studied from public reference sites, but does not copy proprietary PHP, CSS, JavaScript, fonts, icons or artwork.

## Requirements

- WordPress 6.8+
- PHP 8.2+
- Modern browser with native CSS Grid/Flexbox support

## Install

### Installable ZIP

Build a distributable ZIP from the repository:

```bash
npm run package
```

The ZIP is written to:

```text
build/vaarta-0.9.0.zip
```

Upload it in **Appearance → Themes → Add New → Upload Theme**.

### Development checkout

Clone or copy the repository to:

```text
wp-content/themes/vaarta
```

Then activate **Vaarta**.

## Quick start

1. Activate Vaarta.
2. Open **Appearance → Editor → Styles**.
3. Choose one of the six Global Style variations:
   - Vaarta Tech
   - Vaarta Firmware
   - Vaarta Datacrunch
   - Vaarta Foundr
   - Vaarta Artboard
   - Vaarta Design Loft
4. Insert a matching homepage pattern or use the demo bootstrap below.
5. Configure Navigation, site identity, newsletter provider and optional ad integrations.

## One-command demo bootstrap

From the WordPress root:

```bash
wp eval-file wp-content/themes/vaarta/tools/setup-demo-site.php
```

This:

- seeds deterministic editorial posts and categories
- creates Tech, Firmware, Datacrunch, Foundr, Artboard and Design Loft pages
- creates a Blog page
- uses the **Page — Demo Canvas** template for demo homepages
- makes Tech the front page
- creates routes compatible with the Playwright visual tests

The script only replaces content previously marked as Vaarta demo fixtures.

Global Style variations are site-wide, so choose the visual identity you want to inspect in the Site Editor after bootstrapping.

## Editorial system

Major Vaarta blocks include:

- Editorial Grid
- Story Meta
- Category Cards
- Newsletter
- Ad Slot
- Review Rating
- Progress
- Social Share
- Author Box
- Contributors
- Related Stories
- Tabs / Pills
- Search Overlay
- Auto-load Next Articles
- Popup
- Social Feed
- Breadcrumbs
- Contact Form
- Team Grid
- Theme Toggle

Core Gutenberg blocks are extended with Vaarta styles for accordions, alerts, badges, drop caps, editorial images, galleries, styled lists, numbered headings, separators and social links.

## Page and post templates

### Articles

- Default article
- Article Layout 1 — Centered
- Article Layout 2 — Media Lead
- Article Layout 3 — Split Hero

Article templates share Story Meta, side + bottom sharing, author/contributor information, related stories, comments, continuous reading and dormant ad positions.

### Pages

- Page — Contact
- Page — Meet the Team
- Page — Coming Soon
- Page — Demo Canvas

## Provider-neutral integrations

Vaarta deliberately keeps external providers optional.

- Newsletter blocks accept provider form endpoints.
- Ad providers inject placement markup through `vaarta_ad_slot_html`.
- Contact form delivery uses WordPress `wp_mail()` and supports `vaarta_contact_recipient`.
- Social Feed uses native Gutenberg embeds by default.
- SEO/schema ownership is left to the active SEO plugin to avoid duplicate structured data.

## Testing

### Source validation

GitHub Actions validates:

- PHP syntax
- JavaScript and ESM syntax
- JSON syntax
- block asset references
- Gutenberg block-comment JSON
- required block-theme files
- release version consistency
- distributable ZIP packaging

### Visual regression

```bash
npm install
npx playwright install chromium
VAARTA_BASE_URL=https://vaarta.test npm run test:visual
```

Reference capture:

```bash
npm run capture:references
```

### Accessibility

```bash
VAARTA_BASE_URL=https://vaarta.test npm run test:a11y
```

### Lighthouse

```bash
VAARTA_BASE_URL=https://vaarta.test npm run audit:lighthouse
```

A manual **Site Quality Audit** GitHub Actions workflow is also provided for live WordPress installations.

## Release packaging

The **Package Vaarta** workflow can be run manually. Pushing a tag matching `v*` also builds the installable ZIP and creates or updates the corresponding GitHub release.

The distributable ZIP excludes development-only files such as GitHub workflow metadata, Playwright tests, Node dependencies and test reports.

## Documentation

See `docs/` for:

- architecture/component matrix
- advertising integration
- editorial page templates
- performance budgets
- style packs
- visual fidelity workflow

## License

Vaarta declares GPL-2.0-or-later in `style.css`.
