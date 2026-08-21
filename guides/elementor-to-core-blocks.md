# Elementor to WordPress Core blocks

This guide explains how to rebuild an Elementor site with WordPress Core blocks.
It focuses on preserving content, URLs, design intent, and site functionality
while removing the site's dependency on Elementor.

There is no reliable one-click conversion for every Elementor layout. Elementor
widgets and Core blocks use different structures and settings, so plan for a
controlled, page-by-page rebuild. Simple content may move quickly, while
templates, forms, popups, dynamic content, and third-party Elementor add-ons
need separate decisions.

## Before you begin

Do not deactivate Elementor on the live site at the start of the migration.
Existing pages may lose their layout, styling, or functionality while they still
depend on Elementor.

1. **Create a complete backup.** Include the database, uploads, themes, and
   plugins. Confirm that you can restore it.
2. **Work on a staging or local copy.** Keep the public site unchanged while you
   build and test the block version.
3. **Record the current site.** Capture screenshots at common desktop, tablet,
   and mobile widths. Save copies of important form submissions and
   configuration.
4. **Export an Elementor website template as an additional reference.**
   Elementor's export can include content, templates, and site settings. It is
   not a Core block conversion, but it can help preserve a record of the
   original configuration. See Elementor's
   [website template export guide](https://elementor.com/help/import-and-export-elementor-website-templates/).
5. **Inventory every Elementor dependency.** Include:
   - pages and posts edited with Elementor;
   - Theme Builder templates, headers, footers, and archive layouts;
   - global colors, fonts, spacing, and breakpoints;
   - forms, popups, loops, and dynamic tags;
   - custom CSS, custom code, tracking scripts, and integrations;
   - third-party Elementor add-ons and their widgets;
   - WooCommerce, membership, multilingual, and custom-field templates.
6. **Preserve URLs and SEO data.** Record permalinks, page titles, meta
   descriptions, canonical URLs, redirects, structured data, and analytics
   identifiers. Rebuilding a page should not require changing its public URL.

## Choose the migration scope

You can use Core blocks for page content with many classic themes. To rebuild
headers, footers, templates, and global styles with blocks, use a block theme.
The [Site Editor](https://wordpress.org/documentation/article/site-editor/) is
available when a block theme is active.

Decide whether the migration will cover:

- **Page content only:** keep the current theme and replace Elementor content
  inside individual pages.
- **The whole site:** adopt a block theme and rebuild page content, templates,
  template parts, navigation, and global styles.

For a whole-site migration, test the new theme on staging before rebuilding many
pages. A theme change can affect content width, typography, spacing, and plugin
output.

## Build the block design system first

Recreate the site's shared design choices before rebuilding individual pages.
This prevents every page from accumulating one-off settings.

With a block theme, open **Appearance > Editor > Styles** and configure:

- site colors and gradients;
- typography and font sizes;
- content and wide widths;
- spacing and layout defaults;
- the default appearance of common blocks such as Headings, Buttons, and Quotes.

The
[Styles interface](https://wordpress.org/documentation/article/styles-overview/)
applies design settings across the site. If a required font is not bundled with
the theme, install it through a suitable WordPress-supported method and confirm
its license before using it.

Create
[block patterns](https://wordpress.org/documentation/article/block-pattern/) for
repeated sections such as calls to action, testimonials, pricing rows, and
contact panels. Use synced patterns only when editing one instance should update
every occurrence.

## Map Elementor widgets to Core blocks

The following mappings are a starting point. The exact replacement depends on
the design and the Core blocks available in the WordPress version you are using.

- **Section, inner section, or container:** Use Group, Row, Stack, or Columns. A
  Group can wrap the section while nested layout blocks control alignment.
- **Heading:** Use Heading and preserve its logical level, not only its visual
  size.
- **Text Editor:** Split mixed content into Paragraph, List, Quote, or Pullquote
  blocks.
- **Image:** Use Image, or Cover when other content overlays the image.
- **Image Gallery:** Use Gallery and recheck cropping, captions, links, and
  lightbox behavior.
- **Button:** Use Buttons and Button. Recreate normal, hover, and focus styles
  through the theme where possible.
- **Divider:** Use Separator and confirm its width, color, and spacing.
- **Spacer:** Use Spacer or block spacing controls. Prefer layout gap, padding,
  or margin controls when they express the design more clearly.
- **Icon:** Use Image or a suitable icon block. Provide accessible text and do
  not use a decorative icon as the only label for an action.
- **Icon List:** Use List with an appropriate style or icon block. Confirm that
  the list remains understandable without the icons.
- **Video:** Use Video or Embed. Recheck privacy, captions, aspect ratio, and
  autoplay settings.
- **Accordion or Toggle:** Use Details, then test each item with a keyboard.
- **Tabs:** Restructure the content with Headings or Details, or use a suitable
  block. Avoid a new dependency when simpler content communicates the same
  information.
- **Posts, Portfolio, or Loop Grid:** Use Query Loop and recreate the query,
  pagination, ordering, and item template.
- **Nav Menu:** Use Navigation. It works with block themes and themes that
  support template editing.
- **Theme Builder header or footer:** Rebuild it as a Header or Footer template
  part in the Site Editor when using a block theme.
- **Single or archive template:** Rebuild it as a Site Editor template. Check
  every post type, archive, empty state, and pagination path.
- **Form:** Use the existing form plugin or a block-based form solution. Rebuild
  notifications, spam protection, consent, storage, and integrations, then
  submit test entries.
- **Popup:** Use a suitable popup solution or a different interaction. Core does
  not provide a general replacement for all popup conditions and triggers.
- **Dynamic tag or custom field:** Use a supported dynamic block, Block
  Bindings, or an integration plugin. Verify escaping, fallback values,
  permissions, and preview behavior.
- **Motion effects and entrance animations:** Simplify them or use a carefully
  selected solution. Respect reduced-motion preferences and measure the
  performance cost.

## Rebuild a representative page

Start with one page that includes the site's common layout patterns but is not
the highest-traffic or most complex page.

1. Create a new draft page or duplicate the staging page using a safe workflow.
2. Keep the original Elementor page available for side-by-side comparison.
3. Recreate the page structure with Group, Row, Stack, Columns, and Cover
   blocks.
4. Move the text and media into semantic content blocks. Avoid copying
   Elementor's generated wrapper markup into a Custom HTML block.
5. Use List View to check the nesting and order of blocks.
6. Replace repeated sections with patterns instead of rebuilding them on every
   page.
7. Match the design using global styles and block settings before adding custom
   CSS.
8. Preview the page at desktop, tablet, and mobile widths.
9. Ask a second person to compare the old and new page if possible.

Treat the first page as a test of the design system. Fix shared styles and
patterns before migrating the remaining pages.

## Rebuild templates and site-wide areas

When using a block theme, rebuild shared site areas in the Site Editor:

1. Create the Header and Footer template parts.
2. Rebuild the Navigation block and verify desktop and mobile menus.
3. Recreate the Page, Single, Home, Archive, Search, and 404 templates that the
   site uses.
4. Recreate templates for custom post types and WooCommerce views only with
   tools that explicitly support those contexts.
5. Confirm that each template contains the correct Post Content, Post Title,
   Featured Image, Query Loop, and pagination blocks.

Changes to a template or synced pattern can affect many URLs. Review the
complete save summary before saving Site Editor changes.

## Migrate the remaining content

Migrate in small batches and track the status of every URL. A useful checklist
includes:

- original URL;
- new page or template completed;
- desktop review;
- mobile review;
- forms and interactions tested;
- SEO and analytics checked;
- approved for launch.

Start with low-risk pages, then move to high-traffic landing pages and complex
templates after the process is stable. Keep the Elementor version until the
replacement has passed review.

## Test before launch

### Content and layout

- Compare headings, text, images, links, buttons, lists, tables, and downloads.
- Check alignment, content width, spacing, backgrounds, and responsive stacking.
- Verify headers, footers, navigation, breadcrumbs, sidebars, and template
  conditions.
- Confirm that hidden or conditional content still follows the intended rules.

### Functionality

- Submit every form and verify success messages, email delivery, storage, spam
  protection, consent, and external integrations.
- Test search, filters, pagination, account areas, checkout, and dynamic
  content.
- Check logged-in, logged-out, administrator, customer, and member views where
  relevant.
- Verify keyboard navigation, visible focus, form labels, image alternative
  text, and reduced-motion behavior.

### SEO and tracking

- Keep the same permalinks unless a change is intentional and redirected.
- Compare page titles, meta descriptions, canonical URLs, robots directives, and
  structured data.
- Confirm analytics, pixels, consent tools, and conversion events without
  recording duplicates.
- Crawl staging or use a link checker to find broken internal links and missing
  assets.

### Performance and stability

- Compare representative pages before and after migration.
- Check browser and server logs for errors.
- Test with caching and optimization configured as they will be in production.
- Confirm that images use appropriate dimensions and formats.

## Launch safely

1. Take a new production backup and confirm the rollback plan.
2. Schedule a maintenance window if the site receives orders, registrations, or
   user-generated content.
3. Move the approved block content, theme settings, templates, and patterns to
   production using a method that will not overwrite newer production data.
4. Purge relevant caches and test the public site while logged out.
5. Check priority URLs, forms, checkout, navigation, analytics, redirects, and
   error logs.
6. Search the database and site configuration for pages, templates, shortcodes,
   widgets, or integrations that still depend on Elementor or its add-ons.
7. Deactivate Elementor add-ons and Elementor only after those dependencies are
   gone. Do not delete them until the rollback window has passed.
8. Monitor errors, form delivery, conversions, and customer reports after
   launch.

## Troubleshooting

### The design looks different after switching themes

Themes define content width, typography, spacing, and block styles. Configure
Global Styles and templates in the new block theme, then adjust individual
blocks only where the difference is intentional.

### A widget has no Core equivalent

First decide whether the feature is still necessary. Simplifying the content is
often more maintainable than adding another dependency. When the feature is
required, choose a focused block or plugin that is actively maintained,
accessible, and compatible with the rest of the site.

### Dynamic content is missing

Document the original data source and display conditions. Confirm that the
replacement supports the same post type, custom field, query, fallback,
permissions, and escaping requirements before launch.

### Forms submit but messages do not arrive

Check the form's recipient, notification rules, spam controls, and mail delivery
configuration. Use non-sensitive test data and verify both the visitor-facing
confirmation and the server-side record or integration.

### Elementor cannot be deactivated yet

Some page, template, popup, widget, or integration still depends on it. Keep
Elementor active, identify the remaining dependency from the inventory, rebuild
or replace it, and repeat the test. A gradual migration is safer than forcing a
one-time cutover.
