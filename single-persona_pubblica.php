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

        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        $prefix = "_dci_persona_pubblica_";

        $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID);
        $nome = dci_get_meta("nome", $prefix, $post->ID);
        $cognome = dci_get_meta("cognome", $prefix, $post->ID);
        $foto = dci_get_meta("foto", $prefix, $post->ID);

        $organizzazioni = dci_get_meta("organizzazioni", $prefix, $post->ID);
        $responsabile_di = dci_get_meta("responsabile_di", $prefix, $post->ID);

        $competenze = dci_get_wysiwyg_field("competenze");
        $deleghe = dci_get_wysiwyg_field("deleghe");
        $biografia = dci_get_wysiwyg_field("biografia");

        $gallery = dci_get_meta("gallery", $prefix, $post->ID);

        $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID);

        $curriculum_vitae = dci_get_meta("curriculum_vitae", $prefix, $post->ID);
        $situazione_patrimoniale = dci_get_wysiwyg_field("situazione_patrimoniale");


        $dichiarazione_redditi = dci_get_meta("dichiarazione_redditi", $prefix, $post->ID);
        $spese_elettorali = dci_get_meta("spese_elettorali", $prefix, $post->ID);
        $variazione_situazione_patrimoniale = dci_get_meta("variazione_situazione_patrimoniale", $prefix, $post->ID);
        $altre_cariche = dci_get_meta("altre_cariche", $prefix, $post->ID);


        $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");

        $inc_args = array(
            'post_type' => 'incarico',
            'meta_query' => array(
                array(
                    'key'     => '_dci_incarico_persona',
                    'value'   => $post->ID
                ),
            ),
            'numberposts' => -1,
	        'post_status' => 'publish',
	        'orderby' => 'post_title',
	        'order' => 'ASC',
        );
        $inc_query = new WP_Query( $inc_args );
     	$inc_list = get_posts($inc_args);

	 	$incarichi = array();

     	foreach($inc_list as $incarico) {
        	array_push($incarichi,$incarico->post_title);
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
                                <div class="col-auto mt-2">
                                    <?php if ($foto) { ?>
                                    <div class="avatar size-xl">
                                        <?php dci_get_img($foto); ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-auto">
                                    <div class="titolo-sezione">
                                        <h1>
                                            <?php the_title(); ?>
                                        </h1>
                                    </div>
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
        <div class="row justify-content-center">
            <hr class="d-none d-lg-block mt-2" />
        </div>
    </div>

    <div class="container">
        <div class="row row-column-menu-left mt-4 mt-lg-80 pb-lg-80 pb-40">
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
                                                        <?php if ($biografia || $curriculum_vitae) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#biografia">
                                                                <span class="title-medium">Biografia e curriculum</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($competenze) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#competenze">
                                                                <span class="title-medium">Competenze</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($inc_list && is_array($inc_list) && count($inc_list) > 0) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#incarichi">
                                                                <span class="title-medium">Ruolo</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($organizzazioni && is_array($organizzazioni) && count($organizzazioni) > 0) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#organizzazioni">
                                                                <span class="title-medium">Fa parte di</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($responsabile_di) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#responsabile_id">
                                                                <span class="title-medium">È responsabile di</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#contatti">
                                                                <span class="title-medium">Contatti</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php if ($gallery && is_array($gallery) && count($gallery) > 0) {?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#gallery">
                                                                <span class="title-medium">Galleria di immagini</span>
                                                            </a>
                                                        </li>
                                                        <?php } ?>

                                                        <?php
        if (
            ($dichiarazione_redditi && is_array($dichiarazione_redditi) && count($dichiarazione_redditi) > 0)
            || ($variazione_situazione_patrimoniale && is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) > 0)
        )
        {
                                                        ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#situazione_patrimoniale">
                                                                <span class="title-medium">Situazione patrimoniale</span>
                                                            </a>
                                                        </li>
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
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#altri_documenti">
                                                                <span class="title-medium">Altri documenti</span>
                                                            </a>
                                                        </li>
                                                        <?php
        }
                                                        ?>



                                                        <?php if ($more_info) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#more-info">
                                                                <span class="title-medium">Ulteriori informazioni</span>
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
            <div class="col-12 col-lg-8 offset-lg-1">
                <div class="it-page-sections-container">

                    <?php if($biografia || $curriculum_vitae) {  ?>
                    <section id="biografia" class="it-page-section mb-4">
                        <h3 class="my-2 title-large-semi-bold">Biografia e curriculum</h3>
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
                        <h3 class="my-2 title-large-semi-bold">Competenze</h3>
                        <div class="richtext-wrapper lora">
                            <?php echo $competenze ?>
                        </div>
                    </section>
                    <?php } ?>

                    <?php if ($inc_list && is_array($inc_list) && count($inc_list) > 0) {?>
                    <section id="incarichi" class="it-page-section mb-4">
                        <h3 class="my-2 title-large-semi-bold">Ruolo</h3>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($inc_list as $incarico) {
                                      get_template_part("template-parts/incarico/card-full");
                                  } ?>
                        </div>
                    </section>
                    <?php }?>

                    <?php if ($organizzazioni && is_array($organizzazioni) && count($organizzazioni) > 0) {?>
                    <section id="organizzazioni" class="it-page-section mb-4">
                        <h3 class="my-2 title-large-semi-bold">Fa parte di</h3>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($organizzazioni as $uo_id) {
                                      $with_border = true;
                                      get_template_part("template-parts/unita-organizzativa/card");
                                  } ?>
                        </div>
                    </section>
                    <?php }?>

                    <?php if (!empty($responsabile_di)) {?>
                    <section id="responsabile_id" class="it-page-section mb-4">
                        <h3 class="my-2 title-large-semi-bold">Responsabile di</h3>
                        <div class="row">
                            <div class="col-xl-6 col-lg-8 col-md-12 ">
                                <?php
                              foreach($responsabile_di as $uo_id){
                                  $with_border = true;
                                  get_template_part("template-parts/unita-organizzativa/card");
                              }
                                ?>
                            </div>
                        </div>
                    </section>
                    <?php }?>

                    <?php if ($punti_contatto && is_array($punti_contatto) && count($punti_contatto) > 0) { ?>
                    <section id="contatti" class="it-page-section mb-4">
                        <h3 class="my-2 title-large-semi-bold">Contatti</h3>
                        <div class="row">
                            <?php foreach ($punti_contatto as $pc_id) { ?>
                            <div class="col-xl-6 col-lg-8 col-md-12 ">
                                <?php
                                      $with_border = true;
                                      get_template_part("template-parts/punto-contatto/card"); ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </section>
                    <?php } ?>

                    <?php if (is_array($gallery) && count($gallery)) {
                    ?><section id="gallery" class="it-page-section mb-4">
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
                        <h3 class="my-2 title-large-semi-bold">Situazione patrimoniale</h3>

                        <div class="richtext-wrapper lora">
                            <?php echo $situazione_patrimoniale ?>
                        </div>

                        <?php if ($dichiarazione_redditi && is_array($dichiarazione_redditi) && count($dichiarazione_redditi) > 0) {?>
                        <h4 class="title-medium-2-bold">Dichiarazione dei redditi</h4>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($dichiarazione_redditi as $allegato_id) {
                                      $doc = attachment_url_to_postid($allegato_id);

                                      $idfile = $doc;
                                      get_template_part("template-parts/documento/file");
                                  } ?>
                        </div>
                        <?php }?>

                        <?php if ($variazione_situazione_patrimoniale && is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) > 0) {?>
                        <h4 class="title-medium-2-bold">Variazione situazione patrimoniale</h4>
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
                        <h3 class="my-2 title-large-semi-bold">Altri documenti</h3>

                        <?php if ($spese_elettorali && is_array($spese_elettorali) && count($spese_elettorali) > 0) {?>
                        <h4 class="title-medium-2-bold">Spese elettorali</h4>
                        <div class="card-wrapper card-teaser-wrapper">
                            <?php foreach ($spese_elettorali as $allegato_id) {
                                      $doc = attachment_url_to_postid($allegato_id);

                                      $idfile = $doc;
                                      get_template_part("template-parts/documento/file");
                                  } ?>
                        </div>
                        <?php }?>

                        <?php if ($altre_cariche && is_array($altre_cariche) && count($altre_cariche) > 0) {?>
                        <h4 class="title-medium-2-bold">Altre cariche</h4>
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
                        <h3 class="my-2 title-large-semi-bold">Ulteriori informazioni</h3>
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
    <?php get_template_part("template-parts/common/assistenza-contatti"); ?>

    <?php
    endwhile; // End of the loop.
    ?>
</main>
<?php
get_footer();