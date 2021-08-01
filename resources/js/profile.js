import $ from "jquery";
import Form from "./Form";

$(document).on( "submit", "#change-user-data-form", function(e){
    let url = window.location.pathname.replace('edit', '') + 'update'
    e.preventDefault();
    let form = new Form($(this), url);
    form.withRefresh(url+ '/refresh', '#edit-profile')
        .withNotice('.settings-profile')
        .submitForm();
});
