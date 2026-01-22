function fetchGuardians() {
    fetch('fetch_guardians_archive.php', { // Ensure this points to your PHP script
        method: 'GET',
    })
    .then((response) => response.json())
    .then((data) => {
        const tableBody = document.getElementById('guardianTableBody');
        tableBody.innerHTML = '';  // Clear current rows

        data.forEach((guardian) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                 <td class="table-plus">${guardian.g_ID}</td>
                <td>${guardian.g_FirstName} ${guardian.g_LastName}</td>
                <td>${guardian.st_ID}</td> <!-- Ensure this is the correct field -->
                <td>${guardian.st_name}</td>
                 <td>${formatPhoneNumber(guardian.g_PhoneNumber)}</td>
                <td>
                    <div class="btn btn-group">
                        <button class="btn btn-success" onclick="openRestoreModal(${guardian.g_ID})"><i class="dw dw-eye"></i> Restore</button>
                        <button class="btn btn-danger" onclick="openDeleteModal(${guardian.g_ID})"><i class="dw dw-delete-3"></i> Delete</button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable if needed
        if ($.fn.dataTable.isDataTable('#guardianTable')) {
            $('#guardianTable').DataTable().clear().destroy();
        }

        $('#guardianTable').DataTable({
           searching: true,
            paging: true,
            info: true,
            scrollX: true, // Enables horizontal scroll
            autoWidth: false,
            dom: 'Bfrtip',
            lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ], // Controls length
            pageLength: 10, // Default number of rows shown
            columnDefs: [
                { orderable: false, targets: [1, 3, -1] }, // Disable sorting for Guardian Name, Student Name, and Action
                { width: "12%", targets: 0 },  // Adjust width as per your requirement (example for the first column)
                { width: "15%", targets: 1 },  // Adjust the second column width (Guardian Name)
                { width: "15%", targets: 2 },  // Student ID column width
                { width: "15%", targets: 3 },  // Adjust the Student Name column width
                { width: "15%", targets: 4 },  // Phone Number column width
            ]
        });

        document.querySelectorAll('.dropdown-toggle').forEach((dropdown) => {
            new bootstrap.Dropdown(dropdown);
        });
    })
    .catch((error) => console.error('Error fetching guardians:', error));
}

// Call the function to fetch guardians when the script loads
fetchGuardians();



// Function to format phone numbers as "000-000-0000"
function formatPhoneNumber(phoneNumber) {
    if (!phoneNumber) return '';
    phoneNumber = phoneNumber.replace(/\D/g, ''); // Remove non-numeric characters
    if (phoneNumber.length === 10) {
        return phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3'); // Format as 000-000-0000
    }
    return phoneNumber; // Return raw if it's not 10 digits
}



function openRestoreModal(id) {
    document.getElementById("restoreGuardianId").value = id;
    $('#restoreGuardianConfirmModal').modal('show');
}

function openDeleteModal(id) {
    document.getElementById("deleteGuardianId").value = id;
    $('#deleteGuardianConfirmModal').modal('show');
}

function confirmRestoreGuardian() {
    let id = document.getElementById("restoreGuardianId").value;

    fetch("restore_guardian.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `g_ID=${id}`
    })
   .then(res => res.json())
            .then(data => {
                $('#restoreAdminConfirmModal').modal('hide');
                
                if (data.success) {
                    // Show Success Modal
                    $('#restore-success-modal').modal('show');  // Use the success modal
                    
                    $('#archiveGuardianConfirmModal').modal('hide');
                    fetchGuardians();
                } else {
                    // Show Error Modal if specific failure message exists
                    $('#restore-error-modal').modal('show');  // Use the error modal
                }
            })
            .catch(err => {
                console.error('Error:', err);
                // If there's an error in the request, show the error modal
                $('#archived-error-modal').modal('show');
            });
}

function confirmDeleteGuardian() {
    let id = document.getElementById("deleteGuardianId").value;

    fetch("delete_guardian_arch.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `g_ID=${id}`
    })
    .then(res => res.json())
    .then(data => {
        $('#deleteGuardianConfirmModal').modal('hide');
        alert(data.message);
        if (data.success) fetchGuardians();
    })
    .catch(err => console.error("Error deleting guardian:", err));
}
