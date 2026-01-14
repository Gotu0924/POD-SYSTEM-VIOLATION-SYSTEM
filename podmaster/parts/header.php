<style>
/* Style for unread notifications (gray color) */
.notification-list li.unread {
    background-color: #f0f0f0; /* Light gray background for unread notifications */
    color: #888; /* Gray text color */
}

/* Style for read notifications (white color) */
.notification-list li.read {
    background-color: #fff; /* White background for read notifications */
    color: #000; /* Normal text color */
}
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

.dropdown-toggle.disabled {
    pointer-events: none; /* Disable clicks */
    opacity: 0.5; /* Optional: Make the icon appear disabled */
}

/* Disable the notification icon and make it look inactive */
.dropdown-toggle.disabled {
    pointer-events: none; /* Disable clicking */
    opacity: 0.5; /* Make it visually appear disabled */
}


.user-notification .badge {
    position: absolute;
    top: -5px;      /* Adjust this value to move the badge up */
    right: -5px;    /* Adjust this value to move the badge left/right */
    padding: 3px 6px;
    border-radius: 50%;
    background-color: red; /* Or any color you prefer */
    color: white;
    font-size: 10px;
    display: none; /* Keep this to hide it when there are no notifications */
}

.user-notification a {
    position: relative; /* This is crucial for positioning the badge */
    display: inline-block;
}




</style>


<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>
    </div>
    <div class="header-right">
        <div class="user-notification">
            <div class="dropdown">
                <a class="no-arrow" href="logs.php" role="button" id="notification-icon">
                    <i class="icon-copy dw dw-notification"></i>
                    <span class="badge notification-active"></span>
                </a>
            </div>
        </div>
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="vendors/images/logo.png" alt="logo" />
                    </span>
                    <span class="user-name"><?php echo "Welcome, " . $_SESSION['id'] ."!"; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="dw dw-settings2"></i> Change Password
                    </a>
                    <a class="dropdown-item" href="logout_admin.php?action=logout">
                        <i class="dw dw-logout"></i> Log Out
                    </a>
                </div>
            </div>
        </div>  
    </div>
</div>
<script>
let lastSanctionId = 0;

function checkForNewSanction() {
    fetch('fetch_new_sanctions.php')
        .then(response => response.json())
        .then(data => {
            const notificationBadge = document.querySelector('.badge.notification-active');

            if (data.success && data.sanctions && data.sanctions.length > 0) {
                // Assuming fetch_new_sanctions.php returns an array of sanctions
                // and each sanction has an i_ID
                let unseenSanctions = data.sanctions.filter(s => s.i_ID > lastSanctionId);

                if (unseenSanctions.length > 0) {
                    // Update lastSanctionId to the highest i_ID received
                    lastSanctionId = Math.max(...unseenSanctions.map(s => s.i_ID));

                    // Display the number of new sanctions
                    notificationBadge.textContent = unseenSanctions.length;
                    notificationBadge.style.display = 'inline-block';
                }
            } else {
                // No new sanctions
                notificationBadge.style.display = 'none';
                notificationBadge.textContent = '0';
            }
        })
        .catch(error => console.error("Error fetching new sanctions:", error));
}

// Run every 5 seconds
setInterval(checkForNewSanction, 5000);
</script>


<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index3.php">
            <img src="vendors/images/deskapp-logo.svg" alt="" class="dark-logo" />
            <img src="vendors/images/deskapp-logo.svg" alt="" class="light-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon">
                        <img src="vendors/images/graduates.png" alt="Students" style="width: 50px; height: 40px; vertical-align: middle;">
                        </span>
                        <span class="mtext">Manage Students</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="index3.php">View Students</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#addStudentModal">Add Student</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon">
                            <img src="vendors/images/admin.png" alt="admin" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">Manage Admin</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="admin.php">View Admin</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#addAddminModal">Add Admin</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon">
                    <img src="vendors/images/sanctions.png" alt="santions" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">Manage Violation</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="sunctions.php">View Violation</a></li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#addSanctionModal">Add Violation</a>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon">
                    <img src="vendors/images/guard.png" alt="hammer" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">Manage Guardians</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="gaurdians.php">View Guardians</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon">
                    <img src="vendors/images/hammer.png" alt="hammer" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">Appeals</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="appeals.php">View Appeals</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon">
                    <img src="vendors/images/log.png" alt="log" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">Manage Inbox</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="logs.php">View Inbox</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon">
                    <img src="vendors/images/regulation.png" alt="regulation" style="width: 50px; height: 40px; vertical-align: middle;"></span>
                        <span class="mtext">School HandBook</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="handbook.php">View Handbook</a></li>
                    </ul>
                </li>
               <li class="dropdown">
  <a href="javascript:;" class="dropdown-toggle">
    <span class="micon">
      <img src="vendors/images/archive.png" alt="regulation" style="width: 50px; height: 40px; vertical-align: middle;">
    </span>
    <span class="mtext">Archive</span>
  </a>
  <ul class="submenu">
    <li><a href="student_archive.php">Student Archive</a></li>
    <li><a href="admin_archive.php">Admin Archive</a></li>
    <li><a href="violation_archive.php">Violation Archive</a></li>
    <li><a href="guardians_archive.php">Guardians Archive</a></li>
    <li><a href="appeals_archive.php">Appeals Archive</a></li>
  </ul>
</li>




            </ul>
        </div>
    </div>
</div>






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
                    <small id="newPasswordError" class="text-danger" style="display: none;">New password must be at least 8 characters long.</small>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    <small id="confirmPasswordError" class="text-danger" style="display: none;">Passwords do not match.</small>
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
    document.addEventListener("DOMContentLoaded", function () {
    const changePasswordForm = document.getElementById("changePasswordForm");
    const currentPasswordInput = document.getElementById("currentPassword");
    const newPasswordInput = document.getElementById("newPassword");
    const confirmPasswordInput = document.getElementById("confirmPassword");
    const currentPasswordError = document.getElementById("currentPasswordError");
    const newPasswordError = document.getElementById("newPasswordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    // Real-time current password validation
    currentPasswordInput.addEventListener("blur", function () {
        const currentPassword = currentPasswordInput.value.trim();
        if (currentPassword === "") {
            currentPasswordError.style.display = "none";
            return;
        }

        // Make the API call to validate the current password
        fetch("check_password_admin.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ currentPassword })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "error") {
                currentPasswordError.style.display = "block";
            } else {
                currentPasswordError.style.display = "none";
            }
        })
        .catch(() => {
            currentPasswordError.style.display = "none";
        });
    });

    // Form submission
    changePasswordForm.addEventListener("submit", function (e) {
        e.preventDefault();

        // Clear previous error states
        currentPasswordInput.classList.remove("is-invalid");
        newPasswordInput.classList.remove("is-invalid");
        confirmPasswordInput.classList.remove("is-invalid");

        // Clear error messages
        currentPasswordError.style.display = 'none';
        newPasswordError.style.display = 'none';
        confirmPasswordError.style.display = 'none';

        // Get values from the form
        const currentPassword = currentPasswordInput.value.trim();
        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();

        let valid = true;

        // Validate current password
        if (currentPassword === "") {
            currentPasswordInput.classList.add("is-invalid");
            currentPasswordError.style.display = 'block';
            valid = false;
        }

        // Validate new password length
        if (newPassword.length < 8) {
            newPasswordInput.classList.add("is-invalid");
            newPasswordError.style.display = 'block';
            valid = false;
        }

        // Validate if new password matches confirm password
        if (newPassword !== confirmPassword) {
            confirmPasswordInput.classList.add("is-invalid");
            confirmPasswordError.style.display = 'block';
            valid = false;
        }

        // If all fields are valid, proceed with AJAX submission
        if (valid) {
            const formData = new URLSearchParams({
                currentPassword,
                newPassword,
                confirmPassword
            });

            // AJAX request to change password
            fetch("change_password_admin.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Hide the change password modal
                $("#changePasswordModal").modal("hide");

                // Check the response status
                if (data.status === "success") {
                    // Show success modal
                    const successModal = new bootstrap.Modal(document.getElementById('passwordChangeSuccessModal'));
                    successModal.show();
                    
                    // Reset the form
                    changePasswordForm.reset();
                } else {
                    // Show error modal
                    const errorModal = new bootstrap.Modal(document.getElementById('passwordChangeErrorModal'));
                    errorModal.show();
                }
            })
            .catch(() => {
                // Hide the modal if error occurs
                $("#changePasswordModal").modal("hide");

                // Show error modal in case of a catch
                const errorModal = new bootstrap.Modal(document.getElementById('passwordChangeErrorModal'));
                errorModal.show();
            });
        }
    });
});

</script>

<!-- Add Student Modal (Aligned 4-Column Form) -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95vw; max-height: 80vh;">
    <div class="modal-content" style="height: 100%; overflow: hidden;">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" style="max-height: calc(80vh - 56px - 56px); overflow-y: auto;">
        <!-- Student Form -->
        <form id="addStudentForm">
          <div class="row">
            
            <!-- Column 1 -->
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label for="addPicture">Student Picture</label>
                <input type="file" class="form-control" id="addPicture" accept="image/*" required>
              </div>
              <div class="form-group">
                <label for="addStudentID">Student ID</label>
                <div class="position-relative">
                  <input type="text" class="form-control pr-4" id="addStudentID" placeholder="Enter student ID" required onblur="checkStudentID()">
                  <span id="studentIdIcon" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); display: none;">❌</span>
                </div>
                <small id="studentIdError" class="text-danger"></small>
              </div>
              <div class="form-group">
                <label for="addFirstName">First Name</label>
                <input type="text" class="form-control" id="addFirstName" placeholder="Enter first name" required>
              </div>
              <div class="form-group">
                <label for="addMiddlename">Middle Name</label>
                <input type="text" class="form-control" id="addMiddlename" placeholder="Enter middle name" required>
              </div>
              <div class="form-group">
                <label for="addLastName">Last Name</label>
                <input type="text" class="form-control" id="addLastName" placeholder="Enter last name" required>
              </div>
            </div>

            <!-- Column 2 -->
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label for="addDOB">Date of Birth</label>
                <input type="date" class="form-control" id="addDOB" required>
              </div>
              <div class="form-group">
                <label for="addGender">Gender</label>
                <select class="form-control" id="addGender" required>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <!-- Password & Confirm Password -->
              <div class="form-group">
                <label for="addPassword">Password</label>
                <input type="password" class="form-control" id="addPassword" placeholder="Enter password" required>
              </div>
              <div class="form-group">
                <label for="addConfirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="addConfirmPassword" placeholder="Confirm password" required>
                <small id="passwordError" class="text-danger d-none">Passwords do not match.</small>
              </div>

              <!-- School Year + Course same row -->
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="addSchoolYear">School Year</label>
                  <input type="text" class="form-control" id="addSchoolYear" placeholder="e.g., 2024-2025" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="addCourse">Course of Study</label>
                  <select class="form-control" id="addCourse" required>
                    <option value="BSIT">BSIT</option>
                    <option value="BEED">BEED</option>
                    <option value="BSED">BSED</option>
                    <option value="BSBA">BSBA</option>
                    <option value="BSHM">BSHM</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Column 3 -->
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="form-group">
                <label for="addYearLevel">Year Level</label>
                <select class="form-control" id="addYearLevel" required>
                  <option value="1st Year">1st Year</option>
                  <option value="2nd Year">2nd Year</option>
                  <option value="3rd Year">3rd Year</option>
                  <option value="4th Year">4th Year</option>
                </select>
              </div>
              <div class="form-group">
                <label for="addAddress">Address</label>
                <input type="text" class="form-control" id="addAddress" placeholder="Enter address" required>
              </div>
              <div class="form-group">
                <label for="addPhone">Phone Number</label>
                <input type="text" class="form-control" id="addPhone" placeholder="Enter phone number" required>
              </div>
              <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="addReligion">Religion</label>
                        <select class="form-control" id="addReligion" required>
                        <option value="Catholic">Catholic</option>
                        <option value="Baptist">Baptist</option>
                        <option value="Muslim">Muslim</option>
                        <option value="SDA">SDA</option>
                        <option value="Foursquare">Foursquare</option>
                        <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="addGmail">Gmail</label>
                        <input type="text" class="form-control" id="addGmail" placeholder="@smcbi.edu.ph" required>
                    </div>
                </div>
                <div class="form-group">
                  <label for="addLicence">License Number</label>
                  <input type="text" class="form-control" placeholder="Enter your Driver License" id="addLicence" name="addLicence">
                </div>
            </div>

            <!-- Column 4 (Guardian Info) -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="form-group">
                  <label for="addLicenceRegistration">Registration Number</label>
                  <input type="text" class="form-control" placeholder="Enter your Registration Number" id="addLicenceRegistration" name="addLicenceRegistration">
                </div>
              <div class="form-group">
                <label for="addGuardianFirstName">Guardian First Name</label>
                <input type="text" class="form-control" id="addGuardianFirstName" placeholder="Enter guardian's first name" required>
              </div>
              <div class="form-group">
                <label for="addGuardianLastName">Guardian Last Name</label>
                <input type="text" class="form-control" id="addGuardianLastName" placeholder="Enter guardian's last name" required>
              </div>
              <div class="form-group">
                <label for="addGuardianPhone">Guardian Phone Number</label>
                <input type="text" class="form-control" id="addGuardianPhone" placeholder="Enter guardian's phone number" required>
              </div>
              <div class="form-group">
                <label for="addGuardianAddress">Guardian Address</label>
                <input type="text" class="form-control" id="addGuardianAddress" placeholder="Enter guardian's address" required>
              </div>
            </div>

          </div>
        </form>
      </div>

      <!-- Footer with buttons -->
      <div class="modal-footer">
        <form id="csvForm" action="import_csv.php" method="post" enctype="multipart/form-data" style="display:none;">
          <input type="file" name="csv_file" id="csvFile" accept=".csv">
        </form>
        <button type="button" class="btn btn-success mr-auto" id="excelBtn">
          <i class="fa fa-file-excel-o"></i> Import CSV File
        </button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addStudent()">Add Student</button>
      </div>
    </div>
  </div>
</div>

<!-- reuiqred feild modal -->
<div class="modal fade" id="required-field-modal" tabindex="-1" role="dialog" aria-labelledby="requiredFieldModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 id="required-field-message" class="text-danger mt-3">Required Fields Missing!</h4>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- add sanctions -->
<div class="modal fade" id="addSanctionModal" tabindex="-1" role="dialog" aria-labelledby="addSanctionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSanctionLabel">Add New Violation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <form id="addSanctionForm">
                    
                    <!-- Student ID -->
                    <div class="form-group">
                        <label for="st_ID">Student ID</label>
                        <input type="text" class="form-control" id="st_ID" name="st_ID" required onblur="validateStudentID(); fetchStudentName();">
                        <div class="invalid-feedback" id="invalidStudentID" style="display: none;">
                            Please enter a valid Student ID.
                        </div>
                    </div>

                    <!-- Hidden Student Name -->
                    <input type="hidden" id="st_name" name="st_name">
                    <!-- Category -->
                    <div class="form-group">
                    <label for="i_Category">Category</label>
                    <select class="form-control" id="i_Category" name="i_Category" required onchange="handleCategoryChange(); validateCategory();">
                        <option value="">Select Category</option>
                        <option value="Category A">Category A</option>
                        <option value="Category B">Category B</option>
                        <option value="Category C">Category C</option>
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" class="form-control mt-2" id="otherCategory" name="otherCategory" placeholder="Enter custom category" style="display:none;" oninput="validateCategory()">
                    <div class="invalid-feedback" id="invalidCategory" style="display: none;">
                        Please select a category.
                    </div>
                    </div>

                    <!-- Offense -->
                    <div class="form-group">
                    <label for="list_Offense">Offense</label>
                    <select class="form-control" id="list_Offense" name="list_Offense" required onchange="handleOffenseChange(); validateOffense()">
                        <option value="">Select Offense</option>
                    </select>
                    <input type="text" class="form-control mt-2" id="otherOffense" name="otherOffense" placeholder="Enter custom offense" style="display:none;" oninput="validateOffense()">
                    <div class="invalid-feedback" id="invalidOffense" style="display: none;">
                        Please select an offense.
                    </div>
                    </div>

                                        <!-- Sanction -->
                    <div class="form-group">
                        <label for="i_Sanctions">Sanction Type</label>
                        <select class="form-control" id="i_Sanctions" name="i_Sanctions" required onchange="toggleSuspensionTypeadd(); validateSanctionType();">
                            <option value="">Select Sanction Type</option>
                            <option value="Reprimand">Reprimand</option>
                            <option value="Suspension">Suspension</option>
                            <option value="Exclusion">Exclusion</option>
                        </select>
                        <div class="invalid-feedback" id="invalidSanctionType" style="display: none;">
                            Please select a sanction type.
                        </div>
                    </div>

                    <!-- Suspension Type -->
                    <div class="form-group" id="suspensionTypeGroup" style="display: none;">
                        <label for="Suspension_Type">Suspension Type</label>
                        <select class="form-control" id="Suspension_Type" name="Suspension_Type" onchange="validateSuspensionType()">
                            <option value="">Select Suspension Type</option>
                            <option value="First Offense">First Offense: Letter of apology and counseling</option>
                            <option value="Second Offense">Second Offense: Suspension (1-2 days) and two counseling sessions</option>
                            <option value="Third Offense">Third Offense: Suspension (2-4 days), five counseling sessions, and possible community service</option>
                        </select>
                        <div class="invalid-feedback" id="invalidSuspensionType" style="display: none;">
                            Please select a suspension type.
                        </div>
                    </div>
                    <input type="hidden" name="Suspension_Type_Hidden" id="Suspension_Type_Hidden" value="N/A">

                    <!-- Details -->
                    <div class="form-group">
                        <label for="i_Details">Details</label>
                        <textarea class="form-control" id="i_Details" name="i_Details" rows="3" required oninput="validateDetails()"></textarea>
                        <div class="invalid-feedback" id="invalidDetails" style="display: none;">
                            Please provide details of the violation.
                        </div>
                    </div>

                    <!-- Recommendation -->
                    <div class="form-group">
                        <label for="i_Recommendation">Recommendation</label>
                        <input type="text" class="form-control" id="i_Recommendation" name="i_Recommendation" required oninput="validateRecommendation()">
                        <div class="invalid-feedback" id="invalidRecommendation" style="display: none;">
                            Please provide a recommendation.
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="i_Status">Status</label>
                        <select class="form-control" id="i_Status" name="i_Status" required onchange="validateStatus()">
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                        <div class="invalid-feedback" id="invalidStatus" style="display: none;">
                            Please select a status.
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" id="addViolationButton" onclick="addSanction()">Add Violation</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
function fetchStudentName() {
    const studentID = document.getElementById("st_ID").value.trim();
    if (studentID === "") return;

    fetch("fetch_student_name.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ st_ID: studentID })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("st_name").value = data.full_name;
            document.getElementById("invalidStudentID").style.display = "none";
        } else {
            document.getElementById("st_name").value = "";
            document.getElementById("invalidStudentID").style.display = "block";
        }
    })
    .catch(error => {
        console.error("Error fetching student name:", error);
    });
}
</script>


<script>
// Function to toggle suspension type visibility
function toggleSuspensionTypeadd() {
    const sanctionType = document.getElementById('i_Sanctions').value;
    const suspensionTypeGroup = document.getElementById('suspensionTypeGroup');
    const suspensionTypeInput = document.getElementById('Suspension_Type');
    const suspensionTypeHidden = document.getElementById('Suspension_Type_Hidden');

    if (sanctionType === 'Suspension') {
        suspensionTypeGroup.style.display = 'block';
        suspensionTypeInput.setAttribute('required', 'true');
        suspensionTypeHidden.value = '';
    } else {
        suspensionTypeGroup.style.display = 'none';
        suspensionTypeInput.removeAttribute('required');
        suspensionTypeInput.value = '';
        suspensionTypeHidden.value = 'N/A';
    }

    validateSuspensionType();
}

// --- Validation Functions ---

function validateStudentID() {
    const studentIDInput = document.getElementById('st_ID');
    const studentID = studentIDInput.value;
    const invalidFeedback = document.getElementById('invalidStudentID');

    if (studentID === '') {
        invalidFeedback.textContent = 'Student ID is required.';
        invalidFeedback.style.display = 'block';
        studentIDInput.classList.add('is-invalid');
        return false;
    }

    if (!/^\d{6}$/.test(studentID)) {
        invalidFeedback.textContent = 'Student ID must be exactly 6 digits.';
        invalidFeedback.style.display = 'block';
        studentIDInput.classList.add('is-invalid');
        return false;
    }

    $.ajax({
        url: 'check_student_ids.php',
        method: 'POST',
        data: { student_id: studentID },
        success: function(response) {
            if (response === 'exists') {
                invalidFeedback.style.display = 'none';
                studentIDInput.classList.remove('is-invalid');
                studentIDInput.classList.add('is-valid');
                validateForm();
            } else {
                invalidFeedback.textContent = 'Student ID does not exist.';
                invalidFeedback.style.display = 'block';
                studentIDInput.classList.add('is-invalid');
                validateForm();
            }
        },
        error: function() {
            invalidFeedback.textContent = 'Error checking Student ID. Please try again.';
            invalidFeedback.style.display = 'block';
            studentIDInput.classList.add('is-invalid');
            validateForm();
        }
    });
    return false;
}

function validateCategory() {
    const categoryInput = document.getElementById('i_Category');
    const otherCategoryInput = document.getElementById('otherCategory');
    const invalidFeedback = document.getElementById('invalidCategory');

    if (categoryInput.value === '') {
        invalidFeedback.textContent = 'Please select a category.';
        invalidFeedback.style.display = 'block';
        categoryInput.classList.add('is-invalid');
        return false;
    }

    if (categoryInput.value === 'Other' && otherCategoryInput.value.trim() === '') {
        invalidFeedback.textContent = 'Please specify the category.';
        invalidFeedback.style.display = 'block';
        otherCategoryInput.classList.add('is-invalid');
        return false;
    }

    invalidFeedback.style.display = 'none';
    categoryInput.classList.remove('is-invalid');
    categoryInput.classList.add('is-valid');
    otherCategoryInput.classList.remove('is-invalid');
    otherCategoryInput.classList.add('is-valid');
    return true;
}

function validateOffense() {
    const offenseInput = document.getElementById('list_Offense');
    const otherOffenseInput = document.getElementById('otherOffense');
    const invalidFeedback = document.getElementById('invalidOffense');

    if (offenseInput.value === '') {
        invalidFeedback.textContent = 'Please select an offense.';
        invalidFeedback.style.display = 'block';
        offenseInput.classList.add('is-invalid');
        return false;
    }

    if (offenseInput.value === 'Other' && otherOffenseInput.value.trim() === '') {
        invalidFeedback.textContent = 'Please specify the offense.';
        invalidFeedback.style.display = 'block';
        otherOffenseInput.classList.add('is-invalid');
        return false;
    }

    invalidFeedback.style.display = 'none';
    offenseInput.classList.remove('is-invalid');
    offenseInput.classList.add('is-valid');
    otherOffenseInput.classList.remove('is-invalid');
    otherOffenseInput.classList.add('is-valid');
    return true;
}

function validateSanctionType() {
    const sanctionTypeInput = document.getElementById('i_Sanctions');
    const invalidFeedback = document.getElementById('invalidSanctionType');
    if (sanctionTypeInput.value === '') {
        invalidFeedback.textContent = 'Please select a sanction type.';
        invalidFeedback.style.display = 'block';
        sanctionTypeInput.classList.add('is-invalid');
        return false;
    } else {
        invalidFeedback.style.display = 'none';
        sanctionTypeInput.classList.remove('is-invalid');
        sanctionTypeInput.classList.add('is-valid');
        return true;
    }
}

function validateSuspensionType() {
    const suspensionTypeGroup = document.getElementById('suspensionTypeGroup');
    const suspensionTypeInput = document.getElementById('Suspension_Type');
    const invalidFeedback = document.getElementById('invalidSuspensionType');

    if (suspensionTypeGroup.style.display !== 'none') {
        if (suspensionTypeInput.value === '') {
            invalidFeedback.textContent = 'Please select a suspension type.';
            invalidFeedback.style.display = 'block';
            suspensionTypeInput.classList.add('is-invalid');
            return false;
        } else {
            invalidFeedback.style.display = 'none';
            suspensionTypeInput.classList.remove('is-invalid');
            suspensionTypeInput.classList.add('is-valid');
            document.getElementById('Suspension_Type_Hidden').value = suspensionTypeInput.value;
            return true;
        }
    }
    return true;
}

function validateDetails() {
    const detailsInput = document.getElementById('i_Details');
    const invalidFeedback = document.getElementById('invalidDetails');
    if (detailsInput.value.trim() === '') {
        invalidFeedback.textContent = 'Details are required.';
        invalidFeedback.style.display = 'block';
        detailsInput.classList.add('is-invalid');
        return false;
    } else {
        invalidFeedback.style.display = 'none';
        detailsInput.classList.remove('is-invalid');
        detailsInput.classList.add('is-valid');
        return true;
    }
}

function validateRecommendation() {
    const recommendationInput = document.getElementById('i_Recommendation');
    const invalidFeedback = document.getElementById('invalidRecommendation');
    if (recommendationInput.value.trim() === '') {
        invalidFeedback.textContent = 'Recommendation is required.';
        invalidFeedback.style.display = 'block';
        recommendationInput.classList.add('is-invalid');
        return false;
    } else {
        invalidFeedback.style.display = 'none';
        recommendationInput.classList.remove('is-invalid');
        recommendationInput.classList.add('is-valid');
        return true;
    }
}

function validateStatus() {
    const statusInput = document.getElementById('i_Status');
    const invalidFeedback = document.getElementById('invalidStatus');
    if (statusInput.value === '') {
        invalidFeedback.textContent = 'Please select a status.';
        invalidFeedback.style.display = 'block';
        statusInput.classList.add('is-invalid');
        return false;
    } else {
        invalidFeedback.style.display = 'none';
        statusInput.classList.remove('is-invalid');
        statusInput.classList.add('is-valid');
        return true;
    }
}

function validateForm() {
    let isFormValid = true;
    if (!validateStudentID()) isFormValid = false;
    if (!validateCategory()) isFormValid = false;
    if (!validateOffense()) isFormValid = false;
    if (!validateSanctionType()) isFormValid = false;
    if (!validateSuspensionType()) isFormValid = false;
    if (!validateDetails()) isFormValid = false;
    if (!validateRecommendation()) isFormValid = false;
    if (!validateStatus()) isFormValid = false;
    return isFormValid;
}

// --- New "Other" Option Handlers ---
function handleCategoryChange() {
    const category = document.getElementById('i_Category').value;
    const otherCategoryInput = document.getElementById('otherCategory');
    const offenseSelect = document.getElementById('list_Offense');

    if (category === 'Other') {
        otherCategoryInput.style.display = 'block';
        otherCategoryInput.required = true;
        offenseSelect.innerHTML = '<option value="Other">Other</option>';
        handleOffenseChange();
    } else {
        otherCategoryInput.style.display = 'none';
        otherCategoryInput.required = false;
        otherCategoryInput.value = '';
        populateOffensesadd();
    }
}

function handleOffenseChange() {
    const offense = document.getElementById('list_Offense').value;
    const otherOffenseInput = document.getElementById('otherOffense');

    if (offense === 'Other') {
        otherOffenseInput.style.display = 'block';
        otherOffenseInput.required = true;
    } else {
        otherOffenseInput.style.display = 'none';
        otherOffenseInput.required = false;
        otherOffenseInput.value = '';
    }
}

// --- Event Listeners ---
document.getElementById('st_ID').addEventListener('blur', validateStudentID);
document.getElementById('i_Category').addEventListener('change', () => { handleCategoryChange(); validateCategory(); });
document.getElementById('list_Offense').addEventListener('change', () => { handleOffenseChange(); validateOffense(); });
document.getElementById('i_Sanctions').addEventListener('change', () => { toggleSuspensionTypeadd(); validateSanctionType(); });
document.getElementById('Suspension_Type').addEventListener('change', validateSuspensionType);
document.getElementById('i_Details').addEventListener('input', validateDetails);
document.getElementById('i_Recommendation').addEventListener('input', validateRecommendation);
document.getElementById('i_Status').addEventListener('change', validateStatus);

// --- Modal Events ---
$('#addSanctionModal').on('show.bs.modal', function () {
    validateStudentID();
    validateForm();
    toggleSuspensionTypeadd();
});

document.getElementById('addViolationButton').addEventListener('click', function() {
    if (validateForm()) {
        addSanction();
    }
});

// --- Add Sanction Submission ---
function addSanction() {
    var formData = new FormData(document.getElementById('addSanctionForm'));

    // Handle "Other" values before sending
    const categorySelect = document.getElementById('i_Category');
    const offenseSelect = document.getElementById('list_Offense');
    const otherCategory = document.getElementById('otherCategory').value;
    const otherOffense = document.getElementById('otherOffense').value;

    if (categorySelect.value === 'Other' && otherCategory.trim() !== '') {
        formData.set('i_Category', otherCategory.trim());
    }
    if (offenseSelect.value === 'Other' && otherOffense.trim() !== '') {
        formData.set('list_Offense', otherOffense.trim());
    }

    fetch('submit_sanction.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#violation-added-success').modal('show');
            $('#addSanctionModal').modal('hide');
        } else {
            alert('Error adding sanction: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>



<!-- Success Modal -->
<div class="modal fade" id="violation-added-success" tabindex="-1" role="dialog" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Sanction Added Successfully!</h4>
        <p class="mt-3">The violation has been added successfully.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>



<script>

function populateOffensesadd() {
    const category = document.getElementById("i_Category").value;
    const offenseSelect = document.getElementById("list_Offense");
    offenseSelect.innerHTML = "";

    const offenses = {
        "Category A": [
            "Loitering and creating noise",
            "Failure to wear proper attire",
            "Shouting and loud talking",
            "Unauthorized use of facilities",
            "Tampering notices on boards",
            "Non-payment of school debts",
            "Wearing uniform in prohibited places"
        ],
        "Category B": [
            "Cheating during tests",
            "Smoking on school premises",
            "Vandalism",
            "Gambling",
            "Drunkenness and possession of liquor",
            "Refusal to wear proper uniform",
            "Use of fake IDs",
            "Discourtesy to staff",
            "Possession of pornographic material",
            "Public disturbances",
            "Cyberbullying",
            "Unauthorized use of school name"
        ],
        "Category C": [
            "Assaulting a teacher",
            "Carrying deadly weapons",
            "Extortion",
            "Fighting and causing injury",
            "Possessing or selling drugs",
            "Immorality",
            "Instigating school stoppages",
            "Forging school records",
            "Hazing",
            "Drug addiction",
            "Stealing school property",
            "Libel or malicious defamation"
        ]
    };

    offenses[category].forEach(offense => {
        let option = document.createElement("option");
        option.value = offense;
        option.textContent = offense;
        offenseSelect.appendChild(option);
    });
}

function toggleSuspensionTypeadd() {
    var sanctionType = document.getElementById('i_Sanctions').value;
    var suspensionGroup = document.getElementById('suspensionTypeGroup');
    var suspensionField = document.getElementById('Suspension_Type');
    var hiddenSuspensionField = document.getElementById('Suspension_Type_Hidden');

    if (sanctionType === 'Suspension') {
        suspensionGroup.style.display = 'block';
        hiddenSuspensionField.value = suspensionField.value; // Sync value with selection
    } else {
        suspensionGroup.style.display = 'none';
        hiddenSuspensionField.value = 'N/A'; // Set to "N/A" for Reprimand and Exclusion
    }
}

// Ensure the hidden field is updated when Suspension Type changes
document.getElementById('Suspension_Type').addEventListener('change', function() {
    var hiddenSuspensionField = document.getElementById('Suspension_Type_Hidden');
    hiddenSuspensionField.value = this.value;
});



</script>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAddminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addAdminModalLabel">Add Admin</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
        <!-- Import Button -->
        <button type="button" class="btn btn-success mb-3" id="excelBtnadmin">
          <i class="fa fa-file-excel-o"></i> Import CSV File
        </button>

        <!-- Hidden Import CSV Form -->
        <form id="csvFormadmin" action="import_csv_admin.php" method="post" enctype="multipart/form-data" style="display:none;">
          <input type="file" name="csv_file" id="csvFileadmin" accept=".csv">
        </form>

        <!-- Add Admin Form -->
        <form id="addAdminForm">
          <div class="row">
            
            <!-- Left Column -->
            <div class="col-md-6 pr-3">
              <div class="form-group">
                <label for="addFirstname">First Name</label>
                <input type="text" id="addFirstname" class="form-control" placeholder="Enter first name" required>
                <small id="firstnameError" class="text-danger d-none">First name is required.</small>
              </div>

              <div class="form-group">
                <label for="addLastname">Last Name</label>
                <input type="text" id="addLastname" class="form-control" placeholder="Enter last name" required>
                <small id="lastnameError" class="text-danger d-none">Last name is required.</small>
              </div>

             <div class="form-group">
                <label for="addRole">Role</label>
                    <select id="addRole" class="form-control" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                <small id="roleError" class="text-danger d-none">Please select a role.</small>
            </div>


              <div class="form-group">
                <label for="addPhoneNumber">Phone Number</label>
                <input type="text" id="addPhoneNumber" class="form-control" placeholder="Enter phone number" required>
                <small id="phoneError" class="text-danger d-none">Phone number is required.</small>
              </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6 pl-3">
              <div class="form-group">
                <label for="addUsername">Username</label>
                <input type="text" id="addUsername" class="form-control" placeholder="Enter username" required>
                <small id="usernameError" class="text-danger d-none">Username is required.</small>
              </div>

             <div class="form-group">
                <label for="addgmailadmin">Email (SMCBI)</label>
                <input type="email" id="addgmailadmin" class="form-control" placeholder="Enter institutional email" required>
                <small id="addGmailError" class="text-danger d-none">Email must end with @smcbi.edu.ph.</small>
                </div>


              <div class="form-group">
                <label for="a_addPassword">Password</label>
                <input type="password" id="a_addPassword" class="form-control" placeholder="Enter password" required onkeyup="validatePasswordAdmin()">
                <small id="passwordError" class="text-danger d-none">Password is required.</small>
              </div>

              <div class="form-group">
                <label for="confirmPasswordadmin">Confirm Password</label>
                <input type="password" id="confirmPasswordadmin" class="form-control" placeholder="Re-enter password" required onkeyup="validatePasswordAdmin()">
                <small id="confirmPasswordError" class="text-danger d-none">Passwords do not match.</small>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addAdmin()">Add Admin</button>
      </div>
    </div>
  </div>
</div>




<!-- Admin Add Success Modal -->
<div class="modal fade" id="admin-add-success" tabindex="-1" role="dialog" aria-labelledby="adminAddSuccessLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Admin Added Successfully!</h4>
        <p class="mt-3">The admin has been successfully added.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Admin Add Error Modal -->
<div class="modal fade" id="admin-add-error" tabindex="-1" role="dialog" aria-labelledby="adminAddErrorLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Failed to Add Admin!</h4>
        <p class="mt-3" id="error-message">Something went wrong while adding the admin.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





<script>
document.addEventListener("DOMContentLoaded", function () {
    function setupCsvImport(buttonId, fileInputId, formId) {
        const button = document.getElementById(buttonId);
        const fileInput = document.getElementById(fileInputId);
        const form = document.getElementById(formId);

        if (button && fileInput && form) {
            // Open Windows Explorer
            button.addEventListener("click", function () {
                fileInput.click();
            });

            // Auto-submit after file is chosen
            fileInput.addEventListener("change", function () {
                if (fileInput.files.length > 0) {
                    form.submit();
                }
            });
        }
    }

    // Student Import
    setupCsvImport("excelBtn", "csvFile", "csvForm");

    // Admin Import
    setupCsvImport("excelBtnadmin", "csvFileadmin", "csvFormadmin");
});
</script>



<script>

    
    // Add this script after your HTML or in a <script> tag
function validatePasswordAdmin() {
    const password = document.getElementById('a_addPassword').value;
    const confirmPassword = document.getElementById('confirmPasswordadmin').value;
    const errorMsg = document.getElementById('passwordErroradmin');

    if (confirmPassword === "") {
        errorMsg.classList.add('d-none');
        return;
    }

    if (password === confirmPassword) {
        errorMsg.classList.add('d-none');
    } else {
        errorMsg.classList.remove('d-none');
    }
}
</script>

		<!-- Success Modal -->
		<div class="modal fade" id="success-modal-adding" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-body text-center font-18">
							<h3 class="mb-20">Form Submitted!</h3>
							<div class="mb-30 text-center">
								<img src="vendors/images/success.png" />
							</div>
							Student and guardian added successfully!
						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
						</div>
					</div>
				</div>
			</div>

            <!-- Error Modal -->
                            <div
                                class="modal fade"
                                id="error-modal-1"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="errorModalLabel"
                                aria-hidden="true"
                            >
                                <div
                                    class="modal-dialog modal-dialog-centered"
                                    role="document"
                                >
                                    <div class="modal-content">
                                        <div class="modal-body text-center font-18">
                                            <h3 class="mb-20">Faild To Add </h3>
                                            <p id="error-modal-message">Student Id Is Already Exist, Please Enter a Different ID</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button
                                                type="button"
                                                class="btn btn-danger"
                                                data-dismiss="modal"
                                            >
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            

                            
<script>
function checkStudentID() {
    let studentID = document.getElementById("addStudentID").value;
    let errorText = document.getElementById("studentIdError");
    let errorIcon = document.getElementById("studentIdIcon");
    let submitButton = document.getElementById("addStudentBtn");

    if (studentID.trim() === "") {
        errorText.textContent = "";
        errorIcon.style.display = "none"; // Hide icon
        submitButton.disabled = true; // Disable submit if input is empty
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check_student_id.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "exists") {
                errorText.textContent = "Student ID already exists!";
                errorIcon.innerHTML = "❌"; // Set the icon to error
                errorIcon.style.color = "red";
                errorIcon.style.display = "inline"; // Show the icon
                submitButton.disabled = true; // Prevent form submission
            } else {
                errorText.textContent = "";
                errorIcon.innerHTML = "✅"; // Set the icon to success
                errorIcon.style.color = "green";
                errorIcon.style.display = "inline"; // Show the icon
                submitButton.disabled = false; // Allow form submission
            }
        }
    };

    xhr.send("student_id=" + studentID);
}


function toggleLicenceFields() {
    const hasVehicle = document.getElementById("hasVehicle").checked;
    const licenceFields = document.getElementById("licenceFields");
    const licenceInput = document.getElementById("addLicence");
    const registrationInput = document.getElementById("addLicenceRegistration");

    if (hasVehicle) {
        licenceFields.style.display = "block";
        licenceInput.value = "";
        registrationInput.value = "";
    } else {
        licenceFields.style.display = "none";
        licenceInput.value = "N/A";
        registrationInput.value = "N/A";
    }
}

// Run on page load in case of preselection
document.addEventListener("DOMContentLoaded", toggleLicenceFields);

</script>


