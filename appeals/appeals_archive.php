
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
<?php include '../parts/header.php'?>
<div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<!-- Data Table with multiple select row start -->
						<div class="card-box mb-30">
							<div class="pd-20">
								<h4 class="text-blue h4">Students Appeals Archive</h4>
							</div>
							<div class="pb-20">
								<div style="width: 100%;">
									<table class="table table-striped nowrap" style="border-collapse: collapse; width: 100%; min-width: 1200px;" id="appealable">
										<thead>
											<tr>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 50px;;">#</th>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;;">Violation Number</th>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Student ID</th>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Name</th>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Course</th>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Year Level</th>
												<th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Time</th>
												<th class="datatable-nosort">Action</th>
											</tr>
										</thead>
										<tbody id="appealTableBody">
											<!-- Rows will be populated here dynamically -->
										</tbody>
									</table>
								</div>
							</div>
						</div>

            </div>


	<!-- View Appeal Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Appeal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- Content will be injected here by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreConfirmModal" tabindex="-1" aria-labelledby="restoreConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title" id="restoreConfirmModalLabel">Restore Appeal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to restore this appeal?
        <input type="hidden" id="restoreAppealId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="confirmRestore()">Yes, Restore</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this appeal? This action cannot be undone.</p>
        <input type="hidden" id="deleteAppealId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="restore-appeal-success-modal" tabindex="-1" role="dialog" aria-labelledby="restoreAppealSuccessLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Appeal Restored Successfully!</h4>
        <p class="mt-3">The appeal has been moved back from the archive.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="appeal-error-modal" tabindex="-1" role="dialog" aria-labelledby="appealErrorLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Restore Failed!</h4>
        <p class="mt-3">Something went wrong while restoring the appeal.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
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
		<!-- Datatable Setting js -->
		<script ../assets/src="../assets/../assets/vendors/scripts/datatable-setting.js"></script>
		<!-- costume-->
		<script ../assets/src="../assets/../assets/vendors/scripts/dashboard.js"></script>
		<script ../assets/src="../assets/../assets/vendors/archive/appeals_archive.js"></script>
    <script>

	</body>
</html>
