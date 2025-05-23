let loadingHtml = `<div id="loading-overlay" class="w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center pt-5">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Caricamento...</span>
                    </div>
                    <p class="mt-2">Caricamento...</p>
                </div>
            </div>`;
let darkLoadingHtml = `<div id="loading-overlay" class="w-100 h-100 bg-grey-dsk bg-opacity-75 d-flex justify-content-center align-items-center pt-5">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Caricamento...</span>
                    </div>
                    <p class="mt-2">Caricamento...</p>
                </div>
            </div>`;


$(document).ready(function () {

    $('.pagination-container').on('click', '.page-link', function (e) {
        e.preventDefault();

        var paginationRow = $(this).closest('.card-pagination-row');


        var page = $(this).data('page');
        var pageCurrent = paginationRow.data('card-corrente');

        if (page !== pageCurrent) {
            pageCurrent = page;

            
            var container = paginationRow.parent().parent();
            
            var slugArgomento = $('main').data('slug');
            var postType = paginationRow.data('post-type');
            var itemsPerPage = paginationRow.data('posts-per-page');

            requestPageContent('load_card_page', container, page, slugArgomento, postType, itemsPerPage);
        }
    });

    $('.filters-list').on('click', 'button[data-post-type]', function () {
        var btn = $(this);

        resetButtonHighlighting();

        btn.removeClass('btn-outline-primary').addClass('btn-primary');

        var slugArgomento = $('main').data('slug');
        var postType = btn.data('post-type');
        var container = $(this).parents('.container');
        var itemsPerPage = $(this).parents('.container').find('.card-pagination-row').data('posts-per-page');

        requestPageContent('load_card_page', container, 1, slugArgomento, postType, itemsPerPage);


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

function updateCardPagination(container, itemsPerPage, pageCurrent, pagesTotal, postType) {
    pagesTotal = Math.max(pagesTotal, 1);

    var startPage = Math.max(1, pageCurrent - Math.floor(itemsPerPage / 2));
    var endPage = Math.min(pagesTotal, startPage + itemsPerPage - 1);

    if (endPage - startPage + 1 < itemsPerPage && startPage > 1) {
        startPage = Math.max(1, endPage - itemsPerPage + 1);
    }

    var paginationRow = container.find('.card-pagination-row');


    if (pagesTotal > 1) {
        var content = [];
        paginationRow.empty();

        paginationRow.data('card-corrente', pageCurrent);
        paginationRow.data('card-totali', pagesTotal);
        paginationRow.data('post-type', postType); 
        paginationRow.data('posts-per-page', itemsPerPage);

        content.push(`<ul class="pagination justify-content-center card-pagination-ul">`);
        if (pageCurrent > 1) {
            content.push(`<li class="page-item prev-page-card">
                <a class="page-link" href="#" data-page="${pageCurrent - 1}" aria-label="Precedente">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`);
        }

        for (let i = startPage; i <= endPage; i++) {
            content.push(`<li class="page-item ${(i == pageCurrent) ? 'active' : ''} page-card-${i}">
                <a class="page-link ${(i == pageCurrent) ? 'border border-primary rounded' : ''}" href="#" data-page="${i}">
                    ${i}
                </a>
            </li>`);
        }

        if (pageCurrent < pagesTotal) {
            content.push(`<li class="page-item next-page-card">
                <a class="page-link" href="#" data-page="${pageCurrent + 1}" aria-label="Successivo">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`);
        }
        content.push(`</ul>`);
        paginationRow.html(content.join(''));

    } else {
        paginationRow.empty();
    }
    
}

function requestPageContent(action, container, page, slugArgomento, postType, itemsPerPage) {

    var cardWrapper = container.find('.card-wrapper');

    if (postType == 'evento') {
        cardWrapper.html(darkLoadingHtml);
    } else {
        cardWrapper.html(loadingHtml);
    }
    
    var data = {
        action: action,
        pagina_card: page,
        term: slugArgomento,
        post_type: postType,
        post_per_page: itemsPerPage

    };
    $.ajax({
        url: myAjax.ajaxurl,
        type: 'POST',
        data: data,
        success: function (response) {

            if (response.success) {
                cardWrapper.empty();

                if (postType == 'novita' || postType == 'evento') {
                    console.log('dentro');
                    var item = response.data;
                    console.log(response.data.data);
                    cardWrapper.html(response.data.data);
                } else {
                    console.log('fuori');
                    response.data.data.forEach(function (post) {

                        var cardHTML = createCardHTML(post);
                        cardWrapper.append(cardHTML);
                    });
                }

                pageCurrent = page;
                var pagesTotal = response.data.total_pages;
                updateCardPagination(container, itemsPerPage, page, pagesTotal, postType);
            } else {
                container.html('<p class="pt-5 d-flex justify-content-center w-100 text-center">Nessun risultato</p>');
            }
        }
    });
}


function resetButtonHighlighting() {
    $('.filters-list button').removeClass('btn-primary').addClass('btn-outline-primary');
}
