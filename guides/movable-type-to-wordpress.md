# Movable Type or TypePad to WordPress

WordPress includes an importer for Movable Type and TypePad exports. The importer can bring over posts and comments; themes, plugins, and some custom fields need to be recreated separately.

## Prepare the source and destination

- Back up the Movable Type or TypePad site, including its export file, uploaded media, and database where available.
- Keep the source site online and create a staging WordPress site before changing DNS or URLs.
- Review authors, categories, tags, dates, custom fields, and the URL pattern you want to keep in WordPress.

## Export from Movable Type or TypePad

Use the export function in the source administration area and save the generated export file. Keep a copy of the original file unchanged. If media is not included in the export, also download the source uploads so they can be copied to the WordPress media library.

## Import into WordPress

1. In WordPress, go to **Tools > Import**.
2. Select **Movable Type and TypePad**. If it is not installed, choose **Install Now**, then **Run Importer**.
3. Upload the export file and start the import.
4. Assign imported authors to existing WordPress users or create users as appropriate. Do not create accounts for people who should not have access to the new site.
5. Wait for the importer to finish and save its report. For a large export, split it into smaller files only after making a backup and confirming that the split preserves entry boundaries.

## Bring over media and site features

Review image and file URLs after the import. Copy media that was not included in the export, upload it to WordPress, and update references in posts. Rebuild the Movable Type or TypePad theme, navigation, widgets, and plugin features with WordPress equivalents.

## Verify and launch

- Compare a representative set of posts, comments, authors, categories, tags, dates, and formatting with the source.
- Set the WordPress permalink structure and add redirects from important old URLs.
- Test feeds, search, forms, analytics, embeds, and media on staging.
- Take a final backup and switch the domain only after the content and redirects pass review.

See the [WordPress Tools Import screen documentation](https://wordpress.org/documentation/article/tools-import-screen/) for the importer entry point and supported content types.
