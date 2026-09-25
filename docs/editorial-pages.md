# Editorial page templates

Vaarta includes reusable Gutenberg page systems for common editorial-site pages.

## Contact

Select **Page — Contact** in the page template selector.

The template combines normal page content with the `vaarta/contact-form` block.

Contact submissions:

- use the public `/wp-json/vaarta/v1/contact` endpoint
- validate name, email and message server-side
- use a honeypot field
- rate-limit successful submissions per client
- deliver with WordPress `wp_mail()`
- default to the site Administration Email Address

Change the recipient without changing the block:

```php
add_filter(
	'vaarta_contact_recipient',
	function ( string $recipient ): string {
		return 'editor@example.com';
	}
);
```

A mail provider/plugin can replace WordPress mail delivery through normal `wp_mail` integrations.

## Meet the Team

Select **Page — Meet the Team** or insert the **Team Grid** block.

The block is driven by WordPress users. Editors can:

- select specific users
- leave selection empty to show authors automatically
- choose 2, 3 or 4 desktop columns
- show/hide biographies
- show/hide published story counts

Profiles link to normal WordPress author archives.

## Coming Soon

Select **Page — Coming Soon** for a low-chrome, viewport-height launch page.

The template includes:

- site identity
- appearance toggle
- page title/content
- reusable Newsletter block

The newsletter remains provider-neutral. Configure its form action using the block controls when connecting Mailchimp, ConvertKit, Brevo, MailerLite or another provider.

## Patterns

The same systems are available as inserter patterns:

- Contact Page
- Meet the Team
- Coming Soon

This lets editors use the compositions without assigning a special template.
