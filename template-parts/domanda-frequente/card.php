<?php
global $domanda_frequente_id;

$post = get_post($domanda_frequente_id);
?>

<div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
    <div class="card-image-wrapper with-read-more">
        <div class="card-body pt-1 u-grey-light">
            <h3 class="card-title text-paragraph-medium u-grey-light"><?php the_title() ?></h3>
            <p class="text-paragraph-card u-grey-light m-0">
                <?php the_excerpt() ?>
            </p>
        </div>
        <div class="mt-5">
            <a class="read-more" href="<?php the_permalink() ?>" aria-label="Vai alla domanda <?php the_title() ?>" title="Vai alla domanda <?php the_title() ?>">
                <span class="text">Vai alla domanda</span>
                <svg class="icon">
                    <use xlink:href="#it-arrow-right"></use>
                </svg>
            </a>
        </div>
    </div>
</div>