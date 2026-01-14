<?php
include 'sessioning.php';
?>
<!-- Modal HTML -->
<div id="duplicateModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 8px; width: 50%; max-width: 600px; margin: 100px auto; display: grid; grid-template-columns: 1fr; gap: 15px;">
        <span class="close" style="cursor: pointer; position: absolute; top: 10px; right: 10px; font-size: 20px;" onclick="location.reload();">&times;</span>
        <h2 style="font-size: 24px; text-align: center; grid-column: span 2;">Duplicate Entries</h2>
        
        <!-- Duplicates List -->
        <div id="duplicateItems" style="grid-column: span 2; max-height: 400px; overflow-y: auto;"></div>

        <!-- Pagination -->
        <div id="pagination" style="grid-column: span 2; text-align: center; margin-top: 10px;"></div>
    </div>
</div>


<script>
    // Check if there are duplicate entries
    var urlParams = new URLSearchParams(window.location.search);
    var duplicates = urlParams.get('duplicates');

    if (duplicates) {
        // Split duplicates into an array
        var duplicateArray = duplicates.split(',');
        var pageSize = 20; // Items per page
        var currentPage = 1;

        // Function to display duplicates for the current page
        function displayDuplicates(page) {
            // Calculate the start and end indexes for the current page
            var start = (page - 1) * pageSize;
            var end = start + pageSize;
            var pageDuplicates = duplicateArray.slice(start, end);

            // Display duplicates
            var duplicateItems = document.getElementById('duplicateItems');
            duplicateItems.innerHTML = '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">' + pageDuplicates.map(function(duplicate) {
                return '<div style="background-color: #f4f4f4; padding: 10px; border-radius: 5px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">' + duplicate.trim() + '</div>';
            }).join('') + '</div>';

            // Update pagination
            updatePagination(page);
        }

        // Function to update pagination
        function updatePagination(page) {
            var totalPages = Math.ceil(duplicateArray.length / pageSize);
            var pagination = document.getElementById('pagination');

            var prevPage = (page > 1) ? '<button onclick="displayDuplicates(' + (page - 1) + ')" style="padding: 8px 12px; margin: 0 5px;">Prev</button>' : '';
            var nextPage = (page < totalPages) ? '<button onclick="displayDuplicates(' + (page + 1) + ')" style="padding: 8px 12px; margin: 0 5px;">Next</button>' : '';

            pagination.innerHTML = prevPage + 'Page ' + page + ' of ' + totalPages + nextPage;
        }

        // Display the first page of duplicates
        displayDuplicates(currentPage);

        // Show the modal
        var modal = document.getElementById('duplicateModal');
        modal.style.display = "block";

        // Close modal when user clicks on the <span> (x)
        var closeBtn = document.getElementsByClassName("close")[0];
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Close modal if user clicks outside the modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
</script>
        <style>
            #viewModal .modal-body p {
                margin-bottom: 0;
                padding-bottom: 0;
                



            }


            /* Custom Modal Styles */
.modal-content {
  background-color: #fff; /* White background for content */
}

.modal-header {
  font-size: 1.25rem; /* Slightly larger font for modal header */
}

.modal-body {
  font-size: 1.1rem;
}

.btn {
  min-width: 150px; /* Ensures buttons have consistent width */
}

.btn-lg {
  padding: 12px 25px; /* Adds more padding to large buttons */
}

</style>


<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>PREFECT OF DESCPLINE </title>
        <?php include 'parts/links.php' ?>
	</head>x
    <Body>
		<?php include 'parts/header.php'?>


        <div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<!-- Data Table with multiple select row start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Manage Students</h4>
					</div>
                        <div class="pb-20">
                            <div >
                             <table class="table table-striped nowrap" style="width:100%;" id="studentTable">
                                    <thead>
                                    <tr>
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 50px; ">NO</th>
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 140px; ">Student Picture</th>
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; ">Name</th>
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Student ID</th>
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Course</th>
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Year/Level</th>
                                        <th style="border: 1px solid #ddd; padding: 5px; text-align: left; min-width: 50px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="studentTableBody" >
                                        <!-- Rows will be populated here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Student Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Student Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <label class="font-weight-bold d-block mb-2">Student Picture</label>
                    <img id="viewPicture" src="" alt="Student Picture" class="img-thumbnail" width="150" height="120">
                </div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Full Name</th>
                            <td id="viewName"></td>
                        </tr>
                        <tr>
                            <th>Student ID</th>
                            <td id="viewStudentID"></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td id="viewDOB"></td>
                        </tr>
                        <tr>
                            <th>Course of Study</th>
                            <td id="viewCourse"></td>
                        </tr>
                        <tr>
                            <th>Year Level</th>
                            <td id="viewYearLevel"></td>
                        </tr>
                        <tr>
                            <th>School Year</th>
                            <td id="viewSchoolYear"></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td id="viewGender"></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td id="viewAddress"></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td id="viewPhone"></td>
                        </tr>
                        <tr>
                            <th>Religion</th>
                            <td id="viewReligion"></td>
                        </tr>
                        <tr>
                            <th>Driver's License No</th>
                            <td id="viewLicence"></td>
                        </tr>
                        <tr>
                            <th>License Plate No</th>
                            <td id="viewLicenceRegistration"></td>
                        </tr>
                        <tr>
                            <th>Gmail</th>
                            <td id="viewGmail"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<!-- Edit Modal (Landscape with Image on Left, Three-Column Form) -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95vw; max-height: 70vh;">
    <div class="modal-content" style="height: 100%; overflow: hidden;">
      <div class="modal-header">
        <h4 class="modal-title" id="editModalLabel">Edit Student</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      <div class="modal-body" style="max-height: calc(70vh - 56px - 56px); overflow-y: auto;">
        <div class="row">
          <!-- Left Column (Picture) -->
          <div class="col-md-3 text-center mb-3">
            <img id="editPicture" src="" alt="Student Picture" class="img-thumbnail" style="max-width: 100%; height: auto;" />
          </div>

          <!-- Right Columns (Form) -->
          <div class="col-md-9">
            <form id="editForm">
              <div class="row">
               <!-- First Column -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" />
                      </div>
                      <div class="form-group">
                        <label for="editMiddleName">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddleName" />
                      </div>
                      <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" />
                      </div>

                      <!-- Student ID + Course in the same row -->
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="editStudentID" placeholder="7 Digits Only">Student ID</label>
                          <input type="text" class="form-control" id="editStudentID" />
                          <div id="id-error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="editCourse">Course of Study</label>
                          <select class="form-control" id="editCourse">
                            <option value="BSIT">BSIT</option>
                            <option value="BEED">BEED</option>
                            <option value="BSED">BSED</option>
                            <option value="BSBA">BSBA</option>
                            <option value="BSHM">BSHM</option>
                          </select>
                        </div>
                      </div>
                    </div>


                <!-- Second Column -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="editYearLevel">Year Level</label>
                    <select class="form-control" id="editYearLevel">
                      <option value="1st Year">1st Year</option>
                      <option value="2nd Year">2nd Year</option>
                      <option value="3rd Year">3rd Year</option>
                      <option value="4th Year">4th Year</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="editSchoolYear">School Year</label>
                    <input type="text" class="form-control" id="editSchoolYear" placeholder="e.g. 2024-2025" />
                  </div>
                  <div class="form-group">
                    <label for="editGender">Gender</label>
                    <select class="form-control" id="editGender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="editAddress">Address</label>
                    <input type="text" class="form-control" id="editAddress" />
                  </div>
                </div>

                <!-- Third Column -->
                <div class="col-md-4">
                  <!-- Phone Input with Error Message Below -->
                  <div class="form-group">
                      <label for="editPhone">Phone</label>
                      <input type="text" class="form-control" id="editPhone" />
                      <div id="phone-error" class="invalid-feedback" style="display: none;"></div> <!-- Error message here -->
                  </div>

                  <div class="form-group">
                    <label for="editReligion">Religion</label>
                    <select class="form-control" id="editReligion">
                      <option value="Catholic">Catholic</option>
                      <option value="Baptist">Baptist</option>
                      <option value="Muslim">Muslim</option>
                      <option value="SDA">SDA</option>
                      <option value="Foursquare">Foursquare</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>
                  <!-- Driver’s License + Plate in same row -->
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="editLicence">Driver's License No.</label>
                        <input type="text" class="form-control" id="editLicence" maxlength="12" />
                      </div>
                      <div class="form-group col-md-6">
                        <label for="editLicenceRegistration">License Plate No.</label>
                        <input type="text" class="form-control" id="editLicenceRegistration" maxlength="7" />
                      </div>
                    </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="editGmail">Gmail</label>
                          <input type="text" class="form-control" id="editGmail" placeholder="@smcbi.edu.ph"/>
                        </div>
                        <div class="form-group col-md-6" >
                        <label for="editDOB">Date of Birth </label>
                        <input  type="date" class="form-control" id="editDOB"/>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>

      </div>
    </div>
  </div>
</div>



<script>

    function saveChanges() {
        const id = document.getElementById('editForm').dataset.id;

        const updatedStudent = {
            id: id,
            firstname: document.getElementById('editFirstName').value,
            middlename: document.getElementById('editMiddleName').value,
            lastname: document.getElementById('editLastName').value,
            studentID: document.getElementById('editStudentID').value,
            dob: document.getElementById('editDOB').value,
            course: document.getElementById('editCourse').value,
            year_level: document.getElementById('editYearLevel').value,
            school_year: document.getElementById('editSchoolYear').value,
            gender: document.getElementById('editGender').value,
            address: document.getElementById('editAddress').value,
            phone: document.getElementById('editPhone').value,
            religion: document.getElementById('editReligion').value,
            licence: document.getElementById('editLicence').value,
            licence_registration: document.getElementById('editLicenceRegistration').value,
            gmail: document.getElementById('editGmail').value, 
            st_ID: document.getElementById('editStudentID').value
        };

        // Reset all error messages before proceeding
        resetErrorMessages();

        // Validate the phone number format (000-000-0000)
        if (!isValidPhoneNumber(updatedStudent.phone)) {
            const phoneInput = document.getElementById('editPhone');
            const phoneError = document.getElementById('phone-error');

            phoneInput.classList.add('is-invalid'); 
            phoneError.innerText = 'Phone number must be in the format 000-000-0000.';
            phoneError.style.display = 'block'; 
            return; 
        }

        // Validate the student ID to ensure it's exactly 7 digits
        if (!isValidStudentID(updatedStudent.studentID)) {
            const idInput = document.getElementById('editStudentID');
            const idError = document.getElementById('id-error');

            idInput.classList.add('is-invalid'); 
            idError.innerText = 'Student ID must be exactly 7 digits.';
            idError.style.display = 'block'; 
            return; 
        }

        // Validate Gmail to only accept @scmbi.edu.ph domain
        if (!isValidScmbiEmail(updatedStudent.gmail)) {
            const gmailInput = document.getElementById('editGmail');
            const gmailError = document.getElementById('gmail-error'); // You need to add this element to your HTML

            gmailInput.classList.add('is-invalid');
            gmailError.innerText = 'Email must end with @smcbi.edu.ph';
            gmailError.style.display = 'block';
            return;
        }

        fetch('update_student.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedStudent),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("✅ Update success, refreshing page...");
                    location.reload(); 
                } else {
                    console.error("❌ Update failed:", data);
                    $('#error-modal').modal('show');
                }
            })
            .catch(err => {
                console.error("❌ Fetch error:", err);
                $('#error-modal').modal('show');
            });
    }
    
    // Function to validate the @scmbi.edu.ph email format
    function isValidScmbiEmail(email) {
        // Regular expression to check if the email ends with @scmbi.edu.ph
        const regex = /@smcbi\.edu\.ph$/;
        return regex.test(email);
    }

    function isValidPhoneNumber(phone) {
        // Regular expression to validate phone number in the format 000-000-0000
        const regex = /^\d{3}-\d{3}-\d{4}$/;
        return regex.test(phone);
    }

    function isValidStudentID(studentID) {
        // Check if student ID is exactly 7 digits
        const regex = /^\d{7}$/;
        return regex.test(studentID);
    }

    // Phone Number Masking for format 000-000-0000
    $(document).ready(function () {
        $('#editPhone').on('input', function () {
            let value = $(this).val().replace(/\D/g, ''); 
            if (value.length <= 3) {
                $(this).val(value);
            } else if (value.length <= 6) {
                $(this).val(value.replace(/(\d{3})(\d{1,})/, '$1-$2'));
            } else {
                $(this).val(value.replace(/(\d{3})(\d{3})(\d{1,})/, '$1-$2-$3'));
            }
        });
    });

    function resetErrorMessages() {
        // Reset all error messages and input field styles
        const errorElements = document.querySelectorAll('.invalid-feedback');
        errorElements.forEach((element) => {
            element.style.display = 'none';
        });

        const invalidInputs = document.querySelectorAll('.is-invalid');
        invalidInputs.forEach((input) => {
            input.classList.remove('is-invalid');
        });
    }
</script>




<div class="modal fade" id="edit-success-modal" tabindex="-1" role="dialog" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Student Updated Successfully!</h4>
        <p class="mt-3">The student record has been saved.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>

      </div>
    </div>
  </div>
</div>

<!-- ERROR MODAL 
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Update Failed!</h4>
        <p class="mt-3">Something went wrong while saving the student record.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
-->

        <!--   arhicevd succes and error -->

        <div class="modal fade" id="archived-success-modal" tabindex="-1" role="dialog" aria-labelledby="archivedSuccessModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body text-center">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
                  <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
                  <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
                </svg>
                <h4 class="text-success mt-3">Student Archived Successfully!</h4>
                <p class="mt-3">The student record has been archived.</p>
                <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
              </div>
            </div>
          </div>
        </div>


      <div class="modal fade" id="duplicateIdModal" tabindex="-1" role="dialog" aria-labelledby="duplicateIdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-white text-white">
              <h5 class="modal-title" id="duplicateIdModalLabel">Archive Error</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              This student has already been archived.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" id="duplicateOkBtn" data-dismiss="modal">OK</button>
            </div>
          </div>
        </div>
      </div>


<!-- Transition Description Modal -->
<div class="modal fade" id="transitionDescModal" tabindex="-1" role="dialog" aria-labelledby="transitionDescModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg border-0 rounded">
      <div class="modal-header text-white">
        <h5 class="modal-title">About Transition Button</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="lead">This action will <strong>increment the year level by One</strong> for all students. However, <strong>4th-year students, along with their guardians' information, will also be archived.</strong> as they have already graduated from this school.</p>
        <p>Click <strong>Continue</strong> to proceed with the update. Clicking <strong>Cancel</strong> will close the modal without making any changes.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-lg" id="continueTransitionBtn">Continue</button>
        <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Year Modal -->
<div class="modal fade" id="updateYearModal" tabindex="-1" role="dialog" aria-labelledby="updateYearModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="POST" action="update_year.php">
      <div class="modal-content shadow-lg border-0 rounded">
        <div class="modal-header text-white">
          <h5 class="modal-title">Update School Year</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p class="lead"><strong>Warning:</strong> This action will update the school year for all students, and archive the 4th-year students along with their guardians' information, as they have already graduated. Are you sure you want to proceed? This action cannot be undone!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-lg" onclick="updateYearLevel()">Yes, Proceed</button>

          <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function updateYearLevel() {
    // Close the confirmation modal
    $('#updateYearModal').modal('hide');

    fetch('update_year.php', { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                $('#update-year-level-success').modal('show');
            } else {
                $('#update-year-level-error').modal('show');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            $('#update-year-level-error').modal('show');
        });
}
</script>>

<!-- SUCCESS MODAL -->
<div class="modal fade" id="update-year-level-success" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" 
            points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Update Successful!</h4>
        <p class="mt-3">All school years updated and 4th-year students archived.</p>
        <button type="button" class="btn btn-success mt-3" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- ERROR MODAL -->
<div class="modal fade" id="update-year-level-error" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Update Failed!</h4>
        <p class="mt-3">Something went wrong while updating the records.</p>
        <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveConfirmModal" tabindex="-1" aria-labelledby="archiveConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title" id="archiveConfirmModalLabel">Archive Student</h5>
        <!-- Close Button -->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to archive this student?
        <input type="hidden" id="archiveStudentId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="confirmArchive()">Yes, Archive</button>
      </div>
    </div>
  </div>
</div>


		<!-- end modals-->
         <!-- Include jQuery -->
		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
		<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    
        <script src="vendors/scripts/datatable-setting.js"></script>
		<!-- Datatable Setting js -->
		<script src="vendors/scripts/datatable-setting.js"></script>
        
		<!-- costume  -->
		<script src="vendors/scripts/dashboard.js"></script>
    <script src="vendors/scripts/student_crud.js"></script>
    <script src="vendors/scripts/addstudent.js"></script>
	</body>
</html>
