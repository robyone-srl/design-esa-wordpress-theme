<?php
    global $argomento;

    $posts = dci_get_grouped_posts_by_term( 'luoghi' , 'argomenti', $argomento->slug, 3 );

    if($posts) {
?>
<section id="luoghi">
    <div class="pt-40 <?php echo $first_printed ? "pt-lg-80  pb-40" : "pt-md-100 pb-50"; ?>">
        <div class="container">
            <div class="row row-title">
                <div class="col-12">
                    <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">Luoghi
                    </h3>
                </div>
            </div>
            <div class="row mx-0">
                <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                <?php foreach ($posts as $post) { 
                    $description = dci_get_meta('descrizione_breve');
                    $img = get_the_post_thumbnail_url();    
                    $tipi_luogo = get_the_terms($post->ID, 'tipi_luogo');
                ?>
                    <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
                        <div class="card-image-wrapper with-read-more">
                            <div class="card-body p-3">
                                <?php 
                        			$count = 1;
                        			if ( is_array($tipi_luogo) && count($tipi_luogo) ) {
                    			?><div class="category-top"><?php
                        			foreach ($tipi_luogo as $tipo_luogo) {
                    			?>
                        			<?php echo $count == 1 ? '' : ' - '; ?>
                        			<a class="title-xsmall-semi-bold fw-semibold text-decoration-none" href="<?php echo get_term_link($tipo_luogo->term_id); ?>">
                            			<?php echo $tipo_luogo->name;?>
                        			</a>
                    			<?php ++$count; }
                    			?></div><?php } ?>
                                    
                                    <h4 class="card-title text-paragraph-medium u-grey-light">
                                        <a href="<?php echo get_permalink(); ?>" class="text-decoration-none"><?php echo the_title(); ?></a>
                                    </h4>
                                <p class="text-paragraph-card u-grey-light m-0"><?php echo $description; ?></p>
                            </div>
                        <?php if ($img) { ?>
                            <div class="card-image card-image-rounded">
                                <?php dci_get_img($img); ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-lg-3 offset-lg-9">
                <button 
                    type="button" 
                    class="btn btn-primary text-button w-100"
                    onclick="location.href='<?= dci_get_search_query_url(post_types: ['luogo'], argomenti_ids: [$argomento->term_id]); ?>'"
                >
                    Tutti i luoghi
                </button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>