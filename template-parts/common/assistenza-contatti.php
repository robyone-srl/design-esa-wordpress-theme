<?php
  $numero_verde = dci_get_option('numero_verde','footer');
  $centralino_unico = dci_get_option('centralino_unico','footer');
?>
<div class="bg-grey-card">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-6 offset-lg-3 py-5">
        <div class="cmp-contacts">
          <div class="card w-100">
            <div class="card-body">
              <h2 class="title-medium-2-semi-bold">Contatta la Casa di riposo</h2>
              <ul class="contact-list p-0">
                <li>
                  <a class="list-item" href="<?php echo dci_get_template_page_url('page-templates/domande-frequenti.php'); ?>"><svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-help-circle"
                      ></use></svg><span>Leggi le domande frequenti</span></a
                  >
                </li>
                <li>
                  <a class="list-item" href="<?php echo dci_get_template_page_url('page-templates/assistenza.php'); ?>" data-element="contacts"
                    ><svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-mail"
                      ></use></svg><span>Richiedi assistenza</span></a
                  >
                </li>

                <?php if($centralino_unico) { ?>
                <li>
                  <a class="list-item" href="tel:<?php echo $centralino_unico; ?>">
                  <svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-hearing"
                      ></use></svg><span>Centralino <?php echo $centralino_unico; ?></span></a
                  >
                </li>
                <?php } ?>

                <?php
                  if($numero_verde) { ?>
                <li>
                  <a class="list-item" href="tel:<?php echo $numero_verde; ?>">
                  <svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-hearing"
                      ></use></svg><span>Numero verde <?php echo $numero_verde; ?></span></a
                  >
                </li>
                <?php } ?>
              </ul>
              <h2 class="title-medium-2-semi-bold mt-4">
                Problemi nel sito web
              </h2>
              <ul class="contact-list p-0">
                <li>
                  <a class="list-item" href="#"
                    ><svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-map-marker-circle"
                      ></use></svg><span>Segnala disservizio</span></a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>