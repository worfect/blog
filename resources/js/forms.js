import $ from "jquery";

const notice = require('./vendor/notice/messages')

function cleaningInvalid(form){
    form.find('.invalid-feedback')
        .remove()

    form.find('.is-invalid')
        .removeClass('is-invalid')
}

function ajaxForm(url, form, location){
    return new Promise((resolve, reject) => {
        ajaxPromise(url, form)
            .then((data) => {
                if (location){
                    console.log('notice');
                    notice.showNoticeMessages(data, location);
                    console.log(location);
                    console.log(data);
                    resolve();
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
                resolve(data);
            })
            .fail(function(data){
                cleaningInvalid(form);
                reject(data);
            })
    })
}

function refreshContent(url, form, location){
    let formData = new FormData(form.get(0))

    ajaxForm('comment/store', form, ".add-gallery-comment-form")
        .then((data) => {
        $.ajax({
            url: url + "/refresh",
            method: 'POST',
            dataType: 'HTML',
            processData: false,
            contentType: false,
            data: formData
        })
            .done(function(data){
                $(location).empty();
                $(location).append(data);
            })
            .fail(function(data){

            })
        }
    )
}

function sendGalleryComment(form){
    refreshContent('comment', form, '.show-gallery-comments');
}




$(document).on( "submit", "#store-gallery-item", function(e){
    e.preventDefault();
    ajaxForm('gallery', $(this), ".edit-gallery-item");
});

$(document).on( "submit", "#update-gallery-item", function(e){
    e.preventDefault();
    ajaxForm('gallery/update', $(this), ".edit-gallery-item");
});

$(document).on( "submit", ".add-gallery-comment-form", function(e){
    e.preventDefault();
    sendGalleryComment($(this))
});
