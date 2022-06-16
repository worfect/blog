//quick search
$(document).mousedown(function (e) {
    if (
        jQuery(e.target).closest(".quick-search-form").length ||
        jQuery(e.target).closest(".modal").length
    )
        return;
    $(".quick-search-form").find(".search-result").css("display", "none");
});

$(".quick-search-form").ready(function () {
    let section = $(".quick-search-form .section").val();
    let result = $(".quick-search-form .search-result");

    $(".quick-search-form").focusin(function () {
        result.css("display", "flex");
    });
    $(this)
        .find(".search-query")
        .keyup(function () {
            let query = $(this).val();
            result.empty();
            if (query.length >= 2) {
                $.ajax({
                    type: "GET",
                    url: "qsearch",
                    data: { query, section },
                    dataType: "JSON",
                    success: function (data) {
                        result.empty();
                        $.each(data, function (k, v) {
                            let div = document.createElement("DIV");
                            $(div).attr({
                                class: "search-result-item gallery-card-search-result",
                                id: "gallery-card-" + v.id,
                            });
                            div.innerHTML = v.title;
                            $(div).appendTo(result);
                            result.css("display", "flex");
                        });
                    },
                });
            }
        });
});
