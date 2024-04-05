<?php

/**
 * Definisce post type Notizia
 */
add_action( 'init', 'dci_register_post_type_notizia');
function dci_register_post_type_notizia() {

    $labels = array(
        'name'          => _x( 'Notizie', 'Post Type General Name', 'design_comuni_italia' ),
        'singular_name' => _x( 'Notizia', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new'       => _x( 'Aggiungi una Notizia', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new_item'  => _x( 'Aggiungi una nuova Notizia', 'Post Type Singular Name', 'design_comuni_italia' ),
        'edit_item'       => _x( 'Modifica la Notizia', 'Post Type Singular Name', 'design_comuni_italia' ),
        'featured_image' => __( 'Immagine di riferimento', 'design_comuni_italia' ),
    );
    $args   = array(
        'label'         => __( 'Notizia', 'design_comuni_italia' ),
        'labels'        => $labels,
        'supports'      => array( 'title', 'editor', 'author', 'thumbnail' ),
        'hierarchical'  => false,
        'public'        => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-media-interactive',
        'has_archive'   => false,
        //'rewrite' => array('slug' => 'novita/%tipi_notizia%','with_front' => false),
        'rewrite' => array('slug' => 'novita','with_front' => false),
        'capability_type' => array('notizia', 'notizie'),
        'map_meta_cap'    => true,
        'description'    => __( "Tipologia che struttura le informazioni relative a agli aggiornamenti d un comune", 'design_comuni_italia' ),
    );
    register_post_type('notizia', $args );

    remove_post_type_support( 'notizia', 'editor');
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'dci_notizia_add_content_after_title' );
function dci_notizia_add_content_after_title($post) {
    if($post->post_type == "notizia")
        _e('<span><i>il <b>Titolo</b> è il <b>Titolo della Notizia o del Comunicato</b>.</i></span><br><br>', 'design_comuni_italia' );
}

add_action( 'cmb2_init', 'dci_add_notizia_metaboxes' );
function dci_add_notizia_metaboxes() {
    $prefix = '_dci_notizia_';

    //argomenti
    $cmb_argomenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_argomenti',
        'title'        => __( 'Argomenti *', 'design_comuni_italia' ),
        'object_types' => array( 'notizia' ),
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
        'object_types' => array( 'notizia' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'tipo_notizia',
        'name'        => __( 'Tipo di notizia *', 'design_comuni_italia' ),
        'type'             => 'taxonomy_radio_hierarchical',
        'taxonomy'       => 'tipi_notizia',
        'show_option_none' => false,
        'remove_default' => 'true',
        'attributes'    => array(
            'required'    => 'required'
        ),
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'numero_comunicato',
        'name'        => __( 'Numero progressivo comunicato stampa', 'design_comuni_italia' ),
        'desc' => __( 'Se è un comunicato stampa, indica un\'eventuale numero progressivo del comunicato stampa' , 'design_comuni_italia' ),
        'type' => 'text',
        'attributes'    => array(
            'maxlength'  => '255',
            'data-conditional-id'     => $prefix.'tipo_notizia',
            'data-conditional-value'  => 'comunicato-stampa',
        ),
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'a_cura_di',
        'name'    => __( 'A cura di *', 'design_comuni_italia' ),
        'desc' => __( 'Ufficio che ha curato il comunicato (presumibilmente l\'ufficio comunicazione)' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('unita_organizzativa'),
        'attributes'    => array(
            'required'    => 'required',
            'placeholder' =>  __( 'Seleziona le unità organizzative', 'design_comuni_italia' ),
        ),
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'descrizione_breve',
        'name'        => __( 'Descrizione breve *', 'design_comuni_italia' ),
        'desc' => __( 'Descrizione sintentica della notizia, inferiore a 255 caratteri' , 'design_comuni_italia' ),
        'type' => 'textarea',
        'attributes'    => array(
            'maxlength'  => '255',
            'required'    => 'required'
        ),
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'data_scadenza',
        'name'    => __( 'Data di scadenza', 'design_comuni_italia' ),
        'desc' => __( 'Eventuale data di scadenza (dalla quale la notizia non sarà più visibile). Eventuali allegati resteranno comunque raggiungibili attraverso l\'URL.' , 'design_comuni_italia' ),
        'type'    => 'text_date_timestamp',
        'date_format' => 'd-m-Y',
    ) );

    $cmb_apertura->add_field( array(
        'id' => $prefix . 'persone',
        'name'    => __( 'Persone', 'design_comuni_italia' ),
        'desc' => __( 'Riferimenti a persone dell\'amministrazione citate nella notizia' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('persona_pubblica'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona le Persone Pubbliche', 'design_comuni_italia' ),
        ),
    ) );
    $cmb_apertura->add_field( array(
        'id' => $prefix . 'luoghi',
        'name'    => __( 'Luoghi', 'design_comuni_italia' ),
        'desc' => __( 'Riferimenti a luoghi dell\'Ente citati nella notizia' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('luogo'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Luoghi', 'design_comuni_italia' ),
        ),
    ) );

    //CORPO
    $cmb_corpo = new_cmb2_box( array(
        'id'           => $prefix . 'box_corpo',
        'title'        => __( 'Corpo', 'design_comuni_italia' ),
        'object_types' => array( 'notizia' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    $cmb_corpo->add_field( array(
        'id' => $prefix . 'testo_completo',
        'name'        => __( 'Testo completo della notizia *', 'design_comuni_italia' ),
        'desc' => __( 'Testo principale della notizia' , 'design_comuni_italia' ),
        'type' => 'wysiwyg',
        'attributes'    => array(
            'required'    => 'required'
        ),
        'options' => array(
            'textarea_rows' => 10, // rows="..."
            'teeny' => false, // output the minimal editor config used in Press This
        ),
    ) );

    //MEDIA
    $cmb_gallerie_multimediali = new_cmb2_box( array(
        'id'           => $prefix . 'box_gallerie_multimediali',
        'title'        => __( 'Gallerie multimediali', 'design_comuni_italia' ),
        'object_types' => array( 'notizia' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_gallerie_multimediali->add_field( array(
        'id'         => $prefix . 'gallery',
        'name'       => __( 'Galleria di immagini', 'design_comuni_italia' ),
        'desc'       => __( 'Una o più immagini corredate da didascalie', 'design_comuni_italia' ),
        'type' => 'file_list',
        'query_args' => array( 'type' => 'image' ),
    ) );

    $cmb_gallerie_multimediali->add_field( array(
        'id'         => $prefix . 'video',
        'name'       => __( 'Video', 'design_comuni_italia' ),
        'desc'       => __( 'Un video da collegare alla notizia (è possibile inserire un url esterno).', 'design_comuni_italia' ),
        'type' => 'file',
        'query_args' => array( 'type' => 'video' ),
    ) );

    $cmb_gallerie_multimediali->add_field( array(
        'id'         => $prefix . 'trascrizione',
        'name'       => __( 'Trascrizione', 'design_comuni_italia' ),
        'desc'       => __( 'Trascrizione del video', 'design_comuni_italia' ),
        'type' => 'textarea'
    ) );

    //DOCUMENTI
    $cmb_documenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_documenti',
        'title'        => __( 'Documenti', 'design_comuni_italia' ),
        'object_types' => array( 'notizia' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );

    $cmb_documenti->add_field( array(
        'id' => $prefix . 'documenti',
        'name'        => __( 'Documenti', 'design_comuni_italia' ),
        'desc' => __( 'Link a schede di Documenti' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('documento_pubblico'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Documenti Pubblici', 'design_comuni_italia' ),
        ),
    ) );

    $cmb_documenti->add_field( array(
        'id' => $prefix . 'allegati',
        'name'        => __( 'Allegati', 'design_comuni_italia' ),
        'desc' => __( 'Elenco di documenti allegati alla struttura' , 'design_comuni_italia' ),
        'type' => 'file_list',
    ) );

    //DATASET
    $cmb_documenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_documenti',
        'title'        => __( 'Documenti', 'design_comuni_italia' ),
        'object_types' => array( 'notizia' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );

    $cmb_documenti->add_field( array(
        'id' => $prefix . 'dataset',
        'name'        => __( 'Dataset ', 'design_comuni_italia' ),
        'desc' => __( 'Lista schede Dataset collegate alla notizia' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('dataset'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Dataset', 'design_comuni_italia' ),
        ),
    ) );

}


/**
 * aggiungo js per controllo compilazione campi
 */

add_action( 'admin_print_scripts-post-new.php', 'dci_notizia_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'dci_notizia_admin_script', 11 );

function dci_notizia_admin_script() {
    global $post_type;
    if( 'notizia' == $post_type )
        wp_enqueue_script( 'notizia-admin-script', get_template_directory_uri() . '/inc/admin-js/notizia.js' );
}

/**
 * Valorizzo il post content in base al contenuto dei campi custom
 * @param $data
 * @return mixed
 */
function dci_notizia_set_post_content( $data ) {

    if($data['post_type'] == 'notizia') {

        $descrizione_breve = '';
        if (isset($_POST['_dci_notizia_descrizione_breve'])) {
            $descrizione_breve = $_POST['_dci_notizia_descrizione_breve'];
        }

        $testo_completo = '';
        if (isset($_POST['_dci_notizia_testo_completo'])) {
            $testo_completo = $_POST['_dci_notizia_testo_completo'];
        }

        $content = $descrizione_breve.'<br>'.$testo_completo;

        $data['post_content'] = $content;
    }

    return $data;
}
add_filter( 'wp_insert_post_data' , 'dci_notizia_set_post_content' , '99', 1 );


/**
 * aggiungo il cron per cambiare lo stato alle notizie quando scadono
 */

add_action('after_switch_theme', 'dsi_cron_notizie');

function dsi_cron_notizie()
{
    if (!wp_next_scheduled('dsi_cron_notizie_daily')) {
        wp_schedule_event(time(), 'daily', 'dsi_cron_notizie_daily');
    }
}

add_action('dsi_cron_notizie_daily', 'dsi_check_notizie_daily');

function dsi_check_notizie_daily()
{
    $date = new DateTime();
    $date->setTime(0, 0); // removes the time part and leaves only the date part

    // cerco tutte le notizie con data di scadenza passata
    $args = array(
        "post_type" => "notizia",
        "numberposts" => -1,
        'meta_query'  => array(
            array(
                'key' => '_dci_notizia_data_scadenza',
                'value' => $date->getTimestamp(),
                'compare' => '<=',
                'type' => 'numeric'
            )
        )
    );
    $scaduti = get_posts($args);

    foreach ($scaduti as $item) {
        $post = array('ID' => $item->ID, 'post_status' => "private");
        wp_update_post($post);
    }
}