<?php

function dci_register_contatti_options(){
    $prefix = '';

    $args = array(
        'id'           => 'dci_options_contatti',
        'title'        => esc_html__( 'Dati fiscali e di contatto', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'contatti',
        'tab_title'    => __('Dati fiscali e di contatto', "design_comuni_italia"),
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'capability'    => 'manage_theme_options',
    );

// 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $contatti_options = new_cmb2_box( $args );

    $contatti_options->add_field( array(
        'id' => $prefix . 'contatti_options',
        'name'        => __( 'Dati fiscali e contatti e di contatto', 'design_comuni_italia' ),
        'desc' => __( 'Configura i dati che verranno mostrati nel sito (ad esempio: pié di pagina)' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );
    $contatti_options->add_field( array(
        'id' => $prefix . 'indirizzo',
        'name' => 'Indirizzo',
        'type' => 'text',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'CF',
        'name' => 'Codice fiscale',
        'type' => 'text',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'PIVA',
        'name' => 'Partita IVA',
        'type' => 'text',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'PEC',
        'name' => 'Posta Elettronica Certificata (PEC)',
        'type' => 'text_email',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'cuf',
        'name' => 'Codice Unico di Fatturazione (CUF)',
        'type' => 'text',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'cipa',
        'name' => 'Codice Indice delle Pubbliche Amministrazioni (IPA)',
        'type' => 'text',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'scheda_URP',
        'name'    => __( 'Ufficio Relazioni con il Pubblico (URP)', 'design_comuni_italia' ),
        'desc' => __( 'Link alla scheda dell\'Ufficio Relazioni con il Pubblico' , 'design_comuni_italia' ),
        'type'    => 'pw_select',
        'options' => dci_get_posts_options('unita_organizzativa'),
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'numero_verde',
        'name'        => __( 'Numero Verde', 'design_comuni_italia' ),
        'type' => 'text_medium',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'SMS_Whatsapp',
        'name'        => __( 'SMS e Whatsapp', 'design_comuni_italia' ),
        'type' => 'text_medium',
    ) );

    $contatti_options->add_field( array(
        'id' => $prefix . 'centralino_unico',
        'name'        => __( 'Centralino unico', 'design_comuni_italia' ),
        'type' => 'text_medium',
    ) );
}