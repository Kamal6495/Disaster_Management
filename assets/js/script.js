document.addEventListener("DOMContentLoaded", function () {
    showSection('home.php'); // Load home.php by default

    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent page reload
            const sectionFile = this.getAttribute("href"); // Get PHP file name
            showSection(sectionFile);
        });
    });
});

function showSection(sectionFile) {
    fetch(sectionFile)
        .then(response => response.text())
        .then(data => {
            document.getElementById("content").innerHTML = data;
        })
        .catch(error => {
            document.getElementById("content").innerHTML = "<p>Error loading content.</p>";
            console.error("Error fetching file:", error);
        });
}
