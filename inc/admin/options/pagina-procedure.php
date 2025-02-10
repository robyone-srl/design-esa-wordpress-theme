<?php

function dci_register_pagina_procedure_options(){
    $prefix = '';

    /**
     * Opzioni Servizi
     */
    $args = array(
        'id'           => 'dci_options_procedure',
        'title'        => esc_html__( 'Procedure', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'procedure',
        'tab_title'    => __('Procedure', "design_comuni_italia"),
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'capability'    => 'manage_theme_options',
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }
    $procedure_options = new_cmb2_box( $args );
    $procedure_options->add_field( array(
        'id' => $prefix . 'procedure_options',
        'name'        => __( 'Procedure in evidenza', 'design_comuni_italia' ),
        'desc' => __( 'Primi contenuti visualizzati nella pagina Procedure' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );



    $procedure_options->add_field(array(
            'name' => __('Scegli le procedure in evidenza', 'design_comuni_italia'),
            'desc' => __('Seleziona le procedure da mostrare nella sezione In Evidenza. NB: Selezionane 3 o multipli di 3 per evitare buchi nell\'impaginazione.  ', 'design_comuni_italia'),
            'id' => $prefix . 'procedure_evidenziate',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array(
                        'procedura'
                    )
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 10, //change the value here to how many posts may be attached.
            )
        )
    );
}