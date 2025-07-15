<?php

function dci_register_pagina_home_options(){
    $prefix = '';

    /**
     * Opzioni Home
     */
    $args = array(
        'id'           => 'dci_options_home',
        'title'        => esc_html__( 'Home Page', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'homepage',
        'capability'    => 'manage_theme_options',
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'tab_title'    => __('Home Page', "design_comuni_italia"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $home_options = new_cmb2_box( $args );

    $home_options->add_field( array(
        'id' => $prefix . 'home_sections_title',
        'name'        => __( 'Sezioni', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione delle sezioni della home' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $home_options->add_field(array(
        'id' => $prefix . 'home_sections',
        'name'        => __( 'Sezioni della home', 'design_comuni_italia' ),
        'desc' => __( 'Scegli quali sezioni mostrare nella home e in quale ordine. Eliminando tutte le opzioni e poi salvando, la scelta verrà reimpostata.' , 'design_comuni_italia' ),
        'type' => 'pw_multiselect',
        'options' => array(
            'hero' => 'Hero Copertina',
            'hero-chi-siamo' => 'Hero Chi siamo',
            'messages' => 'Avvisi di allerta',
            'notizie' => 'Notizie',
            'contenuti-evidenza' => 'Contenuti in evidenza',
            'luoghi-evidenza' => 'Luoghi in evidenza',
            'calendario' => 'Eventi',
            'argomenti' => 'Argomenti in evidenza',
            'servizi-evidenza' => 'Servizi in evidenza',
            'siti-tematici' => 'Siti tematici',
            'domande-frequenti' => 'Domande frequenti in evidenza',
            'galleria-foto' => 'Galleria delle foto',
            'ricerca' => 'Ricerca e ricerche frequenti',
            'valuta-servizio' => 'Valutazione del servizio',
            'assistenza-contatti' => 'Contatti'
        ),
        'default' => dci_get_default_home_sections()
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'hero_section_title',
        'name'        => __( 'Sezione Hero di copertina', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione immagine all\'inizio della home' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $home_options->add_field( array(
        'id'    => $prefix . 'hero_image',
        'name' => __('Immagine di sfondo', 'design_comuni_italia' ),
        'desc' => __( 'L\'immagine che viene visualizzata come "copertina"' , 'design_comuni_italia' ),
        'type' => 'file',
        'query_args' => array(
            'type' => array(
                'image/*',
        ))
    ));

    $home_options->add_field( array(
        'id' => $prefix . 'hero_title',
        'name'        => __( 'Titolo', 'design_comuni_italia' ),
        'type'    => 'text',
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'hero_description',
        'name'        => __( 'Descrizione', 'design_comuni_italia' ),
        'type'    => 'textarea',
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'hero_button_title',
        'name'        => __( 'Contenuto pulsante', 'design_comuni_italia' ),
        'type'    => 'text',
    ) );
    
    $home_options->add_field( array(
        'id' => $prefix . 'hero_button_link',
        'name'        => __( 'URL pulsante', 'design_comuni_italia' ),
        'type'    => 'text',
    ) );
    
    $home_options->add_field( array(
        'id' => $prefix . 'hero_alignment',
        'name'        => __( 'Allineamento', 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            'left' => __( 'Sinistra', 'cmb2' ),
            'center'   => __( 'Centro', 'cmb2' ),
        ),
        'default' => 'left',
    ) );
    

	
	$home_options->add_field( array(
        'id' => $prefix . 'hero_chi_siamo_section_title',
        'name'        => __( 'Sezione Hero Chi siamo', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione banner di presentazione dell\'Ente con link a luoghi e servizi' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $home_options->add_field( array(
        'id'    => $prefix . 'hero_chi_siamo_image',
        'name' => __('Immagine di sfondo', 'design_comuni_italia' ),
        'desc' => __( 'L\'immagine che viene visualizzata come "copertina"' , 'design_comuni_italia' ),
        'type' => 'file',
        'query_args' => array(
            'type' => array(
                'image/*',
        ))
    ));

    $home_options->add_field( array(
        'id' => $prefix . 'hero_chi_siamo_title',
        'name'        => __( 'Titolo', 'design_comuni_italia' ),
        'type'    => 'text',
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'hero_chi_siamo_description',
        'name'        => __( 'Descrizione', 'design_comuni_italia' ),
        'type'    => 'textarea',
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'hero_chi_siamo_button_title',
        'name'        => __( 'Contenuto pulsante', 'design_comuni_italia' ),
        'type'    => 'text',
    ) );
    
    $home_options->add_field( array(
        'id' => $prefix . 'hero_chi_siamo_button_link',
        'name'        => __( 'URL pulsante', 'design_comuni_italia' ),
        'type'    => 'text',
    ) );
    
    $home_options->add_field( array(
        'id' => $prefix . 'hero_chi_siamo_alignment',
        'name'        => __( 'Allineamento', 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            'left' => __( 'Sinistra', 'cmb2' ),
            'center'   => __( 'Centro', 'cmb2' ),
        ),
        'default' => 'left',
    ) );
	
    $home_options->add_field( array(
        'id' => $prefix . 'contenuti_evidenziati_title',
        'name'        => __( 'Sezione Contenuti in Evidenza', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione Contenuti in Evidenza.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    
    
    $home_options->add_field( array(
        'id' => $prefix . 'visualizzazione_notizie',
        'name'        => __( 'Visualizzazione notizie', 'design_comuni_italia' ),
        'desc' => __( 'Scegli se mostrare le notizie nel modo classico (notizia in primo piano grande + card notizie appena sotto) oppure un carousel (presentazione di slide) con la notizia in primo piano e successivamente le ultime notizie' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            '' => __( 'Classica', 'cmb2' ),
            'carousel'   => __( 'Carousel', 'cmb2' ),
        ),
        'default' => '',
    ) );

    $home_options->add_field( array(
            'name' => __('Notizia in primo piano', 'design_comuni_italia'),
            'desc' => __('Seleziona una notizia da mostrare in apertura in pagina iniziale', 'design_comuni_italia'),
            'id' => $prefix . 'notizia_evidenziata',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('notizia'),
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 1, //change the value here to how many posts may be attached.
            ),
        )
    );

    $home_options->add_field(array(
        'id' => $prefix . 'notizie_in_home',
        'name' => __('Numero notizie da mostrare', 'design_comuni_italia'),
        'desc' => __('Seleziona il numero di notizie da mostrare in homepage (automatico, in base a data di pubblicazione decrescente)', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'default' => 0,
        'options' => array(
            0 => __(0, 'design_comuni_italia'),
            3 => __(3, 'design_comuni_italia'),
            6 => __(6, 'design_comuni_italia'),
        ),
        'attributes' => array(
            'data-conditional-value' => "false",
        ),
    ));


    $home_options->add_field( array(
        'id' => $prefix . 'giorni_per_filtro',
        'name' => 'Giorni da considerare come filtro novit&agrave',
        'desc' => '<br>Se compilato con un numero di giorni maggiore di 0, verranno mostrate solo le notizie pubblicate da meno di X giorni dalla data odierna',
        'type' => 'text_small',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
            'min' => 0,
        ),
    ) );

    /*
    $home_options->add_field( array(
		    'name'        => __('Schede in evidenza', 'design_comuni_italia'),
		    'desc' => __( 'Definisci il contenuto delle Schede in evidenza' , 'design_comuni_italia' ),
            'id' => $prefix . 'schede_evidenziate',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia','dataset','page'),
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 6, //change the value here to how many posts may be attached.
            ),
        )
    );
    */
	
	$contents_group_id = $home_options->add_field( array(
        'id'           => $prefix . 'schede_evidenza',
        'type'        => 'group',
        'desc' => __( 'Ogni scheda di contenuto o tassonomia (categoria, tipologia, argomento, ...) viene riportato nello spazio In evidenza nella pagina iniziale' , 'design_comuni_italia' ),
		'before_group'     => '<div class="postbox cmb-row "><h3>Contenuti e voci in evidenza</h3></div>',
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => __( 'Evidenza {#}', 'design_comuni_italia' ),
            'add_button'    => __( 'Aggiungi una scheda', 'design_comuni_italia' ),
            'remove_button' => __( 'Rimuovi la scheda', 'design_comuni_italia' ),
            'sortable'      => true,  // Allow changing the order of repeated groups.
        ),
    ) );
	
    $home_options->add_group_field( $contents_group_id, array(
        'id' => $prefix . 'tipo_evidenza',
        'name'        => __( 'Tipo di evidenza', 'design_comuni_italia' ),
        'desc' => __( 'Scegli se scegliere un contenuto o un termine di tassonomia' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            'content' => __( 'Contenuto', 'cmb2' ),
            'taxonomy_term'   => __( 'Termine tassonomia', 'cmb2' ),
        ),
        'default' => 'content',
    ) );

    $home_options->add_group_field( $contents_group_id, array(
        'id' => $prefix . 'termine_evidenza',
        'name'        => __( 'Termine di tassonomie', 'design_comuni_italia' ),
        'desc' => __( 'Puoi selezionare categorie, tipologie e altre liste da mettere in evidenza' , 'design_comuni_italia' ),
        'type'    => 'pw_select',
        'options' => dci_get_multi_taxonomies_terms_options(array('categorie_servizio', 'tipi_evento', 'tipi_notizia', 'tipi_luogo', 'tipi_unita_organizzativa', 'tipi_incarico', 'argomenti', 'tipi_documento')),
        'attributes' => array(
			'data-conditional-id'    => $prefix.'tipo_evidenza',
			'data-conditional-value' => "taxonomy_term",
        ),
    ) );
	
    $home_options->add_group_field( $contents_group_id, array(
       		'name'        => __('Contenuto', 'design_comuni_italia'),
		    'desc' => __( 'Definisci il contenuto da mettere in evidenza' , 'design_comuni_italia' ),
            'id' => $prefix . 'contenuto_evidenza',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia','dataset','page'),
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 1, //change the value here to how many posts may be attached.
				'data-conditional-id'    => $prefix.'tipo_evidenza',
				'data-conditional-value' => "content",
        	),
    ) );
	
    $home_options->add_group_field( $contents_group_id, array(
        'id' => $prefix . 'expiration',
        'name'        => __( 'Data fine', 'design_comuni_italia' ),
        'type' => 'text_date',
        'date_format' => 'd-m-Y',
        'data-datepicker' => json_encode( array(
            'yearRange' => '-100:+0',
        ) ),
    ) );

	/*
    $home_options->add_field( array(
		    'name'        => __('Schede di contenuti in evidenza', 'design_comuni_italia'),
		    'desc' => __( 'Definisci il contenuto delle Schede in evidenza' , 'design_comuni_italia' ),
            'id' => $prefix . 'schede_evidenziate',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia','dataset','page'),
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-max-items' => 6, //change the value here to how many posts may be attached.
            ),
        )
    );
	*/
    
    $home_options->add_field( array(
        'id' => $prefix . 'eventi_title',
        'name'        => __( 'Sezione Eventi', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione sezione Eventi.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

	
    $home_options->add_field( array(
        'id' => $prefix . 'visualizzazione_eventi',
        'name'        => __( 'Visualizzazione eventi', 'design_comuni_italia' ),
        'desc' => __( 'Scegli se mostrare i prossimi eventi organizzati per giorni o uno dopo l\'altro' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            '' => __( 'Per giorni', 'cmb2' ),
            'in-lista'   => __( 'In lista, uno dopo l\'altro', 'cmb2' ),
        ),
        'default' => '',
    ) );
    
    $home_options->add_field(array(
        'id' => $prefix . 'quanti_eventi_mostrare',
        'name' => __('Lista eventi nella home', 'design_comuni_italia'),
        'desc' => __('Seleziona il numero di eventi da mostrare in homepage.', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'default' => 3,
        'options' => array(
            3 => __(3, 'design_comuni_italia'),
            6 => __(6, 'design_comuni_italia'),
        ),
        'attributes' => array(
			'data-conditional-id'    => $prefix.'visualizzazione_eventi',
			'data-conditional-value' => "in-lista",
        ),
    ));

    //sezione Siti Tematici
    $home_options->add_field( array(
        'id' => $prefix . 'siti_tematici_title',
        'name'        => __( 'Sezione Siti Tematici', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione sezione Siti Tematici.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'siti_tematici',
        'name'        => __( 'Sito Tematico ', 'design_comuni_italia' ),
        'desc' => __( 'Selezionare il sito tematico di cui visualizzare la Card' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('sito_tematico'),
    ) );

    //sezione Domande Frequenti
    $home_options->add_field( array(
        'id' => $prefix . 'domande_frequenti_title',
        'name'        => __( 'Sezione Domande Frequenti', 'design_comuni_italia' ),
        'desc' => __( 'Configurazione sezione Domande Frequenti.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $home_options->add_field( array(
        'id' => $prefix . 'domande_frequenti',
        'name'        => __( 'Domande Frequenti', 'design_comuni_italia' ),
        'desc' => __( 'Selezionare le domande frequenti di cui visualizzare la card' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('domanda_frequente'),
    ) );

    //sezione Argomenti
    $home_options->add_field( array(
        'id' => $prefix . 'argomenti_title',
        'name'        => __( 'Sezione Argomenti', 'design_comuni_italia' ),
        'desc' => __( 'Gestione Argomenti mostrati in homepage.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $argomenti_group_id = $home_options->add_field( array(
        'id'           => $prefix . 'argomenti_evidenziati_1',
        'type'        => 'group',
        'name'        => 'Argomenti in evidenza',
        'desc' => __( 'Definisci il contenuto delle Card degli argomenti' , 'design_comuni_italia' ),
        'repeatable'  => false,
        'options'     => array(
            'group_title'   => __( 'Argomento 1: ', 'design_comuni_italia' ),
            'closed' => true
        ),
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
        'id' => $prefix . 'argomento_1_argomento',
        'name'        => __( 'Argomento', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona l\'Argomento' , 'design_comuni_italia' ),
        'type' => 'taxonomy_select',
        'taxonomy'=>'argomenti'
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
        'id' => $prefix . 'argomento_1_siti',
        'name'        => __( 'Siti Tematici ', 'design_comuni_italia' ),
        'desc' => __( 'Selezionare i siti tematici da inserire nella Card' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('sito_tematico'),
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
            'name' => __('<h5>Selezione contenuti</h5>', 'design_comuni_italia'),
            'desc' => __('Seleziona i contenuti da mostrare nella Card dell\'Argomento. ', 'design_comuni_italia'),
            'id' => $prefix . 'argomento_1_contenuti',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia'),
                ), // override the get_posts args
            )
        )
    );

    $argomenti_group_id = $home_options->add_field( array(
        'id'           => $prefix . 'argomenti_evidenziati_2',
        'type'        => 'group',
        'repeatable'  => false,
        'options'     => array(
            'group_title'   => __( 'Argomento 2: ', 'design_comuni_italia' ),
            'closed' => true
        ),
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
        'id' => $prefix . 'argomento_2_argomento',
        'name'        => __( 'Argomento', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona l\'Argomento' , 'design_comuni_italia' ),
        'type' => 'taxonomy_select',
        'taxonomy'=>'argomenti'
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
        'id' => $prefix . 'argomento_2_siti',
        'name'        => __( 'Siti Tematici ', 'design_comuni_italia' ),
        'desc' => __( 'Selezionare i siti tematici da inserire nella Card' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('sito_tematico'),
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
            'name' => __('<h5>Selezione contenuti</h5>', 'design_comuni_italia'),
            'desc' => __('Seleziona i contenuti da mostrare nella Card dell\'Argomento. ', 'design_comuni_italia'),
            'id' => $prefix . 'argomento_2_contenuti',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia'),
                ), // override the get_posts args
            )
        )
    );

    $argomenti_group_id = $home_options->add_field( array(
        'id'           => $prefix . 'argomenti_evidenziati_3',
        'type'        => 'group',
        'repeatable'  => false,
        'options'     => array(
            'group_title'   => __( 'Argomento 3: ', 'design_comuni_italia' ),
            'closed' => true
        ),
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
        'id' => $prefix . 'argomento_3_argomento',
        'name'        => __( 'Argomento', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona l\'Argomento' , 'design_comuni_italia' ),
        'type' => 'taxonomy_select',
        'taxonomy'=>'argomenti'
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
        'id' => $prefix . 'argomento_3_siti',
        'name'        => __( 'Siti Tematici', 'design_comuni_italia' ),
        'desc' => __( 'Selezionare i siti tematici da inserire nella Card' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('sito_tematico'),
    ) );
    $home_options->add_group_field( $argomenti_group_id, array(
            'name' => __('<h5>Selezione contenuti</h5>', 'design_comuni_italia'),
            'desc' => __('Seleziona i contenuti da mostrare nella Card dell\'Argomento. ', 'design_comuni_italia'),
            'id' => $prefix . 'argomento_3_contenuti',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia'),
                ), // override the get_posts args
            )
        )
    );

    $home_options->add_field( array(
        'id' => $prefix . 'argomenti_altri',
        'name'        => __( 'Altri argomenti', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona altri Argomenti peri quali compariranno link in homepage.' , 'design_comuni_italia' ),
        'type'             => 'pw_multiselect',
        'options' => dci_get_terms_options('argomenti'),
        'show_option_none' => false,
        'remove_default' => 'true',
    ) );
}