const sliderMain = new Swiper(".slider_main", {
    // freeMode: true,
    // centeredSlides: true,
    // mousewheel: true,
    parallax: true,
    loop: true,
    loopAdditionalSlides: 0,
    breakpoints: {
        0: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        680: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    },
    slidesPerGroup: 4,
    speed: 1100,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

console.log('mm');