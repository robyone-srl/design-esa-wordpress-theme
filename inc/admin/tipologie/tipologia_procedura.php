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
        'name'       => 'Come fare (testo introduttivo) * ',
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

    $cmb_cosa_serve->add_field( array(
        'id'        => $prefix . 'fasi',
        'name'      => 'Lista delle fasi',
        'desc'      => 'Seleziona le fasi della procedura. <br><a href="post-new.php?post_type=fase">Inserisci Fase</a>',
        'type'      => 'pw_multiselect',
        'options' => dci_get_posts_options('fase'),
        'attributes' => array(
            'placeholder' => __( 'Seleziona le fasi della procedura', 'design_comuni_italia')
        )
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