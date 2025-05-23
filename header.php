<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Design_Comuni_Italia
 */
$theme_locations = get_nav_menu_locations();
$current_group = dci_get_current_group();

$barra_intestazione_light = dci_get_option("tema_chiaro_nav_intestazione", "grafica");
$barra_principale_light = dci_get_option("tema_chiaro_nav_principale", "grafica");
?>
<!doctype html>
<html lang="it">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  
	<?php if (dci_get_option("favicon")) { ?>
		<link rel="icon" type="image/x-icon" href="<?php echo dci_get_option("favicon");?>">
  <?php } else { 
      $favicon_path = get_template_directory_uri() . '/assets/svg/it-designers-italia.svg';
      echo '<link rel="shortcut icon" href="' . esc_url($favicon_path) . '" />';
  } ?>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <?php get_template_part("template-parts/common/sprites"); ?>
  <?php get_template_part("template-parts/common/skiplink"); ?>

  <header class="it-header-wrapper" data-bs-target="#header-nav-wrapper">
    <?php get_template_part("template-parts/header/slimheader"); ?>
    <div class="it-nav-wrapper">
      <div class="it-header-center-wrapper <?= $barra_intestazione_light ? 'theme-light' : '' ?>">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="it-header-center-content-wrapper">
                <div class="it-brand-wrapper">
                  <a href="<?php echo home_url(); ?>" <?php if (!is_front_page()) echo 'title="Vai alla Homepage"'; ?>>
                    <div class="it-brand-text d-flex align-items-center">
                      <?php
                      global $inverti_colore_logo;
                      $inverti_colore_logo = $barra_intestazione_light;
                      get_template_part("template-parts/common/logo-header");
                      $inverti_colore_logo = false;
                      ?>
                      <div>
                        <div class="it-brand-title"><?php echo dci_get_option("nome_comune"); ?></div>
                        <div class="it-brand-tagline d-none d-md-block">
                          <?php echo dci_get_option("motto_comune"); ?>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="it-right-zone">
                  <?php
                  $show_socials = dci_get_option("show_socials", "socials");
                  if ($show_socials == "true") :
                    $socials = dci_get_option('link_social', 'socials');
                  ?>
                    <div class="it-socials d-none d-lg-flex">
                      <span>Seguici su:</span>
                      <ul>
                        <?php foreach ($socials as $social) { ?>
                          <li>
                            <a href="<?php echo $social['url_social'] ?>" title="Vai su <?php echo $social['nome_social']; ?>" aria-label="<?php echo $social['nome_social']; ?>" target="_blank">
                              <svg class="icon">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" href="#<?php echo $social['icona_social'] ?>"></use>
                              </svg>
                            </a>
                          </li>
                        <?php } ?>
                      </ul><!-- /header-social-wrapper -->
                    </div><!-- /it-socials -->
                  <?php endif ?>
                  <div class="it-search-wrapper">
                    <span class="d-none d-md-block">Cerca</span>
                    <a class="search-link rounded-icon" role="button" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="Cerca nel sito">
                      <svg class="icon">
                        <use href="#it-search"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="it-header-navbar-wrapper <?= $barra_principale_light ? 'theme-light-desk' : '' ?>" id="header-nav-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav class="navbar navbar-expand-lg has-megamenu">
                <button class="custom-navbar-toggler" type="button" aria-controls="nav4" aria-expanded="false" aria-label="Mostra/Nascondi la navigazione" data-bs-target="#nav4" data-bs-toggle="navbarcollapsible">
                  <svg class="icon">
                    <use href="#it-burger"></use>
                  </svg>
                </button>
                <div class="navbar-collapsable" id="nav4" style="display: none">
                  <div class="overlay" style="display: none"></div>
                  <div class="close-div">
                    <button class="btn close-menu" type="button" title="Nascondi" aria-label="Nascondi la navigazione">
                      <svg class="icon">
                        <use href="#it-close-big"></use>
                      </svg>
                    </button>
                  </div>
                  <div class="menu-wrapper">
                    <a href="<?php echo home_url(); ?>" aria-label="Vai alla homepage" class="logo-hamburger">
                      <?php get_template_part("template-parts/common/logo-mobile"); ?>
                      <div class="it-brand-text">
                        <div class="it-brand-title"><?php echo dci_get_option("nome_comune"); ?></div>
                      </div>
                    </a>
                    <?php
                    $location = "menu-header-main";
                    if (has_nav_menu($location)) {
                      wp_nav_menu(array(
                        "theme_location" => $location,
                        "depth" => 0,
                        "menu_class" => "navbar-nav",
                        'items_wrap' => '<ul class="%2$s" id="%1$s" data-element="main-navigation">%3$s</ul>',
                        "container" => "",
                        'list_item_class'  => 'nav-item',
                        'link_class'   => 'nav-link',
                        'current_group' => $current_group,
                        'walker' => new Main_Menu_Walker()
                      ));
                    }
                    ?>
                    <?php
                    $location = "menu-header-right";
                    if (has_nav_menu($location)) {
                      wp_nav_menu(array(
                        "theme_location" => $location,
                        "depth" => 0,
                        "menu_class" => "navbar-nav navbar-secondary",
                        "container" => "",
                        'list_item_class'  => 'nav-item',
                        'link_class'   => 'nav-link',
                        'walker' => new Menu_Header_Right_Walker()
                      ));
                    }
                    ?>
                    <?php
                    $show_socials = dci_get_option("show_socials", "socials");
                    if ($show_socials == "true") :
                      $socials = dci_get_option('link_social', 'socials');
                    ?>
                      <div class="it-socials">
                        <span>Seguici su:</span>
                        <ul>
                          <?php foreach ($socials as $social) { ?>
                            <li>
                              <a href="<?php echo $social['url_social'] ?>" title="Vai su <?php echo $social['nome_social']; ?>" aria-label="<?php echo $social['nome_social']; ?>" target="_blank">
                                <svg class="icon">
                                  <use xmlns:xlink="http://www.w3.org/1999/xlink" href="#<?php echo $social['icona_social'] ?>"></use>
                                </svg>
                              </a>
                            </li>
                          <?php } ?>
                        </ul><!-- /header-social-wrapper -->
                      </div><!-- /it-socials -->
                    <?php endif ?>
                  </div>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

  </header>

  <?php get_template_part("template-parts/common/search-modal"); ?>
  <?php
  if (!is_user_logged_in())
    get_template_part("template-parts/common/access-modal");
  ?>