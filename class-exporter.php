<?php

namespace Nicomv\Medik_Product_Importer;

/**
 * The class in charge of exporting the columns and meta
 * data.
 */
final class Exporter {
    /**
     * Add the custom column to the exporter and the exporter column menu.
     *
     * @param array $columns
     * @return array $columns
     */
    function add_export_column( $columns ) {
        // column slug => column name
        $columns[NMV_MEDIKPE_METANAME] = 'Medik Meta';
        return $columns;
    }

    /**
     * Provide the data to be exported for one item in the column.
     *
     * @param mixed $value (default: '')
     * @param WC_Product $product
     * @return mixed $value - Should be in a format that can be output into a text file (string, numeric, etc).
     */
    function add_export_data( $value, $product ) {
        // Here we retrieve the actual meta data, with the meta name.
        $value = $product->get_meta( '_custom_settings', true, 'edit' );
        
        if ( ! empty( $value ) ) {
            return serialize( $value );
        }
        return null;
    }
}