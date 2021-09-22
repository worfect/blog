//home main
$(document).ready(function () {
    $('.banner-home').slick({
        arrows: false,
        autoplay: true,
        autoplaySpeed: 8000,
        speed: 2500,
        pauseOnHover: false,
        pauseOnFocus: false,
        draggable: false,
    });

    $('.show-news').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.nav-news'
    });
    $('.nav-news').slick({
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.show-news',
        centerMode: true,
        focusOnSelect: true
    });
});

//search page
$(document).ready(function () {
    $('.search-gallery-result').slick({
        arrows: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    });
    $('.search-blog-result').slick({
        arrows: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    });
    $('.search-news-result').slick({
        arrows: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    });
});

$(document).ready(function () {
    $('.banner-profile').slick({
        arrows: false,
        autoplay: true,
        autoplaySpeed: 8000,
        speed: 2500,
        pauseOnHover: false,
        pauseOnFocus: false,
        draggable: false,
    });
});
