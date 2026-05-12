const reviewsContainer =
  document.querySelector("#reviewsContainer");

const userCommentSection =
  document.querySelector("#usercommenthere");

 selectedRating = 0;

init();

async function init() {

  await renderCommentSection();

  loadReviews();

}

async function renderCommentSection() {

  let user = JSON.parse(
    localStorage.getItem("user")
  );

  // fallback api
  if (!user) {

    const res = await fetch("./api/me.php", {
      credentials: "include"
    });

    const data = await res.json();

    if (data.loggedIn) {

      user = data.user;

      localStorage.setItem(
        "user",
        JSON.stringify(user)
      );
    }
  }

  // logged in
  if (user) {

    userCommentSection.innerHTML = `
    
      <div class="review-user">

        <img
          src="${user.avatar || './images/user.png'}"
          alt="Profile">

        <div>

          <h4>
            ${user.username}
          </h4>

          <span class="review-date">
            Share your experience
          </span>

        </div>

      </div>

      <div class="review-stars" id="writeStars">

        <i class="fa-regular fa-star" data-value="1"></i>
        <i class="fa-regular fa-star" data-value="2"></i>
        <i class="fa-regular fa-star" data-value="3"></i>
        <i class="fa-regular fa-star" data-value="4"></i>
        <i class="fa-regular fa-star" data-value="5"></i>

      </div>

      <input
        class="review-input"
        type="text"
        placeholder="Write your review...">

      <button
        id="submitReviewBtn">

        Submit

      </button>
    `;

    initStars();

    document
      .querySelector("#submitReviewBtn")
      .addEventListener(
        "click",
        submitReview
      );

  }

  // guest
  else {

    userCommentSection.innerHTML = `
    
      <button
        class="login-review-btn"
        id="loginToReviewBtn">

        Login or Sign Up to Review

      </button>

    `;

    document
      .querySelector("#loginToReviewBtn")
      .addEventListener(
        "click",
        pleaseloginorsignup
      );
  }
}

function initStars() {

  const stars =
    document.querySelectorAll(
      "#writeStars i"
    );

  stars.forEach(star => {

    star.addEventListener("click", () => {

      selectedRating =
        parseInt(star.dataset.value);

      updateStars(selectedRating);

    });

  });
}

function updateStars(rating) {

  const stars =
    document.querySelectorAll(
      "#writeStars i"
    );

  stars.forEach(star => {

    const value =
      parseInt(star.dataset.value);

    if (value <= rating) {

      star.classList.remove("fa-regular");
      star.classList.add("fa-solid", "active");

    } else {

      star.classList.remove(
        "fa-solid",
        "active"
      );

      star.classList.add("fa-regular");
    }
  });
}

async function submitReview() {

  const reviewInput =
    document.querySelector(".review-input");

  if (!selectedRating) {

    Swal.fire({
      icon: "warning",
      title: "Select Rating",
      text: "Please choose a star rating first.",
      background: "#1b1d22",
      color: "#fff"
    });

    return;
  }

  const comment =
    reviewInput.value.trim();

  const formData = new FormData();

  formData.append(
    "product_id",
    getProductId()
  );

  formData.append(
    "rating",
    selectedRating
  );

  formData.append(
    "comment",
    comment
  );

  const res = await fetch(
    "./api/createReview.php",
    {
      method: "POST",
      body: formData,
      credentials: "include"
    }
  );

  const data = await res.json();

  if (!data.success) {

    Swal.fire({
      icon: "error",
      title: "Review Failed",
      text: data.message,
      background: "#1b1d22",
      color: "#fff"
    });

    return;
  }

  Swal.fire({
    icon: "success",
    title: "Review Added",
    text: "Thank you for your feedback.",
    background: "#1b1d22",
    color: "#fff",
    timer: 1500,
    showConfirmButton: false
  });

  reviewInput.value = "";

  selectedRating = 0;

  updateStars(0);

  loadReviews();
}

async function loadReviews() {

  const res = await fetch(
    `./api/getReviews.php?product_id=${getProductId()}`
  );

  const data = await res.json()

  if (!data.success) return;

  renderReviews(data.reviews);
}

function renderReviews(reviews) {

  reviewsContainer.innerHTML = "";

  if (reviews.length === 0) {

    reviewsContainer.innerHTML = `
    
      <p class="no-reviews">
        No reviews yet
      </p>

      <hr class="custom-hr">
    
    `;

    return;
  }

  reviews.forEach(review => {

    let starsHTML = "";

    for (let i = 1; i <= 5; i++) {

      starsHTML += `
      
        <i class="fa-solid fa-star ${
          i <= review.rating
            ? "active"
            : ""
        }"></i>
      
      `;
    }

    reviewsContainer.innerHTML += `
    
      <div class="review-card">

        <div class="review-top">

          <div class="review-user">

            <img
              src="${
                review.profile_pic ||
                './images/user.png'
              }">

            <div>

              <h4>
                ${review.username}
              </h4>

              <div class="review-stars">
                ${starsHTML}
              </div>

            </div>

          </div>

          <span class="review-date">
            ${review.created_at}
          </span>

        </div>

        <p class="review-comment">
          ${review.comment}
        </p>

      </div>

      <hr class="custom-hr">
    
    `;
  });
}

function pleaseloginorsignup() {

  Swal.fire({
    icon: "info",
    title: "Join The Conversation",
    text:
      "Please login or create an account to rate and review this product.",
    background: "#1b1d22",
    color: "#fff",
    confirmButtonText: "Login",
    confirmButtonColor: "#70a1ff",
    showCancelButton: true,
    cancelButtonText: "Sign Up",
    cancelButtonColor: "#ff4757"
  }).then((result) => {

    if (result.isConfirmed) {

      window.location.href =
        "./login.html";

    }

    else if (
      result.dismiss ===
      Swal.DismissReason.cancel
    ) {

      window.location.href =
        "./login.html?autosignup";
    }
  });
}