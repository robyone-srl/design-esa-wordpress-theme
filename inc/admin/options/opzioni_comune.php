<?php

function dci_register_comune_options(){
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
        'capability'    => 'manage_options',
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
    'id'    => $prefix . 'comuni_css',
    'name' => __('Comuni css', 'design_comuni_italia' ),
    'desc' => __('Customizzazione del foglio di stile <strong>comuni.css</strong> per personalizzare la grafica del sito. <br> <strong>Nota</strong>. Se il campo é vuoto viene utilizzato quello di default presente nel tema' , 'design_comuni_italia' ),
    'type' => 'textarea'
));

}


function custom_comuni_css_file_option_update(string $object_id, array $updated, CMB2 $cmb) {

    if(array_key_exists("comuni_css", $cmb->data_to_save)){
        $css =  $cmb->data_to_save["comuni_css"];
        $file = get_theme_file_path( '/assets/css/comuni-custom.css');

        if(empty($css))
            unlink($file);
        else{
            $myfile = fopen($file, "w");
            fwrite($myfile, stripslashes($cmb->data_to_save["comuni_css"]));
            fclose($myfile);
        }

    }
}
add_action( 'cmb2_save_options-page_fields_dci_options_configurazione', 'custom_comuni_css_file_option_update', 10, 3 );


function load_comuni_custom_css(){
    $file_comuni = get_theme_file_path( '/assets/css/comuni-custom.css');
    if(file_exists($file_comuni))
        wp_register_style( 'dci-comuni', get_template_directory_uri() . '/assets/css/comuni-custom.css');

}
add_action( 'wp_enqueue_scripts', 'load_comuni_custom_css' );
