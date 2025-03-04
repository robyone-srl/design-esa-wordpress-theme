<?php
    global $argomento, $sito_tematico_id, $count;

    $posts = dci_get_grouped_posts_by_term( 'siti-tematici' , 'argomenti', $argomento->slug, 3);

    if($posts) {
?>

<section id="siti-tematici">
    <div class="pt-40 <?php echo $first_printed ? "pt-lg-80  pb-40" : "pt-md-100 pb-50"; ?>">
        <div class="container">
            <div class="row row-title">
                <div class="col-12">
                    <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">
                        Siti tematici
                    </h3>
                </div>
            </div>
            <div class="pt-2">
        <div class="row gy-4">
          <?php
          $count = 0;
          foreach ($posts as $sito_tematico_id) {
          ?>
            <div class="col-12 col-md-6 col-lg-4 card-wrapper pb-0">
              <?php
              get_template_part("template-parts/sito-tematico/card");
              ?>
            </div>
          <?php
            ++$count;
          }
          ?>
        </div>
      </div>
        <div class="row mt-4">
            <div class="col-12 col-lg-3 offset-lg-9">
                <button 
                    type="button" 
                    class="btn btn-outline-primary w-100"
                    onclick="location.href='<?= dci_get_search_query_url(post_types: ['sito_tematico'], argomenti_ids: [$argomento->term_id]); ?>'"
                >
                    Tutti i siti tematici
                    <svg class="icon icon-primary">
                        <use xlink:href="#it-arrow-right"></use>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
<?php } ?>