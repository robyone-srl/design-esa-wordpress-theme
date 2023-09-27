<?php
global $post;

$img               = dci_get_meta("immagine", '_dci_notizia_', $post->ID);
$arrdata           = dci_get_data_pubblicazione_arr("data_pubblicazione", '_dci_notizia_', $post->ID);
$monthName         = date_i18n('M', mktime(0, 0, 0, $arrdata[1], 10));
$descrizione_breve = dci_get_meta("descrizione_breve", '_dci_notizia_', $post->ID);
$argomenti         = dci_get_meta("argomenti", '_dci_notizia_', $post->ID);

?>

<div class="row">
    <div class="col-lg-5 order-2 order-lg-1">
        <div class="card mb-1">
            <div class="card-body pb-5">
                <div class="category-top">
                    <svg class="icon icon-sm" aria-hidden="true">
                        <use xlink:href="#it-calendar"></use>
                    </svg>
                    <span class="title-xsmall-semi-bold fw-semibold"><?php echo $post->post_type ?></span>
                    <?php if (is_array($arrdata) && count($arrdata)) { ?>
                        <span class="data fw-normal"><?php echo $arrdata[0] . ' ' . $monthName . ' ' . $arrdata[2]; ?></span>
                    <?php } ?>
                </div>
                <a href="<?php echo get_permalink($post->ID); ?>" class="text-decoration-none">
                    <h3 class="card-title">
                        <?php echo $post->post_title ?>
                    </h3>
                </a>
                <p class="mb-4 font-serif pt-3">
                    <?php echo $descrizione_breve ?>
                </p>
                <?php get_template_part("template-parts/common/badges-argomenti"); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 offset-lg-1 order-1 order-lg-2 px-0 px-lg-2">
        <?php if ($img) {
            dci_get_img($img, 'img-fluid');
        } ?>
    </div>
</div>