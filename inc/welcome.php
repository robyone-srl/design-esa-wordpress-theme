<?php

require get_template_directory() . '/inc/lib/parsedown.php';


/* DEBUG: Mostra un avviso in admin con il percorso esatto del file SimpleXLSX.php
add_action('admin_notices', function() {
    $path = get_template_directory() . '/inc/lib/SimpleXLSX.php';
    echo '<div class="notice notice-warning is-dismissible" style="z-index: 99999;">';
    echo '<h3>DEBUG PERCORSO</h3>';
    echo '<p>Il sistema sta cercando il file esattamente qui:<br>';
    echo '<strong>' . $path . '</strong></p>';
    
    if (file_exists($path)) {
        echo '<p style="color:green; font-weight:bold;">✅ IL FILE ESISTE!</p>';
    } else {
        echo '<p style="color:red; font-weight:bold;">❌ IL FILE NON È STATO TROVATO.</p>';
        echo '<p>Controlla che:<br>';
        echo '1. La cartella "lib" esista dentro "inc".<br>';
        echo '2. Il file si chiami "SimpleXLSX.php" (occhio alle maiuscole S e XLSX!).</p>';
    }
    echo '</div>';
});
*/
/**
 * CARICAMENTO LIBRERIA EXCEL E FIX NAMESPACE
 */
$xlsx_path = get_template_directory() . '/inc/lib/SimpleXLSX.php';
if (file_exists($xlsx_path)) {
    require_once $xlsx_path;
    if (class_exists('Shuchkin\SimpleXLSX')) {
        class_alias('Shuchkin\SimpleXLSX', 'SimpleXLSX');
    }
}

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


//------------------------------------

/**
 * 1. REGISTRAZIONE PAGINA DI IMPORTAZIONE
 */
add_action('admin_menu', 'dci_register_import_page');
function dci_register_import_page() {
    add_submenu_page(
        'index.php', 
        'Importa Dati ESA', 
        'Importa Excel ESA', 
        'manage_options', 
        'dci-import-excel', 
        'dci_render_import_page'
    );
}

/**
 * 2. INTERFACCIA GRAFICA IMPORTATORE
 */
function dci_render_import_page() {
    ?>
    <div class="wrap">
        <h1>Importazione Dati da Excel (Modello ESA)</h1>
        <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px;">
            <h2>Carica il file Excel</h2>
            <p>Carica qui il file <code>.xlsx</code> compilato. Il sistema riconoscerà automaticamente le schede e importerà i dati partendo dalle righe predefinite.</p>
            
            <?php 
            if (!class_exists('SimpleXLSX')) {
                echo '<div class="notice notice-error inline"><p><strong>ERRORE CRITICO:</strong> La classe <code>SimpleXLSX</code> non è stata caricata.</p></div>';
            } else {
                if (isset($_FILES['import_file']) && isset($_POST['dci_import_nonce'])) {
                    dci_handle_excel_upload();
                }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field('dci_import_action', 'dci_import_nonce'); ?>
                    <label for="import_file" style="font-weight:bold; display:block; margin-bottom:10px;">Seleziona File (.xlsx):</label>
                    <input type="file" name="import_file" id="import_file" accept=".xlsx" required>
                    <p class="submit">
                        <input type="submit" class="button button-primary button-large" value="Avvia Importazione Dati">
                    </p>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * 3. LOGICA DI LETTURA EXCEL (HARDCODED ROWS)
 */
function dci_handle_excel_upload() {
    if (!wp_verify_nonce($_POST['dci_import_nonce'], 'dci_import_action')) return;
    
    set_time_limit(300); 
    ini_set('memory_limit', '512M');

    if ($xlsx = SimpleXLSX::parse($_FILES['import_file']['tmp_name'])) {
        
        $sheetNames = $xlsx->sheetNames();
        
        // MAPPA CONFIGURAZIONE
        $map = [
            'Luoghi'              => ['func' => 'import_sheet_luoghi',  'start_row' => 11], 
            'Unità organizzative' => ['func' => 'import_sheet_uo',      'start_row' => 8],  
            'Persone e incarichi' => ['func' => 'import_sheet_persone', 'start_row' => 7],  
            'Servizi'             => ['func' => 'import_sheet_servizi', 'start_row' => 12]  
        ];

        echo '<div class="notice notice-success is-dismissible"><p><strong>Importazione Avviata!</strong></p>';
        
        foreach ($sheetNames as $sheetIndex => $sheetName) {
            $cleanName = trim($sheetName);
            
            if (isset($map[$cleanName])) {
                echo "<p>Elaborazione scheda: <strong>$cleanName</strong>... ";
                $rows = $xlsx->rows($sheetIndex);
                
                $startRowIndex = $map[$cleanName]['start_row'];
                $count = 0;
                $functionName = $map[$cleanName]['func'];
                
                for ($i = $startRowIndex; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    if (empty(trim($row[0])) && empty(trim($row[1]))) continue;
                    
                    if ($functionName($row)) {
                        $count++;
                    }
                }
                echo "$count elementi importati.</p>";
            }
        }
        echo '</div>';

    } else {
        echo '<div class="notice notice-error"><p>' . SimpleXLSX::parseError() . '</p></div>';
    }
}

/**
 * 4. FUNZIONI DI MAPPING
 */

function import_sheet_luoghi($row) {
    // 0:Nome, 1:Desc, 2:Tipo, 3:Padre, 4:Recapiti, 5:Accesso, 6:Orari, 7:Via, 8:Civico, 9:Città, 10:Prov, 11:CAP
    $nome = trim($row[0]);
    if(empty($nome)) return false;

    // Indirizzo
    $parts = array_filter([$row[7], $row[8], $row[11], $row[9], $row[10]]); 
    $indirizzo = implode(', ', $parts);
    
    // Argomenti
    $argomenti = [];
    for($j=12; $j<count($row); $j++) { 
        if(!empty($row[$j]) && stripos($row[$j], 'Note') === false) $argomenti[] = $row[$j]; 
    }

    // Tassonomia:
    $tipi_luogo = [];
    if (!empty($row[2]) && strtoupper(trim($row[2])) !== 'NESSUNO') {
        $tipi_luogo[] = $row[2];
    }

    return ESA_Content_Importer::import_post(array(
        'title' => $nome,
        'post_type' => 'luogo',
        'parent_title' => $row[3],
        'content' => $row[1],
        'meta_input' => array(
            '_dci_luogo_descrizione_breve' => $row[1],
            '_dci_luogo_indirizzo' => $indirizzo,
            '_dci_luogo_cap' => $row[11],
            '_dci_luogo_modalita_accesso' => $row[5],
            '_dci_luogo_orario_apertura' => $row[6],
            '_dci_luogo_posizione_gps' => ''
        ),
        'taxonomies' => array(
            'tipi_luogo' => $tipi_luogo,
            'argomenti' => $argomenti
        ),
        'relations' => array(
            // Passiamo il valore grezzo, la logica "dummy" è gestita dentro import_post
            '_dci_luogo_punti_contatto' => array('value' => $row[4], 'post_type' => 'punto_contatto', 'is_dedicated' => true, 'parent_name' => $nome)
        )
    ));
}

function import_sheet_uo($row) {
    // 0:Nome, 1:Desc, 2:Tipo, 3:Contatti, 4:Sede Princ, 5:Madre
    $nome = trim($row[0]);
    if(empty($nome)) return false;

    $argomenti = [];
    for($j=6; $j<count($row); $j++) { if(!empty($row[$j]) && stripos($row[$j], 'Note') === false) $argomenti[] = $row[$j]; }

    return ESA_Content_Importer::import_post(array(
        'title' => $nome,
        'post_type' => 'unita_organizzativa',
        'parent_title' => $row[5], 
        'content' => $row[1],
        'meta_input' => array(
            '_dci_unita_organizzativa_descrizione_breve' => $row[1]
        ),
        'taxonomies' => array(
            'tipi_unita_organizzativa' => $row[2],
            'argomenti' => $argomenti
        ),
        'relations' => array(
            '_dci_unita_organizzativa_sede_principale' => array('value' => $row[4], 'post_type' => 'luogo', 'single' => true),
            '_dci_unita_organizzativa_contatti' => array('value' => $row[3], 'post_type' => 'punto_contatto', 'is_dedicated' => true, 'parent_name' => $nome)
        )
    ));
}

function import_sheet_persone($row) {
    // 0:Nome Cognome, 1:Incarico, 2:Tipo, 3:Contatti, 4:UO, 5:Resp
    $nome_completo = trim($row[0]);
    if(empty($nome_completo)) return false;

    // Logica Nome/Cognome
    $parts = explode(' ', $nome_completo);
    $cognome = '';
    $nome = $nome_completo; 
    if (count($parts) > 1) {
        $cognome = array_pop($parts);
        $nome = implode(' ', $parts);
    }

    // PASSO 1: CREARE LA PERSONA
    $persona_id = ESA_Content_Importer::import_post(array(
        'title' => $nome_completo,
        'post_type' => 'persona_pubblica',
        'meta_input' => array(
            '_dci_persona_pubblica_nome' => $nome,
            '_dci_persona_pubblica_cognome' => $cognome,
            '_dci_persona_pubblica_nominativo' => $nome_completo 
        )
    ));

    // PASSO 2: CREARE L'INCARICO E IL COLLEGAMENTO
    $desc_incarico = !empty($row[1]) ? trim($row[1]) : 'Incarico di ' . $nome_completo;
    
    return ESA_Content_Importer::import_post(array(
        'title' => $desc_incarico,
        'post_type' => 'incarico',
        'taxonomies' => array(
            'tipi_incarico' => $row[2]
        ),
        'meta_input' => array(
            '_dci_incarico_persona' => $persona_id,
            '_dci_incarico_responsabile' => (stripos($row[5], 'Si') !== false ? 'true' : 'false')
        ),
        'relations' => array(
            '_dci_incarico_unita_organizzativa' => array('value' => $row[4], 'post_type' => 'unita_organizzativa'),
            '_dci_incarico_punti_contatto' => array('value' => $row[3], 'post_type' => 'punto_contatto', 'is_dedicated' => true, 'parent_name' => $nome_completo)
        )
    ));
}

function import_sheet_servizi($row) {
    // 0:Titolo, 1:Desc, 2:Inclusi, 3:Cat, 4:Rivolto, 5:Uff, 6:Contatti
    $titolo = trim($row[0]);
    if(empty($titolo)) return false;

    $argomenti = [];
    for($j=7; $j<count($row); $j++) { if(!empty($row[$j]) && stripos($row[$j], 'Note') === false) $argomenti[] = $row[$j]; }

    return ESA_Content_Importer::import_post(array(
        'title' => $titolo,
        'post_type' => 'servizio',
        'content' => $row[1],
        'meta_input' => array(
            '_dci_servizio_descrizione_breve' => $row[1],
            '_dci_servizio_a_chi_e_rivolto' => $row[4],
            '_dci_servizio_stato' => 'true'
        ),
        'taxonomies' => array(
            'categorie_servizio' => $row[3],
            'argomenti' => $argomenti
        ),
        'relations' => array(
            '_dci_servizio_unita_responsabile' => array('value' => $row[5], 'post_type' => 'unita_organizzativa', 'single' => true),
            '_dci_servizio_punti_contatto' => array('value' => $row[6], 'post_type' => 'punto_contatto', 'is_dedicated' => true, 'parent_name' => $titolo),
            '_dci_servizio_servizi_inclusi' => array('value' => $row[2], 'post_type' => 'servizio')
        )
    ));
}

/**
 * 5. CLASSE HELPER
 */
if (!class_exists('ESA_Content_Importer')) {
    class ESA_Content_Importer {

        public static function get_id_by_title($title, $post_type) {
            if(empty($title)) return null;
            $post = get_page_by_title(trim($title), OBJECT, $post_type);
            return $post ? $post->ID : null;
        }

        // Crea/Recupera il contatto dummy
        public static function ensure_placeholder_contact() {
            $title = 'Contatto mancante';
            $id = self::get_id_by_title($title, 'punto_contatto');
            if (!$id) {
                $id = self::import_post(array(
                    'title' => $title,
                    'post_type' => 'punto_contatto',
                    'content' => 'Contatto generico assegnato automaticamente quando non specificato.'
                ));
            }
            return $id;
        }

        // Crea contatto raggruppato
        public static function create_dedicated_contact($contact_string, $parent_name) {
            $contact_string = trim($contact_string);
            if (empty($contact_string)) return null;
            
            $raw_values = preg_split('/[,\n\r]+/', $contact_string);
            $raw_values = array_filter(array_map('trim', $raw_values)); 
            
            if (empty($raw_values)) return null;

            $group_title = "Contatti " . $parent_name;
            
            $contact_id = self::get_id_by_title($group_title, 'punto_contatto');
            if (!$contact_id) {
                $contact_id = self::import_post(array(
                    'title' => $group_title,
                    'post_type' => 'punto_contatto'
                ));
            }

            if (!$contact_id) return null;

            $repeater_values = [];
            $taxonomies_to_set = [];

            foreach ($raw_values as $val) {
                $type = (strpos($val, '@') !== false) ? 'email' : 'telefono';
                $taxonomies_to_set[] = ucfirst($type);

                $repeater_values[] = array(
                    '_dci_punto_contatto_tipo_punto_contatto' => $type,
                    '_dci_punto_contatto_valore' => $val
                );
            }

            update_post_meta($contact_id, '_dci_punto_contatto_voci', $repeater_values);
            if (!empty($taxonomies_to_set)) {
                wp_set_object_terms($contact_id, array_unique($taxonomies_to_set), 'tipi_punto_contatto');
            }

            return $contact_id;
        }

        public static function import_post($args) {
            $post_title = trim($args['title']);
            if(empty($post_title)) return false;

            $post_type = $args['post_type'];
            $existing_post = get_page_by_title($post_title, OBJECT, $post_type);
            
            $post_data = array(
                'post_title'    => $post_title,
                'post_content'  => isset($args['content']) ? $args['content'] : '',
                'post_status'   => 'publish',
                'post_type'     => $post_type,
                'post_author'   => get_current_user_id(),
            );

            if ($existing_post) {
                $post_data['ID'] = $existing_post->ID;
                $post_id = wp_update_post($post_data);
            } else {
                $post_id = wp_insert_post($post_data);
            }

            if (is_wp_error($post_id)) return false;

            if (isset($args['meta_input'])) {
                foreach ($args['meta_input'] as $key => $value) {
                    if(!empty($value)) update_post_meta($post_id, $key, $value);
                }
            }

            if (isset($args['taxonomies'])) {
                foreach ($args['taxonomies'] as $tax => $terms) {
                    if (taxonomy_exists($tax) && !empty($terms)) {
                        if(!is_array($terms)) $terms = array_map('trim', explode(',', $terms));
                        wp_set_object_terms($post_id, $terms, $tax);
                    }
                }
            }

            // GESTIONE RELAZIONI E CONTATTI
            if (isset($args['relations'])) {
                foreach ($args['relations'] as $meta_key => $conf) {
                    $ids = array();
                    
                    // A. GESTIONE PUNTO CONTATTO (con logica Dummy integrata qui)
                    if ($conf['post_type'] === 'punto_contatto') {
                        if (empty($conf['value'])) {
                            $dummy_id = self::ensure_placeholder_contact();
                            if ($dummy_id) $ids[] = $dummy_id;
                        } 
                        elseif (isset($conf['is_dedicated']) && $conf['is_dedicated'] === true) {
                            $cid = self::create_dedicated_contact($conf['value'], $conf['parent_name']);
                            if ($cid) $ids[] = $cid;
                        }
                        else {
                            $found = self::get_id_by_title($conf['value'], 'punto_contatto');
                            if ($found) $ids[] = $found;
                        }
                    } 
                    // B. GESTIONE RELAZIONI STANDARD (Luoghi, Uffici, ecc.)
                    else {
                        if (!empty($conf['value'])) {
                            $raw_values = preg_split('/[,\n\r]+/', $conf['value']);
                            foreach($raw_values as $t) {
                                $t = trim($t);
                                if(empty($t)) continue;
                                $found = self::get_id_by_title($t, $conf['post_type']);
                                if ($found) $ids[] = $found;
                            }
                        }
                    }

                    if (!empty($ids)) {
                        $val = (isset($conf['single']) && $conf['single']) ? $ids[0] : $ids;
                        update_post_meta($post_id, $meta_key, $val);
                    }
                }
            }
            
            if(isset($args['parent_title']) && !empty($args['parent_title'])) {
                $parent_id = self::get_id_by_title($args['parent_title'], $post_type);
                if($parent_id) wp_update_post(array('ID' => $post_id, 'post_parent' => $parent_id));
            }

            return $post_id;
        }
    }
}
