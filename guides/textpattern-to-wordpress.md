# Textpattern to WordPress

WordPress has a Textpattern importer for moving categories, users, posts, comments, and links. Keep the Textpattern site online until the imported content and its links have been verified.

## Before importing

1. Back up the Textpattern database and files, including images and any custom fields.
2. Create a staging WordPress site and confirm that it has enough storage for the imported media.
3. Record the Textpattern site URL, administrator accounts, publishing dates, categories, and any sections or custom fields that need to be mapped manually.

## Run the importer

1. In WordPress, open **Tools > Import**.
2. If **Textpattern** is not listed, install the [Textpattern Importer](https://wordpress.org/plugins/textpattern-importer/) from the WordPress plugin directory, then return to the Import screen.
3. Select **Run Importer** and provide the Textpattern database details requested by the importer.
4. Select the content and authors to import. Keep the source site reachable if the importer needs to download images or other linked files.
5. Run the import and save the completion information. For a large site, repeat the process in manageable batches if supported by the importer.

## Recreate and verify the site

The importer moves content, but it does not reproduce a Textpattern theme or every plugin. Choose a WordPress theme, rebuild navigation and widgets, and map Textpattern sections and custom fields to WordPress post types, taxonomies, or post meta as appropriate.

- Compare a sample of posts, pages, comments, authors, dates, categories, and links with the source site.
- Check image attachments and replace any URLs that still point to the Textpattern host.
- Set the intended WordPress permalink structure and create redirects for changed URLs.
- Test search, forms, analytics, feeds, and any custom functionality on staging.
- Take a final backup and switch the domain only after the migration passes these checks.

For additional importer options and troubleshooting, see the [WordPress importing content documentation](https://developer.wordpress.org/advanced-administration/wordpress/import/).
