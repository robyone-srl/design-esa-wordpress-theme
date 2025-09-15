<?php
/**
 * Generic Content template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */


get_header();
?>
    <main>
        <?php
        while ( have_posts() ) :
            the_post();
            set_views($post->ID);
            $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);
            $descrizione_breve = dci_get_meta("descrizione_breve");
            ?>
            <div class="container px-4 my-4" id="main-container">
                <div class="row">
                    <div class="col px-lg-4">
                        <?php get_template_part("template-parts/common/breadcrumb"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 px-lg-4 py-lg-2">
                        <h1 data-audio><?php the_title(); ?></h1>
                        <p data-audio>
                            <?php echo $descrizione_breve; ?>
                        </p>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <?php 
                        $inline = true;
                        get_template_part('template-parts/single/actions');
                        ?>
                    </div>
                </div>
            </div>

            <div class="container ">
                <article class="article-wrapper" data-audio>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            the_content();
                            ?>

                            <div class="callout note">
                                <div class="callout-inner">
                                    <div class="callout-title">
                                        <svg class="icon"><use href="#it-info-circle"></use></svg>
                                        <span class="visually-hidden">Attenzione</span> 
                                        <span class="text">Attenzione</span>
                                    </div>
                                    <p><strong>Il modello di questa pagina non è ancora disponibile.</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php get_template_part( "template-parts/single/bottom" ); ?>
                        </div><!-- /col-lg-9 -->
                    </div><!-- /row -->

                </article>
            </div>
        <?php get_template_part("template-parts/common/valuta-servizio"); ?>

        <?php
        endwhile; // End of the loop.
        ?>
    </main>
<?php get_footer(); ?>
