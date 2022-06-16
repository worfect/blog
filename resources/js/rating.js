import $ from "jquery";

$(document).on("submit", ".rating-panel", function (e) {
    e.preventDefault();
    let formData = new FormData($(this).get(0));
    formData.append(
        e.originalEvent.submitter.name,
        e.originalEvent.submitter.value
    );
    $.ajax({
        url: "/rating",
        method: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        data: formData,
    })
        .done(function (data) {
            if (data.attitude != null) {
                $(e.originalEvent.submitter).addClass("active");
            } else {
                $(e.originalEvent.target)
                    .find($("[name = attitude]"))
                    .removeClass("active");
            }
            $(e.originalEvent.target)
                .find($(".current-rating"))
                .empty()
                .append(data.rating);
        })
        .fail(function (data) {});
});
