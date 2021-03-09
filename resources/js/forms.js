import $ from "jquery";

const notice = require('./vendor/notice/messages')

function cleaningInvalid(form){
    form.find('.invalid-feedback')
        .remove()

    form.find('.is-invalid')
        .removeClass('is-invalid')
}

function AjaxForm(url, form, location){
    ajaxPromise(url, form)
        .then((data) => {
            if (location){
                notice.showNoticeMessages(data, location)
            }
        })
        .catch((data) => {
            let errors = data.responseJSON.errors;

            $.each( errors, function( name, message ) {

                let span = document.createElement('span');
                let strong = document.createElement('strong');
                let field = $('[name = '+ name +']');

                strong.innerHTML = message;

                $(span).attr({"class":"invalid-feedback", "role":"alert"})
                    .html(strong);

                field.addClass("is-invalid")
                    .after(span);
            });
        })

}

function ajaxPromise(url, form){
    let formData = new FormData(form.get(0))

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            data: formData
        })
            .done(function(data){
                cleaningInvalid(form);
                resolve(data)
            })
            .fail(function(data){
                cleaningInvalid(form);
                reject(data)
            })
    })
}

$(document).on( "submit", "#store-gallery-item", function(e){
    e.preventDefault();

    AjaxForm('gallery', $(this), "#store-gallery-item")
});

