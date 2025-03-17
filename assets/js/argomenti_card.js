function createCardHTML(post) {
    var imgHTML = post.img ? `<div class="card-image card-image-rounded pb-5"><img src="${post.img}" alt="${post.title}" class="img-fluid rounded"></div>` : '';

    var cardHTML = `
        <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
            <div class="card-image-wrapper with-read-more">
                <div class="content aling-top">
                    <div class="card-header border-0 pb-1">
                        ${post.head}
                    </div>
                    <div class="card-body ps-3 pb-3">
                        <h4 class="card-title text-paragraph-medium u-grey-light">
                            <a class="text-decoration-none" href="${post.link}">${post.title}</a>
                        </h4>
                        <p class="text-paragraph-card u-grey-light m-0">${post.desc}</p>
                    </div>
                </div>
                ${imgHTML}
            </div>
        </div>
    `;
    return cardHTML;
}