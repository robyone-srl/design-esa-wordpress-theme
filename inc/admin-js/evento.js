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
        if(document.activeElement.id === 'publish' && (jQuery('input[name^="_dci_evento_posizione_gps_luogo_custom[lat]"][required]').attr('value') === '' || jQuery('input[name^="_dci_evento_posizione_gps_luogo_custom[lng]"][required]').attr('value') === '')) {
            dci_highlight_missing_field('.cmb2-id--dci-evento-posizione-gps-luogo-custom');
            return false;
        }
        return true;
    });

    if(jQuery('input:radio[name="_dci_evento_is_luogo_esa"]:checked').val() == "true"){
        dci_enable_luogo_esa();
    }else{
        dci_disable_luogo_esa();
    }
    jQuery('input:radio[name="_dci_evento_is_luogo_esa"]').change( function(){
        if (jQuery(this).is(':checked') && jQuery(this).val() == 'true') {
            dci_enable_luogo_esa();
        }else{
            dci_disable_luogo_esa();
        }
    });

    if(jQuery('input:radio[name="_dci_evento_evento_ripetuto"]:checked').val() == "true"){
        dci_enable_evento_ripetuto();
    }else{
        dci_disable_evento_ripetuto();
    }
    jQuery('input:radio[name="_dci_evento_evento_ripetuto"]').change( function(){
        if (jQuery(this).is(':checked') && jQuery(this).val() == 'true') {
            dci_enable_evento_ripetuto();
            dci_copy_single_event_to_first_event_repetition();
        }else{
            dci_disable_evento_ripetuto();
            dci_copy_first_event_repetition_to_single_event();
        }
    });
});

function dci_enable_luogo_esa(){
    jQuery(".cmb2-id--dci-evento-posizione-gps-luogo-custom").hide();

    jQuery("#_dci_evento_luogo_evento").attr("required", true);
    jQuery("#_dci_evento_nome_luogo_custom").removeAttr('required');
    jQuery("#_dci_evento_indirizzo_luogo_custom").removeAttr('required');
    jQuery("#_dci_evento_posizione_gps_luogo_custom_lat").removeAttr('required');
    jQuery("#_dci_evento_posizione_gps_luogo_custom_lng").removeAttr('required');
}

function dci_disable_luogo_esa(){
    jQuery(".cmb2-id--dci-evento-posizione-gps-luogo-custom").show();

    jQuery("#_dci_evento_luogo_evento").removeAttr('required');
    jQuery("#_dci_evento_nome_luogo_custom").attr("required", true);
    jQuery("#_dci_evento_indirizzo_luogo_custom").attr("required", true);
    jQuery("#_dci_evento_posizione_gps_luogo_custom_lat").attr("required", true);
    jQuery("#_dci_evento_posizione_gps_luogo_custom_lng").attr("required", true);
}


function dci_enable_evento_ripetuto(){
    jQuery(".cmb2-id--dci-evento-gruppo-eventi-ripetuti").show();

    jQuery(".cmb2-id--dci-evento-data-orario-inizio input").removeAttr('required');
    jQuery(".cmb2-id--dci-evento-data-orario-fine input").removeAttr('required');
    jQuery(".cmb2-id--dci-evento-gruppo-eventi-ripetuti input").attr("required", true);
}

function dci_disable_evento_ripetuto(){
    jQuery(".cmb2-id--dci-evento-gruppo-eventi-ripetuti").hide();
    
    jQuery(".cmb2-id--dci-evento-data-orario-inizio input").attr("required", true);
    jQuery(".cmb2-id--dci-evento-data-orario-fine input").attr("required", true);
    jQuery(".cmb2-id--dci-evento-gruppo-eventi-ripetuti input").removeAttr('required');
}

function dci_copy_single_event_to_first_event_repetition(){
    jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_inizio][date]']").val(jQuery("input[name='_dci_evento_data_orario_inizio[date]']").val());
    jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_inizio][time]']").val(jQuery("input[name='_dci_evento_data_orario_inizio[time]']").val());
    jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_fine][date]']").val(jQuery("input[name='_dci_evento_data_orario_fine[date]']").val());
    jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_fine][time]']").val(jQuery("input[name='_dci_evento_data_orario_fine[time]']").val());
}

function dci_copy_first_event_repetition_to_single_event(){
    jQuery("input[name='_dci_evento_data_orario_inizio[date]']").val(jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_inizio][date]']").val());
    jQuery("input[name='_dci_evento_data_orario_inizio[time]']").val(jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_inizio][time]']").val());
    jQuery("input[name='_dci_evento_data_orario_fine[date]']").val(jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_fine][date]']").val());
    jQuery("input[name='_dci_evento_data_orario_fine[time]']").val(jQuery("input[name='_dci_evento_gruppo_eventi_ripetuti[0][_dci_evento_data_orario_fine][time]']").val());
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
