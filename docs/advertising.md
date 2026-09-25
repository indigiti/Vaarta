# Advertising integration

Vaarta keeps ad placement and ad-provider code separate.

Editors place the `vaarta/ad-slot` Gutenberg block and choose a stable slot name such as:

- `header-leaderboard`
- `homepage-inline-1`
- `article-inline-1`
- `article-inline-2`
- `sidebar-rail`
- `footer-leaderboard`

Provider integrations inject markup through the `vaarta_ad_slot_html` filter:

```php
add_filter(
	'vaarta_ad_slot_html',
	function ( string $html, string $slot_name, array $attributes ): string {
		if ( 'article-inline-1' !== $slot_name ) {
			return $html;
		}

		return '<div class="my-ad-provider-slot" data-slot="article-inline-1"></div>';
	},
	10,
	3
);
```

The block continues to reserve its configured minimum height even before provider JavaScript fills the slot. This avoids avoidable layout shift.

Provider-specific scripts, consent handling, auction logic and targeting should remain outside the block markup.
