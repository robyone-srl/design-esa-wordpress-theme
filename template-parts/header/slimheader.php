<?php
$nascondi_login = dci_get_option('nascondi_pulsante_login');
$barra_superiore_light = dci_get_option("tema_chiaro_nav_superiore");
?>

<div class="it-header-slim-wrapper <?= $barra_superiore_light ? 'theme-light' : '' ?>">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="it-header-slim-wrapper-content">
          <a class="d-lg-block navbar-brand" target="_blank" href="<?php echo dci_get_option("url_sito_regione"); ?>" aria-label="Vai al portale <?php echo dci_get_option("nome_regione"); ?> - link esterno - apertura nuova scheda" title="Vai al portale <?php echo dci_get_option("nome_regione"); ?>"><?php echo dci_get_option("nome_regione"); ?></a>

          <div class="it-header-slim-right-zone" role="navigation">
            <div class="nav-mobile text-end">
              <nav aria-label="Navigazione accessoria">
                <a class="it-opener d-lg-none" data-bs-toggle="collapse" href="#menu1a" role="button" aria-expanded="false" aria-controls="menu4">
                  <span>Link rapidi</span>
                  <svg class="icon" aria-hidden="true">
                    <use href="#it-expand"></use>
                  </svg>
                </a>
                <div class="link-list-wrapper collapse" id="menu1a">
                  <?php
                  if (has_nav_menu('menu-barra-superiore')) {
                    wp_nav_menu(array(
                      'theme_location' => 'menu-barra-superiore',
                      'list_item_class' => 'list-item dropdown-item',
                      'menu_class' => 'link-list ' . ($nascondi_login ? 'me-0' : ''),
                      'container' => false,
                      'depth' => 1,
                      'current_group' => basename(get_permalink()),
                      'walker' => new Main_Menu_Walker()
                    ));
                  }
                  ?>
                </div>
              </nav>
            </div>
            <?php
            if (!is_user_logged_in()) {
              if (!$nascondi_login)
                get_template_part("template-parts/header/header-anon");
            } else {
              get_template_part("template-parts/header/header-logged");
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>