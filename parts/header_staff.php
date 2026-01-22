<style>
.left-side-bar {
        background-color: white;
    }

    .sidebar-menu {
        color: black; /* Set text color to black for sidebar menu items */
    }

    .sidebar-menu .mtext {
        color: black; /* Set text color to black for the text inside the menu */
    }

    .sidebar-menu .submenu li a {
        color: black; /* Set the submenu links text color to black */
    }

    /* Apply black text color to the dropdown toggle link */
    .sidebar-menu .dropdown-toggle {
        color: black; /* Set the dropdown toggle text color to black */
    }

    /* Set color of the icons */
    .sidebar-menu .micon {
        color: black; /* Set icon color to black */
        font-size: 18px; /* Optional: Adjust icon size */
    }

    /* Optional: Set the hover color to make the text and icons darker when hovering */
    .sidebar-menu .submenu li a:hover,
    .sidebar-menu .dropdown-toggle:hover,
    .sidebar-menu .micon:hover {
        color: #333; /* Darker shade for hover effect on text and icons */
    }

    /* Adjust the close button and logo if necessary */
    .left-side-bar .close-sidebar i,
    .brand-logo img {
        filter: none; /* Optional: Remove any color filtering on icons or images */
    }


    .modal#passwordChangeSuccessModal .modal-content,
.modal#passwordChangeErrorModal .modal-content {
    border-radius: 30px;
}

.modal#passwordChangeSuccessModal .modal-content svg,
.modal#passwordChangeErrorModal .modal-content svg {
    width: 100px;
    display: block;
    margin: 0 auto;
}

.modal#passwordChangeSuccessModal .modal-content .path,
.modal#passwordChangeErrorModal .modal-content .path {
    stroke-dasharray: 1000;
    stroke-dashoffset: 0;
}

.modal#passwordChangeSuccessModal .modal-content .path.circle,
.modal#passwordChangeErrorModal .modal-content .path.circle {
    -webkit-animation: dash 0.9s ease-in-out;
    animation: dash 0.9s ease-in-out;
}

.modal#passwordChangeSuccessModal .modal-content .path.line,
.modal#passwordChangeErrorModal .modal-content .path.line {
    stroke-dashoffset: 1000;
    -webkit-animation: dash 0.95s 0.35s ease-in-out forwards;
    animation: dash 0.95s 0.35s ease-in-out forwards;
}

.modal#passwordChangeSuccessModal .modal-content .path.check,
.modal#passwordChangeErrorModal .modal-content .path.check {
    stroke-dashoffset: -100;
    -webkit-animation: dash-check 0.95s 0.35s ease-in-out forwards;
    animation: dash-check 0.95s 0.35s ease-in-out forwards;
}

@-webkit-keyframes dash {
    0% {
        stroke-dashoffset: 1000;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes dash {
    0% {
        stroke-dashoffset: 1000;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

@-webkit-keyframes dash-check {
    0% {
        stroke-dashoffset: -100;
    }
    100% {
        stroke-dashoffset: 900;
    }
}

@keyframes dash-check {
    0% {
        stroke-dashoffset: -100;
    }
    100% {
        stroke-dashoffset: 900;
    }
}

.box00 {
    width: 100px;
    height: 100px;
    border-radius: 50%;
}

</style>


<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="changePasswordForm" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                        <small id="currentPasswordError" class="text-danger" style="display: none;">Current password is incorrect.</small>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="passwordChangeSuccessModal" tabindex="-1" role="dialog" aria-labelledby="passwordChangeSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                    <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5" />
                </svg>
                <h4 class="text-success mt-3">Password Changed Successfully!</h4>
                <p class="mt-3">Your password has been updated.</p>
                <button type="button" class="btn btn-sm mt-3 btn-success" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="passwordChangeErrorModal" tabindex="-1" role="dialog" aria-labelledby="passwordChangeErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                    <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
                    <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" X2="34.4" y2="92.2" />
                </svg>
                <h4 class="text-danger mt-3">Error!</h4>
                <p class="mt-3">There was an issue changing your password. Please try again.</p>
                <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    
    document.getElementById("changePasswordForm").addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the form from submitting automatically

    const currentPassword = document.getElementById("currentPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const currentPasswordError = document.getElementById("currentPasswordError");

    // Reset error message
    currentPasswordError.style.display = "none";

    // Check if the new passwords match
    if (newPassword !== confirmPassword) {
        alert("New passwords do not match!");
        return;
    }

    // Make the AJAX request to check the current password
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../auth/check_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.valid) {
                // Password is correct, submit the form (now the password change is safe to proceed)
                const formData = new FormData(document.getElementById("changePasswordForm"));
                const xhrSubmit = new XMLHttpRequest();
                xhrSubmit.open("POST", "../auth/change_password.php", true);
                xhrSubmit.onload = function() {
                    if (xhrSubmit.status === 200) {
                        // Trigger success modal
                        $('#passwordChangeSuccessModal').modal('show');
                        // Optionally close the original modal if you want
                        $('#changePasswordModal').modal('hide');
                    } else {
                        // Trigger error modal
                        $('#passwordChangeErrorModal').modal('show');
                    }
                };
                xhrSubmit.send(formData);
            } else {
                // Incorrect current password, show error message
                currentPasswordError.style.display = "block";
            }
        } else {
            alert("Error checking the password.");
        }
    };

    // Send the current password to be validated
    xhr.send("currentPassword=" + encodeURIComponent(currentPassword));
});


</script>

<div class="header">
            <div class="header-left">
                <div class="menu-icon bi bi-list">

                </div>
            </div>
                <div class="header-right">
                    <div class="user-info-dropdown">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <span class="user-icon">
                                    <img ../assets/src="../assets/vendors/images/logo.png" alt="logo" />
                                </span>
                                <span class="user-name"><?php echo "Welcome, " . $_SESSION['id'] ."!"; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">
                                    <i class="dw dw-settings2"></i> Change Password
                                </a>
                                <a class="dropdown-item" href="logout_../admin/admin.php?action=logout">
                                    <i class="dw dw-logout"></i> Log Out
                                </a>
                            </div>
                        </div>
                     </div>
                </div>
</div>


<div class="left-side-bar">
<div class="brand-logo">
        <a href="staff.php">
            <img ../assets/src="../assets/vendors/images/deskapp-logo.svg" alt="" class="dark-logo" />
            <img ../assets/src="../assets/vendors/images/deskapp-logo.svg" alt="" class="light-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <!-- Manage Students Section -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon">
                        <img ../assets/src="../assets/vendors/images/graduates.png" alt="Students" style="width: 50px; height: 40px; vertical-align: middle;">
                        </span>
                        <span class="mtext">Manage Students</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="staff.php">View Students</a></li>
                    </ul>
                </li>

                <!-- Policies & Regulation Section -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon">
                    <img ../assets/src="../assets/vendors/images/regulation.png" alt="regulation" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">Policies & Regulation</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="handbook_staff.php">View Handbook</a></li>
                    </ul>
                </li>

                <li>
                    <a href="../logs/history.php" class="dropdown-toggle no-arrow">
                        <span class="micon">
                            <img ../assets/src="../assets/vendors/images/history.png" style="width: 50px; height: 40px; vertical-align: middle;">
                        </span>
                        <span class="mtext">History</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <!-- Logout Button -->

    
   
</div>
