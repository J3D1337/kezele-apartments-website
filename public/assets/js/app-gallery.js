// Gallery functionality
let currentSlide = 0;
const slides = document.querySelectorAll(".gallery-slide");
const thumbnails = document.querySelectorAll(".thumbnail");
const dots = document.querySelectorAll(".absolute.bottom-4 span");

function showSlide(index) {
    // Hide all slides
    slides.forEach((slide) => slide.classList.remove("active"));
    thumbnails.forEach((thumb) => thumb.classList.remove("active"));
    dots.forEach((dot) => dot.classList.remove("!opacity-100"));

    // Show current slide
    if (slides[index]) {
        slides[index].classList.add("active");
        thumbnails[index].classList.add("active");
        dots[index].classList.add("!opacity-100");
        currentSlide = index;
    }
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
    resetInterval();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
    resetInterval();
}

function goToSlide(index) {
    currentSlide = index;
    showSlide(currentSlide);
    resetInterval();
}

// Modal gallery functionality
function openModal(index) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("fullImage");
    const loader = document.getElementById("modalLoader");
    const slideCounter = document.getElementById("slideCounter");

    currentSlide = index;
    loader.style.display = "block";
    modalImg.style.display = "none";
    modalImg.src = slides[index].querySelector("img").src;
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";
    slideCounter.textContent = `${index + 1} / ${slides.length}`;
}

function hideLoader() {
    const loader = document.getElementById("modalLoader");
    const modalImg = document.getElementById("fullImage");
    loader.style.display = "none";
    modalImg.style.display = "block";
}

function closeModal() {
    document.getElementById("imageModal").style.display = "none";
    document.body.style.overflow = "auto";
}

function modalNextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    const modalImg = document.getElementById("fullImage");
    const loader = document.getElementById("modalLoader");
    const slideCounter = document.getElementById("slideCounter");

    loader.style.display = "block";
    modalImg.style.display = "none";
    modalImg.src = slides[currentSlide].querySelector("img").src;
    slideCounter.textContent = `${currentSlide + 1} / ${slides.length}`;
}

function modalPrevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    const modalImg = document.getElementById("fullImage");
    const loader = document.getElementById("modalLoader");
    const slideCounter = document.getElementById("slideCounter");

    loader.style.display = "block";
    modalImg.style.display = "none";
    modalImg.src = slides[currentSlide].querySelector("img").src;
    slideCounter.textContent = `${currentSlide + 1} / ${slides.length}`;
}

// Auto-advance slides
let slideInterval = setInterval(nextSlide, 5000);

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
}

// Pause on hover
const gallery = document.querySelector(".gallery-wrapper");
gallery.addEventListener("mouseenter", () => clearInterval(slideInterval));
gallery.addEventListener("mouseleave", resetInterval);

// Mobile menu toggle
function openMobileMenu() {
    document.getElementById("mobileMenu").style.width = "100%";
}

function closeMobileMenu() {
    document.getElementById("mobileMenu").style.width = "0";
}

function toggleMobileLanguageDropdown() {
    const options = document.getElementById("mobileLanguageOptions");
    const btn = document.querySelector(".mobile-language-btn");

    btn.classList.toggle("active");
    options.classList.toggle("active");
}

// Keyboard navigation for gallery
document.addEventListener("keydown", (e) => {
    const modal = document.getElementById("imageModal");
    if (modal.style.display === "flex") {
        if (e.key === "ArrowRight") {
            modalNextSlide();
        } else if (e.key === "ArrowLeft") {
            modalPrevSlide();
        } else if (e.key === "Escape") {
            closeModal();
        }
    } else {
        if (e.key === "ArrowRight") {
            nextSlide();
            resetInterval();
        } else if (e.key === "ArrowLeft") {
            prevSlide();
            resetInterval();
        }
    }
});

// Click outside modal to close
document.getElementById("imageModal").addEventListener("click", function (e) {
    if (e.target === this) {
        closeModal();
    }
});

// Swipe gestures for mobile
let touchStartX = 0;
let touchEndX = 0;

document.getElementById("fullImage").addEventListener(
    "touchstart",
    (e) => {
        touchStartX = e.changedTouches[0].screenX;
    },
    false
);

document.getElementById("fullImage").addEventListener(
    "touchend",
    (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    },
    false
);

function handleSwipe() {
    if (touchEndX < touchStartX - 50) {
        modalNextSlide(); // Swipe left
    }
    if (touchEndX > touchStartX + 50) {
        modalPrevSlide(); // Swipe right
    }
}
