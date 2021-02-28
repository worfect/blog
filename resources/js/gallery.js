import $ from "jquery";

function removeGalleryModal(){
    if($('.gallery-modal').length){
        $('.gallery-modal').remove();
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
            $(".container").append(data);
            $('.gallery-modal').modal('show');
        }
    });
}



$('.gallery-card').on("click", showGalleryItemModal);
$('.search-result').on("click", ".gallery-card", showGalleryItemModal);

$('.create-gallery-item').on("click", createGalleryItemModal);


