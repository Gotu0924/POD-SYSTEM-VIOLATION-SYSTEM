function addAdmin() {
    // Reset previous validation errors
    const fields = [
        'addFirstname', 'addLastname', 'addRole',
        'addPhoneNumber', 'addUsername', 'addgmailadmin',
        'a_addPassword', 'confirmPasswordadmin'
    ];

    fields.forEach(field => {
        const fieldElement = document.getElementById(field);
        const errorElement = document.getElementById(field + 'Error');

        if (fieldElement) fieldElement.classList.remove('is-invalid');
        if (errorElement) errorElement.classList.add('d-none');
    });

    let isValid = true;

    // Firstname validation
    if (!document.getElementById('addFirstname').value) {
        isValid = false;
        const el = document.getElementById('addFirstname');
        const err = document.getElementById('firstnameError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    // Lastname validation
    if (!document.getElementById('addLastname').value) {
        isValid = false;
        const el = document.getElementById('addLastname');
        const err = document.getElementById('lastnameError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    // Role validation
    if (!document.getElementById('addRole').value) {
        isValid = false;
        const el = document.getElementById('addRole');
        const err = document.getElementById('roleError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    // Phone validation
    if (!document.getElementById('addPhoneNumber').value) {
        isValid = false;
        const el = document.getElementById('addPhoneNumber');
        const err = document.getElementById('phoneError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    // Username validation
    if (!document.getElementById('addUsername').value) {
        isValid = false;
        const el = document.getElementById('addUsername');
        const err = document.getElementById('usernameError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    // Gmail validation - must end with @smcbi.edu.ph
    const gmailField = document.getElementById('addgmailadmin');
    const gmailError = document.getElementById('addGmailError');
    const gmailValue = gmailField ? gmailField.value.trim() : '';

    if (gmailValue === '') {
        isValid = false;
        gmailField.classList.add('is-invalid');
        gmailError.textContent = 'Gmail is required';
        gmailError.classList.remove('d-none');
    } else if (!/^[a-zA-Z0-9._%+-]+@smcbi\.edu\.ph$/.test(gmailValue)) {
        isValid = false;
        gmailField.classList.add('is-invalid');
        gmailError.textContent = 'Gmail must end with @smcbi.edu.ph';
        gmailError.classList.remove('d-none');
    } else {
        gmailField.classList.remove('is-invalid');
        gmailError.classList.add('d-none');
    }

    // Password validation
    if (!document.getElementById('a_addPassword').value) {
        isValid = false;
        const el = document.getElementById('a_addPassword');
        const err = document.getElementById('passwordError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    // Confirm password validation
    if (document.getElementById('a_addPassword').value !== document.getElementById('confirmPasswordadmin').value) {
        isValid = false;
        const el = document.getElementById('confirmPasswordadmin');
        const err = document.getElementById('confirmPasswordError');
        el.classList.add('is-invalid');
        err.classList.remove('d-none');
    }

    if (!isValid) return; // Stop if validation fails

    // Prepare new admin data
    const newAdmin = {
        firstname: document.getElementById('addFirstname').value,
        lastname: document.getElementById('addLastname').value,
        role: document.getElementById('addRole').value,
        phone: document.getElementById('addPhoneNumber').value,
        username: document.getElementById('addUsername').value,
        gmail: gmailValue,
        password: document.getElementById('a_addPassword').value
    };

    // Send request to backend
    fetch('add_admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(newAdmin),
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            $('#admin-add-success').modal('show');
            $('#addAddminModal').modal('hide');
        } else {
            // Handle username taken or other errors
            const usernameEl = document.getElementById('addUsername');
            const usernameErr = document.getElementById('usernameError');

            if (result.error && result.error.includes('Username')) {
                usernameEl.classList.add('is-invalid');
                usernameErr.textContent = 'Username already taken';
                usernameErr.classList.remove('d-none');
            } else {
                document.getElementById('error-message').textContent = result.error || 'Something went wrong while adding the admin.';
                $('#admin-add-error').modal('show');
            }
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        document.getElementById('error-message').textContent = 'Network error: ' + error.message;
        $('#admin-add-error').modal('show');
    });
}
