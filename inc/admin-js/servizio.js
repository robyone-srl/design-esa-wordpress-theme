jQuery( document ).ready(function() {

    let input = jQuery('input[name^="_dci_servizio_argomenti"]');
    input.each(function() {
        jQuery(this).click(function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-argomenti');
        });
    });

    let inputCategorie = jQuery('input[name^="_dci_servizio_categorie"]');
    inputCategorie.each(function() {
        jQuery(this).click(function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-categorie');
        });
    });

    let inputMotivo = jQuery('textarea[name^="_dci_servizio_motivo_stato"]');
    inputMotivo.each(function() {
        jQuery(this).on('change keyup paste', function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-motivo-stato');
        });
    });



    jQuery( 'form[name="post"]' ).on('submit', function(e) {

        /**
         * controllo compilazione campo Categorie Servizio
         */
        if(document.activeElement.id === 'publish' && jQuery('input[name^="_dci_servizio_categorie"]:checked').length === 0){
            dci_highlight_missing_field('.cmb2-id--dci-servizio-categorie');
            return false;
        }

        /**
         * controllo compilazione campo Argomenti
         */
        if(document.activeElement.id === 'publish' && jQuery('input[name^="_dci_servizio_argomenti"]:checked').length === 0){
            dci_highlight_missing_field('.cmb2-id--dci-servizio-argomenti');
            return false;
        }

        /**
         * controllo compilazione campo Motivo dello stato
         */
        if (document.activeElement.id === 'publish' && jQuery('input[name^="_dci_servizio_stato"]:checked').val() === 'false'  && !jQuery('textarea[name^="_dci_servizio_motivo_stato"]').val()) {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-motivo-stato');
            return false;
        }

        /**
         * controllo che se il servizio non ha servizi richiesti allora abbia come fare, cosa serve e tempi e scadenze
         */
        if(document.activeElement.id === 'publish' && jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]>option:selected').length === 0){
            if(!controlla_che_campo_sia_compilato('_dci_servizio_come_fare'))
            return false
            
            if(!controlla_che_campo_sia_compilato('_dci_servizio_cosa_serve_introduzione'))
                return false
            
            if(!controlla_che_campo_sia_compilato('_dci_servizio_tempi_text'))
                return false
        }

        return true;
    });
});

function dci_highlight_missing_field(fieldClass) {

    jQuery(fieldClass).addClass("highlighted_missing_field")
        .append('<div id ="field-required-msg" class="field-required-msg"><em>Campo obbligatorio</em></div>')
    ;
    jQuery('html,body').animate({
        scrollTop: jQuery("#field-required-msg").parent().offset().top - 100
    }, 'slow');

}

function dci_remove_highlight_missing_field(fieldClass) {
    jQuery(fieldClass).removeClass("highlighted_missing_field");
    jQuery('.field-required-msg').remove();
}
