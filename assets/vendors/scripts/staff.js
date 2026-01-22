// Function to handle the 'Send Sanction' action when the button is clicked
function SendSanction(st_ID) {
    // Set the student ID in the form field
    document.getElementById('st_ID').value = st_ID;
    
    // Show the modal to send sanction
    const sanctionModal = new bootstrap.Modal(document.getElementById('small-modal'));
    sanctionModal.show();
}

// Function to handle form submission via AJAX
document.getElementById('sanctionForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Collect form data using FormData object
    const formData = new FormData(this);

    // Send the data to the server using fetch API
    fetch('send_sanction.php', {
        method: 'POST',
        body: formData // The form data is sent as the request body
    })
    .then(response => response.json()) // Parse the JSON response
    .then(data => {
                        if (data.success) {
                    // If the sanction is successfully sent, show the success modal and close the original modal
                    $('#edit-success-modal').modal('show'); // Show the success modal
                    $('#small-modal').modal('hide'); // Hide the original modal
                    
                    // Optional: Reload the page after a delay (to allow user to see the success message)
                    setTimeout(function() {
                        location.reload(); // This will reload the current page
                    }, 4000); // 2-second delay for user to see the success message
                } else {
                    // If there was an error, show the error modal
                    $('#error-modal').modal('show'); // Show the error modal
                }

    })
    .catch(error => {
        // Handle any errors during the fetch request
        console.error('Error:', error);
        alert('There was an error sending the sanction.');
    });
});

// Function to populate offenses based on category selection
function populateOffenses() {
    const category = document.getElementById("i_Category").value;
    const offenseSelect = document.getElementById("list_Offense");
    offenseSelect.innerHTML = ""; // Clear any existing offenses

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

    offenses[category].forEach(offense => {
        let option = document.createElement("option");
        option.value = offense;
        option.textContent = offense;
        offenseSelect.appendChild(option);
    });
}

// Function to toggle the suspension type visibility
function toggleSuspensionType() {
    const sanctionType = document.getElementById('i_Sanctions').value;
    const suspensionGroup = document.getElementById('suspensionTypeGroup');
    const hiddenSuspensionField = document.getElementById('Suspension_Type_Hidden');

    if (sanctionType === 'Suspension') {
        suspensionGroup.style.display = 'block';
        hiddenSuspensionField.value = document.getElementById('Suspension_Type').value;
    } else {
        suspensionGroup.style.display = 'none';
        hiddenSuspensionField.value = 'N/A';
    }
}


// Function to fetch and display all students in a table
function fetchStudents() {
    fetch('fetch_students.php', {
        method: 'GET',
    })
    .then((response) => response.json())
    .then((data) => {
        const tableBody = document.getElementById('studentTableBody');
        tableBody.innerHTML = '';  // Clear current rows

        // Populate the table with student data
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
                <td>${student.s_Firstname} ${student.s_Middlename} ${student.s_Lastname}</td>
                <td>${student.st_ID}</td>
                <td>${student.s_CourseOfStudy}</td>
                <td>${student.year_level}</td>
                <td>
                    <div class="btn-group text-center">
                           
                            <button class="btn btn-danger" onclick="SendSanction('${student.st_ID}')"><i class="dw dw-add"></i> Send Violation</a></button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Reinitialize DataTable after updating rows
        if ($.fn.dataTable.isDataTable('#studentTable')) {
            $('#studentTable').DataTable().clear().destroy();
        }

        $('#studentTable').DataTable({
             searching: true,
            paging: true,
            autoWidth: false,
            scrollX: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [1, -1] }, // disable sorting for picture + action
                { targets: 0 },   // NO
                { targets: 1 },  // Picture
                { targets: 2 },  // Full Name
                { targets: 3 },  // Student ID
                { targets: 4 },  // Course
                { targets: 5 },  // Year Level
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

        // Remove the Transition button code entirely
        // let transitionBtn = $('<button class="btn btn-sm btn-warning me-3 mb-2 mb-md-0 pulse-animation">Transition</button>')
        //     .on('click', function () {
        //         $('#transitionDescModal').modal('show');
        //     });
        // filterContainer.append(transitionBtn);

        lengthContainer.append(filterContainer);
    }

    // Continue button handler can also be removed if it relates to Transition
    // $('#continueTransitionBtn').on('click', function() {
    //     $('#transitionDescModal').modal('hide');
    //     $('#updateYearModal').modal('show');
    // });

    // Build filters initially
    buildFilters();

    // Rebuild filters after redraw (when length changes, pagination, etc.)
    api.on('draw', buildFilters);
}

});
    })
    .catch((error) => console.error('Error fetching students:', error));
}

// Initial call to fetch all students  <button class="btn btn-success" onclick="viewStudent(${student.s_ID})"><i class="dw dw-eye"></i> View</a></button>
fetchStudents();
