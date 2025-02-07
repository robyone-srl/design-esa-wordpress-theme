<?php
//$CSS_NAME_BOOTSTRAP = 'bootstrap-italia-custom.min.css';
$CSS_NAME_ICONS = 'icons.css';
$CSS_NAME_COMUNI = 'custom-comuni.css';

function dci_register_grafica_options(){
    global $CSS_NAME_BOOTSTRAP;
    global $CSS_NAME_ICONS;
    global $CSS_NAME_COMUNI;
    
    $prefix = '';

    /**
     * Opzioni di base
     * nome Comune, Regione, informazioni essenziali
     */
    $args = array(
        'id'           => 'dci_options_grafica',
        'title'        => esc_html__( 'Grafica', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'grafica',
        'capability'    => 'manage_theme_options',
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'tab_title'    => __('Grafica', "design_comuni_italia")
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $header_options = new_cmb2_box( $args );

    $header_options->add_field( array(
        'id' => $prefix . 'home_istruzioni',
        'name'        => __( 'Grafica', 'design_comuni_italia' ),
        'desc' => __( 'Area di configurazione della libreria grafica' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    dci_add_custom_file_field_to_box($header_options, $CSS_NAME_COMUNI, 'comuni_css_file', 'use_comuni_css');
    dci_add_custom_file_field_to_box($header_options, $CSS_NAME_ICONS, 'icons_css_file', 'use_icons_css');

    
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

    $header_options->add_field( array(
        'id' => $prefix . 'nascondi_pulsante_login',
        'name' => 'Nascondi il pulsante di login',
        'desc' => 'Nascondi il pulsante di login dalla barra superiore del sito. Sarà necessario aprire manualmente <a target="_blank" href="'.wp_login_url().'">'. wp_login_url() .'</a> per effettuare il login.',
        'type' => 'checkbox',
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
add_action( 'cmb2_save_options-page_fields_dci_options_grafica', 'custom_comuni_css_file_option_update', 10, 3 );


function load_comuni_custom_css(){
    global $CSS_NAME_COMUNI;
    $file_comuni = dci_get_custom_css_file_path($CSS_NAME_COMUNI);
    if(file_exists($file_comuni))
        wp_register_style( 'dci-bootstrap-italia-min', dci_get_custom_css_file_url($CSS_NAME_COMUNI));

}
add_action('wp_enqueue_scripts', 'load_comuni_custom_css');

function custom_icons_css_file_option_update(string $object_id, array $updated, CMB2 $cmb) {
    global $CSS_NAME_ICONS;
    if(!isset($cmb->data_to_save['use_icons_css'])){
        unlink(dci_get_custom_css_file_path($CSS_NAME_ICONS));
        wp_deregister_style('dci-icons');
    }

    $uploaded_css =  $_FILES['icons_css_file']['tmp_name'] ?? false;

    if(is_uploaded_file($uploaded_css)){
        $file = dci_get_custom_css_file_path($CSS_NAME_ICONS);

        wp_mkdir_p(dci_get_custom_css_folder_path($CSS_NAME_ICONS));
        
        move_uploaded_file($uploaded_css, $file);
    }
}
add_action( 'cmb2_save_options-page_fields_dci_options_grafica', 'custom_icons_css_file_option_update', 10, 3 );


function load_icons_custom_css(){
    global $CSS_NAME_ICONS;
    $file_icone = dci_get_custom_css_file_path($CSS_NAME_ICONS);
    if(file_exists($file_icone))
        wp_register_style( 'dci-icons', dci_get_custom_css_file_url($CSS_NAME_ICONS));

}
add_action( 'wp_enqueue_scripts', 'load_icons_custom_css' );
