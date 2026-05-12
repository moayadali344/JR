const profilePic = document.querySelector("#profile-pic-dashboard");
const usernameEl = document.querySelector("#username");
const memberSinceEl = document.querySelector(".member-since");

const purchasesContainer = document.querySelector("#purchasesContainer");

loadDashboard();

async function loadDashboard() {

  const res = await fetch("./api/me.php", {
    credentials: "include"
  });

  const data = await res.json();

  if (!data.loggedIn) {
    window.location.href = "./login.html";
    return;
  }

  renderDashboard(data.user);

  loadRequests();
}

function renderDashboard(user) {

  if (profilePic) {
    profilePic.src = user.avatar;
  }

  if (usernameEl) {
    usernameEl.textContent = user.username;
  }

  if (memberSinceEl) {

    const date = new Date(user.created_at);

    memberSinceEl.textContent =
      "Member since " + date.getFullYear();
  }
}

async function loadRequests() {

  const res = await fetch("./api/getUserRequests.php", {
    credentials: "include"
  });

  const data = await res.json();

  if (!data.success) return;

  purchasesContainer.innerHTML = "";

  data.requests.forEach(request => {

    const statusClass =
      request.request_status === "success"
        ? "success"
        : "pending";

    const statusText =
      request.request_status === "success"
        ? "Success"
        : "Pending";

    const buttonText =
      request.request_status === "success"
        ? "Show Credentials"
        : "Processing...";

    const disabled =
      request.request_status === "success"
        ? ""
        : "disabled";

    purchasesContainer.innerHTML += `
    
    <div class="purchase-card">

      <div class="icon-box">
        <img src="${request.product_image}" alt="">
        <span>${request.product_name_en}</span>
      </div>

      <div class="purchase-actions">

        <div class="purchase-meta">
          <span class="date">
            ${formatDate(request.created_at)}
          </span>

          <span class="price">
            $${request.total_price}
          </span>
        </div>
<button 
  class="credentials-btn"
  ${disabled}
  data-result="${request.request_result || ''}"
>
  ${buttonText}
</button>

        <span class="status ${statusClass}">
          ${statusText}
        </span>

      </div>

    </div>

    `;
  });

  const credentialButtons =
  document.querySelectorAll(".credentials-btn");

credentialButtons.forEach(button => {

  button.addEventListener("click", () => {

    const result = button.dataset.result;

    if (!result) {
      alert("No credentials yet");
      return;
    }

Swal.fire({
  title: "Account Credentials",
  html: `
  
    <div class="credentials-popup">
      <pre>${result}</pre>
    </div>

  `,
    icon: "success",
  background: "#1b1d22",
  color: "#fff",
  confirmButtonColor: "#70a1ff",
  confirmButtonText: "Close",
  width: "600px"
});  });

});
}

function formatDate(dateString) {

  const date = new Date(dateString);

  return date.toLocaleDateString("en-GB", {
    day: "2-digit",
    month: "short",
    year: "numeric"
  });
}