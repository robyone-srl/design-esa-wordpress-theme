<?php

global $scheda;

$schede_evidenza = dci_get_option("schede_evidenza", "homepage");

if($schede_evidenza != null){

?>
<section aria-describedby="contenuti_evidenza">
        <div class="section-content">
            <div class="section-muted pb-90 pb-lg-50 px-lg-5 pt-0">
                <div class="container">
                    <div class="row row-title pt-5 pt-lg-60 pb-3">
                        <div class="col-12 d-lg-flex justify-content-between">
                            <h2 id="contenuti_evidenza" class="mb-lg-0">Contenuti in evidenza</h2>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
<?php

    foreach($schede_evidenza as $scheda_evidenza):      
        $expiration = strtotime($scheda_evidenza['expiration'] ?? '');
        $now = strtotime("now");
        if (($expiration != "") && ($expiration <= $now)) continue; 
		
		$type = $scheda_evidenza['tipo_evidenza'];
		
		if($type == "content") {
			$scheda = $scheda_evidenza['contenuto_evidenza'][0];
			get_template_part("template-parts/home/scheda-evidenza");
		} else {
			$scheda = get_term($scheda_evidenza['termine_evidenza']);

			if (!isset($titlelevel) || $titlelevel === null || trim($titlelevel) === '') {
				$titleheading = "h3"; 
			}
			
			$site_section = $scheda->taxonomy == 'argomenti' ? 'Argomenti' : get_page_by_path( dci_get_taxonomy_group($scheda->taxonomy) )->post_title;
			
			$tax = get_taxonomy( $scheda->taxonomy );
			?>
				
    <div class="card card-teaser no-after rounded shadow-sm mb-0 border border-light">
        <div class="card-body pb-5">
        <div class="category-top">
            <span class="category title-xsmall-semi-bold fw-semibold" ><?= $site_section . " - " . $tax->label ?></span>
        </div>
        <?php echo '<' . $titleheading . ' class="card-title text-paragraph-medium u-grey-light">' . $scheda->name . '</' . $titleheading . '>'; ?>
        <p class="text-paragraph-card u-grey-light m-0">
            <?php echo $scheda->description ?>
        </p>
        </div>
        <a class="read-more" href="<?php echo get_term_link($scheda->term_id); ?>" aria-label="Vai alla pagina <?php echo $scheda->name ?>" title="Vai alla pagina <?php echo $scheda->name ?>"
        ><span class="text">Vai alla pagina</span>
        <svg class="icon ms-0">
            <use
            xlink:href="#it-arrow-right"
            ></use></svg></a>
    </div>			
							
							<?php
		}
    endforeach;
	?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php	
}?>