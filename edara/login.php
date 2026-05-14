<?php
// If already logged in, skip to dashboard
session_start();
if ($_SESSION['admin'] === true) {
    header('Location: ./yo.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Edara</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap');

  .login-wrap {
    min-height: 520px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    font-family: 'DM Sans', sans-serif;
  }

  .login-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 2.5rem 2rem;
    width: 100%;
    max-width: 400px;
  }

  .brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 2rem;
  }

  .brand-icon {
    width: 36px;
    height: 36px;
    background: #0f172a;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
  }

  .brand-name {
    font-family: 'DM Serif Display', serif;
    font-size: 20px;
    color: var(--color-text-primary);
    letter-spacing: -0.3px;
  }

  .brand-sub {
    font-size: 11px;
    font-family: 'DM Mono', monospace;
    color: var(--color-text-secondary);
    letter-spacing: 1.5px;
    text-transform: uppercase;
  }

  .divider {
    height: 0.5px;
    background: var(--color-border-tertiary);
    margin-bottom: 1.75rem;
  }

  .field {
    margin-bottom: 1.25rem;
  }

  .field label {
    display: block;
    font-size: 12px;
    font-weight: 500;
    color: var(--color-text-secondary);
    letter-spacing: 0.8px;
    text-transform: uppercase;
    margin-bottom: 6px;
    font-family: 'DM Mono', monospace;
  }

  .input-wrap {
    position: relative;
  }

  .input-wrap i {
    position: absolute;
    left: 11px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 15px;
    color: var(--color-text-secondary);
    pointer-events: none;
  }

  .input-wrap input {
    width: 100%;
    padding: 10px 12px 10px 36px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-secondary);
    border-radius: var(--border-radius-md);
    color: var(--color-text-primary);
    box-sizing: border-box;
    transition: border-color 0.15s;
    outline: none;
  }

  .input-wrap input:focus {
    border-color: var(--color-border-primary);
    background: var(--color-background-primary);
  }

  .toggle-pw {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--color-text-secondary);
    padding: 2px;
    display: flex;
    align-items: center;
  }

  .toggle-pw i { font-size: 15px; position: static; transform: none; }

  .error-msg {
    display: none;
    background: var(--color-background-danger);
    border: 0.5px solid var(--color-border-danger);
    border-radius: var(--border-radius-md);
    color: var(--color-text-danger);
    font-size: 13px;
    padding: 10px 12px;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .submit-btn {
    width: 100%;
    padding: 11px;
    background: #0f172a;
    color: white;
    border: none;
    border-radius: var(--border-radius-md);
    font-size: 14px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: opacity 0.15s;
    margin-top: 0.25rem;
  }

  .submit-btn:hover { opacity: 0.88; }
  .submit-btn:active { transform: scale(0.99); }

  .submit-btn.loading { opacity: 0.6; pointer-events: none; }

  .footer-note {
    margin-top: 1.5rem;
    text-align: center;
    font-size: 12px;
    color: var(--color-text-secondary);
    font-family: 'DM Mono', monospace;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }
</style>
</head>
<body>


<div class="login-wrap">
  <div class="login-card">
    <div class="brand">
      <div class="brand-icon"><i class="ti ti-layout-dashboard" aria-hidden="true"></i></div>
      <div>
        <div class="brand-name">Edara</div>
        <div class="brand-sub">Admin Portal</div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="error-msg" id="errMsg" style="display:none;">
      <i class="ti ti-alert-circle" aria-hidden="true"></i>
      <span id="errText">Invalid email or password.</span>
    </div>

    <form id="loginForm" novalidate>

      <div class="field">
        <label for="email">Email</label>
        <div class="input-wrap">
          <i class="ti ti-mail" aria-hidden="true"></i>
          <input type="email" id="email" name="email" placeholder="admin@example.com" autocomplete="email" required>
        </div>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="ti ti-lock" aria-hidden="true"></i>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
          <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password">
            <i class="ti ti-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="submit-btn" id="submitBtn">
        <i class="ti ti-login" aria-hidden="true"></i>
        Sign in
      </button>

    </form>

    <div class="footer-note">
      <i class="ti ti-shield-lock" style="font-size:13px;" aria-hidden="true"></i>
      secured session · httponly cookie
    </div>
  </div>
</div>

<script>
  const togglePw = document.getElementById('togglePw');
  const pwInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');

  togglePw.addEventListener('click', () => {
    const isHidden = pwInput.type === 'password';
    pwInput.type = isHidden ? 'text' : 'password';
    eyeIcon.className = isHidden ? 'ti ti-eye-off' : 'ti ti-eye';
  });

  const form = document.getElementById('loginForm');
  const errMsg = document.getElementById('errMsg');
  const errText = document.getElementById('errText');
  const submitBtn = document.getElementById('submitBtn');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = pwInput.value;

    errMsg.style.display = 'none';

    if (!email || !password) {
      errText.textContent = 'Please fill in all fields.';
      errMsg.style.display = 'flex';
      return;
    }

    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<i class="ti ti-loader-2" aria-hidden="true"></i> Signing in…';

    const body = new URLSearchParams({ email, password });

    try {
      const res = await fetch("./actions/adminlogin.php", {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' ,  'X-Requested-With': 'XMLHttpRequest' },
        body,
      }).then( res => consoloe.log(res.text()))

      if (res.ok || res.redirected) {


      } else if (res.status === 403) {

        errText.textContent = 'Invalid email or password.';
        errMsg.style.display = 'flex';
      } else if (res.status === 400) {
        errText.textContent = 'Please fill in all fields correctly.';
        errMsg.style.display = 'flex';
      } else {
        errText.textContent = 'Something went wrong. Try again.';
        errMsg.style.display = 'flex';
      }
    } catch {
      errText.textContent = 'Network error. Check your connection.';
      errMsg.style.display = 'flex';
    }

    submitBtn.classList.remove('loading');
    submitBtn.innerHTML = '<i class="ti ti-login" aria-hidden="true"></i> Sign in';
  });
</script>

</body>
</html>