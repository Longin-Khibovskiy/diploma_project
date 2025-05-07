var swiperRight = new Swiper(".swiper_right", {
    grabCursor: true,
    speed: 800,
    mousewheel: {
        invert: false,
    },
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true,
    },
    slidesPerView: 1,
    spaceBetween: 10,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false
    },
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
    direction: 'horizontal',
    initialSlide: document.querySelectorAll('.swiper_left .swiper-slide').length - 1, // Старт с последнего слайда
    loop: true,
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true,
    },
    autoplay: {
        delay: 3000,
        reverseDirection: true,
        disableOnInteraction: false
    },
    grabCursor: true,
    speed: 800,
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