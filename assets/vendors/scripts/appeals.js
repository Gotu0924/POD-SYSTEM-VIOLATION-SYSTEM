// Function to fetch and display appeal data
function fetchAppeals() {
  fetch('get_appeals.php') // Use appropriate server-side URL
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
  <td class="text-center">
      <div class="btn-group-vertical d-inline-flex">
          <button class="btn btn-success btn-sm mb-1" onclick="viewAppeal(${row.appeal_ID})">
              <i class="dw dw-eye"></i> View
          </button>
          <button class="btn btn-secondary btn-sm" onclick="archiveAppeal(${row.appeal_ID})">
              <i class="dw dw-archive"></i> Archive
          </button>
      </div>
  </td>
`;

        tableBody.appendChild(tableRow);
      });

      // Destroy the old DataTable if exists
      if ($.fn.dataTable.isDataTable('#appealable')) {
        $('#appealable').DataTable().clear().destroy();
      }

      // Initialize DataTable after adding rows
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

// Close media viewer modal when clicking anywhere inside viewModalBody
document.addEventListener("DOMContentLoaded", function () {
    const viewModalBody = document.getElementById("viewModalBody");
    if (viewModalBody) {
        viewModalBody.addEventListener("click", function () {
            $('#viewModal').modal('hide');
        });
    }
});


function viewAppeal(appeal_ID) {
  fetch('get_appeal_details.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ appeal_ID: appeal_ID })
  })
  .then(response => response.json())
  .then(data => {
      const modalBody = document.getElementById('viewModalBody');

      // Appeal details table
      modalBody.innerHTML = `
          <table class="table table-bordered">
              <tbody>
                  <tr><th>#</th><td>${data.appeal_ID}</td></tr>
                  <tr><th>Violation Number</th><td>${data.violation_number}</td></tr>
                  <tr><th>Student ID</th><td>${data.st_ID}</td></tr>
                  <tr><th>Sender Name</th><td>${data.sender_name}</td></tr>
                  <tr><th>Sender Email</th><td>${data.sender_email}</td></tr>
                  <tr><th>Course</th><td>${data.course}</td></tr>
                  <tr><th>Year Level</th><td>${data.year_level}</td></tr>
                  <tr><th>Appeal Message</th><td>${data.l_appeal_message}</td></tr>
                  <tr><th>Time</th><td>${data.l_Time}</td></tr>
              </tbody>
          </table>
      `;

      // Prepare media arrays
      const images = data.images ? data.images.split(",") : [];
      const videos = data.videos ? data.videos.split(",") : [];

      const viewMediaBtn = document.getElementById("viewMediaBtn");

      // If we have media, show button
      if ((images.length && images[0] !== "") || (videos.length && videos[0] !== "")) {
          viewMediaBtn.style.display = "inline-block";
          viewMediaBtn.onclick = function() {
              const mediaBody = document.getElementById("mediaViewerBody");
              mediaBody.innerHTML = `
                 <div class="row g-4">
                  <!-- Images -->
                  <div class="col-md-6">
                      <h6 class="mb-3 fw-bold text-primary">📷 Proof Images</h6>
                      <div class="d-flex flex-wrap gap-2 p-2 border rounded bg-light" id="mediaImages">
                          
                      </div>
                  </div>

                  <!-- Videos -->
                  <div class="col-md-6">
                      <h6 class="mb-3 fw-bold text-danger">🎥 Proof Videos</h6>
                      <div class="d-flex flex-wrap gap-2 p-2 border rounded bg-light" id="mediaVideos">
                        
                      </div>
                  </div>
              </div>

              `;

              // Insert images
              const imgContainer = document.getElementById("mediaImages");
              if (images.length && images[0] !== "") {
                  images.forEach(img => {
                      const el = document.createElement("img");
                      el.src = img.trim();
                      el.className = "img-fluid m-1 rounded shadow-sm";
                      el.style.maxWidth = "100%";
                      el.style.height = "200px";
                      el.style.cursor = "pointer";
                      el.onclick = () => window.open(img, "_blank");
                      imgContainer.appendChild(el);
                  });
              } else {
                  imgContainer.innerHTML = "<p class='text-muted'>No images</p>";
              }

              // Insert videos
              const vidContainer = document.getElementById("mediaVideos");
              if (videos.length && videos[0] !== "") {
                  videos.forEach(vid => {
                      const el = document.createElement("video");
                      el.controls = true;
                      el.className = "m-1 rounded shadow-sm";
                      el.style.maxWidth = "100%";
                      el.style.height = "200px";
                      el.innerHTML = `<source src="${vid.trim()}" type="video/mp4">`;
                      vidContainer.appendChild(el);
                  });
              } else {
                  vidContainer.innerHTML = "<p class='text-muted'>No videos</p>";
              }

              // Close the details modal before opening media
              $('#viewModal').modal('hide');
              $('#mediaViewerModal').modal('show');
          };
      } else {
          viewMediaBtn.style.display = "none";
      }

      // Show the appeal details modal
      $('#viewModal').modal('show');
  })
  .catch(error => console.error('Error fetching appeal details:', error));
}

// =================================
// Archive Appeal
// =========================

// Open the modal and set appeal ID
function archiveAppeal(appealID) {
  document.getElementById("archiveAppealId").value = appealID;
  $('#archiveAppealConfirmModal').modal('show');
}

// Confirm archive
function confirmAppealArchive() {
  const appealID = document.getElementById("archiveAppealId").value;

  fetch('archive_appeal.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'appeal_ID=' + appealID
  })
 .then(response => response.json())
.then(data => {
  $('#archiveAppealConfirmModal').modal('hide'); // Close confirmation modal

  if (data.success) {
    // Show success modal
    $('#appeal-archive-success-modal').modal('show');
  } else {
    // Show error modal
    $('#appeal-archive-error-modal').modal('show');
    $('#appeal-archive-error-message').text(data.message || "Something went wrong while archiving the appeal.");
  }
})
.catch(error => {
  $('#archiveAppealConfirmModal').modal('hide');
  $('#appeal-archive-error-modal').modal('show');
  $('#appeal-archive-error-message').text("Request failed: " + error);
});

}


// Fetch and display appeal data when the page loads
document.addEventListener('DOMContentLoaded', fetchAppeals);
