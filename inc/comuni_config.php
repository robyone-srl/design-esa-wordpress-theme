<?php


//configurazione del sito
define('COMUNI_PAGINE',jsonToArray(get_template_directory()."/inc/comuni_pagine.json")['pagine']);

define('COMUNI_TIPOLOGIE',jsonToArray(get_template_directory()."/inc/comuni_tipologie.json")['tipologie']);

define('SOCIAL_ICONS', [
    'linkedin' => "it-linkedin",
    'telegram' => "it-telegram",
    'twitter' => "it-twitter",
    'whatsapp' => "it-whatsapp"
]);

/**
 * restituisce l'oggetto che descrive le Pagine del Sito dei Comuni
 * @return mixed
 */
function dci_get_pagine_obj(){
    return COMUNI_PAGINE;
}

/**
 * restituisce l'id del gruppo di appartenenza della tipologia
 * @param $tipologia
 * @return mixed
 */
function dci_get_group($tipologia) {
    return COMUNI_TIPOLOGIE[$tipologia]['group_id'] ?? null;
}

/**
 * restituisce il nome del gruppo di appartenenza della tipologia
 * @param $tipologia
 * @return mixed
 */
function dci_get_group_name($tipologia) {
    if (array_key_exists($tipologia, COMUNI_TIPOLOGIE ) && is_array(COMUNI_TIPOLOGIE[$tipologia]) && array_key_exists('group_name',  COMUNI_TIPOLOGIE[$tipologia]) ){
        return COMUNI_TIPOLOGIE[$tipologia]['group_name'];
    }
    return null;
}

/**
 * restituisce le tipologie associate ad una data tassonomia (es: 'argomenti')
 * @param $taxonomy
 * @return array
 */
function dci_get_tipologie_related_to_taxonomy($taxonomy) {
    $result = array();
    foreach (COMUNI_TIPOLOGIE as $tipologia) {
        if (array_key_exists('taxonomy', $tipologia) && is_array($tipologia['taxonomy']) && in_array($taxonomy,$tipologia['taxonomy'])){
            $result[] = $tipologia['name'];
        }
    }
    return $result;
}

/**
 * restituisce tutti i nomi delle tipologie del Sito dei Comuni
 */
function dci_get_tipologie_names() {
    return array_column(COMUNI_TIPOLOGIE, 'name');
}

/**
 * restituisce tutti i prefix dei custom types del sito dei Comuni Italiani
 */

function dci_get_tipologie_prefixes(){
    return array_column(COMUNI_TIPOLOGIE, 'prefix', 'name');
}



/**
 * restituisce tuttle capability dei custom types del Sito dei Comuni
 */
function dci_get_tipologie_capabilities(){
    return array_column(COMUNI_TIPOLOGIE, 'capability', 'name');
}

/**
 * restituisce tutti i nomi delle taxonomy del sito dei Comuni Italiani
 */
function dci_get_tassonomie_names(){
    $tassonomie = array(
        'categorie_servizio',
        'tipi_evento',
        'tipi_notizia',
        'tipi_luogo',
        'argomenti',
        'tipi_unita_organizzativa',
        'licenze',
        'frequenze_aggiornamento',
        'temi_dataset',
        'tipi_punto_contatto',
        'tipi_doc_albo_pretorio',
        'eventi_vita_persone',
        'eventi_vita_impresa',
        'tipi_incarico',
        'stati_pratica',
        'tipi_documento'
    );
    return $tassonomie;
}

/**
 * restituisce l'id del gruppo di appartenenza della tipologia
 * @param $tipologia
 * @return mixed
 */
function dci_get_taxonomy_group($taxonomy) {
	$result = "";
	
	switch ($taxonomy) {
		case "categorie_servizio":
			$result = "servizi";
			break;
		case "tipi_evento":
			$result = "vivere-ente";
			break;
		case "tipi_notizia":
			$result = "novita";
			break;
		case "tipi_luogo":
			$result = "vivere-ente";
			break;
		case "tipi_unita_organizzativa":
			$result = "amministrazione";
			break;
		case "licenze":
			$result = "amministrazione";
			break;
		case "frequenze_aggiornamento":
			$result = "amministrazione";
			break;
		case "temi_dataset":
			$result = "amministrazione";
			break;
		case "tipi_doc_albo_pretorio":
			$result = "amministrazione";
			break;
		case "tipi_incarico":
			$result = "amministrazione";
			break;
		case "tipi_documento":
			$result = "amministrazione";
			break;
	}

    return $result;
}

/**
 * restituisce tutti gli slug delle pagine di default del Sito dei Comuni
 */
function dci_get_pagine_slugs(){
    return dci_get_all_values(COMUNI_PAGINE,'slug');
}

/**
 * restituisce tutti gli i nomi dei template delle pagine di default del Sito dei Comuni
 */
function dci_get_pagine_template_names(){
    return dci_get_all_values(COMUNI_PAGINE,'template_name');
}

/**
 * restituisce un array contenente i post type ricercabili dalla ricerca globale
 * @return string[]
 */
function dci_get_sercheable_tipologie() {
    $arrayTipologie = array(
        'documento_pubblico',
        'domanda_frequente',
        'dataset',
        'evento',
        'luogo',
        'notizia',
        'pagina',
        'persona_pubblica',
        'post',
        'procedura',
        'servizio',
        'sito_tematico',
        'unita_organizzativa'
    );
    if ( post_type_exists( 'amm-trasparente' ) ) { // Compatibilità plugin amministrazione-trasparente
        $arrayTipologie[] = 'amm-trasparente';
    }
    return $arrayTipologie;
}

/**
 * restituisce un array contenente i post type ricercabili dalla ricerca globale
 * @return string[]
 */
function dci_get_sercheable_tipologie_argomenti() {
    $arrayTipologie = array(
        'documento_pubblico',
        'domanda_frequente',
        'dataset',
        'luogo',
        'persona_pubblica',
        'page',
        'post',
        'servizio',
        'sito_tematico',
        'unita_organizzativa'
    );
    if ( post_type_exists( 'amm-trasparente' ) ) { // Compatibilità plugin amministrazione-trasparente
        $arrayTipologie[] = 'amm-trasparente';
    }
    return $arrayTipologie;
}

/**
 * restituisce un array contenente i post type presenti nella griglia della scheda dell'argomento
 * @return string[]
 */
function dci_get_grid_tipologie_argomenti() {
    $arrayTipologie = array(
        'documento_pubblico',
        'dataset',
        'luogo',
        'pagina',
        'persona_pubblica',
        'post',
        'page',
        'procedura',
        'servizio',
        'sito_tematico',
        'unita_organizzativa'
    );
    if ( post_type_exists( 'amm-trasparente' ) ) { // Compatibilità plugin amministrazione-trasparente
        $arrayTipologie[] = 'amm-trasparente';
    }
    return $arrayTipologie;
}

/**
 * restituisce l'associazione tra i type ricercabili e i post_type wordpress
 * @param string $type
 *
 * @return array
 */
function dci_get_post_types_grouped($group = "", $tag = false)
{
    if ($group == "")
        $group = "any";
    if ($group === "amministrazione")
        $post_types = array("unita_organizzativa");
    else if ($group === "novita")
        $post_types = array("notizia");
    else if ($group === "novita-evento")
        $post_types = array("notizia", "evento");
    else if ($group === "servizi")
        $post_types = array("servizio");
    else if ($group === "vivere-ente")
        $post_types = array("evento", "luogo");
    else if ($group === "documenti-e-dati")
        $post_types = array("documento_pubblico", "dataset");
    else if ($group === "luoghi")
        $post_types = array("luogo");
    else if ($group === "siti-tematici")
        $post_types = array("sito_tematico");
    else if ($group === "domande-frequenti")
        $post_types = array("domanda_frequente");
    else if ($group === "argomenti-tutti")
        $post_types = dci_get_sercheable_tipologie_argomenti();
    else if ($group === "argomenti-griglia") {
        $post_types = dci_get_grid_tipologie_argomenti();
    }
    else if (($group === "page") || ($group === "pagina"))
        $post_types = array("page");
    else
        $post_types = dci_get_sercheable_tipologie();

    // rimuovo post types che non hanno la categoria
    if ($tag) {
        if (($key = array_search("page", $post_types)) !== false) {
            unset($post_types[$key]);
        }
    }
    return $post_types;
}

/**
 * restityuisce gli id dei gruppi del Sito dei Comuni
 * @return string[]
 */
function dci_get_group_ids() {
    return array(
      'amministrazione',
      'novita',
      'servizi',
      'vivere-il-comune',
      'documenti-e-dati',
    );
}

/**
 * restituisce label per costruzione breadcrumb
 * @param $name
 * @param string $type
 * @return mixed|string
 */
function dci_get_breadcrumb_label($name , $type = 'term') {
    $terms = array(
        'comunicato stampa' => 'Comunicati',
        'news' => 'Notizie',
        'avviso' => 'Avvisi'
    );

    if ($terms[$name] ?? false) {
        return $terms[$name];
    }

    return ucfirst($name);
}

/**
 * restituisce l'array per ordinare le voci del menu admin di wordpress
 * @return string[]
 */
function dci_get_admin_menu_order() {
    return array(
        'index.php',
        'dci_options',
        'separator1',
        'edit.php?post_type=notizia',
        'edit.php?post_type=servizio',
        'edit.php?post_type=fase',
        'edit.php?post_type=evento',
        'edit.php?post_type=luogo',
        'edit.php?post_type=documento_pubblico',
        'edit.php?post_type=dataset',
        'edit.php?post_type=unita_organizzativa',
        'edit.php?post_type=persona_pubblica',
        'edit.php?post_type=punto_contatto',
        'edit.php?post_type=sito_tematico',
        'edit.php?post_type=incarico',
        'edit.php?post_type=pratica',
        'edit.php?post_type=documento_privato',
        'edit.php?post_type=messaggio',
        'edit.php?post_type=pagamento',
        'separator2',
        'edit.php?post_type=appuntamento',
        'edit.php?post_type=richiesta_assistenza',
        'edit.php?post_type=domanda_frequente',
        'edit.php?post_type=rating',
        'edit.php?post_type=page',
        'separator3',
        'upload.php',
    );
}

//utility

/**
 * restituisce un array a partire da un file JSON
 * @param $filename
 * @return mixed
 */
function jsonToArray($filename) {
    $strJsonFileContents = file_get_contents($filename);
    // Convert to array
    return json_decode($strJsonFileContents, true);
}

/**
 * ricerca della chiave in tutti gli oggetti
 * @param $array
 * @param $key
 * @return array
 */
function dci_get_all_values($array,$key){
    $result = array();
    foreach ($array as $element){
        $result [] = $element[$key];
        if (!empty($element['children'])){
            $result = array_merge($result,dci_get_all_values($element['children'],$key));
        }
    }
    return $result;
}

function remove_default_post_type($args, $postType) {
    if ($postType === 'post') {
        $args['public']                = false;
        $args['show_ui']               = false;
        $args['show_in_menu']          = false;
        $args['show_in_admin_bar']     = false;
        $args['show_in_nav_menus']     = false;
        $args['can_export']            = false;
        $args['has_archive']           = false;
        $args['exclude_from_search']   = true;
        $args['publicly_queryable']    = false;
        $args['show_in_rest']          = false;
    }

    return $args;
}
add_filter('register_post_type_args', 'remove_default_post_type', 0, 2);