$.getJSON(`/api/pap`, function (data) {
    var resources = data
        .sort((a, b) => a.pap_id - b.pap_id)
        .map(({
            pap_id,
            value
        }) => {
            return (`
            <H3>${pap_id}. ${value.split("?")[0]}?</H3>
                <p>${value.split("?")[1]}</p>
            `);
        });

    $(".data").html(resources);
});