$(document).ready(function () {
    const progressBar = document.querySelector(".progress");

    const swiper = new Swiper(".testimonials_swiper", {
        loop: true,
        grabCursor: true,
        speed: 900,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
      
    });

    progressBar.addEventListener("animationend", myEndFunction);

    // Retrigger Animation on Slide Change

    function myEndFunction() {
        swiper.slideNext();
        progressBar.style.animation = "none";
        void progressBar.offsetWidth; // Triggers Reflow
        progressBar.style.animation = null;
    }

    // Reset Progress Bar On Slide Change

    swiper.on("slideChange", function () {
        progressBar.style.animation = "none";
        void progressBar.offsetWidth; // Triggers Reflow
        progressBar.style.animation = null;
        progressBar.style.animationPlayState = "paused"; // Optional
    });

    // Pause Carousel/Progress Bar On Hover

    document.querySelectorAll(".swiper, .carousel-progress").forEach((item) => {
        item.addEventListener("mouseenter", function () {
            progressBar.style.animationPlayState = "paused";
        });
    });

    document.querySelectorAll(".swiper, .carousel-progress").forEach((item) => {
        item.addEventListener("mouseleave", function () {
            progressBar.style.animationPlayState = "running";
        });
    });
});
