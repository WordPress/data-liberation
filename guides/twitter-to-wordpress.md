# Twitter to WordPress

Moving a Twitter archive into WordPress is different from importing a blog. Decide which posts, media, replies, and links are useful before importing, and keep the original archive as your source of truth.

## Prepare an export and a staging site

1. Request and download your Twitter/X archive from the account settings. Keep the original archive unchanged and make a second working copy.
2. Create a staging WordPress site and back it up before importing anything.
3. Review the archive and decide how tweets should map to WordPress posts, pages, or a custom post type. Decide whether replies, retweets, likes, and deleted media should be excluded.

## Choose an importer

The WordPress [importing content documentation](https://developer.wordpress.org/advanced-administration/wordpress/import/#twitter) lists **Get Your Twitter Timeline into WordPress** as an example of a Twitter importer. Review the plugin’s current support, privacy policy, and API requirements before installing it. A plugin may require a Twitter/X developer application, and the available API access can change over time.

1. Install a maintained importer on staging and follow its connection or archive-upload instructions.
2. Grant only the access the importer needs. Never paste API keys into a post, issue, or public repository.
3. Map the Twitter account to a WordPress author and choose the destination post type, status, date handling, and media behavior.
4. Start with a small sample. Check the output before importing the complete archive, and keep a record of the import date and settings.

## Clean up and verify

- Check tweet text, timestamps, hashtags, mentions, links, replies, and quoted posts for formatting changes.
- Confirm that downloaded images and videos are stored in the WordPress media library rather than pointing back to Twitter.
- Decide how to represent threads and conversations; a single post may be clearer than hundreds of isolated replies.
- Add categories or tags only after reviewing the imported data, and remove duplicates from retries before running another batch.
- Test search, feeds, embeds, privacy settings, and the site’s permalink structure on staging.

After the content is approved, take a final backup and publish the WordPress site. Keep the Twitter archive and an import log so the migration can be audited or repeated.
