<?php
include '../includes/sessioning.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>DAMS</title>
        <?php include '../parts/links.php' ?>
	</head>
	<body>
		<?php include '../parts/header.php'?>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
          <div class="min-height-200px">
            <!-- Export Datatable start -->
            <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Manage Violation</h4>
                    </div>
                    <div class="pb-20">
                        <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-striped nowrap" style=" width: 100%;" id="sanctionTable">
                            <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">#</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Violation Number</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Student ID</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Offense</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;;">Suspension Type</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">By</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Status</th>
                                <th class="datatable-nosort">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="data-sanction-Body">
                            <!-- Data will be dynamically inserted here by JavaScript -->
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            <!-- Export Datatable End -->
          </div>
        </div>
      </div>

<!-- modals -->
<!-- Restore Sanction Confirmation Modal -->
<div class="modal fade" id="restoreSanctionConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title">Restore Sanction</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to restore this sanction?
        <input type="hidden" id="restoreSanctionId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmRestoreSanction()">Yes, Restore</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Sanction Confirmation Modal -->
<div class="modal fade" id="deleteSanctionConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-headertext-white">
        <h5 class="modal-title">Delete Sanction</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this sanction? This action cannot be undone.
        <input type="hidden" id="deleteSanctionId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="confirmDeleteSanction()">Delete</button>
      </div>
    </div>
  </div>
</div>




<!-- Add Sanction Modal -->
<div class="modal fade" id="addSanctionModal" tabindex="-1" role="dialog" aria-labelledby="addSanctionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSanctionLabel">Add New Violation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <form id="addSanctionForm">
                    <div class="form-group">
                        <label for="s_ID">Student ID</label>
                        <input type="text" class="form-control" id="s_ID" name="s_ID" required>
                    </div>
                    <div class="form-group">
                        <label for="i_Category">Category</label>
                        <select class="form-control" id="i_Category" name="i_Category" required onchange="populateOffenses()">
                            <option value="Category A">Category A</option>
                            <option value="Category B">Category B</option>
                            <option value="Category C">Category C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="list_Offense">Offense</label>
                        <select class="form-control" id="list_Offense" name="list_Offense" required>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="i_Sanctions">Sanction Type</label>
                        <select class="form-control" id="i_Sanctions" name="i_Sanctions" required onchange="toggleSuspensionType()">
                            <option value="Reprimand">Reprimand</option>
                            <option value="Suspension">Suspension</option>
                            <option value="Exclusion">Exclusion</option>
                        </select>
                    </div>
                    <div class="form-group" id="suspensionTypeGroup" style="display: none;">
                        <label for="Suspension_Type">Suspension Type</label>
                        <select class="form-control" id="Suspension_Type" name="Suspension_Type">
                            <option value="First Offense">First Offense: Letter of apology and counseling</option>
                            <option value="Second Offense">Second Offense: Suspension (1-2 days) and two counseling sessions</option>
                            <option value="Third Offense">Third Offense: Suspension (2-4 days), five counseling sessions, and possible community service</option>
                        </select>
                    </div>
                    <!-- Hidden input to ensure Suspension_Type is always submitted -->
                    <input type="hidden" name="Suspension_Type_Hidden" id="Suspension_Type_Hidden" value="N/A">

                    <div class="form-group">
                        <label for="i_Details">Details</label>
                        <textarea class="form-control" id="i_Details" name="i_Details" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="i_Recommendation">Recommendation</label>
                        <input type="text" class="form-control" id="i_Recommendation" name="i_Recommendation" required>
                    </div>
                    <div class="form-group">
                        <label for="i_Status">Status</label>
                        <select class="form-control" id="i_Status" name="i_Status" required>
                            <option value="Pending">Pending</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addSanction()">Add Sanction</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- View Sanction Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Sanction Details</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td id="viewSanctionID"></td>
                        </tr>
                        <tr>
                            <th>Violation Number</th>
                            <td id="viewviolation"></td>
                        </tr>
                        <tr>
                            <th>Student ID</th>
                            <td id="viewStudentID"></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td id="viewCategory"></td>
                        </tr>
                        <tr>
                            <th>Offense</th>
                            <td id="viewOffense"></td>
                        </tr>
                        <tr>
                            <th>Sanctions</th>
                            <td id="viewSanctions"></td>
                        </tr>
                        <tr>
                            <th>Suspension Type</th>
                            <td id="viewSuspensionType"></td>
                        </tr>
                        <tr>
                            <th>Details</th>
                            <td id="viewDetails"></td>
                        </tr>
                        <tr>
                            <th>Recommendation</th>
                            <td id="viewRecommendation"></td>
                        </tr>
                            <tr>
                                <th>Recorded By</th>
                                <td id="viewrecorded"></td>
                            </tr>
                        <tr>
                            <th>Status</th>
                            <td id="viewStatus"></td>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this sanction? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
 
<!-- Edit Sanction Modal -->
<div class="modal fade" id="editModalsancitons" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Sanction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <form id="editSanctionForm">
                    <!-- Hidden input for i_ID (primary key) -->
                    <input type="hidden" id="editID" name="i_ID">
                    
                    <div class="mb-3">
                        <label for="editStudentID" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="editStudentID" name="s_ID" required>
                        <!-- 'readonly' to prevent editing of student ID -->
                    </div>

                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="i_Category" required>
                    </div>

                    <div class="mb-3">
                        <label for="editOffense" class="form-label">Offense</label>
                        <input type="text" class="form-control" id="editOffense" name="list_Offense" required>
                    </div>

                    <div class="mb-3">
                        <label for="editSanctions" class="form-label">Sanctions</label>
                        <input type="text" class="form-control" id="editSanctions" name="i_Sanctions" required>
                    </div>

                    <div class="mb-3">
                        <label for="editSuspensionType" class="form-label">Suspension Type</label>
                        <input type="text" class="form-control" id="editSuspensionType" name="Suspension_Type">
                    </div>

                    <div class="mb-3">
                        <label for="editDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="editDetails" name="i_Details" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editRecommendation" class="form-label">Recommendation</label>
                        <input type="text" class="form-control" id="editRecommendation" name="i_Recommendation">
                    </div>

                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="i_Status" required>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal fade" id="restore-success-modal" tabindex="-1" role="dialog" aria-labelledby="restoreSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Sanction Restored Successfully!</h4>
        <p class="mt-3">The sanction record has been restored.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- ERROR MODAL -->
<div class="modal fade" id="restore-error-modal" tabindex="-1" role="dialog" aria-labelledby="restoreErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Restore Failed!</h4>
        <p class="mt-3">Something went wrong while restoring the sanction record.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






<!--end  modals -->
<!-- Checkbox select Datatable End -->

		<script ../assets/src="../assets/../assets/vendors/scripts/core.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/script.min.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/process.js"></script>
		<script ../assets/src="../assets/../assets/vendors/scripts/layout-settings.js"></script>
		<script ../assets/src="../assets/src/plugins/apexcharts/apexcharts.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script ../assets/src="../assets/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- Datatable Setting js -->
		<script ../assets/src="../assets/../assets/vendors/scripts/datatable-setting.js"></script>
		<!-- costume-->
		<script ../assets/src="../assets/../assets/vendors/scripts/dashboard.js"></script>
		<script ../assets/src="../assets/../assets/vendors/archive/violation_archive.js"></script>
	</body>
</html>
