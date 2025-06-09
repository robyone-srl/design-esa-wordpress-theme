(function ($) {
    $(document).ready(function () {
        var $button = $('#dci-start-bulk-migration-button');
        var $spinner = $('#dci-bulk-migration-spinner');
        var $feedbackDiv = $('#dci-migration-feedback');
        var $resultsContent = $('#dci-migration-results-content');
        var $countDisplay = $('#dci-migratable-posts-count');

        // Funzione per caricare il conteggio iniziale dei post da migrare
        function loadInitialCount() {
            if (!$countDisplay.length) return; // Esci se l'elemento non esiste

            $countDisplay.html('<em>' + (dci_bulk_migration_params.text_counting || 'Conteggio in corso...') + '</em>');

            $.ajax({
                url: dci_bulk_migration_params.ajax_url,
                type: 'POST',
                data: {
                    action: dci_bulk_migration_params.count_action, // Nuova azione per il conteggio
                    nonce: dci_bulk_migration_params.count_nonce   // Nuovo nonce per il conteggio
                },
                success: function (response) {
                    if (response.success && typeof response.data.count !== 'undefined') {
                        $countDisplay.text(response.data.count);
                    } else {
                        var errorMsg = response.data && response.data.message ? response.data.message : dci_bulk_migration_params.text_count_error;
                        $countDisplay.html('<em style="color: red;">' + errorMsg + '</em>');
                        console.error('Initial Count AJAX Error:', response);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $countDisplay.html('<em style="color: red;">' + dci_bulk_migration_params.text_count_error + '</em>');
                    console.error('Initial Count AJAX Request Failed:', textStatus, errorThrown);
                }
            });
        }

        // Carica il conteggio iniziale quando la pagina è pronta
        loadInitialCount();

        $button.on('click', function () {
            if (!confirm(dci_bulk_migration_params.text_confirm_migration || 'Sei sicuro di voler avviare la migrazione massiva? Questa operazione &agreve; i dati dei post. Si consiglia un backup.')) {
                return;
            }

            $button.prop('disabled', true);
            $spinner.css('visibility', 'visible');
            $feedbackDiv.hide();
            $resultsContent.html(dci_bulk_migration_params.text_processing || 'Elaborazione in corso...');
            $feedbackDiv.removeClass('notice-success notice-error').show();


            $.ajax({
                url: dci_bulk_migration_params.ajax_url,
                type: 'POST',
                data: {
                    action: dci_bulk_migration_params.action, // Azione per la migrazione effettiva
                    nonce: dci_bulk_migration_params.nonce    // Nonce per la migrazione effettiva
                },
                success: function (response) {
                    if (response.success) {
                        $resultsContent.html('<p style="color: green;">' + response.data.message.replace(/\n/g, '<br>') + '</p>');
                        $feedbackDiv.removeClass('notice-error').addClass('notice notice-success is-dismissible').show();
                        if (response.data.stats) {
                            console.log('Statistiche Migrazione:', response.data.stats);
                        }
                        // Ricarica il conteggio dopo la migrazione per aggiornare il numero
                        loadInitialCount();
                    } else {
                        var errorMessage = response.data && response.data.message ? response.data.message : dci_bulk_migration_params.text_error;
                        $resultsContent.html('<p style="color: red;">' + errorMessage.replace(/\n/g, '<br>') + '</p>');
                        $feedbackDiv.removeClass('notice-success').addClass('notice notice-error is-dismissible').show();
                        if (response.data && response.data.stats) {
                            console.error('Statistiche Migrazione con Errori:', response.data.stats);
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    var errorText = dci_bulk_migration_params.text_error;
                    if (jqXHR.responseJSON && jqXHR.responseJSON.data && jqXHR.responseJSON.data.message) {
                        errorText = jqXHR.responseJSON.data.message;
                    } else if (jqXHR.responseText) {
                        try {
                            var errResponse = JSON.parse(jqXHR.responseText);
                            if (errResponse.data && errResponse.data.message) {
                                errorText = errResponse.data.message;
                            }
                        } catch (e) {
                            errorText = jqXHR.responseText.substring(0, 200) + "... (controlla la console per l'errore completo)";
                        }
                    }
                    $resultsContent.html('<p style="color: red;">' + errorText.replace(/\n/g, '<br>') + '</p>');
                    $feedbackDiv.removeClass('notice-success').addClass('notice notice-error is-dismissible').show();
                },
                complete: function () {
                    $button.prop('disabled', false);
                    $spinner.css('visibility', 'hidden');
                }
            });
        });

        $feedbackDiv.on('click', '.notice-dismiss', function () {
            $(this).closest('.is-dismissible').hide();
        });
    });
})(jQuery);
