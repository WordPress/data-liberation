# Joomla to WordPress

Moving a Joomla site to WordPress is easiest when the source site remains online until the imported content has been checked. Plan the move, make backups of both sites, and test the import on a staging WordPress site first.

## Before you start

- Back up the Joomla database and the files directory.
- Record the Joomla site URL, administrator account, language, and any custom fields or extensions that must be recreated in WordPress.
- Create a WordPress installation with enough storage for the media library. Do not point the production domain at it until the migration is complete.

## Import the Joomla content

The [FG Joomla to WordPress](https://wordpress.org/plugins/fg-joomla-to-wordpress/) plugin is a starting point for importing Joomla content. Review its current compatibility and requirements before beginning.

1. In WordPress, go to **Plugins > Add New**, search for **FG Joomla to WordPress**, and install and activate it.
2. Open **Tools > Import > Joomla (FG)**.
3. Enter the Joomla database connection details requested by the importer. The WordPress server must be able to reach the Joomla database, or you must provide a compatible database export according to the importer’s documentation.
4. Choose whether to import categories, posts, pages, users, comments, and media. Keep the source site available if the importer needs to fetch remote images.
5. Run the importer and keep the completion report. For a large site, import in smaller batches if the plugin provides that option.

## Rebuild the site in WordPress

An importer moves content; it does not recreate every Joomla extension or template. Choose a WordPress theme, recreate navigation menus and widgets, and replace Joomla extensions with WordPress plugins that provide equivalent functionality. Review custom fields and content types individually rather than assuming they map to posts or pages.

## Verify and switch over

- Check posts, pages, categories, authors, comments, and media for a representative sample.
- Confirm internal links, image URLs, redirects, and the site’s permalink structure.
- Compare important Joomla URLs with their WordPress URLs and add redirects where paths changed.
- Test search, forms, analytics, metadata, and any ecommerce or membership flows on staging.
- Take a final backup, put the Joomla site into maintenance mode during the cutover, and point the domain to WordPress only after the staging checks pass.

For general WordPress importer troubleshooting, see the [WordPress importing content documentation](https://wordpress.org/documentation/article/importing-content/).
