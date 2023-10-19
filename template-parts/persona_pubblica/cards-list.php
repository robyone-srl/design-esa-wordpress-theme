<?php 
    global $post, $with_border;

    $prefix = '_dci_persona_pubblica_';
	
    $persona_id = $post->ID;
    $nome = $post->post_title;
    $descrizione_breve = dci_get_meta('descrizione_breve');
    $foto = dci_get_meta('foto');

    
	$inc_args = array(
        'post_type' => 'incarico',
        'meta_query' => array(
            array(
                'key'     => '_dci_incarico_persona',
                'value'   => $post->ID
            ),
        ),
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'post_title',
        'order' => 'ASC',
        );
    $inc_query = new WP_Query( $inc_args );
    $inc_list = get_posts($inc_args);

    $incarichi = array();

    foreach($inc_list as $incarico) {
        $incarichi[trim(strtolower($incarico->post_title))] = $incarico->post_title; //with key to avoid duplication
    }
	?>
	
	<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-teaser border rounded shadow p-4 h-100">
        <div class="card-body pe-3">
            <h4 class="u-main-black mb-1 title-small-semi-bold-medium">
                <a class="text-decoration-none" href="<?php echo get_permalink($persona_id); ?>">
                    <?php echo $nome; ?>
                </a>
            </h4>
            <div class="card-text">
                <?php 
                if($descrizione_breve || $incarichi) {
                    echo '<p class="u-main-black">';
                    if($descrizione_breve) {
                        echo $descrizione_breve;
                    } else {
                        echo implode(', ', $incarichi);
                    }
                    echo '</p>';
                }
                ?>
            </div>
        </div>
        <?php if ($foto) { ?>
        <div class="avatar size-xl">
            <?php dci_get_img($foto); ?>
        </div>
        <?php } else {
        ?>
            <svg class="icon svg-marker-simple"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-user"></use></svg>
        <?php } ?>
    </div>
</div>