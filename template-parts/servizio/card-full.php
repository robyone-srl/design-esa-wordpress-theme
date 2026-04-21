<?php
global $post, $items_count;

$prefix = '_dci_servizio_';
$img = get_template_directory_uri()."\assets\placeholders\img-placeholder-500x384.png";

$descrizione = dci_get_meta('descrizione_breve', $prefix, $post->ID);
$tipi_servizio = get_the_terms($post->ID,'categorie_servizio');

$class = match (true) {
    $items_count === 1 => 'col-12',
    $items_count === 2 => 'col-lg-6',
    default            => 'col-lg-4',
};
?>

<div class="<?php echo $class; ?>">
    <div class="card-wrapper shadow-sm rounded border border-light p-0">
        <div class="card no-after rounded">
		 	<?php
				if(has_post_thumbnail()){    
					$img_url = get_the_post_thumbnail_url($post->ID, 'article-simple-thumb');
					?>
					  <div class="img-responsive-wrapper">
							<div class="card-img-bg rounded-top" style="background-image:url('<?php echo $img_url; ?>');"></div>
					  </div>
		  			<?php
				} 
		  	?>
            <div class="card-body">
                    <?php 
                        $count = 1;
                        if ( is_array($tipi_servizio) && count($tipi_servizio) ) {
                    ?><div class="category-top"><?php
                        foreach ($tipi_servizio as $tipo_servizio) {
                    ?>
                        <?php echo $count == 1 ? '' : ' - '; ?>
                        <a class="category text-decoration-none"
                            href="<?php echo get_term_link($tipo_servizio->term_id); ?>"
                        >
                            <?php echo $tipo_servizio->name;?>
                        </a>
                    <?php ++$count; }
                    ?></div><?php } ?>
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