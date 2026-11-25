# WordPress to WordPress migration with WP-CLI

WP-CLI can make a repeatable WordPress-to-WordPress migration easier to audit. Use it for database backups, content exports, imports, URL replacement, and post-migration checks. These commands assume you have shell access to both sites and that `wp` is installed and available in your PATH.

This guide covers two migration paths:

- A **content migration**, which moves posts, pages, media references, comments, terms, and authors through WXR files.
- A **full-site migration**, which moves the database and `wp-content` and is appropriate when the target should become a copy of the source.

Do not mix the two paths casually. A WXR import does not include site options or the media files themselves, while a database restore replaces the target site's existing data.

## Before you start

1. Confirm the source and target domains, document roots, database names, table prefixes, PHP versions, WordPress versions, active theme, and active plugins.
2. Put the target in maintenance mode or use a private staging URL. Never experiment on the public target before a restore has been tested.
3. Confirm that the target has enough disk space for the database dump, WXR files, uploads, and temporary files.
4. Ensure the source and target use compatible WordPress and PHP versions. Update the source on staging first when an upgrade is required.
5. Record DNS, HTTPS, cron, email, object storage, CDN, payment, webhook, and analytics settings. These are not automatically made safe by copying content.
6. Test that the account running WP-CLI has permission to read the WordPress files and execute the database client.

Run a basic preflight on both sites:

```bash
wp core version
wp core is-installed
wp plugin list --status=active
wp theme list --status=active
wp db check
wp option get siteurl
wp option get home
```

## Choose a migration path

Use the WXR path when the target already has its own theme, configuration, users, or plugins and you only need to bring over content. Use the full-site path when the target is empty or must become an operational copy of the source.

If the source is a multisite network, decide whether you are moving the entire network or one site. A single-site migration needs a separate plan for shared users, network tables, domain mapping, and uploads.

## Path A: migrate content with WXR

### 1. Export the content

Create a protected export directory outside the public web root and export all content:

```bash
mkdir -p ../migration-export
wp export --dir=../migration-export --max_file_size=256
```

The `wp export` command writes WXR files containing authors, terms, posts, comments, and attachment references. It does not include site options or the attachment files themselves. Split large exports with `--max_file_size` so that the importer does not exceed server limits.

If you need a subset, filter it deliberately and keep a record of the command:

```bash
wp export \
  --dir=../migration-export \
  --post_type=post \
  --start_date=2020-01-01 \
  --end_date=2025-12-31
```

Do not delete the export until the target has been checked and the backup retention period has passed.

### 2. Prepare the target

Install and activate the WordPress Importer on the target:

```bash
wp plugin install wordpress-importer --activate
wp plugin status wordpress-importer
```

Confirm that the target has the post types, taxonomies, shortcodes, and block plugins needed by the imported content. Install the required plugins before importing so that their content can be registered correctly.

### 3. Import the WXR files

Create or map authors explicitly. Then import one file at a time and keep the output log:

```bash
wp import ../migration-export/wordpress.2026-08-22.000.xml \
  --authors=create \
  --skip=image_resize
```

Use `--authors=skip` or `--authors=update` only when that mapping is intentional. If the export contains several files, import them in the order produced by the exporter and verify the item counts after each file.

If the source site is publicly reachable and you want attachments downloaded, allow the importer to fetch them. If it is private, copy the uploads separately or expect attachment records without local files.

### 4. Check the imported content

Run counts on both sites and compare them:

```bash
wp post list --post_type=post --format=count
wp post list --post_type=page --format=count
wp term list category --format=count
wp media list --format=count
```

Open representative posts, pages, archives, and media items. Check featured images, internal links, author attribution, comments, custom fields, blocks, shortcodes, and scheduled dates.

## Path B: migrate a complete site

This path overwrites the target database and should be performed only on a fresh or intentionally disposable target. Take a target backup anyway so that the operation is reversible.

### 1. Back up the source

Export the database and record the table prefix:

```bash
mkdir -p ../migration-backup
wp db export ../migration-backup/source.sql --add-drop-table
wp db prefix > ../migration-backup/table-prefix.txt
```

Copy `wp-content` while preserving permissions and symlinks. Exclude cache directories and temporary files when your hosting platform recreates them:

```bash
rsync -a --delete \
  --exclude='cache/' \
  --exclude='upgrade/' \
  wp-content/ ../migration-backup/wp-content/
```

Keep `wp-config.php` separate. It contains target-specific database credentials, salts, and environment settings and should not be blindly copied into the target.

### 2. Prepare the target database and files

Create the target database with your hosting provider or database administrator. Import the dump only after confirming the target database name and credentials in `wp-config.php`:

```bash
wp db import ../migration-backup/source.sql
```

Copy the source `wp-content` into the target and verify ownership and permissions. Keep the target's `wp-config.php`, salts, cache configuration, and environment-specific constants unless you have a documented reason to change them.

### 3. Update URLs safely

Run a dry run first. Include all tables with the target prefix when the prefix differs or when plugins store data outside the default table list:

```bash
wp search-replace \
  'https://old.example' \
  'https://new.example' \
  --all-tables-with-prefix \
  --skip-columns=guid \
  --dry-run
```

Review the dry-run counts. Then repeat the command without `--dry-run`:

```bash
wp search-replace \
  'https://old.example' \
  'https://new.example' \
  --all-tables-with-prefix \
  --skip-columns=guid
```

WP-CLI handles serialized data during a normal search-replace operation. Do not use a raw SQL replacement for serialized WordPress options or post meta.

For multisite, use `--network` and include the network tables only after confirming the domain and path mapping. A network migration may need separate replacements for `siteurl`, `home`, `domain`, and `path`.

### 4. Flush and rebuild derived data

```bash
wp rewrite flush --hard
wp cache flush
wp cron event run --due-now
wp transient delete --all
```

Regenerate plugin-specific indexes, image sizes, search indexes, and WooCommerce lookup tables using the plugin's supported commands or admin tools. Do not assume that a database copy rebuilds these caches.

## Post-migration verification

Check the target from the command line and through a clean browser session:

```bash
wp option get siteurl
wp option get home
wp core verify-checksums
wp plugin list
wp theme list
wp rewrite list --format=count
```

Then verify:

- Homepage, pages, posts, archives, search, feeds, and the 404 page.
- Navigation, media, featured images, embeds, downloads, and internal links.
- User login, password reset, author attribution, roles, and protected content.
- Forms, email delivery, webhooks, scheduled events, and third-party integrations.
- WooCommerce products, variations, cart, checkout, payment, orders, emails, and account pages.
- HTTPS redirects, canonical URLs, sitemap, robots rules, analytics, and cookie consent.
- Error logs, PHP warnings, cron failures, object-cache behavior, and page-cache behavior.

Keep a source-to-target count report. A successful command does not prove that every attachment, custom field, plugin index, or integration migrated correctly.

## Cutover and rollback

1. Lower DNS TTL before the planned cutover if DNS is involved.
2. Freeze content edits on the source, or plan a final delta migration.
3. Take a final source database backup and record the export timestamp.
4. Put the target into production configuration and enable HTTPS, cron, caches, and monitoring.
5. Update DNS or the reverse proxy and verify the canonical public URL.
6. Monitor logs, error rates, forms, orders, email delivery, and analytics events.

If a critical issue appears, keep the source available, switch traffic back, and restore the target database only when the target state must be reset. Do not delete the source or migration backups until the agreed retention period has passed.

## Troubleshooting

### `wp import` cannot download media

The source attachments must be publicly reachable from the target server. Copy `wp-content/uploads` separately, check the source URLs, or rerun the import after allowing the target to reach the source.

### The database import fails

Check the database credentials, server version, file permissions, SQL size limits, and available disk space. Import into an empty database when possible and inspect the first SQL error rather than rerunning blindly.

### URLs still point to the old site

Run a dry-run search-replace across all tables with the target prefix. Check plugin-specific tables and serialized options, and remember that cached HTML or a CDN can serve old output after the database is correct.

### Images or thumbnails are missing

Confirm that `wp-content/uploads` was copied with its year/month structure and correct ownership. Regenerate thumbnails with the supported image tool only after the original files are present.

### A plugin or theme breaks after the move

Check its documented migration steps and environment requirements. Re-save permalinks, clear its caches, regenerate its indexes, and inspect the PHP error log. If the problem is caused by a site-specific integration, move that integration into a site plugin instead of editing a vendor file.

For command syntax and current options, consult the official [WP-CLI command reference](https://developer.wordpress.org/cli/commands/), especially [`wp export`](https://developer.wordpress.org/cli/commands/export/), [`wp import`](https://developer.wordpress.org/cli/commands/import/), [`wp db export`](https://developer.wordpress.org/cli/commands/db/export/), [`wp db import`](https://developer.wordpress.org/cli/commands/db/import/), and [`wp search-replace`](https://developer.wordpress.org/cli/commands/search-replace/).
