
function fetchStudents() {
    fetch('st_archive.php', {
        method: 'GET',
    })
    .then((response) => response.json())
    .then((data) => {
        const tableBody = document.getElementById('studentTableBody');
        tableBody.innerHTML = '';  // Clear current rows

        data.forEach((student) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="table-plus">${student.s_ID}</td>
                <td>
                                <img src="${student.s_PicturePath}" 
                    alt="Student Picture" 
                    class="img-thumbnail" 
                    width="115" height="80"
                    onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';">

                                </td>
                                <td> ${student.s_Firstname} ${student.s_Middlename} ${student.s_Lastname}</td>
                                <td>${student.st_ID}</td>
                                <td>${student.s_CourseOfStudy}</td>
                                <td>${student.year_level}</td>
              <td class="text-center">
                    <div class="btn-group-vertical d-inline-flex">
                    <button class="btn btn-success" onclick="openRestoreModal(${student.s_ID})"><i class="dw dw-eye"></i> Restore</button>
                                        <button class="btn btn-danger" onclick="openDeleteModal(${student.s_ID})"><i class="dw dw-delete-3"></i> Delete</button>
                    </div>
                </td>

            `;
            tableBody.appendChild(row);
        });

        // Destroy old DataTable if exists
        if ($.fn.dataTable.isDataTable('#studentTable')) {
            $('#studentTable').DataTable().clear().destroy();
        }

        

        // Initialize DataTable with filters
        $('#studentTable').DataTable({
            searching: true,
            paging: true,
            autoWidth: false,
            scrollX: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [1, -1] }, // disable sorting for picture + action
                { width: "8%", targets: 0 },   // NO
                { width: "12%", targets: 1 },  // Picture
                { width: "20%", targets: 2 },  // Full Name
                { width: "12%", targets: 3 },  // Student ID
                { width: "15%", targets: 4 },  // Course
                { width: "10%", targets: 5 },  // Year Level
            ],

            initComplete: function () {
    let api = this.api();

    function buildFilters() {
        let filterColumns = [
            { index: 4, label: "Course" },
            { index: 5, label: "Year Level" },
        ];

        let lengthContainer = $('#studentTable_length');
        lengthContainer.find('.custom-filters').remove(); // clear old ones
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

        lengthContainer.append(filterContainer);
    }

    $('#continueTransitionBtn').on('click', function() {
    // Close the description modal
    $('#transitionDescModal').modal('hide');

    // Open the actual update modal
    $('#updateYearModal').modal('show');
});


    // Build filters initially
    buildFilters();

    // Rebuild filters after redraw (when length changes, pagination, etc.)
    api.on('draw', buildFilters);
}

});
    })
    .catch((error) => console.error('Error fetching students:', error));
}
fetchStudents();



/* ==== Restore Functions ==== */
function openRestoreModal(studentID) {
    document.getElementById('restoreStudentId').value = studentID;
    $('#restoreConfirmModal').modal('show');
}

function confirmRestore() {
    let studentID = document.getElementById('restoreStudentId').value;

   fetch('restoreStudent.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `studentID=${studentID}`
})

.then(response => response.text())  // Use .text() to log the raw response
.then(data => {
    console.log(data);  // Log the raw response for debugging
    try {
        const jsonResponse = JSON.parse(data);  

        if (jsonResponse.success) {
            // Show success modal
            $('#restore-success-modal').modal('show');
            fetchStudents();
        } else {
            // Show error modal if something went wrong
            $('#restore-error-modal').modal('show');
        }
    } catch (error) {
        console.error('Error parsing JSON:', error);
        // Show error modal in case of JSON parsing error
        $('#restore-error-modal').modal('show');
    }
})
.catch(error => {
    console.error('Error restoring student:', error);
    // Show error modal in case of a network error
    $('#restore-error-modal').modal('show');
});

}

/* ==== Delete Functions ==== */
function openDeleteModal(studentID) {
    document.getElementById('deleteStudentId').value = studentID;
    $('#deleteConfirmationModal').modal('show');
}

function confirmDelete() {
    let studentID = document.getElementById('deleteStudentId').value;

    fetch('deleteStudent.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `studentID=${studentID}`
    })
    
.then(response => response.text())  // Use .text() to log the raw response
.then(data => {
    console.log(data);  // Log the raw response for debugging
    try {
        const jsonResponse = JSON.parse(data);  

        if (jsonResponse.success) {
            // Show success modal
            $('#delete-success-modal').modal('show');
            fetchStudents();
        } else {
            // Show error modal if something went wrong
            $('#delete-error-modal').modal('show');
        }
    } catch (error) {
        console.error('Error parsing JSON:', error);
        // Show error modal in case of JSON parsing error
        $('#delete-error-modal').modal('show');
    }
})
.catch(error => {
    console.error('Error restoring student:', error);
    // Show error modal in case of a network error
    $('#delete-error-modal').modal('show');
});
}