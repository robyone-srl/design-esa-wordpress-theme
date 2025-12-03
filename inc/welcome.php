<?php

require get_template_directory() . '/inc/lib/parsedown.php';

/**
 * Welcome page
 */
remove_action('welcome_panel', 'wp_welcome_panel');
add_action( 'welcome_panel', 'dci_welcome_panel' );
function dci_welcome_panel(){
    ?>
    <div class="welcome-panel-content" style="padding-bottom:30px;">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/designers-italia-wordpress-dashboard.png'?>"  style="float:left; margin:0px 0px 20px 0px;" />
        <div class="welcome-panel-header">
            <h2><?php echo('Design Enti Socio-Assistenziali: il tema dedicato al settore socio-assistenziale'); ?></h2>
            <h3>Il tema è stato preparato da Robyone sulla base del <a href="https://github.com/italia/design-comuni-wordpress-theme">tema di Developers Italia predisposto per i Comuni Italiani</a></h3>
        </div>
    </div>
    <?php
}

function dci_welcome_init() {
    global $wpdb;
    $wpdb->update($wpdb->usermeta,array('meta_value'=>1),array('meta_key'=>'show_welcome_panel'));
}
add_action('after_switch_theme','dci_welcome_init');

/**
 * Gestione widget dashboard admin
 *
 */

// Add a new widget to the dashboard using a custom function
add_action( 'wp_dashboard_setup', 'dci_add_dashboard_widgets' );

// Register the new dashboard widget with the 'wp_dashboard_setup' action
function dci_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'dci_dashboard_widget', // Widget slug
        'Design Enti Socio-Assistenziali Italia', // Widget title
        'dci_new_dashboard_widget_function' // Function name to display the widget
    );
    wp_add_dashboard_widget(
        'dci_post_type_info_widget_widget', // Widget slug
        'Scopri i tipi di contenuto', // Widget title
        'dci_post_type_info_widget_function' // Function name to display the widget
    );
}

// Initialize the function to output the contents of your new dashboard widget
function dci_new_dashboard_widget_function() {
		$theme = wp_get_theme();
	$version = $theme->get('Version');
	$themeName = $theme->get('Name');
	echo '<p><strong>Tema: ' . $themeName . ' - Versione '. $version . '</h2></strong></p>';
    echo "<p>Il tema applicato è una personalizzazione di WordPress basato sul modello architetturale predisposto per gli Enti socio-assistenziali da Robyone. <br /> Tema e modello sono stati predisposti prendendo in considerazione e riadattando quelli previsti da <a href=\"https://designers.italia.it/\">Agenzia per l'Italia Digitale - Designers Italia</a> per i <a href=\"https://designers.italia.it/modelli/comuni/\" target=\"_blank\">Comuni Italiani</a>";
    echo "<p>Entrambe le risorse sono entrambe aperte al miglioramento continuo con l’obiettivo di arrivare ad una proposta valida e di riferimento anche per altri Enti che volessero aggiungersi all’iniziativa. Gli aggiornamenti sono rilasciati con medesima licenza del tema nazionale.</p>";
    echo "<p><a href=\"https://github.com/robyone-srl/design-esa-wordpress-theme\" target=\"_blank\">Documentazione del tema ESA e lista delle novità per ogni versione rilasciata (su Github)</a></p>";
}

// Initialize the function to output the contents of your new dashboard widget
function dci_post_type_info_widget_function() {
    echo "<p>Un buon contenuto risponde alle domande che può farsi una persona che visita una pagina web in cerca di informazioni. Le domande possono variare in base alla tipologia di contenuto e nel tema ne sono già previsti di diversi per soddisfare i bisogni delle persone che visitano il tuo sito. Utilizzare la tipologia di contenuto corretta è fondamentale per garantire che il sito sia utile e navigabile, riportiamo le tipologie principali di seguito.</p>";

    // Categoria 1: Struttura e Organizzazione dell'Ente
    echo "<h3><strong>Struttura e organizzazione</strong></h3>";
    echo "<ul>";
    echo "<li><strong>Unità organizzativa</strong>, entità con uno scopo organizzativo e competenze specifiche (es. ufficio, organo di governo, area);</li>";
    echo "<li><strong>Persona pubblica</strong>, informazioni di base sulle singole persone che operano nell'Ente (e hanno uno o più <i>incarichi</i>);</li>";
    echo "<li><strong>Incarico</strong>, ruolo specifico all'interno dell'Ente assunto da una <i>Persona</i> (es. direttore, coordinatore, consigliere);</li>";
    echo "<li><strong>Luogo</strong>, per gli ambienti fisici rilevanti per l'Ente come le sedi, i nuclei e gli ambienti legati ai servizi;</li>";
    echo "<li><strong>Punto di contatto</strong>, per riunire i canali di contatto tra loro correlati (telefono, email, PEC) ed evitare duplicazioni.</li>";
    echo "</ul>";

    // Categoria 2: Comunicazione e Novità
    echo "<h3><strong>Comunicazione e novità</strong></h3>";
    echo "<ul>";
    echo "<li><strong>Notizia</strong>, per tutte le comunicazioni e aggiornamenti, come avvisi e comunicati stampa;</li>";
    echo "<li><strong>Evento</strong>, per promuovere avvenimenti con date e orari precisi e creare un calendario;</li>";
    echo "<li><strong>Sito tematico</strong>, per collegare la pagina iniziale o una sezione di un sito esterno (es. amministrazione trasparente, portale whistleblowing).</li>";
    echo "</ul>";

    // Categoria 3: Servizi e Supporto all'Utenza
    echo "<h3><strong>Servizi e supporto all'utenza</strong></h3>";
    echo "<ul>";
    echo "<li><strong>Servizio</strong>, per i servizi erogati (anche quelli digitali), dal soggiorno residenziale al taglio dei capelli e ai pagamenti digitali;</li>";
    echo "<li><strong>Documento pubblico</strong>, per le informazioni documentali prodotte dall'Ente, dallo statuto ai regolamenti e al giornalino;</li>";
    echo "<li><strong>Domanda frequente (FAQ)</strong>, per fornire supporto veloce agli utenti riguardo le richieste più frequenti.</li>";
    echo "</ul>";

    echo "<p>Puoi leggere la <a href=\"https://github.com/robyone-srl/design-esa-wordpress-theme\" target=\"_blank\">documentazione completa del tema su Github</a></p>";
}

/**
 * Mostra solo i metabox del progetto
 */
function dci_remove_all_dashboard_meta_boxes()
{
    global $wp_meta_boxes;

    $keep_boxes = array();
    foreach ($wp_meta_boxes['dashboard']['normal']['core'] as $wp_meta_box) {
        if (substr($wp_meta_box["id"], 0, 4) == "dci_") {
            $keep_boxes[] = $wp_meta_box;
        }
    }
    $wp_meta_boxes['dashboard']['normal']['core'] = $keep_boxes;

    $keep_boxes = array();
    foreach ($wp_meta_boxes['dashboard']['side']['core'] as $wp_meta_box) {
        if (substr($wp_meta_box["id"], 0, 4) == "dci_") {
            $keep_boxes[] = $wp_meta_box;
        }
    }
    $wp_meta_boxes['dashboard']['side']['core'] = $keep_boxes;
}
add_action('wp_dashboard_setup', 'dci_remove_all_dashboard_meta_boxes', 100 );

/**
 * Forzo a 2 colonne la dashboard admin
 * @param $columns
 * @return mixed
 */
function dci_screen_layout_columns($columns) {
    $columns['dashboard'] = 2;
    return $columns;
}
add_filter('screen_layout_columns', 'dci_screen_layout_columns');

function dci_screen_layout_dashboard() {
    return 2;
}
add_filter('get_user_option_screen_layout_dashboard', 'dci_screen_layout_dashboard');

add_action ('admin_menu', function () {
  //  add_management_page('Manuale Tema ESA', 'Manuale Tema ESA', 'read', 'manuale-esa', 'dci_readme_render_manual', '');
});

function dci_readme_render_manual(){
echo '<div class="wrap manuale">';

    $response = wp_remote_get( 'https://raw.githubusercontent.com/robyone-srl/design-esa-wordpress-theme/main/README.md' );

    if ( is_array( $response ) && ! is_wp_error( $response ) ) {

        $body    = $response['body']; // use the content
        $Parsedown = new Parsedown();
        echo $Parsedown->text($body);

    }

echo "</div>";
}
add_action('admin_bar_menu', 'dci_add_toolbar_manual', 100);
function dci_add_toolbar_manual($admin_bar)
{
    $admin_bar->add_menu(array(
        'id' => 'norme_riferimenti',
        'title' => 'Norme e riferimenti',
        'href' => 'https://designers.italia.it/norme-e-riferimenti/',
        'meta' => array(
            'title' => __('La documentazione ufficiale che ti guida nella progettazione per la Pubblica Amministrazione, mettendo le persone al centro'),
            'target' => '_blank'
        ),
    ));
}

add_action('admin_bar_menu', 'dci_add_toolbar_data_filler', 100);

function dci_add_toolbar_data_filler($admin_bar) {
    /*
    define('COMUNI_PAGINE_TEST',jsonToArray(get_template_directory()."/inc/pagine_prova.json")['pagine_test']);

    echo "<pre>";
        print_r(COMUNI_PAGINE_TEST);
    echo "</pre>";
    */
    $admin_bar->add_menu(array(
        'id'    => 'auto_fill',
        'title' => 'Inserimento automatico',
        'href'  => admin_url('admin-ajax.php?action=inserimento_info_prova'),
        'meta'  => array(
            'title' => 'Inserimento automatico di alcune informazioni',
        ),
    ));
}

function inserimento_info_prova() {
    
    define('COMUNI_PAGINE_TEST',jsonToArray(get_template_directory()."/inc/pagine_prova.json")['pagine_test']);
    /*
    echo "<pre>";
        print_r(COMUNI_PAGINE_TEST);
    echo "</pre>";*/

    //Array degli ID
    $id_contatto = array();
    $id_uo = array();
    $id_luogo = array();
    $id_servizio = array();
    $id_fase = array();

    function seleziona_oggetti($sorgente, $indici){
        $ids_selezionati = [];

        foreach ($indici as $indice) {
            if (isset($sorgente[$indice])) {
                $ids_selezionati[] = $sorgente[$indice];
            }
        }
        return $ids_selezionati;
    }

    //Settings ENTE
    update_option('dci_options', array_merge(get_option('dci_options', array()), array(
        'nome_comune' => 'San Camillo de Lellis',
        'nome_regione' => 'Regione Veneto',
        'url_sito_regione' => 'https://www.regione.veneto.it/',
        'motto_comune' => 'Istituzione Pubblica di Assistenza e Beneficenza (IPAB)'
    )));
    
    //Settings Contatti ENTE
    update_option('contatti', array_merge(get_option('contatti', array()), array(
        'indirizzo' => 'Viale Giorgio Ribotta, 5, 00144 Roma',
        'CF' => '0044110067',
        'PIVA' => '0044110067',
        'PEC' => 'pec@ipabsancamillo.it',
        'cuf' => 'c0044f',
        'cipa' => 'ipabscl',
        'centralino_unico' => '0437001672'
    )));

    //Settings Homepage
    update_option('homepage', array_merge(get_option('homepage', array()), array(
        'hero_title' => 'Benvenuto',
        'hero_description' => 'Siamo una istituzione IPAB',
        'hero_button_title' => 'Chi siamo',
        'hero_button_link' => '#'
    )));
    $options = get_option( 'homepage' );  
    $options['notizie_in_home'] = 3;  
    update_option( 'homepage', $options ); 

    //Settings footer
    $option_name = 'footer';
    update_option($option_name, array_merge(get_option($option_name, array()), array(
        'media_policy' => '#',
        'sitemap' => '#'
    )));
    $options = get_option( $option_name );  
    $options['visualizzaContatto'] = 'visible';  
    update_option( $option_name, $options ); 

    $options = get_option( $option_name );  
    $options['contattaci_tipo'] = 'tutte';  
    update_option( $option_name, $options ); 

    //Settings servizi
    $option_name = 'servizi';
    update_option($option_name, array_merge(get_option($option_name, array()), array(
        'titolo_banner_secondario' => 'Servizi per gli ospiti',
        'login_messaggio' => 'Da qui puoi accedere ai diversi servizi della casa di riposo che richiedono una autenticazione personale.'
    )));
    $options = get_option( $option_name );  
    $options['visual_servizi_inclusi'] = 'titolo';  
    update_option( $option_name, $options );

    $options = get_option( $option_name );  
    $options['visual_servizi_necessari'] = 'titolo';  
    update_option( $option_name, $options );
    
    $options = get_option( $option_name );  
    $options['categorie_banner_secondario'] = array('Servizi per gli ospiti');  
    update_option( $option_name, $options );

    $options = get_option( $option_name );  
    $options['categorie_esplora_tipo'] = 'tutte';  
    update_option( $option_name, $options );

    $options = get_option( $option_name );  
    $options['prenota_appuntamento'] = '';  
    update_option( $option_name, $options );

    $options = get_option( $option_name );  
    $options['richiedi_assistenza'] = '';  
    update_option( $option_name, $options );

    //Settings vivi
    $option_name = 'vivi';
    update_option($option_name, array_merge(get_option($option_name, array()), array(
        'gallery_title' => 'Le nostre foto'
    )));
    $options = get_option( $option_name );  
    $options['vivi_visualizzazione_eventi'] = 'in-evidenza';  
    update_option( $option_name, $options );

    $options = get_option( $option_name );  
    $options['vivi_visualizzazione_luoghi'] = 'true';  
    update_option( $option_name, $options );

    //Settings IPAB comunica
    $options = get_option( 'comunica' );  
    $options['notizie_in_comunica'] = 3;  
    update_option( 'comunica', $options ); 

 
    if ( !current_user_can('publish_pages') ) {
        wp_send_json_error('Non hai i permessi per creare una pagina.');
    }

    foreach(COMUNI_PAGINE_TEST as $pagina) {
        if ( empty($pagina['post_title']) || empty($pagina['post_type']) ) {
            wp_send_json_error('Il titolo o il tipo di post mancano per una delle voci.');
        }

        $pagina_post = array(
            'post_title'    => $pagina['post_title'],
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'post_type'     => $pagina['post_type'],
        );

        $post_id = wp_insert_post($pagina_post);
        if (!$post_id) {
            wp_send_json_error('Errore nella creazione del post: ' . print_r($pagina_post, true));
        }

        switch ($pagina['post_type']) {
	        case 'punto_contatto':
                array_push($id_contatto, $post_id);
                echo "<br>ID contatto: ".$id_contatto;
		    break;
            case 'unita_organizzativa':
                array_push($id_uo, $post_id);
                echo "<br>ID unità organizzativa: ".$id_uo;
		    break;
            case 'luogo':
                array_push($id_luogo, $post_id);
                echo "<br>ID luogo: ".$id_luogo;
		    break;
            case 'servizio':
                array_push($id_servizio, $post_id);
                echo "<br>ID servizio: ".$id_servizio;
		    break;
            case 'fase':
		        array_push($id_fase, $post_id);
                echo "<br>ID fase: ".$post_id;
		    break;
        }

        if ($pagina['post_type'] == 'punto_contatto') {
            if (isset($pagina['voci']) && is_array($pagina['voci'])) {
                $array_contatto = array();

                foreach ($pagina["voci"] as $voce) {
                    if (isset($voce['tipo']) && isset($voce['valore'])) {
                        $array_contatto[] = array(
                            '_dci_punto_contatto_tipo_punto_contatto' => $voce['tipo'],
                            '_dci_punto_contatto_valore' => $voce['valore'],
                            '_dci_punto_contatto_dettagli' => isset($voce['dettagli']) ? $voce['dettagli'] : ''  
                        );
                    }
                }

                if (taxonomy_exists('tipi_punto_contatto')) {
                    wp_set_object_terms($post_id, $pagina['categorie_contatto'], 'tipi_punto_contatto');
                } else {
                    wp_send_json_error('Tassonomia "tipi_punto_contatto" non esiste.');
                }

                update_post_meta($post_id, '_dci_punto_contatto_voci', $array_contatto);

            } else {
                wp_send_json_error("L'array delle voci è vuoto o non corretto.");
            }
            echo "<br>Punto contatto creato correttamente | ID: ".$post_id;
        }
        
        if ($pagina['post_type'] == 'luogo') {
            update_post_meta($post_id, '_dci_luogo_descrizione_breve', $pagina['descrizione_breve']);
            update_post_meta($post_id, '_dci_luogo_modalita_accesso', $pagina['modalita_accesso']);
            update_post_meta($post_id, '_dci_luogo_indirizzo', $pagina['indirizzo']);
            update_post_meta($post_id, '_dci_luogo_posizione_gps', $pagina['posizione']);
            update_post_meta($post_id, '_dci_luogo_cap', $pagina['cap']);

                $indiciJson = $pagina['contatto_collegato'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_contatto,$indiciJson);
            update_post_meta($post_id, '_dci_luogo_punti_contatto', $array_contenuto);
            echo "<br>Luogo creato correttamente | ID: ".$post_id;
        }
        
        if ($pagina['post_type'] == 'unita_organizzativa') {

            update_post_meta($post_id, '_dci_unita_organizzativa_descrizione_breve', $pagina['descrizione_breve']);
            update_post_meta($post_id, '_dci_unita_organizzativa_competenze', $pagina['competenze']);
            update_post_meta($post_id, '_dci_unita_organizzativa_is_sede_principale_esa', $pagina['sede_principale']);

                $indiciJson = $pagina['luogo_collegato'];
            update_post_meta($post_id, '_dci_unita_organizzativa_sede_principale', $id_luogo[$indiciJson[0]]);

                $indiciJson = $pagina['contatto_collegato'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_contatto ,$indiciJson);
            update_post_meta($post_id, '_dci_unita_organizzativa_contatti', $array_contenuto);

            if (taxonomy_exists('tipi_unita_organizzativa') && !empty($pagina['tipo_unità_organizzativa'])) {
                wp_set_object_terms($post_id, $pagina['tipo_unità_organizzativa'], 'tipi_unita_organizzativa');
            } else {
                wp_send_json_error('Tassonomia "tipi_unita_organizzativa" non esiste o i termini sono mancanti.');
            }
            echo "<br>Unità organizzativa creata correttamente | ID: ".$post_id;
        }

        if($pagina['post_type'] == 'notizia') {
            update_post_meta($post_id, '_dci_notizia_descrizione_breve', $pagina['descrizione_breve']);
            update_post_meta($post_id, '_dci_notizia_testo_completo', $pagina['testo_completo']);

                $indiciJson = $pagina['uo_collegata'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_uo ,$indiciJson);
            update_post_meta($post_id, '_dci_notizia_a_cura_di', $array_contenuto);

                $indiciJson = $pagina['luogo_collegato'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_luogo ,$indiciJson);
            update_post_meta($post_id, '_dci_notizia_luoghi', $array_contenuto);

            if (taxonomy_exists('tipi_notizia') && !empty($pagina['categoria_notizia'])) {
                wp_set_object_terms($post_id, $pagina['categoria_notizia'], 'tipi_notizia');
            } else {
                wp_send_json_error('Tassonomia "tipi_notizia" non esiste o i termini sono mancanti.');
            }

            if (taxonomy_exists('argomenti') && !empty($pagina['argomenti_notizie'])) {
                wp_set_object_terms($post_id, $pagina['argomenti_notizie'], 'argomenti');
            } else {
                wp_send_json_error('Tassonomia "tipi_notizia" non esiste o i termini sono mancanti.');
            }
            echo "<br>Notizia creata correttamente | ID: ".$post_id;
        }

        if($pagina['post_type'] == 'servizio') {
            update_post_meta($post_id, '_dci_servizio_descrizione_breve', $pagina['descrizione_breve']);
            update_post_meta($post_id, '_dci_servizio_cosa_serve_introduzione', $pagina['cosa_serve_introduzione']);
            update_post_meta($post_id, '_dci_servizio_come_fare', $pagina['come_fare']);
            update_post_meta($post_id, '_dci_servizio_tempi_text', $pagina['tempi']);

                $indiciJson = $pagina['uo_collegata'];
            update_post_meta($post_id, '_dci_servizio_unita_responsabile', $id_uo[$indiciJson[0]]);
            update_post_meta($post_id, '_dci_servizio_a_chi_e_rivolto', $pagina['a_chi_e_rivolto']);
        
            if (taxonomy_exists('categorie_servizio')) {
                wp_set_object_terms($post_id, $pagina['categorie'], 'categorie_servizio');
            } else {
                wp_send_json_error('Tassonomia "categorie_servizio" non esiste.');
            }

            if (taxonomy_exists('argomenti') && !empty($pagina['argomenti_servizi'])) {
                wp_set_object_terms($post_id, $pagina['argomenti_servizi'], 'argomenti');
            } else {
                wp_send_json_error('Tassonomia "argomenti_servizi" non esiste o i termini sono mancanti.');
            }
            echo "<br>Servizio creato correttamente | ID: ".$post_id;
        }

        if($pagina['post_type'] == 'fase') {
            update_post_meta($post_id, '_dci_fase_desc_fase', $pagina['desc_fase']);

                $indiciJson = $pagina['servizio_collegato'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_servizio ,$indiciJson);
            update_post_meta($post_id, '_dci_fase_servizi_inclusi', $array_contenuto);

                $indiciJson = $pagina['contatto_collegato'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_contatto ,$indiciJson);
            update_post_meta($post_id, '_dci_fase_punti_contatto',$array_contenuto);

                $indiciJson = $pagina['uo_collegata'];
            update_post_meta($post_id, '_dci_fase_unita_responsabile', $id_uo[$indiciJson[0]]);
            update_post_meta($post_id, '_dci_fase_titolo_fase',$pagina['titolo_fase']);

            echo "<br>Fase creata correttamente | ID: ".$post_id;
        }

        if($pagina['post_type'] == 'procedura') {
            update_post_meta($post_id, '_dci_procedura_descrizione_breve', $pagina['descrizione_breve']);
            update_post_meta($post_id, '_dci_procedura_descrizione_estesa', $pagina['panoramica']);
            update_post_meta($post_id, '_dci_procedura_a_chi_e_rivolto', $pagina['a_chi_e_rivolto']);
            update_post_meta($post_id, '_dci_procedura_cosa_serve_introduzione', $pagina['cosa_serve_introduzione']);
            update_post_meta($post_id, '_dci_procedura_come_fare_list', $pagina['come_fare_list']);
            update_post_meta($post_id, '_dci_procedura_ulteriori_informazioni', $pagina['ulteriori_informazioni']);
                $indiciJson = $pagina['fasi_collegate'];
                $array_contenuto = array();
                $array_contenuto = seleziona_oggetti($id_fase ,$indiciJson);
            update_post_meta($post_id, '_dci_procedura_fasi', $array_contenuto);

            if (taxonomy_exists('argomenti') && !empty($pagina['argomenti_procedura'])) {
                wp_set_object_terms($post_id, $pagina['argomenti_procedura'], 'argomenti');
            } else {
                wp_send_json_error('Tassonomia "argomenti_procedura" non esiste o i termini sono mancanti.');
            }

            echo "<br>Procedura creata correttamente | ID: ".$post_id;
        }

    }

}
add_action('wp_ajax_inserimento_info_prova', 'inserimento_info_prova');
