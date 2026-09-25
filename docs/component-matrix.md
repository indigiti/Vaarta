# Vaarta Gutenberg Component Matrix

Vaarta is an editorial design system. Pages are compositions of reusable Core Gutenberg blocks, Vaarta blocks, block styles, patterns, Query variations, templates, and global style variations.

## Foundation

| Capability | Implementation | Status |
| --- | --- | --- |
| Global design tokens | `theme.json` | Foundation |
| Header / Footer | Template parts | Foundation |
| Front page / Blog | Block templates | Foundation |
| Archive / Category / Author / Search | Block templates | Foundation |
| Article Layout 1 / 2 / 3 | Selectable custom block templates | Foundation |
| Demo homepages | Gutenberg patterns | 6 compositions |

## Editorial modules

| Reference capability | Vaarta implementation | Status |
| --- | --- | --- |
| Bento / magazine grids | `vaarta/editorial-grid` | Built |
| Category-filtered sections | Editorial Grid category slug | Built |
| Card variants | Standard / Minimal / Overlay / Dark / Compact | Built |
| Reading time | `vaarta/story-meta` + grid metadata | Built |
| Author metadata | `vaarta/story-meta` | Built |
| Author profile | `vaarta/author-box` | Built |
| Related stories | `vaarta/related-posts` | Built |
| Newsletter / subscription | `vaarta/newsletter` | Built |
| Review percentages / points / stars | `vaarta/review` | Built |
| Progress bars | `vaarta/progress` | Built |
| Social sharing | `vaarta/social-share` | Built |
| Advertising placement | `vaarta/ad-slot` | Built |
| Promo sections | Core blocks + Vaarta patterns | Built |
| Featured / Latest queries | Query Loop variations + Editorial Grid | Foundation |

## Formatting modules

| Reference capability | Vaarta implementation | Status |
| --- | --- | --- |
| Accordions | Core Details + Vaarta style | Built |
| Alerts | Core Group + Vaarta Alert style | Built |
| Separators | Core Separator + Hairline style | Built |
| Badges | Core Paragraph + Badge style | Built |
| Drop Caps | Core Paragraph + Drop Cap style | Built |
| Styled blocks | Core Group styles | Built |
| Styled lists | Core List + Check List style | Built |
| Numbered headings | Core Heading + Numbered style | Built |
| Social links | Core Social Links + Pills style | Built |
| Galleries | Core Gallery/Image + Grid/Masonry/Strip + native lightbox | Built |
| Tabs & Pills | Nested blocks + Interactivity API | Built |

## Remaining functional systems

- Multiple-author relationship model and Contributors block. **Built**
- Post views and trending/popular ranking. **Built**
- Auto-load next article with History API and analytics events. **Built**
- Search overlay / instant search. **Built**
- Popup system using the Interactivity API. **Built**
- Full Tabs/Pills block using nested Gutenberg content and the Interactivity API. **Built**
- Social feed layouts using native Gutenberg embeds. **Built**; authenticated provider APIs remain optional adapters.
- Gallery Grid/Masonry/Horizontal Strip enhancements. **Built**
- Dark-mode preference/toggle system. **Built**
- Advertisement provider integration hooks.
- Global Style packs for Tech, Firmware, Datacrunch, Foundr, Artboard, and Design Loft. **Built — first-pass tokens**
- Visual-regression fixtures for all six demos and article layouts. **Built**; pixel tuning remains iterative.
- Performance and accessibility regression testing.


## Editorial utilities milestone

Built in the editorial-utilities milestone:

- lightweight first-party post views with editor/crawler exclusions
- Most Viewed and 7-day Trending ordering in Editorial Grid
- structured contributor user relationships stored as REST-visible post meta
- Contributors Gutenberg block with compact/profile layouts
- system-aware dark mode with persistent manual toggle
- nested Tabs/Pills with arbitrary inner Gutenberg blocks and keyboard navigation
- instant Search Overlay with public compact REST endpoint
- continuous article loading with History API URL/title updates
- `vaarta:autoload` browser event for analytics adapters
- expanded CI for PHP, JSON, JS modules, and block asset references


## Editorial experience milestone

Built in the editorial-experience milestone:

- reusable Popup block with button, delayed and scroll-depth triggers
- once-per-session handling for automatic popups
- arbitrary nested Gutenberg content inside popups
- Core Gallery styles: Editorial Grid, Masonry and Horizontal Strip
- Core Image Portrait treatment
- native WordPress image lightbox enabled globally while remaining editor-adjustable
- six Global Style variations sharing the same semantic design tokens
- Social Feed container for Instagram, X, Facebook, Pinterest or mixed native embeds
- Playwright visual regression harness for all six demo homepages
- fixed desktop, tablet and mobile viewport coverage
- article-layout screenshot regression support


## Quality and fidelity milestone

Built in the quality-fidelity milestone:

- keyboard-visible skip link and automatic main-content target
- consistent focus-visible treatment across interactive controls
- reduced-motion hardening
- focus trapping for Search Overlay and Popup
- focus restoration after automatic popups close
- dedicated Vaarta Editorial block inserter category
- selective first-story LCP image priority
- responsive image sizes hints for editorial grids
- provider-neutral advertising integration hook
- shared long-form article typography for standard and auto-loaded stories
- semantic Breadcrumbs block for articles and archive/search/author templates
- accessibility smoke tests using axe
- manual Lighthouse quality workflow with performance budgets
- stricter CI validation for Gutenberg block-comment JSON and custom block categories

Quality targets are documented in `docs/performance-budgets.md`.


## Visual fidelity milestone

Built in the visual-fidelity milestone:

- widened 1320px editorial canvas
- refined full-width low-chrome site header
- larger balanced homepage hero typography and deck
- asymmetric 7/5-column Bento geometry
- stronger first-story hierarchy and image ratio
- denser read-time/views metadata rhythm
- compact mobile story composition after the lead story
- expanded Tech homepage with Future Tech, Social, Newsletter and Latest Stories layers
- Foundr homepage aligned with Strategies, trending Top on the Week, Entrepreneurship and News
- tuned Firmware, Datacrunch, Artboard and Design Loft lead/section rhythm
- refined Newsletter and Social Feed presentation
- expanded editorial footer
- six Global Style packs refined beyond color into navigation, button and brand typography behavior
- deterministic WP-CLI demo-content seeder with locally generated abstract featured images
- visual/reference screenshot matrix expanded through 1024px and 360px breakpoints
- documented clean-room visual comparison workflow

The next fidelity passes should be driven by running WordPress screenshots with seeded content and comparing measured geometry against the public references.


## Pixel tuning milestone

Built in the pixel-tuning milestone:

- reusable Category Cards block with:
  - editor-selectable categories
  - automatic most-used categories fallback
  - post counts
  - optional descriptions
  - latest-post featured image per category
  - Grid / Strip layouts
- reusable Popular Stories pattern powered by Most Viewed ordering
- Popular discovery layer added above Tech and Datacrunch
- Tech composition expanded with a dedicated Gear section
- Datacrunch composition expanded with:
  - Popular
  - Featured Posts
  - Social Feed
  - Top on the Week
  - Category Cards
- Artboard composition expanded with media-led resource category cards
- archive/search/author templates rebuilt around shared editorial hierarchy
- archive cards now reuse Story Meta for author/date/read-time/views consistency
- three article layouts rebuilt around shared:
  - category
  - title
  - post excerpt/deck
  - Story Meta
  - hero media
  - article body
  - article footer
- Centered, Full-bleed Media Lead and Split Hero layouts now have distinct responsive silhouettes
- shared CSS added for:
  - Popular strips
  - archive headers/cards/pagination
  - article headers/decks/heroes/body widths
  - mobile article stacking
- Top on the Week changed to image-led compact stories

This pass intentionally keeps all fidelity improvements inside reusable Gutenberg modules, patterns and shared component CSS.
