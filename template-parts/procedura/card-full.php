<?php
global $post;

$prefix = '_dci_procedura_';
$img = get_template_directory_uri()."\assets\placeholders\img-placeholder-500x384.png";

$descrizione = dci_get_meta('descrizione_breve', $prefix, $post->ID);
?>

<div class="col-lg-6 col-xl-4">
    <div class="card-wrapper shadow-sm rounded border border-light p-0">
        <div class="card no-after rounded">
            <div class="img-responsive-wrapper">
                <div class="img-responsive img-responsive-panoramic">
                    <figure class="img-wrapper">
                        <?php has_post_thumbnail() ? the_post_thumbnail('medium_large', attr: array('class' => 'figure-img img-fluid rounded-top')) : dci_get_img($img, 'rounded-top img-fluid', 'medium_large') ; ?>
                    </figure>
                </div>
            </div>
            <div class="card-body">
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
                    aria-label="Leggi di pi&ugrave; sulla pagina di <?php echo $post->post_title ?>"
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