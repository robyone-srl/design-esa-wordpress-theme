<?php
  $numero_verde = dci_get_option('numero_verde','contatti');
  $centralino_unico = dci_get_option('centralino_unico','contatti');
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
				<?php if (dci_get_option( "richiedi_assistenza", "servizi" )) { ?>
                <li>
                  <a class="list-item" href="<?php echo dci_get_template_page_url('page-templates/assistenza.php'); ?>" data-element="contacts"
                    ><svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-mail"
                      ></use></svg><span>Richiedi assistenza</span></a
                  >
                </li>
                <?php } ?>

                <?php if($centralino_unico) { ?>
                <li>
                  <a class="list-item" href="tel:<?php echo preg_replace('/\s+/', '', $centralino_unico); ?>">
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
                  <a class="list-item" href="tel:<?php echo preg_replace('/\s+/', '', $numero_verde); ?>">
                  <svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use
                        href="#it-hearing"
                      ></use></svg><span>Numero verde <?php echo $numero_verde; ?></span></a
                  >
                </li>
                <?php } ?>
                <?php if (dci_get_option( "prenota_appuntamento", "servizi" )) { ?>
                  <li>
                  <a class="list-item" href="<?php echo dci_get_template_page_url("page-templates/prenota-appuntamento.php");?>" data-element="appointment-booking">
                    <svg class="icon icon-primary icon-sm" aria-hidden="true">
                      <use href="#it-calendar"></use>
                    </svg><span>Prenota appuntamento</span>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>