<?php
global $order_values, $found_posts, $post_type_multiple;
?>

<div class="d-flex align-items-center justify-content-between" data-current-order="<?php echo esc_attr($order_values["option"]); ?>">
                <p id="autocomplete-label" class="u-grey-light text-paragraph-card mt-4 mb-4 mt-lg-30 mb-lg-30 mb-0 mt-0 pe-2">
                    <span class="badge rounded-pill bg-primary"> <?= $found_posts ?> </span> <?php echo $post_type_multiple; ?> in <strong id="current-order-text">
                    <?php
                        if ($order_values["option"] === "publish_date_desc") {
                            echo "ordine di pubblicazione decrescente";
                        } else if ($order_values["option"] === "publish_date_asc") {
                            echo "ordine di pubblicazione crescente";
                        } else if ($order_values["option"] === "post_title_desc") {
                            echo "ordine alfabetico inverso (Z-A)";
                        } else { 
                            echo "ordine alfabetico (A-Z)";
                        }
                    ?>
                    </strong>
                </p>

                <div class="btn-group">
                    <button type="button" title="Apri opzioni di ordinamento" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#OrderModal">
                        <span class="visually-hidden">Apri opzioni di ordinamento</span>
                        <use xlink:href="#it-more-actions"></use>
                        <svg class="icon icon-sm icon-white align-top">
                            <use xlink:href="#it-more-actions"></use>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="modal fade" id="OrderModal" tabindex="-1" aria-labelledby="OrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="h5 modal-title" id="OrderModalLabel">Seleziona un'opzione di ordinamento</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="order_by" id="opt-post_title_asc" value="post_title_asc" <?= $order_values["option"] === "post_title_asc" ? "checked" : "" ?>>
                            <label class="form-check-label" for="opt-post_title_asc">Ordine alfabetico (A-Z)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="order_by" id="opt-post_title_desc" value="post_title_desc" <?= $order_values["option"] === "post_title_desc" ? "checked" : "" ?>>
                            <label class="form-check-label" for="opt-post_title_desc">Ordine alfabetico inverso (Z-A)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="order_by" id="opt-publish_date_asc" value="publish_date_asc" <?= $order_values["option"] === "publish_date_asc" ? "checked" : "" ?> >
                            <label class="form-check-label" for="opt-publish_date_asc">Ordine di pubblicazione crescente</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="order_by" id="opt-publish_date_desc" value="publish_date_desc" <?= $order_values["option"] === "publish_date_desc" ? "checked" : "" ?> >
                            <label class="form-check-label" for="opt-publish_date_desc">Ordine di pubblicazione decrescente</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <button type="submit" class="btn btn-primary" id="save-selection" disabled>Salva</button>
                    </div>
                </div>
            </div>
        </div>