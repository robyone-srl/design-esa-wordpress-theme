jQuery( document ).ready(function() {

    let input = jQuery('input[name^="_dci_page_uo_tipo"]');
    input.each(function() {
        jQuery(this).click(function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-page-uo-tipo');
        });
    });

    let input_ti = jQuery('input[name^="_dci_page_tipo_incarico"]');
    input_ti.each(function() {
        jQuery(this).click(function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-page-tipo-incarico');
        });
    });

    jQuery( 'form[name="post"]' ).on('submit', function(e) {

        let check_input = jQuery('.cmb2-id--dci-page-uo-tipo').length > 0 && jQuery('.cmb2-id--dci-page-uo-tipo').css('display') !== 'none';

        /**
         * controllo compilazione campo UO Tipo
         */
        if(check_input && document.activeElement.id === 'publish' && jQuery('input[name^="_dci_page_uo_tipo"]:checked').length == 0){
            dci_highlight_missing_field('.cmb2-id--dci-page-uo-tipo');
            return false;
        }

        let check_input_ti = jQuery('.cmb2-id--dci-page-tipo-incarico').length > 0 && jQuery('.cmb2-id--dci-page-tipo-incarico').css('display') !== 'none';
		
		console.log(check_input_ti);

        /**
         * controllo compilazione campo Tipo INCARICO
         */
        if(check_input_ti && document.activeElement.id === 'publish' && jQuery('input[name^="_dci_page_tipo_incarico"]:checked').length == 0){
            dci_highlight_missing_field('.cmb2-id--dci-page-tipo-incarico');
            return false;
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
