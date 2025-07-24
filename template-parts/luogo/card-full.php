<?php
global $post;

$prefix = '_dci_luogo_';
$img = !empty(get_the_post_thumbnail_url($post->ID))
    ? get_the_post_thumbnail_url($post->ID)
    : get_template_directory_uri()."\assets\placeholders\img-placeholder-500x384.png";

$descrizione = dci_get_meta('descrizione_breve', $prefix, $post->ID);
$tipi_luogo = get_the_terms($post->ID,'tipi_luogo');
?>

<div class="col-lg-6 col-xl-4">
    <div class="card-wrapper shadow-sm rounded border border-light">
        <div class="card no-after rounded">
            <div class="img-responsive-wrapper">
                <div class="img-responsive img-responsive-panoramic">
                    <figure class="img-wrapper">
                        <?php dci_get_img($img, 'rounded-top img-fluid', 'medium_large'); ?>
                    </figure>
                </div>
            </div>
            <div class="card-body">
                    <?php 
                        $count = 1;
                        if ( is_array($tipi_luogo) && count($tipi_luogo) ) {
                    ?><div class="category-top"><?php
                        foreach ($tipi_luogo as $tipo_luogo) {
                    ?>
                        <?php echo $count == 1 ? '' : ' - '; ?>
                        <a class="category text-decoration-none"
                            href="<?php echo get_term_link($tipo_luogo->term_id); ?>"
                        >
                            <?php echo $tipo_luogo->name;?>
                        </a>
                    <?php ++$count; }
                    ?></div><?php } ?>
                <h3 class="card-title">
                    <a class="text-decoration-none"
                        href="<?php echo get_permalink($post->ID); ?>"
                        data-element="live-category-link"
                    >
                        <?php echo $post->post_title ?>
                    </a>
                </h3>
                <p class="card-text text-secondary pb-3">
                    <?php echo $descrizione; ?>
                </p>
                <a class="read-more t-primary text-uppercase"
                    href="<?php echo get_permalink($post->ID); ?>"
                    aria-label="Leggi di pi&ugrave; sulla pagina di <?php echo str_replace('"','',$post->post_title) ?>"
                >
                    <span class="text">Leggi di pi&ugrave;</span>
                    <span class="visually-hidden"></span>
                    <svg class="icon icon-primary icon-xs ml-10">
                        <use href="#it-arrow-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>