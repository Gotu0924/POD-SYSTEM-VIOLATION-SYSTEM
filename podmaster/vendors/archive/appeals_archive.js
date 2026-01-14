// Global Variable
let appealIdToDelete = null; // Stores the ID of the appeal to be deleted

// =========================
// Delete Appeal Functions
// =========================

// Function to trigger the delete confirmation modal
function confirmDeleteappeals(id) {
  appealIdToDelete = id; // Set the appeal ID to delete
  $('#deleteConfirmationModal').modal('show'); // Show the modal
}

// Function to handle deletion of an appeal
function deleteAppeal() {
  fetch(`delete_appeal.php?id=${appealIdToDelete}`, {
      method: "DELETE",
      headers: {
          "Content-Type": "application/json"
      }
  })
  .then(response => {
      if (response.ok) {
          // Remove the deleted row from the table
          const rowToDelete = document.querySelector(`#appealRow-${appealIdToDelete}`);
          if (rowToDelete) {
              rowToDelete.remove();
          }
          $('#deleteConfirmationModal').modal('hide'); // Close the modal
      } else {
          alert("Failed to delete appeal. Please try again.");
          $('#deleteConfirmationModal').modal('hide');
      }
  })
  .catch(error => {
      console.error("Error deleting appeal:", error);
      alert("An error occurred while deleting the appeal.");
      $('#deleteConfirmationModal').modal('hide');
  });
}

// Event listener for confirmation button
$('#confirmDeleteBtn').on('click', deleteAppeal);

// =========================
// Fetch and Display Appeals
// =========================

// Function to fetch and display appeal data
function fetchAppeals() {
  fetch('get_appeals_archive.php') // Use appropriate server-side URL
    .then(response => response.json())
    .then(data => {
      const tableBody = document.getElementById('appealTableBody');
      tableBody.innerHTML = ''; // Clear the table body before appending new rows

      data.forEach(row => {
        const tableRow = document.createElement('tr');
        tableRow.id = `appealRow-${row.appeal_ID}`; // Set a unique ID for each row
        
        tableRow.innerHTML = `
          <td class="table-plus">${row.appeal_ID}</td>
          <td>${row.violation_number}</td>
          <td>${row.st_ID}</td>
          <td>${row.sender_name}</td>
          <td>${row.course}</td>
          <td>${row.year_level}</td>
          <td>${row.l_Time}</td>
          <td>
                    <div class="btn btn-group">
                        <button class="btn btn-success" onclick="RestoreAppeals(${row.appeal_ID})"><i class="dw dw-eye"></i> Restore</button>
                        <button class="btn btn-danger" onclick="deleteAppeals(${row.appeal_ID})"><i class="dw dw-delete-3"></i> Delete</button>
                    </div>
                </td>
        `;
        tableBody.appendChild(tableRow);
      });

      // Initialize DataTable after adding rows
      if ($.fn.dataTable.isDataTable('#appealable')) {
          $('#appealable').DataTable().destroy();
      }
      
      $('#appealable').DataTable({
        searching: true,
        paging: true,
        scrollX: true,
        autoWidth: false,
        columnDefs: [
          { orderable: false, targets: [5, -1] }, // Disable sorting for actions
          { width: "10%", targets: 0 },   // Appeal ID
          { width: "20%", targets: 1 },   // Student ID
          { width: "20%", targets: 2 },   // Sender Name
          { width: "20%", targets: 3 },   // Course
          { width: "10%", targets: 4 },   // Year Level
          { width: "20%", targets: -1 }   // Actions
        ],

        initComplete: function () {
          let api = this.api();

          // Build filters for appeal ID, course, and year level
          function buildFilters() {
            let filterColumns = [ // Appeal ID filter
              { index: 4, label: "Course" },     // Course filter
              { index: 5, label: "Year Level" }  // Year Level filter
            ];

            // Get the container for length (this is where the filters will be appended)
            let lengthContainer = $('#appealable_length');
            lengthContainer.find('.custom-filters').remove(); // Clear previous filters
            let filterContainer = $('<div class="custom-filters d-inline-flex align-items-center ms-10"></div>');

            // Add the select filters for each column
            filterColumns.forEach(function (col) {
              let select = $('<select class="form-control form-control-sm me-10"><option value="">' + col.label + '</option></select>')
                .on('change', function () {
                  let val = $.fn.dataTable.util.escapeRegex($(this).val());
                  api.column(col.index).search(val ? '^' + val + '$' : '', true, false).draw();
                });

              // Populate options for each column filter
              api.column(col.index).data().unique().sort().each(function (d) {
                if (d) {
                  select.append('<option value="' + d + '">' + d + '</option>');
                }
              });

              filterContainer.append(select);
            });

            // Append the filter container beside the length selector
            lengthContainer.append(filterContainer);
          }

          // Build filters initially
          buildFilters();

          // Rebuild filters after redraw (when length changes, pagination, etc.)
          api.on('draw', buildFilters);
        }
      });
    })
    .catch((error) => console.error('Error fetching appeals:', error));
}



// Function to view appeal details
function viewAppeal(appeal_ID) {
  fetch('get_appeal_details.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ appeal_ID: appeal_ID })
  })
  .then(response => response.json())
  .then(data => {
      const modalBody = document.getElementById('viewModalBody');
      modalBody.innerHTML = `
          <table class="table table-bordered">
              <tbody>
                  <tr>
                      <th>Appeal ID</th>
                      <td>${data.appeal_ID}</td>
                  </tr>
                  <tr>
                      <th>Student ID</th>
                      <td>${data.st_ID}</td>
                  </tr>
                  <tr>
                      <th>Appeal Message</th>
                      <td>${data.l_appeal_message}</td>
                  </tr>
                  <tr>
                      <th>Time</th>
                      <td>${data.l_Time}</td>
                  </tr>
              </tbody>
          </table>
      `;
      $('#viewModal').modal('show');
  })
  .catch(error => console.error('Error fetching appeal details:', error));
}

// Fetch and display appeal data when the page loads
document.addEventListener('DOMContentLoaded', fetchAppeals);


// Function to trigger restore confirmation modal
function RestoreAppeals(appeal_ID) {
    // Set the appeal ID in the hidden field of the modal
    document.getElementById('restoreAppealId').value = appeal_ID;
    $('#restoreConfirmModal').modal('show'); // Show the modal
}

// Function to trigger delete confirmation modal
function deleteAppeals(appeal_ID) {
    // Set the appeal ID in the hidden field of the modal
    document.getElementById('deleteAppealId').value = appeal_ID;
    $('#deleteConfirmationModal').modal('show'); // Show the modal
}

// Function to confirm the restore action
function confirmRestore() {
    const appealId = document.getElementById('restoreAppealId').value;
    
    fetch('restore_appeal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ appeal_ID: appealId })
    })
  .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success modal
            $('#restore-appeal-success-modal').modal('show');
        } else {
            // Show error modal
            $('#appeal-error-modal').modal('show');
        }
    })
    .catch(error => {
        // Show error modal
        $('#appeal-error-modal').modal('show');
        console.error(error);
    });

    $('#restoreConfirmModal').modal('hide'); // Close the modal
}

// Function to confirm the delete action
function confirmDelete() {
    const appealId = document.getElementById('deleteAppealId').value;
    
    fetch('delete_appeal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ appeal_ID: appealId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload the page to reflect changes
        } else {
            alert('Error deleting appeal.');
        }
    })
    .catch(error => {
        alert('An error occurred.');
        console.error(error);
    });

    $('#deleteConfirmationModal').modal('hide'); // Close the modal
}

