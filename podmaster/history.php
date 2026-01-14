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
		<?php include 'parts/header_staff.php'?>

    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
          <div class="min-height-200px">
            <!-- Export Datatable start -->
            <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">HISTORY</h4>
                    </div>
                    <div class="pb-20">
                        <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-striped nowrap " style=" width: 100%;" id="sanctionTable">
                            <thead>
                            <tr>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;">Violation Number</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Student ID</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Student</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Category</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Offense</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;;">Sanctions</th>
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

<!-- View Sanction Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Sanction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Violation Number</th><td id="viewViolationNumber"></td></tr>
                    <tr><th>Student ID</th><td id="viewStudentID"></td></tr>
                    <tr><th>Student</th><td id="viewstname"></td></tr>
                    <tr><th>Category</th><td id="viewCategory"></td></tr>
                    <tr><th>Offense</th><td id="viewOffense"></td></tr>
                    <tr><th>Sanctions</th><td id="viewSanctions"></td></tr>
                    <tr><th>Suspension Type</th><td id="viewSuspensionType"></td></tr>
                    <tr><th>Details</th><td id="viewDetails"></td></tr>
                    <tr><th>Recommendation</th><td id="viewRecommendation"></td></tr>
                    <tr><th>Status</th><td id="viewStatus"></td></tr>
                    <tr><th>Username</th><td id="viewUsername"></td></tr>
                    <tr><th>Created At</th><td id="viewCreatedAt"></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

<div class="modal fade" id="archiveViolationConfirmModal" tabindex="-1" aria-labelledby="archiveViolationConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title" id="archiveViolationConfirmModalLabel">Archive Violation</h5>
        <!-- Close Button -->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to archive this violation?
        <input type="hidden" id="archiveViolationId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="confirmViolationArchive()">Yes, Archive</button>
      </div>
    </div>
  </div>
</div>


<!--end  modals -->
<!-- Checkbox select Datatable End -->

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
		<script src="vendors/scripts/history_staff.js"></script>


	</body>
</html>
