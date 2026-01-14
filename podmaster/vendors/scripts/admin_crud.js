function fetchAdmins() {
    fetch('fetch_admins.php')
    .then(res => res.json())
    .then(admins => {
        // Destroy old DataTable first
        if ($.fn.dataTable.isDataTable('#adminTable')) {
            $('#adminTable').DataTable().clear().destroy();
        }

        const tableBody = document.getElementById('adminTableBody');
        tableBody.innerHTML = ''; // Clear existing rows

        admins.forEach(admin => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${admin.a_ID}</td>
                <td>${admin.a_Firstname} ${admin.a_Lastname}</td>
                <td>${admin.a_Role}</td>
                <td>${admin.a_PhoneNumber}</td>
                <td>${admin.a_username}</td>
                <td class="text-center">
                    <div class="btn-group-vertical d-inline-flex">
                        <button class="btn btn-success btn-sm mb-1" onclick="viewAdmin(${admin.a_ID})" data-bs-toggle="modal" data-bs-target="#viewAdminModal">
                            <i class="dw dw-eye"></i> View
                        </button>
                        <button class="btn btn-warning btn-sm mb-1" onclick="editAdmin(${admin.a_ID})" data-bs-toggle="modal" data-bs-target="#editadminModal">
                            <i class="dw dw-edit2"></i> Edit
                        </button>
                        <button class="btn btn-secondary btn-sm mb-1" onclick="archiveAdmin(${admin.a_ID})">
                            <i class="dw dw-inbox"></i> Archive
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable after rows are appended
        $('#adminTable').DataTable({
            searching: true,
            paging: true,
            autoWidth: false,
            scrollX: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [-1] }, 
                { width: "5%", targets: 0 }, 
                { width: "15%", targets: 1 },
                { width: "12%", targets: 2 },
                { width: "12%", targets: 4 },
            ],
            initComplete: function () {
                let api = this.api();

                function buildFilters() {
                    let filterColumns = [
                        { index: 2, label: "Role" },
                    ];

                    let lengthContainer = $('#adminTable_length');
                    lengthContainer.find('.custom-filters').remove();
                    let filterContainer = $('<div class="custom-filters d-inline-flex align-items-center ms-10"></div>');

                    filterColumns.forEach(function (col) {
                        let select = $('<select class="form-control form-control-sm me-10"><option value="">' + col.label + '</option></select>')
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(col.index).search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        api.column(col.index).data().unique().sort().each(function (d) {
                            if (d) select.append('<option value="' + d + '">' + d + '</option>');
                        });

                        filterContainer.append(select);
                    });

                    lengthContainer.append(filterContainer);
                }

                buildFilters();
                api.on('draw', buildFilters);
            }
        });
    })
    .catch(error => console.error('Error fetching admins:', error));
}


// View Admin Details - show admin info in a modal
function viewAdmin(id) {
    fetch(`edit_admin.php?id=${id}`)
        .then((response) => response.json())
        .then((admin) => {
            document.getElementById('viewName').textContent = `${admin.a_Firstname} ${admin.a_Lastname}`;
            document.getElementById('viewRole').textContent = admin.a_Role;
            document.getElementById('viewPhone').textContent = formatPhoneNumber(admin.a_PhoneNumber); // Format phone number
            document.getElementById('viewUsername').textContent = admin.a_username;
            document.getElementById('viewGmail').textContent = admin.a_Gmail;

            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            viewModal.show();
        })
        .catch((error) => console.error('Error fetching admin details:', error));
}


// Edit Admin - prepopulate the modal for editing
function editAdmin(id) {
    fetch(`edit_admin.php?id=${id}`)
        .then((response) => response.json())
        .then((admin) => {
            // Populate the modal with the fetched admin data
            document.getElementById('editFirstname').value = admin.a_Firstname || '';
            document.getElementById('editLastname').value = admin.a_Lastname || '';
            document.getElementById('editRole').value = admin.a_Role || '';
            document.getElementById('editPhone').value = formatPhoneNumber(admin.a_PhoneNumber) || ''; // Format phone number
            document.getElementById('editUsername').value = admin.a_username || '';
            document.getElementById('editGmail').value = admin.a_Gmail || '';
            document.getElementById('editForm').dataset.id = admin.a_ID;

            // Show the modal
            const editModal = new bootstrap.Modal(document.getElementById('editAdminModal'));
            editModal.show();
        })
        .catch((error) => console.error('Error fetching admin details:', error));
}

// Phone Number Formatting
function formatPhoneNumber(phoneNumber) {
    const cleaned = ('' + phoneNumber).replace(/\D/g, '');
    if (cleaned.length === 10) {
        return cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    } else {
        return phoneNumber; // Return the original if it's not 10 digits
    }
}

// Validate Phone Number
function isValidPhoneNumber(phone) {
    const regex = /^\d{3}-\d{3}-\d{4}$/;
    return regex.test(phone);
}


// Save Changes
function saveChanges() {
    const adminID = document.getElementById('editForm').dataset.id;
    const firstname = document.getElementById('editFirstname').value.trim();
    const lastname = document.getElementById('editLastname').value.trim();
    const role = document.getElementById('editRole').value.trim();
    const phone = document.getElementById('editPhone').value.trim();
    const username = document.getElementById('editUsername').value.trim();
    const gmail = document.getElementById('editGmail').value.trim();

    let valid = true;

    // Validate phone
    if (!isValidPhoneNumber(phone)) {
        document.getElementById('phone-error').style.display = 'block';
        document.getElementById('phone-error').innerText = 'Phone number must be in XXX-XXX-XXXX format';
        valid = false;
    } else {
        document.getElementById('phone-error').style.display = 'none';
    }

    // Validate Gmail
    const gmailRegex = /^[a-zA-Z0-9._%+-]+@smcbi\.edu\.ph$/;
    if (!gmailRegex.test(gmail)) {
        document.getElementById('gmail-error').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('gmail-error').style.display = 'none';
    }

    if (!valid) return;

    // Check username uniqueness via API
    fetch('check_username.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, id: adminID })
    })
    .then(res => res.json())
    .then(data => {
        if (data.exists) {
            document.getElementById('username-error').style.display = 'block';
        } else {
            document.getElementById('username-error').style.display = 'none';

            // Update admin via API
            fetch('update_admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: adminID,
                    firstname,
                    lastname,
                    role,
                    phone,
                    username,
                    gmail
                })
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    // Show success modal
                $('#edit-success-modal').modal('show');    
                $('#editAdminModal').modal('hide');

                    // Refresh table
                    fetchAdmins();
                } else {
                    // Show error modal
                    $('#error-modal').modal('show');
                }
            })
            .catch(error => {
                // Show error modal on fetch/network error
                $('#error-modal').modal('show');
                console.error('Error updating admin:', error);
            });

        }
    })
    .catch(err => console.error(err));
}



// Archive Admin - open confirmation modal
function archiveAdmin(id) {
    document.getElementById('archiveAdminId').value = id;
    const archiveModal = new bootstrap.Modal(document.getElementById('archiveAdminConfirmModal'));
    archiveModal.show();
}

// Archive Admin - on confirm
function confirmAdminArchive() {
    const adminId = document.getElementById('archiveAdminId').value;

    fetch('archive_admin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'admin_id=' + adminId
    })
    .then(response => response.text())
    .then(data => {
        try {
            const jsonResponse = JSON.parse(data);

            if (jsonResponse.success) {
                // Show success modal
                const successModal = new bootstrap.Modal(document.getElementById('archive-success-modal'));
                successModal.show();
                setTimeout(() => {
                    successModal.hide();
                    location.reload(); // Reload the page
                }, 3000);
            } else {
                // Show error modal
                const errorModal = new bootstrap.Modal(document.getElementById('archive-error-modal'));
                errorModal.show();
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            // Show error modal in case of JSON parsing error
            const errorModal = new bootstrap.Modal(document.getElementById('archive-error-modal'));
            errorModal.show();
        }
    })
    .catch(error => {
        console.error('Error restoring student:', error);
        // Show error modal in case of a network error
        const errorModal = new bootstrap.Modal(document.getElementById('archive-error-modal'));
        errorModal.show();
    });
}

fetchAdmins();
