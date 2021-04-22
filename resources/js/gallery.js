import $ from "jquery";

import Form from './Form.js';

const notice = require('./vendor/notice/messages');

function removeGalleryModal(){
    if($('.gallery-modal').length){
        $('.gallery-modal').remove();
        $('.modal-backdrop').remove();
    }
}

function showGalleryItemModal() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    removeGalleryModal();

    $.ajax({
        type: "GET",
        url: "gallery/show",
        data: {id},
        dataType: "html",
        success: function(data) {
            $(".container").append(data);
            $('.gallery-modal').modal('show');
        }
    });
}

function createGalleryItemModal() {
    removeGalleryModal();
    $.ajax({
        type: "GET",
        url: "gallery/create",
        dataType: "html",
        success: function(data) {
            if(data.indexOf('notice-message') != -1){
                notice.showNoticeHtml(data, 'header')
            }else{
                $(".container").append(data);
                $('.gallery-modal').modal('show');
            }
        }
    });
}

function editGalleryItemModal() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    removeGalleryModal();
    $.ajax({
        type: "GET",
        url: "gallery/edit",
        data: {id},
        dataType: "html",
        success: function(data) {
            if(data.indexOf('notice-message') != -1){
                notice.showNoticeHtml(data, 'header')
            }else{
                $(".container").append(data);
                $('.gallery-modal').modal('show');
            }
        }
    });
}

function deleteGalleryItem() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    removeGalleryModal();
    $.ajax({
        type: "GET",
        url: "gallery/delete",
        data: {id},
        dataType: "html",
        success: function(data) {
            if (data.indexOf('notice-message') != -1) {
                notice.showNoticeHtml(data, 'header')
            }else{
                $('#gallery-card-' + id).addClass("gallery-card-deleted");
                $('#gallery-card-' + id + ' .card-text-deleted').show();
                $('#gallery-card-' + id + ' .icon-deleted').show();
                $('#gallery-card-' + id + ' .card-text').hide();
                $('#gallery-card-' + id + ' .icon').hide();
            }
        }
    });
}

function restoreGalleryItem() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    $.ajax({
        type: "GET",
        url: "gallery/restore",
        data: {id},
        dataType: "html",
        success: function(data) {
            if (data.indexOf('notice-message') != -1) {
                notice.showNoticeHtml(data, 'header')
            }else{
                $('#gallery-card-' + id).removeClass("gallery-card-deleted");
                $('#gallery-card-' + id + ' .card-text-deleted').hide();
                $('#gallery-card-' + id + ' .icon-deleted').hide();
                $('#gallery-card-' + id + ' .card-text').show();
                $('#gallery-card-' + id + ' .icon').show();
            }
        }
    });
}

$(document).on( "submit", "#store-gallery-item", function(e){
    e.preventDefault();
    let form = new Form($(this), 'gallery');
    form.withNotice('.edit-gallery-item')
        .withRefresh('.content-gallery')
        .submitForm();
});

$(document).on( "submit", "#update-gallery-item", function(e){
    e.preventDefault();
    let form = new Form($(this), 'gallery/update');
    form.withNotice('.edit-gallery-item')
        .submitForm();
});

$(document).on( "submit", ".add-gallery-comment-form", function(e){
    e.preventDefault();
    let form = new Form($(this), 'comment');
    form.withNotice('.add-gallery-comment')
        .withRefresh('.show-gallery-comments')
        .submitForm();
});


$(document).on("click", ".gallery-card-search-result", showGalleryItemModal);
$(document).on("click", ".create-gallery-item", createGalleryItemModal);
$(document).on("click", ".gallery-card", showGalleryItemModal);
$(document).on("click", ".gallery-edit-btn", editGalleryItemModal);
$(document).on("click", ".gallery-delete-btn", deleteGalleryItem);
$(document).on("click", '.gallery-card-deleted', restoreGalleryItem);

