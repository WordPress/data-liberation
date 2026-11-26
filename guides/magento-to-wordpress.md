# Migrate from Magento to WordPress and WooCommerce

Magento and WooCommerce use different catalog, customer, order, URL, and theme models. A safe migration is a staged data conversion followed by a storefront rebuild and a controlled cutover. Plan the data that must be preserved before choosing an importer or theme.

## Decide what to migrate

Make a source inventory for each Magento store or website:

- Products, categories, attributes, options, variations, bundles, grouped products, and stock.
- Product images, galleries, thumbnails, and downloadable files.
- CMS pages, blocks, menus, widgets, and blog content.
- Customers, customer groups, passwords, orders, coupons, ratings, reviews, tax classes, and SEO metadata.
- Store views, languages, currencies, URL keys, redirects, payment methods, shipping rules, and tax rules.

The free [FG Magento to WooCommerce](https://wordpress.org/plugins/fg-magento-to-woocommerce/) plugin migrates product categories, category images, products, tags, thumbnails, galleries, stock, and CMS pages. Its premium version adds features such as attributes, variations, grouped products, customers, orders, reviews, coupons, SEO metadata, tax classes, Magento URL redirects, and WP-CLI support. Confirm the current feature set and licensing before promising a field to a client.

Do not assume that an importer can reproduce custom Magento modules, checkout behavior, customer groups, bundles, layered navigation, or order workflows without mapping or an add-on.

## Before you start

1. Take a complete Magento database and media backup and verify that it can be restored.
2. Create a private WordPress staging site with HTTPS and enough disk space for the catalog and images.
3. Record Magento, PHP, MySQL, WordPress, WooCommerce, importer, and PHP extension versions.
4. Freeze or document source changes during the migration window. Record the final export time.
5. Inventory payment, shipping, tax, search, email, analytics, cookie consent, and ERP/CRM integrations separately from catalog data.
6. Do not copy Magento credentials into public tickets, repositories, screenshots, or WordPress options.

## Prepare the WordPress target

Install WordPress, WooCommerce, the destination theme, and only the plugins required for the staging migration. Configure the site's timezone, currency, tax display, permalink structure, uploads, mail delivery, and HTTPS before importing.

Install and activate the importer from **Plugins > Add New**, then open **Tools > Import > Magento**. The importer needs the Magento database connection details. Keep those credentials in a private environment and use a read-only Magento database user when possible.

If Magento and WordPress are on different hosts, confirm that the WordPress server can reach the Magento database. If direct access is not permitted, export the Magento database and import a working copy on a private database host reachable by staging.

## Run a first migration on staging

1. Restore a representative Magento database backup or use a sanitized copy.
2. Copy the required Magento media to a location the importer can read, or confirm that remote media access is permitted.
3. Configure the Magento host, port, database, username, password, and table prefix in the importer.
4. Select the Magento website or store view when the migration contains multiple stores.
5. Run the import in staging and keep the importer log and timestamps.
6. Allow the importer to continue after a timeout rather than starting a second import against the same target without checking the existing records.

The importer reads Magento data; it should not modify the source store. Keep the source online until the target has passed the catalog, order, customer, and redirect checks.

## Map the catalog

### Categories and attributes

Map Magento category levels to WooCommerce product categories and preserve the intended hierarchy. Decide whether Magento attributes become global WooCommerce attributes, custom fields, or variation attributes. Document the mapping for every attribute that affects filtering, variants, search, or SEO.

### Products and variations

Check simple, configurable, grouped, bundle, virtual, downloadable, and disabled products separately. Confirm that:

- SKU, name, description, short description, price, sale price, stock, backorders, weight, and dimensions are correct.
- Configurable products become WooCommerce variable products with the expected attributes and variations.
- Product visibility, catalog order, featured status, and stock status are preserved.
- Product images and galleries retain their order, alt text, and original files.
- Cross-sells, up-sells, related products, and downloadable files have a destination mapping.

If a product type has no safe equivalent, keep it out of the public catalog until a replacement workflow is tested. Do not silently convert a bundle or grouped product into a simple product if that changes how customers buy it.

### CMS content

Review every imported CMS page. Replace Magento-specific layout XML, widgets, shortcodes, scripts, and image URLs with WordPress blocks or maintained plugins. Rebuild the header, footer, navigation, home page, landing pages, and policy pages in the destination theme.

## Customers, orders, and privacy

Customer and order migration needs a separate acceptance checklist. Confirm the importer and license support the required data before promising it:

- Customer email, name, billing, shipping, group, consent, and account status.
- Password handling and the customer sign-in experience after cutover.
- Order number, date, status, currency, line items, taxes, discounts, shipping, refunds, and notes.
- Guest orders and the relationship between historical orders and customer accounts.
- Privacy retention, deletion requests, export requests, and data-processing responsibilities.

Never send live customer data to a developer's local machine without authorization and an appropriate protection plan. If password hashes cannot be imported safely, plan a password-reset campaign rather than asking customers to reuse passwords.

## URLs, SEO, and redirects

Export a list of Magento URLs and map each one to a WooCommerce product, category, page, or intentionally retired URL. Preserve valuable slugs only when they do not conflict with WordPress rewrite rules.

Verify:

- Product, category, CMS, image, and blog URLs.
- Canonical tags, titles, descriptions, structured data, breadcrumbs, and Open Graph output.
- Redirects for changed URL keys, removed products, old media paths, and store-view URLs.
- XML sitemap, robots rules, pagination, feeds, and internal links.

Do not redirect every missing URL to the homepage. Use a relevant destination or return an intentional 410 when the content has no replacement.

## Rebuild the storefront

Use a staging theme that supports WooCommerce blocks and responsive layouts. Recreate:

- Header, footer, navigation, search, account, and cart.
- Product catalog, filters, sorting, pagination, and empty states.
- Single product layout, variation selection, stock messages, gallery, and related products.
- Cart, checkout, payment, shipping, tax, coupons, order confirmation, and customer account.
- Forms, consent notices, analytics events, transactional email, and support contact paths.

Test with real product edge cases: out-of-stock items, zero-price items, decimal quantities where supported, long titles, missing images, sale schedules, variations with different stock, and products with downloadable files.

## Validate the migration

Create a source-to-target report with counts and samples. Compare:

- Product, category, attribute, variation, customer, order, coupon, review, CMS page, and media counts.
- Random samples from each product type and category depth.
- Product prices, stock, SKUs, images, descriptions, tax classes, and visibility.
- Customer access, order totals, line items, statuses, dates, and order numbers.
- Internal links, redirects, canonical URLs, sitemap entries, and search results.
- Checkout payment, shipping, taxes, emails, refunds, analytics, and webhooks.

Run the checks logged out and logged in, on mobile and desktop, with caches disabled first and then with production caching and CDN behavior enabled. Inspect PHP, WooCommerce, mail, and web-server logs throughout.

## Cutover and rollback

1. Freeze Magento catalog and order changes or plan a final delta import.
2. Take a final Magento backup and record the export timestamp.
3. Re-run the importer or the documented delta process on staging, then capture the final count report.
4. Put the WordPress site into maintenance mode, enable production integrations, and run smoke tests.
5. Update DNS or the reverse proxy and verify the canonical HTTPS URL.
6. Monitor orders, payments, email delivery, errors, analytics, and search-console coverage.

Keep Magento available in read-only mode until the business accepts the new store and the rollback retention period has passed. If a critical issue appears, return traffic to Magento, preserve the WordPress logs, and repair the migration on staging before retrying.

## Troubleshooting

### The importer cannot connect to Magento

Check the host, port, database, username, password, and table prefix. Confirm the WordPress server can reach the database and that PDO and PDO_MySQL are enabled. Use a private database copy when the source host blocks remote connections.

### The import stops or times out

Check PHP memory, execution time, disk space, and the importer log. Disable unrelated plugins on staging, increase limits only within the host's policy, and resume from the importer rather than starting a duplicate import.

### Images are missing

Confirm the Magento base URL, media paths, file permissions, and remote URL access. Copy the media locally when the source is private, then rerun the media step and verify thumbnails.

### Product counts or variations differ

Compare the source product types, disabled products, store views, configurable attributes, grouped products, bundles, and visibility rules. A count difference may be an intentional mapping decision, but it must be documented and accepted.

### Customers or orders are missing

Verify the selected importer edition and add-ons support those records. Do not recreate orders manually without an audit trail; plan a supported import or keep Magento available as the historical order system.

### The site works visually but checkout fails

Test payment, shipping, tax, coupons, stock reduction, webhooks, order emails, refunds, and account creation with sandbox credentials. A migrated catalog is not a completed commerce migration until the server-side order flow succeeds.
