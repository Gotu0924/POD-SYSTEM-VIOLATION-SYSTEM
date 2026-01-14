<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// If logged in, show the student dashboard
//echo "Welcome, " . htmlspecialchars($_SESSION['student_id']) . "!";

// Check for connection errors
include 'db_connection.php';
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
    include 'db_connection.php';

    // Get the student ID from the session
    $student_id = $_SESSION['student_id'];

    // Query to fetch the student's image filename based on student ID
    $query = "SELECT s_PicturePath FROM t_students WHERE st_ID = '$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $student_image = $row['s_PicturePath']; // Assuming 's_PicturePath' contains the relative filename
    } else {
        // Fallback image if no image is found
        $student_image = 'default.png'; // Change to a default image if none exists
    }

    // Close the database connection
    mysqli_close($conn);
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
			href="vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="vendors/images/favicon-16x16.png"
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
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="vendors/styles/icon-font.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="src/plugins/datatables/css/dataTables.bootstrap4.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="src/plugins/datatables/css/responsive.bootstrap4.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script
			async
			src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
		></script>
		<script
			async
			src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
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
				j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
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
  margi- : 0;
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

    .xs-pd-20-10 {
        padding: 20px 10px; /* More reasonable padding */
    }
}


/* Basic Modal Styling */
.modal-header {
  border-bottom: 1px solid #dee2e6;
  padding: 1rem 1rem;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 500;
  line-height: 1.5;
  color: #212529;
}

.close {
  padding: 1rem 1rem;
  margin: -1rem -1rem -1rem auto;
  background-color: transparent;
  border: 0;
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  opacity: 0.5;
}

.close:hover {
  opacity: 0.75;
}

.modal-body {
  padding: 1rem;
}

.modal-body p {
  margin-bottom: 1rem;
  line-height: 1.6;
}

.modal-body h5 {
  font-size: 1.15rem;
  margin-top: 1.5rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.modal-body h6 {
  font-size: 1rem;
  margin-top: 1rem;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #495057;
}

.modal-body ul {
  padding-left: 2rem;
  margin-bottom: 1rem;
}

.modal-body li {
  margin-bottom: 0.5rem;
}

.mb-10 {
  margin-bottom: 0.625rem !important; /* This is to match the original class name, though a cleaner name might be preferred */
}

.modal-footer {
  border-top: 1px solid #dee2e6;
  padding: 1rem;
  text-align: right;
}

.btn-secondary {
  color: #fff;
  background-color: #6c757d;
  border-color: #6c757d;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
}

.btn-secondary:hover {
  background-color: #5a6268;
  border-color: #545b62;
}

/* Scrollable Content Styling */
.modal-body.scrollable-content {
  max-height: 70vh; /* Adjust this value as needed, e.g., 70% of viewport height */
  overflow-y: auto; /* Enables vertical scrolling when content exceeds max-height */
}

/* Carousel Specific Styling */
.carousel-control-prev,
.carousel-control-next {
  width: 5%; /* Adjust width as needed */
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for arrows */
  border-radius: 0.25rem;
  padding: 0.5rem; /* Add some padding around the icons */
}

.carousel-indicators {
  bottom: -20px; /* Position indicators slightly below the carousel */
}

.carousel-indicators li {
  background-color: #6c757d; /* Indicator color */
}

.carousel-indicators .active {
  background-color: #007bff; /* Active indicator color */
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
    <a href="student_handbook.php" class="nav-link">Handbook</a>
    <span style="display: inline-block; vertical-align: middle; margin: 0 10px;">
        <img src="vendors/images/logo.png" style="height: 50px; vertical-align: middle;" />
    </span>
    <a href="student.php" class="nav-link">Violations</a>
</div>


    <!-- User Info Dropdown -->
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
              <span class="user-icon">
                  <img src="<?php echo htmlspecialchars($student_image); ?>" alt="User Image" />
              </span>
                <span class="user-name"><?php htmlspecialchars($_SESSION['student_id']); ?></span>
            </a> 
            <!-- Dropdown menu -->
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Medium-modal">
                    <i class="dw dw-user1"></i> Profile
                </a>
                <a class="dropdown-item" href="logout.php?action=logout">
                    <i class="dw dw-logout"></i> Log Out
                </a>
            </div>
          </div>
</div>

    </div>
</div>


<!-- Modal Profile Structure -->
<div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content profile-modal">

      <!-- Header Section -->
      <div class="modal-header profile-header">
        <img id="profilePic" class="profile-pic" src="vendors/images/default-profile.png" alt="Profile Picture">
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


<div class="mobile-menu-overlay"></div>
<div class="main-container" style="margin: 0; center; height: 100vh; padding: 75px;">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="product-wrap">
            <div class="product-list">
                <ul class="row" style="display: flex; justify-content: center; flex-wrap: wrap; padding: 0; margin: 0;">
                    <!-- Product 1 - Section 1: Classification of Offenses -->
                    <li class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="product-box" style="text-align: center;">
                            <div class="product-img">
                                <img src="vendors/images/section1.jpg" alt="" />
                            </div>
                            <div class="product-caption">
                                <h4><a>SECTION 1: CLASSIFICATION OF OFFENSES</a></h4>
                                <a href="#section1Modal" data-toggle="modal" class= "btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </li>
                    <!-- Product 2 - Guidelines for Students and Visitors -->
                    <li class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="product-box" style="text-align: center;">
                            <div class="product-img">
                                <img src="vendors/images/section2.jpg" alt="" />
                            </div>
                            <div class="product-caption">
                                <h4><a href="#section2Modal" data-toggle="modal">Guidelines for Students and Visitors</a></h4>
                                
										<div class="price"></div>
                                <a href="#section2Modal" data-toggle="modal" class= "btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </li>
                    <!-- Product 3 - Section 3: Rules and Regulations -->
                    <li class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="product-box" style="text-align: center;">
                            <div class="product-img">
                                <img src="vendors/images/section3.jpg" alt="" />
                            </div>
                            <div class="product-caption">
                                <h4><a href="#section3Modal" data-toggle="modal">Section 3: Rules and Regulations - Reference: (EMC, 2013)</a></h4>
                                <a href="#section3Modal" data-toggle="modal" class= "btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </li>
                    <!-- Product 4 - Duplicate of Product 1 (Section 1) -->
                    <li class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="product-box" style="text-align: center;">
                            <div class="product-img">
                                <img src="vendors/images/section4.jpg" alt="" />
                            </div>
                            <div class="product-caption">
                                <h4><a href="#section4Modal" data-toggle="modal">Rule 2: Punishable Acts and Penalties Cybercrimes</a></h4>
                                <a href="#section4Modal" data-toggle="modal" class= "btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </li>
                    <!-- Product 5 - Duplicate of Product 2 (Guidelines for Students and Visitors) -->
                    <li class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="product-box" style="text-align: center;">
                            <div class="product-img">
                                <img src="vendors/images/section5.jpg" alt="" />
                            </div>
                            <div class="product-caption">
                                <h4><a href="#section5Modal" data-toggle="modal">Section 5. DATA PRIVACY ACT OF 2012 (RA No. 10173)</h4>
            
										<div class="price"></div>
                                  <a href="#section5Modal" data-toggle="modal" class= "btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </li>
                    <!-- Product 6 - Duplicate of Product 3 (Section 3) -->
                    <li class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="product-box" style="text-align: center;">
                            <div class="product-img">
                                <img src="vendors/images/section6.jpg" alt="" />
                            </div>
                            <div class="product-caption">
                                <h4><a href="#section3Modal" data-toggle="modal">SMCBI SEXUAL HARASSMENT POLICIES & PROCEDURES</a></h4>
                                <a href="#section6Modal" data-toggle="modal" class= "btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="section1Modal" tabindex="-1" role="dialog" aria-labelledby="handbookModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="handbookModalLabel">SECTION 1: <strong>CLASSIFICATION OF OFFENSES</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="lead">Students must bear in mind that disciplinary measures are formulated to help attain self-discipline, preserve peace and order, and become responsible persons with Christian ideals and values.</p>

        <div id="offensesCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#offensesCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#offensesCarousel" data-slide-to="1"></li>
            <li data-target="#offensesCarousel" data-slide-to="2"></li>
            <li data-target="#offensesCarousel" data-slide-to="3"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <h5 class="mb-10">1. Offenses</h5>
              <h6 class="font-weight-bold">Category A - Reprimand</h6>
              <ul class="pl-3">
                <li>• Loitering and creating noise or any disturbance in the corridors, stairways when classes are going on.</li>
                <li>• Failure to wear the proper school attire.</li>
                <li>• Shouting, whistling, and unrestrained laughter and loud talking inside the classroom.</li>
                <li>• Unauthorized use of school facilities.</li>
                <li>• Tampering with notices on bulletin boards.</li>
                <li>• Non-payment of school debts (program/club).</li>
                <li>• Wearing of uniform in parks, video game houses, billiard halls, disco places, etc.</li>
              </ul>
              <p>A student may be meted with suspension after three warnings are served for various offenses during his stay in the College Department.</p>
            </div>
            
            <div class="carousel-item">
              <h6 class="font-weight-bold">Category B - Suspension</h6>
              <p>Offenses punishable by suspension:</p>
              <ul class="pl-3">
                <li>• Cheating during tests or examinations.</li>
                <li>• Smoking inside the school premises.</li>
                <li>• Committing acts of vandalism.</li>
                <li>• Gambling of any sort.</li>
                <li>• Drunkenness and possession of liquor.</li>
                <li>• Refusal to wear the school-issued I.D. and the prescribed school uniform while inside the campus.</li>
                <li>• Use of fake and borrowed examination permits and school I.D.</li>
                <li>• Discourtesy to a teacher, school official, or employee of the institution.</li>
                <li>• Possessing pornographic materials within the school premises.</li>
                <li>• Causing public and campus disturbances.</li>
                <li>• Refusing without valid reason to appear before a school official.</li>
                <li>• Initiating a fundraising activity or using the name of the school without approval.</li>
                <li>• Publishing or circulating false information about the school or its faculty.</li>
                <li>• Unauthorized use of the school's name in any public statement.</li>
                <li>• Wearing earrings for male students or more than one pair for female students.</li>
                <li>• Highly colored hair.</li>
                <li>• Desecration of religious images, disrespect to religious practices and national symbols.</li>
                <li>• Malicious activation of fire alarms.</li>
                <li>• Maligning the Catholic Church, its teachings, or practices.</li>
                <li>• Failure to comply with summons or notices for disciplinary investigation.</li>
                <li>• Exhibiting nudity or explicit content on social media.</li>
                <li>• Cyberbullying.</li>
                <li>• Participating in beauty contests wearing inappropriate attire.</li>
                <li>• Other acts analogous to the above.</li>
              </ul>
            </div>

            <div class="carousel-item">
              <h6 class="font-weight-bold">Category C - Expulsion</h6>
              <p>Offenses punishable by expulsion:</p>
              <ul class="pl-3">
                <li>• Assaulting a teacher or any school authority.</li>
                <li>• Carrying and concealing deadly weapons.</li>
                <li>• Extortion or asking for money from others.</li>
                <li>• Fighting and causing injury to others.</li>
                <li>• Using, possessing, or selling prohibited drugs.</li>
                <li>• Engaging in immoral acts such as premarital sexual relations resulting in pregnancy.</li>
                <li>• Instigating, leading, or participating in activities leading to class stoppage.</li>
                <li>• Threatening school authorities or faculty.</li>
                <li>• Forging or tampering with school records.</li>
                <li>• Hazing or recruiting for organizations involved in hazing.</li>
                <li>• Drug addiction.</li>
                <li>• Participating in strikes and demonstrations causing school disruptions.</li>
                <li>• Stealing school property.</li>
                <li>• Misuse of school documents.</li>
                <li>• Destruction or damage of school property.</li>
                <li>• Libel or defamation against faculty or students.</li>
                <li>• Possession or distribution of subversive materials.</li>
                <li>• Conviction for a criminal offense.</li>
                <li>• Any other crime or misdemeanor deemed serious by the Student Disciplinary Board.</li>
              </ul>
            </div>

            <div class="carousel-item">
              <h5 class="mb-10">2. Sanctions</h5>

              <p><strong>a. Major Offense</strong><br>
                <strong>Exclusion</strong> This is the dropping of a student from the school rolls in a semester, two semesters or both, or for the whole school year. Transfer credentials are immediately issued. Excluding a student for two times may lead to his/her expulsion.<br></p>

              <p><strong>b. Minor Offense</strong><br>
                <strong>1. Reprimand</strong> This is a written warning to the erring student that a commission of a similar offense in the future shall be dealt with severely.<br><br>

                <strong>2. Suspension</strong> This is the deprivation of an erring student to attend classes for a period of not exceeding 20% of the prescribed school days for a semester.<br>
                a.<strong> First Offense:</strong> Submission of letter of apology and short interview/counseling session.<br>
                b.<strong> Second Offense:</strong> Suspension for one to two days and counseling session at least twice.<br>
                c.<strong>Third Offense:</strong> Suspension for two to four days, counseling session at least five times and community service may be given in the following forms of work.<br>
                • Cleaning the school grounds, offices, CRS, canteen<br>
                • Painting the walls of CRs, classrooms or offices<br>
                • Assisting the librarian, Prefect of Discipline, Guidance Counselor in some routine work<br>
                • Making research on reaction papers<br>
                • Fixing chairs or doing simple carpentry works<br>
                • Gardening<br>
                • Digging a hole/canal in the campus<br>
                <strong>Note:</strong><br>
                The student will be disqualified from holding or seeking any position in any school organization.<br>
                If a student is suspended for the fourth time for the same offense, his/her violation will lead to exclusion.<br><br>

                <strong>3. Determining the violation</strong><br>
                a. The faculty members have the right to evaluate and censure their students for any minor violations.<br>
                b. With regard to academic matters, the Dean of College in coordination with the Program Head assumes the responsibility of determining the nature of the offense committed by the student.<br>
                c. The Student Disciplinary Board, upon the recommendation of the Prefect of Discipline, shall have the duty to hear and decide the cases. The decision of the Board may be appealed to the Office of the School President.<br>
                d. The evaluation of the violation will be based on the mitigating and aggravating circumstances and evidence to be determined by the Prefect of Discipline.<br><br>

                <strong>4. Jurisdiction of the Cases</strong><br>
                a. Academic problems: Office of the Dean of College.<br>
                b. Faculty problems: Office of the Dean of College.<br>
                c. Non-academic and other problems of students: Office of the Prefect of Discipline.<br><br>

                <strong>5. Student Disciplinary Board</strong><br>
                <strong>a. Functions and duties</strong><br>
                1. Investigates cases referred by the Prefect of Discipline and within its jurisdiction<br>
                2. Recommends sanctions for the accused to the President of the school<br>
                3. Submits policy recommendations (crafting, innovation, improvement) to the School President pertaining to student discipline and decorum of the school.<br><br>

                <strong>b. Composition</strong><br>
                1. Prefect of Discipline as Chairperson<br>
                2. Dean of College as (Vice-Chairperson)<br>
                3. Christian Formation Coordinator<br>
                4. Representative from the faculty<br>
                5. Representative from the Non-teaching staff<br>
                6. Guidance Counselor<br>
                7. Student Executive Board President or his/her representative<br><br>

                <strong>6. Procedural Due Process</strong><br>
                a. The student must be informed in writing of the nature and cause of the accusations against him/her.<br>
                b. The student must be informed of his/her right to answer the charges against him/her, with the assistance of counsel, if desired.<br>
                c. The student must be told of the evidence against him/her.<br>
                d. The student must be told of his/her right to present evidence on his/her behalf.<br>
                e. Evidence must be considered by the student disciplinary board.<br>
                f. Upon completion of the investigation, the student must be informed about the findings and recommendations of the members of the board. He/she must also be informed of his/her right to make an appeal about the decision to be submitted to the School President. If a student is a minor, his/her parents are required to attend during the hearing and other meetings. If the student is of legal age, his/her parents can participate in the hearing and investigation upon request and with the approval of the student.<br>

            </div>

          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Structure 2 -->
<div class="modal fade" id="section2Modal" tabindex="-1" role="dialog" aria-labelledby="studentGuidelinesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentGuidelinesModalLabel"><strong>Guidelines for Students and Visitors</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="mb-3 font-weight-bold">A. Guidelines for Students</h5>
                <ul class="pl-3">
                    <li><b>1.</b> All students are required to wear complete school uniforms and wear their IDs at all times while in school. Students with incomplete uniforms (no ID, colored shirts, and sandals) are not allowed to enter the school campus.</li>
                    <li><b>2.</b> School bags and other personal belongings are the responsibilities of the students and not the security guard. The guards are not allowed to keep for safety things of the students and personnel in the guard house. However, security guards are authorized to inspect school bags and other belongings if necessary.</li>
                    <li><b>3.</b> The security guard may not allow entrance, at any time, any person with no proper identification and/or official business appointment with any school official, faculty, or student.</li>
                </ul>

                <h5 class="mb-3 font-weight-bold">B. Guidelines for Visitors</h5>
                <ul class="pl-3">
                    <li><b>1.</b> Visitors shall sign the visitor's logbook and wear the visitor's ID.</li>
                    <li><b>2.</b> Boxes/Packages are subject to inspections and shall be submitted when requested by the guards.</li>
                    <li><b>3.</b> Visitors can transact business only in office or with the person indicated in the Visitor's ID. They are not allowed to enter the classrooms or loiter along the corridors.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Section 3: Rules and Regulations -->
<div class="modal fade" id="section3Modal" tabindex="-1" aria-labelledby="section3ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section3ModalLabel">Section 3: <strong>Rules and Regulations - Reference: (EMC, 2013)</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Carousel -->
        <div id="rulesCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#rulesCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#rulesCarousel" data-slide-to="1"></li>
          </ol>
          <div class="carousel-inner">
            <!-- Slide 1: First 4 items -->
            <div class="carousel-item active">
              <h6 class="font-weight-bold">A. INTRODUCTION</h6>
              <p>ST. MARY'S COLLEGE OF BANSALAN, INC. is committed to providing a caring, friendly, safe, and healthy learning environment. Accordingly, the School has a zero-tolerance policy for bullying that infringes on the safety and health of any student.</p>
              <p>All members of the School community collaboratively work together to make the School a happy and secure place. The School supports the Convention on the Rights of the Child (CRC) and follows Republic Act No. 10627 (Anti-Bullying Act of 2013) through its Child Protection Committee.</p>
              
              <h6 class="font-weight-bold">B. FORMS OF BULLYING</h6>
              <p>Bullying includes but is not limited to:</p>
              <ul class="pl-3">
                <li>• Physical aggression such as punching, pushing, or using objects as weapons.</li>
                <li>• Psychological harm, including name-calling and slanderous statements.</li>
                <li>• Cyberbullying through electronic means.</li>
              </ul>

              <h6 class="font-weight-bold">C. OBJECTIVES OF THE POLICY</h6>
              <ul class="pl-3">
                <li>• Increase awareness of bullying effects.</li>
                <li>• Improve student discipline.</li>
                <li>• Enhance teacher's classroom management.</li>
                <li>• Boost parental involvement in school activities.</li>
              </ul>

              <h6 class="font-weight-bold">D. FOCUS OF THE POLICY</h6>
              <p>Professional development and training for all stakeholders in:</p>
              <ul class="pl-3">
                <li>• Student leadership and service learning.</li>
                <li>• Faculty training for homeroom programs.</li>
                <li>• Family enrichment programs.</li>
                <li>• Anti-bullying week advocacies.</li>
              </ul>
            </div>

            <!-- Slide 2: Next 3 items -->
            <div class="carousel-item">
              <h6 class="font-weight-bold">E. THE YOUTH PROTECTION COMMITTEE</h6>
              <p>The committee promotes a zero-tolerance policy and consists of:</p>
              <ul class="pl-3">
                <li>• Dean of College</li>
                <li>• Program Heads/Coordinators</li>
                <li>• Guidance Counselor</li>
                <li>• Coordinator of Student Affairs and Discipline</li>
              </ul>

              <h6 class="font-weight-bold">F. FUNCTIONS OF THE COMMITTEE</h6>
              <ul class="pl-3">
                <li>• Draft and review child protection policies.</li>
                <li>• Organize anti-bullying activities.</li>
                <li>• Establish referral and monitoring systems.</li>
                <li>• Coordinate with authorities on child protection.</li>
              </ul>

              <h6 class="font-weight-bold">G. PROCEDURES FOR DISCIPLINARY ACTION</h6>
              <ul class="pl-3">
                <li>• Incident reporting and investigation.</li>
                <li>• Informing parents/guardians of involved parties.</li>
                <li>• Disciplinary measures in compliance with due process.</li>
                <li>• Implementation of intervention programs.</li>
              </ul>

              <h6 class="font-weight-bold">H. BULLYING INCIDENT HANDLING PROCEDURES</h6>
              <ol class="pl-3">
                <li>• Incident Register - Staff records details of the incident.</li>
                <li>• Reports - Witnesses complete a standardized form.</li>
                <li>• Follow-up - Counseling and monitoring of affected students.</li>
                <li>• Warning - Written notice to repeat offenders.</li>
                <li>• Parent Intervention - Meeting with parents for serious cases.</li>
                <li>• Final Measures - Disciplinary actions recorded by the Prefect of Discipline.</li>
              </ol>
            </div>
          </div>

          <!-- Carousel Controls -->
          <a class="carousel-control-prev" href="#rulesCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#rulesCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Section 4: Rules and Regulations -->
<div class="modal fade" id="section4Modal" tabindex="-1" aria-labelledby="section4ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section4ModalLabel">Rule 2: <strong>Punishable Acts and Penalties Cybercrimes</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="mb-3 font-weight-bold">Section 4. Cybercrime Offenses</h5>
        <p>The following acts constitute the offense of core cybercrime punishable under the Act:</p>

        <h5 class="font-weight-bold">A. Offenses Against the Confidentiality, Integrity, and Availability of Computer Data and Systems</h5>
        <p>Shall be punished with imprisonment of prison mayor or a fine of at least Two Hundred Thousand Pesos (P200,000.00) up to a maximum amount commensurate to the damage incurred, or both, except with respect to number 5 herein:</p>
        <ul class="pl-3">
          <li>1. Illegal Access</li>
          <li>2. Illegal Interception</li>
          <li>3. Data Interference</li>
          <li>4. System Interference</li>
        </ul>

        <h5 class="font-weight-bold">B. Computer-related Offenses</h5>
        <p>Shall be punished with imprisonment of prison mayor, or a fine of at least Two Hundred Thousand Pesos (P200,000.00) up to a maximum amount commensurate to the damage incurred, or both. The following offenses fall under this category:</p>
        <ul class="pl-3">
          <li>1. Computer-related Forgery</li>
          <li>2. Computer-related Fraud</li>
          <li>3. Computer-related Identity Theft</li>
        </ul>

        <h5 class="font-weight-bold">C. Content-related Offenses</h5>
        <p>Any person found guilty of Child Pornography shall be punished in accordance with the penalties set forth in Republic Act No. 9775 or the "Anti-Child Pornography Act of 2009". Provided that the penalty to be imposed shall be one (1) degree higher than that provided for in Republic Act No. 9775 if committed through a computer system.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Section 5: Data Privacy Act of 2012 (RA No. 10173) -->
<div class="modal fade" id="section5Modal" tabindex="-1" aria-labelledby="section5ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section5ModalLabel">Section 5. <strong>DATA PRIVACY ACT OF 2012 (RA No. 10173)</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="font-weight-bold">1. Informational Privacy</h6>
        <p>Informational privacy refers to privacy interests in precluding the dissemination or misuse of sensitive and confidential information. Personal information is defined as "any information from which the identity of an individual is apparent or can be directly ascertained by the entity holding the information." The DPA further recognizes a special category of personal information entitled to a heightened degree of protection (and correspondingly, steeper sanctions), namely, "Sensitive Personal Information" which includes, among other things, information about a person's marital status, age, color, religious affiliation, health, education, as well as "any proceeding for any offense committed or alleged to have been committed by such person, or the sentence."</p>

        <h5 class="font-weight-bold">2. A School as a Personal Information Controller</h5>
        <p>A school is a personal information controller under the DPA as it processes personal information by collecting, organizing, recording, entering, storing, using, accessing, or sharing such personal information in their computer systems. The DPA imposes severe penal sanctions on any person or entity that violates its provisions either knowingly or through negligence. The DPA defines and penalizes various types of conduct in regard to personal information such as:</p>
        
        <ul class="pl-3">
          <li><b>1.</b> All students are required to wear complete school uniforms and wear their IDs at all times while in school. Students with incomplete uniforms (no ID, colored shirts, and sandals) are not allowed to enter the school campus.</li>
          <li><b>2.</b> School bags and other personal belongings are the responsibilities of the students and not the security guard. The guards are not allowed to keep for safety things of the students and personnel in the guard house. However, security guards are authorized to inspect school bags and other belongings if necessary.</li>
          <li><b>3.</b> The security guard may not allow entrance, at any time, any person with no proper identification and/or official business appointment with any school official, faculty, or student of any court in such proceedings.</li>
        </ul>

        <h5 class="font-weight-bold">B. Guidelines for Visitors</h5>
        <ul class="pl-3">
          <li><b>1.</b> Visitors shall sign the visitor's logbook and wear the visitor's ID.</li>
          <li><b>2.</b> Boxes/Packages are subject to inspections and shall be submitted when requested by the guards.</li>
          <li><b>3.</b> Visitors can transact business only in the office or with the person indicated in the Visitor's ID. They are not allowed to enter the classrooms or loiter along the corridors.</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Section 6: Sexual Harassment Policies & Procedures -->
<div class="modal fade" id="section6Modal" tabindex="-1" role="dialog" aria-labelledby="section6Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="section6Modal">SMCBI SEXUAL HARASSMENT POLICIES & PROCEDURES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Carousel -->
                <div id="sexualHarassmentCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#sexualHarassmentCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#sexualHarassmentCarousel" data-slide-to="1"></li>
                        <li data-target="#sexualHarassmentCarousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <!-- Slide 1: Introduction, Institution Policy -->
                        <div class="carousel-item active">
                            <ul>
                                <li><b>•</b>Pursuant to the provisions of Section 4, Republic Act 7877, An Act Declaring Sexual Harassment Unlawful in the Employment, Education or Training Environment, and For Other Purposes, the following policies and procedures are hereby issued by St. Mary's College of Bansalan to prevent sexual harassment and to guarantee full respect for human rights and uphold the dignity of employees, students, and others.</li>
                                <li><b>•</b>School bags and other personal belongings are the responsibilities of the students and not the security guard. The guards are not allowed to keep for safety things of the students and personnel in the guard house. However, security guards are authorized to inspect school bags and other belongings if necessary.</li>
                            </ul>
                            <h5 class="mb-3">INSTITUTION POLICY AGAINST SEXUAL HARASSMENT</h5>
                            <ul>
                                <li><b>•</b><b>St. Mary's College of Bansalan </b> is committed to ensuring that the workplace, training, and education environment is free from sexual harassment. Sexual harassment is a form of misconduct that undermines employment and/or educational relationships. No employee or student, either male or female, should be subjected verbally or physically to unsolicited and unwelcome sexual overtures or conduct.</li>
                            </ul>
                        </div>

                        <!-- Slide 2: Definition of Sexual Harassment -->
                        <div class="carousel-item">
                            <h5 class="mb-3">A. DEFINITION OF SEXUAL HARASSMENT</h5>
                            <ul>
                                <li><b>•</b><b>St. Mary's College of Bansalan </b> has adopted and its policy is based on the definition of sexual harassment set forth in <b>Section 3 or R.A. 7877.</b></li>
                                <li><b>•</b> In a work-related or employment environment, sexual harassment is committed when:</li>
                            </ul>
                            <ul style="list-style-type: none;">
                                <li><b>1.</b> The submission to or rejection of the act or series of acts is used as basis for any employment decision (including but not limited to, matters related to hiring, promotion, raises in salary, job security, benefits and any other personnel action) affecting the applicant/employee;</li>
                                <li><b>2.</b> The act or series of acts have the purpose or effect of interfering with complainant's work performance, or creating an intimidating, hostile or offensive work environment;</li>
                                <li><b>3.</b> The act or series of acts might reasonably be expected to cause discrimination, insecurity, discomfort, offense, or humiliation to a complainant who may be a trainee, apprentice, intern, tutee or ward of the person complained of.</li>
                            </ul>
                            <h5 class="mb-3"><b>•</b> In an education or training environment, sexual harassment is committed when:</h5>
                            <ul>
                                <li><b>1.</b> The submission to or rejection of the act or series of acts is used as a basis for any decision affecting the complainant, including, but not limited to, the giving of a grade, the granting of honors or a scholarship, or any benefit;</li>
                                <li><b>2.</b> The act or series of acts have the purpose or effect of interfering with the performance, or creating an intimidating, hostile or offensive academic environment of the complainant;</li>
                                <li><b>3.</b> The act or series of acts might reasonably be expected to cause discrimination, insecurity, discomfort, offense, or humiliation to a complainant.</li>
                            </ul>
                        </div>

                        <!-- Slide 3: Where and Forms of Sexual Harassment -->
                        <div class="carousel-item">
                            <h5 class="mb-3">B. WHERE SEXUAL HARASSMENT IS COMMITTED</h5>
                            <p><b>Sexual harassment may be committed in any work, training, or education environment. It may include, but not be limited to the following:</b></p>
                            <ol>
                                <li><b>1.</b> In or outside the office building, classroom, or training site;</li>
                                <li><b>2.</b> At office, or training, or education-related social functions;</li>
                                <li><b>3.</b> In the course of work assignments outside the office;</li>
                                <li><b>4.</b> At work-related conferences, studies or training sessions;</li>
                                <li><b>5.</b> During work, education related travel.</li>
                            </ol>

                            <h5 class="mb-3">C. FORMS OF SEXUAL HARASSMENT</h5>
                            <p><b>Sexual harassment may be committed in any of the following forms:</b></p>
                            <ol>
                                <li><b>1.</b> Physical:
                                    <ul style="list-style-type: lower-alpha;">
                                        <li>Malicious touching;</li>
                                        <li>Overt sexual advances;</li>
                                        <li>Unwelcome or improper gestures of affection;</li>
                                        <li>Any other act or conduct of a sexual nature, or for the purpose of sexual gratification which is generally annoying, disgusting or offensive to the victim.</li>
                                    </ul>
                                </li>
                                <li><b>2.</b> Verbal such as request or demand for sexual favors including but not limited to going out on dates, outings, fieldtrips, or the like for the same purpose, and lurid remarks.</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Carousel Controls -->
                    <a class="carousel-control-prev" href="#sexualHarassmentCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#sexualHarassmentCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



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
          <input type="hidden" id="password_st_ID"> <!-- Auto-filled with student ID -->

          <div class="form-group">
            <label for="currentPassword">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password">
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





		<!-- js -->
		<script src="vendors/scripts/core.js"></scrip>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- buttons for Export datatable -->
		<script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
		<script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
		<script src="src/plugins/datatables/js/buttons.print.min.js"></script>
		<script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
		<script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
		<script src="src/plugins/datatables/js/pdfmake.min.js"></script>
		<script src="src/plugins/datatables/js/vfs_fonts.js"></script>
		<!-- Datatable Setting js -->
		<script src="vendors/scripts/datatable-setting.js"></script>
		
    <script src="vendors/st_scripts/students_1.js"></script>
	</body>
</html>
