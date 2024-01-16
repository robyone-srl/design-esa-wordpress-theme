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
}