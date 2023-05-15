<?php
global $luogo;

$card_title = $luogo->post_title;
$indirizzo = dci_get_meta("indirizzo", '', $luogo->ID);

?>

<div class="card card-teaser rounded shadow mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-auto">
                <svg class="icon">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-map-marker"></use>
                </svg>
            </div>
            <div class="col">
                <a href="<?php echo get_permalink($luogo); ?>">
                    <p>
                        <strong>
                            <?php echo $card_title; ?>
                        </strong>
                    </p>
                </a>
                <p>
                    <small>
                        <?php echo $indirizzo; ?>
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>

