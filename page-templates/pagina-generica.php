<?php

/**
 * Template name: Pagina Generica
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

global $uo_id, $inline;

get_header();
?>

<main>
    <?php
    while (have_posts()) :
        the_post();
        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        $descrizione_breve = dci_get_meta('descrizione', '_dci_page_', $post->ID);
        $data_pubblicazione_arr = dci_get_data_pubblicazione_arr("data_pubblicazione", $post->ID);
        $date = date_i18n('d F Y', mktime(0, 0, 0, $data_pubblicazione_arr[1], $data_pubblicazione_arr[0], $data_pubblicazione_arr[2]));
    ?>
        <div class="container" id="main-container">
            <div class="row">
                <div class="col px-lg-4">
                    <?php get_template_part("template-parts/common/breadcrumb"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 px-lg-4 py-lg-2">
                    <h1 data-audio><?php the_title(); ?></h1>
                    <h2 class="visually-hidden" data-audio>Dettagli della notizia</h2>
                    <p data-audio>
                        <?php echo $descrizione_breve; ?>
                    </p>
                    <div class="row mt-5 mb-4">
                        <div class="col-6">
                            <small>Data:</small>
                            <p class="fw-semibold font-monospace">
                                <?php echo $date; ?>
                            </p>
                        </div>
                        <div class="col-6">
                            <small>Tempo di lettura:</small>
                            <p class="fw-semibold" id="readingTime"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <?php
                    $inline = true;
                    get_template_part('template-parts/single/actions');
                    ?>
                </div>
            </div>
        </div>
        <?php get_template_part('template-parts/single/image-large'); ?>
        <div class="container">
            <div class="row border-top border-light row-column-border row-column-menu-left">
                <aside class="col-lg-4">
                    <div class="cmp-navscroll sticky-top" aria-labelledby="accordion-title-one">
                        <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                            <div class="navbar-custom" id="navbarNavProgress">
                                <div class="menu-wrapper">
                                    <div class="link-list-wrapper">
                                        <div class="accordion">
                                            <div class="accordion-item">
                                                <span class="accordion-header" id="accordion-title-one">
                                                    <button class="accordion-button pb-10 px-3 text-uppercase" type="button" aria-controls="collapse-one" aria-expanded="true" data-bs-toggle="collapse" data-bs-target="#collapse-one">INDICE DELLA PAGINA
                                                        <svg class="icon icon-sm icon-primary align-top">
                                                            <use xlink:href="#it-expand"></use>
                                                        </svg>
                                                    </button>
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar it-navscroll-progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div id="collapse-one" class="accordion-collapse collapse show" role="region" aria-labelledby="accordion-title-one">
                                                    <div class="accordion-body">
                                                        <ul class="link-list" data-element="page-index">
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#content">
                                                                    <span class="title-medium">Contenuto</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#more-info">
                                                                    <span class="title-medium">Ulteriori informazioni</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </aside>
                <section class="col-lg-8 it-page-sections-container border-light">
                    <article id="content" class="it-page-section mb-30 richtext-wrapper lora">
                        <?php the_content() ?>
                    </article>
                    <article id="more-info">
                        <div class="row variable-gutters">
                            <div class="col-lg-12">
                                <?php get_template_part("template-parts/single/bottom"); ?>
                            </div>
                        </div>
                    </article>
                </section>
            </div>
        </div>
        <?php get_template_part("template-parts/common/valuta-servizio"); ?>

    <?php
    endwhile; // End of the loop.
    ?>
</main>
<script>
    const descText = document.querySelector('#content')?.closest('article').innerText;
    const wordsNumber = descText.split(' ').length
    document.querySelector('#readingTime').innerHTML = `${Math.ceil(wordsNumber / 200)} min`;
</script>
<?php
get_footer();
