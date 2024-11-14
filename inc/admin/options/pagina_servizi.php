<?php

function dci_register_pagina_servizi_options(){
    $prefix = '';

    /**
     * Opzioni Servizi
     */
    $args = array(
        'id'           => 'dci_options_servizi',
        'title'        => esc_html__( 'Servizi', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'servizi',
        'tab_title'    => __('Servizi', "design_comuni_italia"),
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'capability'    => 'manage_theme_options',
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }
    $servizi_options = new_cmb2_box( $args );
    $servizi_options->add_field( array(
        'id' => $prefix . 'servizi_options',
        'name'        => __( 'Servizi in evidenza', 'design_comuni_italia' ),
        'desc' => __( 'Primi contenuti visualizzati nella pagina Servizi' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );



    $servizi_options->add_field(array(
            'name' => __('Scegli servizi in evidenza', 'design_comuni_italia'),
            'desc' => __('Seleziona i servizi da mostrare nella sezione In Evidenza. NB: Selezionane 3 o multipli di 3 per evitare buchi nell\'impaginazione.  ', 'design_comuni_italia'),
            'id' => $prefix . 'servizi_evidenziati',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array(
                        'servizio'
                    )
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 10, //change the value here to how many posts may be attached.
            )
        )
    );

    $servizi_options->add_field( array(
        'id' => $prefix . 'tit_modalita_visualizzazione',
        'name'        => __( 'Modalità visualizzaizione servizi necessari e inclusi', 'design_comuni_italia' ),
        'desc' => __( 'Cambia tra visualizazione estesa e compatta' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $servizi_options->add_field(array(
        'name' => __('Stile dei servizi necessari', 'design_comuni_italia'),
        'id' => $prefix . 'visual_servizi_necessari',
        'type' => 'radio_inline',
        'default' => 'minimale',
        'options' => array(
            'estesa'    => 'Estesa',
            'icona'     => 'Icona e titolo',
            'titolo'     => 'Titolo',
			'minimale'   => 'Minimale',
        ),
    ));

    $servizi_options->add_field(array(
        'name' => __('Stile dei servizi inclusi', 'design_comuni_italia'),
        'id' => $prefix . 'visual_servizi_inclusi',
        'type' => 'radio_inline',
        'default' => 'minimale',
        'options' => array(
            'estesa'    => 'Estesa',
            'icona'     => 'Icona e titolo',
            'titolo'     => 'Titolo',
			'minimale'   => 'Minimale',
        ),
    ));

    $servizi_options->add_field( array(
        'id' => $prefix . 'tit_banner_secondario',
        'name'        => __( 'Banner secondario', 'design_comuni_italia' ),
        'desc' => __( 'Banner pensato per mostrare ulteriori servizi nella pagina Servizi' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $servizi_options->add_field(array(
        'name' => __('Categorie di servizi da mettere in banner ulteriore', 'design_comuni_italia'),
        'desc' => __('Seleziona le categorie di servizi da mostrare in un banner secondario', 'design_comuni_italia'),
        'id' => $prefix . 'categorie_banner_secondario',
        'type' => 'taxonomy_multicheck_inline',
        'taxonomy' => 'categorie_servizio',  
    ));

    $servizi_options->add_field( array(
        'id' => $prefix . 'titolo_banner_secondario',
        'name' => 'Titolo del banner secondario',
        'type' => 'textarea',
        'default' => 'Servizi inclusi',
    ) );

    $servizi_options->add_field( array(
        'id' => $prefix . 'tit_banner_esplora_categorie',
        'name'        => __( 'Banner esplora categorie', 'design_comuni_italia' ),
        'desc' => __( 'Visualizzazione della lista delle categorie nella pagina Servizi' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $servizi_options->add_field(array(
        'name' => __('Tipo di visualizzazione per il banner di Esplora categorie', ''),
        'id' => $prefix . 'categorie_esplora_tipo',
        'desc' => __('Abilita o disabilita la scelta personalizzata', ''),
        'type' => 'radio_inline',
        'default' => 'tutte',
        'options' => array(
            'tutte' => 'Tutte le categorie in ordine alfabetico',
			'filtro'   => 'Scelta personalizzata',
        ),
    ));
    
    $servizi_options->add_field(array(
        'name' => __('Categorie servizi da riordinare', 'design_comuni_italia'),
        'desc' => __('Scegli quali categorie mostrare nei servizi e in quale ordine. Eliminando tutte le opzioni e poi salvando, la scelta verrà reimpostata.', 'design_comuni_italia'),
        'id' => $prefix . 'categorie_esplora',
        'type' => 'pw_multiselect',
        'taxonomy' => 'categorie_servizio',
        'options' => dci_get_terms_options('categorie_servizio'),
        'attributes' => array(
            'data-conditional-id' => 'categorie_esplora_tipo',
            'data-conditional-value'  => 'filtro',
        ),
    )); 

    $servizi_options->add_field( array(
        'id' => $prefix . 'tit_servizi_esterni',
        'name'        => __( 'Spazio dei servizi esterni', 'design_comuni_italia' ),
        'desc' => __( 'Lista dei servizi esterni nel popup di accesso' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $servizi_options->add_field( array(
        'id' => $prefix . 'login_messaggio',
        'name' => 'Testo da mostrare nell\'area di login per i servizi esterni',
        'type' => 'textarea',
        'default' => 'Da qui puoi accedere ai diversi servizi della casa di riposo che richiedono una autenticazione personale.',
    ) );


    $serv_esterni_group_id = $servizi_options->add_field( array(
        'id'           => $prefix . 'link_esterni',
        'type'        => 'group',
        'name'        => 'Link servizi esterni',
        'desc' => __( 'Definisci tutti i servizi esterni che vuoi mostrare agli utenti in fase di login.' , 'design_comuni_italia' ),
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => __( 'Link {#}', 'design_comuni_italia' ),
            'add_button'    => __( 'Aggiungi un elemento', 'design_comuni_italia' ),
            'remove_button' => __( 'Rimuovi l\'elemento ', 'design_comuni_italia' ),
            'sortable'      => true,  // Allow changing the order of repeated groups.
        ),
    ) );

    $servizi_options->add_group_field( $serv_esterni_group_id, array(
        'id' => $prefix . 'nome_link',
        'name'        => __( 'Nome Servizio', 'design_comuni_italia' ),
        'type' => 'text',
    ) );

    $servizi_options->add_group_field( $serv_esterni_group_id, array(
        'id' => $prefix . 'url_link',
        'name'        => __( 'Link Servizio', 'design_comuni_italia' ),
        'type' => 'text_url',
    ) );

    $servizi_options->add_field( array(
        'id' => $prefix . 'tit_banner_altre',
        'name'        => __( 'Altre opzioni', 'design_comuni_italia' ),
        'desc' => __( 'Impostazioni legate al funzionamento dei servizi' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $servizi_options->add_field(array(
        'id' => $prefix . 'prenota_appuntamento',
        'name' => __('Mostra pulsanti per la prenotazione degli appuntamenti', 'design_comuni_italia'),
        'desc' => __('Se abilitata, vengono mostrati i collegamenti per il modulo di prenotazione degli appuntamenti (richiede collegamento informatico al servizio utilizzato dall\'ente)', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'default' => '',
        'options' => array(
            'true' => __('Si', 'design_comuni_italia'),
            '' => __('No', 'design_comuni_italia'),
        ),
        'attributes' => array(
            'data-conditional-value' => "false",
        ),
    ));

    $servizi_options->add_field(array(
        'id' => $prefix . 'richiedi_assistenza',
        'name' => __('Mostra pulsanti per la richiesta di assistenza', 'design_comuni_italia'),
        'desc' => __('Se abilitata, vengono mostrati i collegamenti per il modulo di richiesta assistenza (richiede collegamento informatico al servizio utilizzato dall\'ente)', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'default' => '',
        'options' => array(
            'true' => __('Si', 'design_comuni_italia'),
            '' => __('No', 'design_comuni_italia'),
        ),
        'attributes' => array(
            'data-conditional-value' => "false",
        ),
    ));


    
}