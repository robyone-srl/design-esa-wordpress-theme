$(document).ready(function () {
    var currentNotiziePage = parseInt($('#notizie-pagination-container').data('notizia-corrente')); 
    var totalNotiziePages = parseInt($('#notizie-pagination-container').data('notizie-totali'));
    var maxPages = 5;

    $('#notizie-pagination .page-link').on('click', function (e) {
        e.preventDefault();

        var page = $(this).data('page');
        var slugArgomento = $('#notizie-pagination-container').data('slug');

        if ($(this).closest('li').is('#prev-page-notizie')) {
            page = Math.max(1, currentNotiziePage - 1);
        } else if ($(this).closest('li').is('#next-page-notizie')) {
            page = Math.min(totalNotiziePages, currentNotiziePage + 1);
        } else {
            page = $(this).data('page');
        }

        if (page !== currentNotiziePage) {
            currentNotiziePage = page;
            loadNotiziePage(page, slugArgomento, maxPages, currentNotiziePage, totalNotiziePages);
            updateNotiziePagination(maxPages, currentNotiziePage, totalNotiziePages);
        }
    });

    updateNotiziePagination(maxPages, currentNotiziePage, totalNotiziePages); 

    var currentEventiPage = $('#pagination-container').data('evento-corrente');
    var totalEventiPages = $('#pagination-container').data('eventi-totali');

    $('#eventi-pagination .page-link').on('click', function (e) {
        e.preventDefault();

        var page = $(this).data('page');
        var slugArgomento = $('#notizie-pagination-container').data('slug');

        if ($(this).parent().hasClass('page-item-prev')) {
            page = Math.max(1, currentEventiPage - 1);
        } else if ($(this).parent().hasClass('page-item-next')) {
            page = Math.min(totalEventiPages, currentEventiPage + 1);
        } else {
            page = $(this).data('page');
        }

        if (page !== currentEventiPage) {
            currentEventiPage = page;
            loadEventiPage(page, slugArgomento, maxPages, currentEventiPage, totalEventiPages);
            updateEventiPagination(maxPages, currentEventiPage, totalEventiPages);
        }
    });

    updateEventiPagination(maxPages, currentEventiPage, totalEventiPages);

    $('.filters-list').on('click', 'button[data-term]', function () {
        var btn = $(this);

        resetButtonHighlighting();

        btn.removeClass('btn-outline-primary').addClass('btn-primary');
        if (btn.data('term')) {
            var term = btn.data('term');
            var postType = btn.data('post-type');
            var container = $('#tutti .card-wrapper');

            container.html(`<div id="loading-overlay" class="w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center pt-5">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Caricamento...</span>
                        </div>
                        <p class="mt-2">Caricamento...</p>
                    </div>
                </div>`);

            $.ajax({
                url: myAjax.ajaxurl,
                type: 'GET',
                data: {
                action: 'cambiaRisultato',
                term: term,
                post_type: postType
            },
                success: function (response) {
                    if (response.success) {
                        var htmlContent = response.data.data;
                        if (typeof htmlContent === 'string') {
                            var cleanData = htmlContent.replace(/\\r\\n/g, '').replace(/\\n/g, '').replace(/\\t/g, '').replace(/\\\"/g, '"');
                            container.html(cleanData);
                        }
                    } else {
                        $('#tutti .card-wrapper').html('<p class="pt-5 d-flex justify-content-center w-100 text-center">Nessun risultato</p>');
                    }
                },
            });
}
    });

    $('#save-selection').on('click', function () {
        var selectedOption = $('input[name="filterOption"]:checked');

        if (selectedOption.length > 0) {
            var optionValue = selectedOption.val();
            var optionLabel = selectedOption.parent().children('label').text();

            $(".filters-list .btn-extra-filter").remove();

            var existentButtons = $('.filters-list button[data-post-type="' + optionValue + '"]');
            var argomento = $('#tutte-cargorie-card-row').data('slug');

            if (!existentButtons.length) {
                var newButtonHtml = `<button type="button" class="btn btn-extra-filter btn-outline-primary btn-xs w-150" 
                                            data-post-type="${optionValue}" 
                                            data-term="${argomento}">
                                            ${optionLabel}
                                          </button>`;
                $('.filters-list').append(newButtonHtml);

                var newButton = $('.filters-list button[data-post-type="' + optionValue + '"]');

                newButton.trigger('click');
            } else {
                existentButtons.removeClass('btn-outline-primary').addClass('btn-primary');

                existentButtons.trigger('click');
            }

            resetButtonHighlighting();

            $('.filters-list button[data-post-type="' + optionValue + '"]').toggleClass('btn-primary btn-outline-primary');

            var modal = bootstrap.Modal.getInstance($('#moreOptionsModal')[0]);
            if (modal) {
                modal.hide();
            }
        }
    });
});

function updateNotiziePagination(maxPages, currentNotiziePage, totalNotiziePages) {
    if (currentNotiziePage <= 1) {
        $('#prev-page-notizie').hide();
    } else {
        $('#prev-page-notizie').show();
    }

    if (currentNotiziePage >= totalNotiziePages) {
        $('#next-page-notizie').hide();
    } else {
        $('#next-page-notizie').show();
    }

    $('#notizie-pagination .page-item').removeClass('active');
    $('#notizie-pagination .page-link').removeClass('border border-primary rounded');

    $('#page-notizie-' + currentNotiziePage).addClass('active');
    $('#page-notizie-' + currentNotiziePage).find('.page-link').addClass('border border-primary rounded');

    var startPage = Math.max(1, currentNotiziePage - Math.floor(maxPages / 2));
    var endPage = Math.min(totalNotiziePages, startPage + maxPages - 1);

    if (endPage - startPage + 1 < maxPages && startPage > 1) {
        startPage = Math.max(1, endPage - maxPages + 1);
    }

    $('#notizie-pagination .page-item').each(function () {
        var pageNum = parseInt($(this).find('.page-link').data('page'));

        if (pageNum < startPage || pageNum > endPage) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });

    if (currentNotiziePage === 1) {
        $('#prev-page-notizie').hide();
    }

    if (currentNotiziePage === totalNotiziePages) {
        $('#next-page-notizie').hide();
    }
}

function loadNotiziePage(page, slugArgomento, maxPages, currentNotiziePage, totalNotiziePages) {
    var container = $('#notizie-row');

    container.html(`<div id="loading-overlay" class="w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Caricamento...</span>
                        </div>
                        <p class="mt-2">Caricamento...</p>
                    </div>
                </div>`);

    var data = {
        action: 'load_notizie_page',
        pagina_notizie: page,
        slug_argomento: slugArgomento
    };

    $.ajax({
        url: myAjax.ajaxurl,
        method: 'POST',
        data: data,
        success: function (response) {
            if ($.trim(response) !== '') {
                container.html(response);
                updateNotiziePagination(maxPages, currentNotiziePage, totalNotiziePages);
            }
        }
    });
}

function updateEventiPagination(maxPages, currentEventiPage, totalEventiPages) {
    if (currentEventiPage <= 1) {
        $('#prev-page').hide();
    } else {
        $('#prev-page').show();
    }

    if (currentEventiPage >= totalEventiPages) {
        $('#next-page').hide();
    } else {
        $('#next-page').show();
    }

    $('#eventi-pagination .page-item').removeClass('active');
    $('#eventi-pagination .page-link').removeClass('border border-primary rounded');

    $('#page-' + currentEventiPage).addClass('active');
    $('#page-' + currentEventiPage).find('.page-link').addClass('border border-primary rounded');

    var startPage = Math.max(1, currentEventiPage - Math.floor(maxPages / 2));
    var endPage = Math.min(totalEventiPages, startPage + maxPages - 1);

    if (endPage - startPage + 1 < maxPages && startPage > 1) {
        startPage = Math.max(1, endPage - maxPages + 1);
    }

    $('#eventi-pagination .page-item').each(function () {
        var pageNum = parseInt($(this).find('.page-link').data('page'));

        if (pageNum < startPage || pageNum > endPage) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });

    if (currentEventiPage === 1) {
        $('#prev-page').hide();
    }

    if (currentEventiPage === totalEventiPages) {
        $('#next-page').hide();
    }
}

function loadEventiPage(page, slugArgomento, maxPages, currentEventiPage, totalEventiPages) {
    var container = $('#eventi-row');

    container.html(`<div id="loading-overlay" class="w-100 h-100 bg-grey-dsk bg-opacity-75 d-flex justify-content-center align-items-center">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Caricamento...</span>
                        </div>
                        <p class="mt-2">Caricamento...</p>
                    </div>
                </div>`);

    var data = {
        action: 'load_eventi_page',
        pagina_eventi: page,
        slug_argomento: slugArgomento
    };

    $.ajax({
        url: myAjax.ajaxurl,
        method: 'POST',
        data: data,
        success: function (response) {
            if ($.trim(response) !== '') {
                container.html(response);
                updateEventiPagination(maxPages, currentEventiPage, totalEventiPages);
            }
        },
        error: function (error) {
            console.error('Errore AJAX:', error);
        }
    });
}

function resetButtonHighlighting() {
    $('.filters-list button').removeClass('btn-primary').addClass('btn-outline-primary');
}