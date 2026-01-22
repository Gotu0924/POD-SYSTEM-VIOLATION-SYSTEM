
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
                    <h4 class="text-blue h4">Manage Admins</h4>
                </div>
                <div class="pb-20">
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-striped nowrap" style="width: 100%;" id="adminTable">
                            <thead>
                                <tr>
                                <th class="table-plus datatable-nosort">ID</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Name</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Role</th>
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
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Edit Modal -->
<div class="modal fade" id="editadminModal" tabindex="-1" role="dialog" aria-labelledby="editadminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="editForm" onsubmit="event.preventDefault(); saveChanges();">
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" class="form-control" id="editTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="editFirstname">First Name</label>
                        <input type="text" class="form-control" id="editFirstname" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastname">Last Name</label>
                        <input type="text" class="form-control" id="editLastname" required>
                    </div>
                    <div class="form-group">
                        <label for="editRole">Role</label>
                        <input type="text" class="form-control" id="editRole" value="Admin" placeholder="Admin" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone Number</label>
                        <input type="text" class="form-control" id="editPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="text" class="form-control" id="editUsername" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add Admin Modal -->
<div class="modal fade" id="addAddminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addAdminModalLabel">Add Admin</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
       <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
        <form id="addAdminForm">
          <div class="form-group">
            <label for="addTitle">Title</label>
            <input type="text" id="addTitle" class="form-control" placeholder="Enter title (e.g., Mr., Ms.)" required />
          </div>
          <div class="form-group">
            <label for="addFirstname">First Name</label>
            <input type="text" id="addFirstname" class="form-control" placeholder="Enter first name" required />
          </div>
          <div class="form-group">
            <label for="addLastname">Last Name</label>
            <input type="text" id="addLastname" class="form-control" placeholder="Enter last name" required />
          </div>
          <div class="form-group">
            <label for="addRole">Role</label>
            <select id="addRole" class="form-control" required>
              <option value="admin">Admin</option>
              <option value="staff">Staff</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addPhoneNumber">Phone Number</label>
            <input type="text" id="addPhoneNumber" class="form-control" placeholder="Enter phone number" required />
          </div>
          <div class="form-group">
            <label for="addUsername">Username</label>
            <input type="text" id="addUsername" class="form-control" placeholder="Enter username" required />
          </div>
          <div class="form-group">
            <label for="a_addPassword">Password</label>
            <input type="password" id="a_addPassword" class="form-control" placeholder="Enter password" required onkeyup="validatePasswordAdmin()" />
          </div>
          <div class="form-group">
            <label for="confirmPasswordadmin">Confirm Password</label>
            <input type="password" id="confirmPasswordadmin" class="form-control" placeholder="Re-enter password" required onkeyup="validatePasswordAdmin()" />
            <small id="passwordErroradmin" class="text-danger d-none">Passwords do not match</small>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addAdmin()">Add Admin</button>
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
                <p>Are you sure you want to delete this Admin ? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Restore Admin Confirmation Modal -->
<div class="modal fade" id="restoreAdminConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title">Restore Admin</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to restore this admin?
        <input type="hidden" id="restoreAdminId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmRestoreAdmin()">Yes, Restore</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Admin Confirmation Modal -->
<div class="modal fade" id="deleteAdminConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title">Delete Admin</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this admin? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="confirmDeleteAdmin()">Delete</button>
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



<!-- Success Modal (Restore Success) -->
<div class="modal fade" id="delete-success-modal" tabindex="-1" role="dialog" aria-labelledby="restoreSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" points="100.2,40.2 51.5,88.8 29.8,67.5"/>
        </svg>
        <h4 class="text-success mt-3">Record archive Successfully Deleted!</h4>
        <p class="mt-3">The record has been Deleted.</p>
        <button type="button" class="btn btn-sm mt-3 btn-success" onclick="location.reload();">Done</button>
      </div>
    </div>
  </div>
</div>


<!-- Error Modal -->
<div class="modal fade" id="delete-error-modal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#dc3545" stroke-width="6" cx="65.1" cy="65.1" r="62.1"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="40.2" y1="40.2" x2="90" y2="90"/>
          <line class="path line" fill="none" stroke="#dc3545" stroke-width="6" x1="90" y1="40.2" x2="40.2" y2="90"/>
        </svg>
        <h4 class="text-danger mt-3">Record archive Deletion Failed!</h4>
        <p class="mt-3">Something went wrong while Deleting the record.</p>
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
		<script ../assets/src="../assets/../assets/vendors/scripts/add_admin.js"></script>
		<script ../assets/src="../assets/../assets/vendors/archive/archive_admin.js"></script>
	</body>
</html>
