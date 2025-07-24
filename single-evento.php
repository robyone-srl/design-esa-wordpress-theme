<?php

/**
 * Evento template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

global $show_calendar, $gallery, $video, $trascrizione, $luogo, $pc_id, $uo_id, $appuntamento, $inline;

get_header();
?>

<main>
    <?php
    while (have_posts()) :
        the_post();
        set_views($post->ID);
        $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

        $prefix = '_dci_evento_';
        $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID);
        //dates
        $recurrent = dci_get_meta("evento_ripetuto", $prefix, $post->ID) === "true";
        $next_recurrence_timestamps = dci_get_evento_next_recurrence_timestamps($post->ID);
        $start_timestamp = $next_recurrence_timestamps['_dci_evento_data_orario_inizio'];
        $start_date = date_i18n('d F Y', date($start_timestamp));
        $start_time = date_i18n('H:i', date($start_timestamp));
        $start_date_arr = explode('-', date_i18n('d-M-Y-H-i', date($start_timestamp)));
        $end_timestamp = $next_recurrence_timestamps['_dci_evento_data_orario_fine'];
        $end_date = date_i18n('d F Y', date($end_timestamp));
        $end_time = date_i18n('H:i', date($end_timestamp));
        $end_date_arr = explode('-', date_i18n('d-M-Y-H-i', date($end_timestamp)));
        $descrizione = dci_get_wysiwyg_field("descrizione_completa", $prefix, $post->ID);
        $destinatari = dci_get_wysiwyg_field("a_chi_e_rivolto", $prefix, $post->ID);
        //media
        $gallery = dci_get_meta("gallery", $prefix, $post->ID);
        $video = dci_get_meta("video", $prefix, $post->ID);
        $trascrizione = dci_get_meta("trascrizione", $prefix, $post->ID);
        $persone = dci_get_meta("persone", $prefix, $post->ID);
        $is_luogo_esa = dci_get_meta("is_luogo_esa") != "false"; //before 1.7.5.12, this meta value was not present
        if ($is_luogo_esa) {
            $luogo_evento_id = dci_get_meta("luogo_evento", $prefix, $post->ID);
            $luogo_evento = $luogo_evento_id ? get_post($luogo_evento_id) : null;
        }
        $show_luogo = $luogo_evento ?? false || !$is_luogo_esa;
        $costi = dci_get_meta('costi');
        $allegati = dci_get_meta("allegati", $prefix, $post->ID);
        $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID);
        $organizzatori = dci_get_meta("organizzatore", $prefix, $post->ID);
        $appuntamenti = dci_get_eventi_figli();
        $appuntamenti_genitore = dci_get_meta("evento_genitore", $prefix, $post->ID);

        $patrocinato = dci_get_meta("patrocinato", $prefix, $post->ID);
        $sponsor = dci_get_meta("sponsor", $prefix, $post->ID);
        $more_info = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $post->ID);
    ?>

        <div class="container px-4 my-4" id="main-container">
            <div class="row">
                <div class="col px-lg-4">
                    <?php get_template_part("template-parts/common/breadcrumb"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 px-lg-4 py-lg-2">
                    <h1><?php the_title(); ?></h1>
                    <h2 class="visually-hidden">Dettagli evento</h2>
                    <p class="h4 py-2">
                        <?php if ($start_timestamp && $end_timestamp) {
                            if ($start_date == $end_date) { ?>
                                <?php echo $start_date; ?> dalle <?php echo $start_time; ?> alle <?php echo $end_time; ?>
                            <?php } else { ?>
                                dal <?php echo $start_date; ?> al <?php echo $end_date; ?>
                            <?php }
                            if ($recurrent) {
                            ?>
                                (l'evento si ripete)
                        <?php
                            }
                        } ?>
                    </p>
                    <p>
                        <?php echo $descrizione_breve; ?>
                    </p>
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
        <div class="row border-top row-column-border row-column-menu-left border-light">
            <aside class="col-lg-3">
                <div class="cmp-navscroll sticky-top" aria-labelledby="accordion-title-one">
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
                                            >Indice della pagina
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
                                                        <a class="nav-link" href="#cos-e">
                                                        <span>Cos'è</span>
                                                        </a>
                                                        </li>
                                                    <?php if( $destinatari) { ?>
                                                        <li class="nav-item">
                                                        <a class="nav-link" href="#destinatari">
                                                        <span>A chi è rivolto</span>
                                                        </a>
                                                        </li>
                                                    <?php } ?>  
                                                    <?php if( $show_luogo) { ?>
                                                        <li class="nav-item">
                                                        <a class="nav-link" href="#luogo">
                                                        <span>Luogo</span>
                                                        </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($start_timestamp && $end_timestamp) { ?>
                                                        <li class="nav-item">
                                                        <a class="nav-link" href="#date-e-orari">
                                                        <span>Date e orari</span>
                                                        </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if( is_array($costi) && count($costi) ) { ?>
                                                        <li class="nav-item">
                                                        <a class="nav-link" href="#costi">
                                                        <span>Costi</span>
                                                        </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if( $allegati ) { ?>
                                                        <li class="nav-item">
                                                        <a class="nav-link" href="#allegati">
                                                        <span>Allegati</span>
                                                        </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if( is_array($punti_contatto) && count($punti_contatto) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#contatti">
                                                    <span>Contatti</span>
                                                    </a>
                                                    </li>
                                                    <?php } ?>
                                                    <?php if( is_array($appuntamenti) && count($appuntamenti) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#appuntamenti">
                                                    <span>Appuntamenti</span>
                                                    </a>
                                                    </li>
                                                    <?php } ?>
                                                    <?php if ( (is_array($patrocinato) && count($patrocinato)) || 
                                                        (is_array($sponsor) && count($sponsor)) ) {  ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#ulteriori-informazioni">
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
            </aside>

                <section class="col-lg-9 it-page-sections-container border-light">
                    <article id="cos-e" class="it-page-section mb-5" data-audio>
                        <h2 class="h3 mb-3">Cos'è</h2>
                        <div class="richtext-wrapper lora">
                            <?php echo $descrizione; ?>
                        </div>

                        <?php if($appuntamenti_genitore != null){ ?>
                        <article id="appuntamenti" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Evento Genitore</h2>
                            <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                <?php
                                    $appuntamento = get_post($appuntamenti_genitore);
                                    get_template_part('template-parts/single/appuntamento');
                                ?>
                            </div>
                        </article>
                        <?php } ?>

                        <?php if (is_array($persone) && count($persone)) { ?>
                            <div class="pt-3 mb-4">
                                <h3 class="h4">Parteciperanno</h3>
                                <?php get_template_part("template-parts/single/persone"); ?>
                            </div>
                        <?php  } ?>
                    </article>
                    <?php if ($video || (is_array($gallery) && count($gallery))) { ?>
                        <article id="media" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Media</h2>
                            <?php if (is_array($gallery) && count($gallery)) {
                                get_template_part("template-parts/single/gallery");
                            } ?>
                            <?php if ($video) {
                                get_template_part("template-parts/single/video");
                            } ?>
                        </article>
                    <?php  } ?>

                    <?php if ($destinatari) { ?>
                        <article id="destinatari" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">A chi è rivolto</h2>
                            <div class="richtext-wrapper lora">
                                <?php echo $destinatari; ?>
                            </div>
                        </article>
                    <?php  } ?>

                    <?php if ($show_luogo) { ?>
                        <article id="luogo" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Luogo</h2>
                            <?php if ($is_luogo_esa && $luogo_evento) { ?>
                                <?php
                                $luogo = $luogo_evento;
                                $showTitle = true;
                                $showPermalink = true;
                                get_template_part("template-parts/luogo/card-single");
                                ?>
                            <?php } else if (!$is_luogo_esa) {
                                get_template_part("template-parts/luogo/card-alt");
                            } ?>
                        </article>
                    <?php   } ?>

                    <?php if ($start_timestamp || $end_timestamp) { ?>
                        <article id="date-e-orari" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Date e orari</h2>
                            <div class="point-list-wrapper my-4">

                                <?php if ($start_timestamp) { ?>
                                    <div class="point-list">
                                        <h3 class="h4 point-list-aside point-list-primary fw-normal">
                                            <span class="point-date font-monospace"><?php echo $start_date_arr[0]; ?></span>
                                            <span class="point-month font-monospace"><?php echo $start_date_arr[1]; ?></span>
                                        </h3>
                                        <div class="point-list-content">
                                            <div class="card card-teaser shadow rounded">
                                                <div class="card-body">
                                                    <p class="card-title h5 m-0">
                                                        <?php echo $start_date_arr[3] . ':' . $start_date_arr[4]; ?> - Inizio evento
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                                <?php if ($end_timestamp) { ?>
                                    <div class="point-list">
                                        <h3 class="h4 point-list-aside point-list-primary fw-normal">
                                            <div class="point-date font-monospace"><?php echo $end_date_arr[0]; ?></div>
                                            <div class="point-month font-monospace"><?php echo $end_date_arr[1]; ?></div>
                                        </h3>
                                        <div class="point-list-content">
                                            <div class="card card-teaser shadow rounded">
                                                <div class="card-body">
                                                    <p class="card-title h5 m-0">
                                                        <?php echo $end_date_arr[3]; ?>:<?php echo $end_date_arr[4]; ?> - Fine evento
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                            $data_inizio = date_i18n("Ymd\THi00", date($start_timestamp));
                            $data_fine = date_i18n("Ymd\THi00", date($end_timestamp));
                            $luogo = $luogo_evento->post_title ?? '';
                            ?>
                            <div class="mt-2">
                                <a target="_blank" href="https://calendar.google.com/calendar/r/eventedit?text=<?php echo urlencode(get_the_title()); ?>&dates=<?php echo $data_inizio; ?>/<?php echo $data_fine; ?>&details=<?php echo urlencode($descrizione_breve); ?>:+<?php echo urlencode(get_permalink()); ?>&location=<?php echo urlencode($luogo); ?>" class="btn btn-outline-primary btn-icon">
                                    <svg class="icon icon-primary" aria-hidden="true">
                                        <use xlink:href="#it-plus-circle"></use>
                                    </svg>
                                    <span>Aggiungi al calendario</span>
                                </a>
                            </div>
                            <?php
                            if ($recurrent) {
                            ?>
                                <h3 class="h4 mt-4">Ricorrenze</h3>
                                <div class="richtext-wrapper">
                                    <p>L'evento si ripete nelle seguenti date:</p>
                                    <ul>
                                        <?php

                                        $recurrences = dci_get_evento_recurrences($id);
                                        $index_of_next_recurrence = dci_get_evento_next_recurrence_index($id);

                                        for ($i = 0; $i < count($recurrences); $i++) {
                                            $recurrence_start_timestamp = $recurrences[$i]['_dci_evento_data_orario_inizio'];
                                            $recurrence_start_date = date_i18n('d F Y', date($recurrence_start_timestamp));
                                            $recurrence_start_time = date_i18n('H:i', date($recurrence_start_timestamp));
                                            $recurrence_start_date_arr = explode('-', date_i18n('d-M-Y-H-i', date($start_timestamp)));
                                            $recurrence_end_timestamp = $recurrences[$i]['_dci_evento_data_orario_fine'];
                                            $recurrence_end_date = date_i18n('d F Y', date($recurrence_end_timestamp));
                                            $recurrence_end_time = date_i18n('H:i', date($recurrence_end_timestamp));
                                            $is_next_recurrence = $index_of_next_recurrence == $i;
                                        ?>
                                            <li class="<?= $is_next_recurrence? 'fw-bold' : '' ?>">
                                                <?php
                                                if ($recurrence_start_date == $recurrence_end_date) { ?>
                                                    <?= $recurrence_start_date; ?>
                                                <?php } else { ?>
                                                    dal <?= $recurrence_start_date; ?> al <?= $recurrence_end_date; ?>
                                                <?php }
                                                ?>
                                                dalle <?= $recurrence_start_time; ?> alle <?= $recurrence_end_time; ?>
                                                <?php
                                                if($is_next_recurrence){
                                                    ?>
                                                    <span class="fw-normal"> (ricorrenza più vicina)</span>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php
                            }
                            ?>
                        </article>
                    <?php } ?>

                    <?php if (is_array($costi) && count($costi)) { ?>
                        <article id="costi" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Costi</h2>
                            <?php foreach ($costi as $costo) { ?>
                                <div class="card no-after border-start mt-3">
                                    <div class="card-body">
                                        <h3 class="h4">
                                            <span>
                                                <?php echo $costo['titolo_costo']; ?>
                                            </span>
                                            <p class="card-title big-heading">
                                                <?php echo $costo['prezzo_costo']; ?>
                                            </p>
                                        </h3>
                                        <p class="mt-4">
                                            <?php echo $costo['descrizione_costo']; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </article>
                    <?php } ?>

                    <?php if ($allegati) {
                        $doc = get_post(attachment_url_to_postid($allegati));
                    ?>
                        <article id="allegati" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Allegati</h2>
                            <div class="card card-teaser shadow mt-3 rounded">
                                <div class="card-body">
                                    <h3 class="card-title h5 m-0">
                                        <svg class="icon" aria-hidden="true">
                                            <use xlink:href="#it-clip"></use>
                                        </svg>
                                        <a class="text-decoration-none" href="<?php echo $allegati; ?>" title="Scarica la locandina <?php echo $doc->post_title; ?>" aria-label="Scarica la locandina <?php echo $doc->post_title; ?>"><?php echo $doc->post_title; ?></a>
                                    </h3>
                                </div>
                            </div>
                        </article>
                    <?php } ?>

                    <?php if (is_array($appuntamenti) && count($appuntamenti)) { ?>
                        <article id="appuntamenti" class="it-page-section mb-5">
                            <h2 class="h3 mb-3">Appuntamenti</h2>
                            <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                <?php foreach ($appuntamenti as $appuntamento) {
                                    get_template_part('template-parts/single/appuntamento');
                                } ?>
                            </div>
                        </article>
                    <?php } ?>

                    <article id="contatti" class="it-page-section mb-5">
                        <?php if (is_array($punti_contatto) && count($punti_contatto)) { ?>
                            <h2 class="mb-3">Contatti</h2>  
                            <div class="row g-2"><?php 
                                foreach ($punti_contatto as $pc_id) {
                                    $contatto = get_post($pc_id);
									$title_level = 3;
                                    if(isset($contatto)){ ?>
                                        <div class="col-xl-6 col-lg-8 col-12 mb-2 d-flex"> <?php
                                            get_template_part("template-parts/punto-contatto/card"); ?>
                                        </div> <?php
                                    }
                                } ?>
                            </div>
                        <?php } ?>
                        <?php if (is_array($organizzatori) && count($organizzatori)) { ?>
                            <h2 class="h5 mt-4">Con il supporto di:</h2>
                            <?php foreach ($organizzatori as $uo_id) {
                                get_template_part("template-parts/unita-organizzativa/card-full");
                            } ?>
                        <?php } ?>
                    </article>

                    <article id="ulteriori-informazioni" class="it-page-section mb-5">
                        <?php
                        if ((is_array($patrocinato) && count($patrocinato)) ||
                            (is_array($sponsor) && count($sponsor))
                        ) { ?>
                            <h2 class="mb-3">Ulteriori informazioni</h2>
                            <?php
                            if (is_array($patrocinato) && count($patrocinato)) {
                                echo '<h3 class="h5">Patrocinato da:</h3>';
                                echo '<div class="link-list-wrapper mb-3"><ul class="link-list">';
                                foreach ($patrocinato as $item) { ?>
                                    <li><a class="list-item px-0" href="<?php echo $item['_dci_evento_url']; ?>" target="_blank"><span><?php echo $item['_dci_evento_nome']; ?></span></a>
                                    </li>
                                <?php }
                                echo '</ul></div>';
                            }
                            if (is_array($sponsor) && count($sponsor)) {
                                echo '<h3 class="h5">Sponsor:</h3>';
                                echo '<div class="link-list-wrapper"><ul class="link-list">';
                                foreach ($sponsor as $item) { ?>
                                    <li><a class="list-item px-0" href="<?php echo $item['_dci_evento_url']; ?>" target="_blank"><span><?php echo $item['_dci_evento_nome']; ?></span></a>
                                    </li>
                        <?php }
                                echo '</ul></div>';
                            }
                        }

                        ?>
                        <?php if ($more_info) { ?>
                            <h3 class="visually-hidden">Altro</h3>
                            <div class="mt-5">
                                <div class="callout">
                                    <div class="callout-title">
                                        <svg class="icon">
                                            <use xlink:href="#it-info-circle"></use>
                                        </svg>
                                    </div>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $more_info; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </article>
                    <?php get_template_part('template-parts/single/page_bottom'); ?>
                </section>
            </div>
            </div>
            <?php get_template_part("template-parts/common/valuta-servizio"); ?>
            <?php 
                $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
                if($visualizza_contatto == 'visible')
                    get_template_part("template-parts/common/assistenza-contatti"); 
            ?>

        <!-- <?php get_template_part('template-parts/single/more-posts', 'carousel'); ?> -->

    <?php
    endwhile; // End of the loop.
    ?>
</main>

<?php
get_footer();
