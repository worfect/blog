import $ from "jquery";

function cleaningInvalid(form){
    form.find('.invalid-feedback')
        .remove();

    form.find('.is-invalid')
        .removeClass('is-invalid');
}

function addingContentViaAjaxForm(url, form) {

   let formData = new FormData(form.get(0));

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            cleaningInvalid(form);

        },
        error: function(data){
            cleaningInvalid(form);

            let errors = data.responseJSON.errors;

            $.each( errors, function( name, message ) {

                let span = document.createElement('span');
                let strong = document.createElement('strong');
                let field = $('[name = '+ name +']')

                strong.innerHTML = message;

                $(span).attr({"class":"invalid-feedback", "role":"alert"})
                    .html(strong);

                field.addClass("is-invalid")
                    .after(span);
            });
        }
    });
}


$(document).on( "submit", "#store-gallery-item", function(){
    addingContentViaAjaxForm('gallery', $(this));
    return false;
});

