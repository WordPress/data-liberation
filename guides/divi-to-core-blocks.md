# Divi to WordPress Core blocks

Divi layouts are stored as builder modules, rows, sections, shortcodes, theme options, and custom CSS. Moving to Core blocks requires rebuilding those structures while preserving content, URLs, integrations, and responsive behavior. Work on a staging copy and keep Divi available until the converted pages pass review.

## Prepare the migration

1. Back up the database and `wp-content`, then verify that the backup can be restored.
2. Clone production to staging and record WordPress, PHP, Divi, child-theme, plugin, and PHP version details.
3. Export or screenshot Divi Theme Options, Theme Builder templates, menus, widget areas, headers, footers, and important pages at desktop and mobile widths.
4. Search content for Divi shortcode prefixes such as `[et_pb_` and list the modules or third-party extensions that render them.
5. Choose and install a block theme on staging. Confirm that it supports the site's post types, forms, commerce, SEO, and accessibility requirements.

Changing themes does not convert Divi modules. Deactivate Divi only after the migration sheet shows that no page, template, or widget still depends on it.

## Build a source inventory

For every page, post, template, and custom post type, record:

- URL, content type, status, author, template, SEO metadata, and redirects.
- Divi sections, rows, columns, modules, global modules, and custom classes.
- Header, footer, menu, sidebar, widget, popup, and Theme Builder assignments.
- Forms, sliders, maps, video, downloads, dynamic fields, and external embeds.
- WooCommerce product, catalog, cart, checkout, account, and email customizations.
- Required desktop, tablet, and mobile behavior.

Start with the homepage, a normal page, a long-form post, an archive, and the highest-value conversion page. Use this sample to decide how to handle modules without a Core equivalent.

## Map Divi to blocks

| Divi feature | Core blocks or destination |
| --- | --- |
| Section and row | Group, Row, Stack, or Columns block |
| Text module | Paragraph, Heading, List, Quote, or Group |
| Button module | Buttons and Button blocks |
| Image and gallery modules | Image and Gallery blocks |
| Video module | Video or Embed block |
| Blog module | Query Loop block |
| Accordion and toggle | Details block or a maintained accessible plugin |
| Contact form | Existing form block or maintained form plugin |
| Menu module | Navigation block |
| Divi global module | Synced pattern or template part |

Preserve the content and user-facing behavior rather than copying Divi's classes or markup. Simplify visual effects that make the new page slower or less accessible.

## Recreate the site shell

1. Install the block theme on staging and configure its global palette, typography, content width, spacing, and link states under **Appearance > Editor > Styles**.
2. Rebuild Divi Theme Builder assignments as block templates and template parts: Header, Footer, Index, Page, Single, Archive, Search, and 404.
3. Recreate menus with the Navigation block and verify focus, nested items, search, skip links, and mobile behavior.
4. Save repeated hero, testimonial, call-to-action, and feature sections as patterns.
5. Move site-specific PHP hooks and CSS into a site plugin or maintainable theme layer instead of retaining Divi implementation files.

Check **Settings > Reading** after building the templates so that the intended static homepage and posts page are still selected.

## Convert a page

Preserve the original revision or duplicate the page on staging. Then convert in small sections:

1. Replace Divi sections and rows with Group, Row, Stack, or Columns blocks.
2. Convert headings, text, lists, buttons, images, galleries, embeds, and separators to Core blocks.
3. Reuse the original media and preserve alt text, captions, focal points, links, and download attributes.
4. Replace hard-coded post grids with Query Loop and keep repeated sections as synced patterns.
5. Replace shortcodes before deactivating Divi or a third-party extension.
6. Compare the page at mobile, tablet, and desktop widths and remove fixed widths, overflow, and copied Divi classes.

For accordions, sliders, maps, forms, and other interactive modules, either choose a Core or maintained block equivalent, simplify the content, or keep the dependency temporarily and record it for follow-up. Do not leave a visible `[et_pb_...]` shortcode as the final output.

## Dynamic content and integrations

- **Custom fields:** confirm that post types and fields remain registered. Use block bindings, a supported field block, or a small site-plugin integration for dynamic output.
- **Forms:** test required fields, validation, spam protection, consent, confirmation messages, email delivery, and webhooks.
- **WooCommerce:** inspect catalog, single product, cart, checkout, account, payment, order email, and refund flows after rebuilding templates.
- **SEO:** compare title and description output, canonical URLs, schema, breadcrumbs, Open Graph data, and redirects.
- **Analytics:** verify page views, form submissions, purchases, outbound links, consent behavior, and event payloads with a clean browser session.

## QA checklist

Before deactivating Divi, test representative content and record the results:

- No `[et_pb_` or other Divi shortcodes remain in converted content.
- Header, footer, navigation, templates, archives, search, 404, feeds, and pagination work.
- Headings, contrast, alt text, keyboard focus, dialogs, accordions, and forms are accessible.
- Mobile, tablet, and desktop layouts have no horizontal scrolling or clipped content.
- Logged-out and logged-in views, protected content, roles, and author output are correct.
- WooCommerce, forms, emails, webhooks, analytics, cache, CDN, and image optimization work.
- PHP warnings and error logs are clean and redirects, canonical URLs, sitemap, and robots rules are correct.

Test with caches disabled first, then repeat with the production cache and CDN configuration enabled.

## Launch and rollback

Take a fresh production backup and freeze or record content changes before launch. Activate the block theme during a low-traffic window, smoke-test the homepage, navigation, forms, checkout, analytics, and logs, and keep Divi installed but inactive until the new output has been stable for the agreed retention period.

If a critical issue appears, reactivate Divi and the required extensions, restore the affected page or template, and investigate on staging. Do not delete the source theme or backup while rollback is still needed.

## Troubleshooting

### Divi shortcodes are visible

Reactivate Divi and any extension that supplies the shortcode, convert the remaining modules, and search for `[et_pb_` before deactivation.

### The old header or footer is missing

Check the block theme's Header and Footer template parts and recreate the old Theme Builder assignments. Verify the Navigation block and the active Front Page, Index, and Single templates.

### Spacing or columns do not match

Check the content width, Columns settings, gap, image sizes, and responsive stacking. Prefer block layout controls over copied Divi classes and large global CSS overrides.

### Forms or tracking look correct but fail

Submit forms and inspect the browser network log, server mail log, webhook responses, consent state, and analytics events. Visual parity does not prove that integrations are connected.
