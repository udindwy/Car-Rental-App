import "./bootstrap";
import "aos/dist/aos.css";
import AOS from "aos";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

AOS.init({
    duration: 800,
    once: true,
});

// resources/js/app.js

import Swiper from "swiper";
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/pagination";

// Inisialisasi Swiper setelah halaman siap
document.addEventListener("DOMContentLoaded", function () {
    // Cek apakah elemen slider ada di halaman saat ini
    if (document.querySelector(".testimonial-slider")) {
        const swiper = new Swiper(".testimonial-slider", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 200,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: { slidesPerView: 1, spaceBetween: 20 },
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 3, spaceBetween: 40 },
            },
        });
    }
});
