<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Design_Comuni_Italia
 */

 global $custom_style;
 $custom_style = "";

function genera_voci_tassonomia($tassonomia, $titolo)
{
    $terms =  get_terms(array(
        'taxonomy' => $tassonomia,
        'hide_empty' => true,
    ));

    if (empty($terms))
        return;
?>

    <h3 class="footer-heading-title">
        <?= $titolo ?>
    </h3>
    <ul class="footer-list">
        <?php
        foreach ($terms as $term) {
        ?>
            <li>
                <a href="<?= get_term_link($term) ?>"><?= $term->name ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
<?php
}

function genera_pagine_figlie($slug_pagina)
{
    $post = get_page_by_path($slug_pagina);

    $child_args = array(
        'post_parent' => $post->ID,
        'orderby' => 'title',
        'order' => 'ASC'
    );

    $children = get_children($child_args);

    if (empty($children))
        return;
?>
    <h3 class="footer-heading-title">
        <?= $post->post_title ?>
    </h3>
    <ul class="footer-list">
        <?php
        foreach ($children as $page) {
        ?>
            <li>
                <a href="<?= get_page_link($page) ?>"><?= $page->post_title ?></a>
            </li>
        <?php
        } ?>
    </ul>
<?php
}
?>

<footer class="it-footer" id="footer">
    <div class="it-footer-main">
        <div class="container">
            <div class="row">
                <div class="col-12 footer-items-wrapper logo-wrapper">
                    <div class="it-brand-wrapper">
                        <a href="<?php echo home_url() ?>">
                            <?php get_template_part("template-parts/common/logo"); ?>
                            <div class="it-brand-text">
                                <h2 class="no_toc"><?php echo dci_get_option("nome_comune"); ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 footer-items-wrapper">
                    <?php
                    $location = "menu-footer-col-1";
                    if (has_nav_menu($location)) { ?>
                        <h3 class="footer-heading-title">
                            <?php echo wp_get_nav_menu_name($location); ?>
                        </h3>
                    <?php wp_nav_menu(array(
                            "theme_location" => $location,
                            "depth" => 0,
                            "menu_class" => "footer-list",
                            'walker' => new Footer_Menu_Walker()
                        ));
                    } else {
                        genera_pagine_figlie('amministrazione');
                    }
                    ?>
                </div>
                <div class="col-md-3 footer-items-wrapper">
                    <?php
                    $location = "menu-footer-col-2";
                    if (has_nav_menu($location)) {
                    ?>
                        <h3 class="footer-heading-title">
                            <?php echo wp_get_nav_menu_name($location); ?>
                        </h3>
                    <?php wp_nav_menu(array(
                            "theme_location" => $location,
                            "depth" => 0,
                            "menu_class" => "footer-list",
                            'walker' => new Footer_Menu_Walker()
                        ));
                    } else {
                        genera_voci_tassonomia('categorie_servizio', "Categorie di servizio");
                    } ?>
                </div>
                <div class="col-md-3 footer-items-wrapper">
                    <?php
                    $location = "menu-footer-col-3";
                    if (has_nav_menu($location)) {
                    ?>
                        <h3 class="footer-heading-title">
                            <?php echo wp_get_nav_menu_name($location); ?>
                        </h3>
                    <?php wp_nav_menu(array(
                            "theme_location" => $location,
                            "depth" => 0,
                            "menu_class" => "footer-list",
                            'walker' => new Footer_Menu_Walker()
                        ));
                    } else {
                        genera_voci_tassonomia('tipi_documento', "Tipi di documento");
                    } ?>
                </div>
                <div class="col-md-3 footer-items-wrapper">
                    <?php
                    $location = "menu-footer-col-4-1";
                    if (has_nav_menu($location)) { ?>
                        <h3 class="footer-heading-title">
                            <?php echo wp_get_nav_menu_name($location); ?>
                        </h3>
                    <?php wp_nav_menu(array(
                            "theme_location" => $location,
                            "depth" => 0,
                            "menu_class" => "footer-list",
                            "container_class" => "footer-list",
                            'walker' => new Footer_Menu_Walker()
                        ));
                    } else {
                        genera_voci_tassonomia('tipi_notizia', "Tipi di notizia");
                    }
                    ?>
                    <?php
                    $location = "menu-footer-col-4-2";
                    if (has_nav_menu($location)) { ?>
                        <h3 class="footer-heading-title mt-0">
                            <?php echo wp_get_nav_menu_name($location); ?>
                        </h3>
                    <?php wp_nav_menu(array(
                            "theme_location" => $location,
                            "depth" => 0,
                            "menu_class" => "footer-list",
                            'walker' => new Footer_Menu_Walker()
                        ));
                    } else {
                        genera_pagine_figlie('vivere-ente');
                    }
                    ?>
                </div>
                <div class="col-md-9 mt-md-4 footer-items-wrapper">
                    <h3 class="footer-heading-title">Contatti</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer-info">
                                <h4 class="mb-0 h6"><strong><?php echo dci_get_option("nome_comune"); ?></strong></h4>
                                <ul class="list-unstyled">
                                    <?php if (dci_get_option("indirizzo", 'contatti')) {?>
                                        <li><a href="https://www.openstreetmap.org/search?query=<?php echo urlencode(dci_get_option("indirizzo", 'contatti')); ?>" title="Mappa e indicazioni stradali"><?php echo dci_get_option("indirizzo", 'contatti'); ?></a></li>
                                    <?php } 
                                        $codice_fiscale = dci_get_option("CF", 'contatti');
                                        $partita_iva = dci_get_option("PIVA", 'contatti');
                                  
                                        if ($codice_fiscale && $codice_fiscale == $partita_iva) {
                                            echo '<li>Codice fiscale / P.IVA: ' . $codice_fiscale.'</li>';
                                        } else {
                                        ?>
                                            <?php if ($codice_fiscale) echo '<li>Codice fiscale: ' . $codice_fiscale.'</li>'; ?>
                                            <?php if ($partita_iva) echo '<li>Partita IVA: ' . $partita_iva.'</li>'; ?>
                                        <?php
                                        }
                                    $ufficio_id = dci_get_option("scheda_URP", 'contatti');
                                    $ufficio = get_post($ufficio_id);
                                    if ($ufficio_id) { ?>
                                        <li>
                                            <a href="<?php echo get_post_permalink($ufficio_id); ?>" class="list-item" title="Vai alla pagina: URP">
                                                <?php echo $ufficio->post_title ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (dci_get_option("numero_verde", 'contatti')) echo '<li>Numero verde: <a href="tel:' . preg_replace('/\s+/', '', dci_get_option("numero_verde", 'contatti')) . '">' . dci_get_option("numero_verde", 'contatti') . '</a></li>'; ?>
                                    <?php if (dci_get_option("SMS_Whatsapp", 'contatti')) echo '<li>SMS e WhatsApp: <a href="tel:' . preg_replace('/\s+/', '', dci_get_option("SMS_Whatsapp", 'contatti')) . '">' . dci_get_option("SMS_Whatsapp", 'contatti') . '</a></li>'; ?>
                                    <?php if (dci_get_option("PEC", 'contatti')) { ?>
                                        <li>PEC: <a href="mailto:<?php echo dci_get_option("PEC", 'contatti'); ?>" class="list-item" title="PEC <?php echo dci_get_option("nome_comune"); ?>"><?php echo dci_get_option("PEC", 'contatti'); ?></a></li>
                                    <?php }
                                    if (dci_get_option("centralino_unico", 'contatti')) echo '<li>Centralino unico: <a href="' . preg_replace('/\s+/', '', dci_get_option("centralino_unico", 'contatti')) . '">' . dci_get_option("centralino_unico", 'contatti') . '</a></li>'; ?>
                                
                                    <?php if(dci_get_option("cuf", 'contatti') || dci_get_option("cipa", 'contatti')) { ?>
                                        <?php if (dci_get_option("cuf", 'contatti')) echo '<li>Codice univoco di fatturazione (CUF): ' . dci_get_option("cuf", 'contatti').'</li>'; ?>
                                        <?php if (dci_get_option("cipa", 'contatti')) echo '<li>Codice Indice delle Pubbliche Amministrazioni (IPA): ' . dci_get_option("cipa", 'contatti').'</li>'; ?>
                                    <?php } 

                                    $contatti_p_cont = dci_get_option("contattaci_contenuto", 'footer');
                                    $tipo_visualizzazione_servizi = dci_get_option('contattaci_tipo', 'footer');
                                    global $pc_id;
                                    $contatti_p_cont = dci_get_option("contattaci_contenuto", 'footer');

                                    if($tipo_visualizzazione_servizi == 'filtro' && $contatti_p_cont){
                                        if (is_array($contatti_p_cont) && count($contatti_p_cont)) { 
                                            foreach ($contatti_p_cont as $pc_id) {
                                                $contatto = get_post($pc_id);
                                                if(isset($contatto)){

                                                $prefix = '_dci_punto_contatto_';

                                                $full_contatto = dci_get_full_punto_contatto($pc_id);
                                                $contatto = get_post($pc_id);

                                                if(isset($contatto)){
                                                    $voci = dci_get_meta('voci', $prefix, $pc_id);

                                                    $other_contacts = array(
                                                        'linkedin',
                                                        'skype',
                                                        'telegram',
                                                        'twitter',
                                                        'whatsapp'
                                                    );

                                                    echo '<li>';
                                                    echo '<h4 class="h6 mt-2 mb-0">'.$contatto->post_title.'</h4>';

                                                        if (array_key_exists('indirizzo', $full_contatto) && is_array($full_contatto['indirizzo']) && count ($full_contatto['indirizzo']) ) {
                                                            foreach ($full_contatto['indirizzo'] as $dati) {
                                                                echo $dati['valore'];
                                                                if($dati['dettagli']) { echo $dati['dettagli']; }
                                                            } 
                                                        }
                                                        if (array_key_exists('telefono', $full_contatto) && is_array($full_contatto['telefono']) && count ($full_contatto['telefono']) ) {
                                                            foreach ($full_contatto['telefono'] as $dati) {
                                                                ?>
                                                                Telefono: 
                                                                <a 
                                                                target="_blank" 
                                                                aria-label="contatta telefonicamente tramite il numero <?php echo $dati['valore']; ?>" 
                                                                title="chiama <?php echo $dati['valore']; ?>" 
                                                                href="tel:<?php echo $dati['valore']; ?>">
                                                                    <?php echo $dati['valore']; ?>
                                                                </a>
                                                                <?php echo $dati['dettagli']; ?>
                                                                <?php
                                                            }
                                                        }
                                                        if (array_key_exists('url', $full_contatto) && is_array($full_contatto['url']) && count ($full_contatto['url']) ) {
                                                            foreach ($full_contatto['url'] as $dati) { ?>
                                                                <p>
                                                                    Collegamento web:
                                                                    <a 
                                                                    target="_blank" 
                                                                    aria-label="scopri di più su <?php echo $dati['valore']; ?> - link esterno - apertura nuova scheda" 
                                                                    title="vai sul sito <?php echo $dati['valore']; ?>" 
                                                                    href="<?php echo $dati['valore']; ?>">
                                                                        <?php echo $dati['valore']; ?>
                                                                    </a>
                                                                    <?php echo $dati['dettagli']; ?>
                                                                </p>
                                                            <?php }
                                                        }
                                                        if (array_key_exists('email', $full_contatto) && is_array($full_contatto['email']) && count ($full_contatto['email']) ) {
                                                            foreach ($full_contatto['email'] as $dati) { ?>
                                                                <p>
                                                                    Email:
                                                                    <a  
                                                                    aria-label="invia un'email a <?php echo $dati['valore']; ?>"
                                                                    title="invia un'email a <?php echo $dati['valore']; ?>" 
                                                                    href="mailto:<?php echo $dati['valore']; ?>">
                                                                        <?php echo $dati['valore']; ?>
                                                                    </a>
                                                                    <?php echo $dati['dettagli']; ?>
                                                                </p>
                                                            <?php }
                                                        }
                                                        if (array_key_exists('pec', $full_contatto) && is_array($full_contatto['pec']) && count ($full_contatto['pec']) ) {
                                                            foreach ($full_contatto['pec'] as $dati) { ?>
                                                                <p>
                                                                    Posta elettronica certificata (PEC):
                                                                    <a  
                                                                    aria-label="invia un'email a <?php echo $dati['valore']; ?>"
                                                                    title="invia un'email a <?php echo $dati['valore']; ?>" 
                                                                    href="mailto:<?php echo $dati['valore']; ?>">
                                                                        <?php echo $dati['valore']; ?>
                                                                    </a>
                                                                    <?php echo $dati['dettagli']; ?>
                                                                </p> <?php 
                                                            }
                                                        }
                                                        foreach ($other_contacts as $type) {
                                                            if (array_key_exists($type, $full_contatto) &&  is_array($full_contatto[$type]) && count ($full_contatto[$type]) ) {
                                                                foreach ($full_contatto[$type] as $dati) {
                                                                    echo '<p class="py-0 my-0">';
                                                                    if($icon = SOCIAL_ICONS[$type] ?? false)
                                                                    { ?>
                                                                        <svg class="icon icon-secondary icon-sm" aria-hidden="true">
                                                                            <use xlink:href="#<?= $icon ?>"></use>
                                                                        </svg>
                                                                        <span class="visually-hidden"><?= $type ?></span>
                                                                    <?php }
                                                                    else
                                                                        echo $type.': ';

                                                                    echo $dati['valore'].(trim($dati['dettagli']) ? '('.$dati['dettagli'].')' : '') .'</p>';
                                                                }
                                                            } 
                                                        }
                                                    echo '</li>';
                                                    }
                                                }
                                            } 
                                        }
                                     
                                    }  ?>


                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $location = "menu-footer-info-1";
                            if (has_nav_menu($location)) {
                                wp_nav_menu(array(
                                    "theme_location" => $location,
                                    "depth" => 0,
                                    "menu_class" => "footer-list",
                                    'walker' => new Footer_Menu_Walker()
                                ));
                            }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $location = "menu-footer-info-2";
                            if (has_nav_menu($location)) {
                                wp_nav_menu(array(
                                    "theme_location" => $location,
                                    "depth" => 0,
                                    "menu_class" => "footer-list",
                                    'walker' => new Footer_Menu_Walker()
                                ));
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-md-4 footer-items-wrapper">
                    <?php
                    $socials = dci_get_option('link_social', 'socials');
                    if (is_array($socials) && count($socials)) {
                    ?>
                        <h3 class="footer-heading-title">Seguici su</h3>
                        <ul class="list-inline text-start social">
                            <?php foreach ($socials as $social) { ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo $social['url_social'] ?>" title="Vai a <?php echo $social['nome_social']; ?>" aria-label="<?php echo $social['nome_social']; ?>" target="_blank" class="p-2 text-white">
                                    <?php    
                                    if(isset($social['icona_social']) && $social['icona_social'] != ""){?>
                                        <svg class="icon icon-sm icon-white align-top">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" href="#<?php echo $social['icona_social'] ?>"></use>
                                        </svg>
                                    <?php }else{ 
                                        echo $social['nome_social'];
                                     }?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul><!-- /header-social-wrapper -->
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 footer-items-wrapper">
                    <div class="footer-bottom">
                        <?php if (dci_get_option("media_policy", 'footer')) { ?>
                            <a href="<?php echo dci_get_option("media_policy", 'footer'); ?>">Media policy</a>
                        <?php } ?>
                        <?php if (dci_get_option("sitemap", 'footer')) { ?>
                            <a href="<?php echo dci_get_option("sitemap", 'footer'); ?>">Mappa del sito</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>