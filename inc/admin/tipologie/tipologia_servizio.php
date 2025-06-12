<?php
/**
 * Definisce post type Servizio
 */
add_action( 'init', 'dci_register_post_type_servizio' );
function dci_register_post_type_servizio() {

	/** servizio **/
	$labels = array(
		'name'                  => _x( 'Servizi', 'Post Type General Name', 'design_comuni_italia' ),
		'singular_name'         => _x( 'Servizio', 'Post Type Singular Name', 'design_comuni_italia' ),
		'add_new'               => _x( 'Aggiungi un Servizio', 'Post Type Singular Name', 'design_comuni_italia' ),
		'add_new_item'          => _x( 'Aggiungi un Servizio', 'Post Type Singular Name', 'design_comuni_italia' ),
		'edit_item'             => _x( 'Modifica il Servizio', 'Post Type Singular Name', 'design_comuni_italia' ),
		'view_item'             => _x( 'Visualizza il Servizio', 'Post Type Singular Name', 'design_comuni_italia' ),
	);

	$args = array(
		'label'            => __( 'Servizio', 'design_comuni_italia' ),
		'labels'           => $labels,
		'supports'         => array( 'title', 'editor', 'thumbnail' ),
//		'taxonomies'       => array( 'tipologia' ),
		'hierarchical'     => false,
		'public'           => true,
        'menu_position'    => 5,
        'menu_icon'        => 'dashicons-id-alt',
		'has_archive'      => false,
        'capability_type'  => array('servizio', 'servizi'),
        'map_meta_cap'     => true,
        'description'      => __( "I servizi che l'Ente mette a disposizione del cittadino.", 'design_comuni_italia' ),
        //'rewrite' => array('slug' => 'servizi'),
        'show_in_rest'       => true,
        'rest_base'          => 'servizi',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
	);

	register_post_type( 'servizio', $args );
    remove_post_type_support( 'servizio', 'editor');
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'sdi_servizio_add_content_after_title' );
function sdi_servizio_add_content_after_title($post) {
    if($post->post_type == "servizio")
        _e('<span><i>il <b>Titolo</b> è il <b>Nome del Servizio</b>. Il nome del Servizio deve essere facilmente comprensibile dai cittadini. Vincoli: massimo 160 caratteri spazi inclusi.</i></span><br><br>', 'design_comuni_italia' );
}

/**
 * Crea i metabox del post type servizi
 */
add_action( 'cmb2_init', 'dci_add_servizi_metaboxes' );
function dci_add_servizi_metaboxes() {

	$prefix = '_dci_servizio_';

	//STATO DEL SERVIZIO
	$cmb_stato = new_cmb2_box( array(
		'id'           => $prefix . 'box_stato',
		'title'        => __( 'Stato del Servizio *', 'design_comuni_italia' ),
		'object_types' => array( 'servizio' ),
		'context'      => 'side',
		'priority'     => 'high',
	) );

	$cmb_stato->add_field( array(
		'id'        => $prefix . 'stato',
		'desc'      => __( 'Lo stato del servizio indica l\'effettiva fruibilità del Servizio', 'design_comuni_italia' ),
		'type'      => 'radio_inline',
		'default'   => 'true',
		'options'   => array(
			"true"  => __( 'Attivo', 'design_comuni_italia' ),
			"false" => __( 'Disattivo', 'design_comuni_italia' ),
		),
	) );

	$cmb_stato->add_field(array(
		'id'         => $prefix . 'motivo_stato',
		'name'       => __( 'Motivo dello stato *', 'design_comuni_italia' ),
		'desc'       => __( 'Descrizione testuale del motivo per cui un servizio non è attivo. Es. Servizio momentaneamente disattivato perché....Servizio attivo dal...', 'design_comuni_italia' ),
		'type'       => 'textarea_small',
		'attributes' => array(
			'data-conditional-id'    => $prefix.'stato',
			'data-conditional-value' => "false",
		),
	) );

	//APERTURA
   	$cmb_apertura = new_cmb2_box( array(
		'id'           => $prefix . 'box_apertura',
		'title'        => __( 'Apertura', 'design_comuni_italia' ),
		'object_types' => array( 'servizio' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );

    $cmb_apertura->add_field( array(
        'id'             => $prefix . 'categorie',
        'name'           => __( 'Categorie del Servizio *', 'design_comuni_italia' ),
        'type'           => 'taxonomy_multicheck_inline',
        'taxonomy'       => 'categorie_servizio',
        'remove_default' => 'true',
    ) );

    $cmb_apertura->add_field( array(
        'id'         => $prefix . 'sottotitolo',
        'name'       => __( 'Sottotitolo', 'design_comuni_italia' ),
        'desc'       => __( 'Indica un sottotitolo che può avere il Servizio, oppure un nome che identifica informalmente il Servizio.' , 'design_comuni_italia' ),
        'type'       => 'text',
        'attributes' => array(
            'maxlength'  => '255',
        ),
    ) );

	$cmb_apertura->add_field( array(
		'id'         => $prefix . 'descrizione_breve',
		'name'       => __( 'Descrizione breve *', 'design_comuni_italia' ),
		'desc'       => __( 'Indicare una sintetica descrizione del Servizio utilizzando un linguaggio semplice che possa aiutare qualsiasi utente a identificare con chiarezza il Servizio. Non utilizzare un linguaggio ricco di riferimenti normativi. Vincoli: 160 caratteri spazi inclusi.' , 'design_comuni_italia' ),
		'type'       => 'textarea',
		'attributes' => array(
			'maxlength' => '160',
			'required'  => 'required'
		),
	) );

    //COS'È 
    $cmb_cosa = new_cmb2_box( array(
        'id'           => $prefix . 'box_cosa',
        'title'        => __( 'Cos\'è', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_cosa->add_field( array(
        'id' => $prefix . 'descrizione_estesa',
        'name'        => __( 'Descrizione estesa', 'design_comuni_italia' ),
        'desc' => __( 'Descrizione estesa e completa del servizio.' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options'    => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    $cmb_cosa->add_field( array(
        'id' => $prefix . 'servizi_inclusi',
        'name'    => __( 'Servizi inclusi ', 'design_comuni_italia' ),
        'desc' => __( 'Servizi che vengono forniti assieme a questo servizio' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('servizio'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i servizi inclusi con questo servizio', 'design_comuni_italia' ),
        )
    ) );

    $cmb_cosa->add_field( array(
        'id'      => $prefix . 'copertura_geografica',
        'name'    => __( 'Copertura geografica', 'design_comuni_italia' ),
        'desc'    => __( 'Eventuale area geografica a cui il servizio si riferisce. Ad esempio "le zone coperte da ZTL"' , 'design_comuni_italia' ),
        'type'    => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //A CHI SI RIVOLGE
    $cmb_destinatari = new_cmb2_box( array(
        'id'           => $prefix . 'box_destinatari',
        'title'        => __( 'A chi è rivolto', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_destinatari->add_field( array(
        'id' => $prefix . 'servizi_richiesti',
        'name'    => __( 'Servizi richiesti ', 'design_comuni_italia' ),
        'desc' => __( 'Servizi richiesti per accedere al servizio' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('servizio'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i servizi necessari per usufruire di tale servizio', 'design_comuni_italia' ),
        )
    ) );

    $cmb_destinatari->add_field( array(
        'id'         => $prefix . 'a_chi_e_rivolto',
        'name'       => __( 'A chi è rivolto', 'design_comuni_italia' ),
        'desc'       => __( 'Descrizione testuale dei principali destinatari dell\'Evento</br>Questo campo &egrave; obbligatorio <b>SOLO se non si inseriscono serivizi richiesti</b>' , 'design_comuni_italia' ),
        'type'       => 'wysiwyg',
        'options'    => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //COME FARE
    $cmb_come_fare= new_cmb2_box( array(
        'id'           => $prefix . 'box_come_fare',
        'title'        => __( 'Come fare', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_come_fare->add_field( array(
        'id'      => $prefix . 'come_fare',
        'name'    => __( 'Come fare *', 'design_comuni_italia' ),
        'desc'    => __( 'Procedura da seguire per usufruire del Servizio.<br>Il campo è obbligatorio se il servizio è primario (ovvero non ha servizi richiesti).' , 'design_comuni_italia' ),
        'type'    => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //COSA SERVE
    $cmb_cosa_serve= new_cmb2_box( array(
        'id'           => $prefix . 'box_cosa_serve',
        'title'        => __( 'Cosa serve', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_in_rest' => WP_REST_Server::READABLE
    ) );

    $cmb_cosa_serve->add_field( array(
        'id'         => $prefix . 'cosa_serve_introduzione',
        'name'       => __( 'Cosa Serve (testo introduttivo) * ', 'design_comuni_italia' ),
        'desc'       => __( 'es: "Per attivare il servizio bisogna prima compilare il modulo on line oppure stampare e compilare il modulo cartaceo che trovi nella sezione documenti di questa pagina. [Vai alla sezione documenti]" Per creare un link mediante ancora inserisci #art-par-documenti come valore del link.<br>Il campo è obbligatorio se il servizio è primario (ovvero non ha servizi richiesti).', 'design_comuni_italia' ),
        'type'       => 'wysiwyg',
        'options'    => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    $cmb_cosa_serve->add_field( array(
        'id'         => $prefix . 'cosa_serve_list',
        'name'       => __( 'Cosa Serve (lista)', 'design_comuni_italia' ),
        'desc'       => __( 'la lista di cosa serve' , 'design_comuni_italia' ),
        'type'       => 'textarea',
        'repeatable' => true
    ) );

    //COSA SI OTTIENE
    $cmb_cosa_ottieni= new_cmb2_box( array(
        'id'           => $prefix . 'box_cosa_ottieni',
        'title'        => __( 'Cosa si ottene', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_cosa_ottieni->add_field( array(
        'id'    => $prefix . 'output',
        'name'  => __( 'Output/Cosa si ottiene', 'design_comuni_italia' ),
        'desc'  => __( 'Indicare uno o più output prodotti dal servizio. Ad es.: "certificato di residenza", o "carta d\'identità elettronica"...' , 'design_comuni_italia' ),
        'type'  => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    $cmb_cosa_ottieni->add_field( array(
        'id' => $prefix . 'procedure_collegate',
        'name'        => __( 'Procedure collegate all\'esito', 'design_comuni_italia' ),
        'desc' => __( 'Questo campo indica cosa fare per conoscere \'esito della procedura, e dove eventualmente ritirare l\'esito (sede dell\'ufficio, orari, numero sportelloetc, .)' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //TEMPI E SCADENZE
    $cmb_tempi = new_cmb2_box( array(
        'id'           => $prefix . 'box_tempi',
        'title'        => __( 'Tempi e scadenze *', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_tempi->add_field( array(
        'id' => $prefix . 'tempi_text',
        'type' => 'wysiwyg',
        'desc' => 'Il campo è obbligatorio se il servizio è primario (ovvero non ha servizi richiesti).',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 4, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    /**  repeater fasi_scadenze **/
    $group_field_id = $cmb_tempi->add_field( array(
        'id'          => $prefix . 'scadenze',
        //'name'        => __('Fasi' , 'design_scuole_italia' ),
        'type'        => 'group',
        'description' => __( 'Aggiungi le fasi specifiche per questo servizio (è possibile specificare il numero di giorni)', 'design_scuole_italia' ),
        'options'     => array(
            'group_title'    => __( 'Fase {#}', 'design_scuole_italia' ), // {#} gets replaced by row number
            'add_button'     => __( 'Aggiungi fase', 'design_scuole_italia' ),
            'remove_button'  => __( 'Rimuovi', 'design_scuole_italia' ),
            'sortable'       => true,
            'closed'      => true
        ),
    ) );
    $cmb_tempi->add_group_field( $group_field_id,  array(
        'id'      => 'titolo',
        'name'    => __( 'Titolo della fase *', 'design_comuni_italia' ),
        'type' => 'text',
    ) );
    $cmb_tempi->add_group_field( $group_field_id,  array(
        'id'      => 'giorni',
        'name'    => __( 'Giorni', 'design_comuni_italia' ),
        //'desc'    => __( 'giorni', 'design_scuole_italia' ),
        'type' => 'text_small',
        'attributes' => array(
            'type' => 'number',
        ),
    ) );
    $cmb_tempi->add_group_field( $group_field_id,  array(
        'id'      => 'descrizione',
        'name'    => __( 'Descrizione', 'design_comuni_italia' ),
        //'desc'    => __( 'Descrizione', 'design_scuole_italia' ),
        'type'             => 'textarea',
    ) );
    /*** fine repeater fasi e scadenze **/

    $cmb_tempi->add_field( array(
        'id' => $prefix . 'fasi',
        'name'        => __( 'Fasi esistenti', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona le fasi del Servizio. <br><a href="post-new.php?post_type=fase">Inserisci Fase</a>' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('fase'),
        'attributes' => array(
            //'required' => true,
            'placeholder' => __( 'Seleziona le fasi del Servizio', 'design_comuni_italia')
        )
    ) );

    //ACCEDERE AL SERVIZIO
    $cmb_costi = new_cmb2_box( array(
        'id'           => $prefix . 'box_costi',
        'title'        => __( 'Quanto costa', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_costi->add_field( array(
        'id' => $prefix . 'costi',
        'name'        => __( 'Costi', 'design_comuni_italia' ),
        'desc' => __( 'Condizioni e termini economici per compleare la procedura di richiesta del Servizio. Ad es. "il rinnovo della carta d\'identità ha un costo di euro x."" ' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //ACCEDERE AL SERVIZIO
    $cmb_accesso = new_cmb2_box( array(
        'id'           => $prefix . 'box_accedi_servizio',
        'title'        => __( 'Accedi al Servizio', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_in_rest' => WP_REST_Server::READABLE
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'tipo_canale',
        'name'        => __( 'Tipo di accesso al servizio', 'design_comuni_italia' ),
        'desc' => __( 'Scegli se il servizio viene offerto tramite il digitale o luoghi fisici' , 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            'digitale' => __( 'Canale digitale', 'cmb2' ),
            'fisico'   => __( 'Canale fisico', 'cmb2' ),
        ),
        'default' => 'digitale',
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'canale_digitale_text',
        'name'        => __( 'Introduzione canale digitale', 'design_comuni_italia' ),
        'desc' => __( 'Testo introduttivo al canale digitale' , 'design_comuni_italia' ),
        'type' => 'text',
        'attributes' => array(
			'data-conditional-id'    => $prefix.'tipo_canale',
			'data-conditional-value' => "digitale",
        )
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'canale_digitale_label',
        'name'        => __( 'Canale digitale label', 'design_comuni_italia' ),
        'desc' => __( 'Label del bottone associato al link di accesso al canale digitale' , 'design_comuni_italia' ),
        'type' => 'text',
        'default' => 'Richiedi online',
        'attributes' => array(
			'data-conditional-id'    => $prefix.'tipo_canale',
			'data-conditional-value' => "digitale",
        )
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'canale_digitale_link',
        'name'        => __( 'Canale digitale', 'design_comuni_italia' ),
        'desc' => __( 'Link per avviare la procedura di attivazione o per accedere al servizio. Questo campo mette in relazione "Servizio" con il suo canale digitale. ' , 'design_comuni_italia' ),
        'type' => 'text_url',
        'attributes' => array(
			'data-conditional-id'    => $prefix.'tipo_canale',
			'data-conditional-value' => "digitale",
        )
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'canale_fisico_text',
        'name'        => __( 'Introduzione canale fisico', 'design_comuni_italia' ),
        'desc' => __( 'Label introduttiva ai luoghi (canale fisico)' , 'design_comuni_italia' ),
        'type' => 'text',
        'attributes' => array(
			'data-conditional-id'    => $prefix.'tipo_canale',
			'data-conditional-value' => "fisico",
        )
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'canale_fisico_luoghi',
        'name'        => __( 'Luoghi (canale fisico)', 'design_comuni_italia' ),
        'desc' => __( 'Luoghi in cui viene erogato il servizio ' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('luogo'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i luoghi', 'design_comuni_italia' ),
        ),
        'attributes' => array(
			'data-conditional-id'    => $prefix.'tipo_canale',
			'data-conditional-value' => "fisico",
        )
    ) );


    //CONDIZIONI DI SERVIZIO

    $cmb_condizioni_servizio = new_cmb2_box( array(
        'id'           => $prefix . 'box_condizioni_servizio',
        'title'        => __( 'Condizioni di servizio', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_condizioni_servizio->add_field( array(
            //'name'       => __('Condizioni di servizio *', 'design_comuni_italia' ),
            'desc' => __( 'file contenente i termini e le condizioni del servizio' , 'design_comuni_italia' ),
            'id'             => $prefix . 'condizioni_servizio',
            'type' => 'file',
        )
    );

    $cmb_condizioni_servizio->add_field( array(
        'id' => $prefix . 'casi_particolari',
        'name'        => __( 'Casi particolari', 'design_comuni_italia' ),
        'desc' => __( 'Eventuali casi particolari riferiti all\'ottenimento del Servizio in questione. Ad es. "Le persone con disabilità (legge 104) possono contattare direttamente l\'ufficio e concordare una procedura di rinnovo a domicilio"' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    
    $cmb_condizioni_servizio->add_field( array(
        'id' => $prefix . 'vincoli',
        'name'        => __( 'Vincoli', 'design_comuni_italia' ),
        'desc' => __( 'Specificare anche eventuali vincoli. Ad es. "Non è possibile rinnovare la carta identità x mesi prima della scadenza."' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );
    
    //DOCUMENTI
    $cmb_documenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_documenti',
        'title'        => __( 'Documenti', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );

    $cmb_documenti->add_field( array(
        'id' => $prefix . 'documenti',
        'name'        => __( 'Documenti', 'design_comuni_italia' ),
        'desc' => __( 'Link alle schede documenti correlati.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('documento_pubblico'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Documenti Pubblici', 'design_comuni_italia' ),
        ),
    ) );

    //CONTATTI
    $cmb_contatti = new_cmb2_box( array(
        'id'           => $prefix . 'box_contatti',
        'title'        => __( 'Contatti', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'unita_responsabile',
        'name'    => __( 'Unità Organizzativa responsabile', 'design_comuni_italia' ),
        'desc' => __( 'Ufficio responsabile dell\'erogazione di questo Servizio' , 'design_comuni_italia' ),
        'type'    => 'pw_select',
        'options' => dci_get_posts_options('unita_organizzativa'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona le Unità Organizzative', 'design_comuni_italia' ),
        )
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'incarico_servizi',
        'name'        => 'Persone incaricate',
        'desc' => 'Scegli gli incarichi che erogano questo servizio o sono delegati a fornire informazioni in merito' ,
        'type'    => 'pw_multiselect',
        'options' => dci_get_incarichi_con_nomi(),
        'default_cb' => 'set_to_current_servizi_incarico',
        'attributes' => array(
            'placeholder' =>  'Seleziona gli incarichi',
        ),
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'punti_contatto',
        'name'        => __( 'Contatti dedicati', 'design_comuni_italia' ),
        'desc' => __( 'Telefono, email o altri punti di contatto che sono specifici di questo servizio, diversi da quello dell\'ufficio o persone indicate sopra<br><a href="post-new.php?post_type=punto_contatto">Inserisci Punto di Contatto</a>' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('punto_contatto'),
        'attributes'    => array(
            'placeholder' =>  __( 'Seleziona i Punti di Contatto', 'design_comuni_italia' ),
        ),
    ) );


    //ULTERIORI INFORMAZIONI
    $cmb_informazioni = new_cmb2_box( array(
        'id'           => $prefix . 'box_informazioni',
        'title'        => __( 'Informazioni', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_informazioni->add_field( array(
        'id'         => $prefix . 'ulteriori_informazioni',
        'name'       => __( 'Ulteriori informazioni', 'design_comuni_italia' ),
        'desc'       => __( 'Eventuali link a pagine web, siti, servizi esterni all\'ambito comunale utili all\'erogazione del servizio descritto. Ad esempio nella pagina servizio "Carta di IdTipologia Elettronica", potrebbe essere utile inserire in questo campo un link al Ministero dell\'Interno', 'design_comuni_italia' ),
        'type'       => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //argomenti
    $cmb_argomenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_argomenti',
        'title'        => __( 'Argomenti *', 'design_comuni_italia' ),
        'object_types' => array( 'servizio' ),
        'context'      => 'side',
        'priority'     => 'high',
    ) );
    $cmb_argomenti->add_field( array(
        'id' => $prefix . 'argomenti',
        'type'             => 'taxonomy_multicheck_hierarchical',
        'taxonomy'       => 'argomenti',
        'show_option_none' => false,
        'remove_default' => 'true',
    ) );

    //CODICE ENTE
	$cmb_ipa = new_cmb2_box( array(
		'id'           => $prefix . 'box_ipa',
		'title'        => __( 'Codice dell’Ente Erogatore (ipa)', 'design_comuni_italia' ),
		'object_types' => array( 'servizio' ),
		'context'      => 'side',
		'priority'     => 'high',
	) );

	$cmb_ipa->add_field( array(
		'id' => $prefix . 'codice_ente_erogatore',
		'desc' => __( 'Specificare il nome dell’organizzazione, come indicato nell’Indice della Pubblica Amministrazione (IPA), che esercita uno specifico ruolo sul Servizio.', 'design_comuni_italia' ),
		'type' => 'text',
        'attributes'    => array(
            'maxlength'  => '255',
        ),
	) );


    //STATO DEL SERVIZIO
	$cmb_stato = new_cmb2_box( array(
		'id'           => $prefix . 'box_stato',
		'title'        => __( 'Stato del Servizio *', 'design_comuni_italia' ),
		'object_types' => array( 'servizio' ),
		'context'      => 'side',
		'priority'     => 'high',
	) );

	$cmb_stato->add_field( array(
		'id'        => $prefix . 'stato',
		'desc'      => __( 'Lo stato del servizio indica l\'effettiva fruibilità del Servizio', 'design_comuni_italia' ),
		'type'      => 'radio_inline',
		'default'   => 'true',
		'options'   => array(
			"true"  => __( 'Attivo', 'design_comuni_italia' ),
			"false" => __( 'Disattivo', 'design_comuni_italia' ),
		),
	) );

    //ICONA
	$cmb_stato = new_cmb2_box( array(
		'id'           => $prefix . 'box_icona',
		'title'        => __( 'Icona', 'design_comuni_italia' ),
		'object_types' => array( 'servizio' ),
		'context'      => 'side',
		'priority'     => 'low',
	) );

	$cmb_stato->add_field( array(
		'id'        => $prefix . 'classi_icona',
		'desc'      => __( 'Classe icona', 'design_comuni_italia' ),
		'type'      => 'text',

        'attributes'=>[
            'placeholder' => 'fa-solid fa-shield-halved'
        ]
	) );
}

/**
 * aggiungo js per controllo compilazione campi
 */

add_action( 'admin_print_scripts-post-new.php', 'dci_servizio_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'dci_servizio_admin_script', 11 );

function dci_servizio_admin_script() {
    global $post_type;
    if( 'servizio' == $post_type )
        wp_enqueue_script( 'servizio-admin-script', get_template_directory_uri() . '/inc/admin-js/servizio.js' );
}

/**
 * Valorizzo il post content in base al contenuto dei campi custom
 * @param $data
 * @return mixed
 */
function dci_servizio_set_post_content( $data ) {

    if($data['post_type'] == 'servizio') {

        $descrizione_breve = '';
        if (isset($_POST['_dci_servizio_descrizione_breve'])) {
            $descrizione_breve = $_POST['_dci_servizio_descrizione_breve'];
        }

        $descrizione_estesa = '';
        if (isset($_POST['_dci_servizio_descrizione_estesa'])) {
            $descrizione_estesa = $_POST['_dci_servizio_descrizione_estesa'];
        }

        $info = '';
        if (isset($_POST['_dci_servizio_ulteriori_informazioni'])) {
            $info = $_POST['_dci_servizio_ulteriori_informazioni'];
        }

        $cosa_serve_introduzione = '';
        if (isset($_POST['_dci_servizio_cosa_serve_introduzione'])) {
            $cosa_serve_introduzione = $_POST['_dci_servizio_cosa_serve_introduzione'];
        }

        $come_fare = '';
        if (isset($_POST['_dci_servizio_box_come_fare'])) {
            $come_fare = $_POST['_dci_servizio_box_come_fare'];
        }

        $cosa_ottieni = '';
        if (isset($_POST['_dci_servizio_box_cosa_ottieni'])) {
            $cosa_ottieni = $_POST['_dci_servizio_box_cosa_ottieni'];
        }

        $desinatari = '';
        if (isset($_POST['_dci_servizio_box_destinatari'])) {
            $desinatari = $_POST['_dci_servizio_box_destinatari'];
        }

        $procedure = '';
        if (isset($_POST['_dci_servizio_procedure_collegate'])) {
            $procedure = $_POST['_dci_servizio_procedure_collegate'];
        }

        $tempi = '';
        if (isset($_POST['_dci_servizio_box_tempi'])) {
            $tempi = $_POST['_dci_servizio_box_tempi'];
        }

        $costi = '';
        if (isset($_POST['_dci_servizio_costi'])) {
            $costi = $_POST['_dci_servizio_costi'];
        }

        $casi_particolari = '';
        if (isset($_POST['_dci_servizio_casi_particolari'])) {
            $casi_particolari = $_POST['_dci_servizio_casi_particolari'];
        }

        $vincoli = '';
        if (isset($_POST['_dci_servizio_vincoli'])) {
            $vincoli = $_POST['_dci_servizio_vincoli'];
        }

        $content = $descrizione_breve
            .'<br>'.$descrizione_estesa
            .'<br>'.$info
            .'<br>'.$cosa_serve_introduzione
            .'<br>'.$cosa_ottieni
            .'<br>'.$desinatari
            .'<br>'.$procedure
            .'<br>'.$tempi
            .'<br>'.$costi
            .'<br>'.$casi_particolari
            .'<br>'.$vincoli
            .'<br>'.$come_fare;



        $data['post_content'] = $content;
    }

    return $data;
}
add_filter( 'wp_insert_post_data' , 'dci_servizio_set_post_content' , '99', 1 );

new dci_bidirectional_cmb2("_dci_servizio_", "servizio", "unita_responsabile", "box_contatti", "_dci_unita_organizzativa_elenco_servizi_offerti");

new dci_bidirectional_cmb2("_dci_servizio_", "servizio", "documenti", "box_documenti", "_dci_documento_pubblico_servizi");

new dci_bidirectional_cmb2("_dci_servizio_", "servizio", "servizi_inclusi", "box_destinatari", "_dci_servizio_servizi_richiesti");

new dci_bidirectional_cmb2("_dci_servizio_", "servizio", "servizi_richiesti", "box_destinatari", "_dci_servizio_servizi_inclusi");

new dci_bidirectional_cmb2("_dci_servizio_", "servizio", "canale_fisico_luoghi", "box_accedi_servizio", "_dci_luogo_servizi_erogati");

new dci_bidirectional_cmb2("_dci_servizio_", "servizio", "incarico_servizi", "box_contatti", "_dci_incarico_servizi_incarico");

function set_to_current_servizi_incarico($field_args, $field  ) {
	return dci_get_meta("incarico_servizi", "_dci_incarico_", $field->object_id) ?? [];
}