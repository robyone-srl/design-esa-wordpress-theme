<?php
global $argomento, $i, $the_query, $load_posts, $load_card_type, $label, $label_no_more, $classes, $content;
$load_posts = 10;

$post_types = dci_get_post_types_grouped('domande-frequenti');

$args = array(
    'showposts' => -1,
    'post_type' => $post_types,
    'tax_query' => array(
        array(
            'taxonomy' => 'argomenti',
            'field' => 'slug',
            'terms' => $argomento->name)
    ),
    'orderby' => 'title',
    'order' => 'ASC',
);
$the_query = new WP_Query( $args );
$faqs = $the_query->posts;

if(count($faqs)>0){
?>
<div class="section primary-bg-a4 py-5">
    <div class="container
">
        <div class="border-bottom border-2 border-primary mb-4">  
            <h3 class="h4"> Domande frequenti</h3>
        </div>
        
        <p>Di seguito le domande frequenti riguardanti all'argomento <?=$argomento->name?> </p>
         
        <div class="row align-items-center py-2">
            <div class="col-12 col-lg-8 offset-lg-2 px-0 px-sm-3">
                <div class="cmp-accordion faq">
                    <div class="accordion" id="accordion-faq">    
                        <?php 
                            $i = 0;
                            foreach ($faqs as $post) {
                                ++$i;
                                get_template_part("template-parts/domanda-frequente/item");
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 offset-lg-2 px-4 mt-40 mb-40 ">
            <?php
                $load_card_type = "domanda-frequente";
                $label = "Carica altre domande";
                $label_no_more = "Nessuna altra domanda";
                $classes = "btn btn-outline-primary w-100 title-medium-bold";
                get_template_part("template-parts/search/more-results");
            ?>
        </div>
    </div>     
</div>
<?php
}
?>