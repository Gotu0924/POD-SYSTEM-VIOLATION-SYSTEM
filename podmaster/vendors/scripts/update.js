function updateSanction() {
    const form = document.getElementById("editSanctionForm");

    // Create a plain object to send as JSON
    const formData = {
        i_ID: document.getElementById("editSanctionID").value,
        s_ID: document.getElementById("editStudentID").value,
        i_Offense: document.getElementById("editOffense").value,
        i_Category: document.getElementById("editCategory").value,
        i_Details: document.getElementById("editDetails").value,
        sanctions: document.getElementById("editsanctions").value,
        i_Recommendation: document.getElementById("editRecommendation").value,
        i_Status: document.getElementById("editStatus").value,
    };

    // Log the data to verify
    console.log(formData);

    fetch('update_sanction.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Sanction updated successfully!');
            $('#editSanctionModal').modal('hide');
            fetchSanctionsData();
        } else {
            alert('Error: ' + data.message);
        }
    })
}
