<?php

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'dci_page_add_content_after_title' );
function dci_page_add_content_after_title($post) {
    if($post->post_type == "page")
        _e('<span><i>il <b>Titolo</b> è il <b>Titolo della Pagina</b>.</i></span><br><br><br> ', 'design_comuni_italia' );
}

/**
* Crea i metabox del post type page
*/
add_action( 'cmb2_init', 'dci_add_page_metaboxes' );
function dci_add_page_metaboxes() {
    $prefix = '_dci_page_';

    $cmb_descrizione = new_cmb2_box( array(
    'id'           => $prefix . 'box_descrizione',
    'object_types' => array( 'page' ),
    'context'      => 'after_title',
    'priority'     => 'high',
    ) );

    $args =  array(
        'id' => $prefix . 'descrizione',
        'name'        => __( 'Descrizione *', 'design_comuni_italia' ),
        'desc'        => __( 'Una breve descrizione compare anche nella card di presentazione della pagina', 'design_comuni_italia' ),
        'type'             => 'textarea',
        'attributes' => array(
            'required' => 'required',
            'maxlength' => 255
        ),
    );

    //Recupero Template Name
    global $pagenow, $template_name;
    if (( $pagenow == 'post.php' ) || (get_post_type() == 'post')) {

        if(isset($_GET['post']))
            $curr_page_id = $_GET['post'];
        else if(isset($_POST['post_ID']))
            $curr_page_id = $_POST['post_ID'];

        if ( ! isset( $curr_page_id ) ) {
            return;
        }

        $slug = get_post_field( 'post_name', $curr_page_id );

        // Get the name of the Page Template file.
        $template_file = get_post_meta( $curr_page_id, '_wp_page_template', true );
        $template_name = basename($template_file, ".php");
        

        /**
         * disabilito editor body e title per le pagine del Sito dei Comuni
         * rendo il campo descrivione_breve readonly
         
        if (in_array($template_name, dci_get_pagine_template_names())) {

            remove_post_type_support( 'page', 'editor' );

            remove_post_type_support( 'page', 'title' );

            $args['attributes'] = array(
                'required' => 'required',
                'maxlength' => 255,
                'readonly' => true
            );
        }
        */
        

    }

    $cmb_descrizione->add_field($args);
    
    //argomenti
    $cmb_argomenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_argomenti',
        'title'        => __( 'Argomenti', 'design_comuni_italia' ),
        'object_types' => array( 'page' ),
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

    if($template_name == 'punti-di-contatto'){

        //Contatti in evidenza
        $cmb_contatti = new_cmb2_box(array(
            'id'           => $prefix . 'box_contatti_evidenza',
            'object_types' => array( 'page' ),
            'context'      => 'after_title',
            'priority'     => 'low',
        ));
        $cmb_contatti->add_field(array(
            'id'      => $prefix . 'vedi_info_principali',
            'name'   => __( 'Informazioni principali', 'design_comuni_italia' ),
            'desc'        => __( ' Visualizza la sezione <b>dati fiscali e di contatto</b>', 'design_comuni_italia' ),
            'type' => 'radio_inline',
            'default' => 'false',
            'options' => array(
                'true'    => 'Attivo',
                'false'     => 'Disattivo',
            ),
        ));
        $cmb_contatti->add_field(array(
            'id'      => $prefix . 'contatti_evidenza',
            'name'   => __( 'Contatti in evidenza', 'design_comuni_italia' ),
            'desc'        => __( ' Inserisci i contatti in evidenza', 'design_comuni_italia' ),
            'type'    => 'pw_multiselect',
            'options' => dci_get_posts_options('punto_contatto'),
        ));
    }

    if($template_name == 'unita-organizzative'){

        $cmb_uo = new_cmb2_box( array(
            'id'           => $prefix . 'box_uo',
            'title'        => __( 'Filtra in base al tipo di unità organizzativa', 'design_comuni_italia' ),
            'object_types' => array( 'page' ),
            'context'      => 'normal',
            'priority'     => 'high',
        ) );

        $cmb_uo->add_field( array(
            'id'      => $prefix . 'uo_select',
            'name'    => __( 'Scegli cosa mostrare', 'design_comuni_italia' ),
            'type'    => 'radio_inline',
            'options' => array(
                'tutti'  => 'Tutti i tipi di unità organizzativa',
                'scegli' => 'Scegli il tipo di unità organizzativa',
            ),
            'default' => 'tutti',
        ) );

        $cmb_uo->add_field( array(
            'id'               => $prefix . 'uo_tipo',
            'name'             => __( 'Tipo di organizzazione *', 'design_comuni_italia' ),
            'type'             => 'taxonomy_radio_hierarchical',
            'taxonomy'         => 'tipi_unita_organizzativa',
            'show_option_none' => false,
            'remove_default'   => 'true',
            'attributes'       => [
			    'data-conditional-id'    => $prefix.'uo_select',
			    'data-conditional-value' => 'scegli',
            ]
        ) );
    }


    if($template_name == 'incarichi' || $template_name == 'persone-incaricate'){

        $cmb_i = new_cmb2_box( array(
            'id'           => $prefix . 'box_tipo_incarico',
            'title'        => __( 'Filtra in base al tipo di incarico', 'design_comuni_italia' ),
            'object_types' => array( 'page' ),
            'context'      => 'normal',
            'priority'     => 'high',
        ) );

        $cmb_i->add_field( array(
            'id'      => $prefix . 'filtro_tipo_incarico_select',
            'name'    => __( 'Scegli cosa mostrare', 'design_comuni_italia' ),
            'type'    => 'radio_inline',
            'options' => array(
                'tutti'  => 'Mostra tutti i tipi di incarico',
                'scegli' => 'Scegli il tipo di incarico',
            ),
            'default' => 'tutti',
        ) );

        $cmb_i->add_field( array(
            'id'               => $prefix . 'tipo_incarico',
            'name'             => __( 'Tipo incarico *', 'design_comuni_italia' ),
            'type'             => 'taxonomy_radio_hierarchical',
            'taxonomy'         => 'tipi_incarico',
            'show_option_none' => false,
            'remove_default'   => 'true',
            'attributes'       => [
			    'data-conditional-id'    => $prefix.'filtro_tipo_incarico_select',
			    'data-conditional-value' => 'scegli',
            ]
        ) );
    }
    if($template_name == 'default'){

        //CONTATTI
        $cmb_contatti = new_cmb2_box( array(
            'id'           => $prefix . 'box_contatti',
            'title'        => __( 'Contatti', 'design_comuni_italia' ),
            'object_types' => array( 'page' ),
            'context'      => 'normal',
            'priority'     => 'high',
        ) );

        $cmb_contatti->add_field( array(
            'id' => $prefix . 'unita_responsabile',
            'name'    => __( 'Unità Organizzativa responsabile', 'design_comuni_italia' ),
            'desc' => __( 'Link dell\'ufficio resposanbile dell\'erogazione di questo Servizio' , 'design_comuni_italia' ),
            'type'    => 'pw_select',
            'options' => dci_get_posts_options('unita_organizzativa'),
            'attributes' => array(
                'placeholder' =>  __( 'Seleziona le Unità Organizzative', 'design_comuni_italia' ),
            )
        ) );

        $cmb_contatti->add_field( array(
            'id' => $prefix . 'punti_contatto',
            'name'        => __( 'Contatti dedicati', 'design_comuni_italia' ),
            'desc' => __( 'Telefono, mail o altri punti di contatto che sono specifici di questo servizio, diversi da quello dell\'ufficio indicato sopra<br><a href="post-new.php?post_type=punto_contatto">Inserisci Punto di Contatto</a>' , 'design_comuni_italia' ),
            'type'    => 'pw_multiselect',
            'options' => dci_get_posts_options('punto_contatto'),
            'attributes'    => array(
                'placeholder' =>  __( 'Seleziona i Punti di Contatto', 'design_comuni_italia' ),
            ),
        ) );
    }
}

/**
 * disabilito quick edit del titolo per le pagine del Sito dei Comuni
 * @param $actions
 * @param $post
 * @return mixed

function dci_page_row_actions( $actions, $post ) {

    //se la pagina ha slug tra le pagine create all'attivazione del tema
    if ( 'page' === $post->post_type && in_array ($post->post_name, dci_get_pagine_slugs())) {

        // Removes the "Quick Edit" action.
        unset( $actions['inline hide-if-no-js'] );
    }
    return $actions;
}
add_filter( 'page_row_actions', 'dci_page_row_actions', 10, 2 ); 
*/