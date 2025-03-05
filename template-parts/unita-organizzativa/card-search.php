<?php
global $post;

    $prefix = '_dci_unita_organizzativa_';
	$descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID);
    $tipo_organizzazione = get_the_terms($post->ID, 'tipi_unita_organizzativa');
    $img = get_the_post_thumbnail_url() ?? '';
if($img){ ?>
    <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
        <div class="card-image-wrapper with-read-more">
            <div class="content aling-top">
                <div class="card-header border-0 pb-1">
                    <?php
                    echo '<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">';
                    echo $tipo_organizzazione[0]->name; 
                    echo '</span>';?>
                </div>
                <div class="card-body ps-3 pb-3">
                    <h4 class="card-title text-paragraph-medium u-grey-light">
                        <a class="text-decoration-none" href="<?= $post->guid ?>" data-element="service-link"><?php echo $post->post_title; ?></a>
                    </h4>
                    <p class="text-paragraph-card u-grey-light m-0"><?php echo $descrizione_breve; ?></p>
                </div>
            </div>
            <div class="card-image card-image-rounded pb-5">            
                <?php dci_get_img($img); ?>
            </div>
        </div>
    </div>

<?php }else{ ?>
    <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0 p-3">
        <div class="content aling-top">
            <div class="card-header border-0 pb-1">
                <?php
                echo '<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">';
                echo $tipo_organizzazione[0]->name; 
                echo '</span>';?>
            </div>
            <div class="card-body px-3 pb-3">
                <h4 class="card-title text-paragraph-medium u-grey-light">
		            <a href="<?= $post->guid ?>" class="text-decoration-none"><?= $post->post_title; ?></a>
	            </h4>
	            <p class="text-paragraph-card u-grey-light m-0"><?php echo $descrizione_breve; ?></p>
            </div>
        </div>
    </div>
<?php } ?>