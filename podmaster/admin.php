
<?php
include 'sessioning.php';
?>


<!-- Modal HTML -->
<div id="duplicateModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 8px; width: 50%; max-width: 600px; margin: 100px auto; display: grid; grid-template-columns: 1fr; gap: 15px;">
        <span class="close" style="cursor: pointer; position: absolute; top: 10px; right: 10px; font-size: 20px;">&times;</span>
        <h2 style="font-size: 24px; text-align: center; grid-column: span 2;">Duplicate Usernames</h2>
        
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


<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>DAMS</title>
        <?php include 'parts/links.php' ?>
	</head>
<?php include 'parts/header.php'?>
        <div class="mobile-menu-overlay"></div>
        <div class="main-container">
            <!-- Data Table with multiple select row start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Manage Admins</h4>
                </div>
                <div class="pb-20">
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-striped nowrap" style="width: 100%;" id="adminTable">
                            <thead>
                                <tr>
                                <th class="table-plus datatable-nosort">NO</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Name</th>
                                <th style="border: 1px solid #ddd; padding: 4px;">Role</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Phone Number</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Username</th>
                                <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="adminTableBody">
                                <!-- Rows will be populated here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<!-- View Admin Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Admin Details</h5>
              
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td id="viewName"></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td id="viewRole"></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td id="viewPhone"></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td id="viewUsername"></td>
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




 <!-- Edit Admin Modal (Bootstrap 4) -->
<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="editForm" onsubmit="event.preventDefault(); saveChanges();">
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
          <input type="hidden" id="editAdminID"> <!-- hidden field for admin ID -->

          <div class="row">
            <!-- First Column -->
            <div class="col-md-6 pr-3">
              <div class="form-group mb-3">
                <label for="editFirstname">First Name</label>
                <input type="text" class="form-control" id="editFirstname" required>
              </div>
              <div class="form-group mb-3">
                <label for="editLastname">Last Name</label>
                <input type="text" class="form-control" id="editLastname" required>
              </div>
              <div class="form-group mb-3">
                <label for="editRole">Role</label>
                <input type="text" class="form-control" id="editRole" value="Admin" placeholder="Admin" readonly>
              </div>
            </div>

            <!-- Second Column -->
            <div class="col-md-6 pl-3">
              <div class="form-group mb-3">
                <label for="editPhone">Phone Number</label>
                <input type="text" class="form-control" id="editPhone" required>
                <small id="phone-error" class="text-danger" style="display:none;"></small>
              </div>

              <div class="form-group mb-3">
                <label for="editUsername">Username</label>
                <input type="text" class="form-control" id="editUsername" required>
                <small id="username-error" class="text-danger" style="display:none;">
                  Username is required, must be alphanumeric, and cannot be already taken.
                </small>
              </div>

              <div class="form-group mb-3">
                <label for="editGmail">Gmail</label>
                <input type="email" class="form-control" id="editGmail" required>
                <small id="gmail-error" class="text-danger" style="display:none;">
                  Please enter a valid Gmail address ending with @smcbi.edu.ph.
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- SUCCESS MODAL -->
<div class="modal fade" id="edit-success-modal" tabindex="-1" role="dialog" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Admin Updated Successfully!</h4>
        <p class="mt-3">The admin record has been saved.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- ERROR MODAL -->
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
        <p class="mt-3">Something went wrong while saving the admin record.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" onclick="$('#error-modal').modal('hide');">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Archive Admin Confirmation Modal -->
<div class="modal fade" id="archiveAdminConfirmModal" tabindex="-1" aria-labelledby="archiveAdminConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title" id="archiveAdminConfirmModalLabel">Archive Admin</h5>
        <!-- Close Button -->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to archive this admin?
        <input type="hidden" id="archiveAdminId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="confirmAdminArchive()">Yes, Archive</button>
      </div>
    </div>
  </div>
</div>

<!-- Archive Admin duplication Modal -->
<div class="modal fade" id="duplicateIdModal" tabindex="-1" role="dialog" aria-labelledby="duplicateIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Already Archived!</h4>
        <p class="mt-3">This admin record has already been archived.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal (Restore Success) -->
<div class="modal fade" id="archive-success-modal" tabindex="-1" role="dialog" aria-labelledby="restoreSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Record archive Successfully!</h4>
        <p class="mt-3">The record has been restored.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>


<!-- Error Modal -->
<div class="modal fade" id="archive-error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Record archive Failed!</h4>
        <p class="mt-3">Something went wrong while archiving the record.</p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Other HTML content goes here -->
<!-- External Scripts -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>

<!-- ApexCharts (if used for visualizations) -->
<script src="src/plugins/apexcharts/apexcharts.min.js"></script>

<!-- DataTables Plugins -->
<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable Setting js -->
<script src="vendors/scripts/datatable-setting.js"></script>

<!-- Custom Scripts -->
<script src="vendors/scripts/dashboard.js"></script>
  <script src="vendors/scripts/admin_crud.js"></script>
  
  <script src="vendors/scripts/add_admin.js"></script>
  <script>
      // Assuming the logged-in user's role is stored in a session variable
        window.loggedInUserRole = '<?php echo $_SESSION['a_Role']; ?>'; 
  </script>

</body>
</html>

	</body>
</html>
