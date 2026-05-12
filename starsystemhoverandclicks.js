let selectedRating = 0;
const stars = document.querySelectorAll("#writeStars i");

// Initially disable stars for non-logged users
function initializeStars() {
    
    stars.forEach(star => {
    
        star.addEventListener("click", () => {
            selectedRating = parseInt(star.dataset.value);
            updateStars(selectedRating);
        });
    });
}

function updateStars(rating) {
    stars.forEach(star => {
        const value = parseInt(star.dataset.value);
        if (value <= rating) {
            star.classList.remove("fa-regular");
            star.classList.add("fa-solid", "active");
        } else {
            star.classList.remove("fa-solid", "active");
            star.classList.add("fa-regular");
        }
    });
}

// Initialize stars when page loads
initializeStars();