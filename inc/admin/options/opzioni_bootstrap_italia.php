<?php
$CSS_NAME_BOOTSTRAP = 'bootstrap-italia-custom.min.css';
$CSS_NAME_ICONS = 'icons.css';

function dci_register_bootstrap_italia_options(){
    global $CSS_NAME_BOOTSTRAP;
    global $CSS_NAME_ICONS;
    
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
        'capability'    => 'manage_theme_options',
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

    add_custom_file_field_to_box($header_options, $CSS_NAME_BOOTSTRAP, 'bootstrap_italia_css_file', 'use_bootstrap_italia_css');
    add_custom_file_field_to_box($header_options, $CSS_NAME_ICONS, 'icons_css_file', 'use_icons_css');
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




function custom_icons_css_file_option_update(string $object_id, array $updated, CMB2 $cmb) {
    global $CSS_NAME_ICONS;
    if(!isset($cmb->data_to_save['use_icons_css'])){
        unlink(get_custom_css_file_path($CSS_NAME_ICONS));
        wp_deregister_style('dci-icons');
    }

    $uploaded_css =  $_FILES['icons_css_file']['tmp_name'] ?? false;

    if(is_uploaded_file($uploaded_css)){
        $file = get_custom_css_file_path($CSS_NAME_ICONS);

        wp_mkdir_p(get_custom_css_folder_path($CSS_NAME_ICONS));
        
        move_uploaded_file($uploaded_css, $file);
    }
}
add_action( 'cmb2_save_options-page_fields_dci_options_bootstrap_italia', 'custom_icons_css_file_option_update', 10, 3 );


function load_icons_custom_css(){
    global $CSS_NAME_ICONS;
    $file_icone = get_custom_css_file_path($CSS_NAME_ICONS);
    if(file_exists($file_icone))
        wp_register_style( 'dci-icons', get_custom_css_file_url($CSS_NAME_ICONS));

}
add_action( 'wp_enqueue_scripts', 'load_icons_custom_css' );
