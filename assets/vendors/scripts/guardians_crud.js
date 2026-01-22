function fetchGuardians() {
    fetch('fetch_guardians.php', { // Ensure this points to your PHP script
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
                        <button class="btn btn-success" onclick="viewGuardian(${guardian.g_ID})"><i class="dw dw-eye"></i> View</button>
                        <button class="btn btn-warning" onclick="editGuardian(${guardian.g_ID})" data-bs-toggle="modal" data-bs-target="#editModal"><i class="dw dw-edit2"></i> Edit</button>
                        <button class="btn btn-secondary" onclick="archiveGuardian(${guardian.g_ID})">
                            <i class="dw dw-inbox"></i> Archive
                        </button>
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


function viewGuardian(id) {
    fetch(`view_guardian.php?id=${id}`)
        .then((response) => response.json())
        .then((guardian) => {
            if (guardian.error) {
                alert(guardian.error);
                return;
            }
            document.getElementById('viewName').textContent = `${guardian.g_FirstName} ${guardian.g_LastName}`;
            document.getElementById('viewStudentID').textContent = guardian.st_ID; // Assuming this corresponds to Student ID
            // document.getElementById('viewDOB').textContent = guardian.date_of_birth;
            document.getElementById('viewAddress').textContent = guardian.g_Address;
            document.getElementById('viewPhone').textContent =formatPhoneNumber(guardian.g_PhoneNumber);

            $('#viewGuardianModal').modal('show'); // Show the modal
        })
        .catch((error) => console.error('Error fetching guardian details:', error));
}



// Function to populate the edit modal with guardian data
function editGuardian(id) {
    fetch(`edit_guardians.php?id=${id}`)
        .then((response) => response.json())
        .then((guardian) => {
            // Populate the modal with the fetched guardian data
            document.getElementById('g_editFirstName').value = guardian.g_FirstName || '';  // Set the first name
            document.getElementById('g_editLastName').value = guardian.g_LastName || '';  // Set the last name
            document.getElementById('g_editStudentID').value = guardian.st_ID || '';  // Corrected variable name
            document.getElementById('g_editAddress').value = guardian.g_Address || '';  // Set the address
            document.getElementById('g_editPhone').value = formatPhoneNumber(guardian.g_PhoneNumber) || '';  // Format phone number for editing

            document.getElementById('g_editForm').dataset.id = guardian.g_ID;  // Store the guardian ID in the form's dataset

            // Show the modal
            const editModal = new bootstrap.Modal(document.getElementById('editGuardianModal'));
            editModal.show();
        })
        .catch((error) => console.error('Error fetching guardian details:', error));
}

// Function to save changes made in the edit modal
function saveChanges() {
    const id = document.getElementById('g_editForm').dataset.id;

    const updatedGuardian = {
        id: id,
        firstname: document.getElementById('g_editFirstName').value || '',  // Get the first name
        lastname: document.getElementById('g_editLastName').value || '',  // Get the last name
        phone: formatPhoneNumber(document.getElementById('g_editPhone').value), // Format the phone number before saving
        address: document.getElementById('g_editAddress').value || '',  // Get the address
        studentID: document.getElementById('g_editStudentID').value || '',  // Get the student ID
    };

    fetch('update_guardian.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(updatedGuardian),
    })
    .then((response) => response.json())
    .then((result) => {
        if (result.status === 'success') {
            location.reload(); // Reload the page after successful update
        } else {
            alert('Failed to update guardian: ' + result.message);
        }
    })
    .catch((error) => console.error('Error updating guardian:', error));
}


// Function to format phone numbers as "000-000-0000"
function formatPhoneNumber(phoneNumber) {
    if (!phoneNumber) return '';
    phoneNumber = phoneNumber.replace(/\D/g, ''); // Remove non-numeric characters
    if (phoneNumber.length === 10) {
        return phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3'); // Format as 000-000-0000
    }
    return phoneNumber; // Return raw if it's not 10 digits
}



// Call the function to fetch guardians when the script loads
function archiveGuardian(id) {
    document.getElementById('archiveGuardianId').value = id;
    const modal = new bootstrap.Modal(document.getElementById('archiveGuardianConfirmModal'));
    modal.show();
}

function confirmGuardianArchive() {
    const guardianId = document.getElementById('archiveGuardianId').value;

    fetch('archive_guardian.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'guardian_id=' + guardianId
    })
            .then(res => res.json())
            .then(data => {
                $('#archiveGuardianConfirmModal').modal('hide');
                
                if (data.success) {
                    // Show Success Modal
                    $('#archived-success-modal').modal('show');  // Use the success modal
                    
                    $('#archiveGuardianConfirmModal').modal('hide');
                    fetchGuardians();
                } else {
                    // Show Error Modal if specific failure message exists
                    $('#archived-error-modal').modal('show');  // Use the error modal
                }
            })
            .catch(err => {
                console.error('Error:', err);
                // If there's an error in the request, show the error modal
                $('#archived-error-modal').modal('show');
            });

}

fetchGuardians();