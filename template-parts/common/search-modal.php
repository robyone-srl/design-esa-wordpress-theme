<?php 
  $links = dci_get_option('contenuti','ricerca');
?>
<!-- Search Modal -->
<div
    class="modal fade search-modal"
    id="search-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content perfect-scrollbar">
      <div class="modal-body">
        <form role="search" id="search-form-modal" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <div class="container">
            <div class="row variable-gutters">
              <div class="col">
                <div class="modal-title">
                  <button
                    class="search-link d-md-none"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#search-modal"
                    aria-label="Cerca nel sito"
                  >
                    <svg class="icon icon-md">
                      <use
                        href="#it-arrow-left"
                      ></use>
                    </svg>
                  </button>
                  <p><span class="h2"><?php _e("Cerca","design_comuni_italia"); ?></span></p>
                  <button
                    class="search-link d-none d-md-block"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#search-modal"
                    data-dismiss="modal" 
                    aria-label="Chiudi e torna alla pagina precedente"
                  >
                    <svg class="icon icon-md">
                      <use
                        href="#it-close-big"
                      ></use>
                    </svg>
                  </button>
                </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <svg class="icon icon-md">
                            <use
                              href="#it-search"
                            ></use>
                          </svg>
                        </div>
                      </div>
                      <label for="search">Con Etichetta</label>
                      <input
                        type="search"
                        class="form-control"
                        id="search"
                        name="s"
                        placeholder="<?php _e("Cerca nel sito","design_comuni_italia"); ?>"
                        value="<?php echo get_search_query(); ?>"
                      />
                    </div>
                    <button
                      type="submit"
                      class="btn btn-primary"
                    >
                      <span class="">Cerca</span>
                    </button>
                  </div>
              </div>
            </div>

                  <div class="row variable-gutters p-4">
                      <div class="col-lg-5">
                          <div class="h4 other-link-title">Ricerche frequenti</div>
                          <div class="link-list-wrapper mb-4">
                            <ul class="link-list">
                                <?php
                                $popular_posts = new WP_Query( array(
                                    'post_type'     => dci_get_sercheable_tipologie(), 
                                    'posts_per_page' => 7, 
                                    'meta_key'      => 'views',
                                    'orderby'       => 'meta_value_num',
                                    'order'         => 'DESC'
                                    )
                                );

                                if (is_array($popular_posts->posts) && count($popular_posts->posts)>0) {
                                    foreach ($popular_posts->posts as $post) {
                                    $group = dci_get_group($post->post_type);
                                ?>
                                    <li>
                                        <a class="list-item large py-1 icon-left"  href="<?php the_permalink(); ?>">
                                        <span class="list-item-title-icon-wrapper">
                                          <svg class="icon icon-primary icon-sm"><use href="#it-search"></use></svg>
                                          <span class="list-item-title"><?php the_title(); ?></span>
                                        </span>
                                      </a>
                                        <!-- <span><?php #echo dsi_get_italian_name_group($group) ?></span> -->
                                    </li>
                                <?php
                                }} else { ?>
                                    <li>Nessun risultato</li>
                                <?php };
                                wp_reset_query();
                                ?>
                            </ul>
                          </div>

                          <?php if ($links) { ?>
                                  <div class="h4 other-link-title">Scelti per te</div>
                                  <div class="link-list-wrapper mb-4">
                                    <ul class="link-list">
                                    <?php foreach ($links as $link_id) { 
                                      $link = get_post($link_id);  
                                    ?>
                                      <li>
                                          <a class="list-item ps-0" href="<?php echo get_permalink($link_id); ?>" aria-label="Vai alla pagina <?php echo $link->post_title; ?>" title="Vai alla pagina <?php echo $link->post_title; ?>"
                                          ><span class="text-button-normal"
                                              ><?php echo $link->post_title; ?></span
                                          ></a
                                          >
                                      </li>
                                  <?php } ?>
                                    </ul>
                                    </div>
                            <?php } ?>
                      </div> 
                      <div class="col-lg-6">
                      <?php
                      $argomenti = get_terms(array(
                          'taxonomy' => 'argomenti',
                          'orderby' => 'count',
                          'order'   => 'DESC',
                          'hide_empty'   => 1,
                          'number' => "20"
                      ));
                      if(!empty($argomenti)) { ?>
                      <div class="row variable-gutters">
                          <div class="col-lg-12">
                              <div class="badges-wrapper">
                                  <div class="h4 other-link-title"><?php _e("Potrebbero interessarti","design_comuni_italia"); ?></div>
                                  <div class="badges">
                                      <?php
                                      foreach ($argomenti as $argomento){
                                          $taglink = get_tag_link($argomento);  ?>
                                          <a href="<?php echo $taglink; ?>" class="chip chip-simple chip-lg"><span class="chip-label"><?php echo $argomento->name; ?></span></a>
                                      <?php } ?>
                                  </div><!-- /badges -->
                              </div><!-- /badges-wrapper -->
                          </div>
                      </div>
                      <?php } ?>
                      </div> <!-- TAGS -->
                  </div>     
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Search Modal -->

