<?php
$links = dci_get_option('link', 'link_utili');
?>

<section id="novita" class="useful-links-section">
    <div class="section section-muted p-0 py-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6">
                    <form role="search" id="search-form" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <h2 class="title-medium-2-semi-bold mb-3">Non hai trovato quello che cercavi?</h2>
                        <div class="cmp-input-search">
                            <div class="form-group autocomplete-wrapper mb-2 mb-lg-4">
                                <div class="input-group">
                                    <label for="autocomplete-three" class="visually-hidden">Cerca una parola chiave</label>
                                    <input type="search" class="autocomplete form-control" placeholder="Cerca una parola chiave" id="autocomplete-three" name="s" value="<?php echo get_search_query(); ?>" data-bs-autocomplete="[]">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit" id="button-3">Invio</button>
                                    </div>
                                    <span class="autocomplete-icon" aria-hidden="true">
                                        <svg class="icon icon-sm icon-primary">
                                            <use href="#it-search"></use>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php if ($links) { ?>
                        <div class="link-list-wrapper">
                            <div class="link-list-heading text-uppercase mt-2 mt-lg-4 mb-3 ps-0">
                                Link utili
                            </div>
                            <ul class="link-list d-flex flex-wrap">
                                <?php foreach ($links as $link) { ?>
                                    <li>
                                        <a class="list-item mb-1 active ps-0" href="<?php echo $link['url']; ?>">
                                            <span class="text-button-normal"><?php echo $link['testo']; ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php }
                    $popular_posts = new WP_Query(
                        array(
                            'post_type'     => dci_get_sercheable_tipologie(),
                            'posts_per_page' => 7,
                            'meta_key'      => 'views',
                            'orderby'       => 'meta_value_num',
                            'order'         => 'DESC'
                        )
                    );

                    if (is_array($popular_posts->posts) && count($popular_posts->posts) > 0) { ?>
                        <div class="link-list-wrapper">
                            <div class="link-list-heading text-uppercase mt-2 mt-lg-4 mb-3 ps-0">
                                Ricerche frequenti
                            </div>
                            <ul class="link-list d-flex flex-wrap">
                                <?php
                                foreach ($popular_posts->posts as $post) {
                                    $group = dci_get_group($post->post_type);
                                ?>
                                    <li>
                                        <a class="list-item mb-1 active ps-0" href="<?php the_permalink() ?>">
                                            <span class="text-button-normal"><?php the_title() ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>