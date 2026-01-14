function fetchAdmins() {
    fetch('fetch_admins_archive.php', {
        method: 'GET',
    })
    .then((response) => response.json())
    .then((data) => {
        const tableBody = document.getElementById('adminTableBody');
        tableBody.innerHTML = '';  // Clear current rows

        data.forEach((admin) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="table-plus">${admin.a_ID}</td>
                <td>${admin.a_Firstname} ${admin.a_Lastname}</td>
                <td>${admin.a_Role}</td>
                <td>${formatPhoneNumber(admin.a_PhoneNumber)}</td>
                <td>${admin.a_username}</td>
                <td>
                    <div class="btn btn-group">
                        <button class="btn btn-success" onclick="openRestoreAdminModal(${admin.a_ID})"><i class="dw dw-eye"></i> Restore</button>
                        <button class="btn btn-danger" onclick="openDeleteAdminModal(${admin.a_ID})"><i class="dw dw-delete-3"></i> Delete</button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        if ($.fn.dataTable.isDataTable('#adminTable')) {
            $('#adminTable').DataTable().clear().destroy();
        }

        $('#adminTable').DataTable({
             searching: true,
        paging: true,
        scrollX: true,
        autoWidth: false,
        columnDefs: [
            { orderable: false, targets: [1, -1] }, // disable sorting for actions
            { width: "10%", targets: 0 },   // Admin ID
            { width: "25%", targets: 1 },   // Admin Name
            { width: "10%", targets: 2 },   // Role
            { width: "20%", targets: -1 }   // Actions
        ],

        initComplete: function () {
            let api = this.api();

            // Build filters for role
            function buildFilters() {
                let filterColumns = [
                    { index: 2, label: "Role" }  // Only filtering by role
                ];

                let lengthContainer = $('#adminTable_length');
                lengthContainer.find('.custom-filters').remove(); // clear old ones
                let filterContainer = $('<div class="custom-filters d-inline-flex align-items-center ms-10"></div>');

                // Add the select filters for role
                filterColumns.forEach(function (col) {
                    let select = $('<select class="form-control form-control-sm me-10"><option value="">' + col.label + '</option></select>')
                        .on('change', function () {
                            let val = $.fn.dataTable.util.escapeRegex($(this).val());
                            api.column(col.index).search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    // Populate options for roles
                    api.column(col.index).data().unique().sort().each(function (d) {
                        if (d) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        }
                    });

                    filterContainer.append(select);
                });

                lengthContainer.append(filterContainer);
            }

            // Build filters initially
            buildFilters();

            // Rebuild filters after redraw (when length changes, pagination, etc.)
            api.on('draw', buildFilters);
        }
    });
})
.catch((error) => console.error('Error fetching admins:', error));
}
/* =========================
   RESTORE ADMIN
========================= */
function openRestoreAdminModal(adminID) {
    document.getElementById('restoreAdminId').value = adminID;
    $('#restoreAdminConfirmModal').modal('show');
}

function confirmRestoreAdmin() {
    let adminID = document.getElementById('restoreAdminId').value;

    fetch('restore_admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `admin_id=${adminID}`
    })
    .then(res => res.json())
    .then(data => {
        $('#restoreAdminConfirmModal').modal('hide');
        
        if (data.success) {
            // Show Success Modal
            $('#archive-success-modal').modal('show');
            fetchAdmins();
        } else {
            // Show Error Modal if specific failure message exists
            $('#archive-error-modal').modal('show');
        }
    })
    .catch(err => {
        console.error('Error restoring admin:', err);
        // Show Error Modal if there's an exception
        $('#archive-error-modal').modal('show');
    });

}

/* =========================
   DELETE ADMIN
========================= */
let adminIdToDelete = null;

function openDeleteAdminModal(adminID) {
    adminIdToDelete = adminID;
    $('#deleteAdminConfirmModal').modal('show');
}

function confirmDeleteAdmin() {
    fetch(`delete_admin_arch.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `admin_id=${adminIdToDelete}`
    })
    .then(res => res.json())
    .then(data => {
        $('#restoreAdminConfirmModal').modal('hide');
        
        if (data.success) {
            // Show Success Modal
            $('#delete-success-modal').modal('show');
            
            $('#deleteAdminConfirmModal').modal('hide');
            fetchAdmins();
        } else {
            // Show Error Modal if specific failure message exists
            $('#delete-error-modal').modal('show');
        }
    })
    .catch(err => {
        console.error('Error restoring admin:', err);
        // Show Error Modal if there's an exception
        $('#delete-error-modal').modal('show');
    });
}

function formatPhoneNumber(phoneNumber) {
    // Remove any non-numeric characters
    const cleaned = ('' + phoneNumber).replace(/\D/g, '');
    
    // Check if the cleaned number has 10 digits
    if (cleaned.length === 10) {
        return cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    } else {
        return phoneNumber; // Return the original if it's not 10 digits
    }
}


fetchAdmins();


