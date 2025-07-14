// FADE IN ANIMATION

document.addEventListener("DOMContentLoaded", function () {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    const fadeElements = document.querySelectorAll(".fade-in-bottom");
    fadeElements.forEach((el) => observer.observe(el));
});

// IMAGE

function confirmDeletion(event) {
    if (!confirm("Are you sure you want to delete this image?")) {
        event.preventDefault(); // Stop the form from submitting
    }
}

function openFullscreenModal(imageUrl) {
    const modal = document.getElementById("fullscreenModal");
    const modalImage = document.getElementById("modalImage");
    modalImage.src = imageUrl; // Set the image source
    modal.style.display = "block"; // Show the modal
}

function closeFullscreenModal() {
    const modal = document.getElementById("fullscreenModal");
    modal.style.display = "none"; // Hide the modal
}

window.onclick = function (event) {
    const modal = document.getElementById("fullscreenModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

// Mobile menu functions
function openMobileMenu() {
    document.getElementById("mobileMenu").style.width = "100%";
}

function closeMobileMenu() {
    document.getElementById("mobileMenu").style.width = "0%";
}

// Close mobile menu when clicking on a link
document.querySelectorAll(".mobile-menu-link").forEach((link) => {
    link.addEventListener("click", closeMobileMenu);
});

// Mobile language dropdown functions
function toggleMobileLanguageDropdown() {
    const dropdown = document.getElementById("mobileLanguageOptions");
    const btn = document.querySelector(".mobile-language-btn");

    dropdown.classList.toggle("active");
    btn.classList.toggle("active");
}

// Close dropdown when clicking outside
document.addEventListener("click", function (event) {
    const languageSelector = document.querySelector(
        ".mobile-language-dropdown"
    );
    if (!languageSelector.contains(event.target)) {
        document
            .getElementById("mobileLanguageOptions")
            .classList.remove("active");
        document
            .querySelector(".mobile-language-btn")
            .classList.remove("active");
    }
});
