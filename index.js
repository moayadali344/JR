const container = document.querySelector(".header-actions");

// 1. check sessionStorage FIRST
const cachedUser = sessionStorage.getItem("user");

if (cachedUser) {

  const user = JSON.parse(cachedUser);

  renderUser(user);

} else {

  // 2. only call API if NO cache
  fetch("/api/me.php", {
    credentials: "include"
  })
  .then(res => res.json())
  .then(data => {

    if (data.loggedIn) {

      const user = data.user;

      sessionStorage.setItem("user", JSON.stringify(user));

      renderUser(user);

    } else {

      sessionStorage.removeItem("user");

      container.innerHTML = `
        <a  href="./login.html" class="btn btn--secondary">Sign In</a>
        <a id="#signupp"href="./login.html?autosignup" class="btn btn--primary">Sign Up</a>
      `;

    }

  });

}

// 3. reusable renderer
function renderUser(user) {

  container.innerHTML = `
    <!-- My Purchases -->
    <a href="./usersdahboard.html" class="purchase-btn">
      <svg viewBox="0 0 24 24" class="icon">
        <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
        <path d="M7.2 14h9.6c.7 0 1.3-.4 1.6-1l2.2-7H6.2l-1-2H2v2h2l3.6 7.6-1.3 2.4c-.6 1 .1 2 1.3 2H19v-2H7.2l1-2z"/>
      </svg>
      <span>My Purchases</span>
    </a>

    <!-- Notification -->
    <div class="notif">
      <svg viewBox="0 0 24 24" class="icon">
        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2z"/>
        <path d="M18 16V11c0-3.1-1.6-5.6-4.5-6.3V4a1.5 1.5 0 0 0-3 0v.7C7.6 5.4 6 7.9 6 11v5l-2 2v1h16v-1l-2-2z"/>
      </svg>
      <span class="dot"></span>
    </div>

    <!-- Profile -->
    <div class="profile">
      <img class="avatar" src="${user.avatar}">
      <span class="username">${user.username}</span>

      <svg class="dropdown-icon" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5z"/>
      </svg>

      <div class="dropdown">
        <a href="#">My Profile</a>
        <a href="#">My Purchases</a>
        <a href="#">Settings</a>
<a href="#" id="logout-btn">Logout</a>
      </div>
    </div>
  `;

}