function fetchStudentIssues() {
    fetch('get_student_issue_details.php', {
        method: 'GET',
    })
    .then((response) => response.json())
    .then((data) => {
        const tableBody = document.getElementById('violatointablebody');
        tableBody.innerHTML = '';  // Clear current rows

        data.forEach((violation) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${violation.i_ID}</td>
                <td>${violation.violation_number}</td>
                <td>${violation.i_Category}</td>
                <td>${violation.list_Offense}</td>
                <td>${violation.Suspension_Type}</td>
                <td>${violation.i_Status}</td>
                <td class="text-center">
                    <div class="btn-group-vertical d-inline-flex">
                       <button class="btn btn-success btn-sm mb-1 appeal-btn" 
                            data-violation_number="${violation.violation_number}" 
                            onclick="viewSanction(${violation.i_ID}, this)">
                        Appeal
                    </button>



                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Destroy old DataTable if exists
        if ($.fn.dataTable.isDataTable('#violationTable')) {
            $('#violationTable').DataTable().clear().destroy();
        }

        // Initialize DataTable
        $('#violationTable').DataTable({
            searching: true,
            paging: true,
            autoWidth: false,
            scrollX: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [6] }, // Disable sorting for "Actions" column (index 6)
                { width: "8%", targets: 0 },   // Violation Number
                { width: "15%", targets: 1 },  // Category
                { width: "15%", targets: 2 },  // Offense
                { width: "20%", targets: 3 },  // Suspension Type
                { width: "15%", targets: 4 },  // Status
                { width: "13%", targets: 5 }   // Actions
            ],
            initComplete: function () {
                let api = this.api();

                function buildFilters() {
                    let filterColumns = [
                        { index: 3, label: "Offense" },       // Column 3: Offense
                        { index: 4, label: "Suspension Type" }, // Column 4: Suspension Type
                        { index: 5, label: "Status" }          // Column 5: Status
                    ];

                    let lengthContainer = $('#violationTable_length');
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
    .catch((error) => console.error('Error fetching violation details:', error));
}

// Call the function to load data on page load
document.addEventListener('DOMContentLoaded', fetchStudentIssues);


function viewSanction(issueId, button) {
    // Step 1: Get the violation number from the clicked button's data attribute
    const violationNumber = button.getAttribute('data-violation_number');
    document.getElementById('violation_number').value = violationNumber; // Set the violation number in the hidden field

    // Optionally, log the violation number for debugging
    console.log('Violation Number:', violationNumber);

    // Step 2: Fetch violation details using AJAX (this triggers the modal population)
    fetch(`get_violation_details.php?id=${issueId}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.violation) {
                // Populate the modal with the fetched violation data
                document.getElementById('violationNumberDisplay').textContent = data.violation.violation_number;
                document.getElementById('CategoryDisplay').textContent = data.violation.i_Category;
                document.getElementById('violationOffenseDisplay').textContent = data.violation.list_Offense;
                document.getElementById('violationSuspensionDisplay').textContent = data.violation.Suspension_Type;
                document.getElementById('violationStatusDisplay').textContent = data.violation.i_Status;
                document.getElementById('violationSanctionsDisplay').textContent = data.violation.i_Sanctions;
                document.getElementById('violationRecommendationDisplay').textContent = data.violation.i_Recommendation;
                document.getElementById('violationStudentIDDisplay').textContent = data.violation.st_ID;
                document.getElementById('violationUsernameDisplay').textContent = data.violation.a_username;

                // Step 3: Show the modal
                $('#appealModal').modal('show');
            } else {
                alert('Violation details not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching violation details:', error);
            alert('Error fetching violation details.');
        });
}


document.addEventListener('DOMContentLoaded', function () {
    // When the modal is about to be shown
    $('#Medium-modal').on('show.bs.modal', function (e) {
        fetchStudentProfile();
    });

    function fetchStudentProfile() {
        fetch('get_student_profile.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Populate modal fields
                    document.getElementById('studentName').textContent = `${data.s_Firstname} ${data.s_Middlename} ${data.s_Lastname}`;
                    document.getElementById('courseOfStudy').textContent = data.s_CourseOfStudy;
                    document.getElementById('dob').textContent = data.s_DOB;
                    document.getElementById('studentID').textContent = data.st_ID;
                    document.getElementById('yearLevel').textContent = data.year_level;
                    document.getElementById('schoolYear').textContent = data.school_year || '';
                    document.getElementById('gender').textContent = data.s_Gender;
                    document.getElementById('address').textContent = data.s_Address;
                    document.getElementById('phoneNumber').textContent = data.s_PhoneNumber;
                    document.getElementById('religion').textContent = data.religion;
                    document.getElementById('licenseStatus').textContent = data.if_licence;
                    document.getElementById('licenceRegistration').textContent = data.if_licence_registration;

                    // ✅ New Gmail field
                    document.getElementById('gmail').textContent = data.s_gmail;

                    // Set profile picture if available
                    if (data.s_PicturePath && data.s_PicturePath.trim() !== '') {
                        document.getElementById('profilePic').src = data.s_PicturePath;
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching profile:', error);
            });
    }
});


$(document).ready(function () {
    let originalContent = {};

    // Enable editing mode
    $("#editBtn").click(function () {
        originalContent = {
            dob: $("#dob").html(),
            gender: $("#gender").html(),
            address: $("#address").html(),
            phoneNumber: $("#phoneNumber").html(),
            religion: $("#religion").html(),
            licenseStatus: $("#licenseStatus").html(),
            licenceRegistration: $("#licenceRegistration").html(),
            gmail: $("#gmail").html(),
            profilePicInput: $("#editProfilePic").length ? $("#editProfilePic").prop("outerHTML") : ""
        };

        // Replace fields with inputs
        $("#dob").html('<input type="date" class="form-control" id="editDob" value="' + $("#dob").text().trim() + '">');

        let currentGender = $("#gender").text().trim();
        $("#gender").html(`
            <select class="form-control" id="editGender">
                <option value="Male" ${currentGender === "Male" ? "selected" : ""}>Male</option>
                <option value="Female" ${currentGender === "Female" ? "selected" : ""}>Female</option>
            </select>
        `);

        $("#address").html('<input type="text" class="form-control" id="editAddress" value="' + $("#address").text().trim() + '">');
        $("#phoneNumber").html('<input type="text" class="form-control" id="editPhone" value="' + $("#phoneNumber").text().trim() + '" placeholder="000-000-0000" pattern="\\d{3}-\\d{3}-\\d{4}">');
        $("#religion").html('<input type="text" class="form-control" id="editReligion" value="' + $("#religion").text().trim() + '">');
        $("#licenseStatus").html('<input type="text" class="form-control" id="editLicense" value="' + $("#licenseStatus").text().trim() + '">');
        $("#licenceRegistration").html('<input type="text" class="form-control" id="editLicenseReg" value="' + $("#licenceRegistration").text().trim() + '">');
        $("#gmail").html('<input type="email" class="form-control" id="editGmail" value="' + $("#gmail").text().trim() + '">');

        // Add profile picture upload
        if (!$("#editProfilePic").length) {
            $("#profilePic").after('<input type="file" class="form-control mt-2" id="editProfilePic" accept="image/*">');
        }

        // Toggle buttons
        $("#editBtn").addClass("d-none");
        $("#saveBtn, #changePassBtn").removeClass("d-none");
    });

    // Save updated profile
    $("#saveBtn").click(function () {
        let phoneVal = $("#editPhone").val().trim();
        let phonePattern = /^\d{3}-\d{3}-\d{4}$/;
        if (!phonePattern.test(phoneVal)) {
            alert("Phone number must be in the format 000-000-0000");
            return;
        }

        let formData = new FormData();
        formData.append("st_ID", $("#studentID").text().trim());
        formData.append("dob", $("#editDob").val());
        formData.append("gender", $("#editGender").val());
        formData.append("address", $("#editAddress").val());
        formData.append("phone", $("#editPhone").val());
        formData.append("religion", $("#editReligion").val());
        formData.append("license", $("#editLicense").val());
        formData.append("licenseReg", $("#editLicenseReg").val());
        formData.append("s_gmail", $("#editGmail").val());

        if ($("#editProfilePic")[0] && $("#editProfilePic")[0].files.length > 0) {
            formData.append("profilePic", $("#editProfilePic")[0].files[0]);
        }

        $.ajax({
            url: "update_profile.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                location.reload();
            },
            error: function () {
                alert("Failed to update profile.");
            }
        });
    });

    // Reset when modal closed
    $('#Medium-modal').on('hidden.bs.modal', function () {
        if (!$.isEmptyObject(originalContent)) {
            $("#dob").html(originalContent.dob);
            $("#gender").html(originalContent.gender);
            $("#address").html(originalContent.address);
            $("#phoneNumber").html(originalContent.phoneNumber);
            $("#religion").html(originalContent.religion);
            $("#licenseStatus").html(originalContent.licenseStatus);
            $("#licenceRegistration").html(originalContent.licenceRegistration);
            $("#gmail").html(originalContent.gmail);

            $("#editProfilePic").remove();

            $("#editBtn").removeClass("d-none");
            $("#saveBtn, #changePassBtn").addClass("d-none");
        }
    });
});    
// Open Change Password modal (and close edit modal)
$("#changePassBtn").click(function () {
    let stID = $("#studentID").text().trim();
    $("#password_st_ID").val(stID);

    $("#Medium-modal").modal("hide"); // close profile modal
    setTimeout(function () {
        $("#changePasswordModal").modal("show"); // open change password modal
    }, 400);
});


$(document).ready(function () {
  $("#submitPasswordBtn").click(function () {
    let st_ID = $("#password_st_ID").val().trim();
    let currentPassword = $("#currentPassword").val().trim();
    let newPassword = $("#newPassword").val().trim();
    let confirmPassword = $("#confirmPassword").val().trim();

    // Reset error messages
    $("#currentPasswordError").text("");
    $("#newPasswordError").text("");
    $("#confirmPasswordError").text("");

    // Validation
    if (newPassword.length < 6) {
      $("#newPasswordError").text("Password must be at least 6 characters.");
      return;
    }
    if (newPassword !== confirmPassword) {
      $("#confirmPasswordError").text("Passwords do not match.");
      return;
    }

    $.ajax({
      url: "update_password.php",
      type: "POST",
      data: {
        st_ID: st_ID,
        currentPassword: currentPassword,
        newPassword: newPassword
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          alert("Password updated successfully!");
          $("#changePasswordModal").modal("hide");
          $("#changePasswordForm")[0].reset();
        } else {
          if (response.field === "currentPassword") {
            $("#currentPasswordError").text(response.message);
          } else if (response.field === "newPassword") {
            $("#newPasswordError").text(response.message);
          } else {
            alert(response.message); // fallback
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        alert("An error occurred while updating password.");
      }
    });
  });
});


document.getElementById("appealForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("submit_appeal.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const responseDiv = document.getElementById("appealResponse");
        if (data.success) {
            responseDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            document.getElementById("appealForm").reset();
        } else {
            responseDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(err => {
        document.getElementById("appealResponse").innerHTML = `<div class="alert alert-danger">Error submitting appeal.</div>`;
    });
});