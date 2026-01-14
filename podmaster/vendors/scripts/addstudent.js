function openAddStudentModal() {
    $('#addStudentModal').modal('show');
}

function showErrorModal(message) {
    document.getElementById('error-modal-message').innerText = message;
    $('#error-modal-1').modal('show');
}

function showRequiredFieldModal(message) {
    document.getElementById('required-field-message').innerText = message;
    $('#required-field-modal').modal('show');
}

function addStudent() {
    // Collect student data
    const studentData = {
        s_Firstname: document.getElementById('addFirstName').value,
        s_Middlename: document.getElementById('addMiddlename').value,
        s_Lastname: document.getElementById('addLastName').value,
        st_ID: document.getElementById('addStudentID').value,
        s_DOB: document.getElementById('addDOB').value,
        s_CourseOfStudy: document.getElementById('addCourse').value,
        year_level: document.getElementById('addYearLevel').value,
        school_year: document.getElementById('addSchoolYear').value,
        s_Gender: document.getElementById('addGender').value,
        s_Address: document.getElementById('addAddress').value,
        s_PhoneNumber: document.getElementById('addPhone').value,
        religion: document.getElementById('addReligion').value,
        gmail: document.getElementById('addGmail').value, 
        if_licence: document.getElementById('addLicence').value || "N/A",
        if_licence_registration: document.getElementById('addLicenceRegistration').value || "N/A",
        s_PicturePath: document.getElementById('addPicture').files[0] || null,
        t_Password: document.getElementById('addPassword').value,
        confirmPassword: document.getElementById('addConfirmPassword').value
    };

    // Collect guardian data
    const guardianData = {
        g_Firstname: document.getElementById('addGuardianFirstName').value,
        g_Lastname: document.getElementById('addGuardianLastName').value,
        g_PhoneNumber: document.getElementById('addGuardianPhone').value,
        g_Address: document.getElementById('addGuardianAddress').value,
    };

    // Field mapping
    const fieldMap = {
        s_Firstname: 'addFirstName',
        s_Middlename: 'addMiddlename',
        s_Lastname: 'addLastName',
        st_ID: 'addStudentID',
        s_DOB: 'addDOB',
        s_CourseOfStudy: 'addCourse',
        year_level: 'addYearLevel',
        school_year: 'addSchoolYear',
        s_Gender: 'addGender',
        s_Address: 'addAddress',
        s_PhoneNumber: 'addPhone',
        religion: 'addReligion',
        gmail: 'addGmail',
        t_Password: 'addPassword',
        g_Firstname: 'addGuardianFirstName',
        g_Lastname: 'addGuardianLastName',
        g_PhoneNumber: 'addGuardianPhone',
        g_Address: 'addGuardianAddress'
    };

    const allData = { ...studentData, ...guardianData };
    let valid = true;

    for (const key in fieldMap) {
        const el = document.getElementById(fieldMap[key]);
        if (el && !allData[key]) {
            el.classList.add('is-invalid');
            valid = false;
        } else if (el) {
            el.classList.remove('is-invalid');
        }
    }

    // 🔴 If ANY field is empty → show modal ONCE
    if (!valid) {
        showRequiredFieldModal("Please fill in all required fields.");
        return;
    }

    // Gmail validation
    const gmailInput = document.getElementById('addGmail');
    if (gmailInput && !gmailInput.value.endsWith('@smcbi.edu.ph')) {
        gmailInput.classList.add('is-invalid');
        showErrorModal("The student's email must end with @smcbi.edu.ph");
        return;
    } else {
        gmailInput.classList.remove('is-invalid');
    }

    // Password confirmation validation
    if (studentData.t_Password !== studentData.confirmPassword) {
        showErrorModal("Passwords do not match.");
        document.getElementById('addPassword').classList.add('is-invalid');
        document.getElementById('addConfirmPassword').classList.add('is-invalid');
        return;
    } else {
        document.getElementById('addPassword').classList.remove('is-invalid');
        document.getElementById('addConfirmPassword').classList.remove('is-invalid');
    }

    // Prepare FormData
    const formData = new FormData();
    for (let key in studentData) {
        if (key !== 'confirmPassword') formData.append(key, studentData[key]);
    }
    for (let key in guardianData) {
        formData.append(key, guardianData[key]);
    }

    // AJAX Submission
    $.ajax({
        url: 'add_student.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                $('#edit-success-modal .text-success').text("Student " + data.student_name + " Added Successfully!");
                $('#edit-success-modal .mt-3 p').text("The student record has been saved.");
                $('#edit-success-modal').modal('show');
                $('#addStudentForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
            } else {
                showErrorModal(data.message);
            }
        },
        error: function() {
            showErrorModal('Error adding student.');
        }
    });
}
