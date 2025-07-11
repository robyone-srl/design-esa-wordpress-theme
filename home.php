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
        case 'messages': ?>
            <section id="messages">               
            <?php
                $messages = dci_get_option("messages", "home_messages");
                if ($messages && !empty($messages)) {
                    get_template_part("template-parts/home/messages");
                }
                ?>
            </section>
        <?php break;
        case 'notizie': ?>
            <section id="notizie">
                <?php get_template_part("template-parts/home/notizie", $visualizzazione_notizie); ?>
            </section>
        <?php break;
        case 'contenuti-evidenza': ?>
            <section id="contenuti-evidenza">
                <?php
                get_template_part("template-parts/home/contenuti-evidenza");
                ?>
            </section>
        <?php break;
        case 'luoghi-evidenza': ?>
            <section id="luoghi-evidenza" aria-describedby="novita-in-evidenza">
                <?php
                get_template_part("template-parts/vivere-ente/luoghi");
                ?>
            </section>
        <?php break;
        case 'servizi-evidenza': ?>
            <section id="servizi-evidenza">
                <?php
                get_template_part("template-parts/servizio/servizi-in-evidenza");
                ?>
            </section>
        <?php break;
        case 'calendario': ?>
            <section id="calendario">
                <?php
                get_template_part("template-parts/home/calendario", $visualizzazione_eventi);
                ?>
            </section>
        <?php break;
        case 'argomenti': ?>
            <section id="evidenza" class="evidence-section">
                <?php get_template_part("template-parts/home/argomenti"); ?>
            </section>
        <?php break;
        case 'siti-tematici': ?>
            <section id="siti-tematici" class="my-5">
                <?php get_template_part("template-parts/home/siti-tematici"); ?>
            </section>
        <?php break;
        case 'domande-frequenti': ?>
            <section id="domande-frequenti" class="my-5">
                <?php get_template_part("template-parts/home/domande-frequenti"); ?>
            </section>
        <?php break;
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