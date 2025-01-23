<?php

function dci_register_pagina_vivi_options(){
    $prefix = '';

    /**
     * Opzioni Vivere il Comune
     */
    $args = array(
        'id'           => 'dci_options_vivi',
        'title'        => esc_html__( 'Vivere l\'Ente', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'vivi',
        'tab_title'    => __('Vivere l\'Ente', "design_comuni_italia"),
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'capability'    => 'manage_theme_options',
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }
    $vivi_options = new_cmb2_box( $args );
    $vivi_options->add_field( array(
        'id' => $prefix . 'vivi_options',
        'name'        => __( 'Vivere l\'Ente', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione della pagina Vivere l\'Ente' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );
    $vivi_options->add_field( array(
        'id' => $prefix . 'immagine',
        'name'        => __( 'Immagine', 'design_comuni_italia' ),
        'desc' => __( 'Immagine/ banner (in alto nella pagina)' , 'design_comuni_italia' ),
        'type' => 'file',
        'query_args' => array( 'type' => 'image' ),
    ) );
    $vivi_options->add_field( array(
        'id' => $prefix . 'didascalia',
        'name'        => __( 'Didascalia', 'design_comuni_italia' ),
        //'desc' => __( 'didascalia.' , 'design_comuni_italia' ),
        'type' => 'text',
    ) );

    $vivi_options->add_field( array(
        'id' => $prefix . 'vivi_visualizzazione_eventi',
        'name'        => __( 'Visualizzazione eventi', 'design_comuni_italia' ),
        'desc' => __( 'Scegli se mostrare i prossimi eventi organizzati manualmente o uno dopo l\'altro' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            'in-evidenza' => __( 'In evidenza', 'cmb2' ),
            'in-lista'   => __( 'In lista, uno dopo l\'altro', 'cmb2' ),
        ),
        'default' => 'in-evidenza',
    ) );
    
    $vivi_options->add_field(array(
        'id' => $prefix . 'vivi_numero_eventi',
        'name' => __('Lista eventi', 'design_comuni_italia'),
        'desc' => __('Seleziona il numero di eventi da mostrare.', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'default' => 3,
        'options' => array(
            3 => __(3, 'design_comuni_italia'),
            6 => __(6, 'design_comuni_italia'),
        ),
        'attributes' => array(
			'data-conditional-id'    => $prefix.'vivi_visualizzazione_eventi',
			'data-conditional-value' => "in-lista",
        ),
    ));

    $vivi_options->add_field(array(
        'id' => $prefix . 'vivi_visualizzazione_luoghi',
        'name' => __('Visualizzazione Luoghi', 'design_comuni_italia'),
        'desc' => __('Seleziona il tipo di visualizzazione dei luoghi.', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'options' => array(
            'true' => 'in evidenza',
            'false' => 'personalizzato',
        ),
        'default' => 'true',
    ));

    $vivi_options->add_field(array(
            'name' => __('Luoghi in evidenza', 'design_comuni_italia'),
            'desc' => __('Seleziona i luoghi in evidenza. NB: Selezionane 3 o multipli di 3 per evitare buchi nell\'impaginazione.  ', 'design_comuni_italia'),
            'id' => $prefix . 'luoghi_evidenziati',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array(
                        'luogo'
                    )
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 6, //change the value here to how many posts may be attached.
                'data-conditional-id'    => $prefix.'vivi_visualizzazione_luoghi',
			    'data-conditional-value' => "false",
            )
        )
    );
    
    $vivi_options->add_field(array(
        'name' => __('Gallery', 'design_comuni_italia'),
        'desc' => __('Seleziona le foto da mostrare in fondo alla pagina', 'design_comuni_italia'),
        'id' => $prefix . 'gallery_items',
        'type' => 'file_list',
        'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
    )
);

    $vivi_options->add_field( array(
        'id' => $prefix . 'gallery_title',
        'name' => 'Nome gallery',
        'desc' => 'Scegli il nome della sezione con la galleria.',
        'type' => 'text',
        'default' => 'Le nostre foto'
    ) );
}
