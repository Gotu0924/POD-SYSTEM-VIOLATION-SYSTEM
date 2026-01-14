
function fetchStudents() {
    fetch('fetch_students.php', {
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
        <button class="btn btn-success btn-sm"  onclick="viewStudent(${student.s_ID})">
            <i class="dw dw-eye"></i> View
        </button>
        <button class="btn btn-warning btn-sm"  onclick="editStudent(${student.s_ID})" data-bs-toggle="modal" data-bs-target="#editAdminModal">
            <i class="dw dw-edit2"></i> Edit
        </button>
        <button class="btn btn-secondary btn-sm"  onclick="archiveStudent(${student.s_ID})">
            <i class="dw dw-inbox"></i> Archive
        </button>
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

       let transitionBtn = $('<button class="btn btn-sm btn-warning me-3 mb-2 mb-md-0 pulse-animation">Transition</button>')
    .on('click', function () {
        // Open the description modal first
        $('#transitionDescModal').modal('show');
    });
filterContainer.append(transitionBtn);

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



function viewStudent(id) {
    fetch(`edit_student.php?id=${id}`)
        .then((response) => response.json())
        .then((student) => {
            // Set the student details in the modal
            document.getElementById('viewName').textContent = `${student.s_Firstname} ${student.s_Middlename} ${student.s_Lastname}`;
            document.getElementById('viewStudentID').textContent = student.st_ID;
            document.getElementById('viewDOB').textContent = student.s_DOB;
            document.getElementById('viewCourse').textContent = student.s_CourseOfStudy;
            document.getElementById('viewSchoolYear').textContent = student.school_year;
            document.getElementById('viewGender').textContent = student.s_Gender;
            document.getElementById('viewYearLevel').textContent = student.year_level;
            document.getElementById('viewAddress').textContent = student.s_Address;
            document.getElementById('viewPhone').textContent = formatPhoneNumber(student.s_PhoneNumber); // Format phone number
            document.getElementById('viewReligion').textContent = student.religion;
            document.getElementById('viewLicence').textContent = student.if_licence;
            document.getElementById('viewLicenceRegistration').textContent = student.if_licence_registration;
            document.getElementById('viewGmail').textContent = student.s_gmail;
            // Set student picture with fallback for empty or broken image
                const pictureElement = document.getElementById('viewPicture');
                pictureElement.src = student.s_PicturePath || 'https://www.w3schools.com/howto/img_avatar.png';
                pictureElement.onerror = function () {
                    this.onerror = null;
                    this.src = 'https://www.w3schools.com/howto/img_avatar.png';
                };


            // Initialize the modal and show it using Bootstrap 5 modal API
            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            viewModal.show();
        })
        .catch((error) => console.error('Error fetching student details:', error));
}

function editStudent(id) {
    fetch(`edit_student.php?id=${id}`)
        .then((response) => response.json())
        .then((student) => {
            // Show student picture (display only)
            // Set student picture with fallback for empty or broken image
            const pictureElement = document.getElementById('editPicture');
            pictureElement.src = student.s_PicturePath || 'https://www.w3schools.com/howto/img_avatar.png';
            pictureElement.onerror = function () {
                this.onerror = null;
                this.src = 'https://www.w3schools.com/howto/img_avatar.png';
            };


            // Column 1 (Names + Student ID)
            document.getElementById('editFirstName').value = student.s_Firstname || '';
            document.getElementById('editMiddleName').value = student.s_Middlename || '';
            document.getElementById('editLastName').value = student.s_Lastname || '';
            document.getElementById('editStudentID').value = student.st_ID || '';

            // Column 2 (Year, School Year, Gender, Address, DOB)
            document.getElementById('editYearLevel').value = student.year_level || '';
            document.getElementById('editSchoolYear').value = student.school_year || '';
            document.getElementById('editGender').value = student.s_Gender || '';
            document.getElementById('editAddress').value = student.s_Address || '';

            // Column 3 (Phone, Religion, Licence, Plate No., Course)
            document.getElementById('editPhone').value = formatPhoneNumber(student.s_PhoneNumber); // Format phone number
            document.getElementById('editReligion').value = student.religion || '';
            document.getElementById('editLicence').value = student.if_licence || '';
            document.getElementById('editLicenceRegistration').value = student.if_licence_registration || '';
            document.getElementById('editCourse').value = student.s_CourseOfStudy || '';
            document.getElementById('editGmail').value = student.s_gmail || '';
            document.getElementById('editDOB').value = student.s_DOB || '';

            // Store student ID for saving
            document.getElementById('editForm').dataset.id = student.s_ID;

            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        })
        .catch((error) => console.error('Error fetching student details:', error));
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


// Open archive modal
function archiveStudent(s_ID) {
    console.log("🟡 Preparing to archive student with s_ID:", s_ID); // Debug log
    document.getElementById("archiveStudentId").value = s_ID;
    $('#archiveConfirmModal').modal('show');
}

// Confirm archive (send to PHP)
function confirmArchive() {
    const studentId = document.getElementById("archiveStudentId").value;

    if (!studentId) {
        console.error("❌ Archive Error: No s_ID provided!");
        return;
    }

    console.log("🟢 Sending archive request for s_ID:", studentId);

    fetch('archive_student.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "student_id=" + encodeURIComponent(studentId)
    })
    .then(response => response.text()) // get raw text first
    .then(text => {
        console.log("📦 Raw response:", text); // Debug log raw PHP output

        try {
            const data = JSON.parse(text); // try parsing JSON
            console.log("✅ Parsed response:", data);

            if (data.success) {
                if (data.success) {
                    $('#archiveConfirmModal').modal('hide'); // Close confirm modal
                    $('#archived-success-modal').modal('show'); // Show success modal
                }

            } else if (data.error === "duplicated-id") {
                // Close archive confirm modal first
                $('#archiveConfirmModal').modal('hide');

                // Then show duplicate modal
                $('#duplicateIdModal').modal('show');

                // When OK is clicked, refresh page/table
                $('#duplicateOkBtn').off('click').on('click', function () {
                    location.reload(); 
                    // Or just fetchStudents(); if you only want table update
                });
            } else {
                console.error("❌ Archive failed:", data.error);
                alert("Archive Error: " + data.error);
            }

        } catch (err) {
            console.error("❌ JSON parse error:", err);
            console.log("⚠️ Response was not valid JSON:", text);
        }
    })
    .catch(err => {
        console.error("🔥 Fetch error:", err);
    });
}
