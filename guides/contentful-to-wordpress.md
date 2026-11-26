# Contentful to WordPress

Contentful spaces are highly configurable, so a migration needs a data map rather than a one-size-fits-all importer. Export the source space, decide how each content type maps to WordPress, and test the transformation on staging before importing the complete dataset.

## Prepare the WordPress destination

1. Create a staging WordPress site and back it up before importing.
2. Decide which Contentful content types become posts, pages, or custom post types.
3. Decide whether each field becomes post content, post meta, a taxonomy, a featured image, or a related WordPress object.
4. Create the destination post types, taxonomies, fields, and users before loading content.
5. Set `WP_IMPORTING` to `true` during the import so WordPress can avoid import-time notifications and related side effects. Remove the temporary setting when the import is complete.

## Export from Contentful

Use Contentful’s [CLI export command](https://www.contentful.com/developers/docs/tutorials/cli/import-and-export/) or the [contentful-export library](https://github.com/contentful/contentful-export) to create a JSON export. Keep the original export unchanged and record the space, environment, locale, and export date.

## Map and transform the data

Inspect the export before writing to WordPress. Contentful entries contain IDs, locales, references, and fields that may not have a direct WordPress equivalent.

- Map `title` and rich-text fields to the destination title and `post_content`.
- Convert Contentful rich text to WordPress-compatible HTML or blocks, and preserve unsupported formatting for manual review.
- Map assets to the WordPress media library, retaining the original asset ID and URL in a migration log.
- Resolve linked entries in dependency order so referenced content exists before the parent entry is imported.
- Convert dates, slugs, locales, authors, and publication status explicitly rather than relying on defaults.

For a small migration, a custom script can call the [WordPress REST API](https://developer.wordpress.org/rest-api/) to create posts, media, terms, and users. For a large migration, use a repeatable command-line importer or WP-CLI command with retries, logging, and an idempotent source-ID mapping so a failed batch can be safely rerun.

## Import and verify

1. Run the transformer against a small sample and review the generated WordPress records.
2. Import referenced assets and entries, then import the parent content.
3. Capture rejected records and validation errors instead of silently skipping them.
4. Compare counts by content type, locale, status, and asset type between the export and WordPress.
5. Check links, images, embeds, structured data, redirects, search, and editor output on staging.

Take a final backup, run the full import, repeat the count and link checks, and switch the production site only after the results are approved. Keep the source export and mapping log for future incremental migrations.
