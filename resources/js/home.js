import Swiper from "swiper/bundle";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", function () {
    // Swiper for categories
    new Swiper(".categories-swiper", {
        slidesPerView: 2,
        spaceBetween: 15,
        navigation: {
            nextEl: ".categories-swiper-next",
            prevEl: ".categories-swiper-prev",
        },
        mousewheel: true,
        keyboard: true,
        grabCursor: true,
        breakpoints: {
            640: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 6 },
        },
    });
});
