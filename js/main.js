var swiperRight = new Swiper(".swiper_right", {
    grabCursor: true,
    speed: 800,
    mousewheel: {
        invert: false,
    },
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
        900: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1200: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
    },
});

var swiperLeft = new Swiper(".swiper_left", {
    grabCursor: true,
    initialSlide: document.querySelectorAll('.swiper-slide').length - 1,
    speed: 800,
    mousewheel: {
        invert: true,
    },
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
        900: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1200: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
    },
});