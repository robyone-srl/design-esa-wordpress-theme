jQuery( document ).ready(function() {

    let input = jQuery('input[name^="_dci_evento_argomenti"]');
    input.each(function() {
        jQuery(this).click(function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-evento-argomenti');
        });
    });

    jQuery( 'form[name="post"]' ).on('submit', function(e) {
        /**
         * controllo compilazione campo Argomenti
         */
        if(document.activeElement.id === 'publish' && jQuery('input[name^="_dci_evento_argomenti"]:checked').length == 0){
            dci_highlight_missing_field('.cmb2-id--dci-evento-argomenti');
            return false;
        }
        
        /**
         * controllo compilazione campo GPS
         */
        if(document.activeElement.id === 'publish' && (jQuery('input[name^="_dci_evento_posizione_gps_luogo_custom[lat]"]').attr('value') === '' || jQuery('input[name^="_dci_evento_posizione_gps_luogo_custom[lng]"]').attr('value') === '')) {
            dci_highlight_missing_field('.cmb2-id--dci-evento-posizione-gps-luogo-custom');
            return false;
        }
        return true;
    });

    if(jQuery('input:radio[name="_dci_evento_is_luogo_esa"]:checked').val() == "true"){
        dci_is_luogo_esa_enabled();
    }else{
        dci_is_luogo_esa_disabled();
    }
    jQuery('input:radio[name="_dci_evento_is_luogo_esa"]').change( function(){
        if (jQuery(this).is(':checked') && jQuery(this).val() == 'true') {
            dci_is_luogo_esa_enabled();
        }else{
            dci_is_luogo_esa_disabled();
        }
    });
});

function dci_is_luogo_esa_enabled(){
    jQuery(".cmb2-id--dci-evento-posizione-gps-luogo-custom").hide();

    jQuery("#_dci_evento_luogo_evento").attr("required", true);
    jQuery("#_dci_evento_nome_luogo_custom").removeAttr('required');
    jQuery("#_dci_evento_indirizzo_luogo_custom").removeAttr('required');
}

function dci_is_luogo_esa_disabled(){
    jQuery(".cmb2-id--dci-evento-posizione-gps-luogo-custom").show();

    jQuery("#_dci_evento_luogo_evento").removeAttr('required');
    jQuery("#_dci_evento_nome_luogo_custom").attr("required", true);
    jQuery("#_dci_evento_indirizzo_luogo_custom").attr("required", true);
}



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
