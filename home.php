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

$hero_show = dci_get_option('hero_show', 'homepage') ?? false;
$hero_image = dci_get_option('hero_image', 'homepage') ?? false;
$hero_title = dci_get_option('hero_title', 'homepage') ?? false;
$hero_description = dci_get_option('hero_description', 'homepage') ?? false;
$hero_button_title = dci_get_option('hero_button_title', 'homepage') ?? false;
$hero_button_link = dci_get_option('hero_button_link', 'homepage') ?? false;
$hero_align_center = dci_get_option('hero_alignment', 'homepage') == 'center';

if ($hero_button_link)
    $hero_button_title = $hero_button_title ?: "Scopri";

$hero_any_text = $hero_title || $hero_description || $hero_button_link;

get_header();
?>
<main id="main-container" class="main-container redbrown">
    <h1 class="visually-hidden">
        <?php echo dci_get_option("nome_comune"); ?>
    </h1>
    <?php
    if ($hero_show) { ?>
        <section class="it-hero-wrapper it-hero-small-size <?= $hero_any_text ? 'it-dark it-overlay' : '' ?> <?= $hero_align_center ? 'it-text-centered' : '' ?>">
            <!-- - img-->
            <div class="img-responsive-wrapper">
                <div class="img-responsive">
                    <div class="img-wrapper">
                        <?php
                        if ($hero_image) { ?>
                            <?php dci_get_img($hero_image) ?>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <!-- - texts-->
            <?php
            if ($hero_any_text) { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="it-hero-text-wrapper bg-dark px-0">
                                <?php
                                if ($hero_title) { ?>
                                    <h2><?= $hero_title ?></h2>
                                <?php
                                } ?>
                                <?php
                                if ($hero_description) { ?>
                                    <p class="d-none d-lg-block"><?= $hero_description ?></p>
                                <?php
                                } ?>
                                <?php
                                if ($hero_button_link) { ?>
                                    <div class="it-btn-container"><a class="btn btn-sm <?= $hero_image ? 'btn-secondary':'btn-outline-primary' ?>" href="<?= $hero_button_link ?>"><?= $hero_button_title ?></a></div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } ?>
        </section>
    <?php
    } ?>
    <section id="head-section">
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
    <section id="evidenza" class="evidence-section">
        <?php get_template_part("template-parts/home/argomenti"); ?>
    </section>
    <section id="siti-tematici" class="my-5">
        <?php get_template_part("template-parts/home/siti", "tematici"); ?>
    </section>
    <?php if ($mostra_gallery) {
        $sfondo_grigio = false;
        get_template_part("template-parts/vivere-ente/galleria-foto");
    } ?>
    <?php get_template_part("template-parts/home/ricerca"); ?>
    <?php get_template_part("template-parts/common/valuta-servizio"); ?>
    <?php get_template_part("template-parts/common/assistenza-contatti"); ?>
</main>
<?php
get_footer();
