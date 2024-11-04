<?php
$CSS_NAME_COMUNI = 'custom-comuni.css';

function dci_register_comune_options(){
    global $CSS_NAME_COMUNI;
    $prefix = '';

    /**
     * Opzioni di base
     * nome Comune, Regione, informazioni essenziali
     */
    $args = array(
        'id'           => 'dci_options_configurazione',
        'title'        => esc_html__( 'Configurazione', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'dci_options',
        'tab_group'    => 'dci_options',
        'tab_title'    => __('Configurazione Ente', "design_comuni_italia"),
        'capability'    => 'manage_theme_options',
        'position'        => 2, // Menu position. Only applicable if 'parent_slug' is left empty.
        'icon_url'        => 'dashicons-admin-tools', // Menu icon. Only applicable if 'parent_slug' is left empty.
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $header_options = new_cmb2_box( $args );

    $header_options->add_field( array(
        'id' => $prefix . 'home_istruzioni',
        'name'        => __( 'Configurazione Ente', 'design_comuni_italia' ),
        'desc' => __( 'Area di configurazione delle informazioni di base' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $header_options->add_field( array(
        'id' => $prefix . 'nome_comune',
        'name'        => __( 'Nome dell\'Ente *', 'design_comuni_italia' ),
        'desc' => __( 'Il Nome dell\'Ente' , 'design_comuni_italia' ),
        'type' => 'text',
        'attributes'    => array(
            'required'    => 'required'
        ),
    ) );

    $header_options->add_field( array(
        'id' => $prefix . 'nome_regione',
        'name'        => __( 'Nome amministrazione afferente *', 'design_comuni_italia' ),
        'desc' => __( 'Il territorio nel quale opera l\'Ente o l\'amministrazione di riferimento (comune, ente locale, provincia, regione)' , 'design_comuni_italia' ),
        'type' => 'text',
        'attributes'    => array(
            'required'    => 'required'
        ),
    ) );

    $header_options->add_field( array(
        'id' => $prefix . 'url_sito_regione',
        'name'        => __( 'Sito afferente', 'design_comuni_italia' ),
        'desc' => __( 'Link al sito dell\'amministrazione afferente' , 'design_comuni_italia' ),
        'type' => 'text_url',
        'attributes'    => array(
            'required'    => 'required'
        ),
    ) );

    $header_options->add_field( array(
        'id' => $prefix . 'motto_comune',
        'name'        => __( 'Motto dell\'Ente', 'design_comuni_italia' ),
        'desc' => __( 'Il Motto dell\'Ente, viene visualizzato sotto il nome' , 'design_comuni_italia' ),
        'type' => 'text',
    ));

    $header_options->add_field( array(
        'id'    => $prefix . 'stemma_comune',
        'name' => __('Stemma', 'design_comuni_italia' ),
        'desc' => __( 'Lo stemma dell\'Ente. Si raccomanda di caricare un\'immagine in formato svg' , 'design_comuni_italia' ),
        'type' => 'file',
        'query_args'   => array(
        'type' => array(
            'image/svg',
        ))
    ));

    $header_options->add_field( array(
        'id'    => $prefix . 'stemma_comune_mobile',
        'name' => __('Stemma per mobile', 'design_comuni_italia' ),
        'desc' => __( 'Utilizzare questo campo per caricare un\'immagine alternativa dello stemma dell\'Ente visibile dal menu hamburger (mobile). Si raccomanda di caricare un\'immagine in formato svg' , 'design_comuni_italia' ),
        'type' => 'file',
        'query_args'   => array(
            'type' => array(
                'image/svg',
            ))
    ));

    $header_options->add_field( array(
        'id'    => $prefix . 'favicon',
        'name' => __('Icona', 'design_comuni_italia' ),
        'desc' => __( 'L\'immagine da utilizzare come icona (favicon). Si raccomanda di caricare un\'immagine in formato svg' , 'design_comuni_italia' ),
        'type' => 'file',
        'query_args'   => array(
        'type' => array(
            'image/svg',
        ))
    ));

    $header_options->add_field( array(
        'id' => $prefix . 'nascondi_pulsante_login',
        'name' => 'Nascondi il pulsante di login',
        'desc' => 'Nascondi il pulsante di login dalla barra superiore del sito. Sarà necessario aprire manualmente <a target="_blank" href="'.wp_login_url().'">'. wp_login_url() .'</a> per effettuare il login.',
        'type' => 'checkbox',
    ) );

    dci_add_custom_file_field_to_box($header_options, $CSS_NAME_COMUNI, 'comuni_css_file', 'use_comuni_css');
    
    $header_options->add_field( array(
        'id' => $prefix . 'home_istruzioni_barra_chiara_scura',
        'name'        => __( 'Tema barra di navigazione', 'design_comuni_italia' ),
        'desc' => __( 'Scegli il tema chiaro o scuro per le barre di navigazione' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $header_options->add_field( array(
        'id' => $prefix . 'tema_chiaro_nav_superiore',
        'name' => 'Barra di navigazione superiore',
        'desc' => "Scegli il tema della barra più alta nella pagina del sito, che contiene l'amministrazione afferente e il pulsante di login.",
        'type' => 'radio_inline',
        'options' => [
            '' => 'Scuro',
            'chiaro' => "Chiaro"
        ],
        'default' => ''
    ) );

    $header_options->add_field( array(
        'id' => $prefix . 'tema_chiaro_nav_intestazione',
        'name' => 'Barra di intestazione',
        'desc' => "Scegli il tema della barra che contiene il nome e logo dell'ente.",
        'type' => 'radio_inline',
        'options' => [
            '' => 'Scuro',
            'chiaro' => "Chiaro"
        ],
        'default' => ''
    ) );
    
    $header_options->add_field( array(
        'id' => $prefix . 'tema_chiaro_nav_principale',
        'name' => 'Barra di navigazione principale',
        'desc' => "Scegli il tema della barra di navigazione principale",
        'type' => 'radio_inline',
        'options' => [
            '' => 'Scuro',
            'chiaro' => "Chiaro"
        ],
        'default' => ''
    ) );
}


function custom_comuni_css_file_option_update(string $object_id, array $updated, CMB2 $cmb) {
    global $CSS_NAME_COMUNI;
    if(!isset($cmb->data_to_save['use_comuni_css'])){
        unlink(dci_get_custom_css_file_path($CSS_NAME_COMUNI));
    }

    $uploaded_css =  $_FILES['comuni_css_file']['tmp_name'] ?? false;

    if(is_uploaded_file($uploaded_css)){
        $file = dci_get_custom_css_file_path($CSS_NAME_COMUNI);

        wp_mkdir_p(dci_get_custom_css_folder_path($CSS_NAME_COMUNI));
        
        move_uploaded_file($uploaded_css, $file);
    }
}
add_action( 'cmb2_save_options-page_fields_dci_options_configurazione', 'custom_comuni_css_file_option_update', 10, 3 );


function load_comuni_custom_css(){
    global $CSS_NAME_COMUNI;
    $file_comuni = dci_get_custom_css_file_path($CSS_NAME_COMUNI);
    if(file_exists($file_comuni))
        wp_register_style( 'dci-comuni', dci_get_custom_css_file_url($CSS_NAME_COMUNI));

}
add_action('wp_enqueue_scripts', 'load_comuni_custom_css');