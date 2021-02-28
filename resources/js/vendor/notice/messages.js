function showHtml(data){
    $('.notice-messages').remove();
    $('.btn-notice').after(data)
    $('#notice-overlay-modal').modal('show')
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    $(".notice-message").wrapAll("<div class='notice-messages'></div>");
}

function showMessages(data){
    $('.notice-messages').remove();
    $.each(data, function(k, message){
        if(message.overlay){
            $('.btn-notice').after(doModal(message))
            $('#notice-overlay-modal').modal('show')
        } else{
            $('.btn-notice').after(doMessage(message))
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        }
    });
    $(".notice-message").wrapAll("<div class='notice-messages'></div>");
}

function doModal(message){
    let html = '<div id="notice-overlay-modal" class="notice-message modal">';
    html += '<div class="modal-dialog">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    html += '<h4 class="modal-title">'+message.title+'</h4>';
    html += '</div>';
    html += '<div class="modal-body"> ';
    html += '<div class="alert alert-'+message.level+'"  role="alert">';
    html +=  message.message;
    html += '</div>';
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    return html;
}


function doMessage(message){
    let important = '';
    if (message.important){
        important = 'alert-important';
    }
    let html = '<div class="notice-message alert alert-'+message.level+' '+important+'"  role="alert">';
    if(message.important){
        html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    }
    html += message.message;
    html += '</div>';
    return html;
}
