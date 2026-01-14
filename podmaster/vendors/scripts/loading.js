document.addEventListener("DOMContentLoaded", function () {
    let progress = 0;
    let percentText = document.getElementById("percent");

    function updateProgress() {
        if (progress < 100) {
            progress += 2; // Increase progress gradually
            percentText.innerText = progress + "%";
            setTimeout(updateProgress, 60); // Adjust speed
        } else {
            setTimeout(() => {
                document.querySelector(".pre-loader").style.display = "none"; // Hide loader when complete
            }, 500);
        }
    }

    updateProgress();
});