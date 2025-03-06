<?php
$nascondi_login = dci_get_option('nascondi_pulsante_login', 'grafica');
$barra_superiore_light = dci_get_option("tema_chiaro_nav_superiore", 'grafica');
?>

<div class="it-header-slim-wrapper <?= $barra_superiore_light ? 'theme-light' : '' ?>">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="it-header-slim-wrapper-content">
          <a class="d-lg-block navbar-brand" target="_blank" href="<?php echo dci_get_option("url_sito_regione"); ?>" aria-label="Vai al portale <?php echo dci_get_option("nome_regione"); ?> - link esterno - apertura nuova scheda" title="Vai al portale <?php echo dci_get_option("nome_regione"); ?>"><?php echo dci_get_option("nome_regione"); ?></a>

          <div class="it-header-slim-right-zone" role="navigation">
            
          <?php if (has_nav_menu('menu-barra-superiore')) {
              $menu = get_nav_menu_locations();
              $menu = is_array($menu) && count($menu) > 0 ? $menu["menu-barra-superiore"] : null;

              $menu_items = wp_get_nav_menu_items($menu);

              ?>
              <div class="d-none"><?php var_dump($menu_items); ?></div>
              <?php

              if(count($menu_items) > 1) {
                ?>
                  <div class="nav-mobile text-end">
                    <nav aria-label="Navigazione accessoria">
                      <a class="it-opener d-lg-none" data-bs-toggle="collapse" href="#menu1a" role="button" aria-expanded="false" aria-controls="menu1a">
                        <span>Link rapidi</span>
                        <svg class="icon" aria-hidden="true">
                          <use href="#it-expand"></use>
                        </svg>
                      </a>
                      <div class="link-list-wrapper collapse" id="menu1a">
                        <?php
                          wp_nav_menu(array(
                            'theme_location' => 'menu-barra-superiore',
                            'list_item_class' => 'list-item dropdown-item',
                            'menu_class' => 'link-list ' . ($nascondi_login ? 'me-0' : ''),
                            'container' => false,
                            'depth' => 1,
                            'current_group' => basename(get_permalink()),
                            'walker' => new Main_Menu_Walker()
                          ));
                        ?>
                      </div>
                    </nav>
                  </div>
                <?php   
              } else {
                ?><a class="<?php echo !$nascondi_login ? "nav-link" : "btn btn-primary py-sm-2"; ?>" href="<?php echo $menu_items[0]->url; ?>"><?php echo $menu_items[0]->title; ?></a><?php   
              }
          }

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