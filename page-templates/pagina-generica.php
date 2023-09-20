<?php
/* Template Name: Pagina Generica
 *
 * Pagina Generica template file
 *
 * @package Design_Comuni_Italia
 */
global $uo_id, $file_url, $hide_arguments;

get_header();
?>
<main>
    <?php
    while (have_posts()) :
        the_post();
        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        $description = dci_get_meta('descrizione', '_dci_page_', $post->ID);
        $argomenti = get_the_terms($post, 'argomenti');

        $img = !empty(dci_get_option('immagine', 'vivi'))
            ? dci_get_option('immagine', 'vivi')
            : get_template_directory_uri() . "\assets\placeholders\img-placeholder-500x384.png";

        function convertToPlain($text)
        {
            $text = str_replace(array("\r", "\n"), '', $text);
            $text = str_replace('"', '\"', $text);
            $text = str_replace('&nbsp;', ' ', $text);

            return trim(strip_tags($text));
        };

    ?>
        <script type="application/ld+json" data-element="metatag">
            {
                "name": "<?php echo esc_js($post->post_title); ?>",
            }
        </script>
        <div class="container" id="main-container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <?php get_template_part("template-parts/common/breadcrumb"); ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="cmp-heading pb-3 pb-lg-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1 class="title-xxxlarge" data-element="title">
                                    <?php the_title(); ?>
                                </h1>
                                <p class="subtitle-small mb-3" data-element="description">
                                    <?php echo $description ?>
                                </p>
                            </div>
                            <div class="col-lg-3 offset-lg-1 mt-5 mt-lg-0">
                                <?php
                                get_template_part('template-parts/single/actions');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('template-parts/single/image-large'); ?>
        <div>
            <div class="container">
                <div class="row border-top row-column-border row-column-menu-left border-light">
                    <div class="col-12 col-lg-3 mb-4 border-col">
                        <div class="cmp-navscroll sticky-top" aria-labelledby="accordion-title-one">
                            <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                                <div class="navbar-custom" id="navbarNavProgress">
                                    <div class="menu-wrapper">
                                        <div class="link-list-wrapper">
                                            <div class="accordion">
                                                <div class="accordion-item">
                                                    <span class="accordion-header" id="accordion-title-one">
                                                        <button class="accordion-button pb-10 px-3 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
                                                            Indice della pagina
                                                            <svg class="icon icon-xs right">
                                                                <use href="#it-expand"></use>
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
                    </div>
                    <div class="col-12 col-lg-8 offset-lg-1">
                        <div class="it-page-sections-container">
                            <section id="content" class="it-page-section mb-30 richtext-wrapper">
                                <?php the_content() ?>
                            </section>
                            <section id="more-info">
                                <div class="row variable-gutters">
                                    <div class="col-lg-12">
                                        <?php get_template_part("template-parts/single/bottom"); ?>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part("template-parts/common/valuta-servizio"); ?>
        <?php get_template_part('template-parts/single/more-posts', 'carousel'); ?>
        <?php get_template_part("template-parts/common/assistenza-contatti"); ?>

    <?php
    endwhile; // End of the loop.
    ?>
</main>
<?php
get_footer();
