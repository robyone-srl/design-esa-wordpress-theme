<?php

/**
 * Incarico template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_CDR_Italia
 * Developer : Marco Rubin
 */
global $uo_id, $file_url, $hide_arguments, $luogo, $documento;

$locale = setlocale(LC_ALL, 'it_IT@euro', 'it_IT', 'it', 'it');

get_header();
?>
    <main>
		<?php
		while (have_posts()) :
		
			the_post();
            set_views($post->ID);

			$user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

			$prefix = "_dci_incarico_";

			$tipo_incarico = wp_get_object_terms( $post->ID,  'tipi_incarico' );
            $data_inizio_incarico = dci_get_meta('data_inizio_incarico', $prefix, $post->ID);
            $data_insediamento = dci_get_meta('data_insediamento', $prefix, $post->ID);
            $data_conclusione_incarico = dci_get_meta('data_conclusione_incarico', $prefix, $post->ID);
            
            $responsabile_struttura = dci_get_meta('responsabile_struttura', $prefix, $post->ID);

            $compensi = dci_get_wysiwyg_field("compensi", $prefix, $post->ID);
            $importi_viaggi_servizi = dci_get_wysiwyg_field("importi_viaggi_servizi", $prefix, $post->ID);
            $ulteriori_informazioni = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $post->ID);

            $atto_nomina = dci_get_meta("atto_nomina", $prefix, $post->ID);

            $unita_organizzativa = dci_get_meta('incarico_unita_organizzative', $prefix, $post->ID);

            $url_trasparenza = dci_get_meta("url_trasparenza", $prefix, $post->ID);

            $servizi_incarico = dci_get_meta("servizi_incarico", $prefix, $post->ID);
            $sede = dci_get_meta("luoghi_incarico", $prefix, $post->ID);

            $persona = dci_get_meta('persona', $prefix, $post->ID);

            if($persona != "") {
                $persona = get_post($persona);
            }
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
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="titolo-sezione">
                                                <h1> <?php the_title(); ?></h1>
                                            </div>
                                            
                                            <h2 class="visually-hidden">Dettagli dell'incarico</h2>
                                            <p class="subtitle-small mb-3" data-element="service-description">
										        Incarico <?php echo strtolower($tipo_incarico[0]->name); ?> 
                                                <?php if($persona != "") { ?>
                                                assunto da <?php echo $persona->post_title ?>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
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
																<?php if($persona != "") { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#titolare">
                                                                            <span>Titolare</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>
                                                                
                                                                <?php if($data_inizio_incarico != "" || $data_insediamento != "" || $data_conclusione_incarico != "") { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#periodo">
                                                                            <span>Periodo di svolgimento</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>


                                                                <?php if($url_trasparenza) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#url_trasparenza">
                                                                            <span>Trasparenza</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>

                                                                <?php if ($unita_organizzativa) {?>
                                                                    <li class="nav-item">
                                                                            <a class="nav-link" href="#unita_organizzativa">
                                                                                <span>Unità organizzative di appartenenza </span>
                                                                            </a>
                                                                        </li>
																<?php } ?>

                                                                <?php if ($servizi_incarico) {?>
                                                                    <li class="nav-item">
                                                                            <a class="nav-link" href="#servizi">
                                                                                <span>Servizi di competenza</span>
                                                                            </a>
                                                                        </li>
																<?php } ?>

                                                                <?php if ($sede) {?>
                                                                    <li class="nav-item">
                                                                            <a class="nav-link" href="#sede">
                                                                                <span>Luoghi gestiti</span>
                                                                            </a>
                                                                    </li>
																<?php } ?>

                                                                <?php if ($responsabile_struttura) {?>
                                                                    <li class="nav-item">
                                                                            <a class="nav-link" href="#responsabile_struttura">
                                                                                <span>Ruolo di responsabilità</span>
                                                                            </a>
                                                                        </li>
																<?php } ?>
                                                                

                                                                <?php if ($atto_nomina) {?>
                                                                    <li class="nav-item">
                                                                            <a class="nav-link" href="#atto_di_nomina">
                                                                                <span>Atto di nomina</span>
                                                                            </a>
                                                                        </li>
																<?php } ?>

                                                                <?php if($compensi) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#compensi">
                                                                            <span>Compensi</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

																<?php if ($importi_viaggi_servizi) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#importi_viaggi_servizi">
                                                                            <span>Importi di viaggi e servizi</span>
                                                                        </a>
                                                                    </li>
																<?php } ?>

																<?php if ($ulteriori_informazioni) { ?>
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
                            if ($persona) {?>
                                <section id="titolare" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Titolare</h2>
                                            <div class="card-wrapper card-teaser-wrapper">
                                                <?php 
                                                    $with_border = true;
                                                    $pp_id = $persona->ID;
                                                    get_template_part("template-parts/persona_pubblica/card");
                                                ?>
                                            </div>
                                </section>
                            <?php }?>

                            <?php if($data_inizio_incarico != "" || $data_insediamento != "" || $data_conclusione_incarico != "") { ?>
                                <section id="periodo" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Periodo di svolgimento</h2>

                                    <div class="richtext-wrapper lora">
                                        <?php if($data_inizio_incarico != "") {?>
                                            <p class="mb-0"><strong>Inizio:</strong> <?php echo printDateTime('d LLLL Y', $data_inizio_incarico); ?></p>
                                        <?php } ?>

                                        <?php if($data_insediamento != "") {?>
                                            <p class="mb-0"><strong>Insediamento:</strong> <?php echo printDateTime('d LLLL Y', $data_insediamento); ?></p>
                                        <?php } ?>

                                        <?php if($data_conclusione_incarico != "") {?>
                                            <p class="mb-0"><strong>Conclusione:</strong> <?php echo printDateTime('d LLLL Y', $data_conclusione_incarico); ?></p>
                                        <?php } ?>
                                    </div>
                                </section>
							<?php } ?>

                            <?php if ($url_trasparenza) {?>
                                <section id="url_trasparenza" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Trasparenza</h2>
                                            <div class="card-wrapper card-teaser-wrapper">
                                                <?php
                                                   $url = $url_trasparenza;
                                                   $url_label = "Scheda dedicata all'incarico in Amministrazione Trasparente";
                                                   get_template_part("template-parts/documento/url");
                                                ?>
                                            </div>
                                </section>
                            <?php }?>

                            <?php if ($unita_organizzativa) {?>
                                <section id="unita_organizzativa" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Unità organizzative di appartenenza</h2>
                                    <?php if(count($unita_organizzativa) == 1){
                                        echo "<p>Questo incarico si riferisce a una unità organizzativa.</p>";
                                    }else{
                                        echo "<p>Questo incarico si riferisce a ". count($unita_organizzativa) ." unità organizzative.</p>";
                                    } ?>
                                        <?php foreach($unita_organizzativa as $uo){ ?>
                                            <div class="card-wrapper card-teaser-wrapper">
                                                <?php
                                                    $uo_id = get_post($uo);
                                                    $with_border = true;
                                                    get_template_part("template-parts/unita-organizzativa/card");
                                                ?>
                                            </div>
                                            <?php } ?>
                                </section>
                            <?php }?>

                            <?php if ($servizi_incarico &&  is_array($servizi_incarico) && count($servizi_incarico)) { ?>
                                <section id="servizi" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Servizi di competenza</h2>
                                    <?php if(count($servizi_incarico) == 1){
                                        echo "<p>Questo incarico prevede la gestione di un servizio.</p>";
                                    }else{
                                        echo "<p>Questo incarico prevede la gestione di ". count($servizi_incarico) ." servizi.</p>";
                                    } ?>
                                    <div class="row g-2">
                                        <?php foreach ($servizi_incarico as $servizio_id) { 
                                            $servizio = get_post($servizio_id);
                                            $with_map = false;
                                            if ($servizio != null) {
                                            ?>
                                                <div class="col-lg-6 col-md-12">
                                                    <?php get_template_part("template-parts/servizio/card"); ?>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                </section>
                            <?php }?>

                            <?php if ($sede && is_array($sede) && count($sede)) { ?>
                                <section id="sede" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Luoghi gestiti</h2>
                                    <?php if(count($sede) == 1){
                                        echo "<p>L'incarico è referente per un luogo.</p>";
                                    }else{
                                        echo "<p>L'incarico è referente per ". count($sede) ." luoghi.</p>";
                                    } ?>
                                    <div class="row">
                                        <?php foreach ($sede as $sede_id) { ?>
                                            <div class="col-xl-6 col-lg-8 col-12 mb-4"><?php
                                                $luogo = get_post($sede_id);
                                                $with_border = false;
                                                get_template_part("template-parts/luogo/card-title"); ?>
                                            </div><?php
                                        } ?>
                                    </div>
                                </section>
                            <?php  } ?>

                            <?php if ($atto_nomina) { ?>
                                <article id="atto_di_nomina" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Atto di nomina</h2>
                                    <div class="col-md-6 col-sm-12 mb-3 card-wrapper">
                                        <?php
                                        $documento = get_post($atto_nomina);
                                        $with_border = true;
                                        get_template_part("template-parts/documento/card"); ?>
                                    </div>
                                </article>
                            <?php } ?>


                            <?php if ($responsabile_struttura) {?>
                                <section id="responsabile_struttura" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Ruolo di responsabilità</h2>
                                        <div class="card-wrapper card-teaser-wrapper">
                                            <?php
                                                $uo_id = $responsabile_struttura;
                                                $with_border = true;
                                                get_template_part("template-parts/unita-organizzativa/card");
                                            ?>
                                        </div>
                                </section>
                            <?php }?>

                            <?php if($compensi) { ?>
                                <section id="compensi" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Compensi</h2>

                                    <div class="richtext-wrapper lora">
                                        <?php echo $compensi; ?>
                                    </div>
                                </section>
							<?php } ?>

                            <?php if($importi_viaggi_servizi) { ?>
                                <section id="importi_viaggi_servizi" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Importi di viaggi e/o servizio</h2>

                                    <div class="richtext-wrapper lora">
                                        <?php echo $importi_viaggi_servizi; ?>
                                    </div>
                                </section>
							<?php } ?>

							<?php if ($ulteriori_informazioni) {  ?>
                                <section id="more-info" class="it-page-section mb-4">
                                    <h2 class="h3 my-2">Ulteriori informazioni</h2>
                                    <div class="richtext-wrapper lora">
										<?php echo $ulteriori_informazioni ?>
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
                    get_template_part("template-parts/common/assistenza-contatti"); 
            ?>

		<?php
		endwhile; // End of the loop.
		?>
    </main>
<?php
get_footer();