import $ from "jquery";
import Form from "./Form";

$("#change-user-data-form").bind("submit", function (e) {
    let id = $(location).attr("pathname").match(/\d+/);
    let formData = new FormData($(this).get(0));
    e.preventDefault();
    $.ajax({
        url: "/profile/" + id + "/update",
        method: "post",
        dataType: "html",
        processData: false,
        contentType: false,
        data: { formData },
    })
        .done(function (data) {
            $("#change-user-data-form").unbind("submit").submit();
        })
        .fail(function (data) {
            $(".container").append(JSON.parse(data.responseText));
            $(".confirm-modal").modal("show");
        });
});

$(document).on("submit", "#confirm-password-form-modal", function (e) {
    e.preventDefault();
    let form = new Form($(this), "/password/conform");
    form.submitForm().then((result) => {
        if (result) {
            $(".confirm-modal").modal("hide");
            $("#change-user-data-form").unbind("submit").submit();
        }
    });
});
