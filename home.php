<?php

/**
 * The template for displaying home
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

$visualizzazione_eventi = dci_get_option('visualizzazione_eventi', 'homepage') ?? '';
$visualizzazione_notizie = dci_get_option('visualizzazione_notizie', 'homepage') ?? '';
$home_sections = dci_get_option('home_sections', 'homepage') ?: dci_get_default_home_sections();
$contatti_p_cont = dci_get_option("contattaci_contenuto", 'footer');


function get_section($name) 
{
    $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');

    global $visualizzazione_eventi, $visualizzazione_notizie, $sfondo_grigio, $messages;
    switch ($name) {
        case 'hero':
            get_template_part("template-parts/home/hero");
            break;
        case 'hero-chi-siamo':
            get_template_part("template-parts/home/hero-chi-siamo");
            break;
        case 'notizie':
            get_template_part("template-parts/home/notizie", $visualizzazione_notizie);
            break;
        case 'contenuti-evidenza':
            get_template_part("template-parts/home/contenuti-evidenza");
            break;
        case 'luoghi-evidenza':
            get_template_part("template-parts/vivere-ente/luoghi");
            break;
        case 'servizi-evidenza':
            get_template_part("template-parts/servizio/servizi-in-evidenza");
            break;
        case 'calendario':
            get_template_part("template-parts/home/calendario", $visualizzazione_eventi);
            break;
        case 'argomenti':
            get_template_part("template-parts/home/argomenti");
            break;
        case 'siti-tematici': 
            $container_css_class = "my-5";
            get_template_part("template-parts/home/siti-tematici");
            break;
        case 'domande-frequenti': 
            $container_css_class = "my-5";
            get_template_part("template-parts/home/domande-frequenti");
            break;
        case 'galleria-foto': 
            $sfondo_grigio = false;
            get_template_part("template-parts/vivere-ente/galleria-foto");
            break;
        case 'ricerca':
            get_template_part("template-parts/home/ricerca");
            break;
        case 'valuta-servizio':
            get_template_part("template-parts/common/valuta-servizio");
            break;
        case 'assistenza-contatti':
            if($visualizza_contatto == 'visible' || $visualizza_contatto == null)
                get_template_part("template-parts/common/assistenza-contatti");
            break; 
        default:
            break;
    }
}

get_header();
?>
<main id="main-container" class="main-container redbrown">
    <h1 class="visually-hidden">
        <?php echo dci_get_option("nome_comune"); ?>
    </h1>

    <?php
    foreach($home_sections as $section){
        get_section($section);
    } ?>
</main>
<?php
get_footer();