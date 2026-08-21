# Drupal to WordPress

Keep the Drupal site available until the migrated content has been checked. The safest workflow is to import into a staging WordPress site, resolve content and URL differences there, and schedule the production cutover only after testing.

## Prepare both sites

- Back up the Drupal database and files, including uploaded media and configuration exports.
- Record the Drupal version, site URL, languages, content types, vocabularies, users, comments, custom fields, and important URL patterns.
- Install WordPress on staging with enough storage for the Drupal media library. Do not change the production domain yet.

## Import Drupal content

The [FG Drupal to WordPress](https://wordpress.org/plugins/fg-drupal-to-wp/) plugin is a practical starting point. Review the plugin page for current Drupal-version support, requirements, and premium extensions before beginning.

1. In WordPress, go to **Plugins > Add New**, install and activate **FG Drupal to WordPress**, and open its importer under **Tools > Import**.
2. Enter the Drupal database connection details requested by the importer. If the target server cannot reach the Drupal database, follow the plugin’s documented alternative for a database export or remote connection.
3. Select the Drupal content types, users, comments, terms, and media to import. Keep the source site reachable if images must be downloaded from its public URLs.
4. Run a small test import first. Check the results, correct the mapping or settings, and then run the remaining content in batches when the importer supports it.
5. Save the importer report and keep the original Drupal backup until the new site is live and verified.

## Map Drupal features to WordPress

An importer moves content; it does not recreate every Drupal module or theme. Map Drupal content types to WordPress post types, vocabularies to taxonomies, and custom fields to post meta or a suitable WordPress plugin. Rebuild menus, blocks, views, forms, search, and other module-provided features separately.

## Verify and cut over

- Compare a representative sample of posts, pages, custom types, terms, authors, comments, dates, and formatting.
- Confirm media files are in the WordPress media library and that content no longer references the Drupal host.
- Preserve important URLs where possible. Add redirects for changed paths and check canonical URLs, feeds, and XML sitemaps.
- Test search, forms, analytics, permissions, multilingual content, and any ecommerce or membership flows on staging.
- Take a final backup, put Drupal into maintenance mode during cutover, and point the domain to WordPress only after the checks pass.

For general importer guidance and troubleshooting, see [Importing Content](https://developer.wordpress.org/advanced-administration/wordpress/import/).
