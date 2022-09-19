$.getJSON(`/api/faq/`, function (
    data) {
    var resources = data.faq
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

    $(".faq-list").html(resources);
});