<?php

namespace Nicomv\Medik_Product_Importer;

/**
 * Class in charge of executing the function for importing products.
 */
final class Importer {
    /**
     * Register the 'Custom Column' column in the importer.
     *
     * @param array $options
     * @return array $options
     */
    function add_columns( $options ) {
        $options[NMV_MEDIKPE_METANAME] = 'Medik Meta';
        return $options;
    }

    /**
     * Add automatic mapping support for 'Custom Column'. 
     * This will automatically select the correct mapping for columns named 'Custom Column' or 'custom column'.
     *
     * @param array $columns
     * @return array $columns
     */
    function add_columns_to_mapping_screen( $columns ) {
        $columns['Medik Meta'] = NMV_MEDIKPE_METANAME;
        $columns['medik_meta'] = NMV_MEDIKPE_METANAME;
        return $columns;
    }

    /**
     * Process the data read from the CSV file.
     * This just saves the value in meta data, but you can do anything you want here with the data.
     *
     * @param WC_Product $object - Product being imported or updated.
     * @param array $data - CSV data read for the product.
     * @return WC_Product $object
     */
    function process_import( $object, $data ) {
        if ( ! empty( $data['medik_meta'] ) ) {
            $object->update_meta_data( '_custom_settings', unserialize( $data['medik_meta'] ) );
        }

        return $object;
    }
}