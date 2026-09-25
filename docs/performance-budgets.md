# Vaarta performance budgets

Vaarta treats performance as part of the editorial design system, not a final optimization pass.

## User-facing targets

The automated site audit uses these thresholds:

| Metric | Target |
| --- | ---: |
| Lighthouse performance | >= 0.90 |
| Lighthouse accessibility | >= 0.95 |
| Largest Contentful Paint | <= 2.5 s |
| Cumulative Layout Shift | <= 0.10 |
| Total Blocking Time | <= 200 ms warning |
| First Contentful Paint | <= 1.8 s warning |
| Total page weight | <= 1.6 MB warning |

These are regression budgets, not guarantees across every host, device or advertising stack.

## Theme implementation budgets

- avoid jQuery as a frontend dependency
- use WordPress Interactivity API only for interactive components
- keep feature JavaScript block-scoped through block metadata
- prioritize only the actual likely LCP image
- lazy-load below-fold story and gallery media
- reserve ad dimensions before provider scripts execute
- prefer system fonts until a licensed/self-hosted editorial font is deliberately added
- preserve explicit image dimensions and responsive WordPress image markup
- keep third-party social content behind native embeds or provider adapters
- avoid loading authenticated social/provider SDKs globally
- keep semantic server-rendered HTML as the baseline experience

## Running audits

Use GitHub Actions → **Site Quality Audit** and supply a public WordPress installation running the branch/theme being evaluated.

The audit is intentionally separate from source validation because Core Web Vitals depend on the WordPress host, content, media and third-party integrations.
