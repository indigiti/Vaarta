# Vaarta architecture

## Product model

Vaarta is a Gutenberg-first editorial system, not a page-builder theme.

### Theme responsibilities

- visual tokens and global styles
- templates and template parts
- patterns and layout compositions
- block style variations
- responsive behavior
- accessible presentation

### Companion plugin responsibilities

- reading time and post views
- editorial ranking/trending signals
- ratings/reviews
- ad slots
- social sharing and integrations
- newsletter provider adapters
- multiple-author relations
- auto-load next article

## Guiding rules

1. Prefer WordPress Core blocks.
2. Prefer Query Loop variations over bespoke query implementations.
3. Add a custom block only where Core cannot express the required editorial UX.
4. Keep frontend JavaScript minimal and progressively enhanced.
5. Treat visual fidelity as a token/layout problem, not duplicated markup.
6. Keep content portable across themes.
