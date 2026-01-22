

<!DOCTYPE html>
    <html>
        <head>
            <!-- Basic Page Info -->
            <meta charset="utf-8" />
            <title>DAMS</title>

            <!-- Site favicon -->
            <link
                rel="apple-touch-icon"
                sizes="180x180"
                href="../assets/../assets/vendors/images/apple-touch-icon.png"
            />
            <link
                rel="icon"
                type="image/png"
                sizes="32x32"
                href="../assets/../assets/vendors/images/favicon-32x32.png"
            />
            <link
                rel="icon"
                type="image/png"
                sizes="16x16"
                href="../assets/../assets/vendors/images/favicon-16x16.png"
            />

            <!-- Mobile Specific Metas -->
            <meta
                name="viewport"
                content="width=device-width, initial-scale=1, maximum-scale=1"
            />

            <!-- Google Font -->
            <link
                href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
                rel="stylesheet"
            />
            <!-- CSS -->
            <link rel="stylesheet" type="text/css" href="../assets/../assets/vendors/styles/core.css" />
            <link
                rel="stylesheet"
                type="text/css"
                href="../assets/../assets/vendors/styles/icon-font.min.css"
            />
            <link rel="stylesheet" type="text/css" href="../assets/../assets/vendors/styles/style.css" />

            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script
                async
                ../assets/src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
            ></script>
            <script
                async
                ../assets/src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
                crossorigin="anonymous"
            ></script>
            
    <!-- Add CSS for hover effect -->
    <style>
        .btn-stroke:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border-width: 3px;  /* Thicker border on hover */
        }

        /* Style for invalid input fields */
.is-invalid {
    border-color: #dc3545;
}

/* Style for error message below the input */
.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    display: block;
}

/* General error message */
.error-message {
    color: #dc3545;
    font-size: 1rem;
    margin-top: 15px;
    display: none;
}

body {
    background-image: url("../assets/../assets/vendors/images/loginpage-image.png");
    background-size: cover;              /* Makes the image cover the whole screen */
    background-repeat: no-repeat;        /* Prevents tiling */
    background-position: center center;  /* Centers the image */
    background-attachment: fixed;        /* Optional: makes background fixed during scroll */
}


    </style>
        </head>

        <div class="login-wrap d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10 p-4">
                    <div class="login-title text-center mb-4">
                        <h2 class="text-primary">DAMS</h2>
                    </div>

                    <!-- LOGIN FORM -->
                    <form id="loginForm">
    <!-- Username Field -->
    <div class="input-group custom mb-3">
        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required />
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
        </div>
    </div>
    <div class="invalid-feedback username-error"></div>

    <!-- Password Field -->
    <div class="input-group custom mb-3">
        <input type="password" name="password" class="form-control form-control-lg" placeholder="**********" required />
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
        </div>
    </div>
    <div class="invalid-feedback password-error"></div>

    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
        </div>
    </div>
</form>

                    <!-- Forgot Password Link -->
                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <a href="../auth/forgot_password.php" class="text-primary">Forgot Password?</a>
                        </div>
                    </div>

                    <!-- General Error Message (e.g., wrong username or password) -->
                    <div class="alert alert-danger mt-3 text-center error-message" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- js -->
            <script ../assets/src="../assets/../assets/vendors/scripts/core.js"></script>
            <script ../assets/src="../assets/../assets/vendors/scripts/script.min.js"></script>
            <script ../assets/src="../assets/../assets/vendors/scripts/process.js"></script>
            <script ../assets/src="../assets/../assets/vendors/scripts/layout-settings.js"></script>

            <script>
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    // Reset validation states
    const usernameField = document.querySelector("[name='username']");
    const passwordField = document.querySelector("[name='password']");
    const usernameError = document.querySelector(".username-error");
    const passwordError = document.querySelector(".password-error");

    usernameField.classList.remove("is-invalid");
    passwordField.classList.remove("is-invalid");
    usernameError.textContent = "";
    passwordError.textContent = "";

    const formData = new FormData(this);

    fetch("validate_../auth/login.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            if (data.field === "username") {
                usernameField.classList.add("is-invalid");
                usernameError.textContent = data.message;
            } else if (data.field === "password") {
                passwordField.classList.add("is-invalid");
                passwordError.textContent = data.message;
            } else {
                alert(data.message); // fallback general error
            }
        }
    })
    .catch(err => console.error("Login error:", err));
});
</script>
        </body>
    </html>
