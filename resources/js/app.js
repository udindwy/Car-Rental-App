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
