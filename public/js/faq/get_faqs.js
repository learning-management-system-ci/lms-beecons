$.getJSON(`/api/faq`, function (data) {
    var resources = data
        .sort((a, b) => a.faq_id - b.faq_id)
        .map(({
            faq_id,
            question,
            answer
        }) => {
            return (`<div class="faq-item">
                    <div class="faq-title d-flex justify-content-between align-items-center">
                        <h4>0${faq_id}. ${question}</h3>
                            <a class="expand d-flex justify-content-center align-items-center" data-bs-toggle="collapse"
                                href="#faq${faq_id}" role="button" aria-expanded="false" aria-controls="collapseExample"
                                id="button12">
                            </a>
                    </div>
                    <div class="faq-content collapse" id="faq${faq_id}">
                        <div class="card-body ml-5">
                        ${answer}.
                        </div>
                    </div>
                    <hr>
                </div>`);
        });

    $("div.faq-list").html(resources);

    var expand_faq = ".faq-title > a";
    $(expand_faq).on('click', function () {
        var color = $(this).css('background-image');
        if (color.includes("expand")) {
            $(this).css({
                'backgroundImage': "url('../../image/faq/close.png')",
                'transform': "scale(0.8) rotate(180deg)",
            })
        }
        else {
            $(this).css({
                'backgroundImage': "url('../../image/faq/expand.png')",
                'transform': "scale(0.8) rotate(0deg)",
            })
        }
    })

});