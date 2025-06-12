<?php
/**
 * Sito tematico template file
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
        while ( have_posts() ) :
            the_post();
            set_views($post->ID);
            
            $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

            $prefix = '_dci_sito_tematico_';

            $descrizione = dci_get_meta('descrizione_breve', $prefix, $post->ID);
            $link = dci_get_meta('link',$prefix, $post->ID);

            $data_pubblicazione_arr = dci_get_data_pubblicazione_arr("data_pubblicazione", $prefix, $post->ID);
            $date = date_i18n('d F Y', mktime(0, 0, 0, $data_pubblicazione_arr[1], $data_pubblicazione_arr[0], $data_pubblicazione_arr[2]));
            
            $has_thumbnail = has_post_thumbnail();

            ?>
            <div class="container" id="main-container">
                <div class="row">
                    <div class="col px-lg-4">
                        <?php get_template_part("template-parts/common/breadcrumb"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto mt-2">
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="avatar size-xl">
                                <?php dci_get_img(get_the_post_thumbnail_url($post, 'post-thumbnail')); ?>
                            </div>
                        <?php } ?>
                        </div>
                        <div class="col">
                        <h1><?php the_title(); ?></h1>
                        <h2 class="visually-hidden">Dettagli del sito tematico</h2>
                        <button type="button" class="btn btn-primary fw-bold" onclick="location.href='<?php echo $link; ?>';">
                            <span>Apri sito web</span>
                        </button>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <?php
                        $inline = true;
                        get_template_part('template-parts/single/actions');
                        ?>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row border-top border-light row-column-border row-column-menu-left">
                    <aside class="col-lg-3">
                        <div class="cmp-navscroll sticky-top">
                            <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                                <div class="navbar-custom" id="navbarNavProgress">
                                    <div class="menu-wrapper">
                                        <div class="link-list-wrapper">
                                            <div class="accordion">
                                                <div class="accordion-item">
                                                    <span class="accordion-header" id="accordion-title-one">
                                                        <button
                                                            class="accordion-button pb-10 px-3 text-uppercase"
                                                            type="button"
                                                            aria-controls="collapse-one"
                                                            aria-expanded="true"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-one"
                                                        >INDICE DELLA PAGINA
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
                                                                    <a class="nav-link" href="#dettagli">
                                                                    <span>Dettagli</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#more-info">
                                                                    <span>Ulteriori informazioni</span>
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
                    <section class="col-lg-9 it-page-sections-container border-light">
                    <article class="it-page-section anchor-offset" data-audio>
                        <h2 class="h3" id="dettagli">Dettagli</h2>
                        <div class="richtext-wrapper lora mb-3">
                            <?php echo $descrizione; ?>
                        </div>
                        <button type="button" class="btn btn-primary mobile-full" onclick="location.href='<?php echo $link; ?>';">
                            <span>Apri sito web</span>
                        </button>
                    </article>
                    <article
                        id="ulteriori-informazioni"
                        class="it-page-section anchor-offset mt-5"
                    >
                        <h2 class="h3 ">Ulteriori informazioni</h2>
                    </article>
                    
                    <?php get_template_part('template-parts/single/page_bottom'); ?>

                    <div class="row mt-3">
                        <div class="col-6">
                            <p>Data pubblicazione:</p>
                            <p class="fw-semibold font-monospace">
                                <?php echo $date; ?>
                            </p>
                        </div>
                    </div>
                    </section>
                </div>
            </div>
            <?php get_template_part("template-parts/common/valuta-servizio"); ?>

        <?php
        endwhile; // End of the loop.
        ?>
    </main>
    <script>
        const descText = document.querySelector('#descrizione')?.closest('article').innerText;
        const wordsNumber = descText.split(' ').length
        document.querySelector('#readingTime').innerHTML = `${Math.ceil(wordsNumber / 200)} min`;
    </script>
<?php
get_footer();

