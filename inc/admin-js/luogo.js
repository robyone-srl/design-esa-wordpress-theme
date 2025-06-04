jQuery( document ).ready(function($) {

    var inputGPSLat = document.querySelector('#_dci_luogo_posizione_gps_lat');
    setTimeout(function() {
        inputGPSLat.setAttribute('data-text', 'whatever');
    }, 5000)
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === "attributes") {
                dci_remove_highlight_missing_field('.cmb2-id--dci-luogo-posizione-gps');
            }
        });
    });

    observer.observe(inputGPSLat, {
        attributes: true //configure it to listen to attribute changes
    });

    var inputGPSLng = document.querySelector('#_dci_luogo_posizione_gps_lng');
    var observer1 = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === "attributes") {
                dci_remove_highlight_missing_field('.cmb2-id--dci-luogo-posizione-gps');
            }
        });
    });

    observer1.observe(inputGPSLng, {
        attributes: true //configure it to listen to attribute changes
    });

    var puntiContattoLuogoField = $('#_dci_luogo_punti_contatto');
    var strutturaResponsabileLuogoField = $('#_dci_luogo_struttura_responsabile');
    var personeDelLuogoField = $('#_dci_luogo_persone_del_luogo_1');

    var puntiContattoLuogoContainerClass = '.cmb2-id--dci-luogo-punti-contatto';
    var strutturaResponsabileLuogoContainerClass = '.cmb2-id--dci-luogo-struttura-responsabile';
    var personeDelLuogoContainerClass = '.cmb2-id--dci-luogo-persone-del-luogo-1';

    function dci_remove_highlight_missing_field_luogo(fieldClass) {
        $(fieldClass).removeClass("highlighted_missing_field");
        $(fieldClass).find('.field-required-msg').remove();


    }

    function dci_highlight_missing_field_luogo(fieldClass, customMessage) {
        var message = customMessage || 'Campo obbligatorio';
        dci_remove_highlight_missing_field_luogo(fieldClass); // Rimuovi messaggi precedenti

        $(fieldClass).addClass("highlighted_missing_field")
            .append('<div class="field-required-msg"><em>' + message + '</em></div>');

        var firstHighlightedField = $(".highlighted_missing_field:first");
        if (firstHighlightedField.length) {
            $('html,body').animate({
                scrollTop: firstHighlightedField.offset().top - 100
            }, 'slow');
        }
    }

    puntiContattoLuogoField.on('change', function () {
        var val = $(this).val();
        if (val !== null && val.length > 0) {
            dci_remove_highlight_missing_field_luogo(puntiContattoLuogoContainerClass);
        }
    });

    strutturaResponsabileLuogoField.on('change', function () {
        var val = $(this).val();
        if (val !== null && val.length > 0) {
            dci_remove_highlight_missing_field_luogo(strutturaResponsabileLuogoContainerClass);
        }
    });

    personeDelLuogoField.on('change', function () {
        var val = $(this).val();
        if (val !== null && val.length > 0) {
            dci_remove_highlight_missing_field_luogo(personeDelLuogoContainerClass);
        }
    });

    jQuery( 'form[name="post"]' ).on('submit', function(e) {

        /**
         * controllo compilazione campo GPS
         */
        if(document.activeElement.id === 'publish' && (jQuery('input[name^="_dci_luogo_posizione_gps[lat]"]').attr('value') === '' || jQuery('input[name^="_dci_luogo_posizione_gps[lng]"]').attr('value') === '')) {
            dci_highlight_missing_field('.cmb2-id--dci-luogo-posizione-gps');
            return false;
        }

        if ($('body').hasClass('post-type-luogo') === false) {
            return true;
        }

        if (document.activeElement.id !== 'publish' && document.activeElement.name !== 'save') {
            return true;
        }

        var puntiContattoValue = puntiContattoLuogoField.val();
        var strutturaResponsabileValue = strutturaResponsabileLuogoField.val();
        var personeDelLuogoValue = personeDelLuogoField.val();

        var isPuntiContattoEmpty = (puntiContattoValue === null || puntiContattoValue.length === 0);
        var isStrutturaResponsabileEmpty = (strutturaResponsabileValue === null || strutturaResponsabileValue.length === 0);
        var isPersoneDelLuogoEmpty = (personeDelLuogoValue === null || personeDelLuogoValue.length === 0);

        dci_remove_highlight_missing_field_luogo(puntiContattoLuogoContainerClass);
        dci_remove_highlight_missing_field_luogo(strutturaResponsabileLuogoContainerClass);
        dci_remove_highlight_missing_field_luogo(personeDelLuogoContainerClass);

        if (isPuntiContattoEmpty && isStrutturaResponsabileEmpty && isPersoneDelLuogoEmpty) {
            var errorMessage = "&Egrave; necessario compilare almeno uno tra 'Punti di contatto', 'Unit&agrave; organizzativa responsabile' o 'Persone'.";

            dci_highlight_missing_field_luogo(puntiContattoLuogoContainerClass, errorMessage);

            e.preventDefault();
            return false;
        }

        return true;
    })
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
