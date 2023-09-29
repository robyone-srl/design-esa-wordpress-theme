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
$mostra_gallery = dci_get_option('mostra_gallery', 'homepage') ?? false;

get_header();
?>
<main id="main-container" class="main-container redbrown">
    <h1 class="visually-hidden" id="main-container">
        <?php echo dci_get_option("nome_comune"); ?>
    </h1>
    <section id="head-section">
        <h2 class="visually-hidden">Contenuti in evidenza</h2>
        <?php
        $messages = dci_get_option("messages", "home_messages");
        if ($messages && !empty($messages)) {
            get_template_part("template-parts/home/messages");
        }
        ?>
        <?php get_template_part("template-parts/home/notizie", $visualizzazione_notizie); ?>
        <?php get_template_part("template-parts/home/contenuti-evidenza"); ?>
        <?php get_template_part("template-parts/home/calendario", $visualizzazione_eventi); ?>
    </section>
    <section id="evidenza" class="evidence-section" style="display: grid;">
        <div class="pt-5 px-lg-5 position-relative" style="grid-row-start:1; grid-column-start:1;">
            <?php get_template_part("template-parts/home/argomenti"); ?>
        </div>
        <div class="bg-primary" style="grid-row-start:1; grid-column-start:1; max-height:300px; min-height: 96px; background-size: 100% 300px; <?php if (file_exists(get_stylesheet_directory() . '/assets/img/evidenza-header.png')) { ?>background-image: url('<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/img/evidenza-header.png');<?php } else { ?>background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/evidenza-header.png');<?php } ?>">
        </div>
    </section>
    <section id="siti-tematici" class="my-5">
        <?php get_template_part("template-parts/home/siti","tematici"); ?>
    </section>
    <?php if ($mostra_gallery) { $sfondo_grigio = false; get_template_part("template-parts/vivere-ente/galleria-foto"); }?>
    <?php get_template_part("template-parts/home/ricerca"); ?>
    <?php get_template_part("template-parts/common/valuta-servizio"); ?>
    <?php get_template_part("template-parts/common/assistenza-contatti"); ?>
</main>
<?php
get_footer();
