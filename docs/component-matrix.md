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
| Galleries | Core Gallery/Image; enhanced styles pending | Core-ready |
| Tabs & Pills | Interactivity API block | Planned |

## Remaining functional systems

- Multiple-author relationship model and Contributors block.
- Post views and trending/popular ranking.
- Auto-load next article with History API and analytics events.
- Search overlay / instant search.
- Popup system using the Interactivity API.
- Full Tabs/Pills block using nested Gutenberg content and the Interactivity API.
- Social feed provider adapters.
- Gallery slider/justified enhancements.
- Dark-mode preference/toggle system.
- Advertisement provider integration hooks.
- Final style packs for Firmware, Datacrunch, Foundr, Artboard, and Design Loft.
- Visual-regression fixtures and pixel matching against the reference demos.
- Performance and accessibility regression testing.
