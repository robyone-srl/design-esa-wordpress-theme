<?php
global $post, $recurrence_index;

$recurrence_index ??= -1;

if($recurrence_index >= 0)
    $timestamps = dci_get_evento_recurrences($post->ID)[$recurrence_index];
else
    $timestamps = dci_get_evento_next_recurrence_timestamps($post->ID);

$prefix = '_dci_evento_';
$img = get_the_post_thumbnail_url($post->ID);
$descrizione = dci_get_meta('descrizione_breve', $prefix, $post->ID);
$start_timestamp = $timestamps['_dci_evento_data_orario_inizio'];
$start_date = date_i18n('d/m', date($start_timestamp));
$start_date_arr = explode('-', date_i18n('d-F-Y-H-i', date($start_timestamp)));
$end_timestamp = $timestamps['_dci_evento_data_orario_fine'];
$end_date = date_i18n('d/m', date($end_timestamp));
$end_date_arr = explode('-', date_i18n('d-F-Y-H-i', date($end_timestamp)));
$tipo_evento = get_the_terms($post->ID,'tipi_evento')[0];
?>

<div class="col-lg-6 col-xl-4">
    <div class="card-wrapper shadow-sm rounded border border-light pb-0">
        <div class="card no-after rounded">
            <div class="img-responsive-wrapper">
                <div class="img-responsive img-responsive-panoramic">
                    <figure class="img-wrapper">
                        <?php dci_get_img($img ?: get_template_directory_uri()."/assets/img/repertorio/abdul-a-CxRBtNe243k-unsplash.jpg", 'rounded-top img-fluid', 'medium_large'); ?>
                    </figure>
                    <div class="card-calendar d-flex flex-column justify-content-center">
                        <span class="card-date"><?php echo $start_date_arr[0]; ?></span>
                        <span class="card-day"><?php echo $start_date_arr[1]; ?></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="category-top">
                    <a class="category text-decoration-none"
                        href="<?php echo get_term_link($tipo_evento->term_id); ?>">
                        <?php echo $tipo_evento->name; ?>
                    </a>
                    <?php if ($start_timestamp && $end_timestamp && $start_date != $end_date) { ?>
                    <span class="data u-grey-light">dal <?php echo $start_date; ?> al <?php echo $end_date; ?></span>
                    <?php }

                    if (dci_get_meta("evento_ripetuto", $prefix, $post->ID) === "true") { ?>
                        <span class="data u-grey-light">Evento ripetuto</span>
                        <?php }
                    ?>
                </div>
                <h3 class="card-title">
                    <a class="text-decoration-none"
                        href="<?php echo get_permalink($post->ID); ?>"
                        data-element="live-category-link">
                        <?php echo $post->post_title ?>
                    </a>
                </h3>
                <p class="card-text text-secondary pb-3">
                    <?php echo $descrizione; ?>
                </p>
                <a class="read-more t-primary text-uppercase"
                    href="<?php echo get_permalink($post->ID); ?>"
                    aria-label="Leggi di più sulla pagina di <?php echo $post->post_title ?>">
                    <span class="text">Leggi di più</span>
                    <span class="visually-hidden"></span>
                    <svg class="icon icon-primary icon-xs ml-10">
                        <use href="#it-arrow-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>