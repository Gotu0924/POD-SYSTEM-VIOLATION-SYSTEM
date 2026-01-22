<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// If logged in, show the student dashboard
//echo "Welcome, " . htmlspecialchars($_SESSION['student_id']) . "!";

// Check for connection errors
include '../includes/db_connection.php';
// Get student ID from the session
$student_id = $_SESSION['student_id'];

// Fetch student details from the database
$sql = "SELECT * FROM t_students WHERE st_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    // If no student data found, you may want to handle the error
    echo "Student not found.";
    exit;
}

if (isset($_SESSION['student_id']) && !empty($_SESSION['student_id'])) {
    // Include the database connection
    include '../includes/db_connection.php';

    // Get the student ID from the session
    $student_id = $_SESSION['student_id'];

    // Query to fetch the student's image filename based on student ID
    $query = "SELECT s_PicturePath FROM t_students WHERE st_ID = '$student_id'";
    $result = pg_query($conn, $query);

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $student_image = $row['s_PicturePath']; // Assuming 's_PicturePath' contains the relative filename
    } else {
        // Fallback image if no image is found
        $student_image = 'default.png'; // Change to a default image if none exists
    }

    // Close the database connection
    pg_close($conn);
} else {
    // If no student is logged in, you can set a default image or leave it blank
    $student_image = 'default.png'; // Change this as needed
}

?>


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
		<link
			rel="stylesheet"
			type="text/css"
			href="../assets/src/plugins/datatables/css/dataTables.bootstrap4.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="../assets/src/plugins/datatables/css/responsive.bootstrap4.min.css"
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
      /* A universal reset is a great practice to remove all default browser styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box; /* This is crucial. It includes padding and border in the element's total width and height. */
}

/* Ensure the body takes up the entire viewport */
body {
  margin: 0;
  padding: 0;
  width: 100vw; /* Viewport width */
}

/* Make sure the header spans the full width */
.header {
  width: 100%;
  /* Add any other styles you have for your header */

  
}

/* Hide the default dropdown arrow icon */
.dropdown-toggle::after {
    display: none;
}

/* Ensure cursor pointer when hovering over the image */
.user-icon img {
    cursor: pointer;
}

.header-left {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    height: 100%;
    width: auto; /* This removes the fixed 50% width */
}

.profile-modal {
  border-radius: 18px;
  border: none;
}

.profile-header {
  background-color: #0d6efd;
  color: #fff;
  border-top-left-radius: 18px;
  border-top-right-radius: 18px;
  flex-direction: column;
  align-items: center;
  padding: 2rem 1rem 1rem 1rem;
}

.profile-pic {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  border: 4px solid #fff;
  object-fit: cover;
  margin-bottom: 1rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
}

.student-name {
  font-weight: bold;
  margin-bottom: 0.5rem;
  text-align: center;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.3); /* added shadow */
}

.course-of-study {
  display: inline-block;
  background-color: #fff;
  color: #0d6efd;
  padding: 0.3rem 1rem;
  border-radius: 50px;
  font-weight: 500;
  margin-bottom: 0.5rem;
  font-size: 1rem;
  text-align: center;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.2); /* added shadow */
}

.dob {
  font-size: 0.9rem;
  background-color: #e9ecef;
  color: #0d6efd;
  padding: 0.2rem 0.8rem;
  border-radius: 50px;
}

.modal-body {
  padding: 1.5rem 2rem;
}

.profile-info .label {
  font-size: 0.8rem;
  color: #6c757d;
}

.profile-info .value {
  font-weight: 600;
  font-size: 1rem;
}

.modal-footer {
  border-top: none;
  padding: 1rem 2rem;
}

/* Center the navigation links */
.header-right {
    display: flex;
    justify-content: center; /* Center the links horizontally */
    align-items: center; /* Center the links vertically */
    flex-grow: 1; /* Allow the header-right section to take full width */
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 20px; /* Space between the links */
}

.user-info-dropdown {
    margin-left: 20px; /* Adjust this to position the icon perfectly */
}

.nav-link {
    font-size: 16px; /* Adjust the font size */
    color: #333; /* Default color */
    text-decoration: none; /* Remove underline */
    font-weight: 500; /* Optional: make the text bold */
}

/* Hover effect for the links */
.nav-link:hover {
    color: #007bff; /* Change color on hover */
    text-decoration: underline; /* Optional: underline on hover */
}


/* Custom CSS for the Appeal Modal */
#appealModal .modal-content {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

#appealModal .modal-header {
    border-bottom: none;
    padding: 1rem 1rem 0 1rem;
}

#appealModal .modal-body {
    padding: 0;
}

.violation-record-section {
    background-color: #2e7352; /* Dark green-blue background */
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: left;
    padding: 2rem;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

.violation-record-section h4 {
    color: #fff;
    font-size: 1.5rem;
}

.violation-record-section .violation-details p {
    margin-bottom: 0.5rem;
    color: #fff;
    font-size: 1rem;
}

.violation-record-section .violation-details strong {
    font-weight: 600;
}

.appeal-form-section {
    flex: 1;
    padding: 2rem;
    background-color: #f8f9fa; /* Light grey background */
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

.appeal-form-section h4 {
    color: #343a40;
    font-size: 1.5rem;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.btn-primary {
    background-color: #2e7352; /* Match the left section color */
    border-color: #2e7352;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #245a40;
    border-color: #245a40;
}

.form-control:disabled {
    background-color: #e9ecef;
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.flex-column.flex-md-row {
        flex-direction: column;
    }

    .violation-record-section,
    .appeal-form-section {
        border-radius: 0; /* Reset radius on smaller screens */
    }

    .violation-record-section {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .appeal-form-section {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
}

    </style>
	</head>
	<body>
    
		<div class="header">
      <div class="header-left">
          <!-- Add any left-aligned items here if needed -->
      </div>
    <div class="header-right">
    <!-- Text Style Links for Handbook and Violations -->
    <div class="nav-links">
    <a href="../student/student_handbook.php" class="nav-link">Handbook</a>
    <span style="display: inline-block; vertical-align: middle; margin: 0 10px;">
        <img ../assets/src="../assets/../assets/vendors/images/logo.png" style="height: 50px; vertical-align: middle;" />
    </span>
    <a href="../student/student.php" class="nav-link">Violations</a>
</div>


    <!-- User Info Dropdown -->
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
              <span class="user-icon">
                  <img ../assets/src="<?php echo htmlspecialchars($student_image); ?>" alt="User Image" />
              </span>
                <span class="user-name"><?php htmlspecialchars($_SESSION['student_id']); ?></span>
            </a> 
            <!-- Dropdown menu -->
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Medium-modal">
                    <i class="dw dw-user1"></i> Profile
                </a>
                <a class="dropdown-item" href="../auth/logout.php?action=logout">
                    <i class="dw dw-logout"></i> Log Out
                </a>
            </div>
          </div>
</div>

    </div>
</div>

<div class="mobile-menu-overlay"></div> 
<div class="main-container" style="display: flex; justify-content: center; align-items: center; height: 100vh; padding: 30px;">
    <div class="pd-ltr-20 xs-pd-20-10" style="width: 100%; max-width: 1200px;">
        <div class="min-height-200px">
            <!-- Manage Violation Table Start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Violation</h4>
                </div>
                <div class="pb-20">
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-striped nowrap" style="width: 100%;" id="violationTable">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">#</th>
                                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Violation Number</th>
                                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Category</th>
                                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;">Offense Description</th>
                                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;">Suspension Type</th>
                                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Current Status</th>
                                    <th class="datatable-nosort">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="violatointablebody">
                                <!-- Data will be populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Manage Violation Table End -->
        </div>
    </div>
</div>






<!-- Modal Profile Structure -->
<div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content profile-modal">

      <!-- Header Section -->
      <div class="modal-header profile-header">
        <img id="profilePic" class="profile-pic" ../assets/src="../assets/../assets/vendors/images/default-profile.png" alt="Profile Picture">
        <h4 class="student-name" id="studentName"></h4>
        <span class="course-of-study" id="courseOfStudy"></span>
      </div>

      <!-- Body Section -->
      <div class="modal-body">
        <div class="row profile-info">
          <!-- LEFT COLUMN -->
          <div class="col-6">
            <div class="mb-2">
              <div class="label">ID</div>
              <div class="value" id="studentID"></div>
            </div>
            <div class="mb-2">
              <div class="label">Year Level</div>
              <div class="value" id="yearLevel"></div>
            </div>
            <div class="mb-2">
              <div class="label">School Year</div>
              <div class="value" id="schoolYear"></div>
            </div>
            <div class="mb-2">
              <div class="label">Gender</div>
              <div class="value" id="gender"></div>
            </div>
            <div class="mb-2">
              <div class="label">DOB</div>
              <div class="value" id="dob"></div>
            </div>
            <div class="mb-2">
              <div class="label">Address</div>
              <div class="value" id="address"></div>
            </div>
          </div>

          <!-- RIGHT COLUMN -->
          <div class="col-6">
            <div class="mb-2">
              <div class="label">Phone</div>
              <div class="value" id="phoneNumber"></div>
            </div>
            <div class="mb-2">
              <div class="label">Religion</div>
              <div class="value" id="religion"></div>
            </div>
            <div class="mb-2">
              <div class="label">Driver License</div>
              <div class="value" id="licenseStatus"></div>
            </div>
            <div class="mb-2">
              <div class="label">Driver Registration</div>
              <div class="value" id="licenceRegistration"></div>
            </div>
            <div class="mb-2">
              <div class="label">Gmail</div>
              <div class="value" id="gmail"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-primary px-4" data-dismiss="modal">Close</button>
        <button type="button" id="editBtn" class="btn btn-outline-primary px-4">Edit</button>
        <button type="submit" id="saveBtn" class="btn btn-primary px-4 d-none">Save</button>
        <button type="button" id="changePassBtn" class="btn btn-warning px-4 d-none">Change Password</button>
      </div>

    </div>
  </div>
</div>



<!-- The Modal -->
<div class="modal fade" id="appealModal" tabindex="-1" role="dialog" aria-labelledby="appealModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="d-flex flex-column flex-md-row">
                    <!-- Left side: Violation Record -->
                    <div class="violation-record-section p-4 text-white d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="text-center font-weight-bold mb-4">Violation Record</h4>
                            <div class="violation-record-list">
                                <div class="record-item">
                              <strong>Violation Number:</strong>
                              <span id="violationNumberDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Category:</strong>
                              <span id="CategoryDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Offense Description:</strong>
                              <span id="violationOffenseDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Suspension Type:</strong>
                              <span id="violationSuspensionDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Status:</strong>
                              <span id="violationStatusDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Sanctions:</strong>
                              <span id="violationSanctionsDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Recommendation:</strong>
                              <span id="violationRecommendationDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Student ID:</strong>
                              <span id="violationStudentIDDisplay"></span>
                          </div>
                          <hr>
                          <div class="record-item">
                              <strong>Assigned By:</strong>
                              <span id="violationUsernameDisplay"></span>
                          </div>
                          <hr>
                            </div>
                        </div>
                        <div class="text-center mt-auto">
                            <img ../assets/src="../assets/../assets/vendors/images/logo.png" alt="Violation Icon" class="img-fluid" style="width: 130px; height: 130px; filter: drop-shadow(0 0 5px rgba(0,0,0,0.5));">
                        </div>
                    </div>

                    <!-- Right side: Appeal Form -->
                    <div class="appeal-form-section p-4">
                        <h4 class="text-center font-weight-bold mb-4">Submit Appeal</h4>
                            <form id="appealForm" method="POST" enctype="multipart/form-data">
                            <!-- Hidden field for Student ID -->
                            <input type="hidden" id="appealStudentId" name="appealStudentId" value="<?php echo $student['st_ID']; ?>">

                            <!-- Hidden field for Violation Number -->
                            <input type="hidden" id="violation_number" name="violation_number">

                            <div class="form-group">
                                <label for="appealStudentEmail">Your Email</label>
                                <input type="email" class="form-control" id="appealStudentEmail" name="appealStudentEmail" readonly value="<?php echo $student['s_gmail']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="appealStudentName">Your Name</label>
                                <input type="text" class="form-control" id="appealStudentName" name="appealStudentName" readonly value="<?php echo $student['s_Firstname'] . ' ' . $student['s_Middlename'] . ' ' . $student['s_Lastname']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="appealCourse">Course</label>
                                <input type="text" class="form-control" id="appealCourse" name="appealCourse" readonly value="<?php echo $student['s_CourseOfStudy']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="appealYearLevel">Year Level</label>
                                <input type="text" class="form-control" id="appealYearLevel" name="appealYearLevel" readonly value="<?php echo $student['year_level']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="appealMessage">Appeal Message</label>
                                <textarea class="form-control" id="appealMessage" name="appealMessage" rows="4" required placeholder="Enter your appeal message here"></textarea>
                            </div>

                            <!-- File Uploads Row -->
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="appealImages">Upload Images</label>
                                          <input type="file" class="form-control" id="appealImages" name="appealImages[]" accept="image/*" multiple>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="appealVideos">Upload Videos</label>
                                          <input type="file" class="form-control" id="appealVideos" name="appealVideos[]" accept="video/*" multiple>
                                      </div>
                                  </div>
                              </div>


                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-block mt-3" id="submitAppealBtn">Submit Appeal</button>
                        </form>

                        <!-- Placeholder for success/error -->
                        <div id="appealResponse" class="mt-2"></div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Success Modal -->
<div class="modal fade" id="edit-success-modal" tabindex="-1" role="dialog" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Profile Updated Successfully!</h4>
        <p class="mt-3">Your profile has been updated successfully.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Profile Update Failed!</h4>
        <p class="mt-3">Something went wrong while updating your profile.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Success Modal -->
<div class="modal fade" id="appeal-success" tabindex="-1" role="dialog" aria-labelledby="appealSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Appeal Submitted Successfully!</h4>
        <p class="mt-3">The appeal has been successfully submitted.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="appeal-error" tabindex="-1" role="dialog" aria-labelledby="appealErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Appeal Submission Failed!</h4>
        <p class="mt-3">Something went wrong while submitting your appeal.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<style>
/* Custom CSS for the Appeal Modal */
#appealModal .modal-content {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    background-color: #5f89c0ff; /* Matches the right-side background */
}

#appealModal .modal-header {
    border-bottom: none;
    padding: 1rem 1rem 0 1rem;
    background-color: #3a4047ff;
}

#appealModal .modal-header .close {
    color: #fff;
    opacity: 1;
}

#appealModal .modal-body {
    padding: 0;
}

#appealModal .violation-record-section {
    background-color: #ffffffff; /* Teal background */
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: left;
    padding: 2rem;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

#appealModal .violation-record-section h4 {
    color: #000000ff;
    font-size: 1.5rem;
}

#appealModal .violation-record-section .violation-details p {
    margin-bottom: 0.5rem;
    color: #818181ff;
    font-size: 1rem;
}

#appealModal .violation-record-section .violation-details strong {
    font-weight: 600;
}

/* New record style CSS */
#appealModal .violation-record-list {
    width: 100%;
}

#appealModal .record-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    color: #000000ff;
    font-size: 1rem;
}

#appealModal .violation-record-section hr {
    border-color: rgba(2, 2, 2, 0.3);
    margin: 0.25rem 0;
}

/* End of new record style CSS */

#appealModal .appeal-form-section {
    flex: 1;
    padding: 2rem;
    background-color: #5f89c0ff; /* Dark navy blue background */
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

#appealModal .appeal-form-section h4,
#appealModal .appeal-form-section label {
    color: #fff;
    font-weight: 600;
}

#appealModal .form-control {
    background-color: #fff;
    border-radius: 5px;
    border: none;
    color: #000;
}

#appealModal .form-control:disabled {
    background-color: #e9ecef;
    opacity: 1;
}

#appealModal .btn-primary {
    background-color: #ffffffff; /* Match the left section color */
    border-color: #ffffffff;
    font-weight: bold;
    border-radius: 5px;
    color: #000000;
}

#appealModal .btn-primary:hover {
    background-color: #67e65eff;
    border-color: #0b0c0cff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #appealModal .d-flex.flex-column.flex-md-row {
        flex-direction: column;
    }

    #appealModal .violation-record-section,
    #appealModal .appeal-form-section {
        border-radius: 0;
    }

    #appealModal .violation-record-section {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #appealModal .appeal-form-section {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
}

</style>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg border-0" style="border-radius: 15px;">
      <div class="modal-header text-dark" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
        <h5 class="modal-title font-weight-bold" id="changePasswordLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body px-4 py-3">
        <form id="changePasswordForm">
          <!-- Hidden field for student ID -->
          <input type="hidden" id="password_st_ID" value="<?php echo $_SESSION['student_id']; ?>">

          <div class="form-group">
            <label for="currentPassword">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" required>
            <small id="currentPasswordError" class="text-danger"></small>
          </div>

          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
            <small id="newPasswordError" class="text-danger"></small>
          </div>

          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required>
            <small id="confirmPasswordError" class="text-danger"></small>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
        <button type="button" id="submitPasswordBtn" class="btn btn-warning px-4">Update Password</button>
      </div>
    </div>
  </div>
</div>

<!-- modals -->
		<!-- js -->
		<script ../assets/src="../assets/../assets/vendors/scripts/core.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/script.min.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/process.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/layout-settings.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- buttons for Export datatable -->
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/buttons.print.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/buttons.html5.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/buttons.flash.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/pdfmake.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/vfs_fonts.js"></script>
		<!-- Datatable Setting js -->
		<script ../assets/src="../assets/../assets/vendors/scripts/datatable-setting.js"></script>
    <script ../assets/src="../assets/../assets/vendors/st_scripts/students_1.js"></script>
	</body>
</html>
