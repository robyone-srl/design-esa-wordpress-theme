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
