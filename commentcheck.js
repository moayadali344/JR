
// Match the exact structure from me.php
let currentUser = null;

function checkAuthAndSetupReviews() {
    // Check sessionStorage first (same as index.js)
    const cachedUser = sessionStorage.getItem("user");
    
    if (cachedUser) {
        currentUser = JSON.parse(cachedUser);
        enableReviewWriting();
    } else {
        // Check with API if no cache
        fetch("/api/me.php", {
            credentials: "include"
        })
        .then(res => res.json())
        .then(data => {
            // IMPORTANT: Your API returns { loggedIn: true/false, user: {...} }
            if (data.loggedIn === true && data.user) {
                currentUser = data.user;
                sessionStorage.setItem("user", JSON.stringify(currentUser));
                enableReviewWriting();
            } else {
                currentUser = null;
                sessionStorage.removeItem("user");
                disableReviewWriting();
            }
        })
        .catch(error => {
            console.error("Auth check failed:", error);
            disableReviewWriting();
        });
    }
}

function enableReviewWriting() {
    // Show the review writing section
    const reviewSection = document.querySelector(".reviews-section .reviews");
    if (reviewSection) {
        reviewSection.style.display = "block";
    }
    

    


}


// Run auth check when page loads
