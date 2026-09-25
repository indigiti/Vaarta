# Visual fidelity workflow

Vaarta's visual-fidelity work uses deterministic content and identical viewports.

## Seed a test site

From the WordPress root:

```bash
wp eval-file wp-content/themes/vaarta/tools/seed-demo.php
```

The seeder:

- removes only previously seeded Vaarta demo posts
- creates the editorial categories used by the demo patterns
- creates twenty deterministic stories
- sets deterministic view counts
- creates abstract locally generated PNG featured images when GD is available
- never downloads reference-site imagery

## Compare

1. Insert one of the six Vaarta homepage patterns.
2. Apply the matching Global Style variation.
3. Capture Vaarta using `npm run test:visual:update`.
4. Capture public references using `npm run capture:references`.
5. Compare:
   - container width
   - header height
   - hero line breaks
   - section vertical rhythm
   - card spans and image crops
   - headline scale
   - metadata density
   - mobile composition
6. Tune tokens/shared component CSS before introducing demo-specific exceptions.

The implementation remains clean-room: reference screenshots are inspection inputs and are not committed or redistributed.
