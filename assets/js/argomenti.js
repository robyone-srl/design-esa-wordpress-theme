let postTypeDefault = 'argomenti-griglia';
let pageCurrent = 1;
let pageCount = 9;
let pagesTotal = 1;
let loadingHtml = `<div id="loading-overlay" class="w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center pt-5">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Caricamento...</span>
                    </div>
                    <p class="mt-2">Caricamento...</p>
                </div>
            </div>`;


$(document).ready(function () {

    /* NOTIZIE E LINK */

    var maxPages = 5;

    var currentNotiziePage = parseInt($('#notizie-pagination-container').data('notizia-corrente')); 
    var totalNotiziePages = parseInt($('#notizie-pagination-container').data('notizie-totali'));


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

    /* ALTRI CONTENUTI */

    pagesTotal = parseInt($('#card-pagination-container').data('card-totali'));
    $('#pagination_container').on('click', '.page-link', function (e) {
        e.preventDefault();

        var page = $(this).data('page');
        var slugArgomento = $('#card-pagination-container').data('slug');

        if (page !== pageCurrent) {
            pageCurrent = page;

            var container = $('#tutti .card-wrapper');
            container.html(loadingHtml);

            requestPageContent('load_card_page', container, page, slugArgomento, postTypeDefault, pageCount, pagesTotal);
        }
    });

    $('.filters-list').on('click', 'button[data-term]', function () {
        var btn = $(this);

        resetButtonHighlighting();

        btn.removeClass('btn-outline-primary').addClass('btn-primary');

        if (btn.data('term')) {
            var slugArgomento = btn.data('term');
            var postType = btn.data('post-type');
            postTypeDefault = postType;
            var container = $('#tutti .card-wrapper');

            container.html(loadingHtml);

            console.log('load_card_page' + '|' + slugArgomento + " | " + postType);

            requestPageContent('load_card_page', container, 1, slugArgomento, postType, pageCount, pagesTotal);

        }
    });

    $('#save-selection').on('click', function () {
        var selectedOption = $('input[name="filterOption"]:checked');

        if (selectedOption.length > 0) {
            var optionValue = selectedOption.val();
            postTypeDefault = optionValue;
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

function updateCardPagination(pageCount, pageCurrent, pagesTotal, slugArgomento) {
    pagesTotal = Math.max(pagesTotal, 1);

    var startPage = Math.max(1, pageCurrent - Math.floor(pageCount / 2));
    var endPage = Math.min(pagesTotal, startPage + pageCount - 1);

    if (endPage - startPage + 1 < pageCount && startPage > 1) {
        startPage = Math.max(1, endPage - pageCount + 1);
    }

    console.log('Paginazione | pageCount ' + pageCount);
    console.log('Paginazione | pageCurrent ' + pageCurrent);
    console.log('Paginazione | pagesTotal ' + pagesTotal);
    console.log('Paginazione | slugArgomento ' + slugArgomento);

    var container = $('#pagination_container');

    container.empty();

    var content = [];
    
    if (pagesTotal > 1) {
        content.push(`<div class="row mt-4" id="card-pagination-container" data-card-corrente="${pageCurrent}" data-card-totali="${pagesTotal}" data-slug="${slugArgomento}"> <div class="col-12"> <nav> <ul class="pagination justify-content-center" id="card-pagination"> `);

        if (pageCurrent > 1) {
            content.push(`<li class="page-item" id="prev-page-card">
                <a class="page-link" href="#" data-page="${pageCurrent - 1}" aria-label="Precedente">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`);
        }

        for (let i = startPage; i <= endPage; i++) {
            content.push(`<li class="page-item ${(i == pageCurrent) ? 'active' : ''}">
                <a class="page-link ${(i == pageCurrent) ? 'border border-primary rounded' : ''}" href="#" data-page="${i}">
                    ${i}
                </a>
            </li>`);
        }

        if (pageCurrent < pagesTotal) {
            content.push(`<li class="page-item" id="next-page-card">
                <a class="page-link" href="#" data-page="${pageCurrent + 1}" aria-label="Successivo">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`);
        }
        content.push(`</ul> </nav> </div> </div>`);
    }
    container.html(content.join(''));
}

function requestPageContent(action, container, page, slugArgomento, postTypeDefault, pageCount, pagesTotal, resetPaginationValue) {
    
    var data = {
        action: action,
        pagina_card: page,
        term: slugArgomento,
        post_type: postTypeDefault

    };
    $.ajax({
        url: myAjax.ajaxurl,
        type: 'POST',
        data: data,
        success: function (response) {

            if (response.success) {
                console.log(response);
                container.empty();
                response.data.data.forEach(function (post) {
                    var cardHTML = createCardHTML(post);
                    container.append(cardHTML);
                });

                pageCurrent = page;
                pagesTotal = response.data.total_pages;
                updateCardPagination(pageCount, page, pagesTotal, slugArgomento);
            } else {
                $('#tutti .card-wrapper').html('<p class="pt-5 d-flex justify-content-center w-100 text-center">Nessun risultato</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
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
