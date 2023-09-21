<?php
$CSS_NAME_BOOTSTRAP = 'bootstrap-italia-custom.min.css';

function dci_register_bootstrap_italia_options(){
    global $CSS_NAME_BOOTSTRAP;
    $prefix = '';

    /**
     * Opzioni di base
     * nome Comune, Regione, informazioni essenziali
     */
    $args = array(
        'id'           => 'dci_options_bootstrap_italia',
        'title'        => esc_html__( 'Bootstrap Italia', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'bootstrap_italia',
    	'capability'    => 'manage_options',
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'tab_title'    => __('Bootstrap Italia', "design_comuni_italia")
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $header_options = new_cmb2_box( $args );

    $header_options->add_field( array(
        'id' => $prefix . 'home_istruzioni',
        'name'        => __( 'Bootstrap Italia', 'design_comuni_italia' ),
        'desc' => __( 'Area di configurazione delle informazioni di Bootstrap Italia' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );



    if(file_exists(get_custom_css_file_path($CSS_NAME_BOOTSTRAP))){
        $header_options->add_field( array(
            'name' => 'Stile personalizzato - Bootstrap Italia',
            'desc' => 'Al momento, è in uso un foglio di stile personalizzato al posto di <strong>bootstrap-italia-comuni.min.css</strong>. Per tornare a usare quello predefinito, disabilita questa opzione e salva le modifiche.',
            'id'   => 'use_bootstrap_italia_css',
            'type' => 'checkbox',
            'default' => 'on'
        ));
    }
    else{

        $header_options->add_field( array(
        'id'    => $prefix . 'bootstrap_italia_css_file',
        'name' => __('Stile personalizzato - Bootstrap Italia', 'design_comuni_italia' ),
        'desc' => __('Customizzazione del foglio di stile <strong>bootstrap-italia-comuni.min.css</strong> per personalizzare la grafica del sito. <br> <strong>Nota</strong>. Se il campo è vuoto viene utilizzato quello di default presente nel tema' , 'design_comuni_italia' ),
        'type' => 'css_file'
        ));
    }
}


function custom_bi_css_file_option_update(string $object_id, array $updated, CMB2 $cmb) {
    global $CSS_NAME_BOOTSTRAP;
    if(!isset($cmb->data_to_save['use_bootstrap_italia_css'])){
        unlink(get_custom_css_file_path($CSS_NAME_BOOTSTRAP));
    }

    $uploaded_css =  $_FILES['bootstrap_italia_css_file']['tmp_name'] ?? false;

    if(is_uploaded_file($uploaded_css)){
        $file = get_custom_css_file_path($CSS_NAME_BOOTSTRAP);

        wp_mkdir_p(get_custom_css_folder_path($CSS_NAME_BOOTSTRAP));
        
        move_uploaded_file($uploaded_css, $file);
    }
}
add_action( 'cmb2_save_options-page_fields_dci_options_bootstrap_italia', 'custom_bi_css_file_option_update', 10, 3 );


function load_bi_custom_css(){
    global $CSS_NAME_BOOTSTRAP;
    $file_comuni = get_custom_css_file_path($CSS_NAME_BOOTSTRAP);
    if(file_exists($file_comuni))
        wp_register_style( 'dci-bootstrap-italia-min', get_custom_css_file_url($CSS_NAME_BOOTSTRAP));

}
add_action( 'wp_enqueue_scripts', 'load_bi_custom_css' );
