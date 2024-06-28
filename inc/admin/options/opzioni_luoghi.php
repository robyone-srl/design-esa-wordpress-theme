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
}