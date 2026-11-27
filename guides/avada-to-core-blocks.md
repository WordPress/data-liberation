# Avada to WordPress Core blocks

Avada sites commonly combine Avada Builder content with theme options, global options, custom CSS, and theme-specific widgets. Moving to Core blocks is a staged rebuild: content remains in WordPress, but layout, templates, styles, and components must be mapped to block equivalents.

## Plan the migration

1. Back up the database and `wp-content`, and verify a restore on a staging site.
2. Clone production to staging and record the Avada, WordPress, PHP, plugin, and child-theme versions.
3. Export or screenshot the Avada Global Options, menus, widget areas, headers, footers, and key pages at desktop and mobile widths.
4. Search content for Avada Builder shortcodes such as `[fusion_` and list the addon or plugin responsible for each custom element.
5. Choose a block theme and confirm that it supports the site's content types, forms, commerce, and accessibility requirements.

Do not deactivate Avada or Avada Builder until the converted pages have been reviewed. A theme switch does not convert Avada shortcodes.

## Inventory the source site

Create a migration sheet with one row per URL or content item. Record:

- Page type, template, author, status, URL, SEO metadata, and redirect.
- Avada containers, columns, elements, global elements, and custom CSS classes.
- Header and footer layouts, menus, sidebars, widgets, and popups.
- Forms, maps, sliders, videos, downloads, dynamic fields, and third-party embeds.
- WooCommerce catalog, product, cart, checkout, account, and email customizations.
- Required behavior at mobile, tablet, and desktop widths.

Start with the homepage, one ordinary page, one long-form post, one archive, and the most important conversion page. This sample exposes unsupported elements before the full migration.

## Map Avada elements to blocks

| Avada feature | Core blocks or destination |
| --- | --- |
| Container and column | Group, Row, Stack, or Columns block |
| Text and heading | Paragraph, Heading, List, Quote, or Group |
| Button | Buttons and Button blocks |
| Image and gallery | Image and Gallery blocks |
| Slider or carousel | Gallery, Cover, or a maintained block plugin |
| Content boxes | Group, Cover, Media & Text, or Columns |
| Blog or portfolio grid | Query Loop block |
| Accordion or FAQ | Details block or a maintained accessible plugin |
| Form | Existing form block or maintained form plugin |
| Avada menu | Navigation block |
| Avada global element | Synced pattern or template part |

The goal is equivalent content and behavior, not identical markup. Simplify decorative effects that make the page slower or less accessible.

## Rebuild the block theme

1. Install the candidate block theme on staging without changing production.
2. Configure global colors, typography, content width, spacing, link states, and button styles in **Appearance > Editor > Styles**.
3. Recreate the header, footer, navigation, index, page, single, archive, search, and 404 templates.
4. Save repeated hero, call-to-action, testimonial, and feature sections as patterns.
5. Move site-specific PHP hooks and styles into a site plugin or maintainable theme layer instead of keeping them in Avada files.

### Header, footer, and navigation

Rebuild Avada's header and footer as block template parts. Use the Navigation block for menus, and confirm keyboard focus, submenu behavior, search, skip links, and mobile toggles. Verify that the site's **Settings > Reading** configuration still points to the intended homepage and posts page.

### Styles and responsive behavior

Translate Avada Global Options into Styles and block settings. Avoid copying a large bundle of Avada CSS. Use fluid typography, content widths, block spacing, and responsive stacking first; add narrowly scoped CSS only when a supported block cannot express the requirement.

Avada responsive column settings may not have a direct block equivalent. Test the rebuilt page at mobile, tablet, and desktop widths and remove fixed widths that cause horizontal scrolling.

## Convert page content

Duplicate or preserve each source page before editing it. Replace containers and columns with Group, Row, Stack, or Columns blocks, then convert the inner elements:

- Preserve image files, alt text, captions, focal points, and links.
- Use Query Loop for posts, portfolios, and related content instead of hard-coded lists.
- Use synced patterns for repeated calls to action and content sections.
- Replace shortcodes with blocks before deactivating the plugin that renders them.
- Review custom HTML for escaping, external scripts, and keyboard behavior.

If an Avada element has no safe Core equivalent, either choose a maintained block plugin, simplify the content, or keep the dependency temporarily and record it in the migration sheet.

## Forms, commerce, and dynamic content

- **Forms:** test required fields, validation, spam protection, consent, email delivery, and webhook responses.
- **WooCommerce:** inspect shop, product, variation, cart, checkout, account, order email, and payment flows after rebuilding templates.
- **Custom fields:** verify dynamic values and custom post types. Use block bindings, the field plugin's supported blocks, or a site-plugin integration.
- **SEO:** compare titles, descriptions, canonical URLs, schema, breadcrumbs, Open Graph data, and redirects.
- **Analytics:** test page views, forms, purchases, outbound links, consent behavior, and event payloads with a clean browser session.

## QA and cutover

Before deactivating Avada, confirm:

- No `[fusion_` or other Avada shortcodes remain on converted pages.
- Templates, menus, archives, search, 404, feeds, and pagination work.
- Headings, contrast, alt text, focus, dialogs, accordions, and forms are accessible.
- Mobile, tablet, and desktop layouts have no overflow or clipped content.
- WooCommerce, forms, emails, webhooks, analytics, caching, and CDN output work.
- Error logs are clean and redirects, canonical URLs, sitemap, and robots rules are correct.

Take a fresh production backup before launch, freeze or record content changes, activate the block theme during a low-traffic window, and smoke-test the critical paths. Keep Avada installed but inactive until the migration is stable and the backup retention period has passed.

If a critical problem appears, reactivate Avada and Avada Builder, restore the affected page or template, and investigate on staging. Do not delete the source theme or migration backup while rollback is still needed.

## Troubleshooting

### Avada shortcodes are visible

The page still depends on Avada Builder or an addon. Reactivate the required plugin, convert the remaining elements, and search for shortcode prefixes before deactivation.

### The header or footer is missing

Check the block theme's template parts and Navigation block. Recreate the old menu locations and verify the active Front Page, Index, and Single templates.

### The layout is too wide or breaks on mobile

Check the block theme's content width, Columns settings, gap, image sizes, and responsive stacking. Remove fixed pixel widths and copied Avada classes that no longer have a supporting stylesheet.

### Dynamic fields or forms stopped working

Confirm that the custom-field or form plugin is active and that the new block or integration supports the required data. Test the server-side response, not only the visual output.
