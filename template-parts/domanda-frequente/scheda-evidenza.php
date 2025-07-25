<?php
global $scheda, $custom_style;

$post = get_post($scheda)??null;
$img = get_the_post_thumbnail_url();
$descrizione_breve = dci_get_meta('descrizione_breve') ?: dci_get_meta('_dci_page_descrizione');

if(isset($post)){

    $icon = dci_get_post_type_icon_by_id($posts);
    if($post->post_type == 'page' && $post->post_type != null && $post->post_type != ''){
        $post_type = 'Pagina';
    }else if($post->post_type != null && $post->post_type != ''){
        $post_T = dci_get_group($post->post_type);
        $page_p = get_page_by_path($post_T);
        $post_type = $page_p != null ? $page_p->post_title : null;
    }

    //$post_type = $post->post_type == 'page' ? 'Pagina' : get_page_by_path( dci_get_group($post->post_type) )->post_title;

    $page_macro_slug = dci_get_group($post->post_type);
    $page_macro = get_page_by_path($page_macro_slug);

    if (!isset($title_level) || $title_level === null || trim($title_level) === '') {
        $titleheading = "h3"; 
    } else {
        $titleheading = "h" . $title_level; 
    }
    ?>

    <?php if ($img) { ?>
    <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
        <div class="card-image-wrapper with-read-more">
            <div class="card-body p-3 u-grey-light">
                <div class="category-top">
                <span class="category title-xsmall-semi-bold fw-semibold" ><?= $post_type ?></span>
                </div>
                <?php echo '<' . $titleheading . ' class="card-title text-paragraph-medium u-grey-light">' . $post->post_title . '</' . $titleheading . '>'; ?>
                <p class="text-paragraph-card u-grey-light m-0" style="margin-bottom: 40px!important;"><?php echo $descrizione_breve ?></p>
            </div>
            <div class="card-image card-image-rounded pb-5">            
                <?php dci_get_img($img, size:'thumbnail'); ?>
            </div>
        </div>
        <?php if ($post_type != null){ ?>
            <a
            class="read-more ps-3"
            href="<?php echo get_permalink($post->ID); ?>"
            aria-label="Vai alla pagina <?php echo $post->post_title ?>" 
            title="Vai alla pagina <?php echo $post->post_title ?>"
            >
                <span class="text">Vai alla pagina</span>
                <svg class="icon">
                    <use xlink:href="#it-arrow-right"></use>
                </svg>
            </a>
        <?php } ?>
    </div> <?php 
    } else { 
        if($post->post_type == 'punto_contatto'){ 
            $custom_style = 'none';
            get_template_part('template-parts/punto-contatto/card-evidenza');
        } else {?>
            <div class="card card-teaser no-after rounded shadow-sm mb-0 border border-light">
                <div class="card-body pb-5">
                <div class="category-top">
                    <!-- <svg class="icon">
                        <use xlink:href="#<?php #echo $icon ?>"></use>
                    </svg> -->
                    <span class="category title-xsmall-semi-bold fw-semibold"><?= $post_type ?></span>
                </div>
                <?php echo '<' . $titleheading . ' class="card-title text-paragraph-medium u-grey-light">' . $post->post_title . '</' . $titleheading . '>'; ?>
                <p class="text-paragraph-card u-grey-light m-0">
                    <?php echo $descrizione_breve ?>
                </p>
                </div>
                <?php if ($post_type != null){ ?>
                    <a class="read-more" href="<?php echo get_permalink($post->ID); ?>" aria-label="Vai alla pagina <?php echo $post->post_title ?>" title="Vai alla pagina <?php echo $post->post_title ?>">
                        <span class="text">Vai alla pagina</span>
                        <svg class="icon ms-0">
                            <use xlink:href="#it-arrow-right" ></use>
                        </svg>
                    </a> <?php 
                } ?>
            </div> <?php 
        }
    } 
}?>