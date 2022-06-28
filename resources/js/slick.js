import $ from "jquery";
window.$ = window.jQuery = $;
import "slick-carousel";

//home main
$(document).ready(function () {
    $(".banner-home").slick({
        arrows: false,
        autoplay: true,
        autoplaySpeed: 8000,
        speed: 2500,
        pauseOnHover: false,
        pauseOnFocus: false,
        draggable: false,
    });

    $(".show-news").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: ".nav-news",
    });
    $(".nav-news").slick({
        nextArrow:
            '<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""></button>',
        prevArrow:
            '<button class="slick-prev slick-arrow" aria-label="Prev" type="button" style=""></button>',
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: ".show-news",
        centerMode: true,
        focusOnSelect: true,
    });
});

//search page
$(document).ready(function () {
    $(".search-gallery-result").slick({
        nextArrow:
            '<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""></button>',
        prevArrow:
            '<button class="slick-prev slick-arrow" aria-label="Prev" type="button" style=""></button>',
        arrows: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    });
    $(".search-blog-result").slick({
        nextArrow:
            '<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""></button>',
        prevArrow:
            '<button class="slick-prev slick-arrow" aria-label="Prev" type="button" style=""></button>',
        arrows: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    });
    $(".search-news-result").slick({
        nextArrow:
            '<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""></button>',
        prevArrow:
            '<button class="slick-prev slick-arrow" aria-label="Prev" type="button" style=""></button>',
        arrows: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    });
});

$(document).ready(function () {
    $(".banner-profile").slick({
        arrows: false,
        autoplay: true,
        autoplaySpeed: 8000,
        speed: 2500,
        pauseOnHover: false,
        pauseOnFocus: false,
        draggable: false,
    });
});
