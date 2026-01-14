function viewSanction(id) {
    fetch(`fetch_sanction_details.php?id=${id}`)
        .then(response => response.json())
        .then(sanction => {
            const viewModalContent = `
                <p><strong>Sanction ID:</strong> ${sanction.s_ID}</p>
                <p><strong>Offense:</strong> ${sanction.i_Offense}</p>
                <p><strong>Category:</strong> ${sanction.i_Category}</p>
                <p><strong>Details:</strong> ${sanction.i_Details}</p>
                <p><strong>Severity:</strong> ${sanction.i_Severity}</p>
                <p><strong>Recommendation:</strong> ${sanction.i_Recommendation}</p>
                <p><strong>Status:</strong> ${sanction.i_Status}</p>
            `;
            document.getElementById("viewSanctionDetails").innerHTML = viewModalContent;

            // Show the modal after content is loaded
            var viewModal = new bootstrap.Modal(document.getElementById('viewSanctionModal'));
            viewModal.show();
        })
        .catch(error => console.error("Error fetching sanction details:", error));
}
    