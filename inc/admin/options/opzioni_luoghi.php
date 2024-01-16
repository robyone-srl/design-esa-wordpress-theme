<?php

function dci_register_luoghi_options(){
    $prefix = '';

    /**
     * Opzioni Luoghi
     */
    $args = array(
        'id'           => 'dci_options_luoghi',
        'title'        => esc_html__( 'Luoghi', 'design_comuni_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'luoghi',
        'capability'    => 'manage_theme_options',
        'parent_slug'  => 'dci_options',
        'tab_group'    => 'dci_options',
        'tab_title'    => __('Luoghi', "design_comuni_italia"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dci_options_display_with_tabs';
    }

    $luoghi_options = new_cmb2_box( $args );

    $luoghi_options->add_field( array(
        'id' => $prefix . 'strutture_luoghi',
        'name'        => __( 'Seleziona le tipologie di luoghi  da mostrare', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona le tipologie di luoghi che vuoi mostrare. ' , 'design_comuni_italia' ),
        'type'           => 'taxonomy_multicheck_hierarchical',
        'taxonomy'       => 'tipi_luogo',
        'attributes' => array(
            'placeholder' =>  __( ' Seleziona e ordina le tipologie di luoghi da mostrare nella pagina Luoghi', 'design_comuni_italia' ),
            'required'    => 'required'
        ),
    ) );

    $luoghi_options->add_field(array(
        'id' => $prefix . 'posizione_mappa',
        'name' => __('Visualizza mappa', 'design_scuole_italia'),
        'desc' => __('Seleziona <b>Si</b> per visualizzare la mappa nella pagina di elenco dei luoghi.', 'design_comuni_italia'),
        'type' => 'radio_inline',
        'default' => 'false',
        'options' => array(
            'true' => __('Si', 'design_scuole_italia'),
            'false' => __('No', 'design_scuole_italia'),
        ),
    ));
}