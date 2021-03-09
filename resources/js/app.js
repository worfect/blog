
import $ from 'jquery';
window.$ = window.jQuery = $;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all');
require('./filters');
require('./search');
require('./slick');
require('./gallery');
require('./menus')
require('./forms')

$('#notice-overlay-modal').modal();
