<?php

/**
 * Definisce la tassonomia Tipi di Documento
 */
add_action('init', 'dci_register_taxonomy_tipi_documento', -10);
function dci_register_taxonomy_tipi_documento()
{

    $labels = array(
        'name'              => _x('Tipi di Documento', 'taxonomy general name', 'design_comuni_italia'),
        'singular_name'     => _x('Tipo di Documento', 'taxonomy singular name', 'design_comuni_italia'),
        'search_items'      => __('Cerca Tipo di Documento', 'design_comuni_italia'),
        'all_items'         => __('Tutti i Tipi di Documento ', 'design_comuni_italia'),
        'edit_item'         => __('Modifica il Tipo di Documento', 'design_comuni_italia'),
        'update_item'       => __('Aggiorna il Tipo di Documento', 'design_comuni_italia'),
        'add_new_item'      => __('Aggiungi un Tipo di Documento', 'design_comuni_italia'),
        'new_item_name'     => __('Nuovo Tipo di Documento', 'design_comuni_italia'),
        'menu_name'         => __('Tipi di Documento', 'design_comuni_italia'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'public'            => true, //enable to get term archive page
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'has_archive'           => true,    //archive page
        //'rewrite'           => array( 'slug' => 'tipo-documento' ),
        'capabilities'      => array(
            'manage_terms'  => 'manage_tipi_documento',
            'edit_terms'    => 'edit_tipi_documento',
            'delete_terms'  => 'delete_tipi_documento',
            'assign_terms'  => 'assign_tipi_documento'
        )
    );

    register_taxonomy('tipi_documento', array('documento_pubblico'), $args);
}

add_action( 'cmb2_admin_init', 'dci_register_taxonomy_tipi_documento_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function dci_register_taxonomy_tipi_documento_metabox() {
    $prefix = 'dci_term_tipi_documento_';

    /**
     * Metabox to add fields to categories and tags
     */
    $cmb_term = new_cmb2_box( array(
        'id'               => $prefix . 'edit',
        'title'            => __( 'Personalizzazione <b>pagina Tipo documento</b>' , 'design_comuni_italia' ), // Doesn't output for term boxes
        'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
        'taxonomies'       => array( 'tipi_documento' ), // Tells CMB2 which taxonomies should have these fields
        // 'new_term_section' => true, // Will display in the "Add New Category" section
        'context' => 'normal',
        'priority' => 'high',
    ) );

    $cmb_term->add_field( array(
        'id' => $prefix . 'campo_ordinamento',
        'name'        => __( 'Campo ordinamento', 'design_comuni_italia' ),
        'desc' => __( 'Scegli il campo per il quale ordinare i dati presenti nella lista' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => dci_get_campo_ordinamento_radio_options(),
        'default' => '',
    ) );

    $cmb_term->add_field( array(
        'id' => $prefix . 'direzione_ordinamento',
        'name'        => __( 'Direzione ordinamento', 'design_comuni_italia' ),
        'desc' => __( 'Scegli la direzione per la quale ordinare i dati presenti nella lista' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => dci_get_direzione_ordinamento_radio_options(),
        'default' => '',
    ) );

}