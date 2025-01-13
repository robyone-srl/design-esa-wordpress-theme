<?php

function dci_register_footer_options(){
    $prefix = '';

    /**
     * Opzioni Footer
     */
    $args = array(
        'id'           => 'dci_options_footer',
        'title'        => esc_html__( 'Footer', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'footer',
        'tab_title'    => __('Footer', "design_comuni_italia"),
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'capability'    => 'manage_theme_options',
    );

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $footer_options = new_cmb2_box( $args );

    $footer_options->add_field( array(
        'id' => $prefix . 'footer_options',
        'name'        => __( 'Footer', 'design_comuni_italia' ),
        'desc' => __( 'Area di configurazione del footer.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );

    $footer_options->add_field( array(
        'id'   => $prefix . 'media_policy',
        'name' => __( 'Media Policy', 'design_comuni_italia' ),
        'desc' => __( 'Link alla Media Policy', 'design_comuni_italia' ),
        'type' => 'text_url',
    ) );

    $footer_options->add_field( array(
        'id' => $prefix . 'sitemap',
        'name'        => __( 'Mappa del sito', 'design_comuni_italia' ),
        'desc'        => __( 'Link alla Mappa del sito', 'design_comuni_italia' ),
        'type' => 'text_url',
    ) );

    $footer_options->add_field(array(
        'name' => __('Contatta la casa di riposo', ''),
        'id' => $prefix . 'visualizzaContatto',
        'desc' => __('Abilita o disabilita <b>Contatta la casa di riposo</b>', ''),
        'type' => 'radio_inline',
        'default' => 'visible',
        'options' => array(
            'visible' => 'Visibile',
			'hidden'   => 'Nascosto',
        ),
    ));

    $footer_options->add_field( array(
        'id' => $prefix . '$contacts_options',
        'name'        => __( 'Contattaci', 'design_comuni_italia' ),
        'desc' => __( 'Area di configurazione della visualizzazione personalizzata dei contatti a pie di pagina.' , 'design_comuni_italia' ),
        'type' => 'title',
    ) );


    $footer_options->add_field(array(
        'name' => __('Tipo di visualizzazione contatti', ''),
        'id' => $prefix . 'contattaci_tipo',
        'desc' => __('Abilita o disabilita la visualizzazione personalizzata', ''),
        'type' => 'radio_inline',
        'default' => 'tutte',
        'options' => array(
            'tutte' => 'Non visualizzare',
			'filtro'   => 'Scelta personalizzata',
        ),
    ));

    $footer_options->add_field(array(
        'name' => __('Contatti da visualizzare', 'design_comuni_italia'),
        'desc' => __('Scegli quali contatti mostrare nella sezione contattaci.', 'design_comuni_italia'),
        'id' => $prefix . 'contattaci_contenuto',
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('punto_contatto'),
        'attributes'    => array(
            'placeholder' =>  __( ' Seleziona i Punti di Contatto', 'design_comuni_italia' ),
            'data-conditional-id' => 'contattaci_tipo',
            'data-conditional-value'  => 'filtro',
        ),
    ));
     
}