# WPBakery to WordPress Core blocks

WPBakery stores page layouts as shortcodes and nested shortcode attributes. A move to Core blocks is therefore a content conversion and theme migration, not only a theme switch. Work on a staging copy, keep the old editor and plugins available during the transition, and migrate a representative page before converting the whole site.

## Before you start

1. Back up the database and `wp-content`, and verify that the backup can be restored.
2. Clone the site to staging and record the active theme, WPBakery version, addons, custom post types, forms, menus, widgets, and custom CSS.
3. Export or screenshot the homepage, landing pages, posts, archives, headers, footers, and responsive layouts.
4. Search the database and content for `[vc_` and `[vc_`-related shortcodes. Record which addon supplies each element.
5. Install and test the destination block theme on staging. Keep WPBakery active until every dependent page has been converted.

## Understand the conversion boundary

WPBakery's rows, columns, text blocks, buttons, images, tabs, accordions, carousels, and addon elements do not become Core blocks automatically. Existing page content may appear as raw shortcodes after the new theme is activated. The shortcodes remain data until you replace them or keep the plugin that renders them.

Use the following mapping as a starting point:

| WPBakery element | Core block or replacement |
| --- | --- |
| Row and column | Group, Row, Stack, or Columns block |
| Text block | Paragraph, Heading, List, Quote, or Group block |
| Single image | Image block |
| Image gallery | Gallery block |
| Button | Buttons and Button blocks |
| Separator | Separator or Spacer block |
| Video | Video or Embed block |
| Post grid | Query Loop block |
| Tabs and accordion | Details block or a maintained block plugin |
| Contact form | Existing form block or a maintained form plugin |
| Custom HTML | Custom HTML block, after reviewing the markup and security |

The mapping is not one-to-one. Preserve the user's content and behavior, not the old shortcode names.

## Inventory the source site

Create a migration sheet with one row per page or post:

- URL, post type, status, author, template, and last modified date.
- WPBakery elements and addons used by the content.
- Forms, embeds, downloads, custom fields, and dynamic data.
- SEO title, description, canonical URL, schema, and redirects.
- Desktop, tablet, and mobile screenshots.
- Conversion status, reviewer, and remaining dependencies.

Start with the homepage, one ordinary page, a long-form post, an archive, and the highest-value conversion page. This reveals unsupported elements before you migrate hundreds of pages.

## Prepare the block theme

1. Install the candidate block theme on staging and confirm its WordPress and PHP requirements.
2. Review **Appearance > Editor > Styles** and set the global colors, typography, content width, and spacing.
3. Recreate the header, footer, navigation, index, page, single, archive, search, and 404 templates.
4. Build reusable sections as patterns instead of copying the same group of blocks into many pages.
5. Move site-specific PHP hooks and CSS to a site plugin or child-theme equivalent rather than relying on WPBakery's theme integration.

## Convert a page

### 1. Preserve the source

Duplicate the page on staging or keep the original revision available. Save the WPBakery layout and capture the published page before editing it.

### 2. Rebuild the structure

Replace rows and columns with Group, Row, Stack, or Columns blocks. Match the intended content width and use block spacing controls rather than a collection of negative margins. Keep sections in the same order so that redirects and analytics remain easy to compare.

### 3. Replace content elements

Convert headings, paragraphs, lists, images, galleries, buttons, embeds, and separators to their Core equivalents. Upload or select the original media rather than re-encoding it. Preserve alt text, captions, focal points, links, and download attributes.

### 4. Handle unsupported elements deliberately

For tabs, accordions, sliders, maps, forms, and addon widgets, choose one of these options:

- Replace the element with a Core block that provides equivalent behavior.
- Use a maintained block plugin after checking its accessibility, security, and export behavior.
- Simplify the content into headings, paragraphs, lists, or links when the interaction is decorative.
- Keep the WPBakery shortcode temporarily and mark the page for a follow-up migration.

Do not leave a shortcode in the content while deactivating the plugin that renders it. A visible `[vc_row]` or `[contact-form-7]` string is a migration failure, not a graceful fallback.

### 5. Check mobile behavior

WPBakery layouts often encode responsive behavior in column attributes and custom classes. Compare the rebuilt page at mobile, tablet, and desktop widths. Check stacking order, image crop, spacing, text size, button width, and overflow. Remove fixed widths and inline styles that no longer serve a purpose.

## Templates, menus, and widgets

If the old theme provided WPBakery header or footer templates, recreate them as block template parts. Use the Navigation block for menus and Query Loop for post lists and grids. A classic widget can be placed in a Legacy Widget block temporarily while you replace it with a supported block.

Check **Settings > Reading** after rebuilding the homepage, and verify that the correct Front Page, Index, and archive templates are in use. Confirm that custom post types still have usable single and archive views.

## Forms, commerce, and integrations

- **Forms:** test required fields, validation, spam protection, consent text, confirmation messages, email delivery, and webhook integrations.
- **WooCommerce:** test the shop, product, variation, cart, checkout, payment, account, order email, and refund flows. Rebuild product grids with WooCommerce blocks or Query Loop.
- **Custom fields:** verify that dynamic values still render. Use block bindings, the field plugin's supported block, or a small site-plugin integration.
- **SEO:** compare titles, descriptions, canonical URLs, schema, breadcrumbs, Open Graph data, and redirects.
- **Analytics:** verify page views, forms, purchases, outbound links, consent behavior, and event payloads in a clean browser session.

## QA checklist

Before deactivating WPBakery, test a representative sample and record the results:

- No WPBakery shortcodes remain in converted content.
- Headings are ordered correctly and links have meaningful text.
- Images have useful alt text and responsive sizes.
- Keyboard navigation, focus indicators, dialogs, accordions, and forms are usable.
- The layout works at mobile, tablet, and desktop widths without horizontal scrolling.
- Logged-out and logged-in views are correct.
- Search, archives, pagination, feeds, 404, and redirects work.
- Forms, checkout, emails, webhooks, analytics, and consent tracking work.
- Page caches, CDN output, image optimization, and error logs are clean.

Run the checks with caches disabled first, then repeat with the production cache and CDN configuration enabled.

## Cutover and rollback

1. Complete the migration sheet and take a fresh production backup.
2. Freeze content edits or record a final list of pages changed after staging was created.
3. Deploy the converted content and activate the block theme during a low-traffic window.
4. Smoke-test the homepage, navigation, forms, checkout, analytics, and error logs.
5. Keep WPBakery and the old theme installed but inactive until the new site is stable and the backup retention period has passed.

If a critical issue appears, reactivate the old theme and the required plugin, then restore the affected page or the backup as appropriate. Do not remove the source content until the new output and integrations have been verified.

## Troubleshooting

### Shortcodes are visible on the page

The content still depends on WPBakery or one of its addons. Reactivate the required plugin, convert the page, and search for remaining shortcode prefixes before deactivating it.

### A page is blank after conversion

Inspect the post content for malformed shortcode remnants, disabled addon elements, and PHP errors. Restore the last known-good revision, then convert smaller sections so the failing element is isolated.

### Columns do not match the old layout

Check the content width, column ratios, gap settings, and responsive stacking. Prefer Row, Stack, and Columns block settings over copied WPBakery classes and inline CSS.

### A form looks correct but does not send

Submit it in staging and inspect the browser network log, server mail log, spam integration, and webhook response. Visual parity does not prove that the server-side action is connected.

### Search results or archives are incomplete

Check the Query Loop's post type, taxonomy, and pagination settings. Confirm that the block theme has the expected Archive, Search, and Single templates for each custom post type.
