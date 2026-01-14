$(document).ready(function() {
    // Handle form submission
    $('#registration-form').on('submit', function(e) {
        e.preventDefault();

        // Get form data
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirm-password').val();
        var fullName = $('#full-name').val();
        var gender = $('input[name="gender"]:checked').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var termsAccepted = $('#terms-checkbox').is(':checked');

        // Basic validation
        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        if (!termsAccepted) {
            alert('You must accept the terms and conditions.');
            return;
        }

        // Show the overview information
        $('#email-info').text(email);
        $('#username-info').text(username);
        $('#fullname-info').text(fullName);

        // Send data to the backend using AJAX
        $.ajax({
            url: 'register.php',
            type: 'POST',
            data: {
                email: email,
                username: username,
                password: password,
                full_name: fullName,
                gender: gender,
                city: city,
                state: state,
                terms_accepted: termsAccepted
            },
            success: function(response) {
                if (response === 'success') {
                    alert('Registration successful!');
                    window.location.href = 'login.php'; // Redirect to login page after success
                } else {
                    alert('Error: ' + response);
                }
            }
        });
    });
});