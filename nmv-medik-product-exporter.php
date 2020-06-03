<?php
/**
 * Plugin Name: NMV Medik Product Exporter
 * Description: A simple plugin that hooks into the woocommerce import/export process to
 * include the meta data used by the DesignThemes Medik theme.
 * Author:      NicoMV
 * Author URI:  https://nicomv.com/
 * Plugin URI:  https://github.com/skaparate/nmv-medik-product-exporter
 * License:     GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Version:     1.0.0
 */

use Nicomv\Medik_Product_Importer\Exporter;
use Nicomv\Medik_Product_Importer\Importer;

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Root path to the plugin.
 */
define( 'NMV_MEDIKPE_ROOT', plugins_dir( __FILE__ ) );

/**
 * The column name on the exported data.
 * This is not the title of the column.
 */
define( 'NMV_MEDIKPE_METANAME', 'medik_meta' );

function nmvpe_run() {
    if ( is_admin() ):
        require_once NMV_MEDIKPE_ROOT . '/class-importer.php';
        
        $importer = new Importer();
        add_filter(
            'woocommerce_csv_product_import_mapping_options',
            array( $importer, 'add_columns'
        );
        add_filter(
            'woocommerce_csv_product_import_mapping_default_columns',
            array( $importer, 'add_columns_to_mapping_screen' )
        );
        add_filter(
            'woocommerce_product_import_pre_insert_product_object',
            array( $importer, 'process_import' ),
            10,
            2
        );

        require_once NMV_MEDIKPE_ROOT . '/class-exporter.php';
        $exporter = new Exporter();
        add_filter(
            'woocommerce_product_export_column_names',
            array( $exporter, 'add_export_column' )
        );
        add_filter(
            'woocommerce_product_export_product_default_columns',
            array( $exporter, 'add_export_column' )
        );
        // Filter you want to hook into will be: 'woocommerce_product_export_product_column_{$column_slug}'.
        add_filter(
            'woocommerce_product_export_product_column_' . NMV_MEDIKPE_METANAME,
            array( $exporter, 'add_export_data' ),
            10,
            2
        );
    endif;
}

add_action( 'plugins_loaded', 'nmvpe_run', 0 );