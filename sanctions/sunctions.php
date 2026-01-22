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
      <style>
  #overlay {
    position: fixed;
    bottom: 20px;  /* Change 'top' to 'bottom' */
    right: 20px;   /* Keep it in the bottom-right corner */
    width: 280px;  /* Slightly smaller for a note feel */
    max-width: 90vw;
    background: #ffffcc;  /* Sticky note yellow */
    border: 1px solid #e0e0b3;  /* Lighter border */
    border-radius: 4px;  /* Sharper corners */
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);  /* Softer shadow */
    padding: 18px 20px 15px 20px;  /* Adjusted padding */
    color: #333333;  /* Darker text for readability */
    font-family: 'Permanent Marker', cursive, sans-serif;  /* A font that mimics handwriting, if available */
    z-index: 10000;
    user-select: none;
    transform: rotate(2deg);  /* Slightly rotated for a "stuck" look */
    transition: transform 0.2s ease-in-out;
}


  #overlay:hover {
    transform: rotate(0deg); /* Straightens on hover */
  }

  #overlay h3 {
    margin: 0 0 10px 0;
    font-weight: 700;
    font-size: 1.2rem; /* Slightly smaller heading */
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #222222;
    border-bottom: 1px dashed #aaaaaa; /* Dashed line for a note look */
    padding-bottom: 5px;
  }

  #loading {
    font-size: 0.9rem;
    font-weight: 500;
    color: #666666;
    text-align: center;
    padding: 10px 0;
  }

  #violator-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  #violator-list li {
    background: transparent; /* No background for list items */
    border: none; /* No border for list items */
    padding: 8px 0px; /* Reduced padding */
    margin-bottom: 5px;
    font-weight: 400; /* Lighter font weight */
    font-size: 0.95rem;
    color: #333333;
    cursor: default;
  }

  #violator-list li strong {
    font-weight: 600; /* Make ID stand out a bit */
  }

  #toggleListBtn {
    background: none;
    border: none;
    color: #333;
    font-weight: 700;
    font-size: 1.2rem;
    padding: 0;
    user-select: none;
    font-family: 'Permanent Marker', cursive, sans-serif; /* Consistent font */
  }

  #toggleListBtn:hover {
    color: #666; /* Darker on hover */
    text-decoration: underline;
  }

  .close-btn {
    position: absolute;
    top: 5px; /* Closer to the top-right corner */
    right: 8px;
    background: transparent;
    border: none;
    font-size: 1.3rem; /* Slightly smaller close button */
    font-weight: 700;
    color: #666; /* Darker color for close button */
    cursor: pointer;
    z-index: 10001;
  }

  .close-btn:hover {
    color: #cc0000; /* Red on hover */
  }

  #showOverlayBtn {
    background: #ffffcc; /* Sticky note yellow */
    border: 1px solid #e0e0b3;
    border-radius: 4px;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.15);
    color: #333333;
    font-family: 'Permanent Marker', cursive, sans-serif;
    font-size: 1rem;
    padding: 8px 12px;
    transform: rotate(-3deg); /* Also rotated */
  }

  #showOverlayBtn:hover {
    transform: rotate(0deg);
    box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
  }
</style>



	</head>
	<body>
		<?php include '../parts/header.php'?>

       <div id="overlay">
  <button type="button" id="closeOverlayBtn" aria-label="Close" class="close-btn">
    <span aria-hidden="true">&times;</span>
  </button>

  <h3 id="toggleListBtn" aria-expanded="true" aria-controls="violator-list" style="cursor: grab;">
    Top Violators ▲
  </h3>

  <div id="loading">Loading...</div>
  <ul id="violator-list"></ul>
</div>
<button id="showOverlayBtn" style="display:none; position:fixed; bottom:20px; right:20px; z-index:1000;" class="btn btn-primary">
  Show Top Violators
</button>

<script>
  // violators

  async function fetchTopViolators() {
    try {
      const response = await fetch('../violations/top_violators.php');
      const data = await response.json();

      const loadingDiv = document.getElementById('loading');
      const list = document.getElementById('violator-list');

      loadingDiv.style.display = 'none';

      if (data.length === 0) {
        list.innerHTML = '<li>No violations found</li>';
        return;
      }

   // Populate the list
list.innerHTML = data.map(item =>
  `<li><strong>ID=</strong> ${item.st_ID} - ${item.full_name} : 
   <span style="color: red; font-weight: bold;">${item.violation_count} violation's <span></li>`
).join('');


    } catch (error) {
      document.getElementById('loading').textContent = 'Error loading data';
      console.error('Error:', error);
    }
  }

  // Call on page load
  fetchTopViolators();



  // ==============================
  // Overlay Elements
  // ==============================
  const toggleListBtn = document.getElementById('toggleListBtn');
  const violatorList = document.getElementById('violator-list');
  const overlay = document.getElementById('overlay');
  const closeOverlayBtn = document.getElementById('closeOverlayBtn');
  const showOverlayBtn = document.getElementById('showOverlayBtn'); // new button


  // ==============================
  // Toggle Violator List Display
  // ==============================
  toggleListBtn.addEventListener('click', () => {
    const isHidden = violatorList.style.display === 'none';
    violatorList.style.display = isHidden ? 'block' : 'none';
    toggleListBtn.textContent = isHidden ? 'Top Violators ▲' : 'Top Violators ▼';
    toggleListBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
  });


  // ==============================
  // Close / Show Overlay
  // ==============================
  closeOverlayBtn.addEventListener('click', () => {
    overlay.style.display = 'none';
    showOverlayBtn.style.display = 'block'; // show the button again
  });

  showOverlayBtn.addEventListener('click', () => {
    overlay.style.display = 'block';
    showOverlayBtn.style.display = 'none'; // hide the button
  });


  // ==============================
  // Draggable Overlay
  // ==============================
  let isDragging = false;
  let offsetX = 0;
  let offsetY = 0;

  const header = document.getElementById('toggleListBtn');

  header.addEventListener('mousedown', (e) => {
    isDragging = true;
    offsetX = e.clientX - overlay.offsetLeft;
    offsetY = e.clientY - overlay.offsetTop;
    overlay.style.cursor = 'grabbing'; // Change cursor while dragging
  });

  document.addEventListener('mousemove', (e) => {
    if (isDragging) {
      overlay.style.left = `${e.clientX - offsetX}px`;
      overlay.style.top = `${e.clientY - offsetY}px`;
      overlay.style.position = 'fixed';
    }
  });

  document.addEventListener('mouseup', () => {
    isDragging = false;
    overlay.style.cursor = 'grab'; // Reset cursor
  });

  // violators //
</script>

   <div class="mobile-menu-overlay"></div>
<div class="main-container">
  <div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
      <!-- Export Datatable start -->
      <div class="card-box mb-30">
        <div class="pd-20 d-flex justify-content-between align-items-center">
          <h4 class="text-blue h4 mb-0">Manage Violation</h4>
          <div class="dt-buttons btn-group flex-wrap">
            <button class="btn btn-secondary buttons-csv buttons-html5" type="button">
              <span>CSV</span>
            </button>
            <button class="btn btn-secondary buttons-pdf buttons-html5" type="button">
              <span>PDF</span>
            </button>
            <button class="btn btn-secondary buttons-print" type="button">
              <span>Print</span>
            </button>
          </div>
        </div>
        <div class="pb-20">
          <div style="overflow-x: auto; width: 100%;">
            <table class="table table-striped nowrap" id="sanctionTable" style="width: 100%;">
              <thead>
                <tr>
                  <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Student ID</th>
                  <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Student</th>
                  <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Offense</th>
                  <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 150px;">Suspension Type</th>
                  <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Status</th>
                  <th style="border: 1px solid #ddd; padding: 12px; text-align: left; min-width: 120px;">Time</th>
                  <th class="datatable-nosort" style="border: 1px solid #ddd; padding: 12px; text-align: left;">Actions</th>
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
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Sanction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>#</th><td id="viewSanctionID"></td></tr>
                        <tr><th>Violation Number</th><td id="viewViolationNumber"></td></tr>
                        <tr><th>Student ID</th><td id="viewStudentID"></td></tr>
                        <tr><th>Student</th><td id="viewstname"></td></tr>
                        <tr><th>Category</th><td id="viewCategory"></td></tr>
                        <tr><th>Offense</th><td id="viewOffense"></td></tr>
                        <tr><th>Sanctions</th><td id="viewSanctions"></td></tr>
                        <tr><th>Suspension Type</th><td id="viewSuspensionType"></td></tr>
                        <tr><th>Details</th><td id="viewDetails"></td></tr>
                        <tr><th>Recommendation</th><td id="viewRecommendation"></td></tr>
                        <tr><th>Recorded By</th><td id="viewrecorded"></td></tr>
                        <tr><th>Time</th><td id="viewtime"></td></tr>
                        <tr><th>Status</th><td id="viewStatus"></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Sanction Modal -->
<div class="modal fade" id="editModalsancitons" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Sanction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSanctionForm">
                    <input type="hidden" id="editID" name="i_ID"> <!-- Hidden field for i_ID -->

                    <div class="row">
                        <!-- First Column (Student ID, Category, Offense) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editStudentID">Student ID</label>
                                <input type="text" class="form-control" id="editStudentID" name="st_ID" readonly>
                            </div>
                            <div class="form-group">
                                <label for="editCategory">Category</label>
                                <select class="form-control" id="editCategory" name="i_Category" required>
                                    <option value="Category A">Category A</option>
                                    <option value="Category B">Category B</option>
                                    <option value="Category C">Category C</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editOffense">Offense</label>
                                <select class="form-control" id="editOffense" name="list_Offense" required>
                                    <!-- Options populated dynamically -->
                                </select>
                            </div>
                        </div>

                        <!-- Second Column (Sanctions, Suspension Type, Status) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editSanctions">Sanction Type</label>
                                <select class="form-control" id="editSanctions" name="i_Sanctions" required>
                                    <option value="Reprimand">Reprimand</option>
                                    <option value="Suspension">Suspension</option>
                                    <option value="Exclusion">Exclusion</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="editSuspensionType">Suspension Type</label>
                                <select class="form-control" id="editSuspensionType" name="Suspension_Type" required>
                                    <option value="First Offense">First Offense: Letter of apology and counseling</option>
                                    <option value="Second Offense">Second Offense: Suspension (1-2 days) and two counseling sessions</option>
                                    <option value="Third Offense">Third Offense: Suspension (2-4 days), five counseling sessions, and possible community service</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editrecorder">Recorded By</label>
                                        <input type="text" class="form-control" id="editrecorder" name="a_username" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editStatus">Status</label>
                                        <select class="form-control" id="editStatus" name="i_Status" required>
                                            <option value="">Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Resolved">Resolved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Third Column (Details) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editDetails">Details</label>
                                <textarea class="form-control" id="editDetails" name="i_Details" rows="4" required></textarea>
                            </div>
                        </div>

                        <!-- Fourth Column (Recommendation) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editRecommendation">Recommendation</label>
                                <textarea class="form-control" id="editRecommendation" name="i_Recommendation" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveEditBtn">Save Changes</button>
                    </div>
                </form>
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

<!-- Success Modal -->
<div class="modal fade" id="archive-violation-success-modal" tabindex="-1" role="dialog" aria-labelledby="archiveViolationSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Violation Archived Successfully!</h4>
        <p class="mt-3">The violation has been archived successfully.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="archive-violation-error-modal" tabindex="-1" role="dialog" aria-labelledby="archiveViolationErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Archiving Failed!</h4>
        <p class="mt-3" id="errorMessage">Something went wrong while archiving the violation.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!--end  modals -->
<script ../assets/src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script ../assets/src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script ../assets/src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script ../assets/src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script ../assets/src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script ../assets/src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script ../assets/src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script ../assets/src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script ../assets/src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script ../assets/src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
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
		<script ../assets/src="../assets/../assets/vendors/scripts/sunctions_crud.js"></script>
    <script ../assets/src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script ../assets/src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>


	</body>
</html>
