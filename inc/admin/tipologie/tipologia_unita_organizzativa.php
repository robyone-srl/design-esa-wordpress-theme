<?php
/**
 * Definisce post type Unità organizzativa
 */
add_action( 'init', 'dci_register_post_type_unita_organizzativa', 60 );
function dci_register_post_type_unita_organizzativa() {
    /** scheda **/
    $labels = array(
        'name'          => _x( 'Unità Organizzative', 'Post Type General Name', 'design_comuni_italia' ),
        'singular_name' => _x( 'Unità Organizzativa', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new'       => _x( 'Aggiungi una Unità Organizzativa', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new_item'  => _x( 'Aggiungi una nuova Unità Organizzativa', 'Post Type Singular Name', 'design_comuni_italia' ),
        'edit_item'       => _x( 'Modifica l\'Unità Organizzativa', 'Post Type Singular Name', 'design_comuni_italia' ),
        'featured_image' => __( 'Immagine di riferimento dell\'Unità Organizzativa', 'design_comuni_italia' ),
    );

    $args   = array(
        'label'         => __( 'Unità organizzativa', 'design_comuni_italia' ),
        'labels'        => $labels,
        'supports'      => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'  => false,
        'public'        => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-admin-multisite',
        'has_archive'   => false,
        'rewrite' => array('slug' => 'amministrazione/unita_organizzativa','with_front' => false),
        'capability_type' => array('unita_organizzativa', 'unita_organizzative'),
        'map_meta_cap'    => true,
        'description'    => __( 'Questa Tipologia descrive la struttura di un\'organizzazione funzionale alla creazione di contenuti come uffici o altre unità organizzative (content type "organizzazione")', 'design_comuni_italia' ),
        'show_in_rest'       => true,
        'rest_base'          => 'unita_organizzative',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );

    register_post_type('unita_organizzativa', $args );

    remove_post_type_support( 'unita_organizzativa', 'editor');
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'dci_unita_organizzativa_add_content_after_title' );
function dci_unita_organizzativa_add_content_after_title($post) {
    if($post->post_type == "unita_organizzativa")
        _e('<span><i>il <b>Titolo</b> è il <b>Nome dell\'Unità Organizzativa *</b>.</i></span><br><br>', 'design_comuni_italia' );
}

/**
 * Crea i metabox del post type Unità organizzativa
 */
add_action( 'cmb2_init', 'dci_add_unita_organizzativa_metaboxes' );
function dci_add_unita_organizzativa_metaboxes() {
    $prefix = '_dci_unita_organizzativa_';

    $cmb_argomenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_argomenti',
        'title'        => __( 'Apertura', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'side',
        'priority'     => 'high',
    ) );

    $cmb_argomenti->add_field( array(
        'id' => $prefix . 'argomenti',
        'name'        => __( 'Argomenti', 'design_comuni_italia' ),
        'desc' => __( 'Argomenti di cui si occupa' , 'design_comuni_italia' ),
        'type'             => 'taxonomy_multicheck_hierarchical',
        'taxonomy'       => 'argomenti',
        'show_option_none' => false,
        'remove_default' => 'true',
    ) );

    //APERTURA
    $cmb_apertura = new_cmb2_box( array(
        'id'           => $prefix . 'box_apertura',
        'title'        => __( 'Apertura', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'descrizione_breve',
        'name'        => __( 'Descrizione breve *', 'design_comuni_italia' ),
        'desc' => __( ' Descrizione sintetica (inferiore ai 255 caratteri) dell\'unità organizzativa' , 'design_comuni_italia' ),
        'type' => 'textarea',
        'attributes'    => array(
            'maxlength'  => '255',
            'required'    => 'required'
        ),
    ) );

    //COSA FA
    $cmb_cosa_fa = new_cmb2_box( array(
        'id'           => $prefix . 'box_cosa_fa',
        'title'        => __( 'Cosa fa', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    $cmb_cosa_fa->add_field( array(
        'id' => $prefix . 'competenze',
        'name'        => __( 'Competenze *', 'design_comuni_italia' ),
        'desc' => __( 'Elenco/descrizione dei compiti assegnati all\'unità organizzativa.' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'attributes'    => array(
            'required'    => 'required'
        ),
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //STRUTTURA
    $cmb_struttura = new_cmb2_box( array(
        'id'           => $prefix . 'box_struttura',
        'title'        => __( 'Struttura', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_struttura->add_field( array(
        'id' => $prefix . 'unita_organizzativa_genitore',
        'name'    => __( 'Unità organizzativa genitore', 'design_comuni_italia' ),
        'desc' => __( 'Se la struttura fa parte di un\'Area o altre macro unità, va inserita l\'unità organizzativa principale' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('unita_organizzativa'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona le Unità Organizzative', 'design_comuni_italia' ),
        )
    ) );


    $cmb_struttura->add_field( array(
        'id' => $prefix . 'uo_figlie',
        'name'    => __( 'Unità organizzativa gestite', 'design_comuni_italia' ),
        'description' => 'Unità organizzative figlie',
        'options' => dci_get_posts_options('unita_organizzativa'),
        'type'    => 'pw_multiselect',
        'default_cb' => 'dci_get_uo_figlia_id',
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona le Unità Organizzative figlie', 'design_comuni_italia' ),
            'disabled' => 'true',
        )
    ) );
    
    $cmb_struttura->add_field( array(
        'id' => $prefix . 'tipo_organizzazione',
        'name'        => __( 'Tipo di organizzazione *', 'design_comuni_italia' ),
        'type'             => 'taxonomy_radio_hierarchical',
        'taxonomy'       => 'tipi_unita_organizzativa',
        'show_option_none' => false,
        'remove_default' => 'true',
        'attributes' => [
            'required' => 'required'
        ]
    ) );

    //PERSONE
    $cmb_persone = new_cmb2_box( array(
        'id'           => $prefix . 'box_persone',
        'title'        => __( 'Persone e incarichi', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_persone->add_field( array(
        'id' => $prefix . 'incarichi',
        'name'    => __( 'Incarichi', 'design_comuni_italia' ),
        'desc' => __( 'Gli incarichi delle persone nell\'unità organizzativa.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_incarichi_con_nomi(),
        'default_cb' => 'set_to_current_unita_organizzativa_incarichi',
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona gli incarichi', 'design_comuni_italia' ),
        )
    ) );

    $cmb_persone->add_field( array(
        'id' => $prefix . 'persone_struttura',
        'name'    => __( 'Componenti senza incarico', 'design_comuni_italia' ),
        'desc' => __( 'Persone che fanno parte dell\'unità organizzativa, senza un titolo specifico.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('persona_pubblica'),
        'attributes'    => array(
            'placeholder' =>  __( 'Seleziona le Persone Pubbliche', 'design_comuni_italia' ),

        ),
    ) );

    //SERVIZI
    $cmb_servizi = new_cmb2_box( array(
        'id'           => $prefix . 'box_servizi',
        'title'        => __( 'Servizi', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    $cmb_servizi->add_field( array(
        'id' => $prefix . 'elenco_servizi_offerti_1',
        'name'    => __( 'Elenco servizi offerti', 'design_comuni_italia' ),
        'desc' => __( 'Relazione con i servizi offerti dall\'unità organizzativa. I servizi appaiono qui automaticamente in base alle impostazioni del singolo servizio.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('servizio'),
        'default_cb' => 'set_to_current_unita_organizzativa_servizi',
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Servizi', 'design_comuni_italia' ),
            'disabled' => 'true',
        )
    ) );

    //CONTATTI
    $cmb_contatti = new_cmb2_box( array(
        'id'           => $prefix . 'box_contatti',
        'title'        => __( 'Contatti', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_contatti->add_field( array(
        'id'         => $prefix . 'orario_ricevimento',
        'name'       => __('Orari e modalità di ricevimento ', 'design_comuni_italia' ),
        'desc'       => __( 'Orario di apertura al pubblico del luogo.  ' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    
    $cmb_contatti->add_field( array(
        'name' => 'Sede principale è luogo dell\'Ente *',
        'id' =>  $prefix . 'is_sede_principale_esa',
        'desc' => __( 'Seleziona se l\'unità organizzativa ha sede in un luogo dell\'ente', 'design_comuni_italia' ),
        'type'    => 'radio_inline',
        'options' => array(
            'true' => __( 'Si', 'design_comuni_italia' ),
            'false'   => __( 'No', 'design_comuni_italia' ),
        ),
        'default' => 'true',
        'attributes' => array(
            'required' => 'required'
        ),
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'sede_principale',
        'name'        => __( 'Sede principale *', 'design_comuni_italia' ),
        'desc' => __( 'Relazione con un luogo (sede fisica principale)' , 'design_comuni_italia' ),
        'type'    => 'pw_select',
        'options' => dci_get_posts_options('luogo'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona il luogo', 'design_comuni_italia' ),
            'data-conditional-id' => $prefix . 'is_sede_principale_esa',
            'data-conditional-value' => "true",
            'required' => 'required'
        ),
	) );

	$cmb_contatti->add_field( array(
		'id' =>  $prefix . 'nome_sede_principale_custom',
		'name'    => __( 'Nome del luogo', 'design_comuni_italia' ),
		'desc' => __( 'Inserisci il nome del luogo (lascia vuoto hai selezionato un Luogo dell\'Ente)' , 'design_comuni_italia' ),
		'type'    => 'text',
        'attributes' => array(
            'data-conditional-id' => $prefix . 'is_sede_principale_esa',
            'data-conditional-value' => "false",
            'required' => 'required'
        ),
	) );



	$cmb_contatti->add_field( array(
		'id'         => $prefix . 'indirizzo_sede_principale_custom',
		'name'       => __( 'Indirizzo Completo', 'design_comuni_italia' ),
		'desc'       => __( 'Indirizzo completo del luogo: Via, civico, cap, città e Provincia (es: Via Vaglia, 6, 00139 - Roma RM) (lascia vuoto hai selezionato un Luogo dell\'Ente)', 'design_comuni_italia' ),
		'type'       => 'text',
        'attributes' => array(
            'data-conditional-id' => $prefix . 'is_sede_principale_esa',
            'data-conditional-value' => "false",
            'required' => 'required'
        ),
	) );


	$cmb_contatti->add_field( array(
		'id'         => $prefix . 'posizione_gps_sede_principale_custom',
        'name'       => __( 'Posizione GPS <br><small>NB: clicca sulla lente di ingandimento e cerca l\'indirizzo, anche se lo hai già inserito nel campo precedente.<br>Questo permetterà una corretta georeferenziazione del luogo</small>', 'design_comuni_italia' ),
		'desc'       => __( 'Georeferenziazione del luogo e link a posizione in mappa.  (lascia vuoto hai selezionato un Luogo dell\'Ente)', 'design_comuni_italia' ),
		'type'       => 'leaflet_map',
		'attributes' => array(
//			'tilelayer'           => 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
			'searchbox_position'  => 'topleft', // topright, bottomright, topleft, bottomleft,
			'search'              => __( 'Digita l\'indirizzo del Luogo' , 'design_comuni_italia' ),
			'not_found'           => __( 'Indirizzo non trovato' , 'design_comuni_italia' ),
			'initial_coordinates' => [
				'lat' => 41.894802, // Go Italy!
				'lng' => 12.4853384  // Go Italy!
			],
			'initial_zoom'        => 5, // Zoomlevel when there's no coordinates set,
			'default_zoom'        => 12, // Zoomlevel after the coordinates have been set & page saved
			'required'    => 'required',
            'data-conditional-id' => $prefix . 'is_sede_principale_esa',
            'data-conditional-value' => "false",
    ),
	) );


	$cmb_contatti->add_field( array(
		'id'         => $prefix . 'quartiere_sede_principale_custom',
		'name'       => __( 'Quartiere ', 'design_comuni_italia' ),
		'desc'       => __( 'Se il territorio è mappato in quartieri, riportare il Quartiere dove si svolge l\'evento (lascia vuoto hai selezionato un Luogo dell\'Ente)', 'design_comuni_italia' ),
		'type'       => 'text',
        'attributes' => array(
            'data-conditional-id' => $prefix . 'is_sede_principale_esa',
            'data-conditional-value' => "false",
        ),
	) );


	$cmb_contatti->add_field( array(
		'id'         => $prefix . 'circoscrizione_sede_principale_custom',
		'name'       => __( 'Circoscrizione ', 'design_comuni_italia' ),
		'desc'       => __( 'Se il territorio è mappato in circoscrizioni, riportare la Circoscrizione dove si svolge l\'evento (lascia vuoto hai selezionato un Luogo della Scuola )', 'design_comuni_italia' ),
		'type'       => 'text',
        'attributes' => array(
            'data-conditional-id' => $prefix . 'is_sede_principale_esa',
            'data-conditional-value' => "false",
        ),
	) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'altre_sedi_luoghi',
        'name'        => __( 'Altre sedi', 'design_comuni_italia' ),
        'desc' => __( 'Relazioni con eventuali altri luoghi che sono definibili come sedi' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('luogo'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Luoghi', 'design_comuni_italia' ),
        )
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'contatti',
        'name'        => __( 'Contatti *', 'design_comuni_italia' ),
        'desc' => __( 'Contatti dell\'Unità organizzativa' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('punto_contatto'),
        'attributes'    => array(
            'required'    => 'required',
            'placeholder' =>  __( ' Seleziona i Punti di Contatto', 'design_comuni_italia' ),
        ),
    ) );


    //DOCUMENTI
    $cmb_documenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_documenti',
        'title'        => __( 'Documenti', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );

    $cmb_documenti->add_field( array(
        'id' => $prefix . 'allegati',
        'name'        => __( 'Allegati', 'design_comuni_italia' ),
        'desc' => __( 'Elenco di documenti allegati all\'unità organizzativa' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('documento_pubblico'),
        'atributes' => array(
            'placeholder' =>  __( 'Seleziona i Documenti Pubblici', 'design_comuni_italia' ),
        )
    ) );

    //ULTERIORI INFORMAZIONI
    $cmb_ulteriori_informazioni = new_cmb2_box( array(
        'id'           => $prefix . 'box_ulteriori_informazioni',
        'title'        => __( 'Ulteriori informazioni', 'design_comuni_italia' ),
        'object_types' => array( 'unita_organizzativa' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );
    $cmb_ulteriori_informazioni->add_field( array(
        'id' => $prefix . 'ulteriori_informazioni',
        'name'        => __( 'Ulteriori informazioni', 'design_comuni_italia' ),
        'desc' => __( 'Ulteriori informazioni sull\'unità organizzativa non contemplate dai campi precedenti.' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false,
            'textarea_rows' => 10,
            'teeny' => false,
        ),
    ) );
}

/**
 * aggiungo js per controllo compilazione campi
 */
add_action( 'admin_print_scripts-post-new.php', 'dci_unita_organizzativa_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'dci_unita_organizzativa_admin_script', 11 );

function dci_unita_organizzativa_admin_script() {
    global $post_type;
    if( 'unita_organizzativa' == $post_type )
        wp_enqueue_script( 'unita_organizzativa-admin-script', get_template_directory_uri() . '/inc/admin-js/unita_organizzativa.js' );
}

/**
 * Valorizzo il post content in base al contenuto dei campi custom
 * @param $data
 * @return mixed
 */
function dci_unita_organizzativa_set_post_content( $data ) {

    if($data['post_type'] == 'unita_organizzativa') {

        $descrizione_breve = '';
        if (isset($_POST['_dci_unita_organizzativa_descrizione_breve'])) {
            $descrizione_breve = $_POST['_dci_unita_organizzativa_descrizione_breve'];
        }

        $competenze= '';
        if (isset($_POST['_dci_unita_organizzativa_competenze'])) {
            $competenze = $_POST['_dci_unita_organizzativa_competenze'];
        }

        $info = '';
        if (isset($_POST['_dci_unita_organizzativa_ulteriori_informazioni'])) {
            $info = $_POST['_dci_unita_organizzativa_ulteriori_informazioni'];
        }

        $content = $descrizione_breve.'<br>'.$competenze.'<br>'.$info;

        $data['post_content'] = $content;
    }

    return $data;
}

add_filter( 'wp_insert_post_data' , 'dci_unita_organizzativa_set_post_content' , '99', 1 );

new dci_bidirectional_cmb2("_dci_unita_organizzativa_", "unita_organizzativa", "persone_struttura", "box_persone", "_dci_persona_pubblica_organizzazioni");

new dci_bidirectional_cmb2("_dci_unita_organizzativa_", "unita_organizzativa", "sede_principale", "box_contatti", "_dci_luogo_sede_di");

new dci_bidirectional_cmb2("_dci_unita_organizzativa_", "unita_organizzativa", "elenco_servizi_offerti", "box_contatti", "_dci_servizio_unita_responsabile");

new dci_bidirectional_cmb2("_dci_unita_organizzativa_", "unita_organizzativa", "incarichi", "box_persone", "_dci_incarico_incarico_unita_organizzative");


function set_to_current_unita_organizzativa_servizi($field_args, $field  ) {
	return dci_get_meta("elenco_servizi_offerti", "_dci_unita_organizzativa_", $field->object_id) ?? [];
}

function set_to_current_unita_organizzativa_incarichi($field_args, $field  ) {
	return dci_get_meta("incarichi", "_dci_unita_organizzativa_", $field->object_id) ?? [];
}


function get_post_admin(){
	if ( isset( $_GET['post'] ) && ! empty( $_GET['post'] ) ) {
    $post_id = absint( $_GET['post'] ); 
    $post = get_post( $post_id );

	}
	return $post->ID;
}

function dci_get_uo_figlia_id($field_args, $field){
	

	$post = get_post_admin();


    $args = [
        'post_type' => 'unita_organizzativa',
        'posts_per_page' => -1
    ];

    $unita = get_posts($args);

    $unita_organizzate = array();

    foreach($unita as $uo){
        $id_genitore_uo = get_post_meta($uo->ID, '_dci_unita_organizzativa_unita_organizzativa_genitore');

        if(isset($id_genitore_uo) && is_array($id_genitore_uo)){
            foreach($id_genitore_uo[0] as $id_g){
                
                if(intval($id_g) == $post){
                    $unita_organizzate[] = $uo->ID;
                }   
            }
        }     
    }
    return $unita_organizzate;
}

function dci_get_uo_figlia($post){

    $args = [
        'post_type' => 'unita_organizzativa',
        'posts_per_page' => -1
    ];

    $unita = get_posts($args);

    $unita_organizzate = array();

    foreach($unita as $uo){
        $id_genitore_uo = get_post_meta($uo->ID, '_dci_unita_organizzativa_unita_organizzativa_genitore');

        if(isset($id_genitore_uo) && is_array($id_genitore_uo)){
            foreach($id_genitore_uo[0] as $id_g){
                
                if(intval($id_g) == $post){
                    $unita_organizzate[] = $uo->ID;
                }   
            }
        }     
    }
    return $unita_organizzate;
}