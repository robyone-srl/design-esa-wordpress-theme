<?php

$hero_image = dci_get_option('hero_image', 'homepage') ?? false;
$hero_title = dci_get_option('hero_title', 'homepage') ?? false;
$hero_description = dci_get_option('hero_description', 'homepage') ?? false;
$hero_button_title = dci_get_option('hero_button_title', 'homepage') ?? false;
$hero_button_link = dci_get_option('hero_button_link', 'homepage') ?? false;
$hero_align_center = dci_get_option('hero_alignment', 'homepage') == 'center';

if ($hero_button_link)
    $hero_button_title = $hero_button_title ?: "Scopri";

$hero_any_text = $hero_title || $hero_description || $hero_button_link;

?>
<section class="it-hero-wrapper it-hero-small-size <?= $hero_any_text ? 'it-dark it-overlay' : '' ?> <?= $hero_align_center ? 'it-text-centered' : '' ?>">
    <!-- - img-->
    <div class="img-responsive-wrapper">
        <div class="img-responsive">
            <div class="img-wrapper">
                <?php
                if ($hero_image) { ?>
                    <?php dci_get_img($hero_image) ?>
                <?php
                } ?>
            </div>
        </div>
    </div>
    <!-- - texts-->
    <?php
    if ($hero_any_text) { ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="it-hero-text-wrapper bg-dark px-0">
                        <?php
                        if ($hero_title) { ?>
                            <h2><?= $hero_title ?></h2>
                        <?php
                        } ?>
                        <?php
                        if ($hero_description) { ?>
                            <p class="d-block"><?= $hero_description ?></p>
                        <?php
                        } ?>
                        <?php
                        if ($hero_button_link) { ?>
                            <div class="it-btn-container"><a class="btn btn-sm <?= $hero_image ? 'btn-secondary' : 'btn-outline-primary' ?>" href="<?= $hero_button_link ?>"><?= $hero_button_title ?></a></div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } ?>
</section>