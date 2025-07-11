<?php

$hero_image = dci_get_option('hero_chi_siamo_image', 'homepage') ?? false;
$hero_title = dci_get_option('hero_chi_siamo_title', 'homepage') ?? false;
$hero_description = dci_get_option('hero_chi_siamo_description', 'homepage') ?? false;
$hero_button_title = dci_get_option('hero_chi_siamo_button_title', 'homepage') ?? false;
$hero_button_link = dci_get_option('hero_chi_siamo_button_link', 'homepage') ?? false;
$hero_align_center = dci_get_option('hero_chi_siamo_alignment', 'homepage') == 'center';

$luoghi_page = get_page_by_path('vivere-ente/luoghi');
$url_luoghi = get_permalink(get_page_by_path('vivere-ente/luoghi'));

$servizi_page = get_page_by_path('servizi');
$url_servizi = get_permalink(get_page_by_path('servizi'));

$amministrazione_page = get_page_by_path('amministrazione');
$url_amministrazione = get_permalink(get_page_by_path('amministrazione'));

if ($hero_button_link)
    $hero_button_title = $hero_button_title ?: "Scopri";

$hero_any_text = $hero_title || $hero_description || $hero_button_link;

?>
<section class="it-hero-wrapper it-hero-small-size <?= $hero_image && $hero_any_text ? 'it-dark it-overlay' : '' ?> <?= $hero_align_center ? 'it-text-centered' : '' ?> it-bottom-overlapping-content">
   <div class="img-responsive-wrapper">
      <div class="img-responsive">
         <div class="img-wrapper"><?php
                if ($hero_image) { ?>
                    <?php dci_get_img($hero_image) ?>
                <?php
                } ?></div>
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="it-hero-text-wrapper bg-dark mt-4 pt-5">
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
</section>
<div class="container mb-5 pb-5">
   <div class="row">
	   <div class="col-12 col-lg-10 offset-lg-1"> 
		   
		   <div class="row">
			   
			   
			   <?php 
			       if ($luoghi_page) {
				   $luoghi_description = dci_get_meta('descrizione','_dci_page_',$luoghi_page->ID ?? null);
				$has_thumbnail = has_post_thumbnail($luoghi_page->ID);
					   ?>
			   <div class="col-12 col-lg-4">
    <!--start card-->
    <div class="card-wrapper">
      <div class="card rounded shadow <?php echo $has_thumbnail ? "card-img" : ""; ?>">
		  
		 <?php
				if($has_thumbnail){    
					$img_url = get_the_post_thumbnail_url($luoghi_page->ID, 'post-thumbnail');
					$img = get_post(attachment_url_to_postid( $img_url ));
					$img_alt = get_post_meta( $img->ID, '_wp_attachment_image_alt', true);
    				$img_caption = $img->post_excerpt;
					?>
					  <div class="img-responsive-wrapper">
					  <div class="img-responsive img-responsive-panoramic">
						<figure class="img-wrapper">
						  <img src="<?php echo $img_url; ?>" title="<?php echo $img_caption; ?>" alt="<?php echo $img_alt; ?>">
						</figure>
					  </div>
					</div>
		  
		  			<?php
				} 
		  ?>
		  
        <div class="card-body pt-4">
          <h3 class="card-title h4">Luoghi</h3>
          <p class="card-text font-serif"><?php echo $luoghi_description; ?></p>
		  <a class="read-more" href="<?php echo $url_luoghi; ?>">
				<span class="text">Inizia la visita</span>
				<svg class="icon ms-0"><use xlink:href="#it-arrow-right"></use></svg>
          </a>
        </div>
      </div>
    </div>
    <!--end card-->
  </div>
			   <?php
				   } 
			   ?>
  
			   <?php 
			       if ($servizi_page) {
				   $servizi_description = dci_get_meta('descrizione','_dci_page_',$servizi_page->ID ?? null);
				$has_thumbnail = has_post_thumbnail($servizi_page->ID);
					   ?>
			   <div class="col-12 col-lg-4">
    <!--start card-->
    <div class="card-wrapper">
      <div class="card rounded shadow <?php echo $has_thumbnail ? "card-img" : ""; ?>">
		  
		 <?php
				if($has_thumbnail){    
					$img_url = get_the_post_thumbnail_url($servizi_page->ID, 'post-thumbnail');
					$img = get_post(attachment_url_to_postid( $img_url ));
					$img_alt = get_post_meta( $img->ID, '_wp_attachment_image_alt', true);
    				$img_caption = $img->post_excerpt;
					?>
					  <div class="img-responsive-wrapper">
					  <div class="img-responsive img-responsive-panoramic">
						<figure class="img-wrapper">
						  <img src="<?php echo $img_url; ?>" title="<?php echo $img_caption; ?>" alt="<?php echo $img_alt; ?>">
						</figure>
					  </div>
					</div>
		  
		  			<?php
				} 
		  ?>
		  
        <div class="card-body pt-4">
          <h3 class="card-title h4">Servizi</h3>
          <p class="card-text font-serif"><?php echo $servizi_description; ?></p>
		  <a class="read-more" href="<?php echo $url_servizi; ?>">
            <span class="text">Scopri di più</span>
            <span class="visually-hidden">sui servizi</span>
            <svg class="icon ms-0"><use xlink:href="#it-arrow-right"></use></svg>
          </a>
        </div>
      </div>
    </div>
    <!--end card-->
  </div>
			   <?php
				   } 
			   ?>
			   
			   <?php 
			       if ($amministrazione_page) {
				   $amministrazione_description = dci_get_meta('descrizione','_dci_page_',$amministrazione_page->ID ?? null);
				$has_thumbnail = has_post_thumbnail($amministrazione_page->ID);
					   ?>
			   <div class="col-12 col-lg-4">
    <!--start card-->
    <div class="card-wrapper">
      <div class="card rounded shadow <?php echo $has_thumbnail ? "card-img" : ""; ?>">
		  
		 <?php
				if($has_thumbnail){    
					$img_url = get_the_post_thumbnail_url($amministrazione_page->ID, 'post-thumbnail');
					$img = get_post(attachment_url_to_postid( $img_url ));
					$img_alt = get_post_meta( $img->ID, '_wp_attachment_image_alt', true);
    				$img_caption = $img->post_excerpt;
					?>
					  <div class="img-responsive-wrapper">
					  <div class="img-responsive img-responsive-panoramic">
						<figure class="img-wrapper">
						  <img src="<?php echo $img_url; ?>" title="<?php echo $img_caption; ?>" alt="<?php echo $img_alt; ?>">
						</figure>
					  </div>
					</div>
		  
		  			<?php
				} 
		  ?>
		  
        <div class="card-body pt-4">
          <h3 class="card-title h4">Amministrazione</h3>
          <p class="card-text font-serif"><?php echo $amministrazione_description; ?></p>
		  <a class="read-more" href="<?php echo $url_amministrazione; ?>">
            <span class="text">Scopri di più</span>
            <span class="visually-hidden">sull'organizzazione</span>
            <svg class="icon ms-0"><use xlink:href="#it-arrow-right"></use></svg>
          </a>
        </div>
      </div>
    </div>
    <!--end card-->
  </div>
			   <?php
				   } 
			   ?>
</div>
		   
      </div>
   </div>
</div>