<?php
/**
 * Definisce post type Luogo
 */
add_action( 'init', 'dci_register_post_type_luogo');
function dci_register_post_type_luogo() {

	/** luogo **/
	$labels = array(
		'name'          => _x( 'Luoghi', 'Post Type General Name', 'design_comuni_italia' ),
		'singular_name' => _x( 'Luogo', 'Post Type Singular Name', 'design_comuni_italia' ),
		'add_new'       => _x( 'Aggiungi un Luogo', 'Post Type Singular Name', 'design_comuni_italia' ),
		'add_new_item'  => _x( 'Aggiungi un Luogo', 'Post Type Singular Name', 'design_comuni_italia' ),
		'edit_item'      => _x( 'Modifica il Luogo', 'Post Type Singular Name', 'design_comuni_italia' ),
		'view_item'      => _x( 'Visualizza il Luogo', 'Post Type Singular Name', 'design_comuni_italia' ),
	);
	$args   = array(
		'label'         => __( 'Luogo', 'design_comuni_italia' ),
		'labels'        => $labels,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'  => true,
		'public'        => true,
        'menu_position' => 5,
        'rewrite' => array('slug' => 'vivere-ente/luoghi', 'with_front' => false),
		'menu_icon'     => 'dashicons-location-alt',
        'has_archive'           => false,    //archive page
        'capability_type' => array('luogo', 'luoghi'),
        'map_meta_cap'    => true,
	);
	register_post_type( 'luogo', $args );

    remove_post_type_support( 'luogo', 'editor');
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'dci_luogo_add_content_after_title' );
function dci_luogo_add_content_after_title($post) {
	if($post->post_type == "luogo")
		_e('<span><i>il <b>Titolo</b> è il <b>Nome del Luogo</b> o il nome con cui il luogo è conosciuto.</i></span><br><br>', 'design_comuni_italia' );
}

/**
 * Crea i metabox del post type servizi
 */
add_action( 'cmb2_init', 'dci_add_luogo_metaboxes' );
function dci_add_luogo_metaboxes() {

	$prefix = '_dci_luogo_';

    $cmb_identificativo = new_cmb2_box(array(
        'id' => $prefix . 'box_identificativo',
        'title' => __('Identificativo', 'design_comuni_italia'),
        'object_types' => array('luogo'),
        'context' => 'side',
        'priority' => 'high',
    ));

    $cmb_identificativo->add_field(array(
        'id' => $prefix . 'id',
        //'name' => __("Identificativo", 'design_comuni_italia'),
        'desc' => __('Codice identificativo del luogo. Nel MIBAC c\'è il codice del DBUnico per i luoghi della cultura e il codice ISIL per le biblioteche.', 'design_comuni_italia'),
        'after' => __("  ad uso interno", 'design_comuni_italia'),
        'type' => 'text_small',
    ));


    $cmb_tipo_luogo = new_cmb2_box(array(
        'id' => $prefix . 'box_tipo_luogo',
        'title' => __('Tipo di luogo', 'design_comuni_italia'),
        'object_types' => array('luogo'),
        'context' => 'side',
        'priority' => 'high',
    ));

    $cmb_tipo_luogo->add_field( array(
        'id'        => $prefix . 'tipo_luogo',
        //'name'      => __( 'Tipo di Luogo', 'design_comuni_italia' ),
        'desc'      => __( 'Non obbligatoria perché il luogo potrebbe non essere un POI', 'design_comuni_italia' ),
        'type'           => 'taxonomy_radio_hierarchical',
        'taxonomy'       => 'tipi_luogo',
        'remove_default' => 'true',
        'show_option_none' => true,
        'attributes' => array(
            'required' => 'required'
        )
    ) );

    //argomenti
    $cmb_argomenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_argomenti',
        'title'        => __( 'Argomenti', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
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

    //APERTURA
    $cmb_apertura = new_cmb2_box( array(
        'id'           => $prefix . 'box_apertura',
        'title'        => __( 'Apertura', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'nome_alternativo',
        'name'      => __( 'Nome alternativo', 'design_comuni_italia' ),
        'desc' => __( 'Nome alternativo o secondario del luogo. Ad es. "Anfiteatro Flavio".', 'design_comuni_italia' ),
        'type' => 'text',
    ) );

    $cmb_apertura->add_field( array(
        'id'         => $prefix . 'descrizione_breve',
        'name'       => __( 'Descrizione breve *', 'design_comuni_italia' ),
        'desc'       => __( 'Sintetica descrizione del luogo (meno di 255 caratteri)', 'design_comuni_italia' ),
        'type'       => 'textarea',
        'attributes'    => array(
            'maxlength'  => '255',
            'required'    => 'required'
        ),
    ) );

    //DESCRIZIONE
    $cmb_descrizione = new_cmb2_box( array(
        'id'           => $prefix . 'box_descrizione',
        'title'        => __( 'Descrizione', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_descrizione->add_field( array(
        'id' => $prefix . 'descrizione_estesa',
        'name'        => __( 'Descrizione estesa', 'design_comuni_italia' ),
        'desc' => __( 'Descrizione del luogo e degli elementi di interesse presenti nel luogo (POI)' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    $cmb_descrizione->add_field( array(
        'id' => $prefix . 'luoghi_collegati',
        'name'        => __( 'Altri luoghi collegati', 'design_comuni_italia' ),
        'desc' => __( 'Elenco di eventuali altri luoghi d\'interesse collegati' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('luogo'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Luoghi', 'design_comuni_italia' ),
        ),
    ) );

    $cmb_gallerie_multimediali = new_cmb2_box( array(
        'id'           => $prefix . 'box_gallerie_multimediali',
        'title'        => __( 'Gallerie multimediali', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_gallerie_multimediali->add_field( array(
        'name'       => __('Galleria di immagini', 'design_comuni_italia' ),
        'desc' => __( 'Solo per Persona Politica: gallery dell attività politica e istituzionale della persona.' , 'design_comuni_italia' ),
        'id'             => $prefix . 'gallery',
        'type' => 'file_list',
        'query_args' => array( 'type' => 'image' ),
        'attributes'    => array(
            'data-conditional-id'     => $prefix.'tipologia_persona',
            'data-conditional-value'  => "Persona Politica",
        ),
    ) );

    /*
    $cmb_gallerie_multimediali = new_cmb2_box( array(
        'id'           => $prefix . 'box_gallerie_multimediali',
        'title'        => __( 'Gallerie multimediali', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    // repeater Gallerie Multimediali
    $group_field_id = $cmb_gallerie_multimediali->add_field( array(
        'id'          => $prefix . 'gallerie_multimediali',
        //'name'        => __('<h1>Fasi e Scadenze</h1>', 'design_comuni_italia' ),
        'type'        => 'group',
        'description' => __( 'E\' possibile inserire più gallerie multimediali' , 'design_comuni_italia' ),
        'options'     => array(
            'group_title'    => __( 'Galleria {#}', 'design_comuni_italia' ), // {#} gets replaced by row number
            'add_button'     => __( 'Aggiungi una gallery', 'design_comuni_italia' ),
            'remove_button'  => __( 'Rimuovi la gallery', 'design_comuni_italia' ),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            //'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );

    $cmb_gallerie_multimediali->add_group_field( $group_field_id, array(
        'name'       => __('Titolo gallery', 'design_comuni_italia' ),
        //'desc'       => __('Esempio: ".."', 'design_comuni_italia' ),
        'id'         => 'titolo_gallery',
        'type'       => 'text',
    ) );
    $cmb_gallerie_multimediali->add_group_field( $group_field_id, array(
        'name'       => __('Media', 'design_comuni_italia' ),
        'desc'       => __('contenuti della gallery (immagini o video)', 'design_comuni_italia' ),
        'id'         => 'contenuti_gallery',
        'type'       => 'file_list',
        'query_args' => array( 'type' => array('image','video') )
    ) );

    fine repeater gallerie */


    //SERVIZI
    $cmb_servizi = new_cmb2_box( array(
        'id'           => $prefix . 'box_servizi',
        'title'        => __( 'Servizi', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    
    $cmb_servizi->add_field( array(
        'id' => $prefix . 'servizi_erogati',
        'name'        => __( 'Servizi erogati in questo luogo', 'design_comuni_italia' ),
        'desc' => __( 'Scegli i servizi che vengono erogati in questo luogo' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('servizio'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i servizi', 'design_comuni_italia' ),
        ),
    ) );

    $cmb_servizi->add_field( array(
        'id' => $prefix . 'servizi',
        'name'        => __( 'Servizi privati erogati nel luogo', 'design_comuni_italia' ),
        'desc' => __( 'Se il luogo presenta servizi di carattere privato, descrizione testuale del servizio e link esterno al servizio.' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );


    //MODALITA' DI ACCESSO
    $cmb_accesso = new_cmb2_box( array(
        'id'           => $prefix . 'box_accesso',
        'title'        => __( 'Modalità di accesso', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_accesso->add_field( array(
        'id' => $prefix . 'modalita_accesso',
        'name'        => __( 'Modalità di accesso *', 'design_comuni_italia' ),
        'desc' => __( 'Servizi disponibili sulle modalità di accesso al luogo con particolare attenzione agli accessi per disabili.' , 'design_comuni_italia' ),
        'type'       => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
        'attributes'    => array(
            'required'    => 'required'
        ),
    ) );

    //DOVE
    $cmb_dove = new_cmb2_box( array(
        'id'           => $prefix . 'box_dove',
        'title'        => __( 'Dove', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_dove->add_field( array(
        'id'         => $prefix . 'childof',
        'name'       => __( 'Il luogo è parte di ', 'design_comuni_italia' ),
        'desc'       => __( 'Con questo campo è possibile stabilire una relazione tra il luogo che si sta creando e il luogo che lo contiene. Ad esempio: il luogo chiesetta è contenuto nell\'edificio principale.', 'design_scuole_italia' ),
        'type'    => 'select',
        'options' => dci_get_posts_options('luogo', true, true),
    ) );

    $cmb_dove->add_field( array(
        'id'         => $prefix . 'indirizzo',
        'name'       => __( 'Indirizzo *', 'design_comuni_italia' ),
        'desc'       => __( 'Indirizzo del luogo.', 'design_comuni_italia' ),
        'type'       => 'textarea',
        'attributes'    => array(
            'maxlength'  => '255',
            'data-conditional-id'    => $prefix . 'childof',
			'data-conditional-value' => '0',
        ),
    ) );

    $cmb_dove->add_field( array(
        'id'         => $prefix . 'quartiere',
        'name'       => __( 'Quartiere  ', 'design_comuni_italia' ),
        'desc'       => __( 'Se il territorio è mappato in quartieri, riportare il Quartiere dove è situato il luogo.', 'design_comuni_italia' ),
        'type'       => 'text',
        'attributes'    => array(
            'maxlength'  => '255',
            'data-conditional-id'    => $prefix . 'childof',
			'data-conditional-value' => '0',
        ),
    ) );

    //mappa field GPS
    $cmb_dove->add_field( array(
        'id'         => $prefix . 'posizione_gps',
        'name'       => __( 'Posizione GPS *<br><small>NB: clicca sulla lente d\'ingrandimento e cerca l\'indirizzo, anche se lo hai già inserito nel campo precedente.<br>Questo permetterà una corretta georeferenziazione del luogo</small>', 'design_comuni_italia' ),
        'desc'       => __( 'Georeferenziazione del luogo e link a posizione in mappa', 'design_comuni_italia' ),
        'type'       => 'leaflet_map',
        'attributes' => array(
            'searchbox_position'  => 'topleft', // topright, bottomright, topleft, bottomleft,
            'search'              => __( 'Digita l\'indirizzo della Sede' , 'design_comuni_italia' ),
            'not_found'           => __( 'Indirizzo non trovato' , 'design_comuni_italia' ),
            'initial_coordinates' => [
                'lat' => 41.894802, // Go Italy!
                'lng' => 12.4853384  // Go Italy!
            ],
            'initial_zoom'        => 5, // Zoomlevel when there's no coordinates set,
            'default_zoom'        => 12, // Zoomlevel after the coordinates have been set & page saved
        )
    ) );


    $cmb_dove->add_field( array(
        'id'         => $prefix . 'cap',
        'name'       => __( 'CAP *', 'design_comuni_italia' ),
        'desc'       => __( 'Codice di avviamento postale del luogo', 'design_comuni_italia' ),
        'type'       => 'text_small',
        'attributes' => array(
            'data-conditional-id'    => $prefix . 'childof',
			'data-conditional-value' => '0',
        ),
    ) );

    //ORARI DI APERTURA
    $cmb_orari = new_cmb2_box( array(
        'id'           => $prefix . 'box_orari',
        'title'        => __( 'Orari di apertura', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_orari->add_field( array(
        'id'         => $prefix . 'orario_pubblico',
        'name'       => __('Orario per il pubblico ', 'design_comuni_italia' ),
        'desc'       => __( 'Orario di apertura al pubblico del luogo.  ' ),
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //CONTATTI
    $cmb_contatti = new_cmb2_box( array(
        'id'           => $prefix . 'box_contatti',
        'title'        => __( 'Contatti', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'punti_contatto',
        'name'        => __( 'Punti di contatto *', 'design_comuni_italia' ),
        'desc' => __( 'Telefono, mail o altri punti di contatto<br><a href="post-new.php?post_type=punto_contatto">Inserisci Punto di Contatto</a>' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('punto_contatto'),
        'attributes'    => array(
            'placeholder' =>  __( ' Seleziona i Punti di Contatto', 'design_comuni_italia' ),
        ),
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'struttura_responsabile',
        'name'    => __( 'Unità organizzativa responsabile' ),
        'desc' => __( 'Unità organizzativa che ha la responsabilità del luogo' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('unita_organizzativa'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona le Unità Organizzative', 'design_comuni_italia' ),
        )
    ) );

    $cmb_contatti->add_field( array(
        'id' => $prefix . 'incarichi',
        'name'    => 'Persone: ',
        'desc' => 'Link alle Persone (incarichi) presenti nel luogo. Puoi modificare il luogo di un\'incarico nelle sue impostazioni.' ,
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('incarico'),
        'default_cb' => 'set_to_current_persona',
        'attributes' => array(
            'placeholder' =>  'Seleziona le Persone',
        )
    ) );


    //ULTERIORI INFORMAZIONI
    $cmb_informazioni = new_cmb2_box( array(
        'id'           => $prefix . 'box_informazioni',
        'title'        => __( 'Ulteriori informazioni', 'design_comuni_italia' ),
        'object_types' => array( 'luogo' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_informazioni->add_field( array(
        'id' => $prefix . 'sede_di_1',
        'name'    => __( 'Sede di: ', 'design_comuni_italia' ),
        'desc' => __( 'Link alle unità organizzative (uffici, aree, organi) presenti nel luogo. Puoi modificare il luogo di un\'unità organizzativa nelle sue impostazioni.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('unita_organizzativa'),
        'default_cb' => 'set_to_current_luogo_sede_di',
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona le Unità Organizzative', 'design_comuni_italia' ),
            'disabled' => 'true',
            'required' => 'required'
        )
    ) );

    $cmb_informazioni->add_field( array(
        'id'         => $prefix . 'ulteriori_informazioni',
        'name'       => __( 'Ulteriori informazioni', 'design_comuni_italia' ),
        'desc'       => __( 'Ulteriori informazioni sul Luogo, FAQ ed eventuali riferimenti normativi', 'design_comuni_italia' ),
        'type'       => 'wysiwyg',
        'options' => array(
            'media_buttons' => false,
            'textarea_rows' => 10,
            'teeny' => false,
        ),
    ) );

}


//TODO: rimozione body del post
/**
 * Aggiungo testo prima del content
 */
/*
add_action( 'edit_form_after_title', 'sdi_luogo_add_content_before_editor', 100 );
function sdi_luogo_add_content_before_editor($post) {
	if($post->post_type == "luogo")
		_e('<h1>Descrizione del luogo</h1>', 'design_comuni_italia' );
}
*/

/**
 * aggiungo js controllo campi obbligatori
 */
add_action( 'admin_print_scripts-post-new.php', 'dci_luogo_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'dci_luogo_admin_script', 11 );

function dci_luogo_admin_script() {
	global $post_type;
	if( 'luogo' == $post_type )
		wp_enqueue_script( 'luogo-admin-script', get_template_directory_uri() . '/inc/admin-js/luogo.js' );
}

/**
 * salvo il parent cmb2
 */

add_action( 'save_post_luogo', 'dci_save_luogo' );
function dci_save_luogo( $post_id) {
	$post_type = get_post_type($post_id);
	// If this isn't a 'book' post, don't update it.
	if ( "luogo" != $post_type ) return;
	//Check it's not an auto save routine
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return;

	//Perform permission checks! For example:
	if ( !current_user_can('edit_post', $post_id) )
		return;

	if(!isset($_POST["_dci_luogo_childof"]))
	    return;

	//$parentid = dci_get_meta("childof", "_dci_luogo_", $post_id);
    $parentid = $_POST["_dci_luogo_childof"];


    if($parentid == "")
		$parentid = 0;
	remove_action( 'save_post_luogo','dci_save_luogo' );
	wp_update_post(
		array(
			'ID'          => $post_id,
			'post_parent' => $parentid
		)
	);
	add_action( 'save_post_luogo', 'dci_save_luogo' );
}

/**
 * Valorizzo il post content in base al contenuto dei campi custom
 * @param $data
 * @return mixed
 */
function dci_luogo_set_post_content( $data ) {

    if($data['post_type'] == 'luogo') {

        $descrizione_breve = '';
        if (isset($_POST['_dci_luogo_descrizione_breve'])) {
            $descrizione_breve = $_POST['_dci_luogo_descrizione_breve'];
        }

        $descrizione_estesa = '';
        if (isset($_POST['_dci_luogo_descrizione_estesa'])) {
            $descrizione_estesa = $_POST['_dci_luogo_descrizione_estesa'];
        }

        $info = '';
        if (isset($_POST['_dci_luogo_ulteriori_informazioni'])) {
            $info = $_POST['_dci_luogo_ulteriori_informazioni'];
        }

        $content = $descrizione_breve.'<br>'.$descrizione_estesa.'<br>'.$info;

        $data['post_content'] = $content;
    }

    return $data;
}
add_filter( 'wp_insert_post_data' , 'dci_luogo_set_post_content' , '99', 1 );

// relazione bidirezionale struttura / luoghi
new dci_bidirectional_cmb2("_dci_luogo_", "luogo", "sede_di", "box_informazioni", "_dci_unita_organizzativa_sede_principale");

// relazione bidirezionale Incarico / luoghi
new dci_bidirectional_cmb2("_dci_luogo_", "luogo", "incarichi", "box_contatti", "_dci_incarico_luoghi_incarico");

// relazione bidirezionale luoghi / luoghi
new dci_bidirectional_cmb2("_dci_luogo_", "luogo", "luoghi_collegati", "box_descrizione", "_dci_luogo_luoghi_collegati");

// relazione bidirezionale servizi / luoghi
new dci_bidirectional_cmb2("_dci_luogo_", "luogo", "servizi_erogati", "box_servizi", "_dci_servizio_canale_fisico_luoghi");

function set_to_current_luogo_sede_di($field_args, $field  ) {
	return dci_get_meta("sede_di", "_dci_luogo_", $field->object_id) ?? [];
}

function set_to_current_persona($field_args, $field  ) {
	return dci_get_meta("incarichi", "_dci_luogo_", $field->object_id) ?? [];
}