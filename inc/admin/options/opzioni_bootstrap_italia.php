<?php

function dci_register_bootstrap_italia_options(){
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
        'tab_group'    => 'dci_options',
        'tab_title'    => __('Bootstrap Italia', "design_comuni_italia"),
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
        'name'        => __( 'Bootstrap Italia', 'design_comuni_italia' ),
        'desc' => __( 'Area di configurazione delle informazioni di Bootstrap Italia' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $header_options->add_field( array(
        'id'    => $prefix . 'boostrap_css',
        'name' => __('Boostrap css', 'design_comuni_italia' ),
        'desc' => __( 'Customizzazione del foglio di stile <strong>bootstrap-italia.min.css</strong> per personalizzare la grafica del sito. <br> <strong>Nota</strong>. Se il campo é vuoto viene utilizzato quello di default presente nel tema' , 'design_comuni_italia' ),
        'type' => 'textarea'
    ));
}


function custom_bi_css_file_option_update(string $object_id, array $updated, CMB2 $cmb) {

    if(array_key_exists("boostrap_css", $cmb->data_to_save)){
        $css =  $cmb->data_to_save["boostrap_css"];
        $file = get_theme_file_path( '/assets/css/bootstrap-italia-custom.min.css');

        if(empty($css)){
            $response =  unlink($file);
        }
        else{
            $myfile = fopen($file, "w");
            fwrite($myfile, $css);
            fclose($myfile);
        }

    }
}
add_action( 'cmb2_save_options-page_fields_dci_options_bootstrap_italia', 'custom_bi_css_file_option_update', 10, 3 );


function load_bi_custom_css(){
    $file_boostrap = get_theme_file_path( '/assets/css/bootstrap-italia-custom.min.css');
    if(file_exists($file_boostrap))
        wp_register_style( 'dci-boostrap-italia-min', get_template_directory_uri() . '/assets/css/bootstrap-italia-custom.min.css');

}
add_action( 'wp_enqueue_scripts', 'load_bi_custom_css' );
