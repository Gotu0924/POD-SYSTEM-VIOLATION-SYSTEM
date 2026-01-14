<?php
include 'sessioning.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>PREFECT OF DESCPLINE </title>
        <?php include 'parts/links.php' ?>
        <style>
            #viewModal .modal-body p {
                margin-bottom: 0;
                padding-bottom: 0;
                
            }
            
        </style>
	</head>
    

    <Body>
		<?php include 'parts/header.php'?>
        <div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<!-- Data Table with multiple select row start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Student Archive</h4>
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
                                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Action</th>
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

            <!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreConfirmModal" tabindex="-1" aria-labelledby="restoreConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title" id="restoreConfirmModalLabel">Restore Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to restore this student?
        <input type="hidden" id="restoreStudentId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="confirmRestore()">Yes, Restore</button>
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
              <p>Are you sure you want to delete this student? This action cannot be undone.</p>
              <input type="hidden" id="deleteStudentId">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
          </div>
      </div>
  </div>
</div>

<!-- Restore Success Modal -->
<div class="modal fade" id="restore-success-modal" tabindex="-1" role="dialog" aria-labelledby="restoreSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Student Restored Successfully!</h4>
        <p class="mt-3">The student record has been successfully restored.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Restore Error Modal -->
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
        <p class="mt-3">Something went wrong while restoring the student record.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Restore Success Modal -->
<div class="modal fade" id="delete-success-modal" tabindex="-1" role="dialog" aria-labelledby="restoreSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Student Deleted Successfully!</h4>
        <p class="mt-3">The student record has been successfully Deleted.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Restore Error Modal -->
<div class="modal fade" id="delete-error-modal" tabindex="-1" role="dialog" aria-labelledby="restoreErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Deleted Failed!</h4>
        <p class="mt-3">Something went wrong while Deleted the student record.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
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
		<!-- costume  -->
		<script src="vendors/scripts/dashboard.js"></script>
        <script src="vendors/archive/student_archive.js"></script>
        <script src="vendors/scripts/loading.js"></script>
            <script>
        // This function will replace the current page in the session history
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        
</script>
	</body>
</html>
