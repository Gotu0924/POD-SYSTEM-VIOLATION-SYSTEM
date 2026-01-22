    function fetchLogsData() {
    fetch("fetch_logs.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("logsTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        // Populate the table with log data
        data.forEach(log => {
            const row = document.createElement("tr");
            row.setAttribute("data-id", log.i_ID);  // i_ID for Log ID
            row.innerHTML = `
                <td>${log.violation_number}</td> <!-- Student ID -->
                <td>${log.st_ID}</td> <!-- Student ID -->
                <td>${log.st_name}</td> <!-- Student ID -->
                <td>${log.i_Category}</td> <!-- Category -->
                <td>${log.list_Offense}</td> <!-- Offense -->
                <td>${log.a_username}</td> <!-- Staff -->
                <td>${log.i_Status}</td> <!-- Status -->
                <td>
                    <div class="btn-group">
                         <button class="btn btn-success" onclick="viewLog(${log.i_ID})"><i class="dw dw-eye"></i> View</button>
                        <button class="btn btn-danger" onclick="deleteLog(${log.i_ID})"><i class="dw dw-delete-3"></i> Delete</button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Re-initialize DataTable
        if ($.fn.dataTable.isDataTable('#logsTable')) {
            $('#logsTable').DataTable().clear().destroy();
        }
        const table = $('#logsTable').DataTable({
            searching: true,
            paging: true,
            scrollX: true, 
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [6] }, // Disable sorting for actions column
                { width: "10%", targets: 0 },   // Log ID
                { width: "15%", targets: 1 },   // Student ID
                { width: "20%", targets: 2 },   // Category
                { width: "20%", targets: 3 },   // Offense
                { width: "15%", targets: 4 },   // Staff
                { width: "15%", targets: 5 },   // Status
                { width: "15%", targets: 6 }    // Actions
            ]
        });

        // Build filters for Category, Offense, and Staff columns
        function buildFilters() {
            let filterColumns = [
                { index: 3, label: "Category" },     // Category filter
                { index: 4, label: "Offense" },      // Offense filter
                { index: 5, label: "Recorded" }         // Staff filter
            ];

            // Get the container for length (this is where the filters will be appended)
            let lengthContainer = $('#logsTable_length');
            lengthContainer.find('.custom-filters').remove(); // Clear previous filters
            let filterContainer = $('<div class="custom-filters d-inline-flex align-items-center ms-10"></div>');

            // Add the select filters for each column
            filterColumns.forEach(function (col) {
                let select = $('<select class="form-control form-control-sm me-10"><option value="">' + col.label + '</option></select>')
                    .on('change', function () {
                        let val = $.fn.dataTable.util.escapeRegex($(this).val());
                        table.column(col.index).search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                // Populate options for each column filter
                table.column(col.index).data().unique().sort().each(function (d) {
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
        table.on('draw', buildFilters);

        // Initialize Bootstrap dropdowns
        document.querySelectorAll('.dropdown-toggle').forEach(dropdown => {
            new bootstrap.Dropdown(dropdown);
        });
    })
    .catch(error => console.error("Error fetching logs:", error));
}

    // Fetch existing logs data on page load
    fetchLogsData();
    function viewLog(logId) {
        fetch(`view_log.php?id=${logId}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            const logDetails = data[0]; // Assuming the response is an array with one log object
            
            // Fill in the modal with log details
            document.getElementById("logDetailContent").innerHTML = `
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>Log ID</th><td>${logDetails.i_ID}</td></tr>
                        <tr><th>Student ID</th><td>${logDetails.s_ID}</td></tr>
                        <tr><th>Category</th><td>${logDetails.i_Category}</td></tr>
                        <tr><th>Offense</th><td>${logDetails.list_Offense}</td></tr>
                        <tr><th>Sanctions</th><td>${logDetails.i_Sanctions}</td></tr>
                        <tr><th>Suspension Type</th><td>${logDetails.Suspension_Type}</td></tr>
                        <tr><th>Details</th><td>${logDetails.i_Details}</td></tr>
                        <tr><th>Recommendation</th><td>${logDetails.i_Recommendation}</td></tr>
                        <tr><th>Sent By</th><td>${logDetails.a_username}</td></tr>
                        <tr><th>Status</th><td>${logDetails.i_Status}</td></tr>
                    </tbody>
                </table>
            `;

            // Show the modal using Bootstrap
            $('#logDetailModal').modal('show');
        })
        .catch(error => console.error("Error viewing log:", error));
    }

    function closeModal() {
        $('#logDetailModal').modal('hide'); // Hide the modal using Bootstrap
    }
    // Function to trigger the delete log action
    function deleteLog(logId) {
        logToDelete = logId; // Store the log ID to be deleted
        $('#confirmation-modal').modal('show'); // Show the confirmation modal
    }

    // Confirm delete action
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (logToDelete !== null) {
            fetch(`delete_log.php?id=${logToDelete}`, {
                method: "DELETE", // Send DELETE request to delete the log
                headers: {
                    "Content-Type": "application/json"
                }
            })
          .then(response => response.json())
            .then(data => {
                if (data.success) { 
                    $('#success-inbox-modal').modal('show'); // Show success modal
                    window.location.reload(); // Reload page after modal display
                } else {
                    $('#error-inbox-modal').modal('show'); // Show error modal
                }
            })

            .catch(error => console.error("Error deleting log:", error));
        }
    });
