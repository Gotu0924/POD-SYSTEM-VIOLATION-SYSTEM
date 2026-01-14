
// =========================
// Edit Sanction Function
// =========================
function editSanction(id) {
    fetch(`fetch_sanction_details.php?id=${id}`)
        .then(response => response.json())
        .then(sanction => {
            document.getElementById("editSanctionID").value = sanction.i_ID;
            document.getElementById("editStudentID").value = sanction.s_ID;
            document.getElementById("editCategory").value = sanction.i_Category;
            document.getElementById("editOffense").value = sanction.list_Offense;
            document.getElementById("editSanctions").value = sanction.i_Sanctions;
            document.getElementById("editSanctionType").value = sanction.Sanction_Type;
            document.getElementById("editSuspensionType").value = sanction.Suspension_Type;
            document.getElementById("editDetails").value = sanction.i_Details;
            document.getElementById("editRecommendation").value = sanction.i_Recommendation;
            document.getElementById("editStatus").value = sanction.i_Status;
            var editModal = new bootstrap.Modal(document.getElementById('editSanctionModal'));
            editModal.show();
        })
        .catch(error => console.error("Error fetching sanction for editing:", error));
}

