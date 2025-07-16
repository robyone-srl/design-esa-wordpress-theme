<?php
/**
 * Documento pubblico template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

global $uo_id, $inline;

get_header();
?>

    <main>
        <?php 
        while ( have_posts() ) :
            the_post();
            set_views($post->ID);
            $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

            //$prefix= '_dci_documento_pubblico_';			
            $identificativo = dci_get_meta("identificativo");
            $numero_protocollo = dci_get_meta("numero_protocollo");
            $data_protocollo = dci_get_meta("data_protocollo");			
            $tipo_documento = wp_get_post_terms( $post->ID, array( 'tipi_documento', 'tipi_doc_albo_pretorio' ) );
            $descrizione_breve = dci_get_meta("descrizione_breve");
            $indice = dci_get_wysiwyg_field("indice");
            $url_documento = dci_get_meta("url_documento");
            $file_documento = dci_get_meta("file_documento");
            $file_allegati = dci_get_meta("file_allegati") ?? [];
            $descrizione = dci_get_wysiwyg_field("descrizione_estesa");
            $ufficio_responsabile = dci_get_meta("ufficio_responsabile");
            $autori = dci_get_meta("autori");
            $formati = dci_get_wysiwyg_field("formati");
            $licenza = wp_get_post_terms( $post->ID, array( 'licenze' ) );
            $servizi = dci_get_meta("servizi");
            $data_inizio = dci_get_meta("data_inizio");
            $data_fine = dci_get_meta("data_fine");
            $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");
            $riferimenti_normativi = dci_get_wysiwyg_field("riferimenti_normativi"); 			
            $documenti_collegati = dci_get_meta("documenti_collegati");


            $modalita_pagina = dci_get_meta("content_type");
            if($modalita_pagina == '')
                $modalita_pagina = 'onlydesc';

            $contenuto_documento = dci_get_wysiwyg_field("content");

            ?>
            <div class="container" id="main-container">
                <div class="row">
                    <div class="col px-lg-4">
                        <?php get_template_part("template-parts/common/breadcrumb"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 px-lg-4 py-lg-2">
                        <h1><?php the_title(); ?></h1>
                        <h2 class="visually-hidden">Dettagli del documento</h2>
                        <?php if($numero_protocollo) { ?>
                            <h4>Protocollo <?= $numero_protocollo ?> del <?= $data_protocollo ?></h4>
                        <?php } ?>
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
            </div><!-- ./main-container -->

            <div class="container">
                <div class="row border-top border-light row-column-border row-column-menu-left">
                    <aside class="col-lg-3">
                        <div class="cmp-navscroll sticky-top">
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
                                                        >INDICE DELLA PAGINA
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

                                                            <?php if( $modalita_pagina == 'onlydesc' ) { ?>
                                                                <?php if( $descrizione) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#descrizione">
                                                                        <span>Descrizione</span>
                                                                    </a>
                                                                </li>
                                                                <?php } ?>

                                                                <?php if( $indice ) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#indice">
                                                                        <span>Elenco delle informazioni contenute</span>
                                                                    </a>
                                                                </li>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php if( $contenuto_documento ) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#doc_content">
                                                                        <span>Contenuto documento</span>
                                                                    </a>
                                                                </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                                <?php if( $url_documento || $file_documento || !empty($file_allegati)) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#documento">
                                                                            <span>Scarica documento</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>

                                                                <?php 
                                                                if($modalita_pagina == 'webcontent'){

                                                                    if( 
                                                                        $autori ||
                                                                        ($servizi && count($servizi)) ||
                                                                        $data_inizio ||
                                                                        $data_fine ||
                                                                        $more_info ||
                                                                        $riferimenti_normativi ||
                                                                        ( is_array($documenti_collegati) && count($documenti_collegati) )
                                                                    ) { ?>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="#metadata">
                                                                                <span>Metadati</span>
                                                                            </a>
                                                                        </li> <?php 
                                                                    }
                                                                }else{ ?>

                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#ufficio_responsabile">
                                                                            <span>Ufficio responsabile</span>
                                                                        </a>
                                                                    </li>

                                                                    <?php if( $autori) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#autore">
                                                                            <span>Autori</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>

                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#licenza_distribuzione">
                                                                            <span>Licenza di distribuzione</span>
                                                                        </a>
                                                                    </li>																

                                                                    <?php if( $servizi && count($servizi) ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#servizi">
                                                                            <span>Servizi collegati</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>

                                                                    <?php if( $data_inizio) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#data_inizio">
                                                                            <span>Data inizio</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>

                                                                    <?php if( $data_fine) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#data_fine">
                                                                            <span>Data fine</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>

                                                                    <?php if( $more_info) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#ulteriori_informazioni">
                                                                            <span>Ulteriori informazioni</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>

                                                                    <?php if( $riferimenti_normativi) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#riferimenti_normativi">
                                                                            <span>Riferimenti normativi</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>

                                                                    <?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#documenti_collegati">
                                                                            <span>Documenti collegati</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>
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

                    <div class="col-12 col-lg-9">
                        <div class="it-page-sections-container">

                        <?php if($modalita_pagina == 'onlydesc'){ ?>
                            <?php if( $descrizione) { ?>
                            <section id="descrizione" class="it-page-section mb-5">
                                <h2 class="h3 mb-3">Descrizione</h2>
                                <div class="richtext-wrapper lora">
                                    <?php echo $descrizione; ?>
							    </div>
                            </section>
                            <?php } ?>

                            <?php if( $indice) { ?>
                            <section id="indice" class="it-page-section mb-5">
                                <h2 class="h3 mb-3">Elenco delle informazioni contenute</h2>
                                <div class="richtext-wrapper lora">
                                    <?php echo $indice; ?>
							    </div>
                            </section>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if( $contenuto_documento) { ?>
                            <section id="doc_content" class="it-page-section mb-5">
                                <h2 class="h3 mb-3">Contenuto documento</h2>
                                <div class="richtext-wrapper lora">
                                    <?= $contenuto_documento ?>
							    </div>
                            </section>
                            <?php } ?>
                        <?php } ?>

                            <?php if( $url_documento || $file_documento ) { ?>
                            <section id="documento" class="it-page-section mb-5">
                                <h2 class="h3 mb-3">Scarica documento</h2>
                                <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                <?php
                                    if ( $file_documento ) {
                                        dsi_get_documento_card($file_documento);
                                    }

                                    if ( $url_documento ) { ?>
                                        <div class="card card-teaser shadow-sm p-4 mt-3 rounded border border-light flex-nowrap">
                                            <svg class="icon" aria-hidden="true">
                                                <use
                                                    xlink:href="#it-clip"
                                                ></use>
                                            </svg>
                                            <div class="card-body">
                                                <h3 class="card-title h5">
                                                    <a class="text-decoration-none" href="<?php echo $url_documento; ?>" aria-label="Scarica il documento (collegamento esterno)" title="Scarica il documento (collegamento esterno)">
                                                        Scarica il documento (collegamento esterno)
                                                    </a>
                                                </h3>
                                            <span> Formati disponibili: <?= $formati ?> </span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div><!-- ./card-wrapper -->

                                <?php if(!empty($file_allegati)){ ?>
                                    <h5 class="mt-2">Allegati</h5>
                                    <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                        <?php foreach ($file_allegati as $url) {
                                            dsi_get_documento_card($url);
                                        } ?>
                                    </div>
                                <?php } ?>
                            </section>
                            <?php } ?>

                            <?php if($modalita_pagina == 'onlydesc'){ ?>

                                <section id="ufficio_responsabile" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Ufficio responsabile</h2>
                                    <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                        <?php foreach ($ufficio_responsabile as $uo_id) {
                                            $with_border = true;
                                            get_template_part("template-parts/unita-organizzativa/card");
                                        } ?>
                                    </div>
                                </section>

                                <?php if ($autori &&  is_array($autori) && count($autori)) { ?>
                                <section id="autore" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Autori</h2>
                                    <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                        <?php foreach ($autori as $pp_id) { ?>
                                            <?php get_template_part("template-parts/persona_pubblica/card"); ?>
                                        <?php } ?>
                                    </div>
                                </section>
                                <?php } ?>

                                <?php if ($licenza) { ?>
                                <section id="licenza_distribuzione" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Licenza di distribuzione</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php foreach($licenza as $tipo) { 
                                            echo $tipo->name;
                                        } ?>
                                    </div>
                                </section>
                                <?php } ?>

                                <?php if ($servizi && is_array($servizi) && count($servizi)>0 ) { ?>
                                <section id="servizi" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Servizi collegati</h2>
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

                                <?php if ($data_inizio) { ?>
                                <section id="data_inizio" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Data inizio</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php
                                            echo date_i18n('j F Y', strtotime($data_inizio));
                                        ?>
                                    </div>
                                </section>
                                <?php } ?>

                                <?php if ($data_fine) { ?>
                                <section id="data_fine" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Data fine</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php
                                            echo date_i18n('j F Y', strtotime($data_fine));
                                        ?>
                                    </div>
                                </section>
                                <?php } ?>

                                <?php if ( $more_info ) {  ?>
                                <section id="ulteriori_informazioni" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Ulteriori informazioni</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $more_info ?>
                                    </div>
                                </section>
                                <?php }  ?>

                                <?php if ( $riferimenti_normativi ) { ?>
                                <section id="riferimenti_normativi" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Riferimenti normativi</h2>
                                    <div class="richtext-wrapper lora">
                                        <?php echo $riferimenti_normativi ?>
                                    </div>
                                </section>
                                <?php } ?>

                                <?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
                                <section id="documenti_collegati" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Documenti collegati</h2>
                                    <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                        <?php foreach ($documenti_collegati as $documento_id) {
                                            $documento = get_post($documento_id);
                                            $with_border = true;
                                            get_template_part("template-parts/documento/card");
                                        } ?>
                                    </div>
                                </section>
                                <?php } ?>
                            <?php } else {
                                if( 
                                    $autori ||
                                    ($servizi && count($servizi)) ||
                                    $data_inizio ||
                                    $data_fine ||
                                    $more_info ||
                                    $riferimenti_normativi ||
                                    ( is_array($documenti_collegati) && count($documenti_collegati) ) ||
                                    $licenza ||
                                    $ufficio_responsabile
                                ) { ?>
                                <div id="metadata" class="it-page-section mb-5">
                                    <h2 class="h3 mb-3">Metadati</h2>

                                    <div class="metadata_content">
                                        <?php if ($ufficio_responsabile) { ?>
                                            <section id="ufficio_responsabile" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Ufficio responsabile</h3>
                                                <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                                    <?php foreach ($ufficio_responsabile as $uo_id) {
                                                        $with_border = true;
                                                        get_template_part("template-parts/unita-organizzativa/card");
                                                    } ?>
                                                </div>
                                            </section>
                                        <?php } ?>

                                        <?php if ($autori &&  is_array($autori) && count($autori)) { ?>
                                            <section id="autore" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Autori</h3>
                                                <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                                    <?php foreach ($autori as $pp_id) { ?>
                                                        <?php get_template_part("template-parts/persona_pubblica/card"); ?>
                                                    <?php } ?>
                                                </div>
                                            </section>
                                        <?php } ?>

                                        <?php if ($licenza) { ?>
                                            <section id="licenza_distribuzione" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Licenza di distribuzione</h3>
                                                <div class="richtext-wrapper lora">
                                                    <?php foreach($licenza as $tipo) { 
                                                        echo $tipo->name;
                                                    } ?>
                                                </div>
                                            </section>
                                        <?php } ?>

                                        <?php if ($servizi && is_array($servizi) && count($servizi)>0 ) { ?>
                                            <section id="servizi" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Servizi collegati</h3>
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

                                        <?php if ($data_inizio) { ?>
                                            <section id="data_inizio" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Data inizio</h3>
                                                <div class="richtext-wrapper lora">
                                                    <?php
                                                        echo date_i18n('j F Y', strtotime($data_inizio));
                                                    ?>
                                                </div>
                                            </section>
                                        <?php } ?>

                                        <?php if ($data_fine) { ?>
                                            <section id="data_fine" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Data fine</h3>
                                                <div class="richtext-wrapper lora">
                                                    <?php
                                                        echo date_i18n('j F Y', strtotime($data_fine));
                                                    ?>
                                                </div>
                                            </section>
                                        <?php } ?>

                                        <?php if ( $more_info ) {  ?>
                                            <section id="ulteriori_informazioni" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Ulteriori informazioni</h3>
                                                <div class="richtext-wrapper lora">
                                                    <?php echo $more_info ?>
                                                </div>
                                            </section>
                                        <?php }  ?>

                                        <?php if ( $riferimenti_normativi ) { ?>
                                            <section id="riferimenti_normativi" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Riferimenti normativi</h3>
                                                <div class="richtext-wrapper lora">
                                                    <?php echo $riferimenti_normativi ?>
                                                </div>
                                            </section>
                                        <?php } ?>

                                        <?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
                                            <section id="documenti_collegati" class="it-page-section mb-5">
                                                <h3 class="h4 mb-3">Documenti collegati</h3>
                                                <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                                                    <?php foreach ($documenti_collegati as $documento_id) {
                                                        $documento = get_post($documento_id);
                                                        $with_border = true;
                                                        get_template_part("template-parts/documento/card");
                                                    } ?>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                            <?php } ?>




                        </div><!-- /it-page-sections-container -->

                        <div>
                            <?php get_template_part('template-parts/single/page_bottom'); ?>
                        </div>

										</div><!-- ./col-12 col-9 -->

                </div><!-- ./row border-top border-light row-column-border row-column-menu-left -->
            </div><!-- ./container -->

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
        const descText = document.querySelector('#descrizione')?.closest('article').innerText;
        const wordsNumber = descText.split(' ').length
        document.querySelector('#readingTime').innerHTML = `${Math.ceil(wordsNumber / 200)} min`;
    </script>
<?php
get_footer();

function dsi_get_documento_card($url){
    $documento_id = attachment_url_to_postid($url);
    $documento = get_post($documento_id);
    ?>
    <div class="card card-teaser shadow-sm my-2 p-4 rounded border border-light flex-nowrap">
        <svg class="icon" aria-hidden="true">
            <use
                xlink:href="#it-clip"
            ></use>
        </svg>
        <div class="card-body">
            <h5 class="card-title mb-0">
                <a class="text-decoration-none" href="<?php echo $url; ?>" aria-label="Scarica il documento <?php echo $documento->post_title; ?>" title="Scarica il documento <?php echo $documento->post_title; ?>">
                    <?php echo $documento->post_title; ?> (<?php echo getFileSizeAndFormat($url);?>)
                </a>
            </h5>
        </div>
    </div>
<?php
}