function fetchViolations() {
    fetch('fetch_history.php')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById('data-sanction-Body');
        tableBody.innerHTML = '';

        data.forEach(violation => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${violation.violation_number}</td>
                <td>${violation.st_ID}</td>
                <td>${violation.st_name}</td>
                <td>${violation.i_Category}</td>
                <td>${violation.list_Offense}</td>
                <td>${violation.i_Sanctions}</td>
                <td>${violation.i_Status}</td>
                <td class="text-center">
                    <div class="btn-group-vertical d-inline-flex">
                        <button class="btn btn-success btn-sm mb-1" onclick="viewSanction(${violation.log_ID})">
                            <i class="dw dw-eye"></i> View
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Destroy old DataTable if exists
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
                api.on('draw', buildFilters);
            }
        });
    })
    .catch(error => console.error('Error fetching violations:', error));
}


// Function to fetch and display sanction details in the modal
function viewSanction(log_ID) {
    fetch(`view_history.php?id=${log_ID}`)
        .then(response => response.json())
        .then(data => {
            if (data && Object.keys(data).length > 0) {
                // Populate modal fields
                document.getElementById('viewViolationNumber').textContent = data.violation_number || '-';
                document.getElementById('viewStudentID').textContent = data.st_ID || '-';
                document.getElementById('viewstname').textContent = data.st_name || '-';
                document.getElementById('viewCategory').textContent = data.i_Category || '-';
                document.getElementById('viewOffense').textContent = data.list_Offense || '-';
                document.getElementById('viewSanctions').textContent = data.i_Sanctions || '-';
                document.getElementById('viewSuspensionType').textContent = data.Suspension_Type || '-';
                document.getElementById('viewDetails').textContent = data.i_Details || '-';
                document.getElementById('viewRecommendation').textContent = data.i_Recommendation || '-';
                document.getElementById('viewStatus').textContent = data.i_Status || '-';
                document.getElementById('viewUsername').textContent = data.a_username || '-';
                document.getElementById('viewCreatedAt').textContent = data.created_at || '-';

                // Show the modal
                $('#viewModal').modal('show');
            } else {
                alert('No data found for this sanction.');
            }
        })
        .catch(error => {
            console.error('Error fetching sanction details:', error);
            alert('Failed to fetch sanction details.');
        });
}




document.addEventListener('DOMContentLoaded', fetchViolations);