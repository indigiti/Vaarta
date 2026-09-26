# Changelog

All notable changes to Vaarta are documented here.

## 0.9.1 — Gutenberg editorial architecture rebuild

### WordPress-native composition
- Replaced hard-wired homepage rendering with WordPress-selected front-page content.
- Standard story collections now use Core Query Loop + Post Template patterns wherever possible.
- Added reusable Featured Story Grid and Horizontal Story List Gutenberg patterns.
- Reserved the dynamic Editorial Grid block for queries Core Query does not express cleanly, including most-viewed, trending-window and most-discussed ordering.
- Added deterministic comment fixtures and cross-preset taxonomy assignments for demo content.

### Shared editorial module system
- Unified all six homepage presets around shared query-card, section, panel and list primitives.
- Rebuilt Firmware with Popular, lead stories, Most Discussed, Top Weekly, Mobile, Computers, newsletter and Latest Posts regions.
- Migrated Tech, Foundr, Datacrunch, Artboard and Design Loft onto the same Gutenberg-native module grammar.
- Added responsive lead-card, category-card, horizontal-list and dark editorial-panel treatments.
- Added module styling to both the front end and Block Editor.

### Article experience
- Rebuilt the default single-post template with category kicker, author byline, editorial metadata, featured media, share tools and long-form content flow.
- Expanded article footers with tags, author/contributor modules, previous/next navigation, related stories and native comments.

## 0.9.0 — Pre-release

### Editorial design system
- Native block-theme foundation with `theme.json` v3.
- Six reusable homepage compositions and six Global Style variations.
- Responsive asymmetric editorial Bento/grid/list systems.
- Archive, category, author, search and three distinct article layouts.
- Deterministic visual-regression fixtures and public-reference capture workflow.

### Editorial blocks
- Editorial Grid with category filters, card styles, popular/trending ordering and LCP controls.
- Story Meta with author/date/read-time/views.
- Category Cards with post counts and category imagery.
- Newsletter, Ad Slot, Review Rating, Progress and Social Share.
- Author Box, Contributors and Related Stories.
- Tabs/Pills, Search Overlay, Popup and Theme Toggle using the Interactivity API.
- Auto-load Next Articles with History API updates.
- Social Feed, Breadcrumbs, Contact Form and Team Grid.

### Article experience
- Side + bottom sharing.
- Native Gutenberg comments.
- Multiple-author contributor relationships.
- Related stories and author profiles.
- Continuous reading.
- Dormant provider-neutral ad placements before/after header, before/after content and before footer.

### Editorial pages
- Contact.
- Meet the Team.
- Coming Soon.
- Demo Canvas.

### Formatting and media
- Accordion, alert, badge, drop cap, list, heading and separator Core-block styles.
- Editorial Gallery Grid, Masonry and Horizontal Strip.
- Native image lightbox.
- Portrait editorial image treatment.

### Quality
- Dark mode with system preference and persistent override.
- Skip link, focus management, reduced-motion handling and dialog focus traps.
- Axe accessibility smoke tests.
- Lighthouse performance budgets.
- PHP/JavaScript/JSON/Gutenberg-markup CI validation.
- Curated installable ZIP packaging.

### Development tooling
- WP-CLI deterministic content seeder.
- WP-CLI one-command demo-site bootstrap.
- Playwright responsive screenshot matrix.
- Manual live-site quality audit workflow.
