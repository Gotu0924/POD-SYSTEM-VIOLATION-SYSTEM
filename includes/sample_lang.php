<?php
include '../includes/sessioning.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>PREFECT OF DESCPLINE </title>
        <?php include '../parts/links.php' ?>
        <style>
            #viewModal .modal-body p {
    margin-bottom: 0;
    padding-bottom: 0;
}
        </style>
	</head>
    <Body>
		<?php include '../parts/header.php'?>
        <div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<!-- Data Table with multiple select row start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Manage Students</h4>
					</div>
                        <div class="pb-20">
                            <div style="overflow-x: auto; width: 100%;">
                                <table class="table nowrap" style="border-collapse: collapse; width: 100%; min-width: 1200px;" id="studentTable">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">ID</th>
                                            <th style="border: 1px solid #ddd; padding: 8px;"> Student Picture</th>
                                            <th style="border: 1px solid #ddd; padding: 8px;">Name</th>
                                            <th style="border: 1px solid #ddd; padding: 8px;">Student ID</th>
                                            <th style="border: 1px solid #ddd; padding: 8px;">Matric</th>
                                            <th style="border: 1px solid #ddd; padding: 8px;">Course</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <!-- Rows will be populated here dynamically  id="studentTableBody"-->


                                    <?php include "../includes/sample_api.php";?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <div class="form-group">
                        <label for="addStudentID">Student ID</label>
                        <input type="text" class="form-control" id="addStudentID" placeholder="Enter student ID" required>
                    </div>
                    <div class="form-group">
                        <label for="addPicture">Student Picture</label>
                        <input type="file" class="form-control-file" id="addPicture" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="addName">Title</label>
                        <select class="form-control" id="addName" required>
                            <option value="Mr">Mr</option>
                            <option value="Sir">Sir</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                        </select>
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
                    <div class="form-group">
                        <label for="addMatric">Matriculation Number</label>
                        <input type="text" class="form-control" id="addMatric" placeholder="Enter matriculation number" required>
                    </div>
                    <div class="form-group">
                        <label for="addPassword">Password</label>
                        <input type="password" class="form-control" id="addPassword" placeholder="Enter password" required>
                    </div>

                    <div class="form-group">
                        <label for="addCourse">Course of Study</label>
                        <select class="form-control" id="addCourse" required>
                            <option value="BSIT">BSIT</option>
                            <option value="BEED">BEED</option>
                            <option value="BSED">BSED</option>
                            <option value="BSBA">BSBA</option>
                            <option value="BSHM">BSHM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="addYearLevel">Year Level</label>
                        <select class="form-control" id="addYearLevel" required>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
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
                    <div class="form-group">
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
                    <div class="form-group">
                        <label for="addLicence">Driver's License No</label>
                        <input type="text" class="form-control" id="addLicence" placeholder="Enter license number" required>
                    </div>
                    <div class="form-group">
                        <label for="addLicenceRegistration">License Plate No</label>
                        <input type="text" class="form-control" id="addLicenceRegistration" placeholder="Enter license plate number" required>
                    </div>

                    <!-- Guardian Information -->
                    <h5 class="mt-4">Guardian Information</h5>
                    <div class="form-group">
                        <label for="addGuardianTitle">Guardian Title</label>
                        <select class="form-control" id="addGuardianTitle" required>
                            <option value="Mr">Mr</option>
                            <option value="Sir">Sir</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                        </select>
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
                    <div class="form-group">
                        <label for="addGuardianOccupation">Guardian Occupation</label>
                        <input type="text" class="form-control" id="addGuardianOccupation" placeholder="Enter guardian's occupation" required>
                    </div>
                    <div class="form-group">
                        <label for="addGuardianDOB">Guardian Date of Birth</label>
                        <input type="date" class="form-control" id="addGuardianDOB" required>
                    </div>
                    <div class="form-group">
                        <label for="addGuardianReligion">Guardian Religion</label>
                        <select class="form-control" id="addGuardianReligion" required>
                            <option value="Catholic">Catholic</option>
                            <option value="Baptist">Baptist</option>
                            <option value="Muslim">Muslim</option>
                            <option value="SDA">SDA</option>
                            <option value="Foursquare">Foursquare</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addStudent()">Add Student</button>
            </div>
        </div>
    </div>
</div>


<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel">Student Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
            <div class="d-flex flex-column align-items-center">
                <img id="viewPicture" ../assets/src="" alt="Student Picture" class="img-thumbnail mb-3" width="150" height="120">
                <p><strong>Full Name</strong><br><em id="viewName"></em></p>
                <p><strong>Student ID</strong><br><em id="viewStudentID"></em></p>
                <p><strong>Date of Birth</strong><br><em id="viewDOB"></em></p>
                <p><strong>Matric</strong><br><em id="viewMatric"></em></p>
                <p><strong>Course of Study</strong><br><em id="viewCourse"></em></p>
                <p><strong>Year Level</strong><br><em id="viewYearLevel"></em></p>
                <p><strong>Address</strong><br><em id="viewAddress"></em></p>
                <p><strong>Phone</strong><br><em id="viewPhone"></em></p>
                <p><strong>Religion</strong><br><em id="viewReligion"></em></p>
                <p><strong>Driver's license NO</strong><br><em id="viewLicence"></em></p>
                <p><strong>License plate NO</strong><br><em id="viewLicenceRegistration"></em></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <img id="editPicture" ../assets/src="" alt="Student Picture" class="img-thumbnail mb-3" width="150" height="120">
                <form id="editForm">
                    <div class="form-group">
                        <label for="editName">Full Name</label>
                        <input type="text" class="form-control" id="editName" placeholder="(Title, First Name, Middle Name, Last Name)" />
                    </div>
                    <div class="form-group">
                        <label for="editStudentID">Student ID</label>
                        <input type="text" class="form-control" id="editStudentID" />
                    </div>
                    <div class="form-group">
                        <label for="editDOB">Date of Birth</label>
                        <input type="date" class="form-control" id="editDOB" />
                    </div>
                    <div class="form-group">
                        <label for="editMatric">Matric(Secondary ID)</label>
                        <input type="text" class="form-control" id="editMatric" />
                    </div>
                    <div class="form-group">
                        <label for="editCourse">Course of Study</label>
                        <select class="form-control" id="editCourse">
                            <option value="BSIT">BSIT</option>
                            <option value="BEED">BEED</option>
                            <option value="BSED">BSED</option>
                            <option value="BSBA">BSBA</option>
                            <option value="BSHM">BSHM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editYearLevel">Year Level</label>
                        <select class="form-control" id="editYearLevel">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" />
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" class="form-control" id="editPhone" />
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
                    <div class="form-group">
                        <label for="editLicence">Driver's License No.</label>
                        <input type="text" class="form-control" id="editLicence" maxlength="12" />
                    </div>
                    <div class="form-group">
                        <label for="editLicenceRegistration">License Plate No.</label>
                        <input type="text" class="form-control" id="editLicenceRegistration" maxlength="7" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div
    class="modal fade"
    id="success-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="successModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-body text-center font-18">
                <h3 class="mb-20">Student Updated Successfully!</h3>
                <div class="mb-30 text-center">
                    <img ../assets/src="../assets/../assets/vendors/images/success.png" alt="success"/>
                </div>
                Your student details have been updated successfully.
            </div>
            <div class="modal-footer justify-content-center">
            <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                onclick="window.location.reload(true);"
            >
                Done
            </button>
            </div>
        </div>
    </div>
</div>


<!-- Error Modal -->
<div
    class="modal fade"
    id="error-modal"
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
                <h3 class="mb-20">Failed to Update Student</h3>
                <div class="mb-30 text-center">
                    <img ../assets/src="../assets/../assets/vendors/images/error.png" alt="error"/>
                </div>
                There was an error updating the student details. Please try again later.
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

		<!-- end modals-->
         <!-- Include jQuery -->
		<script ../assets/src="../assets/../assets/vendors/scripts/core.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/script.min.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/process.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/layout-settings.js"></script>
		<script ../assets/src="../assets/src/plugins/apexcharts/apexcharts.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
        <script ../assets/src="../assets/../assets/vendors/scripts/datatable-setting.js"></script>
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
		<!-- costume  -->
		<script ../assets/src="../assets/../assets/vendors/scripts/dashboard.js"></script>
        <script ../assets/src="../assets/../assets/vendors/scripts/student_crud.js"></script>
        <script ../assets/src="../assets/../assets/vendors/scripts/addstudent.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/add_admin.js"></script>
        <script ../assets/src="../assets/../assets/vendors/scripts/add_sanction.js"></script>
        <script>
    // This function will replace the current page in the session history
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
        
	</body>
</html>
