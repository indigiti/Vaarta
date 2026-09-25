# Vaarta

Vaarta is a native WordPress Gutenberg editorial theme project.

The goal is to build a high-performance news and magazine design system inspired by the modular editorial patterns audited from the Caards demos, while using clean-room implementation, native WordPress blocks, block patterns, Query Loop variations, `theme.json`, and a companion editorial plugin for portable functionality.

## Architecture

- `theme/` — block theme: templates, template parts, patterns, style variations, presentation.
- `plugin/` — editorial engine: dynamic metadata, views, reviews, advertising, sharing, newsletter integrations, and other portable functionality.
- `docs/` — architecture and visual-system documentation.

## Development principles

- Native Gutenberg first.
- Core blocks before custom blocks.
- Server-rendered semantic HTML.
- Performance budgets and responsive images.
- Accessibility by default.
- Visual fidelity through reusable design tokens and regression testing.
