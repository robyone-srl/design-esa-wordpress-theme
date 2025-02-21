<?php
    $argomenti = array(get_page_by_title('notizie'),get_page_by_title('eventi'));
?>

<div class="container py-5" id="argomento">
  <h2 class="title-xxlarge mb-4">Esplora</h2>
  <div class="row g-4">
    <?php foreach ($argomenti as $argomento) { 
        ?>
    <div class="col-md-6 col-xl-4">
      <div class="cmp-card-simple card-wrapper pb-0 rounded border border-light">
        <div class="card shadow-sm rounded">
          <div class="card-body">
            <a class="text-decoration-none" href="<?php echo(get_permalink($argomento)); ?>"
              data-element="news-category-link">
              <h3 class="card-title t-primary title-xlarge"><?php echo(get_the_title($argomento)); ?></h3>
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>