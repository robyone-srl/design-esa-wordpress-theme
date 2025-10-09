<?php

/**
 * Unità Organizzativa template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_CDR_Italia
 * Developer : Alessio Lazzaron, Marco Rubin
 */
global $uo_id, $file_url, $hide_arguments, $luogo;

get_header();
?>
<main>
    <?php
    while (have_posts()) :
        the_post();
        set_views($post->ID);

        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        $prefix = "_dci_unita_organizzativa_";

        $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID);
        $competenze = dci_get_wysiwyg_field("competenze");
        $tipi_organizzazione = get_the_terms($post, 'tipi_unita_organizzativa');
        $tipo_organizzazione = array_column($tipi_organizzazione, 'name') ?? null;
        $unita_organizzativa_genitore = dci_get_meta("unita_organizzativa_genitore", $prefix, $post->ID);

        $unità_organizzative_figlie = dci_get_uo_figlia($post->ID) ?? false;

        $incarichi = dci_get_meta("incarichi", $prefix, $post->ID);

        $incarichi = is_array($incarichi) ? $incarichi : [];
        $incarichi_di_responsabilita = array_filter($incarichi, fn ($incarico) => dci_get_meta('di_responsabilita', '_dci_incarico_', $incarico) == "true");
        $altri_incarichi = array_diff($incarichi, $incarichi_di_responsabilita);

        $argomenti = get_the_terms($post, 'argomenti');

        $assessore_riferimento = dci_get_meta("assessore_riferimento", $prefix, $post->ID);
        $persone = dci_get_meta("persone_struttura", $prefix, $post->ID);

        $servizi = dci_get_meta("elenco_servizi_offerti", $prefix, $post->ID);

        foreach ($servizi as $key => $servizio_id) {
            if (FALSE === get_post_status( $servizio_id ) ) {
                unset($servizi[$key]);
            }
        }
	
        $is_sede_principale_esa = dci_get_meta("is_sede_principale_esa") != "false";
        if ($is_sede_principale_esa) {
            $sede_principale_id = dci_get_meta("sede_principale", $prefix, $post->ID);
            $sede_principale = $sede_principale_id ? get_post($sede_principale_id) : null;
        }
        $show_sede_principale = $sede_principale ?? false || !$is_sede_principale_esa;
        $altre_sedi = dci_get_meta("altre_sedi_luoghi", $prefix, $post->ID);
        $punti_contatto = dci_get_meta("contatti", $prefix, $post->ID);
        $orario_ricevimento= dci_get_wysiwyg_field("orario_ricevimento");

        $allegati = dci_get_meta("allegati", $prefix, $post->ID);

        $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");

        $has_persone = (is_array($persone) && count($persone));
        $has_incarichi = (is_array($incarichi) && count($incarichi));
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
                                <div class="titolo-sezione">
                                    <h1> <?php the_title(); ?></h1>
                                </div>
                                <h2 class="visually-hidden">Dettagli dell'unit&agrave;</h2>
                                <?php if(count($tipo_organizzazione) > 1) {?>
                                <ul class="list-inline gap-1 my-3">
                                    <?php foreach ($tipo_organizzazione as $tipo) {
                                        ?>
                                        <li class="list-inline-item">
                                            <span class="chip chip-simple">
                                                <span class="chip-label"><?php echo ucfirst($tipo); ?></span>
                                            </span>
                                        </li>
                                        <?php
                                    } ?>
                                </ul>
                                <?php } else if (count($tipo_organizzazione) > 0) { ?>
                                    <span class="chip chip-simple">
                                        <span class="chip-label"><?php echo ucfirst($tipo_organizzazione[0]); ?></span>
                                    </span>
                                <?php } ?>

                                
                                <?php if(is_array($unita_organizzativa_genitore) && (count($unita_organizzativa_genitore) > 0)) { ?>
                                    Dipende da: <?php 
                                    $i = 0;
                                    foreach ($unita_organizzativa_genitore as $uo_id) {
                                        $ufficio = get_post( $uo_id );
                                        echo '<a href="' . get_permalink($ufficio->ID) . '">'. $ufficio -> post_title . '</a>';
                                        if($i < count($unita_organizzativa_genitore) -1 ) echo ", ";
                                        $i++;
                                    } ?>
                                <?php }  ?>

                                <p class="subtitle-small mb-3 mt-2">
                                    <?php echo $descrizione_breve ?>
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

        <?php get_template_part('template-parts/single/foto-large'); ?>

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
                                                            <?php if ($competenze) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#competenze">
                                                                        <span>Competenze</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($has_persone || $has_incarichi) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#persone">
                                                                        <span>Persone</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($unità_organizzative_figlie) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#uo_figlie">
                                                                        <span>Unità organizzative gestite</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            
                                                            <?php if ($servizi && is_array($servizi) && count($servizi) > 0) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#servizi">
                                                                        <span>Servizi gestiti</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if($show_sede_principale) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#sede-principale">
                                                                        <span><?php echo $altre_sedi != "" ? "Sede principale" : "Sede"; ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($altre_sedi && is_array($altre_sedi) && count($altre_sedi) > 0) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#altre-sedi">
                                                                        <span>Altre sedi</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($orario_ricevimento) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#orari">
                                                                        <span>Orari di ricevimento</span>
                                                                    </a>
                                                                </li>
															<?php } ?>
                                                            <?php if ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#contatti">
                                                                        <span>Contatti</span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($allegati && is_array($allegati) && count($allegati) > 0) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#allegati">
                                                                        <span>Documenti</span>
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
                    
                        <section id="competenze" class="it-page-section mb-4">
                            <h2 class="h3 my-2">Competenze</h2>
                            <div class="richtext-wrapper lora">
                                <?php echo $competenze ?>
                            </div>
                        </section>
                        <?php if ($has_persone || $has_incarichi) { ?>
                            <section id="persone" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Persone</h2>
                                <div class="richtext-wrapper lora">
                                    <p>Le persone che fanno parte di questa unità:</p>
                                    <div class="d-flex gap-3 flex-column mt-2">
                                        <?php
                                        $persone_incaricate = array();

                                        if ($has_incarichi) {
										?>
                                            <div class="row g-2">
                                                <?php
                                                foreach ($incarichi_di_responsabilita as $inc_id) {
                                                    $pp_id = dci_get_meta('persona', '_dci_incarico_', $inc_id);
                                                    if($pp_id){ 
                                                        $persone_incaricate[] = $pp_id;
                                                    } else {
                                                        if (FALSE !== get_post_status( $inc_id ) ) { ?>
                                                            <div class="col-lg-6 col-md-12 d-flex">
                                                                <?php 
                                                                $title_level = 3;
                                                                get_template_part("template-parts/incarico/card"); ?>
                                                            </div>  <?php 
                                                        }
                                                    }
                                                }

                                                $persone_incaricate = array_unique($persone_incaricate);


                                                foreach ($persone_incaricate as $pp_id) { ?>
                                                    <div class="col-lg-6 col-md-12 d-flex">
                                                        <?php 
                                                        $title_level = 3;
                                                        get_template_part("template-parts/persona_pubblica/card"); ?>
                                                    </div> <?php
                                                }?>
                                            </div> <?php 
											
                                        	$persone_incaricate_noresp = array();
											if($altri_incarichi){ ?>
                                                <div class="row g-2">
													<?php
                                                    foreach ($altri_incarichi as $inc_id) {
                                                        $pp_id = dci_get_meta('persona', '_dci_incarico_', $inc_id);
                                                        if($pp_id){ 
                                                            $persone_incaricate_noresp[] = $pp_id;
                                                        } else {
                                                            if (FALSE !== get_post_status( $inc_id ) ) { ?>
                                                                <div class="col-lg-6 col-md-12 d-flex">
                                                                    <?php 
                                                                    $title_level = 3;
                                                                    get_template_part("template-parts/incarico/card"); ?>
                                                                </div>  <?php 
                                                            }
                                                        }
                                                    } ?>
                                                </div> <?php

                                                $persone_incaricate_noresp = array_unique($persone_incaricate_noresp);
                                                
												?> <div class="row g-2"> <?php
                                                foreach ($persone_incaricate_noresp as $pp_id) { 
                                                   ?>
                                                        <div class="col-lg-6 col-md-12 d-flex">
                                                            <?php 
                                                            $title_level = 3;
                                                            get_template_part("template-parts/persona_pubblica/card"); ?>
                                                        </div> <?php
                                                    
												} ?> </div> <?php
                                            }
                                        }
                                        if ($has_persone) {

										?>
                                            <div class="row g-2"> <?php 
                                            foreach ($persone as $pp_id) {

                                                if(empty($persone_incaricate)){
                                                    $pp_in_array_check = true; 
                                                }else{
                                                    $pp_in_array_check = !(in_array($pp_id, $persone_incaricate, true));
                                                }

                                                if (FALSE !== get_post_status( $pp_id ) && $pp_in_array_check) {
                                                        
                                                    $with_border = true;
                                                    $hide_incarichi = true; ?>
                                                    <div class="col-lg-6 col-md-12 d-flex">
                                                        <?php 
                                                        $title_level = 3;
                                                        get_template_part("template-parts/persona_pubblica/card"); ?>
                                                    </div> <?php 
                                                } 
                                            } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </section>
                        <?php } ?>

                        <section id="uo_figlie" class="it-page-section mb-4">
                            <?php if(is_array($unità_organizzative_figlie) && (count($unità_organizzative_figlie) > 0)) { ?>
                                <h2 class="h3 my-2">Unità organizzative gestite</h3>
                                <div class="row g-2">
                                    <?php foreach ($unità_organizzative_figlie as $uo_id) {
                                        $with_border = false; ?>
                                        <div class="col-lg-6 col-md-12 d-flex">
                                            <?php 
                                            get_template_part("template-parts/unita-organizzativa/card"); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }  ?>
                        </section>

                        <?php if ($servizi &&  is_array($servizi) && count($servizi)) { ?>
                            <section id="servizi" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Servizi gestiti</h2>
                                <div class="row g-2">
                                    <?php
                                    $servizi_items = [];
                                    foreach ($servizi as $servizio_id) { 
										if (FALSE !== get_post_status( $servizio_id ) ) {
											$servizio = get_post($servizio_id);
											$priority_order = get_post_meta($servizio_id, '_dci_servizio_priority_order', true );
											$servizio->priority_order = $priority_order != "" ? intval($priority_order) : 0;

											$servizi_items[] = $servizio;
										}
                                    }
	
									usort($servizi_items, fn($a, $b) => strcmp($a->priority_order, $b->priority_order));

                                    foreach ($servizi_items as $servizio_item) { 
                                        $servizio = $servizio_item;
                                        $with_map = false;
                                        if ($servizio != null) {
                                        ?>
                                            <div class="col-lg-6 col-md-12">
                                                <?php get_template_part("template-parts/servizio/card"); ?>
                                            </div>
                                    <?php
                                        }
                                    } ?>
                                </div>
                            </section>
                        <?php }
                        if ($show_sede_principale) { ?>
                            <section id="sede-principale" class="it-page-section mb-4"> <?php 
                            if(!$altre_sedi == "") { ?>
                                <h2 class="h3 my-2">Sede principale</h2> <?php 
                            }
                            else 
                            {?>
                                <h2 class="h3 my-2">Sede</h2>
                                <?php }?>
                                <?php if ($is_sede_principale_esa && $sede_principale) { ?>
                                <?php
                                $luogo = $sede_principale;
                                $showTitle = true;
                                $showParent = true;
                                $showPermalink = true;
                                get_template_part("template-parts/luogo/card-single");
                                ?> <?php 
                            } else if (!$is_sede_principale_esa) {
                                    $luogo_option_name = 'sede_principale_custom';
                                    get_template_part("template-parts/luogo/card", "custom");
                            } ?>
                            </section>  <?php
                        }
                        if ($altre_sedi && is_array($altre_sedi) && count($altre_sedi)) { ?>
                            <section id="altre-sedi" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Altre sedi</h2>
                                <div class="row">
                                    <?php foreach ($altre_sedi as $sede_id) { ?>
                                        <div class="col-xl-6 col-lg-8 col-12 mb-4"><?php
                                            $luogo = get_post($sede_id);
                                            $with_border = false;
                                            get_template_part("template-parts/luogo/card-title"); ?>
                                        </div><?php
                                    } ?>
                                </div>
                            </section>
                        <?php  } ?>

                        <?php if ($orario_ricevimento) { ?>
                            <section id="orari" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Orari e modalità di ricevimento</h2>
                                <div class="richtext-wrapper lora">
                                    <?php echo $orario_ricevimento ?>
                                </div>
                            </section>
                        <?php } ?>
                        <?php if ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) { ?>
                            <section id="contatti" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Contatti</h2>
                                <div class="row">  <?php 
                                    foreach ($punti_contatto as $pc_id) { 
                                        $contatto = get_post($pc_id);
                                        if(isset($contatto)){?>
                                            <div class="col-md-6 col-sm-12 mb-3 card-wrapper">
                                                <?php
                                                $with_border = true;
										        $title_level = 3;
                                                get_template_part("template-parts/punto-contatto/card"); ?>
                                            </div>  <?php  
                                        }
                                    } ?>
                                </div>
                            </section>
                        <?php } ?>
                        <?php if ($allegati && is_array($allegati) && count($allegati) > 0) { ?>
                            <section id="allegati" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Documenti</h2>
                                <div class="row">
                                    <?php foreach ($allegati as $allegato_id) { ?>
                                        <div class="col-md-6 col-sm-12 mb-3 card-wrapper">
                                            <?php
                                            $documento = get_post($allegato_id);
                                            $with_border = true;
                                            get_template_part("template-parts/documento/card"); ?>
                                        </div>
                                    <?php  } ?>
                                </div>
                            </section>
                        <?php } ?>

                        <?php if ($more_info) {  ?>
                            <section id="more-info" class="it-page-section mb-4">
                                <h2 class="h3 my-2">Ulteriori informazioni</h2>
                                <div class="richtext-wrapper lora">
                                    <?php echo $more_info ?>
                                </div>
                            </section>
                        <?php }  ?>

                        <?php get_template_part('template-parts/single/page_bottom', "simple"); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part("template-parts/common/valuta-servizio"); ?>
        <?php get_template_part('template-parts/single/more-posts', 'carousel'); ?>
        <?php 
        $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
        if($visualizza_contatto == 'visible')
            get_template_part("template-parts/common/assistenza-contatti"); ?>

    <?php
    endwhile; // End of the loop.
    ?>
</main>
<?php
get_footer();
