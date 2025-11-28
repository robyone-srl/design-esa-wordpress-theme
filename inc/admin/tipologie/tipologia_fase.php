<?php
/**
 * Definisce post type Fase
 */
add_action( 'init', 'dci_register_post_type_fase', 60 );
function dci_register_post_type_fase() {

    $labels = array(
        'name'          => _x( 'Fasi', 'Post Type General Name', 'design_comuni_italia' ),
        'singular_name' => _x( 'Fase', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new'       => _x( 'Aggiungi una Fase', 'Post Type Singular Name', 'design_comuni_italia' ),
        'add_new_item'  => _x( 'Aggiungi una nuova Fase', 'Post Type Singular Name', 'design_comuni_italia' ),
        'edit_item'       => _x( 'Modifica la Fase', 'Post Type Singular Name', 'design_comuni_italia' ),
        'featured_image' => __( 'Immagine di riferimento', 'design_comuni_italia' ),
    );
    $args   = array(
        'label'         => __( 'Fase', 'design_comuni_italia' ),
        'labels'        => $labels,
        'supports'      => array( 'title', 'editor', 'author', 'thumbnail'),
        'hierarchical'  => false,
        'public'        => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-clock',
        'has_archive'   => true,
        'rewrite' => array('slug' => 'fase','with_front' => false),
        'capability_type' => array('fase', 'fasi'),
        'map_meta_cap'    => true,
    );
    register_post_type('fase', $args );

    remove_post_type_support( 'fase', 'editor');
}

/**
 * Aggiungo label sotto il titolo
 */
add_action( 'edit_form_after_title', 'dci_fase_add_content_after_title' );
function dci_fase_add_content_after_title($post) {
    if($post->post_type == "fase")
        _e('<span><i>il <b>Titolo</b> è il <b>Titolo della Fase</b>.</i></span><br><br>', 'design_comuni_italia' );
}

add_action( 'cmb2_init', 'dci_add_fase_metaboxes' );
function dci_add_fase_metaboxes() {
    $prefix = '_dci_fase_';

    //TEMPI E SCADENZE
    $cmb_dati = new_cmb2_box( array(
        'id'           => $prefix . 'box_dati',
        'title'        => __( 'Dati fase o scadenza', 'design_comuni_italia' ),
        'object_types' => array( 'fase' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_dati->add_field( array(
        'name'       => __('Titolo *', 'design_comuni_italia' ),
        'desc'       => __('Esempio: "Iscrizione alla gita" oppure "Pagamento della gita"', 'design_comuni_italia' ),
        'id'         => $prefix . 'titolo_fase',
        'type'       => 'text',
        'attributes' => array(
            'required'            => true
        )
    ) );
    
    $cmb_dati->add_field( array(
        'name'       => __('Data', 'design_comuni_italia' ),
        'desc'       => __('Data', 'design_comuni_italia' ),
        'id'         => $prefix . 'data_fase',
        'type'       => 'text_date',
        'date_format' => 'd-m-Y',
    ) );
    
    $cmb_dati->add_field(array(
        'name'       => __('Descrizione', 'design_comuni_italia' ),
        'id'         => $prefix . 'desc_fase',
        'type'       => 'wysiwyg',
    ) );

    //Servizi inclusi
    $cmb_dati->add_field( array(
        'id' => $prefix . 'servizi_inclusi',
        'name'    => __( 'Servizi inclusi ', 'design_comuni_italia' ),
        'desc' => __( 'Seleziona i servizi riguardanti questa fase' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('servizio'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i servizi inclusi', 'design_comuni_italia' ),
        )
    ) );

    //DOCUMENTI
    $cmb_documenti = new_cmb2_box( array(
        'id'           => $prefix . 'box_documenti',
        'title'        => __( 'Documenti', 'design_comuni_italia' ),
        'object_types' => array( 'fase' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );

    $cmb_documenti->add_field( array(
        'id' => $prefix . 'documenti',
        'name'        => __( 'Documenti', 'design_comuni_italia' ),
        'desc' => __( 'Link alle schede documenti correlati.' , 'design_comuni_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dci_get_posts_options('documento_pubblico'),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona i Documenti Pubblici', 'design_comuni_italia' ),
        ),
    ) );

    //Contatti
    $cmb_contatti = new_cmb2_box( array(
        'id'           => $prefix . 'box_contatti',
        'title'        => 'Contatti',
        'object_types' => array( 'fase' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $cmb_contatti->add_field( array(
        'id'        => $prefix . 'unita_responsabile',
        'name'      => 'Unita&grave; Organizzativa responsabile',
        'desc'      => 'Link dell\'ufficio resposanbile' ,
        'type'      => 'pw_select',
        'options'   => dci_get_posts_options('unita_organizzativa'),
        'attributes' => array(
            'placeholder'   =>  'Seleziona le Unità Organizzative',
        )
    ) );

    $cmb_contatti->add_field( array(
        'id'        => $prefix . 'punti_contatto',
        'name'      => 'Contatti dedicati',
        'desc'      => 'Telefono, mail o altri punti di contatto a cui rivolgersi per ulteriori informazioni',
        'type'      => 'pw_multiselect',
        'options'   => dci_get_posts_options('punto_contatto'),
        'attributes'    => array(
            'placeholder' =>  'Seleziona i Punti di Contatto',
        ),
    ) );


    //RELATIONSHIPS INVERSE: PROCEDURE COLLEGATE
    $cmb_relazioni_inverse = new_cmb2_box( array(
        'id'           => $prefix . 'box_relazioni_inverse',
        'title'        => __( 'Procedure Collegate', 'design_comuni_italia' ),
        'object_types' => array( 'fase' ),
        'context'      => 'normal',
        'priority'     => 'low',
    ) );

    $cmb_relazioni_inverse->add_field( array(
        'id'           => $prefix . 'procedure_collegate',
        'name'         => __( 'Procedure collegate a questa Fase', 'design_comuni_italia' ),
        'desc'         => __( 'Queste sono le procedure in cui questa fase è stata selezionata', 'design_comuni_italia' ),
        'type'         => 'pw_multiselect',
        'options'      => dci_get_posts_options('procedura'),
    ) );
}

function set_to_current_fase_procedure($field_args, $field  ) {
	return dci_get_meta("procedure_collegate", "_dci_fase_", $field->object_id) ?? [];
}

add_action( 'save_post_fase', 'dci_handle_fase_to_procedura_group_update', 10, 2 );

function dci_handle_fase_to_procedura_group_update( $fase_id, $fase_post ) {
    
    $fase_id_int = absint($fase_id);
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $fase_id ) ) { return; }

    $meta_key_fase_collegate  = '_dci_fase_procedure_collegate';
    $meta_key_procedura_group = '_dci_procedura_fasi_raggruppate';
    $sub_key_fase_id          = 'fase_selezionata';

    $nuove_procedure_raw = isset( $_POST[ $meta_key_fase_collegate ] ) 
        ? (array) $_POST[ $meta_key_fase_collegate ]
        : array(); 
    $nuove_procedure_collegate = array_filter( array_map( 'absint', $nuove_procedure_raw ) );

    $vecchie_procedure_collegate = array_filter( array_map( 'absint', (array) get_post_meta( $fase_id, $meta_key_fase_collegate, true ) ) );
    
    $procedure_da_processare = array_unique(
        array_merge( $vecchie_procedure_collegate, $nuove_procedure_collegate )
    );
    
    foreach ( $procedure_da_processare as $procedura_id ) {
        
        wp_cache_delete( $procedura_id, 'post_meta' ); 
        
        $gruppo_fasi = get_post_meta( $procedura_id, $meta_key_procedura_group, true );
        $gruppo_fasi = is_array( $gruppo_fasi ) ? $gruppo_fasi : array();
        
        $is_collegata_ora = in_array( $procedura_id, $nuove_procedure_collegate, true ); 
        
        $fase_trovata_precedentemente = false;
        $gruppo_fasi_filtrato = []; 
        
        foreach ( $gruppo_fasi as $row ) {
            
            $row_fase_id = isset( $row[ $sub_key_fase_id ] ) ? absint( $row[ $sub_key_fase_id ] ) : 0;
            
            if ( (string) $row_fase_id === (string) $fase_id_int ) {
                
                if ( $is_collegata_ora ) {
                    $gruppo_fasi_filtrato[] = $row;
                }
                $fase_trovata_precedentemente = true;
                
            } else {
                $gruppo_fasi_filtrato[] = $row;
            }
        }
        
        if ( $is_collegata_ora && ! $fase_trovata_precedentemente ) {
            $gruppo_fasi_filtrato[] = [
                $sub_key_fase_id      => $fase_id,
                'count_giorni' => '',
                'type_count_giorni' => '',
                'scadenza_fase' => '',
                'type_date' => '',
            ];
        }
        
        update_post_meta( $procedura_id, $meta_key_procedura_group, $gruppo_fasi_filtrato );
    }
    
    update_post_meta( $fase_id, $meta_key_fase_collegate, $nuove_procedure_collegate );
}
/**
 * Funzione di callback per formattare la colonna "Procedure Collegate" (bidirezionale).
 * Prende l'array di ID dalla relazione bidirezionale e li trasforma in link cliccabili.
 */
function dci_fase_procedure_collegate_column_format( $field_value, $field_args, $field ) {
    if ( ! is_array( $field_value ) || empty( $field_value ) ) {
        return '';
    }

    $procedure_links = array();
    
    foreach ( $field_value as $p_id ) {
        $id = absint( $p_id ); 

        if ( $id > 0 ) {
            $title = get_the_title( $id );
            
            if ( $title ) {
                $edit_link = get_edit_post_link( $id );
                
                if ( $edit_link ) {
                    $procedure_links[] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( $edit_link ),
                        esc_html( $title )
                    );
                } else {
                    $procedure_links[] = esc_html( $title );
                }
            }
        }
    }
    
    return implode( ', ', $procedure_links ); 
}

/**
 * 1. Registra la colonna "Come fare per" nella tabella delle Fasi.
 * Hook: manage_fase_posts_columns
 */
add_filter( 'manage_fase_posts_columns', 'dci_set_fase_inverse_columns' );
function dci_set_fase_inverse_columns( $columns ) {

    $nome_colonna_target = 'author';

    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        
        if ( $nome_colonna_target === $key ) { 
            $new_columns['procedure_collegate_inv'] = __( 'Come fare per', 'design_comuni_italia' );
        }
    }
    
    return $new_columns;
}

/**
 * 2. Visualizza il contenuto per la colonna "Come fare per".
 * Hook: manage_fase_posts_custom_column
 */
add_action( 'manage_fase_posts_custom_column', 'dci_render_fase_inverse_column_content', 10, 2 );
function dci_render_fase_inverse_column_content( $column, $post_id ) {
    
    if ( 'procedure_collegate_inv' === $column ) {
        
        $meta_key = '_dci_fase_procedure_collegate'; 

        $field_value = get_post_meta( $post_id, $meta_key, true );
        
        if ( ! is_array( $field_value ) || empty( $field_value ) ) {
            echo '';
            return;
        }

        $procedure_links = array();
        
        foreach ( $field_value as $p_id ) {
            $id = absint( $p_id ); 

            if ( $id > 0 ) {
                $title = get_the_title( $id );
                
                if ( $title ) {
                    $edit_link = get_edit_post_link( $id );
                    
                    if ( $edit_link ) {
                        $procedure_links[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url( $edit_link ),
                            esc_html( $title )
                        );
                    } else {
                        $procedure_links[] = esc_html( $title );
                    }
                }
            }
        }
        
        echo implode( ', ', $procedure_links ); 
    }
}