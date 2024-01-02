# WooCommerce Products to WordPress

If you have another WordPress site with WooCommerce products you'd like to migrate that's definitely something you can do.
WooCommerce has a built in Product CSV import/export tool which can be used to transfer products in a few simple steps.

## Step 1: Export your products

In your site admin, go to 'Products' and then click the 'Export' button at the top.

Clicking the 'Generate CSV' will create and download a CSV file containing your products. There are also settings you can use to include/exclude certain product details, categories, and vary the export otherwise. [You can refer to WooCommerce's own documentation on those](https://woo.com/document/product-csv-importer-exporter/#export) if you wish to use them.

![](https://raw.githubusercontent.com/WordPress/move-to-wp/HEAD/assets/woo-csv-export.webp)

**NOTE:** It is *also* possible to manually create a CSV file, or edit a CSV export from *another* platform to make it fit the data schema WooCommerce expects. You can [download a sample of Product data in the schema](https://github.com/woocommerce/woocommerce/tree/trunk/plugins/woocommerce/sample-data, or find out more in the documentation about the [Product Data CSV Schema](https://github.com/woocommerce/woocommerce/wiki/Product-CSV-Import-Schema#csv-columns-and-formatting).

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

# Add or Import Custom Data

If you have another WordPress site with WooCommerce products that you would like to migrate, it is definitely something you can do. In your current installation, your products may have custom fields and you want to migrate this data to your new WooCommerce and WordPress installation. You can choose to add those fields so that they are recognizable and saved by the WooCommerce Product CSV Importer and Exporter. Below is a example for developers to add columns to the WooCommerce importer.

This guide will walk you through using the importer and exporter and will also detail how to add custom import and export columns for developers.

# Adding Custom Import Columns (for Developers)

It is a straightforward process to add support for custom columns to the importer. The following example breaks down the process:

```php
/**
 * Register the 'Custom Column' column in the importer.
 *
 * @param array $options
 * @return array $options
 */
function add_column_to_importer( $options ) {

	// column slug => column name
	$options['custom_column'] = 'Custom Column';

	return $options;
}
add_filter( 'woocommerce_csv_product_import_mapping_options', 'add_column_to_importer' );

/**
 * Add automatic mapping support for 'Custom Column'. 
 * This will automatically select the correct mapping for columns named 'Custom Column' or 'custom column'.
 *
 * @param array $columns
 * @return array $columns
 */
function add_column_to_mapping_screen( $columns ) {
	
	// potential column name => column slug
	$columns['Custom Column'] = 'custom_column';
	$columns['custom column'] = 'custom_column';

	return $columns;
}
add_filter( 'woocommerce_csv_product_import_mapping_default_columns', 'add_column_to_mapping_screen' );

/**
 * Process the data read from the CSV file.
 * This just saves the value in meta data, but you can do anything you want here with the data.
 *
 * @param WC_Product $object - Product being imported or updated.
 * @param array $data - CSV data read for the product.
 * @return WC_Product $object
 */
function process_import( $object, $data ) {
	
	if ( ! empty( $data['custom_column'] ) ) {
		$object->update_meta_data( 'custom_column', $data['custom_column'] );
	}

	return $object;
}
add_filter( 'woocommerce_product_import_pre_insert_product_object', 'process_import', 10, 2 );
```

## Adding Custom Export Columns (for Developers)

It is a straightforward process to add support for custom columns to the exporter. The following example breaks down the process:

```php
/**
 * Add the custom column to the exporter and the exporter column menu.
 *
 * @param array $columns
 * @return array $columns
 */
function add_export_column( $columns ) {

	// column slug => column name
	$columns['custom_column'] = 'Custom Column';

	return $columns;
}
add_filter( 'woocommerce_product_export_column_names', 'add_export_column' );
add_filter( 'woocommerce_product_export_product_default_columns', 'add_export_column' );

/**
 * Provide the data to be exported for one item in the column.
 *
 * @param mixed $value (default: '')
 * @param WC_Product $product
 * @return mixed $value - Should be in a format that can be output into a text file (string, numeric, etc).
 */
function add_export_data( $value, $product ) {
	$value = $product->get_meta( 'custom_column', true, 'edit' );
	return $value;
}
// Filter you want to hook into will be: 'woocommerce_product_export_product_column_{$column_slug}'.
add_filter( 'woocommerce_product_export_product_column_custom_column', 'add_export_data', 10, 2 );
```


# ¿You have problems or questions about the Product CSV Importer & Exporter?

You can see the official documentation in the following github repository: https://github.com/woocommerce/woocommerce/wiki/Product-CSV-Importer-&-Exporter

