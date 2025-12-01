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
        $come_fare_list = dci_get_meta("come_fare_list");
        //canali di prenotazione
        $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");
        $argomenti = get_the_terms($post, 'argomenti');
        $fasi_gruppo = dci_get_meta("fasi_raggruppate");

        $servizi_inclusi = dci_get_meta("servizi_inclusi");
        $documenti = dci_get_meta("documenti");
        $unita_responsabile = dci_get_meta("unita_responsabile");
        $punti_contatto = dci_get_meta("punti_contatto");

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
                                                            <?php if (!empty($servizi_inclusi)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#included-services">
                                                                        <span>Servizi inclusi</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($documenti)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#included-documents">
                                                                        <span>Documenti</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($punti_contatto)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#contact-points">
                                                                        <span>Punti di contatto</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($unita_responsabile)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#responsible-unit">
                                                                        <span>Unit&agrave; responsabile</span>
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
                        <?php if (!empty($descrizione)) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="description">Panoramica</h2>
                                <div class="richtext-wrapper lora">
                                    <?php echo $descrizione ?>
                                </div>
                            </section>
                        <?php } ?>
                        <?php if (!empty($destinatari)) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="who-needs">A chi &egrave; rivolto</h2>
                                <div class="richtext-wrapper lora">
                                    <?php echo $destinatari ?>
                                </div>
                            </section>
                        <?php } ?>
                        <?php if ($come_fare_intro ?? false) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="needed">Come fare</h2> 
                                <div class="richtext-wrapper lora" data-element="service-needed"><?php 
                                    echo $come_fare_intro;
                                    if (!empty($come_fare_list)) { ?>
                                        <ul>
                                            <?php
                                            foreach ($come_fare_list as $come_fare_item) { ?>
                                                <li><span><?php echo $come_fare_item ?></span></li>
                                            <?php } ?>
                                        </ul> <?php
                                    } ?>
                                </div> <?php
        
                                $fasi_gruppo = dci_get_meta("fasi_raggruppate");
        
                                $n_fase = 0;

                                if (!empty($fasi_gruppo)) foreach ($fasi_gruppo as $fase_riga) {
            
                                    $fase_id = $fase_riga['fase_selezionata'] ?? false;
                                    $count_giorni = $fase_riga['count_giorni'] ?? ''; 
                                    $type_count_giorni = $fase_riga['type_count_giorni'] ?? '';
                                    $data_fase_val = $fase_riga['scadenza_fase'] ?? '';
                                    $tipo_scadenza = $fase_riga['type_date'] ?? '';

                                    if (!$fase_id) continue;
            
                                    $fase = get_post($fase_id); 
            
                                    

                                    $mostra_intervallo = "";
                                    if (
                                        !empty($count_giorni) && 
                                        !empty($type_count_giorni) &&
                                        $tipo_scadenza == 'days'
                                    ) {
                                        $riferimento = '';
                                        if ($type_count_giorni === 'fase') {
                                            $riferimento = '  dopo la scadenza dell\'attivit&agrave; precedente.';
                                        } elseif ($type_count_giorni === 'totale') {
                                            $riferimento = '  dall\'inizio della procedura.';
                                        }
                                        $mostra_intervallo = " {$count_giorni} giorni{$riferimento}";
                                    }
            
                                    $mostra_data_fase = '';
                                    if (empty($mostra_intervallo) && !empty($data_fase_val)) {
                                        $mostra_data_fase = " (Scadenza: {$data_fase_val})";
                                    }
            
                                    if ($fase) {
                                    ?>
                                    <div class="collapse-div mb-4">
                                        <a class="primary-bg collapse-header p-2 d-flex align-items-center" style="text-decoration: none" data-bs-toggle="collapse" href="#collapsefase<?= $n_fase ?>" role="button" aria-expanded="false" aria-controls="collapsefase<?= $n_fase ?>">

                                            <div class="h5 px-2 me-2 my-0">
                                                <span class="white-color"> <?= $n_fase + 1 ?> </span>
                                            </div>

                                            <div class="flex-grow-1 d-flex justify-content-between align-items-center p-0 my-0 ps-3 border-start" role="alert">
                                                <h4 class="h5 white-color mb-0"> <?= dci_get_meta('titolo_fase', '_dci_fase_', $fase->ID); ?> </h4> 
                                                <svg class="icon icon-white ms-4 chevron"><use href="#it-expand"></use></svg>
                                            </div>

                                        </a>
                                        <div class="ps-4">
                                            <div class="collapse clearfix border-start" id="collapsefase<?= $n_fase ?>">
                                                <div class="collapse-body p-3 ms-3"> <?php 
                                                    if (!empty(dci_get_wysiwyg_field('desc_fase', '_dci_fase_', $fase->ID))) { ?>
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
                                                                <h5 class="title mt-3"> Servizi collegati</h5>
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
                                                            <h5 class="h5 my-3" id="docs">Documenti correlati</h5>
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
                                                            <h5 class="my-3 h5" id="contacts">Contatti</h5>
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
                                                            <h5 class="mb-3 h5">Contatta ufficio</h5>
                            
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

                                                        if(!empty($mostra_intervallo) || !empty($mostra_data_fase)){?>
                                                            <h5 class="title mt-3"> Tempistiche attivit&agrave;</h5>
                                                            <?php if (!empty($mostra_intervallo)) { ?>
                                                                <p class="info-text mb-0"><?php echo 'L\'attivit&agrave; scade' . $mostra_intervallo; ?></p>
                                                            <?php } elseif (!empty($mostra_data_fase)) { ?>
                                                                <p class="info-text mb-0"><?php echo 'Scadenza fissata al: ' . $data_fase_val; ?></p>
                                                            <?php } ?>
                                                        <?php }
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <?php 
                                    $n_fase++;
                                } } ?>
                            </section>
                        <?php } ?>         
                        <?php if (!empty($servizi_inclusi)) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="included-services">Servizi collegati</h2>
                                <div class="row g-4">
                                    <?php foreach ($servizi_inclusi as $servizio_Id) { 
                                        $servizio = get_post($servizio_Id); ?>
                                        <div class="col-lg-6 col-md-12"> <?php
                                                    $mostra_dettagli_servizi  = 'estesa';
                                                    get_template_part("template-parts/servizio/card"); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>
                        <?php } ?>

                        <?php if (!empty($documenti)) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="included-documents">Documenti</h2>
                                <div class="row g-4">
                                    <?php foreach ($documenti as $documento_Id) {
                                        $documento = get_post($documento_Id); ?>
                                        <div class="col-lg-6 col-md-12"> <?php
                                                    get_template_part("template-parts/documento/card"); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>
                        <?php
                        } ?>

                        <?php if (!empty($punti_contatto)) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="contact-points">Punti di Contatto</h2>
                                <div class="row g-4">
                                    <?php foreach ($punti_contatto as $pc_id) { ?>
                                        <div class="col-lg-6 col-md-12"> <?php
                                            $contatto = get_post($pc_id);
                                            $with_border = true;
                                            $no_vertical_margin = true;
                                            get_template_part("template-parts/punto-contatto/card"); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>
                        <?php
                        } ?>

                        <?php if (!empty($unita_responsabile)) { ?>
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="responsible-unit">Unit&agrave; Responsabile </h2>
                                <div class="row g-4">
                                    <div class="col-lg-6 col-md-12"> <?php
                                        $uo_id = $unita_responsabile;
                                        $with_border = true;
                                        $no_vertical_margin = true;
                                        get_template_part("template-parts/unita-organizzativa/card-full"); ?>
                                    </div>
                                </div>
                            </section>
                        <?php
                        } ?>
                        <section class="it-page-section">
                            <?php if ($more_info) {  ?>
                                <section class="it-page-section mb-30">
                                    <h2 class="h3 mb-3" id="more-info">Ulteriori informazioni</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $more_info ?>
                                    </div>
                                </section>
                            <?php }  ?>
                            <?php if ($argomenti) {  ?>
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
                            <?php }  ?>
                        </section>
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
    endwhile;
    ?>
</main>
<?php
get_footer();
