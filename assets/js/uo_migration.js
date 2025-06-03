// Assicura che jQuery sia disponibile e $ sia un alias per jQuery in questo scope.
(function ($) {
    // Esegui quando il DOM è pronto.
    $(document).ready(function () {
        // Listener per il click sul pulsante di migrazione
        $(document).on('click', '.dci-migrate-button', function () {
            var $button = $(this);
            var sourceFieldId = $button.data('source-field-id'); // ID del campo pw_select (usato come meta_key)
            var targetFieldId = $button.data('target-field-id'); // ID del campo pw_multiselect
            var sourceValueFromMeta = $button.data('source-value-from-meta'); // Valore letto da PHP via post_meta

            var $targetField = $('#' + targetFieldId);

            var $messageDiv = $button.closest('div').find('.dci-migration-message');
            $messageDiv.hide().removeClass('dci-message-success dci-message-error dci-message-warning dci-message-info').removeAttr('style');

            var styles = {
                error: { 'border-color': '#dc3232', 'background-color': '#f8d7da', 'color': '#721c24', 'padding': '10px', 'border-width': '1px', 'border-style': 'solid', 'border-radius': '3px' },
                warning: { 'border-color': '#ffb900', 'background-color': '#fff3cd', 'color': '#856404', 'padding': '10px', 'border-width': '1px', 'border-style': 'solid', 'border-radius': '3px' },
                success: { 'border-color': '#46b450', 'background-color': '#d4edda', 'color': '#155724', 'padding': '10px', 'border-width': '1px', 'border-style': 'solid', 'border-radius': '3px' },
                info: { 'border-color': '#00a0d2', 'background-color': '#cfe2ff', 'color': '#0c5460', 'padding': '10px', 'border-width': '1px', 'border-style': 'solid', 'border-radius': '3px' }
            };

            function showMessage(type, text) {
                $messageDiv.text(text).css(styles[type] || styles.info).show();
            }

            // Determina il valore sorgente
            var sourceValue = '';
            if (typeof sourceValueFromMeta !== 'undefined' && sourceValueFromMeta !== null && String(sourceValueFromMeta).trim() !== '') {
                sourceValue = String(sourceValueFromMeta).trim();
            } else {
                // Fallback: prova a leggere dal campo HTML se esiste (per compatibilità o se il campo non è ancora rimosso)
                var $sourceField = $('#' + sourceFieldId); // L'ID HTML del campo sorgente, se esiste
                if ($sourceField.length > 0) {
                    sourceValue = $sourceField.val();
                    if (sourceValue !== null) {
                        sourceValue = String(sourceValue).trim();
                    }
                }
            }

            // Verifica che il campo destinazione esista
            if ($targetField.length === 0) {
                showMessage('error', 'Errore: Campo destinazione ("' + targetFieldId + '") non trovato. Controlla l\'ID del campo.');
                return;
            }

            // Controlla se è stato trovato un valore sorgente
            if (!sourceValue) {
                showMessage('warning', 'Nessun valore sorgente trovato (né da meta né da campo HTML) per "' + sourceFieldId + '".');
                return;
            }

            var currentTargetValues = $targetField.val() || [];
            if (!Array.isArray(currentTargetValues)) {
                currentTargetValues = (currentTargetValues === null || currentTargetValues === '') ? [] : [currentTargetValues];
            }
            currentTargetValues = currentTargetValues.filter(function (value) {
                return value !== '' && value !== null;
            });

            if ($.inArray(sourceValue, currentTargetValues) === -1) {
                currentTargetValues.push(sourceValue);
                $targetField.val(currentTargetValues).trigger('change');
                // if (typeof $targetField.select2 === 'function') { $targetField.trigger('change.select2'); }
                showMessage('success', 'Valore "' + sourceValue + '" trasferito da "' + sourceFieldId + '" (meta) a "' + targetFieldId + '". IMPORTANTE: Ricorda di SALVARE o AGGIORNARE il post.');
            } else {
                showMessage('info', 'Il valore "' + sourceValue + '" (da meta) è già presente nel campo destinazione ("' + targetFieldId + '").');
            }
        });
    });
})(jQuery);
