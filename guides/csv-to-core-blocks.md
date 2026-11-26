# CSV to WordPress Core blocks

A CSV file is only a transport format. Before importing, decide how each column maps to a WordPress field and how the content should be represented with core blocks. Keep the original CSV unchanged and test the mapping on a staging site.

## Prepare the CSV

- Use a header row with stable, unique column names.
- Choose an encoding such as UTF-8 and quote fields that contain commas, line breaks, or HTML.
- Decide which column is the unique source ID. Keep it in WordPress post meta so an import can be rerun without creating duplicates.
- Normalize dates, authors, statuses, slugs, categories, and media URLs before importing.
- Validate required fields and produce a rejected-row report rather than silently dropping invalid records.

## Prepare WordPress

1. Back up the destination and create a staging copy.
2. Create the destination post type, taxonomies, users, and any custom fields before loading rows.
3. Choose an importer that supports CSV-to-WordPress mapping, such as [WP All Import](https://wordpress.org/plugins/wp-all-import/), or build a repeatable script with the [WordPress REST API](https://developer.wordpress.org/rest-api/).
4. Decide how the importer will authenticate and how it will store the source ID for idempotent retries.

## Map content to core blocks

Map simple fields directly to the title, excerpt, status, author, and date. Transform the body column into block markup instead of treating it as one unstructured HTML string where possible:

- paragraphs become `core/paragraph` blocks;
- headings become `core/heading` blocks with the correct level;
- unordered and ordered lists become `core/list` blocks;
- images become `core/image` blocks after the files are imported to the media library;
- galleries, quotes, tables, and embeds become their corresponding core blocks when the source data supports them.

If the CSV contains HTML or Markdown, sanitize and transform it in a tested preprocessing step. Preserve the original source ID and any unmapped fields in post meta so a reviewer can resolve exceptions later.

## Import and verify

1. Import a small sample and open the posts in the block editor.
2. Confirm that block markup is valid, media URLs resolve, and links point to the intended site.
3. Compare source and destination row counts, statuses, authors, dates, taxonomies, and rejected rows.
4. Fix the mapping and rerun only failed or changed rows; do not re-import the entire file blindly.
5. Review responsive rendering, accessibility, search, feeds, redirects, and structured data on staging.

After approval, back up the production site, run the same versioned import, repeat the count and link checks, and keep the CSV, mapping, and import log for future updates.
