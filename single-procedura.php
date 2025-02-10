<?php

/**
 * Procedura template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

get_header();
?>
<main>
    <?php
    while (have_posts()) :
        the_post();
        set_views($post->ID);
        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        // prefix: _dci_procedura_
        $descrizione_breve = dci_get_meta("descrizione_breve");
        $destinatari = dci_get_wysiwyg_field("a_chi_e_rivolto");
        $descrizione = dci_get_wysiwyg_field("descrizione_estesa");
        $come_fare_intro = dci_get_wysiwyg_field("cosa_serve_introduzione");
        $come_fare_list = dci_get_meta("cosa_serve_list");
        //canali di prenotazione
        $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");
        $argomenti = get_the_terms($post, 'argomenti');
        $fasi_scadenze = dci_get_meta("fasi");


    ?>
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
                                <h1 data-element="service-title">
                                    <?php the_title(); ?>
                                </h1>
                                <h2 class="visually-hidden">Dettagli del servizio</h2>
                                <p class="subtitle-small mb-3" data-element="service-description">
                                    <?php echo $descrizione_breve ?>
                                </p>
                            </div>
                            <div class="col-lg-3 offset-lg-1 mt-5 mt-lg-0">
                                <?php
                                $hide_arguments = true;
                                get_template_part('template-parts/single/actions');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php get_template_part('template-parts/single/image-large'); ?>


        <div class="container">
            <div class="row border-top row-column-border row-column-menu-left border-light">
                <div class="col-12 col-lg-3 mb-4 border-col">
                    <div class="cmp-navscroll sticky-top">
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
                                                            <?php if ($descrizione) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#description">
                                                                        <span>Cos'&egrave;</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($destinatari) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#who-needs">
                                                                        <span>A chi &egrave; rivolto</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($come_fare_intro || is_array($come_fare_list)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#needed">
                                                                        <span>Come fare</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($more_info) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#more-info">
                                                                        <span>Ulteriori informazioni</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
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
                <div class="col-12 col-lg-9">
                    <div class="it-page-sections-container">
                        <section class="it-page-section mb-30">
                            <h2 class="h3 mb-3" id="who-needs">A chi &egrave; rivolto</h2>
                            <div class="richtext-wrapper lora">
                                <?php echo $destinatari ?>
                            </div>
                        </section>

                        <?php if ($come_fare_intro ?? false) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="needed">Come fare</h2> <?php 
                                echo $come_fare_intro;
                                    $n_fase = 0;
                                    if (!empty($fasi_scadenze)) foreach ($fasi_scadenze as $fase_id) {
                                        $fase = get_post($fase_id); ?>
                                        <div class="collapse-div mb-4">
                                            <div class="border p-3 primary-bg collapse-header" role="alert">
                                                <div class="h4 d-flex justify-content-between pb-0 mb-0" data-bs-toggle="collapse" href="#collapsefase<?= $n_fase ?>" role="button" aria-expanded="false" aria-controls="collapsefase<?= $n_fase ?>">
											        <span class="white-color"> <?php echo $fase->post_title; ?> </span>
                                                    <svg class="icon icon-white ms-5 chevronwhite"><use href="#it-expand"></use></svg>
											    </div>
										    </div>
									        <div class="collapse clearfix border-start" id="collapsefase<?= $n_fase ?>">
										        <div class="collapse-body p-3"> <?php 
                                                    if (!empty(dci_get_meta('desc_fase', '_dci_fase_', $fase->ID))) { ?>
                                                        <h4 class="h5">Introduzione</h4>
                                                        <p class="info-text mb-0">
                                                                <?php echo dci_get_meta('desc_fase', '_dci_fase_', $fase->ID); ?>
                                                        </p> <?php 

                                                        $servizi_inclusi_id = dci_get_meta('servizi_inclusi', '_dci_fase_', $fase->ID);

                                                        if (!empty($servizi_inclusi_id)) {
                                                            $servizi_inclusi_id = array_map('intval', $servizi_inclusi_id);

                                                            $args = array(
                                                                'nopaging' => true,
                                                                'post_type' => 'servizio',
                                                                'post__in' => $servizi_inclusi_id,
                                                                'orderby' => 'post_title',
                                                                'order' => 'ASC',
                                                            );
                                                            $posts = get_posts($args);

                                                            if (!empty($posts)) { ?>
									                            <h4 class="h5 title mt-3"> Servizi collegati</h3>
                                                                <div>

                                                                    <a class="btn btn-primary btn-icon btn-xs" data-bs-toggle="collapse" href="#collapseServiziInclusi<?= $n_fase ?>" role="button" aria-expanded="false" aria-controls="collapseServiziInclusi<?= $n_fase ?>">
											                            Mostra servizi collegati 
                                                                        <svg class="icon icon-white ms-5 chevron"><use href="#it-expand"></use></svg>
											                        </a>
											
									                                <div class="collapse clearfix me-5" id="collapseServiziInclusi<?= $n_fase ?>">
										                                <div class="row g-4 pt-4">
											                                <?php foreach ($posts as $servizio) { ?>
												                                <div class="col-lg-6 col-md-12"> <?php
                                                                                            $mostra_dettagli_servizi  = 'estesa';
                                                                                            get_template_part("template-parts/servizio/card"); ?>
												                                </div>
                                                                            <?php } ?>
											                            </div>
										                            </div>
									                            </div> <?php
							                                } 
                                                        }

                                                        $documenti_ids = dci_get_meta('documenti', '_dci_fase_', $fase->ID); ?>
                                                        <?php if (!empty($documenti_ids)) { ?>
                                                            <h4 class="h5 my-3" id="docs">Documenti correlati</h3>
                                                            <div class="richtext-wrapper lora" data-element="service-document">
                                                                <div class="row">
                                                                    <?php
                                                                    foreach ($documenti_ids as $documento_id) { ?>
                                                                        <div class="col-12 col-md-6 mb-3 card-wrapper">
                                                                            <?php
                                                                            $documento = get_post($documento_id);
                                                                            get_template_part("template-parts/documento/card");
                                                                            ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div> <?php
                                                        }
                                                        
                                                        $punti_contatto_id = dci_get_meta('punti_contatto', '_dci_fase_', $fase->ID);
                                                        if (!empty($punti_contatto_id)) {
                                                        ?>
                                                            <h4 class="mb-3 h5" id="contacts">Contatti</h2>
                                                            <div class="row"> <?php
                                                                foreach ($punti_contatto_id as $pc_id) {
                                                                    $contatto = get_post($pc_id);
                                                                    if(isset($contatto)){ ?>
                                        
                                                                        <div class="col-lg-6 col-md-12 mb-4">
                                                                            <?php get_template_part("template-parts/punto-contatto/card"); ?>
                                                                        </div> <?php 
                                                                    }
                                                                } ?>
                                                            </div>
                                                        <?php }

                                                        $uo_id = intval(dci_get_meta('unita_responsabile', '_dci_fase_', $fase->ID));
                                                        if(isset($punti_contatto_id) && ($uo_id != false)){ ?>
                                                            <h4 class="mb-3 h5">Contatta ufficio</h3>
                                                        
                                                            <div class="row">
                                                                <div class="col-12 col-md-8 col-lg-6 mb-0">
                                                                    <?php
                                                                    $with_border = true;
                                                                    $no_vertical_margin = true;
                                                                    get_template_part("template-parts/unita-organizzativa/card-full");
                                                                    ?>
                                                                </div>
                                                            </div> 
                                                        <?php } 
                                                    } ?>
											    </div>
										    </div> 
                                        </div> <?php 
                                        $n_fase++;
                                    } ?>
                            </section>
                        <?php } ?>                                               
                        <section class="it-page-section">

                            <?php if ($more_info) {  ?>
                                <section class="it-page-section mb-30">
                                    <h2 class="h3 mb-3" id="more-info">Ulteriori informazioni</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $more_info ?>
                                    </div>
                                </section>
                            <?php }  ?>
                            <div class="row">
                                <div class="col-12 mb-30">
                                    <span class="text-paragraph-small">Argomenti:</span>
                                    <ul class="d-flex flex-wrap gap-2 mt-10 mb-30">
                                        <?php foreach ($argomenti as $item) { ?>
                                            <li>
                                                <a href="<?php echo get_term_link($item); ?>" class="chip chip-simple" data-element="service-topic">
                                                    <span class="chip-label">
                                                        <?php echo $item->name; ?>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <?php get_template_part('template-parts/single/page_bottom', "simple"); ?>
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
        <?php 
        $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
        if($visualizza_contatto == 'visible')
            get_template_part("template-parts/common/assistenza-contatti"); 
        ?>

    <?php
    endwhile; // End of the loop.
    ?>
</main>
<?php
get_footer();
