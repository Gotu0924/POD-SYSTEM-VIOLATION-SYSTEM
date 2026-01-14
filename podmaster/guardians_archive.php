<?php
include 'sessioning.php';
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
		<?php include 'parts/header.php' ?>
		<div class="mobile-menu-overlay"></div>
		<div class="main-container">
    <!-- Data Table with multiple select row start -->
  <div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Manage Guardians</h4>
    </div>
    <div class="pb-20">
        <div style="overflow-x: auto; width: 100%;">
            <table class="table table-striped nowrap" style="border-collapse: collapse; width: 100%; min-width: 1200px;" id="guardianTable">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">No</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Guardian Name</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Student ID</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Student</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;;">Phone Number</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody id="guardianTableBody">
                    <!-- Rows will be populated here dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modals-->

<!-- Restore Guardian Confirmation Modal -->
<div class="modal fade" id="restoreGuardianConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header  text-white">
        <h5 class="modal-title">Restore Guardian</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to restore this guardian?
        <input type="hidden" id="restoreGuardianId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmRestoreGuardian()">Yes, Restore</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Guardian Confirmation Modal -->
<div class="modal fade" id="deleteGuardianConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title">Delete Guardian</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this guardian? This action cannot be undone.
        <input type="hidden" id="deleteGuardianId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="confirmDeleteGuardian()">Delete</button>
      </div>
    </div>
  </div>
</div>



<!-- Success Modal -->
<div class="modal fade" id="restore-success-modal" tabindex="-1" role="dialog" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Guardian Restore Successfully!</h4>
        <p class="mt-3">The Guardian account has been Restore successfully.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="restore-error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Guardian Restore Failed!</h4>
        <p class="mt-3">Something went wrong while uwu the Guardian account.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- View Guardian Modal -->
<div class="modal fade" id="viewGuardianModal" tabindex="-1" aria-labelledby="viewGuardianLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewGuardianLabel">Guardian Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
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
                            <th>Occupation</th>
                            <td id="viewOccupation"></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td id="viewAddress"></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td id="viewPhone"></td>
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


<!-- Modal for Editing Guardian -->
<div class="modal fade" id="editGuardianModal" tabindex="-1" aria-labelledby="editGuardianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuardianModalLabel">Edit Guardian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <form id="g_editForm">
                    <div class="mb-3">
                        <label for="g_editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="g_editName" required>
                    </div>
                    <div class="mb-3">
                        <label for="g_editStudentID" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="g_editStudentID" required>
                    </div>
                    <div class="mb-3">
                        <label for="g_editDOB" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="g_editDOB" required>
                    </div>
                    <div class="mb-3">
                        <label for="editOccupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control" id="editOccupation" required>
                    </div>
                    <div class="mb-3">
                        <label for="g_editAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="g_editAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="g_editPhone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="g_editPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="g_editReligion" class="form-label">Religion</label>
                        <input type="text" class="form-control" id="g_editReligion" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete Guardian Confirmation Modal -->
<div class="modal fade" id="deleteGuardianModal" tabindex="-1" role="dialog" aria-labelledby="deleteGuardianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteGuardianLabel">Delete Guardian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this guardian?</p>
                <p id="deleteGuardianName"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Guardian ? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- end modals-->


		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
		<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- Datatable Setting js -->
		<script src="vendors/scripts/datatable-setting.js"></script>
		<!-- costume-->
		<script src="vendors/scripts/dashboard.js"></script>
		<script src="vendors/archive/guardians_archive.js"></script>

	</body>
</html>
