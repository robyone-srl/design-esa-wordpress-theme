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
            $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

            $prefix= '_dci_documento_pubblico_';
            $identificativo = dci_get_meta("identificativo", $prefix, $post->ID);
            $numero_protocollo = dci_get_meta("numero_protocollo", $prefix, $post->ID);
            $data_protocollo = dci_get_meta("data_protocollo", $prefix, $post->ID);
            $tipo_documento = wp_get_post_terms( $post->ID, array( 'tipi_documento', 'tipi_doc_albo_pretorio' ) );
            $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID);
            $url_documento = dci_get_meta("url_documento", $prefix, $post->ID);
            $file_documento = dci_get_meta("file_documento", $prefix, $post->ID);
            $descrizione = dci_get_wysiwyg_field("descrizione_estesa", $prefix, $post->ID);
            $ufficio_responsabile = dci_get_meta("ufficio_responsabile", $prefix, $post->ID);
            $autori = dci_get_wysiwyg_field("autori", $prefix, $post->ID);
            $formati = dci_get_wysiwyg_field("formati", $prefix, $post->ID);
            $licenza = wp_get_post_terms( $post->ID, array( 'licenze' ) );
            $servizi = dci_get_meta("servizi", $prefix, $post->ID);
            $dataset = dci_get_meta("dataset", $prefix, $post->ID);
            $documenti_collegati = dci_get_meta("documenti_collegati", $prefix, $post->ID);
            $more_info = dci_get_wysiwyg_field("ulteriori_informazioni");
            $riferimenti_normativi = dci_get_wysiwyg_field("riferimenti_normativi"); 
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
                <div class="row border-top border-light row-column-border row-column-menu-left">
                    <aside class="col-lg-4">
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
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#descrizione">
                                                                    <span class="title-medium">Descrizione</span>
                                                                    </a>
                                                                </li>

                                                                <?php if( $url_documento || $file_documento ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#allegati">
                                                                        <span class="title-medium">Allegati</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#documenti_collegati">
                                                                        <span class="title-medium">Documenti correlati</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#ufficio_responsabile">
                                                                        <span class="title-medium">Uffici responsabili</span>
                                                                        </a>
                                                                    </li>
                                                                <?php if( $servizi && count($servizi) ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#servizi">
                                                                        <span class="title-medium">Servizi</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if( $dataset && count($dataset) ) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#dataset">
                                                                        <span class="title-medium">Dataset</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if( $more_info) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#ulteriori_informazioni">
                                                                        <span class="title-medium">Ulteriori informazioni</span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if( $riferimenti_normativi) { ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#riferimenti_normativi">
                                                                        <span class="title-medium">Riferimenti normativi</span>
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
                    <section class="col-lg-8 it-page-sections-container border-light">
                    <article id="descrizione" class="it-page-section anchor-offset">
                        <h2 class="h3">Descrizione</h2>
                        <div class="richtext-wrapper lora">
                            <?php echo $descrizione; ?>
                                    
                            <dl class="row mt-3">
                                <dt class="col-sm-3 py-2 border-bottom">Tipo documento</dt>
                                <dd class="col-sm-9 py-2 border-bottom"><?php $addcomma = false;
                                    foreach($tipo_documento as $tipo) { 
                                        $url = get_term_link($tipo->slug, $tipo->taxonomy);
                                        
                                        if($addcomma) echo ", ";
                                        ?>
                                        <a class="text-decoration-none" href="<?php echo $url; ?>" aria-label="Vai all'archivio <?php echo esc_attr($tipo->name); ?>" title="Vai all'archivio <?php echo esc_attr($tipo->name); ?>">
                                            <?php echo $tipo->name; ?>
                                        </a>
                                        <?php $addcomma=true; }  ?>
                                </dd>

                                <?php if ($numero_protocollo && $data_protocollo) { ?>
                                    <dt class="col-sm-3 py-2 border-bottom">Protocollo</dt>
                                    <dd class="col-sm-9 py-2 border-bottom">Numero <?php echo $numero_protocollo; ?> del <?php echo $data_protocollo; ?></dd>
                                <?php } ?>

                                <dt class="col-sm-3 py-2 border-bottom">Data di pubblicazione</dt>
                                <dd class="col-sm-9 py-2 border-bottom"><?php the_date() ?></dd>

                                <dt class="col-sm-3 py-2 border-bottom">Oggetto</dt>
                                <dd class="col-sm-9 py-2 border-bottom"><?php echo $descrizione_breve; ?></dd>
  
                                <?php if ($autori) { ?>
                                    <dt class="col-sm-3 py-2 border-bottom">Autori</dt>
                                    <dd class="col-sm-9 py-2 border-bottom"><?php echo $autori; ?></dd>
                                <?php } ?>

                                <?php if ($formati) { ?>
                                    <dt class="col-sm-3 py-2 border-bottom">Formati disponibili</dt>
                                    <dd class="col-sm-9 py-2 border-bottom"><?php echo $formati; ?></dd>
                                <?php } ?>

                                <?php if ($licenza) { ?>
                                    <dt class="col-sm-3 py-2 border-bottom">Licenze</dt>
                                    <dd class="col-sm-9 py-2 border-bottom">
                                        <?php foreach($licenza as $tipo) { 
                                            echo $tipo->name;
                                        } ?></dd>
                                <?php } ?>
                            </dl>
                        </div>
                    </article>
                    <?php if( $url_documento || $file_documento ) { ?>
                    <article id="allegati" class="it-page-section anchor-offset mt-5">
                        <h2 class="h3">Allegati</h2>
                        <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                            <?php  
                            if ( $file_documento ) {
                                $documento_id = attachment_url_to_postid($file_documento);
                                $documento = get_post($documento_id);
                            ?>
                            <div class="card card-teaser shadow-sm p-4 mt-3 rounded border border-light flex-nowrap">
                                <svg class="icon" aria-hidden="true">
                                <use
                                    xlink:href="#it-clip"
                                ></use>
                                </svg>
                                <div class="card-body">
                                <h3 class="h5 card-title">
                                    <a class="text-decoration-none" href="<?php echo $file_documento; ?>" aria-label="Scarica il documento <?php echo $documento->post_title; ?>" title="Scarica il documento <?php echo $documento->post_title; ?>">
                                        <?php echo $documento->post_title; ?>
                                    </a>
                                </h3>
                                </div>
                            </div>
                            <?php } 
                            if ( $url_documento ) { ?>
                            <div class="card card-teaser shadow-sm p-4 mt-3 rounded border border-light flex-nowrap">
                                <svg class="icon" aria-hidden="true">
                                <use
                                    xlink:href="#it-clip"
                                ></use>
                                </svg>
                                <div class="card-body">
                                <h3 class="h5 card-title">
                                    <a class="text-decoration-none" href="<?php echo $url_documento; ?>" aria-label="Scarica il documento" title="Scarica il documento">
                                        Scarica il documento
                                    </a>
                                </h3>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </article>
                    <?php } ?>
                    <?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
                    <article id="documenti_collegati" class="it-page-section anchor-offset mt-5">
                        <h2 class="h3">Documenti correlati</h2>
                        <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                            <?php foreach ($documenti_collegati as $all_id) {
                                $documento = get_post($all_id);
                                $with_border = true;
                                get_template_part("template-parts/documento/card");
                            } ?>
                        </div>
                    </article>
                    <?php } ?>
                    <article id="ufficio_responsabile" class="it-page-section anchor-offset mt-5">
                        <h2 class="h3">Uffici responsabili</h2>
                    	<h3 class="h6">La gestione del documento è curata da:</h3>
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <?php foreach ($ufficio_responsabile as $uo_id) {
                                    $with_border = true;
                                    get_template_part("template-parts/unita-organizzativa/card");
                                } ?>
                            </div>
                            <!-- <div class="col-12 col-sm-4">
                                <h3 class="h6">Persone</h6>
                                <?php get_template_part("template-parts/single/persone"); ?>
                            </div> -->
                        </div>
                    </article>
                    <?php if ($servizi && is_array($servizi) && count($servizi)>0 ) { ?>
                        <article id="servizi" class="it-page-section anchor-offset mt-5">
                            <h2 class="h3">Servizi</h2>
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <?php foreach ($servizi as $servizio_id) {
                                        $servizio = get_post($servizio_id);
                                        $with_border = true;
                                        get_template_part("template-parts/servizio/card");
                                    } ?>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                    <?php if ($dataset && is_array($dataset) && count($dataset)>0 ) { ?>
                        <article id="dataset" class="it-page-section anchor-offset mt-5">
                            <h2 class="h3">Dataset</h2>
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <?php foreach ($dataset as $dataset_id) {
                                        $documento = get_post($dataset_id);
                                        $with_border = true;
                                        get_template_part("template-parts/documento/card");
                                    } ?>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                    <?php if ( $more_info ) {  ?>
                        <article id="ulteriori_informazioni" class="it-page-section anchor-offset mt-5">
                            <h2 class="h3">Ulteriori informazioni</h2>
                            <div class="richtext-wrapper lora">
                                <?php echo $more_info ?>
                            </div>
                        </article>
                    <?php }  ?>
                    <?php if ( $riferimenti_normativi ) { ?>
                        <article id="riferimenti_normativi" class="it-page-section anchor-offset mt-5">
                            <h2 class="h3">Riferimenti normativi</h2>
                            <div class="richtext-wrapper lora">
                                <?php echo $riferimenti_normativi ?>
                            </div>
                        </article>
                    <?php } ?>
                    </section>
                </div>
            </div>
            <?php get_template_part("template-parts/common/valuta-servizio"); ?>

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
