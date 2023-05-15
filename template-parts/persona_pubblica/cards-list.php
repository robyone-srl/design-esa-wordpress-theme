<?php 
    global $post, $with_border;

    $prefix = '_dci_persona_pubblica_';
	
    $descrizione_breve = dci_get_meta('descrizione_breve');
    $foto = dci_get_meta('foto');
	?>
	
	<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-teaser border rounded shadow p-4 h-100">
        <div class="card-body pe-3">
            <h4 class="u-main-black mb-1 title-small-semi-bold-medium">
                <a class="text-decoration-none" href="<?php echo get_permalink($post->ID); ?>">
                    <?php echo $post->post_title; ?>
                </a>
            </h4>
            <div class="card-text">
                <?php if ($descrizione_breve) {
					    echo '<p class="u-main-black">'.$descrizione_breve.'</p>';
				    } ?>
            </div>
        </div>
        <?php if ($foto) { ?>
        <div class="avatar size-xl">
            <?php dci_get_img($foto); ?>
        </div>
        <?php } ?>
    </div>
</div>