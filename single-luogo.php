<?php

/**
 * Luogo template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_CDR_Italia
 * Developer : Alessio Lazzaron, Marco Rubin
 */
global $file_url, $hide_arguments, $luogo, $mostra_dettagli_servizi, $mostra_dettagli_sede;

get_header();
?>
    <main>
        <?php
		while (have_posts()) :
			the_post();
            set_views($post->ID);
			$user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

			$prefix = "_dci_luogo_";

            $immagine = get_the_post_thumbnail_url($post->ID);
            $descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $post->ID);
            $tipi_luogo = get_the_terms($post->ID,'tipi_luogo');

			$descrizione = dci_get_wysiwyg_field("descrizione_estesa");

            $childof  = dci_get_meta("childof", $prefix, $post->ID);
            $luoghi_collegati = dci_get_meta('luoghi_collegati', $prefix, $post->ID);

            $servizi_privati = dci_get_wysiwyg_field("servizi");
            $modalita_accesso = dci_get_wysiwyg_field("modalita_accesso");

            $indirizzo = dci_get_meta('indirizzo', $prefix, $post->ID);

            $orario_pubblico = dci_get_wysiwyg_field("orario_pubblico");

            $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID);

            $incarichi = dci_get_meta("incarichi", $prefix, $post->ID);

            $gestito_da = dci_get_meta('struttura_responsabile', $prefix, $post->ID);

            $gallery = dci_get_meta("gallery", $prefix, $post->ID);

            $sede_di = dci_get_meta('sede_di', $prefix, $post->ID);

            $servizi = dci_get_meta('servizi_erogati', $prefix, $post->ID) ?: [];

            $tipo_visualizzazione_servizi = dci_get_option('visual_servizi_luogo', 'luoghi');
            if($tipo_visualizzazione_servizi == 'enabled'){
                $mostra_dettagli_servizi = true;
            } else {
                 $mostra_dettagli_servizi = false;
            }
            
            $tipo_visualizzazione_sede = dci_get_option('view_select', 'luoghi');
            if($tipo_visualizzazione_sede == 'enabled' || $tipo_visualizzazione_sede == null){
                $mostra_dettagli_sede = true;
            } else {
                 $mostra_dettagli_sede = false;
            }

            $nome_alternativo = dci_get_meta('nome_alternativo', $prefix, $post->ID);
			$more_info = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $post->ID);
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
                                    <h2 class="visually-hidden">Dettagli del luogo</h2>
                                    <?php if($nome_alternativo){ ?>
                                    <div>
                                    <p class="subtitle-small mb-3">
                                        <i>Luogo conosciuto anche come <?php echo $nome_alternativo ?></i>
                                    </p>
                                    </div>
                                    <?php } ?>
                                    <p class="subtitle-small mb-3">
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
                                                                        <a class="nav-link" href="#descrizione">
                                                                            <span>Caratteristiche</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

                                                                <?php if ($gallery && is_array($gallery) && count($gallery) > 0) {?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gallery">
                                                                        <span>Galleria di immagini</span>
                                                                    </a>
                                                                </li>
                                                                <?php } ?>

																<?php if ($indirizzo || $childof) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#dove_si_trova">
                                                                            <span>Dove si trova</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

																<?php if ($modalita_accesso) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#modalita_accesso">
                                                                            <span>Modalità di accesso</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

																<?php if ($orario_pubblico) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#orario_pubblico">
                                                                            <span>Orari di apertura</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

                                                                <?php if ($servizi_privati || isset($servizi)) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#servizi">
                                                                            <span>Servizi presenti</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>

                                                                
                                                                <?php if ($sede_di && is_array($sede_di) && count($sede_di) > 0) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#sede_di">
                                                                            <span>Sede di</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                
																<?php if (
                                                                    ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) ||
                                                                    ($gestito_da && is_array($gestito_da) && count($gestito_da) > 0) ||
                                                                    ($incarichi && is_array($incarichi) && count($incarichi) > 0)
                                                                ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#contatti">
                                                                            <span>Contatti</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

                                                                <?php if ($luoghi_collegati && is_array($luoghi_collegati) && count($luoghi_collegati) > 0) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#luoghi_collegati">
                                                                            <span>Luoghi correlati</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>

																<?php if ($more_info || $nome_alternativo) { ?>
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
                            <?php 
                                $args = array(
		                                'post_parent'    => $post->ID,
		                                'order'          => 'ASC',
		                                'post_type'      => 'luogo',
	                                );
                                $arr_figli = get_children($args);

                                if ($descrizione || $arr_figli) { ?>
                                <section id="descrizione" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Caratteristiche</h2>
                                    <?php
                                        if ($descrizione) {
                                            ?><div class="richtext-wrapper lora">
                                                <?php echo $descrizione ?>
                                            </div><?php
                                        }
	                                
                                        if($arr_figli){ ?>
                                            <h3 class="h4">Ospita</h3>
                                            <div class="row d-flex align-items-stretch"> <?php

                                                $luoghi_items_ordered = [];
                                                foreach($arr_figli as $arr_figli_id){ 
                                                    $luogo = $arr_figli_id;
                                                    $priority_order = get_post_meta($arr_figli_id->ID, '_dci_luogo_priority_order', true );
                                                    $luogo->priority_order = $priority_order != "" ? intval($priority_order) : 0;

                                                    $luoghi_items_ordered[] = $luogo;

                                                    usort($luoghi_items_ordered, fn($a, $b) => strcmp($a->priority_order, $b->priority_order));
                                                }

                                                foreach($luoghi_items_ordered as $luogo_item){
                                                    $luogo = $luogo_item;
                                                    if($luogo != null){
                                                        ?> <div class="col-lg-6 col-md-12 d-flex"> <?php 
                                                            $show_descrizione = true;
                                                            get_template_part("template-parts/luogo/card-title");
                                                        ?> </div> <?php
                                                    }
                                                }
                                            ?> </div> <?php
                                        }
                                    ?>
                                </section>
                            <?php } ?>

                            
                            <?php if (is_array($gallery) && count($gallery)) { ?>
                            <section id="gallery" class="it-page-section mb-4">
                                <h3>
                                    Galleria di immagini
                                </h3>
                                <?php get_template_part("template-parts/single/gallery");?>
                            </section>
                            <?php } ?>


                            <?php if ($indirizzo || $childof) { ?>
                                <section id="dove_si_trova" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Dove si trova</h2>
                                    <?php
                                                        $luogo = $post;
                                                        $showTitle = false;
                                                        $showParent = true;
                                                        get_template_part("template-parts/luogo/card-single");
                                    ?>
                                </section>
                            <?php } ?>

                            <?php if ($modalita_accesso) { ?>
                                <section id="modalita_accesso" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Modalità di accesso</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $modalita_accesso ?>
                                    </div>
                                </section>
                            <?php } ?>

                            <?php if ($orario_pubblico) { ?>
                                <section id="orario_pubblico" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Orari di apertura</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $orario_pubblico ?>
                                    </div>
                                </section>
                            <?php } ?>

                            <?php if ($servizi_privati || (is_array($servizi) && count($servizi))) { ?>
                                <section id="servizi" class="it-page-section mb-4"> <?php 
                                    
                                    if (!empty($servizi) &&  is_array($servizi) && count($servizi)) {  ?>
                                        <h2 class="h3 my-2">Servizi presenti nel luogo</h2> <?php
                                        if(count($servizi)>1){?>
                                            <p>In questo luogo vengono erogati <?php echo count($servizi); ?> servizi.</p> <?php
                                        }else{?>
                                            <p>In questo luogo viene erogato 1 servizio.</p> <?php
                                        }?>
                                            <a class="btn btn-primary btn-icon btn-xs mb-3" data-bs-toggle="collapse" href="#collapseServiziPresenti" role="button" aria-expanded="false" aria-controls="collapseServiziPresenti">
											    Mostra i servizi presenti 
                                                <svg class="icon icon-white ms-5 chevron"><use href="#it-expand"></use></svg>
											</a>
											
									        <div class="collapse clearfix mt-0 me-5" id="collapseServiziPresenti">
										        <div class="row g-4">
											        <?php foreach ($servizi as $servizio_id) { ?>
														<div class="col-lg-4 col-md-12">
															<?php
															$servizio = get_post($servizio_id);
															$with_map = false;
															if($tipo_visualizzazione_servizi == 'enabled' || $tipo_visualizzazione_servizi == 'disabled'){
																get_template_part("template-parts/servizio/card");
															} else
																get_template_part("template-parts/servizio/card-con-icona");?>
														</div> <?php 
													} ?>
											    </div>
										    </div>
									
									<?php
                                        
							        }

                                    if ($servizi_privati) { 
                                        if(is_array($servizi) && count($servizi)){ ?> <h3 class="h4 mt-4">Altri servizi</h3> <?php } ?>
                                        <div class="richtext-wrapper lora">
                                            <?php echo $servizi_privati ?>
                                        </div>
                                    <?php } ?>
                                </section>
                            <?php } ?>

							<?php if ($sede_di && is_array($sede_di) && count($sede_di) > 0) { ?>
                                <section id="sede_di" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Sede di</h2>

									<p>Questo luogo è sede di <?php if (count($sede_di) == 1) { echo "1 unità organizzativa"; } else { echo count($sede_di) . " unità organizzative"; } ?>.</p>

                                    <a class="btn btn-primary btn-icon btn-xs mb-3" data-bs-toggle="collapse" href="#collapseUnitaPresenti" role="button" aria-expanded="false" aria-controls="collapseUnitaPresenti">
										Mostra le unità
                                        <svg class="icon icon-white ms-5 chevron"><use href="#it-expand"></use></svg>
									</a>
											
									<div class="collapse clearfix mt-0 me-5" id="collapseUnitaPresenti">
										<div class="row d-flex align-items-stretch">  <?php 
                                            foreach ($sede_di as $uo_id) { ?>  
                                                <div class="col-lg-6 col-md-12 d-flex"><?php
													$with_border = true;
													$h100 = true;
													get_template_part("template-parts/unita-organizzativa/card"); ?>
                                                </div><?php
											} ?>
										</div>
									</div>
                                </section>
                            <?php } ?>
							
							<?php if 
                            (
                                    ($gestito_da && is_array($gestito_da) && count($gestito_da) > 0) ||
                                    ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) ||
                                    ($incarichi && is_array($incarichi) && count($incarichi) > 0)
                            ){ ?>
                                <section id="contatti" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Contatti</h2>
                                    
                                    <div class="row mb-4"> <?php 
                                        foreach ($punti_contatto as $pc_id) { 
                                            $contatto = get_post($pc_id);
                                            if(isset($contatto)){?>
                                                <div class="col-xl-6 col-lg-8 col-md-12 ">
                                                    <?php
                                                    $with_border = true;
                                                    $title_level = 3;
                                                    get_template_part("template-parts/punto-contatto/card"); ?>
                                                </div> <?php  
                                            }
                                        } ?>
                                    </div>

                                    <?php if ($incarichi) { ?>
                                        <h3 class="h4 mt-4 mb-2">Contatta le persone</h3>
                                    <?php } ?>
                                    <?php if ($incarichi) { ?>
                                        <div class="row g-2 mb-4">
                                            <?php foreach ($incarichi as $incarico_id) { 
                                            ?>
                                                <div class="col-xl-6 col-lg-8 col-md-12">
                                                    <?php 
                                                    $title_level = 4;
                                                    get_template_part("template-parts/incarico/card-person-contacts"); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <?php if (($gestito_da && is_array($gestito_da) && count($gestito_da) > 0) && ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) && ($incarichi)) { ?>
                                        <h3 class="h4 mt-4 mb-2">Contatta il gestore</h3>
                                    <?php } ?>
                                    <?php if($gestito_da && is_array($gestito_da) && count($gestito_da) > 0){?>
                                        <div class="row">
                                                <?php foreach ($gestito_da as $uo_id) {
                                                ?><div class="col-xl-6 col-lg-8 col-md-12"><?php
                                                    $with_border = true;
                                                    $no_vertical_margin = true;
                                                    $title_level = 4;
                                                    get_template_part("template-parts/unita-organizzativa/card-full");
                                                    ?></div><?php
                                                } ?>
                                        </div>
							        <?php } ?>

                                </section>
							<?php } ?>

                            <?php if ($luoghi_collegati && is_array($luoghi_collegati) && count($luoghi_collegati) > 0) { ?>
                                <section id="luoghi_collegati" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Luoghi correlati</h2>
                                    
                                    <div class="row">
                                        <?php foreach ($luoghi_collegati as $luogo_id) {
                                            ?><div class="col-xl-6 col-lg-8 col-md-12"><?php
                                            $with_border = true;
                                            $luogo = get_post( $luogo_id );
                                            get_template_part("template-parts/luogo/card-title");
                                            ?></div><?php
                                        } ?>
                                    </div>
                                </section>
                            <?php } ?>

							<?php if ($more_info || $nome_alternativo) { ?>
                                <section id="more-info" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Ulteriori informazioni</h2>

                                    <?php if($nome_alternativo){ ?>
                                    <div>
                                        <strong>Nome alternativo:</strong> <?php echo $nome_alternativo ?>
                                    </div>
                                    <?php } ?>

                                    <?php if($more_info) { ?>
                                        <div class="richtext-wrapper lora">
                                            <?php echo $more_info ?>
                                        </div>
                                    <?php }?>
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
                    get_template_part("template-parts/common/assistenza-contatti"); 
            ?>

		<?php
		endwhile; // End of the loop.
		?>
    </main>
<?php
get_footer();