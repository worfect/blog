
import $ from 'jquery';
window.$ = window.jQuery = $;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all');
require('./Form');
require('./rating');
require('./filters');
require('./search');
require('./slick');
require('./gallery');
require('./menus');
require('./profile');

$('#notice-overlay-modal').modal();
$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
