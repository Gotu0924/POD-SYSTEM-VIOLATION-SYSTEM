document.getElementById('addSanctionForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = {
        studentID: document.getElementById('studentID').value,
        offense: document.getElementById('offense').value,
        category: document.getElementById('category').value,
        details: document.getElementById('details').value,
        severity: document.getElementById('severity').value,
        recommendation: document.getElementById('recommendation').value,
        status: document.getElementById('status').value,
        sanctionType: document.getElementById('sanctionType').value,  // Assuming new input field for sanction type
        suspensionType: document.getElementById('suspensionType').value  // New Suspension Type input field
    };

    fetch('add_sanction.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message); // Alert the success message
            location.reload();    // Reload the page to reflect changes
        } else {
            alert("Failed to add sanction. Please try again.");
        }
    })
    .catch(error => {
        console.error("Error adding sanction:", error);
        alert("An error occurred while adding the sanction.");
    });
});
