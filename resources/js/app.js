import $ from "jquery";
import "datatables.net";
window.$ = window.jQuery = $;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

require("bootstrap/js/dist/dropdown.js");
require("bootstrap/js/dist/collapse.js");
require("bootstrap/js/dist/modal.js");
require("@fortawesome/fontawesome-free/js/all");
require("./Form");
require("./rating");
require("./filters");
require("./search");
require("./slick");
require("./gallery");
require("./menus");
require("./profile");
require("./admin");

$("#notice-overlay-modal").modal();
$("div.alert").not(".alert-important").delay(3000).fadeOut(350);
