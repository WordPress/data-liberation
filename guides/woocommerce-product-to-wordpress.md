# WooCommerce Products to WordPress

If you have another WordPress site with WooCommerce products you'd like to migrate that's definitely something you can do.
WooCommerce has a built in Product CSV import/export tool which can be used to transfer products in a few simple steps.

## Step 1: Export your products

In your site admin, go to 'Products' and then click the 'Export' button at the top.

Clicking the 'Generate CSV' will create and download a CSV file containing your products. There are also settings you can use to include/exclude certain product details, categories, and vary the export otherwise. [You can refer to WooCommerce's own documentation on those](https://woo.com/document/product-csv-importer-exporter/#export) if you wish to use them.

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/woo-csv-export.webp)

**NOTE:** It is *also* possible to manually create a CSV file, or edit a CSV export from *another* platform to make it fit the data schema WooCommerce expects. You can [download a sample of Product data in the schema](https://github.com/woocommerce/woocommerce/tree/trunk/plugins/woocommerce/sample-data), or find out more in the documentation about the [Product Data CSV Schema](https://github.com/woocommerce/woocommerce/wiki/Product-CSV-Import-Schema#csv-columns-and-formatting).

## Step 2: Install WooCommerce on your new site

First of all, you'll need WooCommerce installed on your site (if it isn't already).

In your admin menu go to Plugins > Add New and then search for WooCommerce. Click on 'Install', and then 'Activate'


## Step 3: Import your products

Once WooCommerce is installed, you can go to WooCommerce > Products in your admin menu and click 'Import' at the top. The Upload CSV File screen will display.

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/product-csv-import-01.webp)

Select Choose File and the CSV you wish you use and click 'Continue'. For further information on the other options in this screen - [check out WooCommerce's more details documentation](https://woo.com/document/product-csv-importer-exporter/?quid=bfdabf3117c866ffaf4ad5b58820b55d#adding-new-products.

Now you will see the 'Column Mapping' screen where WooCommerce automatically attempts to match or “map” the Column Name from your CSV to Fields.

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/woo_columnmapping.webp)

Making any adjustments you would like (using the dropdown menus for each field) and then click 'Run the importer'. 

Wait until the Importer is finished. Do not refresh or touch the browser while in progress.

## That's it!
Your products are now imported - you can view them under 'Products' in the main admin menu.
