const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const signupForm = document.getElementById("signupForm");
const usernameInput = document.getElementById("signupUsername");
const emailInput = document.getElementById("signupEmail")
const emailStatus = document.getElementById("emailStatus")
const MIN_PASSWORD_LENGTH = 6;



function debounce(fn, delay = 400) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}



emailInput.addEventListener("input", debounce((e) => {
    const email = e.target.value.trim().toLowerCase();

    // reset if empty
    if (!email) {
        emailStatus.textContent = "";
        return;
    }

    // invalid format → no request
    if (!EMAIL_REGEX.test(email)) {
        emailStatus.textContent = " Invalid email";
        emailStatus.style.color = "red";
        return;
    }




    // show loading state
    emailStatus.textContent = "Checking...";
    emailStatus.style.color = "gray";

    fetch("api/checkmail.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "email=" + encodeURIComponent(email)
    })
    .then(res => res.json())
    .then(data => {
        if (data.exists) {
            emailStatus.textContent = " Email taken";
            emailStatus.style.color = "red";
        } else {
            emailStatus.textContent = " Available";
            emailStatus.style.color = "lime";
        }
    })
    .catch(() => {
        emailStatus.textContent = " Error checking";
        emailStatus.style.color = "orange";
    });

}, 400));






usernameInput.addEventListener("input", debounce(function (e) {
const usernameStatus = document.getElementById("usernameStatus");

console.log("here",e.target.value)
    const username = e.target.value.trim();

    if (username.length < 3) {
        usernameStatus.textContent = "";
        return;
    }

    fetch("api/checkusername.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "username=" + encodeURIComponent(username)
    })
    .then(res => res.json())
    .then(data => {
        if (data.exists) {
            usernameStatus.textContent = " Username taken";
            usernameStatus.style.color = "red";
        } else {
            usernameStatus.textContent = "Available";
            usernameStatus.style.color = "lime";
        }
    });
}, 400));







signupForm.addEventListener("submit", function(e) {
    e.preventDefault(); // stop page reload

    const username = document.getElementById("signupUsername").value.trim();
    const email = document.getElementById("signupEmail").value.trim();
    const password = document.getElementById("signupPassword").value;
    const confirm = document.getElementById("signupConfirm").value;
    const gender = document.getElementById("signupGender").value;

    // simple frontend validation
    if (!username || !email || !password || !confirm) {
        alert("All fields required");
        return;
        
    }

    //improve username validation please dont forget 
    //also password check length on input 



    if (!EMAIL_REGEX.test(email)) {
        alert("Invalid email format");
        return;
    }


    

    if (password !== confirm) {
        alert("Passwords do not match");
        return;
    }


      if (password.length < MIN_PASSWORD_LENGTH) {
        alert("Password too short");
        return;
    }

    // send to PHP
    fetch("api/register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&gender=${encodeURIComponent(gender)}`
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "success") {
            window.location.href = "index.html"; // or "/" if root
            alert("Account created ✅");
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert("Server error");
    });
});
