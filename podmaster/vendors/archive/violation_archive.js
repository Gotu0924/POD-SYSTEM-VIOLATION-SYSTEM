function fetchSanctions() {
    fetch("fetch_sanctions_archive.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("data-sanction-Body");
        tableBody.innerHTML = ""; // Clear existing data

        // Populate table with sanction data
        data.forEach(sanction => {
            const row = document.createElement("tr");
            row.setAttribute("data-id", sanction.i_ID);
            row.innerHTML = `
                <td class="table-plus">${sanction.i_ID}</td>
                <td>${sanction.violation_number}</td>
                <td>${sanction.st_ID}</td>
                <td>${sanction.list_Offense}</td>
                <td>${sanction.Suspension_Type}</td>
                <td>${sanction.a_username}</td>
                <td>${sanction.i_Status}</td>
                 <td>
                    <div class="btn btn-group">
                    <button class="btn btn-warning" onclick="viewSanction(${sanction.i_ID})">
                            <i class="dw dw-eye"></i> View
                        </button>
                        <button class="btn btn-success" onclick="RestoreViolation(${sanction.i_ID})"><i class="dw dw-refresh"></i> Restore</button>
                        <button class="btn btn-danger" onclick="deleteViolation(${sanction.i_ID})"><i class="dw dw-delete-3"></i> Delete</button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Destroy existing DataTable instance if it exists
        if ($.fn.dataTable.isDataTable('#sanctionTable')) {
            $('#sanctionTable').DataTable().clear().destroy();
        }

        // Initialize DataTable
        $('#sanctionTable').DataTable({
            searching: true,
            paging: true,
            autoWidth: false,
            scrollX: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [6] }, // Disable sorting for "Actions" column (index 6)
                { width: "8%", targets: 0 },   // Violation Number
                { width: "12%", targets: 1 },  // Student ID
                { width: "15%", targets: 2 },  // Category
                { width: "20%", targets: 3 },  // Offense
                { width: "15%", targets: 4 },  // Sanctions
                { width: "15%", targets: 5 },  // Suspension Type
                { width: "13%", targets: 6 }   // Actions
            ],
            initComplete: function () {
                let api = this.api();

                function buildFilters() {
                    let filterColumns = [
                        { index: 3, label: "Offense" },       // Column 3: Offense
                        { index: 4, label: "Suspension Type" }, // Column 4: Suspension Type
                        { index: 6, label: "Status" }          // Column 5: Status
                    ];

                    let lengthContainer = $('#sanctionTable_length');
                    lengthContainer.find('.custom-filters').remove(); // Clear old ones

                    // Create a new container to hold the filters next to the length control
                    let filterContainer = $('<div class="custom-filters d-inline-flex align-items-center ms-10"></div>');

                    // Add the select filters
                    filterColumns.forEach(function (col) {
                        let select = $('<select class="form-control form-control-sm me-10"><option value="">' + col.label + '</option></select>')
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(col.index).search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        // Populate options
                        api.column(col.index).data().unique().sort().each(function (d) {
                            if (d) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            }
                        });

                        filterContainer.append(select);
                    });

                    // Append the filter container right after the length control
                    lengthContainer.append(filterContainer);
                }

                // Build filters initially
                buildFilters();

                // Rebuild filters after redraw (when length changes, pagination, etc.)
                api.on('draw', buildFilters);
            }
        });
    })
    .catch((error) => console.error('Error fetching violations:', error));
}

// Fetch existing sanctions data on page load
document.addEventListener("DOMContentLoaded", fetchSanctions);

function viewSanction(i_ID) {
    fetch('get_sanction_details.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ i_ID: i_ID })
    })
    .then(response => response.json())
    .then(data => {
        // Populate the modal with the fetched sanction details
        document.getElementById('viewSanctionID').textContent = data.i_ID;
        document.getElementById('viewviolation').textContent = data.violation_number;
        document.getElementById('viewStudentID').textContent = data.st_ID;
        document.getElementById('viewCategory').textContent = data.i_Category;
        document.getElementById('viewOffense').textContent = data.list_Offense;
        document.getElementById('viewSanctions').textContent = data.i_Sanctions;
        document.getElementById('viewSuspensionType').textContent = data.Suspension_Type;
        document.getElementById('viewDetails').textContent = data.i_Details;
        document.getElementById('viewRecommendation').textContent = data.i_Recommendation;
        document.getElementById('viewrecorded').textContent = data.a_username;
        document.getElementById('viewStatus').textContent = data.i_Status;

        // Show the modal
        $('#viewModal').modal('show');
    })
    .catch(error => console.error('Error fetching sanction details:', error));
}

function deleteViolation(id) {
    document.getElementById("deleteSanctionId").value = id;
    $('#deleteSanctionConfirmModal').modal('show');
}




function RestoreViolation(id) {
    document.getElementById("restoreSanctionId").value = id;
    $('#restoreSanctionConfirmModal').modal('show');
}
function confirmRestoreSanction() {
    let id = document.getElementById("restoreSanctionId").value;

    fetch("restore_sanction.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `i_ID=${id}`
    })
    .then(response => response.json())
    .then(data => {
        $('#restoreSanctionConfirmModal').modal('hide');
        if (data.success) {
            $('#restore-success-modal').modal('show');
            fetchSanctions();
        } else {
            $('#restore-error-modal').modal('show');
        }
    })

    .catch(error => console.error("Error restoring sanction:", error));
}


function confirmDeleteSanction() {
    let id = document.getElementById("deleteSanctionId").value;

    fetch("delete_sanction_arch.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `i_ID=${id}`
    })
    .then(response => response.json())
    .then(data => {
        $('#deleteSanctionConfirmModal').modal('hide');
        alert(data.message);
        if (data.success) fetchSanctions();
    })
    .catch(error => console.error("Error deleting sanction:", error));
}
