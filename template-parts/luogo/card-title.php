<?php
global $luogo;

$card_title = $luogo->post_title;
$indirizzo = dci_get_meta("indirizzo", '', $luogo->ID);

?>

<div class="card card-teaser rounded border border-light shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-auto mt-1">
                <svg class="icon">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-map-marker"></use>
                </svg>
            </div>
            <div class="col">
                <div class="card-title">
                    <a href="<?php echo get_permalink($luogo); ?>">
                        <strong>
                            <?php echo $card_title; ?>
                        </strong>
                    </a>
                </div>
                <div class="card-text">
                    <small>
                        <?php echo $indirizzo; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

