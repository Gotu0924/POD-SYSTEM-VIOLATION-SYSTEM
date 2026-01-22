document.addEventListener("DOMContentLoaded", function() {
    // Add event listeners for login form submission
    const adminForm = document.querySelector("#loginModalAdmin form");
    const staffForm = document.querySelector("#loginModalStaff form");
    const studentForm = document.querySelector("#loginModalStudent form");

    // Check if each form exists before attaching event listeners
    if (adminForm) {
        adminForm.addEventListener("submit", function(event) {
            event.preventDefault();
            const username = document.getElementById("adminUsername").value;
            const password = document.getElementById("adminPassword").value;
            validateLogin('admin', username, password);
        });
    }

    if (staffForm) {
        staffForm.addEventListener("submit", function(event) {
            event.preventDefault();
            const username = document.getElementById("staffUsername").value;
            const password = document.getElementById("staffPassword").value;
            validateLogin('staff', username, password);
        });
    }

    if (studentForm) {
        studentForm.addEventListener("submit", function(event) {
            event.preventDefault();
            const username = document.getElementById("studentUsername").value;
            const password = document.getElementById("studentPassword").value;
            validateLogin('student', username, password);
        });
    }
});

function validateLogin(role, username, password) {
    let endpoint;
    let credentials = {};

    // Set appropriate endpoint and credentials based on the role
    switch(role) {
        case 'admin':
            endpoint = 'admin.php';
            credentials = { username: username, password: password, role: 'admin' };
            break;
        case 'staff':
            endpoint = 'staff.php';
            credentials = { username: username, password: password, role: 'staff' };
            break;
        case 'student':
            endpoint = 'student.php';
            credentials = { username: username, password: password, role: 'student' };
            break;
        default:
            console.error('Invalid role');
            return;
    }

    // Make an API request to verify the credentials
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Successful login logic
            alert(`${role.charAt(0).toUpperCase() + role.slice(1)} login successful!`);

            // Redirect based on the role
            switch(role) {
                case 'admin':
                    window.location.href = 'index3.php'; // Redirect to index3.php for admin
                    break;
                case 'staff':
                    window.location.href = 'staff.php'; // Redirect to staff.php for staff
                    break;
                case 'student':
                    window.location.href = 'student.php'; // Redirect to student.php for student
                    break;
            }
        } else {
            // Invalid credentials
            alert('Invalid username or password. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again later.');
    });
}
