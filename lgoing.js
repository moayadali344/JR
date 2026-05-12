const errorEl = document.getElementById("loginError");
errorEl.style.color = "#ff4d4f";
errorEl.style.fontSize = "13px";
errorEl.style.marginTop = "8px";
errorEl.style.display = "block";
errorEl.style.marginBottom = "8px";

const cachedUser = sessionStorage.getItem("user");
if (cachedUser) {
  // already logged in → redirect
  window.location.href = "./index.html";
}

const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const userInput = document.getElementById("loginUser");
  const passInput = document.getElementById("loginPassword");

  const user = userInput.value.trim();
  const password = passInput.value.trim();

  // 🔍 VALIDATION
  if (!user) {
    userInput.focus();
errorEl.textContent = "enter email or user name";
    return;
  }

  if (!password) {
    passInput.focus();
errorEl.textContent = "please enter a password";
    return;
  }

  if (password.length < 6) {
errorEl.textContent = "password must be at least 8 char";
    return;
  }

  // 🔒 Disable button to prevent double submit
  const btn = loginForm.querySelector(".login-btn");
  btn.disabled = true;
  btn.textContent = "Logging in...";

  // 🚀 SEND REQUEST
  fetch("/api/login.php", {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `user=${encodeURIComponent(user)}&password=${encodeURIComponent(password)}`
  })
  .then(res => res.json())
  .then(data => {

    if (data.status !== "success") {

// show error
errorEl.textContent = data.message;

// style it with JS



      btn.disabled = false;
      btn.textContent = "Log In";
      return;
    }

    // ✅ SAVE USER (IMPORTANT)
    sessionStorage.setItem("user", JSON.stringify(data.user));

    // 🔄 REDIRECT
    window.location.href = "./index.html";

  })
  .catch((e) => {
    alert("Network error");
    btn.disabled = false;
    btn.textContent = "Log In";
  });

});