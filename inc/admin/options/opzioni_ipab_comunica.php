<?php

function dci_register_ipab_comunica_options(){
    $prefix = '';

    /**
     * Opzioni Home
     */
    $args = array(
        'id'           => 'dci_options_ipab_comunica',
        'title'        => esc_html('IPAB comunica'),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'comunica',
        'capability'    => 'manage_theme_options',
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'tab_title'    => __('IPAB comunica', "design_comuni_italia"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $comunica_options = new_cmb2_box( $args );

    $comunica_options->add_field( array(
        'id' => $prefix . 'comunica_sections_title',
        'name'        => 'Sezione evidenza', 'design_comuni_italia',
        'desc' => 'Configurazione delle sezioni della pagina IPAB comunica',
        'type' => 'title',
    ));
    
    $comunica_options->add_field( array(
		'name'        => 'Schede in evidenza', 'design_comuni_italia',
		'desc' => 'Definisci il contenuto delle Schede in evidenza',
        'id' => $prefix . 'schede_evidenziate',
        'type'    => 'custom_attached_posts',
        'column'  => true, //
        'options' => array(
            'show_thumbnails' => false,
            'filter_boxes'    => true,
            'query_args'      => array(
                'posts_per_page' => -1,
                'post_type'      => array('evento','notizia'),
            ),
        ),
        'attributes' => array(
            'data-max-items' => 6,
        ),
    ));

    $comunica_options->add_field( array(
        'id' => $prefix . 'comunica_sections_notizia',
        'name'        => 'Sezione Notizie', 'design_comuni_italia',
        'desc' => 'Configurazione della sezione <b>Notizia</b> della pagina IPAB comunica',
        'type' => 'title',
    ));

    $comunica_options->add_field( array(
        'id' => $prefix . 'visualizzazione_notizie',
        'name'        =>'Visualizzazione notizie',
        'desc' => 'Scegli se mostrare le notizie nel modo classico (notizia grande in evidenza + card notizie appena sotto) oppure un carousel (presentazione di slide) con la notizia in evidenza e successivamente le ultime notizie' ,
        'type'    => 'radio_inline',
        'options' => array(
            ''          => 'Classica',
            'carousel'  => 'Carousel',
        ),
        'default' => '',
    ) );

    $comunica_options->add_field( array(
        'name' => 'Notizia in evidenza',
        'desc' => 'Seleziona una notizia da mostrare in homepage',
        'id' => $prefix . 'notizia_evidenziata',
        'type'    => 'custom_attached_posts',
        'column'  => true, 
        'options' => array(
            'show_thumbnails' => false, 
            'filter_boxes'    => true, 
            'query_args'      => array(
                'posts_per_page' => -1,
                'post_type'      => array('notizia'),
            ), 
        ),
        'attributes' => array(
            'data-max-items' => 1, 
        ),
    ));

    $comunica_options->add_field(array(
        'id' => $prefix . 'notizie_in_comunica',
        'name' => 'Numero notizie',
        'desc' => 'Seleziona il numero di notizie da mostrare nella pagina.',
        'type' => 'radio_inline',
        'default' => 0,
        'options' => array(
            0 => 0,
            3 => 3,
            6 => 6,
        ),
        'attributes' => array(
            'data-conditional-value' => "false",
        ),
    ));


    $comunica_options->add_field( array(
        'id' => $prefix . 'giorni_per_filtro',
        'name' => 'Giorni da considerare come filtro novit&agrave',
        'desc' => '<br>Se compilato con un numero di giorni maggiore di 0, verranno mostrate solo le notizie pubblicate da meno di X giorni dalla data odierna',
        'type' => 'text_small',
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
            'min' => 0,
        ),
    ));

    $comunica_options->add_field( array(
        'id' => $prefix . 'comunica_sections_Eventi',
        'name'        => 'Sezione eventi', 'design_comuni_italia',
        'desc' => 'Configurazione della sezione <b>Eventi</b> della pagina IPAB comunica',
        'type' => 'title',
    ));
    $comunica_options->add_field( array(
        'id' => $prefix . 'visualizzazione_eventi',
        'name'        => 'Visualizzazione eventi',
        'desc' => 'Scegli se mostrare i prossimi eventi organizzati per giorni o uno dopo l\'altro',
        'type'    => 'radio_inline',
        'options' => array(
            '' => 'Per giorni',
            'in-lista'   =>'In lista, uno dopo l\'altro',
        ),
        'default' => '',
    ));
    
    $comunica_options->add_field(array(
        'id' => $prefix . 'quanti_eventi_mostrare',
        'name' => 'Lista eventi nella pagina',
        'desc' => 'Seleziona il numero di eventi da mostrare in homepage.',
        'type' => 'radio_inline',
        'default' => 3,
        'options' => array(
            3 => 3,
            6 => 6,
        ),
        'attributes' => array(
			'data-conditional-id'    => $prefix.'visualizzazione_eventi',
			'data-conditional-value' => "in-lista",
        ),
    ));

}
