<?php
$argomenti = dci_get_terms_options('argomenti'); 
$arr_ids = array_keys((array)$argomenti); 

$terms_with_procedures = array();
foreach ($arr_ids as $term_id) {
    $query_check = new WP_Query(array(
        'post_type'   => 'procedura',
        'tax_query'   => array(
            array(
                'taxonomy' => 'argomenti',
                'field'    => 'id',
                'terms'    => $term_id
            )
        ),
        'posts_per_page' => 1 
    ));

    if ($query_check->have_posts()) {
        $terms_with_procedures[] = $term_id;
    }
}

$args = array(
    'taxonomy'   => 'argomenti',
    'hide_empty' => true,
    'include'    => $terms_with_procedures, 
);

$filtered_terms = get_terms($args);
$post_terms = isset($_GET['post_terms']) ? (array)$_GET['post_terms'] : array(); ?>

<div class="accordion argomenti_accordion">
    <div class="accordion-item">
        <div id="collapse-one" class="accordion-collapse collapse d-lg-block" role="region" aria-labelledby="accordion-title-one">
            <div class="accordion-body">
                <fieldset class="argomenti_fieldset">
                    <legend class="h6 px-2 pt-4 mb-0 text-uppercase category-list__title argomenti_fieldset_title">
                        Filtra per argomenti
                    </legend>
                    <div class="categoy-list pb-4">
                        <ul>
                            <?php 
                                if ($filtered_terms && !is_wp_error($filtered_terms)) {
                                    foreach ($filtered_terms as $argomento) {
                                        $arg_id = $argomento->term_id; 
                            ?>
                                        <li>
                                            <div class="form-check">
                                                <div class="checkbox-body border-light py-1">
                                                    <input
                                                        type="checkbox" 
                                                        id="<?php echo $arg_id; ?>" 
                                                        name="post_terms[]" 
                                                        value="<?php echo $arg_id; ?>"
                                                        <?php if (in_array($arg_id, $post_terms)) echo " checked "; ?>
                                                        onChange="this.form.submit()"
                                                    />
                                                    <label 
                                                        for="<?php echo $arg_id; ?>" 
                                                        class="subtitle-small_semi-bold mb-0 category-list__list"
                                                    >
                                                        <?php echo($argomento->name); ?> 
                                                    </label>
                                                </div>
                                            </div>
                                        </li> 
                            <?php 
                                    }
                                } else { ?>
                                    <p class="text-paragraph-regular-medium ps-2 mb-0">Nessun filtro disponibile</p> 
                                <?php } 
                            ?>
                        </ul>
                    </div>
                </fieldset>   
            </div>
        </div>
    </div>
</div>


                                        
<script>
$(document).ready(function () {
    SetupArgomenti();
});

$(window).resize(function() {
    SetupArgomenti();
});

function SetupArgomenti() {
    $(".argomenti_fieldset_title").remove();

    if (window.innerWidth >= 992) {
        if ($(".argomenti_fieldset_title").length === 0) {
            $(".argomenti_fieldset").prepend("<legend class=\"h6 px-2 pt-4 mb-0 text-uppercase category-list__title argomenti_fieldset_title\">Filtra per argomenti</legend>");
        }

        $(".argomenti_accordion .border-bottom").remove();

        const accordionButton = $('#accordion-title-one button');
        if (accordionButton.length > 0) {
            accordionButton.attr('data-bs-toggle', ''); 
            console.log("Rimosso toggle");
        }
    }

    if (window.innerWidth < 992) {
        if ($('#accordion-title-one').length === 0) {
            $(".argomenti_accordion .accordion-item").prepend(`
                <div class="border-bottom">
                    <span class="accordion-header" id="accordion-title-one">
                        <button class="accordion-button pb-10 px-3 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
                            <legend class="h6 text-uppercase category-list__title mb-0">Filtra per argomenti</legend>
                            <svg class="icon icon-xs right d-lg-none">
                                <use href="#it-expand"></use>
                            </svg>
                        </button>
                    </span>
                </div>
            `);
        }

        const accordionButton = $('#accordion-title-one button');
        if (accordionButton.length > 0) {
            accordionButton.attr('data-bs-toggle', 'collapse'); 
            console.log("Aggiunto toggle");
        }
    }
}
</script>