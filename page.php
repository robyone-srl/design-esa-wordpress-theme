<?php

/*
 * Generic Page Template
 *
 * @package Design_Comuni_Italia
 */

global $uo_id, $inline;

$mostra_prenota_appuntamento = dci_get_option("prenota_appuntamento", "servizi");
$punti_contatto_id = dci_get_meta('punti_contatto', '_dci_page_');
$uo_id = intval(dci_get_meta("unita_responsabile", "_dci_page_"));
$documenti = dci_get_meta('documenti', '_dci_page_');
$incarichi = dci_get_meta('incarico', '_dci_page_');

$servizi = dci_get_meta('servizi', '_dci_page_');
$luoghi = dci_get_meta('luoghi', '_dci_page_');

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
                            <small>Tempo di lettura:</small>
                            <p class="fw-semibold" id="readingTime"></p>
                        </div>
                    </div>                
                    <a class="visually-hidden" href="#more-info">Ulteriori informazioni</a>
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
                <aside class="col-lg-3">
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
                                                                    <span>Contenuto</span>
                                                                </a>
                                                            </li>
                                                            <?php if(!empty($documenti)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#documents">
                                                                        <span> Documenti allegati</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($luoghi)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#luoghi_collegati">
                                                                        <span>Luoghi correlati</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($servizi)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#servizi">
                                                                        <span>Servizi correlati</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($mostra_prenota_appuntamento || !empty($punti_contatto_id)) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#contacts">
                                                                        <span> Contatti</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
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
                    <article id="content" class="it-page-section mb-30 richtext-wrapper lora">
                        <?php the_content() ?>
                    </article>  <?php 
                    
                    if (!empty($documenti)) { ?>
                        <article id="documents">
                            <section class="it-page-section mb-30">
                                <h2 class="h3 mb-3" id="docs">Documenti allegati</h2>
                                <div class="richtext-wrapper lora" data-element="service-document">
                                    <div class="row">
                                        <?php
                                        foreach ($documenti as $documento_id) { ?>
                                            <div class="col-12 col-md-6 mb-3 card-wrapper">
                                                <?php
                                                $documento = get_post($documento_id);
                                                get_template_part("template-parts/documento/card");
                                                ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </section> 
                        </article> <?php 
                    } ?>

                    <?php if ($luoghi && is_array($luoghi) && count($luoghi)) { ?>
                        <section id="luoghi_collegati" class="it-page-section mb-4">
                            <h2 class="h3 my-2">Luoghi correlati</h2>
                                    
                            <div class="row g-4 d-flex align-items-stretch">
                                <?php foreach ($luoghi as $luogo_id) {
                                    ?><div class="col-12 col-lg-6 d-flex"><?php
                                    $with_border = true;
                                    $luogo = get_post( $luogo_id );
                                    get_template_part("template-parts/luogo/card-title");
                                    ?></div><?php
                                } ?>
                            </div>
                        </section>
                    <?php } ?>

                    <?php if ($servizi && is_array($servizi) && count($servizi)) { ?>
                        <section id="servizi" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Servizi correlati</h2>
                            <div class="row g-4">
                                        
                                <?php foreach ($servizi as $servizio_id) {
                                    $servizio = get_post($servizio_id);
                                    $with_border = true;
                                    ?> <div class="col-12 col-lg-6"><?php
                                    get_template_part("template-parts/servizio/card");
                                    ?> </div> <?php
                                } ?>
                            </div>
                        </section>
                    <?php } ?>

                    <?php if(
                        $mostra_prenota_appuntamento || !empty($punti_contatto_id) || !empty($punti_contatto_id) ||
                        !empty($uo_id) || !empty($incarichi)     
                    ) { ?>
                        <article id="contacts" class="it-page-section mb-30 richtext-wrapper lora">
                            <h2 class="mb-3 h3" id="contacts">Contatti</h2> <?php 
                            if ($mostra_prenota_appuntamento) { ?>
                                <button type="button" class="btn btn-outline-primary t-primary bg-white mobile-full mb-3" onclick="location.href='<?php echo dci_get_template_page_url('page-templates/prenota-appuntamento.php'); ?>';" data-element="service-booking-access">
                                    <span class="">Prenota appuntamento</span>
                                </button> <?php 
                            } 

                        
                            if (!empty($punti_contatto_id)) { ?>
                                <div class="row"> <?php
                                    foreach ($punti_contatto_id as $pc_id) {  
                                        $contatto = get_post($pc_id);
                                            if(isset($contatto)){ ?>
                                            <div class="col-lg-6 col-md-12 mb-4">
                                                <?php get_template_part("template-parts/punto-contatto/card"); ?>
                                            </div> <?php 
                                            }    
                                        } ?>
                                </div> <?php 
                            }

                            if(!empty($uo_id) && !empty($punti_contatto_id)){ ?>
                                <h3 class="mb-3 h4">Contatta l'ufficio</h3> <?php
                            } if(!empty($uo_id)){ ?>

                                <div class="row g-4">
                                    <div class="col-12 col-md-8 col-lg-6 mb-30">
                                        <?php
                                        $with_border = true;
                                        $no_vertical_margin = true;
                                        get_template_part("template-parts/unita-organizzativa/card-full");
                                        ?>
                                    </div>
                                </div> <?php
                            } 

                            if (!empty($incarichi) && (!empty($punti_contatto_id) || !empty($uo_id))) { ?>
                                <h3 class="h4 mb-2">Contatta le persone</h3> <?php 
                            }
                            if ($incarichi) { ?>
                                <div class="row g-4 mb-4"> <?php 
                                    foreach ($incarichi as $incarico_id) { ?>
                                        <div class="col-lg-6 col-md-12"> <?php 
                                            $title_level = 3;
                                            get_template_part("template-parts/incarico/card-person-contacts"); ?>
                                        </div> <?php 
                                    } ?>
                                </div> <?php 
                            } ?>
                        </article> <?php
                    }?>

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
            $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
            if($visualizza_contatto == 'visible')
                get_template_part("template-parts/common/assistenza-contatti"); 
        ?>
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
