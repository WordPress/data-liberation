# Squarespace to WordPress

Great news! WordPress has built in tools to help you export your content from one site, and then import it into another.

## Step 1: Export your site

First of all you'll need to export your content from Squarespace. Log into your Squarespace account and select the site you'd like to migrate. Go to Settings > Import & Export Content and then click the 'Export' button and select the WordPress option.

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/import_squarespace_export.png)

It may take a moment to prepare the export - and then you can click the 'Download' button to download an XML file with your content.


## Step 2: Install the WordPress Importer

In your WordPress site you can start the import by going to Tools > Import. 
Whilst there isn't a dedicated Squarespace importer - the content you exported has been prepared in such a way that you can use the standard WordPress importer!

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/import_screen_install_wordpress.png)

Click the 'Install Now' link on the Wordpress Importer, and then click 'Run Importer' once the installation is complete.

## Step 3: Upload your WXR file

Click 'Choose File' then locate and select the WXR that you downloaded from the original site. Then click 'Upload File and Import'.

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/import_wordpress_upload_file.png)

## Step 4: Select your import options

One the file is uploaded you will given some options on how to handle the data while importing:

* You may have the option to choose to add new users, or select existing ones, in order to assign content to them.
* You can choose to download and import media attachments related to the content being imported.

**A note on importing attachments:** The original site will need to be publicly accessible in order to download the attachments from it.

## That's it!

The import process may take a little time - but be patient. You'll be notified once it is complete and then you can check your pages, posts, and other post types to check the content is there!



## Troubleshooting

Something didn’t work as expected? Here are some next steps to try.
You can also always [ask for assistance in the Support Forums](https://wordpress.org/support/plugin/wordpress-importer/?view=all).

### WXR file is too big to upload
Some hosts will have a file upload limit which is lower than the size of your WXR file. You can contact your host for assistance with raising this limit.

### 'Out of Memory' errors
If the file you’re importing is too large, your server may run out of memory when you import it. If this happens, you’ll see an error like `Fatal error: Allowed memory size of 8388608 bytes exhausted.`

If you have sufficient permissions on the server, you can edit the php.ini file to increase the available memory. Alternatively, you could ask your hosting provider to do this. Otherwise, you can edit your import file and save it as several smaller files, then import each one.

### Partial imports
If your import process fails, it still may create some content. When you resolve the error and try again, you may create duplicate data. Review your site after a failed import and remove records as necessary to avoid this.