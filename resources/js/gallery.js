import $ from "jquery";
import Form from "./Form.js";

const notice = require("./vendor/notice/messages");

function showGalleryItemModal() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    $.ajax({
        type: "GET",
        url: "/gallery/show",
        data: { id },
        dataType: "html",
        success: function (data) {
            $(".container").append(data);
            $(".gallery-modal").modal("show");
        },
    });
}

function createGalleryItemModal() {
    $.ajax({
        type: "GET",
        url: "/gallery/create",
        dataType: "html",
        success: function (data) {
            if (data.indexOf("notice-message") != -1) {
                notice.showNoticeHtml(data, "header");
            } else {
                $(".container").append(data);
                $(".gallery-modal").modal("show");
            }
        },
    });
}

function editGalleryItemModal() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    $(".close").click();

    $.ajax({
        type: "GET",
        url: "/gallery/edit",
        data: { id },
        dataType: "html",
        success: function (data) {
            if (data.indexOf("notice-message") != -1) {
                notice.showNoticeHtml(data, "header");
            } else {
                $(".container").append(data);
                $(".gallery-modal").modal("show");
            }
        },
    });
}

function deleteGalleryItem() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    $(".close").click();

    $.ajax({
        type: "GET",
        url: "/gallery/delete",
        data: { id },
        dataType: "html",
        success: function (data) {
            if (data.indexOf("notice-message") != -1) {
                notice.showNoticeHtml(data, "header");
            } else {
                $("div #gallery-card-" + id)
                    .addClass("gallery-card-deleted")
                    .removeClass("gallery-card");
                $("#gallery-card-" + id + " .card-text-deleted").show();
                $("#gallery-card-" + id + " .icon-deleted").show();
                $("#gallery-card-" + id + " .card-text").hide();
                $("#gallery-card-" + id + " .icon").hide();
            }
        },
    });
}

function restoreGalleryItem() {
    let id = $(this).prop("id");
    id = parseInt(id.match(/\d+/));

    $.ajax({
        type: "GET",
        url: "/gallery/restore",
        data: { id },
        dataType: "html",
        success: function (data) {
            if (data.indexOf("notice-message") != -1) {
                notice.showNoticeHtml(data, "header");
            } else {
                $("div #gallery-card-" + id)
                    .removeClass("gallery-card-deleted")
                    .addClass("gallery-card");
                $("#gallery-card-" + id + " .card-text-deleted").hide();
                $("#gallery-card-" + id + " .icon-deleted").hide();
                $("#gallery-card-" + id + " .card-text").show();
                $("#gallery-card-" + id + " .icon").show();
            }
        },
    });
}

$(document).on("submit", "#store-gallery-item", function (e) {
    e.preventDefault();
    let form = new Form($(this), "/gallery");
    form.withNotice(".edit-gallery-item")
        .withRefresh("/gallery/refresh", ".content-gallery")
        .submitForm();
});

$(document).on("submit", "#update-gallery-item", function (e) {
    e.preventDefault();
    let form = new Form($(this), "/gallery/update");
    form.withNotice(".edit-gallery-item")
        .withRefresh("/gallery/refresh", ".content-gallery")
        .submitForm();
});

$(document).on("submit", ".add-gallery-comment-form", function (e) {
    e.preventDefault();
    let form = new Form($(this), "/comment");
    form.withNotice(".add-gallery-comment")
        .withRefresh("/comment/refresh", ".show-gallery-comments")
        .submitForm();
});

$(document).on("click", ".gallery-card-search-result", showGalleryItemModal);
$(document).on("click", ".create-gallery-item", createGalleryItemModal);
$(document).on("click", ".gallery-card", showGalleryItemModal);
$(document).on("click", ".gallery-edit-btn", editGalleryItemModal);
$(document).on("click", ".gallery-delete-btn", deleteGalleryItem);
$(document).on("click", ".gallery-card-deleted", restoreGalleryItem);

//когда-то почему-то решил, что лишние модалы должны удаляться и работать без указания id. Повернуть назад теперь не могу. Сделать нормально - тоже...
function removeModal() {
    $(".modal").modal("hide");
    $(".gallery-modal").remove();
    $(".modal-backdrop").remove();
    $("body").removeClass("modal-open");
}

$(document).on("click", "button.close", removeModal);
$(document).on("click", function (e) {
    if (!$(e.target).closest(".modal-dialog").length) {
        removeModal();
    }
});
