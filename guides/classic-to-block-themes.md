# Leave a classic theme and move to a block theme

Moving from a classic theme to a block theme changes how you manage the site's layout. Content stays in WordPress, while templates, template parts, styles, and navigation move into the Site Editor. Treat the change as a staged migration so that you can compare the two themes and roll back safely.

## Before you start

1. Make a complete backup of the database and `wp-content`. Keep a copy outside the server and test that it can be restored.
2. Create a staging site that matches production. Do not test a theme switch for the first time on a live site.
3. Record the active theme, WordPress version, PHP version, plugins, custom post types, taxonomies, widgets, menus, forms, and analytics integrations.
4. Take screenshots of the Customizer, widget areas, menus, key pages, archive pages, and WooCommerce templates. These are your visual reference during the rebuild.
5. Check that your plugins support block themes. Update plugins on staging first, and note any plugin that adds a custom template, widget, shortcode, or editor integration.

## Understand what changes

Classic themes normally keep layout in PHP template files and expose settings through the Customizer. Block themes use HTML templates and template parts that you edit in **Appearance > Editor**. Global colors, typography, spacing, and layout are controlled by **Styles** and `theme.json`.

Posts, pages, media, users, and taxonomies are stored in the database and are not deleted by changing themes. Theme-specific settings, widgets, menus, customizer values, and PHP hooks may need to be recreated or mapped manually.

## Audit the classic site

Create a page-by-page inventory before activating the new theme:

| Existing feature | Record before switching | Likely block-theme destination |
| --- | --- | --- |
| Header and footer | Logo, navigation, search, utility links | Header and Footer template parts |
| Homepage | Sections, hero, query loops, calls to action | Front Page template and patterns |
| Blog and archives | Columns, metadata, pagination, filters | Index, Archive, and Search templates |
| Single content | Title, author, featured image, related content | Single template and patterns |
| Sidebar and widgets | Widget order, shortcodes, embeds | Columns, Sidebar template part, or blocks |
| Customizer settings | Colors, widths, typography, CSS | Styles, site-wide CSS, or block settings |
| Menus | Locations, labels, nested items | Navigation block |
| WooCommerce | Shop, product, cart, checkout, account layouts | WooCommerce blocks and templates |

Also search the content for shortcodes and theme-specific classes. A block theme cannot automatically replace a shortcode supplied by the old theme, so identify an actively maintained block or plugin before removing the dependency.

## Install and compare the block theme

1. Install the candidate block theme on staging without activating it on production.
2. Read the theme's documentation and confirm its minimum WordPress and PHP versions.
3. Preview the theme and compare its content width, typography, color contrast, spacing, and responsive behavior with your screenshots.
4. Activate it on staging. WordPress will use the block theme's templates immediately; the old theme remains available for rollback.
5. Open **Appearance > Editor** and review **Design > Styles**, **Patterns**, **Templates**, and **Navigation** before making custom changes.

## Rebuild the site structure

### Header, footer, and navigation

Open **Patterns > Template parts** and edit the Header and Footer parts. Recreate the logo, site title, navigation, search, social links, and utility links with blocks. Use the Navigation block to recreate menu hierarchy and confirm that every link and submenu works on touch screens.

If the old theme registered multiple menu locations, decide whether each one is still needed. A block theme may expose one or more Navigation blocks rather than the old location names.

### Templates

Review the templates used by the site and edit them in **Appearance > Editor > Templates**. Common templates include:

- Index for the default post list.
- Front Page for a static homepage.
- Page and Single Post for individual content.
- Archive, Category, Tag, and Author for archive views.
- Search for search results.
- 404 for missing URLs.

Use Query Loop, Post Template, Featured Image, Post Title, Post Excerpt, Post Date, Post Author, and Pagination blocks to reproduce the old content hierarchy. Keep content-specific sections in patterns instead of duplicating them across templates.

### Styles

Use **Styles** to set the global palette, typography, link treatment, content width, and spacing. Prefer the theme's style controls and block settings before adding custom CSS. If the old site relies on custom CSS, move only the rules that are still required and test them at narrow and wide viewports.

### Widget areas and legacy widgets

The **Legacy Widget** block can temporarily render a classic widget inside a block template. Use it as a bridge while you replace each widget with a supported block. For example:

- Text or HTML widgets become Paragraph, Heading, Image, or Custom HTML blocks.
- Recent Posts and Categories become Query Loop or navigation blocks.
- Custom menus become Navigation blocks.
- Shortcode widgets remain only while the plugin that provides the shortcode is active.

After each replacement, compare the output and remove the legacy widget only when the replacement is verified. See the [legacy widget migration documentation](https://developer.wordpress.org/block-editor/how-to-guides/widgets/legacy-widget-block/).

## Convert page content

Open representative pages in the editor and replace theme-specific shortcodes, columns, buttons, and separators with core blocks where possible. Save repeated sections as synced patterns so future edits remain consistent.

Do not rewrite every page at once. Start with the homepage, one ordinary page, one long-form post, an archive, and the site's most important conversion page. Record any content that still depends on a shortcode or a plugin-specific block and make a replacement decision before deactivating the old dependency.

## Rebuild special features

- **Forms:** keep the existing form plugin if it supports the new theme, or migrate to a maintained block-based form solution. Test validation, email delivery, spam protection, confirmation messages, and consent text.
- **WooCommerce:** inspect the Product Catalog, Single Product, Cart, Checkout, and Customer Account templates. Test variable products, coupons, shipping, taxes, payment, order emails, and account pages.
- **Custom post types:** check that archive and single templates render the correct fields. Recreate custom field output with blocks, block bindings, or a maintained integration plugin.
- **Analytics and SEO:** verify title and description output, canonical URLs, structured data, analytics events, cookie consent, and redirects.
- **Custom PHP:** review hooks and filters supplied by the old theme. Move site-specific behavior to a site plugin or mu-plugin so it does not disappear on the next theme change.

## Test before launch

Compare staging with the reference screenshots and test at mobile, tablet, and desktop widths. Check:

- Navigation, search, skip links, keyboard focus, and heading order.
- Contrast, link states, alt text, captions, and form labels.
- Homepage, pages, posts, archives, search, 404, feeds, and pagination.
- Logged-out and logged-in views, user roles, and protected content.
- WooCommerce catalog, product, cart, checkout, payment, email, and account flows.
- Performance, image sizes, lazy loading, caching, analytics, and error logs.
- Permalinks, redirects, canonical URLs, sitemap, robots rules, and social previews.

Use a clean browser session and test with caches disabled first. Then test with the production caching and CDN configuration enabled.

## Launch and rollback

1. Back up production immediately before launch and record the active theme and plugin versions.
2. Rehearse the activation and verification checklist on staging.
3. Activate the block theme during a low-traffic window.
4. Check the homepage, navigation, forms, checkout, analytics, and error logs immediately.
5. Keep the classic theme installed until the migration has been stable and the backup has been verified.

If a critical issue appears, reactivate the classic theme, restore the affected template or plugin setting, and use the backup if data was changed. A theme switch should not be used as a substitute for a database restore when the problem is caused by content or plugin data.

## Troubleshooting

### The old menu is missing

Open **Appearance > Editor > Navigation** and select the existing navigation. If it is not present, recreate it from the old menu inventory and verify every nested item.

### A widget shows as a legacy widget

Keep the plugin active, place the widget in a Legacy Widget block, and replace it with a core or maintained block when possible. Do not remove the plugin until no page, template, or widget area depends on it.

### The homepage layout changed

Check whether the old site used a static front page and whether the block theme provides a Front Page template. Rebuild the sections as a pattern or template, then verify the **Settings > Reading** configuration.

### Custom fields or dynamic content disappeared

Confirm that the custom post type and field plugin are active. Recreate the output with the plugin's block, a supported block binding, or a small site-plugin integration. Do not hard-code values that editors need to update.

### The site looks correct but forms or tracking stopped

Test submissions and inspect the browser network log, mail delivery, consent configuration, and analytics events. A visual match does not prove that server-side integrations are still connected.

For additional background, see [Moving sites](https://developer.wordpress.org/advanced-administration/upgrade/migrating/) and [Importing widget areas from a classic theme to a block theme](https://learn.wordpress.org/tutorial/importing-widget-areas-from-a-classic-theme-to-a-block-theme/).
