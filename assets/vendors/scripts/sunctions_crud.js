function fetchViolations() {
    fetch('fetch_violations.php', { method: 'GET' })
        .then((response) => response.json())
        .then((data) => {
            const tableBody = document.getElementById('data-sanction-Body');
            tableBody.innerHTML = '';

            const now = new Date();

            data.forEach((violation) => {
                const row = document.createElement('tr');
                const violationDate = new Date(violation.time);
                const diffDays = (now - violationDate) / (1000 * 60 * 60 * 24);

                // Row coloring
                if (diffDays >= 7 && diffDays < 30) {
                    row.style.backgroundColor = "#cce5ff"; 
                    row.style.color = "#004085";
                } else if (diffDays >= 30) {
                    row.style.backgroundColor = "#343a40"; 
                    row.style.color = "#ffffff";
                }

                row.innerHTML = `
                    <td>${violation.st_ID}</td>
                    <td>${violation.st_name}</td>
                    <td>${violation.list_Offense}</td>
                    <td>${violation.Suspension_Type}</td>
                    <td>${violation.i_Status}</td>
                    <td>${violation.time}</td>
                    <td class="text-center">
                        <div class="btn-group-vertical d-inline-flex">
                            <button class="btn btn-success btn-sm mb-1" onclick="viewSanction(${violation.i_ID})">
                                <i class="dw dw-eye"></i> View
                            </button>
                            <button class="btn btn-warning btn-sm mb-1" onclick="editSanction(${violation.i_ID})" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="dw dw-edit2"></i> Edit
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="archiveViolation(${violation.i_ID})">
                                <i class="dw dw-inbox"></i> Archive
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            if ($.fn.dataTable.isDataTable('#sanctionTable')) {
                $('#sanctionTable').DataTable().clear().destroy();
            }

            // Initialize DataTable with search bar + custom filters inline
            const table = $('#sanctionTable').DataTable({
                dom: '<"d-flex justify-content-between mb-2"f<"#sanction-filters">>rtip',
                paging: true,
                autoWidth: false,
                scrollX: false,
                responsive: true,
                columnDefs: [{ orderable: false, targets: [6] }],
                initComplete: function () {
                    setupExportButtons();
                    const api = this.api();

                    // Filters container inline next to search
                    const filterContainer = $('#sanction-filters');  
                     filterContainer.addClass('d-flex align-items-center gap-2 me-3'); 

                    // Column filters
                    const filterColumns = [
                        { index: 2, label: "Offense" },
                        { index: 3, label: "Suspension Type" },
                        { index: 4, label: "Status" }
                    ];

                    filterColumns.forEach(col => {
                        const select = $(`<select class="form-control form-control-sm"><option value="">${col.label}</option></select>`)
                            .on('change', function() {
                                const val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(col.index).search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        api.column(col.index).data().unique().sort().each(d => {
                            if(d) select.append(`<option value="${d}">${d}</option>`);
                        });
                        filterContainer.append(select);
                    });

                    // Date range inputs
                    const minDate = $('<input type="date" id="minDate" class="form-control form-control-sm">');
                    const maxDate = $('<input type="date" id="maxDate" class="form-control form-control-sm">');
                    filterContainer.append(minDate, maxDate);

                    // Date range filter logic
                    $.fn.dataTable.ext.search.push(function(settings, data) {
                        const min = $('#minDate').val() ? new Date($('#minDate').val()) : null;
                        const max = $('#maxDate').val() ? new Date($('#maxDate').val()) : null;
                        const date = new Date(data[5]);
                        return (!min || date >= min) && (!max || date <= max);
                    });

                    minDate.on('change', () => api.draw());
                    maxDate.on('change', () => api.draw());
                }
            });
        })
        .catch((error) => console.error('Error fetching violations:', error));
}

// Export buttons
function setupExportButtons() {
    const table = $('#sanctionTable').DataTable();

    // CSV
    document.querySelector('.buttons-csv').addEventListener('click', () => {
        const rows = [];
        const headers = [];
        $('#sanctionTable thead th').each(function (index) {
            if (index < 6) headers.push($(this).text().trim()); // exclude last column (Actions)
        });
        rows.push(headers.join(','));

        table.rows({ search: 'applied' }).every(function () {
            const cells = [];
            $(this.node()).find('td').each(function (i) {
                if (i < 6) cells.push($(this).text().trim());
            });
            rows.push(cells.join(','));
        });

        const blob = new Blob([rows.join('\n')], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'violations_report.csv';
        link.click();
    });

    // PDF
    document.querySelector('.buttons-pdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text('Violation Report', 14, 15);

        const data = [];
        table.rows({ search: 'applied' }).every(function () {
            const row = [];
            $(this.node()).find('td').each(function (i) {
                if (i < 6) row.push($(this).text().trim()); // exclude Actions
            });
            data.push(row);
        });

        doc.autoTable({ head: [['Student ID','Student','Offense','Suspension Type','Status','Time']], body: data, startY: 20 });
        doc.save('violations_report.pdf');
    });

    // Print
document.querySelector('.buttons-print').addEventListener('click', () => {
    const printWindow = window.open('', '', 'width=900,height=700');
    const tableClone = $('#sanctionTable').clone(); // clone the table
    tableClone.find('th:last-child, td:last-child').remove(); // remove the Actions column

    printWindow.document.write(`
        <html>
            <head>
                <title>Violation Report</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            </head>
            <body>
                <h3 class="text-center mt-4">Violation Report</h3>
                ${tableClone.prop('outerHTML')}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
});

}

document.addEventListener('DOMContentLoaded', fetchViolations);



// Create a mapping of categories to offenses
const offenses = {
    "Category A": [
        "Loitering and creating noise",
        "Failure to wear proper attire",
        "Shouting and loud talking",
        "Unauthorized use of facilities",
        "Tampering notices on boards",
        "Non-payment of school debts",
        "Wearing uniform in prohibited places"
    ],
    "Category B": [
        "Cheating during tests",
        "Smoking on school premises",
        "Vandalism",
        "Gambling",
        "Drunkenness and possession of liquor",
        "Refusal to wear proper uniform",
        "Use of fake IDs",
        "Discourtesy to staff",
        "Possession of pornographic material",
        "Public disturbances",
        "Cyberbullying",
        "Unauthorized use of school name"
    ],
    "Category C": [
        "Assaulting a teacher",
        "Carrying deadly weapons",
        "Extortion",
        "Fighting and causing injury",
        "Possessing or selling drugs",
        "Immorality",
        "Instigating school stoppages",
        "Forging school records",
        "Hazing",
        "Drug addiction",
        "Stealing school property",
        "Libel or malicious defamation"
    ]
};

// Function to populate offense dropdown based on the selected category
function populateOffenses(category, currentOffense) {
    const offenseSelect = $('#editOffense');
    offenseSelect.empty(); // Clear existing options

    // Add the default "Select" option
    offenseSelect.append('<option value="">Please select an offense</option>');

    // Populate new options based on the selected category
    offenses[category].forEach(function(offense) {
        const isSelected = offense === currentOffense ? 'selected' : ''; // Check if the offense matches the current value
        offenseSelect.append(`<option value="${offense}" ${isSelected}>${offense}</option>`);
    });
}


// Function to handle the update submission
function updateSanction() {
    const formData = new FormData(document.getElementById("editSanctionForm"));

    // Ensure the correct category and offense values are included
    const selectedCategory = $('#editCategory').val();
    const selectedOffense = $('#editOffense').val();
    const selectedSuspensionType = $('#editSuspensionType').val() || "N/A"; // Default to "N/A" if empty

    // Add category, offense, and suspension type to the FormData object if not already there
    formData.append('i_Category', selectedCategory);
    formData.append('list_Offense', selectedOffense);
    formData.append('Suspension_Type', selectedSuspensionType);

    // We don't include st_ID and violation_number in the form data for the update
    formData.delete('st_ID'); // Remove the st_ID from the form data if present
    formData.delete('violation_number'); // Remove the violation_number from the form data if present

    // Perform the fetch request to submit the data
    fetch("update_sanction.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#editModalsancitons').modal('hide'); // Close the modal
            location.reload(); // Reload the page to reflect the changes
        } else {
            alert("Failed to update sanction. Please try again.");
        }
    })
    .catch(error => console.error("Error updating sanction:", error));
}

// On page load, set the category, offense, and suspension type
$(document).ready(function() {
    $('#editCategory').val(currentCategory); // Set the initial category
    $('#editSuspensionType').val(currentSuspensionType || "N/A"); // Set the initial suspension type (default "N/A" if empty)

    // Now populate the offenses for the selected category
    populateOffenses(currentCategory);

    // Event listener for category change
    $('#editCategory').change(function() {
        const selectedCategory = $(this).val();
        populateOffenses(selectedCategory); // Update offense dropdown based on selected category
    });
});

// Event listener for the update button
document.getElementById("saveEditBtn").addEventListener("click", function() {
    updateSanction();  // Call updateSanction function when the save button is clicked
});





// Function to view sanction details
function viewSanction(id) {
    fetch(`fetch_sanction_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("viewSanctionID").textContent = data.i_ID;
            document.getElementById("viewViolationNumber").textContent = data.violation_number;
            document.getElementById("viewStudentID").textContent = data.st_ID;
            document.getElementById("viewstname").textContent = data.st_name;
            document.getElementById("viewCategory").textContent = data.i_Category;
            document.getElementById("viewOffense").textContent = data.list_Offense;
            document.getElementById("viewSanctions").textContent = data.i_Sanctions;
            document.getElementById("viewSuspensionType").textContent = data.Suspension_Type;
            document.getElementById("viewDetails").textContent = data.i_Details;
            document.getElementById("viewRecommendation").textContent = data.i_Recommendation;
            document.getElementById("viewrecorded").textContent = data.a_username;
            document.getElementById("viewtime").textContent = data.time;
            document.getElementById("viewStatus").textContent = data.i_Status;
            $('#viewModal').modal('show');
        })
        .catch(error => console.error("Error fetching sanction details:", error));
}

// Fetch existing sanctions data on page load
document.addEventListener("DOMContentLoaded", fetchSanctions);
// Function to fetch sanction details and populate the edit modal


function editSanction(id) {
    fetch(`fetch_sanction_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Populating the form fields with data
            document.getElementById("editStudentID").value = data.st_ID;  // Display st_ID in the modal (existing value)
            document.getElementById("editCategory").value = data.i_Category;  // Set Category
            document.getElementById("editSanctions").value = data.i_Sanctions;
            document.getElementById("editSuspensionType").value = data.Suspension_Type;
            document.getElementById("editDetails").value = data.i_Details;
            document.getElementById("editrecorder").value = data.a_username;
            document.getElementById("editRecommendation").value = data.i_Recommendation;
            document.getElementById("editStatus").value = data.i_Status;

            // Populate the hidden field for i_ID (primary key)
            document.getElementById("editID").value = data.i_ID;

            // Update the offense dropdown based on the selected category
            populateOffenses(data.i_Category, data.list_Offense);

            // Show the modal
            $('#editModalsancitons').modal('show');
        })
        .catch(error => console.error("Error fetching sanction details:", error));
}



function archiveViolation(id) {
    document.getElementById('archiveViolationId').value = id;
    const archiveModal = new bootstrap.Modal(document.getElementById('archiveViolationConfirmModal'));
    archiveModal.show();
}
function confirmViolationArchive() {
    const violationId = document.getElementById('archiveViolationId').value;

    fetch('archive_violation.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'violation_id=' + violationId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success modal
            $('#archive-violation-success-modal').modal('show');
            setTimeout(() => location.reload(), 2000); // Reload after 2 seconds
        } else {
            // Show error modal with message
            $('#archive-violation-error-modal').modal('show');
            document.getElementById('errorMessage').innerText = 'Failed to archive violation: ' + data.error;
        }
    })
    .catch(error => {
        console.error('Error archiving violation:', error);
        // Show error modal on fetch failure
        $('#archive-violation-error-modal').modal('show');
        document.getElementById('errorMessage').innerText = 'An error occurred while archiving the violation.';
    });
}