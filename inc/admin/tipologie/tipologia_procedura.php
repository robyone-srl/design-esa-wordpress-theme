<?php

/**
 * Definisce post type come_fare
 */
add_action( 'init', 'dci_register_post_type_procedura');
function dci_register_post_type_procedura() {

    /** procedura **/
    $labels = array(
        'name'                  => _x( 'Come fare per', 'Post Type General Name', 'design_comuni_italia' ),
        'singular_name'         => _x( 'Come fare per', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new'               => _x( 'Aggiungi un nuovo Come fare per', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new_item'          => _x( 'Aggiungi un nuovo elemento', 'Post Type Singular Name', 'design_comuni_italia' ),
        'featured_image'        => __( 'Logo Identificativo della procedura', 'design_comuni_italia' ),
        'edit_item'             => _x( 'Modifica la procedura', 'Post Type Singular Name', 'design_comuni_italia' ),
        'view_item'             => _x( 'Visualizza la procedura', 'Post Type Singular Name', 'design_comuni_italia' ),
    );
    $args = array(
        'label'                 => __( 'Procedura', 'design_comuni_italia' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' , 'thumbnail' ),
        'taxonomies'            => array( 'argomenti' ),
        'hierarchical'          => false,
        'public'                => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-list-view',
        'has_archive'           => false,
        'rewrite'               => array('slug' => 'procedura', 'with_front' => false),
        'capability_type'       => array('procedura', 'procedure'),
        'map_meta_cap'          => true,
        'description'           => __( "Descrizione", 'design_comuni_italia' ),
    );
    register_post_type( 'procedura', $args );

    remove_post_type_support( 'procedura', 'editor');
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'dci_procedura_add_content_after_title' );
function dci_procedura_add_content_after_title($post) {
    if($post->post_type == "procedura")
        _e('<span><i>il <b>Titolo</b> e&grave; il <b>Nome della procedura</b>.</i></span><br><br>', 'design_comuni_italia' );
}

/**
 * Crea i metabox del post type procedura
 */
add_action( 'cmb2_init', 'dci_add_procedura_metaboxes' );
function dci_add_procedura_metaboxes() {
    $prefix = '_dci_procedura_';

    // Intestazione
    $cmb_procedura_int = new_cmb2_box( array(
        'id'           => $prefix . 'box_procedura_int',
        'title'        => 'Intestazione',
        'object_types' => array( 'procedura' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    $cmb_procedura_int->add_field( array(
        'id'            => $prefix . 'descrizione_breve',
        'name'          => 'Descrizione breve *', 'design_comuni_italia',
        'desc'          => 'Sintetica descrizione della procedura (meno di 255 caratteri)',
        'type'          => 'textarea',
        'attributes'    => array(
            'maxlength' => '255',
            'required'  => 'required'
        ),
    ) );

    //argomenti
    $cmb_argomenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_argomenti',
        'title'        => __( 'Argomenti', 'design_comuni_italia' ),
        'object_types' => array( 'procedura' ),
        'context'      => 'side',
        'priority'     => 'high',
    ) );
    $cmb_argomenti->add_field( array(
        'id'                => $prefix . 'argomenti',
        'type'              => 'taxonomy_multicheck_hierarchical',
        'taxonomy'          => 'argomenti',
        'show_option_none'  => false,
        'remove_default'    => 'true',
    ) );

    //corpo
    $cmb_procedura_body = new_cmb2_box( array(
        'id'           => $prefix . 'box_procedura_body',
        'title'        => 'Cos\'e&grave;',
        'object_types' => array( 'procedura' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    $cmb_procedura_body->add_field( array(
        'id'        => $prefix . 'descrizione_estesa',
        'name'      => 'Panoramica',
        'desc'      => 'Descrizione estesa e completa della procedura.' ,
        'type'      => 'wysiwyg',
        'options'   => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny'         => false, // output the minimal editor config used in Press This
        ),
    ) );

    $cmb_procedura_body->add_field( array(
        'id'         => $prefix . 'a_chi_e_rivolto',
        'name'       => 'A chi e&grave; rivolto',
        'desc'       => 'Descrizione testuale dei principali destinatari della procedura',
        'type'       => 'wysiwyg',
        'options'    => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //Come fare
    $cmb_cosa_serve= new_cmb2_box( array(
        'id'           => $prefix . 'box_cosa_serve',
        'title'        => 'Come fare',
        'object_types' => array( 'procedura' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_in_rest' => WP_REST_Server::READABLE
    ) );

    $cmb_cosa_serve->add_field( array(
        'id'         => $prefix . 'cosa_serve_introduzione',
        'name'       => 'Come fare (testo introduttivo)',
        'desc'       => 'es: "Per attivare il servizio bisogna prima compilare il modulo on line oppure stampare e compilare il modulo cartaceo che trovi nella sezione documenti di questa pagina. [Vai alla sezione documenti]" Per creare un link mediante ancora inserisci #art-par-documenti come valore del link.',
        'type'       => 'wysiwyg',
        'options'    => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny'         => false, // output the minimal editor config used in Press This
        ),
    ) );
    $cmb_cosa_serve->add_field( array(
        'id'         => $prefix . 'come_fare_list',
        'name'       => __( 'Come fare (lista)', 'design_comuni_italia' ),
        'desc'       => __( 'la lista dei passaggi da fare' , 'design_comuni_italia' ),
        'type'       => 'textarea',
        'repeatable' => true
    ) );

    $group_field_id = $cmb_cosa_serve->add_field( array(
        'id'          => $prefix . 'fasi_raggruppate',
        'name'        => 'Lista delle fasi',
        'desc'        => 'Seleziona e configura le fasi della procedura.',
        'type'        => 'group',
        'options'     => array(
            'group_title'    => __( 'Fase {#}', 'design_comuni_italia' ),
            'add_button'     => __( 'Aggiungi Fase', 'design_comuni_italia' ),
            'remove_button'  => __( 'Rimuovi Fase', 'design_comuni_italia' ),
            'sortable'       => true,
            'closed'         => false,
        ),
    ) );

    $cmb_cosa_serve->add_group_field( $group_field_id, array(
        'id'          => 'fase_selezionata',
        'name'        => 'Fase della procedura',
        'desc'        => 'Seleziona la fase specifica. <br><a href="post-new.php?post_type=fase">Inserisci Fase</a>',
        'type'        => 'pw_select',
        'options'     => dci_get_posts_options('fase'),
        'attributes'  => array(
            'placeholder' => __( 'Seleziona una fase', 'design_comuni_italia')
        ),
    ) );

    $cmb_cosa_serve->add_group_field( $group_field_id, array(
        'id'          => 'type_date',
        'name'        => 'Tipo di data per la scadenza delle attivit&agrave',
        'type' => 'radio',
        'show_option_none' => false,
        'default'     => 'days',
        'options'          => array(
            'days'   => __( 'Scadenza per giorni', 'cmb2' ),
            'calendar' => __( 'Scadenza per calendario', 'cmb2' ),
        ),
    ) );

    $cmb_cosa_serve->add_group_field( $group_field_id, array(
        'name'       => 'Data di scadenza dell\'attivit&agrave;',
        'desc'       => 'Scadenza dell\'attivit&agrave;',
        'id'         => 'scadenza_fase',
        'type'       => 'text_date',
        'date_format' => 'd-m-Y',
        'attributes' => array(
            'data-conditional-id' => 'type_date',
            'data-conditional-value'  => 'calendar',
        ),
    ) );

    $cmb_cosa_serve->add_group_field( $group_field_id, array(
        'id'          => 'count_giorni',
        'name'        => 'Durata prevista per l\'esecuzione dell\'attivit&agrave; (in giorni)',
        'desc'        => 'Aggiungi termine in giorni (non verra mostrato se vuoto)',
        'type' => 'text_small',
        'attributes' => array(
            'type' => 'number',
            'data-conditional-id' => 'type_date',
            'data-conditional-value'  => 'days',
        ),
    ) );

    $cmb_cosa_serve->add_group_field( $group_field_id, array(
        'id'          => 'type_count_giorni',
        'name'        => 'Riferimento per il calcolo dei giorni della durata',
        'desc'        => 'Verr&agrave; mostrata di fianco ai giorni qualora compilati',
        'type' => 'radio',
        'show_option_none' => false,
        'options'          => array(
            'fase' => __( 'Termine dalla fase precedente', 'cmb2' ),
            'totale'   => __( 'Inizio della procedura', 'cmb2' ),
        ),
        'attributes' => array(
            'data-conditional-id' => 'type_date',
            'data-conditional-value'  => 'days',
        ),
    ) );

    //Ulteriori info
    $cmb_informazioni = new_cmb2_box( array(
        'id'           => $prefix . 'box_informazioni',
        'title'        => 'Informazioni',
        'object_types' => array( 'procedura' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_informazioni->add_field( array(
        'id'         => $prefix . 'ulteriori_informazioni',
        'name'       => 'Ulteriori informazioni',
        'desc'       => 'Eventuali link a pagine web, siti, servizi esterni all\'ambito comunale utili',
        'type'       => 'wysiwyg',
        'options' => array(
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //Servizi inclusi
    $cmb_informazioni->add_field( array(
        'id' => $prefix . 'servizi_inclusi',
        'name'    => __( 'Servizi inclusi ', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona i servizi riguardanti questa procedura' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('servizio'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i servizi inclusi', 'design_comuni_italia' ),
        )
    ) );

    //DOCUMENTI
    $cmb_informazioni->add_field( array(
        'id' => $prefix . 'documenti',
        'name'        => __( 'Documenti', 'design_comuni_italia' ),
        'desc' => __( 'Link alle schede documenti correlati.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('documento_pubblico'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Documenti Pubblici', 'design_comuni_italia' ),
        ),
    ) );

    //Contatti
    $cmb_informazioni->add_field( array(
        'id'        => $prefix . 'unita_responsabile',
        'name'      => 'Unit&agrave; Organizzativa responsabile',
        'desc'      => 'Link dell\'ufficio resposanbile' ,
        'type'      => 'pw_select',
        'options'   => dci_get_posts_options('unita_organizzativa'),
        'attributes' => array(
            'placeholder'   =>  'Seleziona le Unit&agrave; Organizzative',
        )
    ) );

    $cmb_informazioni->add_field( array(
        'id'        => $prefix . 'punti_contatto',
        'name'      => 'Contatti dedicati',
        'desc'      => 'Telefono, mail o altri punti di contatto a cui rivolgersi per ulteriori informazioni',
        'type'      => 'pw_multiselect',
        'options'   => dci_get_posts_options('punto_contatto'),
        'attributes'    => array(
            'placeholder' =>  'Seleziona i Punti di Contatto',
        ),
    ) );

 }

function dci_extract_fasi_from_post_data( $post_data ) {
    $fasi_ids = array();
    $meta_key_gruppo = '_dci_procedura_fasi_raggruppate';
    
    $fasi_group = isset( $post_data[$meta_key_gruppo] ) ? $post_data[$meta_key_gruppo] : array();
    
    if ( is_array( $fasi_group ) && ! empty( $fasi_group ) ) {
        foreach ( $fasi_group as $fase_row ) {
            if ( ! empty($fase_row['fase_selezionata']) ) {
                $fasi_ids[] = absint( $fase_row['fase_selezionata'] );
            }
        }
    }
    return array_filter( array_unique( $fasi_ids ) );
}


add_action( 'save_post_procedura', 'dci_update_bidirectional_fasi_field', 10, 2 );

/**
 * Gestisce l'aggiornamento bidirezionale (Procedura -> Fase) utilizzando i Transients.
 */
function dci_update_bidirectional_fasi_field( $procedura_id, $procedura_post ) {
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $procedura_id ) ) { return; }

    $meta_key_fase_inversa = '_dci_fase_procedure_collegate';
    $procedura_id = absint( $procedura_id );

    $nuovi_fasi_ids = dci_extract_fasi_from_post_data( $_POST );

    $vecchi_fasi_ids_group = (array) get_post_meta( $procedura_id, '_dci_procedura_fasi_raggruppate', true );
    $vecchi_fasi_ids = dci_extract_fasi_from_post_data( ['_dci_procedura_fasi_raggruppate' => $vecchi_fasi_ids_group] );

    $fasi_da_processare = array_unique( array_merge( $vecchi_fasi_ids, $nuovi_fasi_ids ) );

    foreach ( $fasi_da_processare as $fase_id ) {
        
        $collegamenti_inversi = (array) get_post_meta( $fase_id, $meta_key_fase_inversa, true );
        $collegamenti_inversi = array_map( 'absint', array_filter( $collegamenti_inversi ) );
    
        $e_ancora_collegata = in_array( $fase_id, $nuovi_fasi_ids, true );
        $procedura_id_int = absint($procedura_id);

        $key = array_search( $procedura_id_int, $collegamenti_inversi, true );

        if ( $e_ancora_collegata && $key === false ) {
            $collegamenti_inversi[] = $procedura_id_int;
        
        } elseif ( ! $e_ancora_collegata && $key !== false ) {
            unset( $collegamenti_inversi[ $key ] );
        }
        
        $collegamenti_inversi = array_unique( array_values( $collegamenti_inversi ) );
        update_post_meta( $fase_id, $meta_key_fase_inversa, $collegamenti_inversi );
    }
}

function set_to_current_procedure_fase($field_args, $field  ) {
	return dci_get_meta("fasi", "_dci_fase_", $field->object_id) ?? [];
}

 /**
 * Valorizzo il post content in base al campo procedura, necessario per la ricerca del contenuto
 * @param $data
 * @return mixed
 */
function dci_procedura_set_post_content( $data ) {

    if($data['post_type'] == 'procedura' && isset($_POST['_dci_procedura_campo_prova'])) {
        $prova = $_POST['_dci_procedura_campo_prova'];
        $data['post_content'] =  $prova;
    }

    return $data;
}
add_filter( 'wp_insert_post_data' , 'dci_procedura_set_post_content' , '99', 1 );

/**
 * Aggiunge la colonna "Fasi" alla tabella dell'elenco post per 'procedura'.
 * Uso l'hook nativo di WordPress per assicurare che la colonna sia registrata.
 */
add_filter( 'manage_procedura_posts_columns', 'dci_set_custom_procedura_columns' );
function dci_set_custom_procedura_columns( $columns ) {

    $nome_colonna_target = 'title';

    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        if ( $nome_colonna_target === $key ) {
            $new_columns['fasi'] = __( 'Fasi', 'design_comuni_italia' );
        }
    }    
    return $new_columns;
}

/**
 * Visualizza il contenuto per la colonna "Fasi" utilizzando il valore CMB2,
 * includendo ora i link alla pagina di modifica di ciascuna fase.
 */
add_action( 'manage_procedura_posts_custom_column', 'dci_custom_procedura_column_content', 10, 2 );
function dci_custom_procedura_column_content( $column, $post_id ) {
    
    if ( 'fasi' === $column ) {
        
        $meta_key = '_dci_procedura_fasi'; 
        $field_value = get_post_meta( $post_id, $meta_key, true );
        
        if ( ! is_array( $field_value ) || empty( $field_value ) ) {
            echo 'Nessuna fase collegata';
            return;
        }

        $fase_links = array();
        
        foreach ( $field_value as $id ) {
            $id = absint( $id ); 

            if ( $id > 0 ) {
                $title = get_the_title( $id );
                
                if ( $title ) {
                    $edit_link = get_edit_post_link( $id );
                    
                    if ( $edit_link ) {
                        $fase_links[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url( $edit_link ),
                            esc_html( $title )
                        );
                    } else {
                        $fase_links[] = esc_html( $title );
                    }
                }
            }
        }
        
        if ( empty( $fase_links ) ) {
            echo 'Nessuna fase collegata';
        } else {
            echo implode( ', ', $fase_links ); 
        }
    }
}