<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

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
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				dataLayer.push(arguments);
			}
			gtag("js", new Date());

			gtag("config", "G-GBZ3SGGX85");
		</script>
		<!-- Google Tag Manager -->
		<script>
			(function (w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != "dataLayer" ? "&l=" + l : "";
				j.async = true;
				j.../assets/src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, "script", "dataLayer", "GTM-NXZMQSS");
		</script>
		<!-- End Google Tag Manager -->

        <style>
            
body {
    background-image: url("../assets/../assets/vendors/images/loginpage-image.png");
    background-size: cover;              /* Makes the image cover the whole screen */
    background-repeat: no-repeat;        /* Prevents tiling */
    background-position: center center;  /* Centers the image */
    background-attachment: fixed;        /* Optional: makes background fixed during scroll */
}

        </style>
	</head>

	<body>

<div class="login-wrap d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10 p-4">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Forgot Password</h2>
                    </div>
                    <h6 class="mb-20 text-center">
                        Enter your email address to reset your password
                    </h6>
                    <form id="forgotForm" method="POST" action="../auth/forgot_password_process.php">
                        <div class="input-group custom mb-3">
                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="form-control form-control-lg"
                                placeholder="Username or Student ID(#)"
                                required
                            />
                            <div class="input-group-append custom">
                                <span class="input-group-text">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="username-error">
                            Please enter your Username or Student ID.
                        </div>

                        <div class="input-group custom mb-3">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control form-control-lg"
                                placeholder="Gmail"
                                required
                            />
                            <div class="input-group-append custom">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="email-error">
                            Please enter a valid SMCBI email address (example@smcbi.edu.ph).
                        </div>

                        <input
                            class="btn btn-primary btn-lg btn-block"
                            type="submit"
                            value="Submit"
                        />
                    </form>
                    <!-- Go back link -->
                    <div class="text-center mt-3">
                        <a href="../auth/login.php" class="text-muted">Go back to login</a>
                    </div>
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
        <script ../assets/src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
document.getElementById("forgotForm").addEventListener("submit", function(e){
    e.preventDefault();

    // Clear previous errors
    const usernameField = document.getElementById("username");
    const emailField = document.getElementById("email");
    const usernameError = document.getElementById("username-error");
    const emailError = document.getElementById("email-error");

    usernameField.classList.remove("is-invalid");
    emailField.classList.remove("is-invalid");
    usernameError.style.display = "none";
    emailError.style.display = "none";

    const formData = new FormData(this);

    fetch("../auth/forgot_password_process.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // or use a Bootstrap modal
            window.location.href = "../auth/login.php";
        } else {
            if (data.field === "username") {
                usernameField.classList.add("is-invalid");
                usernameError.textContent = data.message;
                usernameError.style.display = "block";
            } else if (data.field === "email") {
                emailField.classList.add("is-invalid");
                emailError.textContent = data.message;
                emailError.style.display = "block";
            } else {
                alert(data.message); // general errors
            }
        }
    })
    .catch(err => console.error("Error:", err));
});
</script>
	</body>
</html>
