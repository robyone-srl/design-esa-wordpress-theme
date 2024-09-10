<?php
global $domanda_frequente_id, $count, $location;

$domande_frequenti = dci_get_option('domande_frequenti', $location ?? 'homepage');
if (is_array($domande_frequenti) && count($domande_frequenti)) {
?>

  <div class="container mb-4">
    <div class="row">
      <h2 class="mb-0">Hai dubbi o domande?</h2>
    </div>
    <div class="pt-4 pt-lg-30">
      <div class="row gy-4">
        <?php
        $count = 0;
        foreach ($domande_frequenti as $domanda_frequente_id) {
        ?>
          <div class="col-12 col-md-6 col-lg-4 card-wrapper pb-0">
            <?php
            get_template_part("template-parts/domanda-frequente/card");
            ?>
          </div>
        <?php
          ++$count;
        }
        ?>
      </div>
    </div>
    <div class="my-4 d-flex justify-content-end">
      <a class="read-more btn btn-outline-primary" href="<?= dci_get_template_page_url('page-templates/domande-frequenti.php') ?>">
        Tutte le domande frequenti
        <svg class="icon">
          <use xlink:href="#it-arrow-right"></use>
        </svg>
      </a>
    </div>
  </div>

<?php
} ?>