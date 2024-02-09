<?php
    global $luogo, $luoghi;
    $prefix = '_dci_luogo_';
    $indirizzo = dci_get_meta('indirizzo', $prefix, $luogo->ID);
?>

<div class="card-wrapper card-teaser-wrapper">
    <div class="card card-teaser border border-light shadow-sm mt-3 rounded">
    <svg class="icon mt-1">
        <use xlink:href="#it-pin" aria-hidden="true"></use>
    </svg>
    <div class="card-body">
        <div class="card-title">
            <a href="<?php echo get_permalink($luogo->ID); ?>">
                <strong>
                    <?php echo $luogo->post_title; ?>
                </strong>
            </a>
        </div>
        <div class="card-text">
            <?php echo $indirizzo; ?>
        </div>
    </div>
    </div>
</div>
<?php 
    $luoghi = array($luogo);
    get_template_part("template-parts/luogo/map"); 
?>
