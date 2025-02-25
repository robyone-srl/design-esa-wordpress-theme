<?php

/**
 * attivazione del Tema
 */
function dci_theme_activation() {
    // controllo se è una prima installazione
    $dci_has_installed = get_option("dci_has_installed");
    if(!$dci_has_installed){
        // preparo immagini di repertorio
        prepareDefaultMediaCollection();
    
        // inserisco i termini di tassonomia
        insertCustomTaxonomyTerms();
    
        //inserisco le descrizioni di default per la tassonomia Argomenti
        updateArgomentiDescription();
    
        //inserisco le descrizioni di default per la tassonomia Categorie di Servizio
        updateCategorieServizio();
        
        //inserisco le descrizioni di default per la tassonomia Tipi di Documento
        updateTipiDocumento();
    
        //inserisco le descrizioni di default per la tassonomia Tipi di Notizia
        updateCategorieNotizia();
    
        //creo le pagine
        insertPages($pagine = dci_get_pagine_obj());
    
        //creo i permessi e le capabilites
        createCapabilities();
    
        //creo i menu
        createMenu();    
    }

    global $wp_rewrite;
    $wp_rewrite->init(); //important...

    $wp_rewrite->set_tag_base("argomenti" );
    $wp_rewrite->flush_rules();

    update_option("dci_has_installed", true);

    // disabilito i commenti per i nuovi post
    if( '' != get_option( 'default_comment_status' ) ) {
        update_option( 'default_comment_status', '' );
    }

}
add_action( 'after_switch_theme', 'dci_theme_activation' );

function dci_reload_theme_option_page() {
    if(isset($_GET["action"]) && $_GET["action"] == "reload"){
        dci_theme_activation();
    }

    echo "<div class='wrap'>";
    echo '<h1>Ricarica i dati di attivazione del tema</h1>';

    echo '<a href="themes.php?page=reload-data-theme-options&action=reload" class="button button-primary">Ricarica i dati di attivazione (menu, tipologie, etc)</a>';
    echo "</div>";
}
function dci_add_update_theme_page() {
    add_theme_page( 'Ricarica i dati', 'Ricarica i dati', 'edit_theme_options', 'reload-data-theme-options', 'dci_reload_theme_option_page' );
}
add_action( 'admin_menu', 'dci_add_update_theme_page' );

function prepareDefaultMediaCollection() {
    $strJsonFileContents = file_get_contents(get_stylesheet_directory()."/inc/comuni_immagini.json");
    // Convert to array
    $immagini_source = json_decode($strJsonFileContents, true);
    $immagini = $immagini_source['immagini'];
    $data_caricamento_immagini = $immagini_source['data_caricamento_immagini'];
    $temp_dir = get_temp_dir();


    // it allows us to use download_url() and wp_handle_sideload() functions
	require_once( ABSPATH . 'wp-admin/includes/file.php' );

    foreach($immagini as $immagine) {
        

        if($immagine['path-type'] == "child") {
            $image_url = get_stylesheet_directory()."/assets/img/repertorio/".$immagine['url'];

            $basename = basename($image_url);
            $temp_url = $temp_dir . $basename;

            $copyresult = copy($image_url, $temp_url);
        } else {
            // download to temp dir
            $temp_url = download_url( $image_url );

            if( is_wp_error( $image_url ) ) {
                //console_log('FILE NOT FOUND IN ASSETS');
                continue;
            }

            $basename = basename($temp_url);
        }

        $target_src = wp_upload_dir()['baseurl'] . '/' . _wp_relative_upload_path('') . $data_caricamento_immagini . '/' . $basename;
        $target_id = attachment_url_to_postid( $target_src );

        if($target_id != 0) continue;

        // move the temp file into the uploads directory
        $file = array(
            'name'     => $basename,
            'type'     => mime_content_type( $temp_url ),
            'tmp_name' => $temp_url,
            'size'     => filesize( $temp_url ),
        );

        
        $sideload = wp_handle_sideload(
            $file,
            array(
                'test_form'   => false // no needs to check 'action' parameter
            ),
            $data_caricamento_immagini
        );

        if( ! empty( $sideload[ 'error' ] ) ) {
            //console_log('ERROR SAVING FILE');
            continue;
        }

        // it is time to add our uploaded image into WordPress media library
        $attachment_id = wp_insert_attachment(
            array(
                'guid'           => $sideload[ 'url' ],
                'post_mime_type' => $sideload[ 'type' ],
                'post_title'     => $immagine['title'],
                'post_excerpt'   => $immagine['caption'],
                'post_content'    => $immagine['description'],
                'post_status' => 'inherit'
            ),
            $sideload[ 'file' ]
        );

        if( is_wp_error( $attachment_id ) || ! $attachment_id ) {
            return false;
        }

        // update medatata, regenerate image sizes
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        wp_update_attachment_metadata(
            $attachment_id,
            wp_generate_attachment_metadata( $attachment_id, $sideload[ 'file' ] )
        );

        update_post_meta(
            $attachment_id,
            '_wp_attachment_image_alt',
            $immagine['alt-text']
        );
    }
}


/**
 * inserimento ricorsivo dei termini di tassonomia
 * @param $array
 * @param $tax_name
 * @param null $parent_id
 */
function recursionInsertTaxonomy($array, $tax_name, $parent_id = null) {
    foreach ($array as $key => $value) {
        if (!is_numeric($key)) { //se NON è numerico, ha dei figli
            if (!term_exists( $key , $tax_name)) {
                $parent = $parent_id !== null ? wp_insert_term( $key, $tax_name, array("parent" => $parent_id)) : wp_insert_term( $key, $tax_name );
                if(is_array($parent)){
                    recursionInsertTaxonomy($value, $tax_name, $parent['term_taxonomy_id']);
                }
            } else {
                //se il padre esiste già ma il figlio no (get id del padre in base al termine...)
            }
        } else {
            $parent_id !== null ? wp_insert_term( $value, $tax_name, array("parent" => $parent_id)) : wp_insert_term( $value, $tax_name);
        }
    }
}

/**
 * inserimento termini di tasssonomia
 */
function insertCustomTaxonomyTerms() {

    /**
     * inserimento termini di tassonomia
     */

    /**
     * Argomenti
     */
    $argomenti_array = dci_argomenti_array();
    recursionInsertTaxonomy($argomenti_array, 'argomenti');

    /**
     * Tipi di Luogo
     */
    $tipi_luogo_array = dci_luoghi_array();
    recursionInsertTaxonomy($tipi_luogo_array, 'tipi_luogo');

    /**
     * Tipi di Notizia
     */
    $tipi_notizia_array = dci_tipi_notizia_array();
    recursionInsertTaxonomy($tipi_notizia_array, 'tipi_notizia');

    /**
     * Tipi di Evento
     */
    $tipi_evento_array = dci_tipi_evento_array();
    recursionInsertTaxonomy($tipi_evento_array, 'tipi_evento');

    /**
     * Tipi di Unità organizzativa
     */
    $tipi_unita_organizzativa_array = dci_tipi_unita_organizzativa_array();
    recursionInsertTaxonomy($tipi_unita_organizzativa_array, 'tipi_unita_organizzativa');

    /**
     * Categorie di Servizio
     */
    $categorie_servizio_array = dci_categorie_servizio_array();
    recursionInsertTaxonomy($categorie_servizio_array, 'categorie_servizio');

    /**
     * Tipi di Incarico
     */
    $tipi_incarico_array = dci_tipi_incarico_array();
    recursionInsertTaxonomy($tipi_incarico_array, 'tipi_incarico');

    /**
     * Licenze
     */
    $licenze_array = dci_licenze_array();
    recursionInsertTaxonomy($licenze_array, 'licenze');

    /**
     * Temi di un Dataset
     
    $temi_dataset_array = dci_temi_dataset_array();
    recursionInsertTaxonomy($temi_dataset_array, 'temi_dataset');
*/
    /**
     * Tipi di Punto di contatto
     */
    $tipi_punto_contatto_array = dci_tipi_punto_contatto_array();
    recursionInsertTaxonomy($tipi_punto_contatto_array, 'tipi_punto_contatto');

    /**
     * Frequenza di aggiornamento
     
    $frequenze_aggiornamento_array = dci_frequenze_aggiornamento_array();
    recursionInsertTaxonomy($frequenze_aggiornamento_array, 'frequenze_aggiornamento');
*/
    /**
     * Tipologia Documento Albo Pretorio
     
    $tipi_doc_albo_pretorio_array = dci_tipi_doc_albo_pretorio_array();
    recursionInsertTaxonomy($tipi_doc_albo_pretorio_array, 'tipi_doc_albo_pretorio');
*/
    /**
     * Eventi della vita delle Persone
    
    $eventi_vita_persone_array = dci_eventi_vita_persone_array();
    recursionInsertTaxonomy($eventi_vita_persone_array, 'eventi_vita_persone');
 */
    /**
     * Eventi della vita di un'Impresa
     
    $eventi_vita_impresa_array = dci_eventi_vita_impresa_array();
    recursionInsertTaxonomy($eventi_vita_impresa_array, 'eventi_vita_impresa');
*/
    /**
     * Stati di una Pratica
     
    $stati_pratica_array = dci_stati_pratica_array();
    recursionInsertTaxonomy($stati_pratica_array, 'stati_pratica');
*/
    /**
     * Tipi di Documento
     */
    $tipi_documento_array = dci_tipi_documento_array();
    recursionInsertTaxonomy($tipi_documento_array, 'tipi_documento');

    /**
     * sistema di valutazione (stars)
     */
    recursionInsertTaxonomy(array(0,1,2,3,4,5), 'stars');

}

/**
 * inserimento descrizioni
 */
function updateArgomentiDescription() {
    $terms =  get_terms(array(
        'taxonomy' =>'argomenti',
        'hide_empty' => false,
    ));
    
    $descriptions = dci_get_argomenti_descriptions_array();

    foreach($terms as $term){
        if(array_key_exists($term->name, $descriptions)){
            $args = array(
                'description' => $descriptions[$term->name]
            );
        } else {
            $args = array(
                'description' => 'Servizi, documenti, uffici, notizie e altre informazioni relativi a '.$term->name
            );
        }
        wp_update_term($term->term_id,'argomenti',$args);
    }
}

function updateCategorieServizio() {
    $terms =  get_terms(array(
        'taxonomy' =>'categorie_servizio',
        'hide_empty' => false,
    ));
    $descriptions = dci_get_categorie_servizio_descriptions_array();
    foreach($terms as $term){

        $args = array(
            'description' => $descriptions[$term->name]
        );
        wp_update_term($term->term_id,'categorie_servizio',$args);
    }
}

function updateTipiDocumento() {
    $terms =  get_terms(array(
        'taxonomy' =>'tipi_documento',
        'hide_empty' => false,
    ));
    $descriptions = dci_get_tipi_documento_descriptions_array();
    foreach($terms as $term){

        $args = array(
            'description' => $descriptions[$term->name]
        );
        wp_update_term($term->term_id,'tipi_documento',$args);
    }
}

function updateCategorieNotizia() {
    $terms =  get_terms(array(
        'taxonomy' =>'tipi_notizia',
        'hide_empty' => false,
    ));
    $descriptions = dci_get_categorie_notizia_descriptions_array();
    foreach($terms as $term){

        $args = array(
            'description' => $descriptions[$term->name]
        );
        wp_update_term($term->term_id,'tipi_notizia',$args);
    }
}


function updatePageDescription($page_title, $description) {
    $page= get_page_by_title( $page_title);
    if (dci_get_meta('descrizione','_dci_page_',$page->ID)==''){
        update_post_meta( $page->ID, '_dci_page_descrizione', $description );
    }
}

/**
 * inserimento pagine (ricorsivo)
 */
function insertPages($pagine, $parent_id = 0) {

    foreach ($pagine as $pagina) {
        $page_id = dci_create_page_template(__($pagina['title'],'design_comuni_italia'), $pagina['slug'], $pagina['template_name'], $parent_id );
        if (!empty($pagina['description'])){
            updatePageDescription($pagina['title'],$pagina['description']);
        }

        if (!isset($page_id)) {
            $page = get_page_by_title($pagina['title']);
            $page_id = $page->ID;
        }

        if (!empty($pagina['children']) && isset($page_id)){
            insertPages($pagina['children'],$page_id);
        }
    }
}

/**
 * creazione capabilities utente admin
 */
function createCapabilities() {

    $admins = get_role( 'administrator' );

    $custom_types = dci_get_tipologie_capabilities(); //nomi plurali dei custom post type
    $custom_types [] = 'ratings'; //aggiungo capability post type sistema di valutazione
    $custom_types [] = 'richieste_assistenza'; //aggiungo capability post type richiesta assistenza

    $caps = array("edit_","edit_others_","publish_","read_private_","delete_","delete_private_","delete_published_","delete_others_","edit_private_","edit_published_");
    foreach ($custom_types as $custom_type){
        foreach ($caps as $cap){
            $admins->add_cap( $cap.$custom_type);
        }
    }
    $custom_tax = dci_get_tassonomie_names(); //array contenente i nomi delle tassonomie custom
    $custom_tax [] = 'stars'; //aggiungo tassonomia sistema di valutazione
    $custom_tax [] = 'page_urls'; //aggiungo tassonomia sistema di valutazione

    $caps_terms = array("manage_","edit_","delete_","assign_");
    foreach ($custom_tax as $ctax){
        foreach ($caps_terms as $cap){
            $admins->add_cap( $cap.$ctax);
        }
    }
    // members cap for multisite
    $admins->add_cap( "create_roles");
    $admins->add_cap( "edit_roles");
    $admins->add_cap( "delete_roles");
    $admins->add_cap( "manage_theme_options");
}

/**
 * creazione menu
 */
function createMenu()
{
    //creo i menu
    $menu_main = dci_create_menu(__('Main Menu', "design_comuni_italia"));
    $menu_amministrazione = dci_create_menu(__('Area istituzionale', "design_comuni_italia"));
    $menu_informativa = dci_create_menu(__('Area informativa', "design_comuni_italia"));
    //$menu_novita = dci_create_menu(__('IPAB comunica', "design_comuni_italia"));
    //$menu_servizi = dci_create_menu(__('Categorie di Servizio', "design_comuni_italia"));
    //$menu_documenti = dci_create_menu(__('Tipi di Documento', "design_comuni_italia"));
    //$menu_vivere_ente =  dci_create_menu(__('Vivere l\'ente', "design_comuni_italia"));
    //$menu_documenti_dati = dci_create_menu(__('Tutti i documenti', "design_comuni_italia"));
    $menu_argomenti = dci_create_menu(__('Argomenti', 'design_comuni_italia'));
    $menu_info_1 = dci_create_menu('Info 1', 'design_comuni_italia');
    $menu_info_2 = dci_create_menu('Info 2', 'design_comuni_italia');
    $menu_barra_superiore = dci_create_menu('Barra superiore', 'design_comuni_italia');
    //$menu_footer =  dci_create_menu(__('Footer bottom', 'design_comuni_italia'));

    //aggiungo le voci

    //Main menu
    dci_create_page_menu_item(__( 'Servizi', 'design_comuni_italia'),$menu_main);
    dci_create_page_menu_item(__( 'Come fare per', 'design_comuni_italia'),$menu_main);
    dci_create_page_menu_item(__( 'Luoghi', 'design_comuni_italia'),$menu_main);
    dci_create_page_menu_item(__( "IPAB comunica", 'design_comuni_italia'),$menu_main);
    //assegno menu a header main location
    dci_add_menu_to_location($menu_main,'menu-header-main');

    //menu Informativa
    dci_create_page_menu_item(__( 'Servizi', 'design_comuni_italia'),$menu_informativa);
    dci_create_page_menu_item(__( 'Come fare per', 'design_comuni_italia'),$menu_informativa);
    dci_create_page_menu_item(__( 'Luoghi', 'design_comuni_italia'),$menu_informativa);
    dci_create_page_menu_item(__( "IPAB comunica", 'design_comuni_italia'),$menu_informativa);
    //assegno menu prima colonna footer
    dci_add_menu_to_location($menu_informativa,'menu-footer-col-1'); 

    //menu Istituzionale
    dci_create_page_menu_item(__( 'Organizzazione', 'design_comuni_italia'),$menu_amministrazione);
    dci_create_page_menu_item(__( 'Documenti', 'design_comuni_italia'),$menu_amministrazione);
    dci_create_page_menu_item(__( 'Personale', 'design_comuni_italia'),$menu_amministrazione);
    dci_create_page_menu_item(__( 'Storia', 'design_comuni_italia'),$menu_amministrazione);
    dci_create_page_menu_item(__( 'Valori e obiettivi', 'design_comuni_italia'),$menu_amministrazione);

    //assegno menu prima colonna footer
    dci_add_menu_to_location($menu_amministrazione,'menu-footer-col-2'); 

    //menu Servizi
    /* pagine di secondo livello (corrispondenza con termini dei tassonomia)
    foreach( dci_categorie_servizio_array() as $term_name) {
        dci_create_term_menu_item($term_name,'categorie_servizio',$menu_servizi);
    }*/
    //assegno menu seconda colonna footer
    //dci_add_menu_to_location($menu_servizi,'menu-footer-col-2'); // tolgo questa linea così le voci nel footer vengono generate automaticamente, ma resta l'opzione di collegare il menu alla posizione per controllarlo manualmente

    //menu Documenti
    /* pagine di secondo livello (corrispondenza con termini dei tassonomia)
    foreach( dci_tipi_documento_array() as $term_name) {
        dci_create_term_menu_item($term_name,'tipi_documento',$menu_documenti);
    }*/
    //assegno menu terza colonna footer
    //dci_add_menu_to_location($menu_documenti,'menu-footer-col-3');  // tolgo questa linea così le voci nel footer vengono generate automaticamente, ma resta l'opzione di collegare il menu alla posizione per controllarlo manualmente

    /*voci menu Novità
    dci_create_term_menu_item('notizia','tipi_notizia',$menu_novita, 'Notizie');
    dci_create_term_menu_item('comunicato stampa','tipi_notizia',$menu_novita, 'Comunicati');
    dci_create_term_menu_item('avviso','tipi_notizia',$menu_novita, 'Avvisi');
    //assegno menu quarta colonna footer (sopra)*/
    //dci_add_menu_to_location($menu_novita,'menu-footer-col-4-1'); // tolgo questa linea così le voci nel footer vengono generate automaticamente, ma resta l'opzione di collegare il menu alla posizione per controllarlo manualmente

    //voci menu Vivere ente
    /*placeholder
    dci_create_page_menu_item(__( 'Luoghi', 'design_comuni_italia'), $menu_novita);
    dci_create_page_menu_item(__( 'Eventi', 'design_comuni_italia'), $menu_novita);*/

    //assegno menu quarta colonna footer (sotto)
    //dci_add_menu_to_location($menu_novita,'menu-footer-col-4-2'); // tolgo questa linea così le voci nel footer vengono generate automaticamente, ma resta l'opzione di collegare il menu alla posizione per controllarlo manualmente

    //voci menu Argomenti (in alto a destra)
    dci_create_page_menu_item(__('Argomenti', 'design_comuni_italia'), $menu_argomenti, __('Tutti gli argomenti...','design_comuni_italia'));
    //assegna menu a posizione topright
    dci_add_menu_to_location($menu_argomenti,'menu-header-right');

    //menu info colonna 1
    //dci_create_custom_menu_item(__( 'Leggi le FAQ', 'design_comuni_italia'),$menu_info_1);
    //dci_create_archive_menu_item('domanda_frequente', $menu_info_1, __( 'Leggi le FAQ', 'design_comuni_italia'));
    dci_create_page_menu_item(__('Domande frequenti', 'design_comuni_italia'), $menu_info_1, __('Leggi le domande frequenti','design_comuni_italia'));
    dci_create_page_menu_item(__('Prenotazioni', 'design_comuni_italia'), $menu_info_1, __( 'Prenotazione appuntamento', 'design_comuni_italia'));
    dci_create_page_menu_item(__( 'Assistenza', 'design_comuni_italia'), $menu_info_1, __( 'Richiesta assistenza', 'design_comuni_italia'));
    //assegno menu a location
    dci_add_menu_to_location($menu_info_1,'menu-footer-info-1');

    //menu info colonna 2
    dci_create_custom_menu_item(__( 'Amministrazione trasparente', 'design_comuni_italia'),$menu_info_2);
    dci_create_custom_menu_item(__( 'Albo pretorio', 'design_comuni_italia'),$menu_info_2);
    dci_create_custom_menu_item(__( 'Informativa privacy', 'design_comuni_italia'),$menu_info_2);
    dci_create_custom_menu_item(__( 'Note legali', 'design_comuni_italia'),$menu_info_2);
    dci_create_custom_menu_item(__( 'Dichiarazione di accessibilità', 'design_comuni_italia'),$menu_info_2);
    //assegno menu a location
    dci_add_menu_to_location($menu_info_2,'menu-footer-info-2');


    //Menu superiore contatti
    dci_create_page_menu_item(__('Contatti', 'design_comuni_italia'),$menu_barra_superiore);
    dci_add_menu_to_location($menu_barra_superiore,'menu-barra-superiore');

    /**
    //menu footer bottom (media policy, mappa del sito)
    dci_create_custom_menu_item(__( 'Media policy','design_comuni_italia'),$menu_footer);
    dci_create_custom_menu_item(__( 'Mappa del sito','design_comuni_italia'),$menu_footer);
    //assegno menu a posizione topright
    dci_add_menu_to_location($menu_footer,'menu-footer-bottom');
    */
}

/**
 * creazione Menu
 * @param $name
 * @return mixed the id of the menu created
 */
function dci_create_menu($name) {

    wp_delete_nav_menu($name);
    $menu_object = wp_get_nav_menu_object($name);

    if ($menu_object) {
        $menu_item = $menu_object->term_id;
    } else {
        $menu_id = wp_create_nav_menu($name);
        $menu = get_term_by('id', $menu_id, 'nav_menu');
    }

    return $menu_id;
}

function dci_create_custom_menu_item($item_name,  $menu_id, $link = '#') {
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>$item_name,
        'menu-item-url' => $link,
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom', // optional
        'menu-item-attr-title' => $item_name,
    ));
}

function dci_create_page_menu_item($page_name, $menu_id ,$label = '') {
    $page= get_page_by_title( $page_name);
    $item_label =  ($label !== '') ? $label : $page_name;
    if ($page) {
       wp_update_nav_menu_item($menu_id, 0, array(
           'menu-item-title' =>$item_label,
           'menu-item-status' => 'publish',
           'menu-item-type' => 'post_type',
           'menu-item-object-id' => $page->ID,
           'menu-item-object' => 'page',
           'menu-item-attr-title' => $page->post_name
       ));
    }
}

function dci_create_archive_menu_item($post_type, $menu_id ,$label = '') {

    $item_label =  ($label !== '') ? $label : $post_type;
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => $item_label,
        'menu-item-status' => 'publish',
        'menu-item-object' => $post_type,
        'menu-item-type' => 'post_type_archive',
        'menu-item-attr-title' => $item_label
    ));
}

function dci_create_term_menu_item($term_name, $taxonomy, $menu_id, $item_label = '') {
    $term = get_term_by('name', $term_name, $taxonomy);
    if ($term){
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-status' => 'publish',
            'menu-item-type' => 'taxonomy',
            'menu-item-object-id' => $term->term_id,
            'menu-item-object' => $taxonomy,
            'menu-item-attr-title' => ($item_label != '') ? $item_label : $term->slug,
            'menu-item-title' => ($item_label != '') ? $item_label : $term->name
        ));
    }
}

function dci_add_menu_to_location($menu_id, $location_id) {
    $locations_primary_arr = get_theme_mod('nav_menu_locations');
    $locations_primary_arr[$location_id] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations_primary_arr);
    update_option('menu_check', true);
}

function dci_create_page_template($name, $slug, $template, $parent_id = '', $content = '') {

    $new_page_title    = $name;
    $new_page_content  = $content;
    $new_page_template = $template ? 'page-templates/'.$template.'.php' : '';
    $page_check        = get_page_by_title( $new_page_title);

    $new_page = array(
        'post_type'    => 'page',
        'post_title'   => $new_page_title,
        'post_content' => $new_page_content,
        'post_status'  => 'publish',
        'post_author'  => 1,
        'post_name' => $slug,
        'post_parent' => $parent_id
    );

    $new_page_id = null;
    if ( ! isset( $page_check->ID ) ) {
        $new_page_id = wp_insert_post( $new_page );
        if ( ! empty( $new_page_template ) ) {
            update_post_meta( $new_page_id, '_wp_page_template', $new_page_template );
        }
    }
    return $new_page_id;
}


function updateArgomentiImmagini() {
    $terms =  get_terms(array(
        'taxonomy' =>'argomenti',
        'hide_empty' => false,
    ));
    $imgs = dci_get_immagini_argomenti_array();

    $strJsonFileContents = file_get_contents(get_stylesheet_directory()."/inc/comuni_immagini.json");
    $immagini_source = json_decode($strJsonFileContents, true);

    foreach($terms as $term){
        if(array_key_exists($term->name, $imgs)) {
            $media_src = getSrcFromJsonImmagini($imgs[$term->name], $immagini_source);
            $media_id = getIdFromJsonImmagini($imgs[$term->name], $immagini_source);

            if($media_src == null) continue;

            update_term_meta($term->term_id, 'dci_term_immagine', $media_src);
            update_term_meta($term->term_id, 'dci_term_immagine_id', $media_id);
        }
    }
}

function getSrcFromJsonImmagini($term, $immagini_source) {
    $immagini = $immagini_source['immagini'];
    $data_caricamento_immagini = $immagini_source['data_caricamento_immagini'];
    $immagine = $immagini_source['immagini'][$term];

    $basename = basename($immagine['url']);

    $target_src = wp_upload_dir()['baseurl'] . '/' . _wp_relative_upload_path('') . $data_caricamento_immagini . '/' . $basename;
    $target_id = attachment_url_to_postid( $target_src );

    if($target_id == 0) return null;

    return $target_src;
}

function getIdFromJsonImmagini($term, $immagini_source) {
    $immagini = $immagini_source['immagini'];
    $data_caricamento_immagini = $immagini_source['data_caricamento_immagini'];
    $immagine = $immagini_source['immagini'][$term];

    $basename = basename($immagine['url']);

    $target_src = wp_upload_dir()['baseurl'] . '/' . _wp_relative_upload_path('') . $data_caricamento_immagini . '/' . $basename;
    $target_id = attachment_url_to_postid( $target_src );

    if($target_id == 0) return null;

    return $target_id;
}
