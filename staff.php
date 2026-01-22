<?php
include 'includes/sessioning.php';
?>

<!DOCTYPE html>

<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>DAMS</title>
        <?php include 'parts/links.php' ?>
	</head>

    <body>
		<?php include 'parts/header_staff.php'?>
        <div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<!-- Data Table with multiple select row start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">View Students</h4>
					</div>
					<div class="pb-20">
						<div style="overflow-x: auto; width: 100%;">
							<table class="table table-striped nowrap" style="border-collapse: collapse; width: 100%; min-width: 1200px;" id="studentTable">
								<thead>
									<tr>
                                    <th class="table-plus datatable-nosort">#</th>
                                        <th style="border: 1px solid #ddd; padding: 12px;  min-width: 140px; ">Student Picture</th>
                                        <th style="border: 1px solid #ddd; padding: 12px;  ">Name</th>
                                        <th style="border: 1px solid #ddd; padding: 12px;  ">Student ID</th>
                                        <th style="border: 1px solid #ddd; padding: 12px;  ">Course</th>
                                        <th style="border: 1px solid #ddd; padding: 12px;  ">Year/Level</th>
                                        <th style="border: 1px solid #ddd; padding: 12px;  ">Action</th>
									</tr>
								</thead>
								<tbody id="studentTableBody">
									<!-- Rows will be populated here dynamically -->
								</tbody>
							</table>
						</div>
					</div>
                    <!-- Data Table with multiple select row start -->
				</div>
			</div>
            
<!--  Modal -->





<div class="modal fade" id="small-modal" tabindex="-1" role="dialog" aria-labelledby="addSanctionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSanctionLabel">Add New Violation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                  <form id="sanctionForm" method="POST" action="sanctions/send_sanction.php">
                    <div class="form-group">
                        <label for="st_ID">Student ID</label>
                        <input type="text" id="st_ID" class="form-control" name="st_ID" readonly />
                    </div>
                    <div class="form-group">
                        <label for="i_Category">Category</label>
                        <select class="form-control" id="i_Category" name="i_Category" required onchange="populateOffensesadd(); validateCategory();">
                            <option value="">Select Category</option>
                            <option value="Category A">Category A</option>
                            <option value="Category B">Category B</option>
                            <option value="Category C">Category C</option>
                        </select>
                        <div class="invalid-feedback" id="invalidCategory" style="display: none;">
                            Please select a category.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="list_Offense">Offense</label>
                        <select class="form-control" id="list_Offense" name="list_Offense" required onchange="validateOffense()">
                            <option value="">Select Offense</option>
                        </select>
                        <div class="invalid-feedback" id="invalidOffense" style="display: none;">
                            Please select an offense.
                        </div>
                    </div>

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

                    <div class="form-group">
                        <label for="i_Details">Details</label>
                        <textarea class="form-control" id="i_Details" name="i_Details" rows="3" required oninput="validateDetails()"></textarea>
                        <div class="invalid-feedback" id="invalidDetails" style="display: none;">
                            Please provide details of the violation.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="i_Recommendation">Recommendation</label>
                        <input type="text" class="form-control" id="i_Recommendation" name="i_Recommendation" required oninput="validateRecommendation()">
                        <div class="invalid-feedback" id="invalidRecommendation" style="display: none;">
                            Please provide a recommendation.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sent_by">Sent By</label>
                        <input type="text" class="form-control" id="sent_by" name="sent_by" 
                            value="<?php echo htmlspecialchars($_SESSION['id'] ?? ''); ?>" 
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="i_Status">Status</label>
                        <select class="form-control" id="i_Status" name="i_Status" required onchange="validateStatus()">
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                        </select>
                        <div class="invalid-feedback" id="invalidStatus" style="display: none;">
                            Please select a status.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Sanction</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="edit-success-modal" tabindex="-1" role="dialog" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Violation Sent Successfully!</h4>
        <p class="mt-3">The student Violation has been saved.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Violation record Failed!</h4>
        <p class="mt-3">Something went wrong while sending the student Violation.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



    <script>
    // Define the offenses for each category
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

// Function to populate offenses based on category
function populateOffensesadd() {
    const category = document.getElementById('i_Category').value;
    const offenseSelect = document.getElementById('list_Offense');
    offenseSelect.innerHTML = '<option value="">Select Offense</option>'; // Reset options

    // Populate offenses based on the selected category
    if (offenses[category]) {
        offenses[category].forEach(offense => {
            offenseSelect.innerHTML += `<option value="${offense}">${offense}</option>`;
        });
    }
    
    validateOffense(); // Validate after populating
}


    // Function to toggle suspension type visibility
function toggleSuspensionTypeadd() {
    const sanctionType = document.getElementById('i_Sanctions').value;
    const suspensionTypeGroup = document.getElementById('suspensionTypeGroup');
    const suspensionTypeInput = document.getElementById('Suspension_Type');
    const suspensionTypeHidden = document.getElementById('Suspension_Type_Hidden');

    // Check if the selected sanction type is "Suspension"
    if (sanctionType === 'Suspension') {
        suspensionTypeGroup.style.display = 'block';
        suspensionTypeInput.setAttribute('required', 'true');
        suspensionTypeHidden.value = ''; // Reset to empty if Suspension is chosen
    } else {
        suspensionTypeGroup.style.display = 'none';
        suspensionTypeInput.removeAttribute('required');
        suspensionTypeInput.value = ''; // Clear selection
        suspensionTypeHidden.value = 'N/A'; // Set to "N/A" when Reprimand or Exclusion is chosen
    }

    // Validate suspension type after toggling
    validateSuspensionType();
}


    // --- Validation Functions ---

    function validateStudentID() {
        const studentIDInput = document.getElementById('s_ID');
        const studentID = studentIDInput.value;
        const invalidFeedback = document.getElementById('invalidStudentID');
        const addViolationButton = document.getElementById('addViolationButton');

        if (studentID === '') {
            invalidFeedback.textContent = 'Student ID is required.';
            invalidFeedback.style.display = 'block';
            studentIDInput.classList.add('is-invalid');
            return false;
        }

        if (!/^\d{7}$/.test(studentID)) {
            invalidFeedback.textContent = 'Student ID must be exactly 7 digits.';
            invalidFeedback.style.display = 'block';
            studentIDInput.classList.add('is-invalid');
            return false;
        }

        // Perform AJAX request to check if Student ID exists in the database
        // Assuming you have a PHP file 'student/check_student_ids.php' that checks existence
        $.ajax({
            url: 'student/check_student_ids.php',
            method: 'POST',
            data: { student_id: studentID },
            success: function(response) {
                if (response === 'exists') {
                    invalidFeedback.style.display = 'none';
                    studentIDInput.classList.remove('is-invalid');
                    studentIDInput.classList.add('is-valid');
                    validateForm(); // Re-validate the whole form
                    return true;
                } else {
                    invalidFeedback.textContent = 'Student ID does not exist.';
                    invalidFeedback.style.display = 'block';
                    studentIDInput.classList.add('is-invalid');
                    validateForm(); // Re-validate the whole form
                    return false;
                }
            },
            error: function() {
                invalidFeedback.textContent = 'Error checking Student ID. Please try again.';
                invalidFeedback.style.display = 'block';
                studentIDInput.classList.add('is-invalid');
                validateForm(); // Re-validate the whole form
                return false;
            }
        });
        return false; // Default to false while AJAX is pending
    }

    function validateCategory() {
        const categoryInput = document.getElementById('i_Category');
        const invalidFeedback = document.getElementById('invalidCategory');
        if (categoryInput.value === '') {
            invalidFeedback.textContent = 'Please select a category.';
            invalidFeedback.style.display = 'block';
            categoryInput.classList.add('is-invalid');
            return false;
        } else {
            invalidFeedback.style.display = 'none';
            categoryInput.classList.remove('is-invalid');
            categoryInput.classList.add('is-valid');
            return true;
        }
    }

    function validateOffense() {
        const offenseInput = document.getElementById('list_Offense');
        const invalidFeedback = document.getElementById('invalidOffense');
        if (offenseInput.value === '') {
            invalidFeedback.textContent = 'Please select an offense.';
            invalidFeedback.style.display = 'block';
            offenseInput.classList.add('is-invalid');
            return false;
        } else {
            invalidFeedback.style.display = 'none';
            offenseInput.classList.remove('is-invalid');
            offenseInput.classList.add('is-valid');
            return true;
        }
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

        if (suspensionTypeGroup.style.display !== 'none') { // Only validate if visible
            if (suspensionTypeInput.value === '') {
                invalidFeedback.textContent = 'Please select a suspension type.';
                invalidFeedback.style.display = 'block';
                suspensionTypeInput.classList.add('is-invalid');
                return false;
            } else {
                invalidFeedback.style.display = 'none';
                suspensionTypeInput.classList.remove('is-invalid');
                suspensionTypeInput.classList.add('is-valid');
                // Update hidden field when a valid selection is made
                document.getElementById('Suspension_Type_Hidden').value = suspensionTypeInput.value;
                return true;
            }
        }
        return true; // Return true if the section is hidden
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

    // Check all individual validation functions
    if (!validateStudentID()) isFormValid = false;
    if (!validateCategory()) isFormValid = false;
    if (!validateOffense()) isFormValid = false;
    if (!validateSanctionType()) isFormValid = false;
    if (!validateSuspensionType()) isFormValid = false; // This will only check if the section is visible
    if (!validateDetails()) isFormValid = false;
    if (!validateRecommendation()) isFormValid = false;
    if (!validateStatus()) isFormValid = false;

    return isFormValid;
}


    // --- Event Listeners ---

    // Add event listeners to all relevant input/select fields
    document.getElementById('s_ID').addEventListener('blur', validateStudentID);
    document.getElementById('i_Category').addEventListener('change', () => { populateOffensesadd(); validateCategory(); });
    document.getElementById('list_Offense').addEventListener('change', validateOffense);
    document.getElementById('i_Sanctions').addEventListener('change', () => { toggleSuspensionTypeadd(); validateSanctionType(); });
    document.getElementById('Suspension_Type').addEventListener('change', validateSuspensionType);
    document.getElementById('i_Details').addEventListener('input', validateDetails);
    document.getElementById('i_Recommendation').addEventListener('input', validateRecommendation);
    document.getElementById('i_Status').addEventListener('change', validateStatus);


    // On Modal Open, validate the Student ID field immediately and the whole form
    $('#addSanctionModal').on('show.bs.modal', function () {
        validateStudentID(); // Initial validation for student ID
        validateForm();      // Validate the whole form on show
        // Set default values for select elements if they are empty
        if (document.getElementById('i_Category').value === '') document.getElementById('i_Category').value = '';
        if (document.getElementById('list_Offense').value === '') document.getElementById('list_Offense').value = '';
        if (document.getElementById('i_Sanctions').value === '') document.getElementById('i_Sanctions').value = '';
        if (document.getElementById('i_Status').value === '') document.getElementById('i_Status').value = '';
        // Ensure suspension type is handled correctly on open
        toggleSuspensionTypeadd();
    });

    // Prevent closing the modal if the form is not valid on hide
    $('#addSanctionModal').on('hide.bs.modal', function (e) {
        // You might want to add a confirmation dialog here if the form is dirty
        // For now, we'll just ensure the button is correctly enabled/disabled
        validateForm(); // Ensure final validation state
        if (document.getElementById('addViolationButton').disabled) {
            // Optionally show a message if the user tries to close with invalid data
            // alert("Please fill out the form correctly before closing.");
            // e.preventDefault(); // Uncomment to prevent closing
        }
    });

    // Add event listener for the "Add Violation" button to call validateForm before submitting
    document.getElementById('addViolationButton').addEventListener('click', function() {
        if (validateForm()) {
            // If the form is valid, proceed with addSanction()
            addSanction();
        }
    });
</script>


<!--view modal -->
		<!-- end modals-->
         <!-- Include jQuery -->
		<script assets/src="assets/vendors/scripts/core.js"></script>
		<script assets/src="assets/vendors/scripts/script.min.js"></script>
		<script assets/src="assets/vendors/scripts/process.js"></script>
		<script assets/src="assets/vendors/scripts/layout-settings.js"></script>
		<script assets/src="assets/src/plugins/apexcharts/apexcharts.min.js"></script>
		<script assets/src="assets/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script assets/src="assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script assets/src="assets/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script assets/src="assets/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- Datatable Setting js -->
		<script assets/src="assets/vendors/scripts/datatable-setting.js"></script>
		<!-- costume  -->
		<script assets/src="assets/vendors/scripts/dashboard.js"></script>
        <script assets/src="assets/vendors/scripts/staff.js"></script>
        <script assets/src="assets/vendors/scripts/loading.js"></script>
	</body>
</html>
