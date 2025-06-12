<?php

/**
 * Persona pubblica template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_CDR_Italia
 * Developer : Marco Rubin
 */
global $inc_id, $uo_id, $file_url, $hide_arguments, $luogo;

$locale = setlocale(LC_ALL, 'it_IT@euro', 'it_IT', 'it', 'it');

get_header();
?>
<main>
    <?php
    while (have_posts()) :
        the_post();
        set_views($post->ID);
        
        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        $prefix = "_dci_persona_pubblica_";

        $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID);
        $nome = dci_get_meta("nome", $prefix, $post->ID);
        $cognome = dci_get_meta("cognome", $prefix, $post->ID);
        $foto = dci_get_meta("foto", $prefix, $post->ID);

        $organizzazioni = dci_get_meta("organizzazioni", $prefix, $post->ID);

        $competenze = dci_get_wysiwyg_field("competenze");
        $deleghe = dci_get_wysiwyg_field("deleghe");
        $biografia = dci_get_wysiwyg_field("biografia");

        $gallery = dci_get_meta("gallery", $prefix, $post->ID);

        $orari_ricevimento = dci_get_wysiwyg_field("orari_ricevimento", $prefix, $post->ID);
        $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID);

        $curriculum_vitae = dci_get_meta("curriculum_vitae", $prefix, $post->ID);
        $situazione_patrimoniale = dci_get_wysiwyg_field("situazione_patrimoniale");


        $dichiarazione_redditi = dci_get_meta("dichiarazione_redditi", $prefix, $post->ID);
        $spese_elettorali = dci_get_meta("spese_elettorali", $prefix, $post->ID);
        $variazione_situazione_patrimoniale = dci_get_meta("variazione_situazione_patrimoniale", $prefix, $post->ID);
        $altre_cariche = dci_get_meta("altre_cariche", $prefix, $post->ID);


        $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");

        $ids_incarichi = dci_get_meta("incarichi", $prefix, $post->ID) ?? [];


     	$inc_list = !empty($ids_incarichi) ? get_posts([
            'nopaging' => true,
            'post_type' => 'incarico',
            'post__in'=>$ids_incarichi
        ]) : [];

	 	$incarichi = array();

     	foreach($inc_list as $incarico) {
        	array_push($incarichi,$incarico->post_title);
     	}
        
        $incarichi = array_unique($incarichi);
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
                                <div class="col-auto mt-2">
                                    <?php if ($foto) { ?>
                                    <div class="avatar size-xl">
                                        <?php dci_get_img($foto); ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <div class="titolo-sezione">
                                        <h1>
                                            <?php the_title(); ?>
                                        </h1>
                                    </div>
                                    <h2 class="visually-hidden">Dettagli della persona</h2>
                                    <p class="subtitle-small mb-3" data-element="service-description">
                                    <?php
                                    	if($descrizione_breve) {
                							echo $descrizione_breve;
            							} else {
                							echo implode(', ', $incarichi);
            							} ?>
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
                                                        <?php if ($biografia || $curriculum_vitae) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#biografia">
                                                                <span>Biografia e curriculum</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($competenze) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#competenze">
                                                                <span>Competenze</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($inc_list && is_array($inc_list) && count($inc_list) > 0) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#incarichi">
                                                                <span>Incarichi</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($organizzazioni && is_array($organizzazioni) && count($organizzazioni) > 0) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#organizzazioni">
                                                                <span>Fa parte di</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>
                                                        
                                                        <?php if ($orari_ricevimento) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#orari_ricevimento">
                                                                <span>Orari di ricevimento</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#contatti">
                                                                <span>Contatta la persona</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($gallery && is_array($gallery) && count($gallery) > 0) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#gallery">
                                                                <span>Galleria di immagini</span>
                                                            </a>
                                                        </li>
                                                        <?php } 
                                                        if (
                                                            ($dichiarazione_redditi && is_array($dichiarazione_redditi) && count($dichiarazione_redditi) > 0)
                                                            || ($variazione_situazione_patrimoniale && is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) > 0)
                                                        ) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#situazione_patrimoniale">
                                                                    <span>Situazione patrimoniale</span>
                                                                </a>
                                                            </li>  <?php
                                                        } 
                                                        if (
                                                             ($spese_elettorali && is_array($spese_elettorali) && count($spese_elettorali) > 0)
                                                             || ($altre_cariche && is_array($altre_cariche) && count($altre_cariche) > 0)
                                                        ) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#altri_documenti">
                                                                    <span>Altri documenti</span>
                                                                </a>
                                                            </li> <?php
                                                        }  
                                                        if ($more_info) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#more-info">
                                                                    <span>Ulteriori informazioni</span>
                                                                </a>
                                                            </li> <?php 
                                                        } ?>
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

                    <?php if($biografia || $curriculum_vitae) {  ?>
                    <section id="biografia" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Biografia e curriculum</h2>
                        <div class="richtext-wrapper lora">
                            <?php echo $biografia ?>
                        </div>
                        <?php if ($curriculum_vitae != "") {?>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php
                                $doc = attachment_url_to_postid($curriculum_vitae);

                                if($doc != 0) {
                                    $idfile = $doc;
                                    get_template_part("template-parts/documento/file");
                                } else {
                                    $url = $curriculum_vitae;
                                    $url_label = "Curriculum vitae";
                                    get_template_part("template-parts/documento/url");
                                }
                            ?>
                        </div>
                        <?php }?>
                    </section>
                    <?php } ?>

                    <?php if($competenze) {  ?>
                    <section id="competenze" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Competenze</h2>
                        <div class="richtext-wrapper lora">
                            <?php echo $competenze ?>
                        </div>
                    </section>
                    <?php } ?>

                    <?php if ($inc_list && is_array($inc_list) && count($inc_list) > 0) {?>
                    <section id="incarichi" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Incarichi</h2>
                        <div class="row">
                            <?php foreach ($inc_list as $incarico) { ?>
                                <div class="col-xl-6 col-lg-8 col-md-12 pb-3"> <?php
                                    $inc_id = $incarico->ID;
                                    $show_Persona = false;
                                    get_template_part("template-parts/incarico/card");
                                ?> </div>
                            <?php } ?>
                        </div>
                    </section>
                    <?php }?>

                    <?php if ($organizzazioni && is_array($organizzazioni) && count($organizzazioni) > 0) {?>
                    <section id="organizzazioni" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Fa parte di</h2>
                        <div class="row g-0 card-wrapper card-teaser-wrapper d-flex align-items-stretch">
                            <?php foreach ($organizzazioni as $uo_id) {
                                      $with_border = true;
                                      get_template_part("template-parts/unita-organizzativa/card");
                            } ?>
                        </div>
                    </section>
                    <?php }?>

                    <?php if ($orari_ricevimento) { ?>
                    <section id="orari_ricevimento" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Orari di ricevimento</h2>
                        <div class="richtext-wrapper lora">
                            <?php echo $orari_ricevimento ?>
                        </div>
                    </section>
                    <?php } ?>

                    <?php if ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) { ?>
                    <section id="contatti" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Contatta la persona</h2>
                        <div class="row">
                            <?php 
                            foreach ($punti_contatto as $pc_id) { 
                                $contatto = get_post($pc_id);
                                if(isset($contatto)){?>
                                    <div class="col-xl-6 col-lg-8 col-md-12 pb-3">
                                        <?php
                                              $with_border = true;
                                              get_template_part("template-parts/punto-contatto/card"); ?>
                                    </div> <?php
                                }
                            } ?>
                        </div>
                    </section>
                    <?php } ?>

                    <?php if (is_array($gallery) && count($gallery)) {
                    ?><section id="gallery" class="it-page-section mb-4">
                        <h3>
                            Galleria di immagini
                        </h3>
                        <?php
                              get_template_part("template-parts/single/gallery");
                        ?>
                    </section><?php
                          } ?>

                    <?php
        if (
            $situazione_patrimoniale
            || ($dichiarazione_redditi && is_array($dichiarazione_redditi) && count($dichiarazione_redditi) > 0)
            || ($variazione_situazione_patrimoniale && is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) > 0)
        )
        {
                    ?>
                    <section id="situazione_patrimoniale" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Situazione patrimoniale</h2>

                        <div class="richtext-wrapper lora">
                            <?php echo $situazione_patrimoniale ?>
                        </div>

                        <?php if ($dichiarazione_redditi && is_array($dichiarazione_redditi) && count($dichiarazione_redditi) > 0) {?>
                        <h3 class="h4">Dichiarazione dei redditi</h3>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($dichiarazione_redditi as $allegato_id) {
                                      $doc = attachment_url_to_postid($allegato_id);

                                      $idfile = $doc;
                                      get_template_part("template-parts/documento/file");
                                  } ?>
                        </div>
                        <?php }?>

                        <?php if ($variazione_situazione_patrimoniale && is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) > 0) {?>
                        <h3 class="h4">Variazione situazione patrimoniale</h3>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($variazione_situazione_patrimoniale as $allegato_id) {
                                      $doc = attachment_url_to_postid($allegato_id);

                                      $idfile = $doc;
                                      get_template_part("template-parts/documento/file");
                                  } ?>
                        </div>
                        <?php }?>


                    </section>


                    <?php
        }
                    ?>


                    <?php
        if (
            ($spese_elettorali && is_array($spese_elettorali) && count($spese_elettorali) > 0)
            || ($altre_cariche && is_array($altre_cariche) && count($altre_cariche) > 0)
        )
        {
                    ?>
                    <section id="altri_documenti" class="it-page-section mb-4">
                        <h2 class="h3 my-2">Altri documenti</h2>

                        <?php if ($spese_elettorali && is_array($spese_elettorali) && count($spese_elettorali) > 0) {?>
                        <h3 class="h4">Spese elettorali</h3>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($spese_elettorali as $allegato_id) {
                                      $doc = attachment_url_to_postid($allegato_id);

                                      $idfile = $doc;
                                      get_template_part("template-parts/documento/file");
                                  } ?>
                        </div>
                        <?php }?>

                        <?php if ($altre_cariche && is_array($altre_cariche) && count($altre_cariche) > 0) {?>
                        <h3 class="h4">Altre cariche</h3>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($altre_cariche as $allegato_id) {
                                      $doc = attachment_url_to_postid($allegato_id);

                                      $idfile = $doc;
                                      get_template_part("template-parts/documento/file");
                                  } ?>
                        </div>
                        <?php }?>


                    </section>


                    <?php
        }
                    ?>

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
            get_template_part("template-parts/common/assistenza-contatti"); 
    ?>

    <?php
    endwhile; // End of the loop.
    ?>
</main>
<?php
get_footer();