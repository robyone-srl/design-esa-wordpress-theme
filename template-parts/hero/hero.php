<?php
    global $title, $description, $with_shadow, $data_element, $content, $hide_arguments;

    if (!$title) $title = get_the_title();
    if (!$description) $description = dci_get_meta('descrizione','_dci_page_',$post->ID ?? null);
    if(!$content) $content = get_the_content();

    $argomenti = get_the_terms($post, 'argomenti');
    $post_url = get_permalink();

    if ($hide_arguments) $argomenti = array();
?>

<div class="container" id="main-container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <?php get_template_part("template-parts/common/breadcrumb"); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center <?php echo $with_shadow? 'row-shadow' : ''?>">
        <div class="<?php echo is_array($argomenti) && count($argomenti) ? "col-lg-7 col-md-6 pt-4" :"col-lg-10"; ?>">
            <div class="cmp-hero">
                <section class="it-hero-wrapper bg-white align-items-start">
                    <div class="it-hero-text-wrapper pt-0 ps-0 pb-2">
                        <h1 class="text-black hero-title" <?php echo $data_element ? $data_element : null ?>>
                            <?php echo $title; ?>
                        </h1>
                        <div class="hero-text">
                            <p><?php echo $description; ?></p>
                        </div>
                    </div>
                </section>
            </div>
            <div class="pt-4 pb-4">
                <?php
                if($content != '')
                    echo $content; 
                ?>
            </div>
        </div>
        <?php if (is_array($argomenti) && count($argomenti) ) { ?>
            <div class="col-lg-2 offset-lg-1 col-md-3 offset-md-1 pt-4">
                <div class="mt-4 mb-4">
                    <span class="subtitle-small">Argomenti</span>
                    <ul class="d-flex flex-wrap gap-1">
                        <?php foreach ($argomenti as $argomento) { ?>
                        <li>
                            <a class="chip chip-simple" href="<?php echo get_term_link($argomento->term_id); ?>">
                                <span class="chip-label"><?php echo $argomento->name; ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>	
</div>