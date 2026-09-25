# Vaarta visual regression

The visual suite is for pixel-level tuning after the Gutenberg modules and patterns are installed on a WordPress test site.

## Setup

```bash
npm install
npx playwright install chromium
```

Point the suite at a WordPress site running Vaarta:

```bash
VAARTA_BASE_URL=https://vaarta.test npm run test:visual:update
VAARTA_BASE_URL=https://vaarta.test npm run test:visual
```

The demo paths can be overridden independently:

- `VAARTA_TECH_PATH`
- `VAARTA_FIRMWARE_PATH`
- `VAARTA_DATACRUNCH_PATH`
- `VAARTA_FOUNDR_PATH`
- `VAARTA_ARTBOARD_PATH`
- `VAARTA_DESIGN_LOFT_PATH`

Article URLs can be supplied as a comma-separated list through `VAARTA_ARTICLE_PATHS`.

## Viewports

Homepage snapshots cover:

- 1440 × 1200
- 1280 × 1000
- 768 × 1024
- 430 × 932
- 390 × 844

The intended workflow is:

1. capture Vaarta snapshots
2. compare them with manually captured reference screenshots
3. tune design tokens, card geometry, typography and media crops
4. update Vaarta baselines only after the visual change is accepted
5. keep future changes within the screenshot-diff budget
